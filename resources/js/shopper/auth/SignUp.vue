<template>
  <div>
    <form @submit.prevent="submit" style="border: 1px solid #ccc">
      <div class="container">
        <h1>Sign Up</h1>
        <p>Please fill in this form to create an account.</p>
        <hr />

        <label for="email"><b>Email</b></label>
        <input
          type="email"
          placeholder="Enter Email"
          name="email"
          required
          v-model="form.email"
        />
        <div class="text-danger" v-if="errors.has('email')">
          {{ errors.first("email") }}
        </div>
        <label for="name"><b>Name</b></label>
        <input
          type="text"
          placeholder="Enter Name"
          name="name"
          required
          v-model="form.name"
        />
        <div class="text-danger" v-if="errors.has('name')">
          {{ errors.first("name") }}
        </div>
        <label for="password"><b>Password</b></label>
        <input
          type="password"
          placeholder="Enter Password"
          name="password"
          required
          v-model="form.password"
          @input="checkConfirmPassword"
        />
        <div class="text-danger" v-if="errors.has('password')">
          {{ errors.first("password") }}
        </div>
        <label for="password-repeatt"><b>Repeat Password</b></label>
        <input
          type="password"
          placeholder="Repeat Password"
          name="password-repeat"
          id="password-repeat"
          required
          @input="checkConfirmPassword"
        />
        <div class="text-danger" v-if="confirmError != ''">
          {{ confirmError }}
        </div>

        <div class="clearfix">
          <a href="/login">
            <button type="button" class="loginbtn">Login</button></a
          >

          <button type="submit" class="signupbtn">Sign Up</button>
        </div>
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
      const confirm = document.getElementById("password-repeat").value;
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
  font-family: Arial, Helvetica, sans-serif;
}
* {
  box-sizing: border-box;
}

/* Full-width input fields */
input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
  background-color: #04aa6d;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity: 1;
}

/* Extra styles for the cancel button */
.loginbtn {
  padding: 14px 20px;
  background-color: blue;
}

/* Float cancel and signup buttons and add an equal width */
.loginbtn,
.signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
.loginbtn {
  color: white;
}
/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .loginbtn,
  .signupbtn {
    width: 100%;
  }
}
</style>
