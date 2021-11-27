<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <div class="form-group">
          <label for="categoryName">Category name</label>
          <input
            type="text"
            class="form-control"
            id="categoryName"
            placeholder="Enter category name"
            v-model="form.name"
          />
          <div class="text-danger" v-if="errors.has('name')">
            {{ errors.first("name") }}
          </div>
        </div>
        <parent-select :parentData="categories" @select-parent="selectParent" />
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </layout-app>
</template>

<script>
import axios from "axios";
import { Errors } from "form-backend-validation";

import ParentSelect from "../../components/select/ParentSelect.vue";
export default {
  components: { ParentSelect },
  data() {
    return {
      headerContent: {
        name: "Category",
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
    categories: {
      type: Array,
    },
  },
  methods: {
    submit() {
      axios
        .post("/category", this.form)
        .then((response) => {
          Turbolinks.visit("/category");
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
