<template>
<div>
    <div class="form-group float-right">
        <router-link :to="{name: 'create-genre'}" class="btn btn-primary">Create new genre</router-link>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(genre, key) in genres" :key="key">
                        <td>{{ genre.name }}</td>
                        <td v-if="genre.status == 1">
                            <el-button type="success" plain>Active</el-button>
                        </td>
                        <td v-else>
                            <el-button type="danger" plain>Inactive</el-button>
                        </td>
                        <td>
                            <router-link :to="{name: 'edit-genre', params: {uuid: genre.uuid}}" class="btn btn-xs btn-default">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data: function () {
        return {
            genres: []
        }
    },
    mounted() {
        this.fetchInfo();
    },
    methods: {
        fetchInfo() {
            var app = this;
            axios.get('/genre')
                .then(function (resp) {
                    app.genres = resp.data.genres;
                })
                .catch(function (resp) {
                    alert("Could not load genres");
                });
        }
    }
}
</script>
