<template>
        <div class="">
            <div class="comment-wrapper">
                <div class="panel panel-info">
                    <div class="panel-heading title_topic">
                        {{ trans('titles.comments') }}
                    </div>
                    <div class="panel-body comments-block">
                                <textarea v-on:keyup="checkEnter" class="form-control" :placeholder="trans('titles.commentsPlaceholder')" rows="3"></textarea>
                            <br>
                            <button type="button" class="btn btn-secondary pull-right button-post mr-2" @click="postComment()">{{ trans('titles.commentsAction') }}</button>
                        <div class="clearfix"></div>
                        <hr>

                        <ul v-if="parsedComments.length" class="media-list">
                            <li v-for="comment in parsedComments" class="media">
                                <a :href="prefix_profile + comment.login" class="pull-left comment_img">
                                    <img :src="comment.avatar" alt="" class="rounded-circle m-2">
                                    <strong class="login_a">{{ comment.login }}</strong>
                                </a>
                                <div class="media-body">
                                    <span class="text-muted pull-right mr-2">
                                        <small class="text-muted">{{ comment.date }}</small>
                                    </span>
<!--                                    <a :href="prefix_profile + comment.login" class="pull-left login_a">-->
<!--                                        <strong>{{ comment.login }}</strong>-->
<!--                                    </a>-->
                                    <p style="margin: 20px">
                                        {{ comment.comment }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <ul v-else class="media-list">
                            <li class="media">
                                <div class="media-body">
                                    <p style="margin: 20px; color: gray">
                                        {{ trans('titles.noComments') }}
                                    </p>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: [
            'action',
            'comments',
            'prefix_avatar',
            'prefix_profile',
            'auth_login',
            'auth_avatar'
        ],

        data: function() {
            return {
                parsedComments: JSON.parse(this.comments),
                mutableAuthLogin: this.auth_login,
                mutablePrefixProfile: this.prefix_profile,
                mutableAuthAvatar: this.auth_avatar
            }
        },

        methods: {
            postComment: function () {
                let self = this;
                let textarea = this.$el.querySelector('textarea').value.trim().replace(/\s\s+/g, ' ');
                this.$el.querySelector('textarea').value = '';

                if (!textarea.length || textarea.length >= 500)
                    return;

                axios.post(this.action, {
                    imdb_id: document.documentURI.split('/')[4],
                    comment: textarea
                }).then(function (response) {
                    if (response.data.result === true)
                       self.addComment(self, textarea);
                    }).catch((error) => {
                            // console.log(error)
                        }
                    );
            },

            addComment: function (self, textarea) {
                self.parsedComments.unshift({
                    avatar: self.auth_avatar,
                    comment: textarea,
                    date: self.trans('titles.commentsNew'),
                    login: self.auth_login
                });
            },
            
            checkEnter: function (event) {
                if (event.key === 'Enter')
                    this.postComment();
            }
        },
    }
</script>

<style scoped>
    .comment-wrapper .panel-body {
        max-height: 650px;
        overflow: auto;
    }

    .comment-wrapper .media-list .media img {
        width: 64px;
        height: 64px;
    }

    .comment-wrapper .media-list .media {
        border-bottom: 1px dashed grey;
        margin-bottom: 25px;
    }

    .comments-block {
        background-color: rgba(51,51,51,.4);
        word-break: break-word;
    }

    .button-post {
        background-color: transparent;
    }

    .button-post:hover {
        text-decoration: none;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .pull-left {
        color: grey;
    }
    .login_a {
        vertical-align: top;
    }
    .login_a:hover {
        color: white;
        text-decoration: none;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .comment_img:hover {
        color: white;
        text-decoration: none;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
</style>