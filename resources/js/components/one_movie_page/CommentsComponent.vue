<template>
        <div class="col-md-6 col-md-offset-2 col-sm-12 m-auto">
            <div class="comment-wrapper">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Comments
                    </div>
                    <div class="panel-body comments-block">
                                <textarea class="form-control" placeholder="What do you think about this movie? (up to 500 symbols)" rows="3"></textarea>
                            <br>
                            <button type="button" class="btn btn-secondary pull-right button-post mr-2" @click="postComment()">Post</button>
                        <div class="clearfix"></div>
                        <hr>

                        <ul id="box" class="media-list">
                            <li v-for="comment in parsed_comments" class="media">
                                <a :href="prefix_profile + comment.login" class="pull-left">
                                    <img :src="prefix_avatar + comment.avatar" alt="" class="rounded-circle m-2">
                                </a>
                                <div class="media-body">
                                <span class="text-muted pull-right mr-2">
                                    <small class="text-muted">{{ comment.date }}</small>
                                </span>
                                    <strong class="text-info pull-left">{{ comment.login }}</strong>
                                    <p style="margin: 20px">
                                        {{ comment.comment }}
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
                parsed_comments: JSON.parse(this.comments),
                mutableAuthLogin: this.auth_login,
                mutablePrefixProfile: this.prefix_profile,
                mutableAuthAvatar: this.auth_avatar
            }
        },

        mounted () {
            // console.log('comments component mounted');
        },

        methods: {
            postComment: function () {
                let self = this;
                let textarea = document.getElementsByTagName('textarea')[0];

                if (!textarea.value || textarea.value.length >= 500)
                    return;

                axios.post(this.action, {
                    imdb_id: document.documentURI.split('/')[4],
                    comment: textarea.value
                }).then(function (response) {
                    if (response.data.result === true)
                       self.addComment(self, textarea);
                    }).catch((error) =>
                        console.log(error)
                    );
            },

            addComment: function (self, textarea) {
                let p = document.createElement('p');
                p.style.margin = '20px';
                p.innerHTML = self.escapeHTML(textarea.value.trim().replace(/\s\s+/g, ' '));
                textarea.value = '';

                let strong = document.createElement('strong');
                strong.className = 'text-info pull-left';
                strong.innerHTML = self.mutableAuthLogin;

                let span = document.createElement('span');
                span.className = 'text-muted pull-right mr-2';

                let small = document.createElement('small');
                small.className = 'text-muted';
                small.innerHTML = 'just now';

                span.appendChild(small);

                let div = document.createElement('div');
                div.className = 'media-body';

                div.append(span, strong, p);

                let a = document.createElement('a');
                a.className = 'pull-left';
                a.href = self.mutablePrefixProfile + self.mutableAuthLogin;

                let img = document.createElement('img');
                img.className = 'rounded-circle m-2';
                img.src = self.mutableAuthAvatar;
                img.width = 64;
                img.style.border = '2px solid #e5e7e8';

                a.appendChild(img);

                let li = document.createElement('li');
                li.className = 'media';
                li.style.borderBottom = '1px dashed #efefef';
                li.style.marginBottom = '25px';

                li.append(a, div);

                $('#box').prepend(li);
            },

            escapeHTML: function (comment) {
                return comment.replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            },
        },
    }
</script>

<style scoped>
    body{margin-top:20px;}

    .comment-wrapper .panel-body {
        max-height:650px;
        overflow:auto;
    }

    .comment-wrapper .media-list .media img {
        width:64px;
        height:64px;
        border:2px solid #e5e7e8;
    }

    .comment-wrapper .media-list .media {
        border-bottom:1px dashed #efefef;
        margin-bottom:25px;
    }

    .comments-block {
        background-color: #2f2f2f;
        word-break: break-word;
    }

    .button-post {
        background-color: #828282;
        border: #000;
    }
</style>