<template>
    <div class="" style="margin-top: 2%;">
        <div class="justify-content-center">
            <div class="">
                <div class="card" style="box-shadow: none">
                    <div class="card-header"><h2 class="title_topic" style="text-align: center">{{ trans('titles.downloadTorrent') }}</h2></div>
                        <table class="table table-dark">
                            <thead style="text-align: center">
                            <tr>
                                <th scope="col">{{ trans('titles.quality') }}</th>
                                <th scope="col">{{ trans('titles.seeds') }}</th>
                                <th scope="col">{{ trans('titles.size') }}</th>
                                <th scope="col">{{ trans('titles.download') }}</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            <tr v-for="torrent in torrentsParsed">
                                <td>{{ torrent.quality }}</td>
                                <td style="color: #228DFF">{{ torrent.seeds }}</td>
                                <td>{{ torrent.size }}</td>
                                <td><a :href="torrent.url">
                                    <img src="http://localhost:8080/images/service/download.png" style="width: 20px">
                                </a></td>
                            </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'torrents'
        ],

        data: function () {
            return {
                torrentsParsed: JSON.parse(this.torrents)
            }
        },
    }
</script>
<style>
    .table-dark {
        background-color: rgba(51,51,51,.4);
    }
    .card {
        background: transparent;
    }
</style>