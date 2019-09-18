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
    // console.log(magnet);
    try {
        //TODO base64 or encoded URI?

        // const decoded = decodeURI('magnet:?xt=urn:btih:79816060ea56d56f2a2148cd45705511079f9bca&dn=TPB.AFK.2013.720p.h264-SimonKlose&tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80&tr=udp%3A%2Fopen.demonii.com%3A1337')
        // const decoded = decodeURI('magnet:?xt=urn:btih:ce9156eb497762f8b7577b71c0647a4b0c3423e1&dn=Inception+(2010)+720p:+Mkv:+1.0GB:+YIFY&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969&tr=udp%3A%2F%2Ftracker.zer0day.to%3A1337&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337');
        // const decoded = decodeURI('magnet:?xt=urn:btih:B07C0C3782CB3737ED7ECE605375FC8C8150BC04');
        // const decoded = decodeURI('magnet:?xt=urn:btih:8B1F91F666FB59D27E30ED595682F1FA86A4FBAF&dn=The.Furies.2019.720p.WEBRip.800MB.x264-GalaxyRG+%E2%AD%90&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969%2Fannounce&tr=udp%3A%2F%2Fbt.xxx-tracker.com%3A2710%2Fannounce&tr=udp%3A%2F%2Ftracker.internetwarriors.net%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80%2Fannounce&tr=udp%3A%2F%2Fexplodie.org%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.tiny-vps.com%3A6969%2Fannounce&tr=udp%3A%2F%2Fopen.demonii.si%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.torrent.eu.org%3A451%2Fannounce&tr=udp%3A%2F%2Ftracker.pirateparty.gr%3A6969%2Fannounce&tr=udp%3A%2F%2Fipv4.tracker.harry.lu%3A80%2Fannounce&tr=udp%3A%2F%2Ftracker.cyberia.is%3A6969%2Fannounce&tr=udp%3A%2F%2F9.rarbg.to%3A2710%2Fannounce&tr=udp%3A%2F%2Ftracker.zer0day.to%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969%2Fannounce&tr=udp%3A%2F%2Fcoppersurfer.tk%3A6969%2Fannounce');
        // const decoded = decodeURI('magnet:?xt=urn:btih:16B087DFF9C8153072BD35C1BEC245CB831AEF4D&tr=udp://open.demonii.com:1337/announce&tr=udp://tracker.openbittorrent.com:80&tr=udp://tracker.coppersurfer.tk:6969&tr=udp://glotorrents.pw:6969/announce&tr=udp://tracker.opentrackr.org:1337/announce&tr=udp://torrent.gresille.org:80/announce&tr=udp://p4p.arenabg.com:1337&tr=udp://tracker.leechers-paradise.org:6969');
        // const decoded = decodeURI('magnet:?xt=urn:btih:03B6752B7626FA3E1801F55A2A8F0EB43C814DB1&dn=Greys+Anatomy+S14E20+HDTV+x264+%5BMP4%5D&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce&tr=udp%3A%2F%2Ftorrent.gresille.org%3A80%2Fannounce&tr=udp%3A%2F%2F9.rarbg.me%3A2710%2Fannounce&tr=udp%3A%2F%2Fp4p.arenabg.com%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.internetwarriors.net%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.zer0day.to%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969%2Fannounce&tr=udp%3A%2F%2Fcoppersurfer.tk%3A6969%2Fannounce');
        // const buf = new Buffer(magnet, 'base64');
        //const decoded = buf.toString()
        const decoded = decodeURI(magnet);
        console.log(decoded);
        // let decoded = 'magnet:?xt=urn:btih:C168B84FC2B8CF062B67E4168E35C98F10BC7C74';
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