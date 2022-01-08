<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <text-form-input
          id="userName"
          :errorName="errors.has('name')"
          :errorData="errors.first('name')"
          @change-input="changeInput($event, 'name')"
        />
        <text-form-input
          id="userEmail"
          :errorName="errors.has('email')"
          :errorData="errors.first('email')"
          @change-input="changeInput($event, 'email')"
        />
        <text-form-input
          id="password"
          :errorName="errors.has('password')"
          :errorData="errors.first('password')"
          @change-input="changeInput($event, 'password')"
        />

        <div class="form-group">
          <label>Select roles</label>
          <multiselect
            v-model="form.user_roles"
            :options="roles"
            track-by="id"
            label="name"
            placeholder="Search roles"
            :multiple="true"
          >
          </multiselect>
          <div class="text-danger" v-if="errors.has('user_roles')">
            {{ errors.first("user_roles") }}
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </layout-app>
</template>

<script>
import axios from "axios";
import { Errors } from "form-backend-validation";
import Multiselect from "vue-multiselect";

import TextFormInput from "../../components/input/TextFormInput.vue";
import TextAreaInput from "../../components/input/TextAreaInput.vue";
import ParentSelection from "../../components/select/ParentSelection.vue";
export default {
  components: { TextFormInput, TextAreaInput, ParentSelection, Multiselect },
  data() {
    return {
      headerContent: {
        name: "User",
        key: "Add",
      },
      form: {
        name: "",
        email: "",
        password: "",
        user_roles: [],
      },
      user_roles: [],
      errors: new Errors(),
      storeRoute: laroute.route("user.store"),
      indexRoute: laroute.route("user.index"),
    };
  },
  props: {
    roles: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  methods: {
    submit() {
      const formData = new FormData();
      _.each(this.form, (value, key) => {
        if (key == "user_roles") {
          return;
        }
        formData.append(key, value);
      });
      formData.append("user_roles", this.getRolesId);

        axios
          .post(this.storeRoute, formData)
          .then((response) => {
            Turbolinks.visit(this.indexRoute);
          })
          .catch((error) => {
            this.errors = new Errors(error.response.data.errors);
          });
    },
    changeInput($event, element) {
      this.form[element] = $event;
    },
  },
  computed: {
    getRolesId() {
      return this.form.user_roles == null
        ? []
        : this.form.user_roles.map((v) => v.id);
    },
    isInvalidClass() {
      return this.errorName ? "is-invalid form-control" : "form-control";
    },
    testDefault() {
      return this.roles.filter((value, index, array) => {
        return value.id == 1;
      });
    },
  },
//   mounted() {
//     this.form.user_roles = this.testDefault;
//     // console.log(this.form.user_roles);
//   },
};
</script>

<style>
</style>
