<template>
    <div class="container">
        <li class="badge badge-pill badge-success" v-on:click="like()">like {{counts['like']}}</li>
        <li class="badge badge-pill badge-danger" v-on:click="dislike()">dislike {{counts['dislike']}}</li>
    </div>
</template>

<style>
    li {
        cursor: pointer;
    }
</style>

<script>
    export default {
        props: ['id', 'user_id', 'post_id'],

        data: function () {
            return {
                counts: []
            }
        },

        mounted() {
            var app = this;

            console.log(this.id);

            axios.get('/photo/count/' + this.id)
                .then(function (resp) {
                    app.counts = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось загрузить компании");
                });
        },
        methods: {
            like() {
                var app = this;
                axios.get('/photo/like/' + this.id + '/' + this.user_id + '/' + this.post_id)
                    .then(function (resp) {
                        app.counts = resp.data;
                    })
                    .catch(function (resp) {
                        alert("system error");
                    });
            },

            dislike() {
                var app = this;
                axios.get('/photo/dislike/' + this.id + '/' + this.user_id + '/' + this.post_id)
                    .then(function (resp) {
                        app.counts = resp.data;
                    })
                    .catch(function (resp) {
                        alert("system error");
                    });
            }
        }
    }
</script>
