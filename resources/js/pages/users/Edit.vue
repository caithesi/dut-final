<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <text-form-input
          id="userName"
          :formdata="form.name"
          :errorName="errors.has('name')"
          :errorData="errors.first('name')"
          @change-input="changeInput($event, 'name')"
        />
        <text-form-input
          id="email"
          :formdata="form.email"
          :errorName="errors.has('email')"
          :errorData="errors.first('email')"
          @change-input="changeInput($event, 'email')"
        />
        <text-form-input
          id="password"
          :formdata="form.password"
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

import ParentSelection from "../../components/select/ParentSelection.vue";
import TextFormInput from "../../components/input/TextFormInput.vue";
import FileFormInput from "../../components/input/FileFormInput.vue";
export default {
  components: { ParentSelection, TextFormInput, FileFormInput, Multiselect },
  data() {
    return {
      headerContent: {
        name: "User",
        key: "Edit",
      },
      form: {
        name: this.user.name,
        email: this.user.email,
        password: this.user.password,
        user_roles: this.user.roles,
      },
      errors: new Errors(),
      storeRoute: laroute.route("user.store"),
      indexRoute: laroute.route("user.index"),
    };
  },
  props: {
    user: {
      type: Object,
    },
    roles: {
      type: Array,
    },
  },
  methods: {
    submit() {
      let editLink = laroute.route("user.update", {
        user: this.user.id,
      });
      this.form.user_roles = this.getRolesId;
      axios
        .put(editLink, this.form)
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
  mounted() {
    // console.log(this.user);
  },
  computed: {
    getRolesId() {
      return this.form.user_roles == null
        ? []
        : this.form.user_roles.map((v) => v.id);
    },
  },
};
</script>

<style scoped>
</style>
