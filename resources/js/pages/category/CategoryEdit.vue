<template>
  <layout-app>
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
        <parent-select
          :parentData="categories"
          :childParentId="category.parent_id"
          @select-parent="selectParent"
        />

        <test-select :parentData="categories" />

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </layout-app>
</template>

<script>
import ParentSelect from "../../components/select/ParentSelect.vue";

import axios from "axios";
import { Errors } from "form-backend-validation";
import TestSelect from "../../components/select/TestSelect.vue";
export default {
  data() {
    return {
      errors: new Errors(),
      form: {
        name: this.category.name,
        id: this.category.id,
        parent_id: this.category.id,
      },
    };
  },
  components: { ParentSelect, TestSelect },
  props: {
    categories: {
      type: Array,
    },
    category: {
      type: Object,
    },
  },
  computed: {
    parentId() {
      return this.category.id;
    },
  },
  methods: {
    submit() {
      axios
        .put(`/category/${this.category.id}`, this.form)
        .then((response) => {
          Turbolinks.visit("/category");
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
          this.form.name = this.category.name;
        });
    },
    selectParent(parentId) {
      this.category.parent_id = parentId;
    },
    testSelectParent(parentId) {
      console.log(parentId);
    },
  },
};
</script>

<style>
</style>
