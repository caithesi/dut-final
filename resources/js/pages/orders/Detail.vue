<template>
  <layout-app>
    <!-- <success-link-btn :link="productCreate" alias="Add" /> -->
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th scope="col" v-for="(value, key) in tableHeaderData" :key="key">
              {{ value }}
            </th>
          </tr>
        </thead>
        <tbody class="custom-table-body">
          <tr v-for="(value, key) in detail" :key="key">
            <th scope="row">{{ value.id }}</th>

            <td>
              {{ detailProduct[value.product_id] }}
            </td>
            <td>
              {{ value.price }}
            </td>
            <td>
              {{ value.quantity }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </layout-app>
</template>
<script>
import Pagination from "../../components/pagination/Pagination.vue";
import SuccessLinkBtn from "../../components/button/SuccessLinkBtn.vue";
import CustomTable from "../../components/tables/CustomTable.vue";

import axios from "axios";

export default {
  components: { Pagination, SuccessLinkBtn, CustomTable },
  data() {
    return {
      tableHeaderData: ["#", "Product", "Price", "Quantity"],
    };
  },
  props: {
    detail: {
      type: Array,
    },
    detailProduct: {
      type: Object,
    },
  },
  computed: {},
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
  },
  mounted() {
    console.log(this.detailProduct);
  },
};
</script>

<style>
</style>

