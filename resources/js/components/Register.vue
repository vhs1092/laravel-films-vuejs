<template>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div v-if="error" class="errorClass" role="alert">
                        <span class="errorClass" style="color:red;">{{ error.message }}</span>
                    </div>
                    <h5 class="card-title text-center">Register</h5>
                    <form class="form-signin" @submit.prevent="register" @keydown="form.errors.clear($event.target.name)">
                        <div class="form-label-group">
                            <label for="inputName">Name</label>
                            <input v-focus v-model="form.name" class="form-control" id="name" type="text" :class="{ 'border-red mb-3' : form.errors.has('name') }" name="name" placeholder="Name">
                            <p v-if="form.errors.has('name')" class="errorClass">{{ form.errors.get('name') }}</p>
                        </div>
                        <div class="form-label-group">
                            <label for="inputEmail">Email</label>
                            <input v-model="form.email" class="form-control" :class="{ 'border-red mb-3' : form.errors.has('email') }" id="username" type="email" name="email" placeholder="Email">
                            <p v-if="form.errors.has('email')" class="errorClass">{{ form.errors.get('email') }}</p>
                        </div>

                        <div class="form-label-group">
                            <label for="inputPassword">Password</label>
                            <input v-model="form.password" class="form-control" :class="{ 'border-red mb-3' : form.errors.has('password') }" id="password" type="password" name="password" placeholder="Password">
                            <p v-if="form.errors.has('password')" class="errorClass">{{ form.errors.get('password') }}</p>
                        </div>
                        <div class="form-label-group">
                            <label for="password_confirmation">Password confirmation</label>
                            <input v-model="form.password_confirmation" class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Password confirmation">
                        </div>

                            <div class="mt-4 text-sm">
                                Already have an account ?

                                <router-link class="inline-block font-bold text-indigo hover:text-indigo-darker" to="/login" exact>
                                    Log in now
                                </router-link>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" :disabled="this.isDisabled" :class="{ 'opacity-50 cursor-not-allowed': this.isDisabled }">
                  <i v-if="isLoading" class="fa fa-spinner fa-spin fa-fw"></i>
                  Register</button>
                            <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<style scoped>
.errorClass{
    color:red;
}
</style>

<script>
import Form from '../utils/Form'

export default {
    data() {
        return {
            form: new Form({
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }),
            isLoading: false,
            error: false
        }
    },

    computed: {
        isDisabled() {
            return this.form.incompleted() || this.isLoading
        }
    },

    methods: {
        register() {
            if (this.isDisabled) {
                return false
            }

            this.isLoading = true
            this.error = null

            this.form.post('auth/register')
                .then(data => this.$store.dispatch('login', data))
                .catch(error => {
                    this.isLoading = false
                    this.error = error

                    this.form.password = ''
                    this.form.password_confirmation = ''
                })
        }
    }
}
</script>
