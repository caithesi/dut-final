<template>
  <layout-app>
    <success-link-btn :link="createRoute" alias="Add" />
    <div class="col-md-12">
      <custom-table
        :headData="tableHeaderData"
        :loopData="tableLoopData"
        :tableData="settingsData"
        @edit-item="editItem"
        @delete-item="deleteItem"
      >
      </custom-table>
    </div>
    <pagination
      :links="this.settings.links"
      :current_page="this.settings.current_page"
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
      tableHeaderData: ["#", "Config Key", "Config Value", "Action"],
      tableLoopData: ["id", "config_key", "config_value"],
      createRoute: laroute.route("setting.create"),
      //   productIndex: laroute.route("product.index"),
    };
  },
  props: {
    settings: {
      type: Object,
    },
  },
  computed: {
    settingsData() {
      return this.settings["data"];
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
    editItem(id) {
      let edit = laroute.route("setting.edit", { setting: id });
      Turbolinks.visit(edit);
    },
    deleteItem(id) {
      let del = laroute.route("setting.destroy", { setting: id });
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

