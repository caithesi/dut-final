<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <text-form-input
          id="sliderName"
          :errorName="errors.has('name')"
          :errorData="errors.first('name')"
          @change-input="changeInput($event, 'name')"
        />
        <text-area-input
          id="sliderDescription"
          :errorName="errors.has('description')"
          :errorData="errors.first('description')"
          @change-input="changeInput($event, 'description')"
        />

        <file-form-input
          id="featureImage"
          fileAccept="image/*"
          @change-file-input="selectFeatureImage"
        />

        <button type="submit" class="btn btn-primary" id="submit-form-btn">
          Submit
        </button>
      </form>
    </div>
  </layout-app>
</template>

<script>
import axios from "axios";
import { Errors } from "form-backend-validation";

import ParentSelection from "../../../components/select/ParentSelection.vue";
import TextFormInput from "../../../components/input/TextFormInput.vue";
import FileFormInput from "../../../components/input/FileFormInput.vue";
import TextAreaInput from "../../../components/input/TextAreaInput.vue";
export default {
  components: { ParentSelection, TextFormInput, FileFormInput, TextAreaInput },
  data() {
    return {
      headerContent: {
        name: "Menu",
        key: "Add",
      },
      form: {
        name: "",
        description: "",
        slider_image: "",
      },
      errors: new Errors(),
      sliderCreate: laroute.route("slider.create"),
      sliderStore: laroute.route("slider.store"),
      sliderIndex: laroute.route("slider.index"),
    };
  },
  props: {
    categories: {
      type: Array,
    },
  },
  methods: {
    submit() {
      const formData = new FormData();
      _.each(this.form, (value, key) => {
        formData.append(key, value);
      });
      const config = { headers: { "Content-Type": "multipart/form-data" } };
      axios
        .post(this.sliderStore, formData, config)
        .then((response) => {
          console.log(response);
        //   Turbolinks.visit(response.data.file_path);
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
    changeInput($event, element) {
      this.form[element] = $event;
    },
    selectFeatureImage(file) {
      this.form.slider_image = file;
    },
  },
  mounted() {
    document
      .getElementById("sliderDescription")
      .setAttribute("maxlength", "150");
  },
};
</script>

<style>
</style>
