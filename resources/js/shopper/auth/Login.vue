<template>
  <div id="lvl0-container">
    <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>

    <form @submit.prevent="submit">
      <div class="container">
        <label for="email-input"><b>Username</b></label>
        <input
          type="email"
          placeholder="Enter Email"
          name="email"
          id="email-input"
          required
          v-model="form.email"
        />
        <div class="text-danger" v-if="errors.has('email')">
          {{ errors.get("email") }}
        </div>

        <label for="password-input"><b>Password</b></label>
        <input
          type="password"
          placeholder="Enter Password"
          name="password"
          required
          id="password-input"
          v-model="form.password"
        />

        <button type="submit">Login</button>
        <label>
          <input
            type="checkbox"
            name="remember_me"
            v-model="form.remember_me"
            id="remember-me-check"
          />
          Remember me
        </label>
      </div>

      <div class="container" style="background-color: #f1f1f1">
        <button type="button" class="signup-btn" @click.prevent="visitSignUp">
          Sign Up
        </button>
        <span class="psw">Forgot <a href="#">password?</a></span>
      </div>
    </form>
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
    visitSignUp() {
      Turbolinks.visit("/signup");
    },
  },
};
</script>

<style scoped>
body {
  font-family: Arial, Helvetica, sans-serif;
}
form {
  border: 3px solid #f1f1f1;
}

input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04aa6d;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.signup-btn {
  width: auto;
  padding: 10px 18px;
  background-color: green;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }
  .cancelbtn {
    width: 100%;
  }
}
</style>
