<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <text-form-input
          id="menuName"
          :errorName="errors.has('name')"
          :errorData="errors.first('name')"
          @change-input="changeInput($event, 'name')"
        />
        <parent-selection
          :parentData="menus"
          labelSelect="Select menu parent"
          @select-parent="selectParent"
        ></parent-selection>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </layout-app>
</template>

<script>
import axios from "axios";
import { Errors } from "form-backend-validation";

import ParentSelection from "../../components/select/ParentSelection.vue";
import TextFormInput from "../../components/input/TextFormInput.vue";
export default {
  components: { ParentSelection, TextFormInput },
  data() {
    return {
      headerContent: {
        name: "Menu",
        key: "Add",
      },
      form: {
        name: null,
        parent_id: 0,
      },
      errors: new Errors(),
      routeName: "menu",
    };
  },
  props: {
    menus: {
      type: Array,
    },
  },
  methods: {
    submit() {
      //   console.log(this.form);
      axios
        .post(this.lararoutes("store"), this.form)
        .then((response) => {
          Turbolinks.visit(this.lararoutes("index"));
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
          console.log(this.errors.errors.name)
        });
    },
    selectParent(parentId) {
      this.form.parent_id = parentId;
    },
    lararoutes(name, parameter = {}) {
      return laroute.route(`${this.routeName}.${name}`, parameter);
    },
    changeInput($event, formEle) {
      this.form[formEle] = $event;
    },
  },
};
</script>

<style>
</style>
