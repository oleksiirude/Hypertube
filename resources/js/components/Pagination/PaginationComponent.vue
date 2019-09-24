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
                                        <span class="badge badge-secondary m-1" v-for="genre in film.genres">
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
        </div>
        <button id="paginator" class="btn-primary ml-auto mr-auto mt-4" @click="showMore">
            <img src = "http://186.237.228.34:4010/portal_unimed/images/Load.gif" style="width:50px" v-if="show">
            {{ text }}
        </button>
    </div>
</template>

<script>
    export default {
        mounted () {
            document.getElementsByClassName('research')[0].addEventListener('click', this.changeType);
        },

        methods: {
            changeType: function(e) {
                e.preventDefault();

                this.page = 0;
                this.type = 'params';
                $('#movies_catalog').empty();
                this.params = this.getParams();
                this.showMore();
            },
            showMore: function () {
                let btn = document.getElementById('paginator');
                let self = this;
                btn.disabled = true;
                btn.hidden = false;
                this.show = true;
                this.text = '';

                if (this.type === 'top') {
                    this.ajax.open('GET', '/' + this.page, true);
                    this.ajax.setRequestHeader('XMLHttpRequest', 'true');
                    this.ajax.send();

                    this.ajax.onreadystatechange = () => {
                        if (this.ajax.readyState === 4) {
                            let response = JSON.parse(this.ajax.responseText);
                            if (response['result'] === true) {
                                this.films = this.films.concat(response['data']);
                                btn.disabled = false;
                                self.text = self.trans('titles.showMore');
                                this.show = false;
                            }
                            else if (response['result'] === false) {
                                btn.hidden = true;
                            }
                        }
                    };
                    this.page++;
                }
                else if (this.type === 'params') {
                    this.ajax.open('GET', '/search/params?' + this.params + '&page=' + this.page, true);
                    this.ajax.setRequestHeader('XMLHttpRequest', 'true');
                    this.ajax.send();

                    this.ajax.onreadystatechange = () => {
                        if (this.ajax.readyState === 4) {
                            let response = JSON.parse(this.ajax.responseText);
                            if (response['result'] === true) {
                                this.films = this.films.concat(response['data']);
                                if ((response['data'].length < 12))
                                    btn.hidden = true;
                                else {
                                    btn.disabled = false;
                                    self.text = self.trans('titles.showMore');
                                    this.show = false;
                                }
                            }
                            else if (response['result'] === false) {
                                if (this.page === 1) {
                                    self.text = 'Empty... Please, try another parameters';
                                }
                                else
                                    btn.hidden = true;
                            }
                        }
                    };
                    this.page++;
                }
            },
            getParams: function () {
                let input = document.getElementById('search_form').getElementsByTagName('input');
                let select = document.getElementById('search_form').getElementsByTagName('select');

                return jQuery.param({
                    genre: select.genre.value,
                    year_from: input.year_from.value,
                    year_to: input.year_to.value,
                    min_rating: select.min_rating.value,
                    sort: select.sort.value,
                    order: select.order.value,
                });
            },
        },

        props: [
            'base_url',
            'films_top'
        ],

        data: function () {
            return {
                films: JSON.parse(this.films_top),
                page: 1,
                type: 'top',
                ajax: new XMLHttpRequest(),
                params: null,
                text: this.trans('titles.showMore'),
                show: false,
            }
        }
    }
</script>

<style scoped>

</style>