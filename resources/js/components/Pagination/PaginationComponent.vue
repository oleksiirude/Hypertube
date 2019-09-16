<template>
    <div class="movies_list" id="movies_list">
        <div class="row" id="movies_catalog">
            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-12 col-xs-12 movie_main_div" v-for="film in films">
                    <a :href="base_url + film.imdb_id">
                        <div class="movie">
                            <span class="badge badge-info float-right movie_year">{{ film.prod_year }}</span>
                            <img class="movie_poster" :src="film.poster">
                            <div class="poster_slide">
                                <div class="poster_slide_cont">
                                    <div class="poster_slide_bg"></div>
                                    <div class="poster_slide_details">
                                        <h5 class="movie_title">
                                            {{ film.title }}
                                        </h5>

                                        <div class="details">
                                            <span class="badge badge-secondary" v-for="genre in film.genres">
                                                {{ trans('genres.' + genre) }}
                                            </span>
                                            <star-component :rating="film.rating" rating_nbr="true"></star-component>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
            </div>
            <button @click="downloadmore">download more</button>
        </div>
    </div>
</template>

<script>
    export default {
        mounted () {
            console.log('pagination mounted', this.films_top);

            let test = document.getElementsByClassName('research')[0].addEventListener('click', this.changeType);
            // console.log(test);

            // window.onscroll = () => {
            //     let scrollHeight, totalHeight;
            //     scrollHeight = document.body.scrollHeight;
            //     totalHeight = window.scrollY + window.innerHeight + 10;
            //
            //     if (totalHeight >= scrollHeight) {
            //         if (this.type === 'top') {
            //             const ajax = new XMLHttpRequest();
            //             ajax.open('GET', '/' + this.page, true);
            //             ajax.setRequestHeader('Content-Type', 'application/json');
            //             ajax.send();
            //
            //             ajax.onreadystatechange = () => {
            //                 if (ajax.status !== 200)
            //                     console.log('ajax response error with ' + ajax.status + ' status');
            //                 if (ajax.readyState === 4) {
            //                     let response = JSON.parse(ajax.responseText);
            //                     if (response['result'] === true) {
            //                         this.films = this.films.concat(response['data']);
            //                         console.log(this.page, response['data']);
            //                     }
            //                     else {
            //                         console.log('bad response');
            //                     }
            //                     // update = true;
            //                 }
            //             };
            //             this.page++;
            //         }
            //         else if (this.type === 'params') {
            //
            //         }
            //     }
            // }
        },
        props: [
            'base_url',
            'films_top'
        ],
        data: function () {
            return {
                films: JSON.parse(this.films_top),
                page: 1,
                type: 'top'
            }
        },



        methods: {
            changeType: function(e) {
                console.log(this.type);
                e.preventDefault();

                $('#movies_catalog').empty();
                this.type = 'params';
                console.log(this.type);
            },
            downloadmore: function () {
                if (this.type === 'top') {
                    const ajax = new XMLHttpRequest();
                    ajax.open('GET', '/' + this.page, true);
                    ajax.setRequestHeader('Content-Type', 'application/json');
                    ajax.send();

                    ajax.onreadystatechange = () => {
                        if (ajax.status !== 200)
                            console.log('ajax response error with ' + ajax.status + ' status');
                        if (ajax.readyState === 4) {
                            let response = JSON.parse(ajax.responseText);
                            if (response['result'] === true) {
                                this.films = this.films.concat(response['data']);
                                console.log(this.page, response['data']);
                            }
                            else {
                                console.log('bad response');
                            }
                            // update = true;
                        }
                    };
                    this.page++;
                }
                else if (this.type === 'params') {

                }
            }
        }
    }
</script>

<style scoped>

</style>