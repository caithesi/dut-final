<template>
  <layout-app :headerPage="headerContent">
    <form @submit.prevent="submit" id="form">
      <div class="col-md-12">
        <text-form-input
          id="roleName"
          :formdata="form.role_name"
          :errorName="errors.has('role_name')"
          :errorData="errors.first('role_name')"
          @change-input="changeInput($event, 'role_name')"
        />
        <text-area-input
          id="description"
          :formdata="form.display_name"
          :errorName="errors.has('display_name')"
          :errorData="errors.first('display_name')"
          @change-input="changeInput($event, 'display_name')"
        />
      </div>

      <permisstion-check-box
        :permissions="permissions"
        :role_permission="getRolePermissionsIds"
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
import Multiselect from "vue-multiselect";

import ParentSelection from "../../components/select/ParentSelection.vue";
import TextFormInput from "../../components/input/TextFormInput.vue";
import FileFormInput from "../../components/input/FileFormInput.vue";
import PermisstionCheckBox from "./PermisstionCheckBox.vue";
import TextAreaInput from "../../components/input/TextAreaInput.vue";
export default {
  components: {
    ParentSelection,
    TextFormInput,
    FileFormInput,
    Multiselect,
    PermisstionCheckBox,
    TextAreaInput,
  },
  data() {
    return {
      headerContent: {
        name: "User",
        key: "Edit",
      },
      form: {
        role_name: this.role.name,
        display_name: this.role.display_name,
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
    role: {
      type: Object,
    },
  },
  methods: {
    submit() {
      let editLink = laroute.route("role.update", {
        role: this.role.id,
      });
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
  computed: {
    getRolePermissionsIds() {
      if (this.role.permissions == null) {
        console.log("??");
      }
      console.log(this.role.permissions.map((v) => v.id));
      return this.role.permissions == null
        ? []
        : this.role.permissions.map((v) => v.id);
    },
  },
  mounted() {
    this.form.permissions = this.getRolePermissionsIds;
  },
};
</script>

<style scoped>
#form {
  width: 100%;
}
</style>
