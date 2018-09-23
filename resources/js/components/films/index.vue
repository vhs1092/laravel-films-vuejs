<template>
<div>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <div class="form-group float-left">
                <router-link :to="{name: 'create-film'}" class="btn btn-primary">Create new film</router-link>
            </div>
            <div class="form-group float-right">
                <router-link :to="{name: 'genres'}" class="btn btn-warning">Genres</router-link>
            </div>
        </div>
        <div class="text item" v-if="films.length > 0">
            <el-carousel :interval="4000" type="card" height="500px">
                <el-carousel-item v-for="(item,key) in films" :key="key">
                    <h3>Name: {{ item.name }}</h3>
                    <h3>Ticket Price: ${{ item.ticket_price }}</h3>
                    <div class="filmImage">
                        <router-link :to="{name: 'show-film', params:{slug: item.slug}}">
                            <img :src="item.storage_path" style="width:100%;">
                            </router-link>
                    </div>
                </el-carousel-item>
            </el-carousel>
        </div>
        <div v-else>
            <h3>No Films Created</h3>
        </div>
    </el-card>
</div>
</template>

<style scoped>
.el-carousel__item h3 {
    text-align: center;
    font-weight: bold;
}

.el-carousel__item {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
}

.el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
}

.filmImage a {
    width: 60%;
    margin: 0 auto;
    display: block;
}
</style>

<script>
export default {
    data: function () {
        return {
            films: []
        }
    },
    mounted() {
        this.fetchInfo();
    },
    methods: {
        fetchInfo() {
            var app = this;
            axios.get('/films')
                .then(function (resp) {
                    app.films = resp.data.films;
                })
                .catch(function (resp) {
                    alert("Could not load films");
                });
        }
    }
}
</script>
