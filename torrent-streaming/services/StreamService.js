const ts     = require('torrent-stream');
const md5    = require('md5');
const pump   = require('pump');
const ffmpeg = require('fluent-ffmpeg');

const isStreamable = (fileName) => {
    const mimes = [ '.*[.]{1}mp4', '.*[.]{1}avi', '.*[.]{1}mkv' ];
    console.log(fileName);
    return fileName.match(new RegExp('(' + mimes.join('|') + ')'))
};

const mustBeConverted = (fileName) => {
    const mimes = [ '.*[.]{1}avi', '.*[.]{1}mkv' ];

    return fileName.match(new RegExp('(' + mimes.join('|') + ')'))
};

const getRange = (range, file) => {
    const parts = (range) ? range.replace(/bytes=/, '').split('-') : null;
    const start = (parts) ? parseInt(parts[0], 10) : 0;
    const end = (parts && parts[1]) ? parseInt(parts[1], 10) : file.length - 1;

    return {start, end};
};

function checkTorrentStatus(engine) {
    let total = 0;

    console.log('Checking torrents...', engine.files);
    engine.files.forEach((file) => {
        total += parseInt(file.length);
        console.log('Total : ', total);
        console.log('Downloaded : ', engine.swarm.downloaded);
        if (total === engine.swarm.downloaded)
            console.log('Torrent fully downloaded')
    })
}

const processStandardStreaming = (req, res, engine, file, range) => {

    const stream = file.createReadStream(range);

    console.log('Streaming[Standard]: processing');

    res.on('close', () => {
        engine.remove(true, () => { console.log('Engine cleared') } );
        engine.destroy();
        console.log('Streaming[Standard]: closed')
    });

    res.statusCode = 206;
    res.setHeader('Accept-Ranges', 'bytes');
    res.setHeader('Cache-Control', 'no-cache, no-store');
    res.setHeader('Content-Range', `bytes ${range.start}-${range.end}/${file.length}`);
    res.setHeader('Content-Length', range.end - range.start + 1);
    res.setHeader('Content-Type', 'video/mp4');
    if (req.method === 'HEAD') {
        return res.end();
    }

    stream.pipe(res)
};

const initConversionStreaming = (req, res, engine, file, path, range) => {
    const stream = file.createReadStream();

    console.log('Streaming[Conversion]: initialized');
    console.log('Streaming[Conversion]: path: ', path + '/' + file.name);
    res.on('close', () => {
        console.log('Streaming[Conversion]: (response stream) closed')
    });

    res.statusCode = 206;
    res.setHeader('Content-Length', file.length);
    res.setHeader('Accept-Ranges', 'bytes');
    res.setHeader('Content-Range', `bytes 0-${range.end}/${file.length}`);
    res.setHeader('Cache-Control', 'no-cache, no-store');
    res.setHeader('Content-Type', 'video/webm');
    if (req.method === 'HEAD') {
        return res.end();
    }

    const conversion = ffmpeg(stream)
        .on('error', function (err) {
            console.log('Streaming[Conversion]ff: error:', err)
        })
        .audioBitrate(128)
        .audioCodec('libvorbis')
        .format('webm')
        .outputOptions([
            '-cpu-used 2',
            '-deadline realtime',
            '-error-resilient 1',
            '-threads 4'
        ])
        .videoBitrate(1024)
        .videoCodec('libvpx')
        .on('end', () => {
            console.log('Streaming[Conversion]: finished')
        });

    pump(conversion, res)
};

const getLargestFile = (files) => {
    return files.reduce(function (a, b) {
        return a.length > b.length ? a : b;
    });
};

const initStreaming = (req, res, magnet, options) => {
    const engine = ts(magnet, options);
    const {range} = req.headers;

    console.log('Initialization range: ', range);

    engine.once('ready', function () {
        const files = engine.files;

        let largestFile = getLargestFile(files);
        console.log(largestFile);
        if (isStreamable(largestFile.name)) {
            largestFile.select();
            if (mustBeConverted(largestFile.name))
                initConversionStreaming(req, res, engine, largestFile, options.path, getRange(range, largestFile));
            else {
                processStandardStreaming(req, res, engine, largestFile, getRange(range, largestFile));
            }
        }
    });

    engine.on('torrent', () => {
        checkTorrentStatus(engine);
    });
    engine.on('download', (index) => {
        console.log(`Engine downloading chunk: [${index}]`);
        console.log('Engine swarm downloaded : ', engine.swarm.downloaded);
    });
    engine.on('idle', () => {
        console.log('All selected files was successfully downloaded');
    });
    engine.on('error', function (e) {
        console.log('error ' + engine.infoHash + ': ' + e);
    });
};


const streamingHandler = async (req, res) => {
    const {magnet} = req.params;
    try {
        const decoded = decodeURI(magnet);
        console.log(decoded);
        const path = `./files/${md5(decoded)}`;
        const options = {
            connections: 100,
            uploads: 10,
            tmp: './files/cache',
            path: path,
            dht: true,
            verify: true,
            tracker: true
        };

        if (decoded && decoded.match(new RegExp(/^(magnet:\?xt=urn:btih:).*?$/))) {
            initStreaming(req, res, decoded, options);
        } else {
            return res.sendStatus(204);
        }
    } catch (err) {
        return res.sendStatus(203);
    }
};

module.exports = {streamingHandler};