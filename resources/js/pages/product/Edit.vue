<template>
  <layout-app :headerPage="headerContent">
    <div class="col-md-6">
      <form @submit.prevent="submit">
        <text-form-input
          id="productName"
          :formdata="form.name"
          :errorName="errors.has('name')"
          :errorData="errors.first('name')"
          @change-input="changeInput($event, 'name')"
        />

        <text-form-input
          id="productPrice"
          :formdata="form.price"
          :errorName="errors.has('price')"
          :errorData="errors.first('price')"
          @change-input="changeInput($event, 'price')"
        />

        <parent-selection
          :parentData="categories"
          labelSelect="Select Category"
          @select-parent="selectCategory"
          :childParentId="form.category_id"
        ></parent-selection>
        <div>
          <file-form-input
            id="featureImage"
            fileAccept="image/*"
            @change-file-input="selectFeatureImage"
          />
          <div class="col-md-12">
            <div class="row">
              <img
                :src="form.feature_image_path"
                alt=""
                id="feature-img-path"
              />
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="">Select Product Images</label>
          <input
            type="file"
            class="form-control-file"
            id="files"
            @change="selectProductImage($event)"
            multiple
          />
          <div class="col-md-12">
            <div class="row">
              <div
                v-for="(img_src, index) in form.productImg"
                :key="index"
                class="col-md-3"
              >
                <img
                  :src="img_src.image_path"
                  alt=""
                  srcset=""
                  class="product-images"
                />
              </div>
            </div>
          </div>
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
        name: this.product.name,
        category_id: this.product.category_id,
        price: this.product.price,
        feature_image_path: this.product.feature_img_path,
      },
      productImg: this.productImgs,

      errors: new Errors(),
      productCreate: laroute.route("product.create"),
      productStore: laroute.route("product.store"),
      productIndex: laroute.route("product.index"),
      productUpdate: laroute.route("product.update"),
    };
  },
  props: {
    product: {
      type: Object,
    },
    categories: {
      type: Array,
      default() {
        return [];
      },
    },
    productImgs: {
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
      //   for (var i = 0; i < this.productImg.length; i++) {
      //     let file = this.productImg[i];

      //     formData.append("product_img[" + i + "]", file);
      //   }
      formData.append("_method", "put");
      let editLink = laroute.route("product.update", {
        product: this.product.id,
      });
      editLink = editLink + "?_method=PATCH";
      console.log(editLink);
      const config = { headers: { "Content-Type": "multipart/form-data" } };
      axios
        .post(editLink, this.form, config)
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
  mounted() {
    console.log(this.productImgs);
  },
};
</script>

<style scoped>
#feature-img-path {
  width: 100%;
  object-fit: cover;
}
.product-images {
  width: 100%;
  height: 130px;
  object-fit: cover;
}
</style>
