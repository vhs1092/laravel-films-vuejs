<template>
<el-card class="box-card">
    <div slot="header" class="clearfix">
        <span>Show Film</span>
    </div>
    <div class="text item" v-if="dataLoaded">
        <div class="container col-lg-12 row">
            <div class="col-lg-6">
                <div class="showImage">
                    <img :src="filmForm.storage_path" style="width:100%;">
            </div>
                </div>
                <div class="col-lg-6">

                    <label for="name" class="el-form-item__label" style="width: 120px;"><b>Name:</b></label>
                    <div class="el-form-item__content" style="margin-left: 120px;">
                        <div class="el-form-item__label">
                            {{filmForm.name}}
                        </div>
                    </div>
                    <label for="description" class="el-form-item__label" style="width: 120px;"><b>Description:</b></label>
                    <div class="el-form-item__content" style="margin-left: 120px;">
                        <div class="el-form-item__label" style="text-align:justify;">
                            {{filmForm.description}}
                        </div>
                    </div>

                    <label for="date" class="el-form-item__label" style="width: 120px;"><b>Release date:</b></label>
                    <div class="el-form-item__content" style="margin-left: 120px;">
                        <div class="el-form-item__label">
                            {{filmForm.release_date}}
                        </div>
                    </div>

                    <label for="rate" class="el-form-item__label" style="width: 120px;"><b>Rate:</b></label>
                    <div class="el-form-item__content" style="margin-left: 120px;">
                        <div class="el-form-item__label">
                            <el-rate v-model="filmForm.rating" :disabled="true"></el-rate>
                        </div>
                    </div>

                    <label for="ticket_price" class="el-form-item__label" style="width: 120px;"><b>Ticket Price:</b></label>
                    <div class="el-form-item__content" style="margin-left: 120px;">
                        <div class="el-form-item__label">
                            $ {{filmForm.ticket_price}}
                        </div>
                    </div>
                    <label for="country" class="el-form-item__label" style="width: 120px;"><b>Country:</b></label>
                    <div class="el-form-item__content" style="margin-left: 120px;">
                        <div class="el-form-item__label">
                            {{filmForm.country}}
                        </div>
                    </div>

                    <label for="Genres" class="el-form-item__label" style="width: 120px;"><b>Genres:</b></label>
                    <div class="el-form-item__content" style="margin-left: 120px;">
                        <div class="el-form-item__label">
                            <b v-for="(item, key) in filmForm.genres" :key="key">{{item}}, </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <el-card class="box-card mt-2" v-for="(com, key) in comments" :key="key">
            <div slot="header" class="clearfix">
                <span>Comment by <b>{{com.name}}</b> on <b>{{com.created_at}}</b></span>
            </div>
            <div>
                <label for="name" class="el-form-item__label" style="width: 120px;"><b>Comment:</b></label>
                <div class="el-form-item__content" style="margin-left: 120px;">
                    <div class="el-form-item__label">
                        {{com.comment}}
                    </div>
                </div>

            </div>
        </el-card>

        <el-card class="box-card mt-2">
            <div slot="header" class="clearfix">
                <span>Leave a comment</span>
            </div>
            <div class="Comments">
                <el-form :model="commentForm" :rules="rules" ref="commentForm" label-width="120px" class="demo-commentForm">
                    <el-form-item label="Name" prop="name">
                        <el-input v-model="commentForm.name"></el-input>
                    </el-form-item>
                    <el-form-item label="Comment" prop="comment">
                        <el-input type="textarea" v-model="commentForm.comment"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="submitForm('commentForm')">Comment</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </el-card>

</el-card>
</template>

    

<script>
export default {
    data() {
        return {
            dataLoaded: false,
            countries: [],
            genres: [],
            comments: [],
            filmForm: {},
            commentForm: {
                name: '',
                comment: '',
                film_id: 0
            },
            rules: {
                name: [{
                    required: true,
                    message: 'Please input the name',
                    trigger: 'blur'
                }],
                comment: [{
                    required: true,
                    message: 'Please input the comment',
                    trigger: 'blur'
                }],
            }

        };
    },
    mounted() {
        this.fetchInfo();
    },
    methods: {
        fetchInfo() {
            //*get initial data, countries and genres
            let app = this;
            const loading = this.$loading({
                lock: true,
                text: 'Processing...',
                fullscreen: true,
                spinner: 'fas fa-spinner fa-pulse fa-3x',
                background: 'rgba(0, 0, 0, 0.8)'
            });
            let slug = this.$route.params.slug;
            axios.get('/films/' + slug)
                .then(function (response) {
                    app.filmForm = response.data.info;
                    app.comments = response.data.comments;
                    app.commentForm.film_id = app.filmForm.uuid;
                    app.dataLoaded = true;
                    loading.close();
                })
                .catch(function (response) {
                    app.$notify.error({
                        title: 'Error',
                        message: 'Something went wrong',
                    });
                });
        },
        submitForm(formName) {
            let app = this;
            //*validate and submit form
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    const loading = this.$loading({
                        lock: true,
                        text: 'Processing...',
                        fullscreen: true,
                        spinner: 'fas fa-spinner fa-pulse fa-3x',
                        background: 'rgba(0, 0, 0, 0.8)'
                    });
                    axios.post('/comments', app.commentForm)
                        .then(function (response) {
                            if (response.data.code == 200) {
                                app.$notify.success({
                                    title: 'Success',
                                    message: response.data.message,
                                });
                                //redirect to home
                                app.comments = response.data.comments;

                            } else {
                                app.$notify.error({
                                    title: 'Error',
                                    message: response.data.message,
                                });
                            }
                            loading.close();
                        })
                        .catch(function (response) {
                            app.$notify.error({
                                title: 'Error',
                                message: response.data.message,
                            });
                        });
                } else {
                    app.$notify.error({
                        title: 'Error',
                        message: 'Please review all the fields',
                    });
                    return false;
                }
            });
        }
    }
}
</script>
