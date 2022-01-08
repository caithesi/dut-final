<template>
  <layout-app>
    <success-link-btn :link="createRoute" alias="Add" />
    <div class="col-md-12">
      <custom-table
        :headData="tableHeaderData"
        :loopData="tableLoopData"
        :tableData="usersData"
        @edit-item="editItem"
        @delete-item="deleteItem"
      >
      </custom-table>
    </div>
    <pagination
      :links="this.users.links"
      :current_page="this.users.current_page"
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

export default {
  components: { Pagination, SuccessLinkBtn, CustomTable },
  data() {
    return {
      tableHeaderData: ["#", "Name", "Email", "Action"],
      tableLoopData: ["id", "name", "email"],
      createRoute: laroute.route("user.create"),
      //   productIndex: laroute.route("product.index"),
    };
  },
  props: {
    users: {
      type: Object,
    },
  },
  computed: {
    usersData() {
      return this.users["data"];
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
    editItem(id) {
      let edit = laroute.route("user.edit", { user: id });
      Turbolinks.visit(edit);
    },
    deleteItem(id) {
      let del = laroute.route("user.destroy", { user: id });
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

