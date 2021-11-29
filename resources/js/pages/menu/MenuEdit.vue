<template>
  <layout-app>
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
          :childParentId="parentId"
        ></parent-selection>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </layout-app>
</template>

<script>
import ParentSelect from "../../components/select/ParentSelect.vue";
import ParentSelection from "../../components/select/ParentSelection.vue";

import axios from "axios";
import { Errors } from "form-backend-validation";
export default {
  data() {
    return {
      errors: new Errors(),
      form: {
        name: this.menu.name,
        id: this.menu.id,
        parent_id: this.menu.id,
      },
    };
  },
  components: { ParentSelect, ParentSelection },
  props: {
    menus: {
      type: Array,
    },
    menu: {
      type: Object,
    },
  },
  computed: {
    parentId() {
      return this.menu.parent_id;
    },
  },
  methods: {
    submit() {
      axios
        .put(`/menu/${this.menu.id}`, this.form)
        .then((response) => {
          Turbolinks.visit("/menu");
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
          this.form.name = this.menu.name;
        });
    },
    selectParent(parentId) {
      this.menu.parent_id = parentId;
    },
  },
};
</script>

<style>
</style>
