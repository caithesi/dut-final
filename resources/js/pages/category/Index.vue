<template>
  <layout-app>
    <success-link-btn :link="categoryCreate" alias="Add" />
    <div class="col-md-12">
      <custom-table
        :headData="tableHeaderData"
        :loopData="tableLoopData"
        :tableData="categoriesData"
        @edit-item="editItem"
        @delete-item="deleteItem"
      />
    </div>
    <pagination
      :links="this.categories.links"
      :current_page="this.categories.current_page"
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
      tableHeaderData: ["#", "Name", "Action"],
      tableLoopData: ["id", "name"],
      categoryCreate: laroute.route("category.create"),
      categoryIndex: laroute.route("category.index"),
    };
  },
  props: {
    categories: {
      type: Object,
    },
  },
  computed: {
    categoriesData() {
      return this.categories["data"];
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
    editItem(id) {
      let edit = laroute.route("category.edit", { category: id });
      Turbolinks.visit(edit);
    },
    deleteItem(id) {
      let del = laroute.route("category.destroy", { category: id });
      console.log(del);
      axios
        .delete(del)
        .then((response) => {
          Turbolinks.visit(this.categoryIndex);
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
  },
};
</script>

<style>
</style>

