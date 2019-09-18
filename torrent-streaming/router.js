'use strict';

const express = require('express');
const StreamService = require('./services/StreamService');
const SubtitleService = require('./services/SubtitleService');

const router = express.Router();

router.get('/api/stream/:magnet', StreamService.streamingHandler);
router.get('/api/subtitles/:imdbid', SubtitleService.subsHandler);

router.get('*', function(req, res){
    return res.sendStatus(404);
});

module.exports = router;