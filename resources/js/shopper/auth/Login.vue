<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto" id="lvl3-container">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            <form @submit.prevent="submit">
              <div class="form-floating mb-3">
                <input
                  type="email"
                  class="form-control"
                  id="floatingInput"
                  placeholder="name@example.com"
                  required="required"
                  name="email"
                  v-model="form.email"
                />
                <label for="floatingInput">Email address</label>
                <div class="text-danger" v-if="errors.has('email')">
                  {{ errors.get("email") }}
                </div>
              </div>
              <div class="form-floating mb-3">
                <input
                  type="password"
                  class="form-control"
                  id="floatingPassword"
                  placeholder="Password"
                  required="required"
                  name="password"
                  v-model="form.password"
                />
                <label for="floatingPassword">Password</label>
              </div>

              <div class="form-check mb-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="rememberPasswordCheck"
                  name="remember_me"
                  v-model="form.remember_me"
                />
                <label class="form-check-label" for="rememberPasswordCheck">
                  Remember password
                </label>
              </div>

              <div class="d-grid">
                <a href="#" @click.prevent="submit" class="btn btn-primary">
                  Sign in
                </a>
              </div>
              <div class="d-grid">
                <a href="http://" class="btn btn-primary"> Sign Up </a>
              </div>
              <hr class="my-4" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { Errors } from "form-backend-validation";

export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
        remember_me: false,
      },
      errors: new Errors(),
    };
  },
  methods: {
    submit() {
      axios
        .post(`/login`, this.form)
        .then((response) => {
          Turbolinks.visit("/");
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
  },
};
</script>

<style scoped>
body {
  background: #007bff;
  background: linear-gradient(to right, #0062e6, #33aeff);
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
  width: 100%;
}

.btn-google {
  color: white !important;
  background-color: #ea4335;
}

.btn-facebook {
  color: white !important;
  background-color: #3b5998;
}
#lvl3-container {
  margin: auto;
}
a.btn {
  width: 100%;
}
</style>
