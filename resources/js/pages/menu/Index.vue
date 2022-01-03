<template>
  <layout-app :headerPage="headerContent">
    <success-link-btn :link="lararoutes('create')" alias="Add" />
    <div class="col-md-12">
      <custom-table
        :headData="tableHeaderData"
        :loopData="tableLoopData"
        :tableData="menusData"
        @edit-item="editItem"
        @delete-item="deleteItem"
      />
    </div>
    <pagination
      :links="this.menus.links"
      :current_page="this.menus.current_page"
      @change-page="changePage"
    />
  </layout-app>
</template>
<script>
import Pagination from "../../components/pagination/Pagination.vue";
import axios from "axios";
import { Errors } from "form-backend-validation";
import SuccessLinkBtn from "../../components/button/SuccessLinkBtn.vue";
import CustomTable from "../../components/tables/CustomTable.vue";

export default {
  components: { Pagination, SuccessLinkBtn, CustomTable },
  data() {
    return {
      tableHeaderData: ["#", "Name", "Action"],
      tableLoopData: ["id", "name"],
      headerContent: {
        name: "Menu",
        key: "Index",
      },
      routeName: "menu",
    };
  },
  props: {
    menus: {
      type: Object,
    },
  },
  computed: {
    menusData() {
      return this.menus["data"];
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
    editItem(id) {
      Turbolinks.visit(this.lararoutes("edit", { [this.routeName]: id }));
    },
    deleteItem(id) {
      axios
        .delete(this.lararoutes("destroy", { [this.routeName]: id }))
        .then((response) => {
          Turbolinks.visit(this.lararoutes("index"));
        })
        .catch((error) => {
          this.errors = new Errors(error.response.data.errors);
        });
    },
    lararoutes(name, parameter = {}) {
      return laroute.route(`${this.routeName}.${name}`, parameter);
    },
  },
};
</script>

<style>
</style>

