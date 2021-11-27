<template>
  <layout-app>
    <success-link-btn link="/category/create" alias="Add" />
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
import axios from "axios";
import { Errors } from "form-backend-validation";

export default {
  components: { Pagination },
  data() {
    return {
      tableHeaderData: ["#", "Name", "Action"],
      tableLoopData: ["id", "name"],
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
      Turbolinks.visit("/category/" + id + "/edit");
    },
    deleteItem(id) {
      axios
        .delete(`/category/${id}`)
        .then((response) => {
          Turbolinks.visit("/category");
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

