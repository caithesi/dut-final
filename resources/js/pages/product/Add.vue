<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <text-form-input
          id="productName"
          :errorName="errors.has('name')"
          :errorData="errors.first('name')"
          @change-input="changeInput($event, 'name')"
        />

        <text-form-input
          id="productPrice"
          :errorName="errors.has('price')"
          :errorData="errors.first('price')"
          @change-input="changeInput($event, 'price')"
        />

        <parent-selection
          :parentData="categories"
          labelSelect="Select Category"
          @select-parent="selectCategory"
        ></parent-selection>

        <file-form-input
          id="featureImage"
          fileAccept="image/*"
          @change-file-input="selectFeatureImage"
        />

        <div class="form-group">
          <label for="">Select Product Images</label>
          <input
            type="file"
            class="form-control-file"
            id="files"
            @change="selectProductImage($event)"
            multiple
          />
        </div>

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
import FileFormInput from "../../components/input/FileFormInput.vue";
export default {
  components: { ParentSelection, TextFormInput, FileFormInput },
  data() {
    return {
      headerContent: {
        name: "Menu",
        key: "Add",
      },
      form: {
        name: null,
        category_id: 0,
        price: 0,
        feature_image_path: {},
      },
      productImg: "",
      errors: new Errors(),
      productCreate: laroute.route("product.create"),
      productStore: laroute.route("product.store"),
      productIndex: laroute.route("product.index"),
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
      for (var i = 0; i < this.productImg.length; i++) {
        let file = this.productImg[i];

        formData.append("product_img[" + i + "]", file);
      }
      const config = { headers: { "Content-Type": "multipart/form-data" } };
      axios
        .post(this.productStore, formData, config)
        .then((response) => {
          Turbolinks.visit(response.data.file_path);
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
    selectCategory(categoryId) {
      this.form.category_id = categoryId;
    },
    changeInput($event, element) {
      this.form[element] = $event;
    },
    selectFeatureImage(file) {
      this.form.feature_image_path = file;
    },
    selectProductImage($event) {
      this["productImg"] = $event.target.files;
    },
  },
  mounted() {},
};
</script>

<style>
</style>
