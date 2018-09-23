<template>
    <div>
        <div class="form-group pull-right">
            <router-link :to="{name: 'createfilm'}" class="btn btn-primary">Create new film</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">films list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(film, key) in films" :key="key" >
                        <td>{{ film.name }}</td>
                        <td>{{ film.description }}</td>
                        <td>
                            <router-link :to="{name: 'editfilm', params: {id: film.id}}" class="btn btn-xs btn-default">
                                Show
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
                films: []
            }
        },
        mounted() {
            this.fetchInfo();
        },
        methods: {
            fetchInfo(){
                var app = this;
                axios.get('/films')
                .then(function (resp) {
                    app.films = resp.data;
                })
                .catch(function (resp) {
                    alert("Could not load films");
                });
            }
        }
    }
</script>
