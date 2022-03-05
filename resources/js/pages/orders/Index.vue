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
          <tr v-for="(value, key) in orders.data" :key="key">
            <th scope="row">{{ value.id }}</th>

            <td>
              {{ value.customer == null ? value.user_id : value.customer.name }}
            </td>
            <td>
              {{ value.total }}
            </td>
            <td>
              {{ value.order_code }}
            </td>
            <td>
              <a :href="detailItem(value.id)" class="btn btn-default">Detail</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination
      :links="this.orders.links"
      :current_page="this.orders.current_page"
      @change-page="changePage"
    />
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
      tableHeaderData: ["#", "User", "Total", "Order Code", "Action"],
    };
  },
  props: {
    orders: {
      type: Object,
    },
  },
  computed: {
    detailItem() {
      return function (id) {
        return laroute.route("orders.show", { order: id });
      };
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
  },
  mounted() {},
};
</script>

<style>
</style>

