<template>
<div class="page-wrapper full-page">
    <div class="page-content d-flex align-items-center justify-content-center">
        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-5 col-xl-4 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-center">
                            Document Tracking System - Registration Form
                        </h6>
                        <div class="form-outline mb-4">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" v-model="form.name" />

                            <span class="text-danger" v-if="errors && errors.name">
                                {{ errors.name }}</span>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control" v-model="form.email" />

                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example2">Password</label>
                            <input type="password" class="form-control" v-model="form.password" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example2">Confirm Password</label>
                            <input type="password" class="form-control" v-model="form.password_confirmation" />
                        </div>
                        <button type="button" class="btn btn-primary btn-block mb-4" @click="Register">
                            Sign up
                        </button>

                        <div class="text-center">
                            <p>
                                Already a member?
                                <router-link :to="{ name: 'Login' }">Login</router-link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    reactive,
    ref,
    onMounted
} from "vue";
import axios from "axios";

export default {
    setup() {
        const errors = ref({});
        const form = reactive({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        });

        const Register = async () => {
            try {
                await axios
                    .post("api/register", form)
                    .then((response) => {
                        Toast.fire({
                            icon: "success",
                            title: response.data,
                            customClass: {
                                title: "text-capitalize",
                            },
                        });
                    })
                    .catch((err) => {
                        console.log(err.value);
                    });
            } catch (error) {
                console.log(error);
            }
        };

        return {
            form,
            Register,
        };
    },
};
</script>
