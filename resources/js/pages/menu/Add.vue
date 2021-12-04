<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <div class="form-group">
          <label for="menuName">Menu name</label>
          <input
            type="text"
            class="form-control"
            id="menuName"
            placeholder="Enter menu name"
            v-model="form.name"
          />
          <div class="text-danger" v-if="errors.has('name')">
            {{ errors.first("name") }}
          </div>
        </div>
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
export default {
  components: { ParentSelection },
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
    };
  },
  props: {
    menus: {
      type: Array,
    },
  },
  methods: {
    submit() {
      axios
        .post("/menu", this.form)
        .then((response) => {
          Turbolinks.visit("/menu");
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
    selectParent(parentId) {
      this.form.parent_id = parentId;
    },
  },
};
</script>

<style>
</style>
