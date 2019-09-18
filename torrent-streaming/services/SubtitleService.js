const OS = require('opensubtitles-api');
const download = require('download');
const str2vtt = require('srt-to-vtt');
const fs = require('fs');
const _ = require('lodash');

const PATH = 'files/subtitles';

const OpenSubtitles = new OS({
    useragent: process.env.OSUBS_USERAGENT,
    username: process.env.OSUBS_LOGIN,
    password: process.env.OSUBS_PASS,
    ssl: false
});

const saveAsVtt = (sub, imdbid) => {
    return new Promise(async (resolve, reject) => {
        const path = `${PATH}/${imdbid}/${imdbid}.${sub.langcode}.vtt`;
        if (fs.existsSync(path)) {
            return resolve(path);
        }
        if (_.has(sub, 'vtt')) {
            await download(sub.vtt).then(
                data  => fs.writeFileSync(path, data),
                error => {
                    console.error(`VTT is unavailable. Status: ${error.statusMessage}`);
                }
            );
        }
        if (fs.existsSync(path)) {
            return resolve(path);
        }
        try {
            console.log(`Start downloading ${sub.format} format.`);
            await download(sub.url).pipe(str2vtt())
                                   .pipe(fs.createWriteStream(path));
            return resolve(path);
        } catch (e) {
            return reject(e);
        }
    })
};

const isPathExist = (imdbid) => {
    if (!fs.existsSync(PATH)) {
        fs.mkdirSync(PATH);
    }
    if (!fs.existsSync(`${PATH}/${imdbid}`)) {
        fs.mkdirSync(`${PATH}/${imdbid}`);
        return false;
    }
    return true;
};

const getSubtitles = async (imdbid) => {
    return new Promise(async (resolve, reject) => {
        let langs = process.env.SUB_LANGS.split(',');
        let subs = {};
        try {
            const res = await OpenSubtitles.search({imdbid});
            if (_.isEmpty(res)) {
                return resolve(subs);
            }
            isPathExist(imdbid);
            await Promise.allSettled(langs.map(
                async lang => {
                    if (!_.has(res, lang)){
                        return null;
                    }
                    await saveAsVtt(res[lang], imdbid).then(res => subs[lang] = res);
                }
                )).catch(e => console.log(e));
        } catch (e) {
            console.log(`Error: ${e}`);
            return resolve(subs);
        }
        return resolve(subs);
    });
};

const subsHandler = async (req, res) => {
  const {imdbid} = req.params;
  getSubtitles(imdbid).then(subs => res.status(200).json(subs));
};

module.exports = {subsHandler};