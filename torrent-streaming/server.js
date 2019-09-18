const dotenv = require('dotenv').config();
const express = require('express');
const cors = require('cors')
const router = require('./router.js');
const path = require('path');

const app = express();

app.use(cors());
app.use('/files', express.static(path.join(__dirname, '/files')));
app.use('/', router);

app.listen(3000, function () {
    console.log('App run on port 3000!');
});
