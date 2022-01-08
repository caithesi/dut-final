<template>
  <layout-app :headerPage="headerContent">
    <success-link-btn :link="createRoute" alias="Add" />
    <div class="col-md-12">
      <custom-table
        :headData="tableHeaderData"
        :loopData="tableLoopData"
        :tableData="rolesData"
        @edit-item="editItem"
        @delete-item="deleteItem"
      >
      </custom-table>
    </div>
    <pagination
      :links="this.roles.links"
      :current_page="this.roles.current_page"
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
      headerContent: {
        name: "Role",
        key: "Index",
      },
      tableHeaderData: ["#", "Name", "Description", "Action"],
      tableLoopData: ["id", "name", "display_name"],
      createRoute: laroute.route("role.create"),
      indexRoute: laroute.route("role.index"),
    };
  },
  props: {
    roles: {
      type: Object,
    },
  },
  computed: {
    rolesData() {
      return this.roles["data"];
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
    editItem(id) {
      let edit = laroute.route("role.edit", { role: id });
      Turbolinks.visit(edit);
    },
    deleteItem(id) {
      let del = laroute.route("role.destroy", { role: id });
      axios
        .delete(del)
        .then((response) => {
          Turbolinks.visit(this.indexRoute);
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

