<template>
<el-card class="box-card">
    <div slot="header" class="clearfix">
        <span>Create Genre</span>
    </div>
    <div class="text item">
        <div class="container col-lg-8">
            <el-form :model="genreForm" :rules="rules" ref="genreForm" label-width="120px" class="demo-genreForm">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="genreForm.name"></el-input>
                </el-form-item>
                <el-form-item prop="status">
                    <el-switch style="display: block" v-model="genreForm.status" active-color="#13ce66" inactive-color="#ff4949" active-text="Active" inactive-text="Inactive">
                    </el-switch>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="submitForm('genreForm')">Save</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</el-card>
</template>

<script>
export default {
    data() {
        return {
            dataLoaded: false,
            genreForm: {
                name: '',
                status: true
            },
            rules: {
                name: [{
                    required: true,
                    message: 'Please input the name',
                    trigger: 'blur'
                }]

            }
        };
    },
    mounted() {
        let id = this.$route.params.uuid;
        if (id !== undefined) {
            let app = this;
            axios.get('/genre/' + id)
                .then(function (resp) {
                    app.genreForm = resp.data.genre;
                })
                .catch(function (resp) {
                    app.$notify.error({
                        title: 'Error',
                        message: 'Something went wrong',
                    });
                });
        }
    },
    methods: {

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

                    let id = app.$route.params.uuid;
                    if (id !== undefined) {
                        //*update genre
                        axios.put('/genre/' + id, app.genreForm)
                            .then(function (response) {
                                if (response.data.code == 200) {
                                    app.$notify.success({
                                        title: 'Success',
                                        message: response.data.message,
                                    });
                                    //redirect to home
                                    app.$router.push({
                                        name: 'genres'
                                    });
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
                        //*create genre
                        axios.post('/genre', app.genreForm)
                            .then(function (response) {
                                if (response.data.code == 200) {
                                    app.$notify.success({
                                        title: 'Success',
                                        message: response.data.message,
                                    });
                                    //redirect to home
                                    app.$router.push({
                                        name: 'genres'
                                    });
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
                    }

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
