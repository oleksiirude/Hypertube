# Hypertube [125/125]
This project at UNIT Factory (School 42) is about creating a web application that allows the user to research and watch films.

Project is done with 2 outstanding developers [@dashacherednichenko](https://github.com/dashacherednichenko) and [@hromadsky](https://github.com/hromadsky)

Main aim of this project is to create web app which has to be capable stream films online.
We've used torrent-stream library for video streaming, yts and TMDB APIs for collecting and updating data about films and MySQL for saving these data on our local server (MAMP in our case).

### Technologies used:
<pre>
1. Back-end: Laravel, MySQL, Redis, Node.js
2. Front-end: Vue.js, HTML/CSS, Bootstrap
</pre>

### To run project:
<pre>
1. Set your .env file (DB_USERNAME and DB_PASSWORD, MAIL)
2. Create database named "hypertube"
4. Run bash script at the root "sh start.sh" into one term window
5. Run bash script at ~Hypertube/torrent-streaming "sh start.sh" into second term window
6. Enjoy films!
</pre>

### Functionality:
<pre>
1. Complete auth functionality with password recovery
2. Capabilty to auth with 4 external resources (42 intra, github, google+, linkedin)
3. Film research (by title, by genre, year, etc)
4. Save films to wishlist, recommend films to others and see all watched films in profile page
5. Watch selected film online, change quality, subtitles, volume and speed
6. Three languages are available (english, ukrainian, russian)
</pre>

### Welcome page:
![alt text](https://github.com/oleksiirude/Hypertube/blob/master/storage/pics/main.jpg)

### Search:
![alt text](https://github.com/oleksiirude/Hypertube/blob/master/storage/pics/search.png)

### Search by title:
![alt text](https://github.com/oleksiirude/Hypertube/blob/master/storage/pics/research.png)

### Player:
![alt text](https://github.com/oleksiirude/Hypertube/blob/master/storage/pics/player.jpg)

Correction form you can find in storage/correction_form<br>
All project requirements you can find in Subject.pdf<br>
