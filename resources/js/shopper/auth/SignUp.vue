<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign Up</h5>
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
                  {{ errors.first("email") }}
                </div>
              </div>
              <div class="form-floating mb-3">
                <input
                  type="text"
                  class="form-control"
                  id="user-name"
                  placeholder="Your Name"
                  required="required"
                  name="name"
                  v-model="form.name"
                />
                <label for="floatingInput">Email address</label>
                <div class="text-danger" v-if="errors.has('email')">
                  {{ errors.first("email") }}
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
                  @input="checkConfirmPassword"
                />
                <label for="floatingPassword">Password</label>
                <div class="text-danger" v-if="errors.has('password')">
                  {{ errors.first("password") }}
                </div>
              </div>
              <div class="form-floating mb-3">
                <input
                  type="password"
                  class="form-control"
                  id="confirmPassword"
                  placeholder="Confirm Password"
                  required="required"
                  @input="checkConfirmPassword"
                />
                <label for="floatingPassword">Confirm Password</label>
                <div class="text-danger" v-if="confirmError != ''">
                  {{ confirmError }}
                </div>
              </div>

              <div class="d-grid">
                <button
                  class="btn btn-primary btn-login text-uppercase fw-bold"
                  type="submit"
                >
                  Sign Up
                </button>
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
        name: "",
      },
      errors: new Errors(),
      confirmError: "",
    };
  },
  methods: {
    submit() {
      if (this.confirmError != "") {
        return;
      }
      axios
        .post(`/signup`, this.form)
        .then((response) => {
          if (response.status == 200) {
            this.$swal({
              icon: "success",
              title: `${response.data.msg}`,
              text: "Sign Up Success",
              timer: 3000,
            }).then((result) => {
              Turbolinks.visit("/");
            });
          }
        })
        .catch((error) => {
          console.log(error);
          this.errors = new Errors(error.response.data.errors);
        });
    },
    checkConfirmPassword() {
      const confirm = document.getElementById("confirmPassword").value;
      if (confirm !== this.form.password) {
        this.confirmError = "Password confirm is wrong";
      } else {
        this.confirmError = "";
      }
    },
  },
  computed: {
    confirmErr() {
      return this.confirmError;
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
</style>
