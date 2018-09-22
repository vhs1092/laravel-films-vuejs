<template>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Sign In</h5>
                    <form class="form-signin" @submit.prevent="login" @keydown="form.errors.clear($event.target.name)">
                        <div class="form-label-group">
                            <input v-focus v-model="form.email" class="form-control" :class="{ 'border-red mb-3' : form.errors.has('email') }" id="email" type="email" name="email" placeholder="Email">
                            <p v-if="form.errors.has('email')" class="text-red text-xs italic">{{ form.errors.get('email') }}</p>
                            <label for="inputEmail">Email address</label>
                        </div>

                        <div class="form-label-group">
                            <input v-model="form.password" class="form-control" :class="{ 'border-red mb-3' : form.errors.has('password') }" id="password" type="password" name="password" placeholder="Password">
                            <p v-if="form.errors.has('password')" class="text-red text-xs italic">{{ form.errors.get('password') }}</p>

                            <label for="inputPassword">Password</label>
                        </div>

                        <div class="mt-4 text-sm">
                            Don't have an account?
                            <router-link class="inline-block font-bold text-indigo hover:text-indigo-darker" to="/register" exact>
                                Register now
                            </router-link>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" :disabled="this.isDisabled" :class="{ 'opacity-50 cursor-not-allowed': this.isDisabled }">
                  <i v-if="isLoading" class="fa fa-spinner fa-spin fa-fw"></i>
                  Log in</button>
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Form from '../utils/Form'

export default {
    data() {
        return {
            form: new Form({
                email: '',
                password: ''
            }),
            isLoading: false
        }
    },
    computed: {
        isDisabled() {
            return this.form.incompleted() || this.isLoading
        }
    },
    methods: {
        login() {
            if (this.isDisabled) {
                return false
            }
            this.isLoading = true
            this.form.post('auth/login')
                .then(data => this.$store.dispatch('login', data))
                .catch(() => {
                    this.isLoading = false
                    this.form.password = ''
                })
        }
    }
}
</script>
