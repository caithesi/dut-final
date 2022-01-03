<template>
  <layout-app>
    <success-link-btn :link="productCreate" alias="Add" />
    <div class="col-md-12">
      <custom-table
        :headData="tableHeaderData"
        :loopData="tableLoopData"
        :tableData="productsData"
        @edit-item="editItem"
        @delete-item="deleteItem"
      >
        <template v-slot:default="slotProps">
          <product-custom-table
            :dataTable="slotProps.value"
            :dataKey="slotProps.value_loop"
          />
        </template>
      </custom-table>
    </div>
    <pagination
      :links="this.products.links"
      :current_page="this.products.current_page"
      @change-page="changePage"
    />
  </layout-app>
</template>
<script>
import Pagination from "../../components/pagination/Pagination.vue";
import SuccessLinkBtn from "../../components/button/SuccessLinkBtn.vue";
import CustomTable from "../../components/tables/CustomTable.vue";

import axios from "axios";
import { Errors } from "form-backend-validation";
import ProductCustomTable from "./ProductCustomTable.vue";

export default {
  components: { Pagination, SuccessLinkBtn, CustomTable, ProductCustomTable },
  data() {
    return {
      tableHeaderData: ["#", "Name", "Price", "Image", "Category", "Action"],
      tableLoopData: ["id", "name", "price", "feature_img_path", "category"],
      productCreate: laroute.route("product.create"),
      productIndex: laroute.route("product.index"),
    };
  },
  props: {
    products: {
      type: Object,
    },
  },
  computed: {
    productsData() {
      return this.products["data"];
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
    editItem(id) {
      let edit = laroute.route("product.edit", { product: id });
      Turbolinks.visit(edit);
    },
    deleteItem(id) {
      let del = laroute.route("product.destroy", { product: id });
      axios
        .delete(del)
        .then((response) => {
          Turbolinks.visit(this.productIndex);
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
  },
  mounted() {},
};
</script>

<style>
</style>

