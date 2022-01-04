<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <text-form-input
          id="configKey"
          :formdata="form.config_key"
          :errorName="errors.has('config_key')"
          :errorData="errors.first('config_key')"
          @change-input="changeInput($event, 'config_key')"
        />
        <text-area-input
          id="configValue"
          :formdata="form.config_value"
          :errorName="errors.has('config_value')"
          :errorData="errors.first('config_value')"
          @change-input="changeInput($event, 'config_value')"
        />

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </layout-app>
</template>

<script>
import axios from "axios";
import { Errors } from "form-backend-validation";

import TextFormInput from "../../components/input/TextFormInput.vue";
import TextAreaInput from "../../components/input/TextAreaInput.vue";
export default {
  components: { TextFormInput, TextAreaInput },
  data() {
    return {
      headerContent: {
        name: "Setting",
        key: "Add",
      },
      form: {
        config_key: this.setting.config_key,
        config_value: this.setting.config_value,
      },
      errors: new Errors(),
      storeRoute: laroute.route("setting.store"),
    };
  },
  props: {
    setting: {
      type: Object,
    },
  },
  methods: {
    submit() {
      const formData = new FormData();
      _.each(this.form, (value, key) => {
        formData.append(key, value);
      });
      let edit_url = laroute.route("setting.update", {
        setting: this.setting.id,
      });
      edit_url = edit_url + "?_method=PUT";
      axios
        .post(edit_url, formData)
        .then((response) => {
          Turbolinks.visit(response.data.file_path);
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
    changeInput($event, element) {
      this.form[element] = $event;
    },
  },
  mounted() {},
};
</script>

<style>
</style>
