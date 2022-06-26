<template>
  <div class="page-wrapper full-page">
    <div class="page-content d-flex align-items-center justify-content-center">
      <div class="row w-100 mx-0 auth-page">
        <div class="col-md-5 col-xl-4 mx-auto">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title text-center">
                Document Tracking System - LogIn Form
              </h6>
              <form>
                <div class="form-outline mb-4">
                  <label class="form-label">Email address</label>
                  <input
                    type="email"
                    class="form-control"
                    v-model="form.email"
                  />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="form2Example2">Password</label>
                  <input
                    type="password"
                    class="form-control"
                    v-model="form.password"
                  />
                </div>

                <button
                  type="button"
                  class="btn btn-primary btn-block mb-4"
                  @click="Login"
                >
                  Sign in
                </button>

                <div class="text-center">
                  <p>
                    Not a member?
                    <router-link :to="{ name: 'Register' }"
                      >Register</router-link
                    >
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { reactive, ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
export default {
  setup() {
    const router = useRouter();
    const form = reactive({
      email: "",
      password: "",
      device_name: "browser",
    });

    const Login = async () => {
      try {
        axios.get("/sanctum/csrf-cookie").then((response) => {
          axios
            .post("api/login", form)
            .then((response) => {
              console.log(response.data);
              localStorage.setItem("token", response.data);
               router.go({ name: "Dashboard" });
            })
            .catch((err) => {
              errors.value = err.response.data.errors;
              console.log(errors.value);
            });
        });
      } catch (error) {
        console.log(error);
      }
    };

    return {
      form,
      Login,
    };
  },
};
</script>
