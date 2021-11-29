<template>
  <layout-app :headerPage="headerContent">
    <success-link-btn link="/menu/create" alias="Add" />
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

export default {
  components: { Pagination },
  data() {
    return {
      tableHeaderData: ["#", "Name", "Action"],
      tableLoopData: ["id", "name"],
      headerContent: {
        name: "Menu",
        key: "Index",
      },
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
      Turbolinks.visit("/menu/" + id + "/edit");
    },
    deleteItem(id) {
      axios
        .delete(`/menu/${id}`)
        .then((response) => {
          Turbolinks.visit("/menu");
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

