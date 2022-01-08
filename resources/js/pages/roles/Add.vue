<template>
  <layout-app :headerPage="headerContent">
    <form @submit.prevent="submit" id="form">
      <div class="col-md-12">
        <text-form-input
          id="roleName"
          :errorName="errors.has('role_name')"
          :errorData="errors.first('role_name')"
          @change-input="changeInput($event, 'role_name')"
        />
        <text-area-input
          id="description"
          :errorName="errors.has('display_name')"
          :errorData="errors.first('display_name')"
          @change-input="changeInput($event, 'display_name')"
        />
      </div>
      <permisstion-check-box
        :permissions="permissions"
        @check-permisstion="checkPermission"
        @check-all-permisstion="checkAllPermission"
        @remove-all-permisstion="removePermission"
      />
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </layout-app>
</template>

<script>
import axios from "axios";
import { Errors } from "form-backend-validation";

import TextFormInput from "../../components/input/TextFormInput.vue";
import TextAreaInput from "../../components/input/TextAreaInput.vue";
import PermisstionCheckBox from "./PermisstionCheckBox.vue";
export default {
  components: { TextFormInput, TextAreaInput, PermisstionCheckBox },
  data() {
    return {
      headerContent: {
        name: "Role",
        key: "Add",
      },
      PermisstionCheckBoxderContent: {
        name: "Role",
        key: "Add",
      },
      form: {
        role_name: "",
        display_name: "",
        permissions: [],
      },
      errors: new Errors(),
      indexRoute: laroute.route("role.index"),
      storeRoute: laroute.route("role.store"),
    };
  },
  props: {
    permissions: {
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
        formData.append(key, value);
      });
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
    checkPermission(permission_id) {
      this.togglePermisstion(this.form.permissions, permission_id);
    },
    checkAllPermission(permission_id) {
      this.addOrRemove(this.form.permissions, permission_id);
    },
    removePermission(permission_id) {
      this.addOrRemove(this.form.permissions, permission_id, "remove");
    },
    togglePermisstion(array, value) {
      let index = array.indexOf(value);
      if (index === -1) {
        array.push(value);
      } else {
        array.splice(index, 1);
      }
    },
    addOrRemove(array, value, action = "add") {
      let index = array.indexOf(value);
      if (action == "add") {
        if (index !== -1) {
          return;
        }
        array.push(value);
        return;
      }
      if (index !== -1) {
        array.splice(index, 1);
        return;
      }
    },
  },
  mounted() {
    // console.log(this.permissions);
  },
};
</script>

<style scoped>
#form {
  width: 100%;
}
</style>
