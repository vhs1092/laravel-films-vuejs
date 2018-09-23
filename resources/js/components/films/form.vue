<template>
<el-card class="box-card">
    <div slot="header" class="clearfix">
        <span>Create Film</span>
    </div>
    <div class="text item">
        <div class="container col-lg-8" v-if="dataLoaded">
            <el-form :model="filmForm" :rules="rules" ref="filmForm" label-width="120px" class="demo-filmForm">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="filmForm.name"></el-input>
                </el-form-item>
                <el-form-item label="Description" prop="description">
                    <el-input type="textarea" v-model="filmForm.description"></el-input>
                </el-form-item>

                <el-form-item label="Release date" prop="release_date">
                    <el-date-picker type="date" placeholder="Pick a date" v-model="filmForm.release_date" style="width: 100%;"></el-date-picker>
                </el-form-item>

                <el-form-item label="Rating" prop="rating">
                    <el-rate v-model="filmForm.rating"></el-rate>
                </el-form-item>

                <el-form-item label="Ticket Price" prop="ticket_price">
                    <money v-model="filmForm.ticket_price" class="el-input__inner" v-bind="money"></money>
                </el-form-item>

                <el-form-item label="Country" prop="country">
                    <el-select v-model="filmForm.country" filterable placeholder="Select country">
                        <el-option v-for="(item, key) in countries" :key="item.value" :label="item" :value="key">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Genres" prop="genres">
                    <el-select v-model="filmForm.genres" multiple placeholder="Select genre">
                        <el-option v-for="item in genres" :key="item.value" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item prop="photo">
                    <label>Photo</label>
                    <input class="form-control" type="file" accept="image/*" v-on:change="photoUploaded">
            </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="submitForm('filmForm')">Create</el-button>
                        <el-button @click="resetForm('filmForm')">Reset</el-button>
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
            countries: [],
            genres: [],
            money: {
                decimal: '.',
                thousands: ',',
                prefix: '$ ',
                suffix: '',
                precision: 2,
                masked: false
            },
            filmForm: {
                name: '',
                description: '',
                country: '',
                release_date: '',
                rating: 0,
                ticket_price: 0,
                genres: [],
                photo: ''
            },
            rules: {
                name: [{
                    required: true,
                    message: 'Please input the name',
                    trigger: 'blur'
                }],
                description: [{
                    required: true,
                    message: 'Please input the description',
                    trigger: 'blur'
                }],
                country: [{
                    required: true,
                    message: 'Please select the country',
                    trigger: 'change'
                }],
                rating: [{
                    type: 'number',
                    required: true,
                    message: 'Please select the rating',
                    trigger: 'change'
                }],
                release_date: [{
                    type: 'date',
                    required: true,
                    message: 'Please pick a date',
                    trigger: 'change'
                }],
                ticket_price: [{
                    type: 'number',
                    required: true,
                    message: 'Please input the ticket price',
                    trigger: 'blur'
                }],
                genres: [{
                    type: 'array',
                    required: true,
                    message: 'Please select at least one activity type',
                    trigger: 'change'
                }],
                photo: [{
                    required: true,
                    message: 'Please upload the photo',
                    trigger: 'blur'
                }]
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
            axios.get('/films/get_data')
                .then(function (response) {
                    app.countries = response.data.countries;
                    app.genres = response.data.genres;
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
        photoUploaded: function (e) {
            //*on change photo set value
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            let file = files[0];
            let reader = new FileReader();
            let vm = this;
            reader.onload = e => {
                vm.filmForm.photo = e.target.result;
            };
            reader.readAsDataURL(file);

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
                    axios.post('/films', app.filmForm)
                        .then(function (response) {
                            if (response.data.code == 200) {
                                app.$notify.success({
                                    title: 'Success',
                                    message: response.data.message,
                                });
                                //redirect to home
                                app.$router.push({
                                    name: 'films'
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
                    app.$notify.error({
                        title: 'Error',
                        message: 'Please review all the fields',
                    });
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        }
    }
}
</script>
