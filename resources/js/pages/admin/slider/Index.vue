<template>
  <layout-app>
    <success-link-btn :link="sliderCreate" alias="Add" />
    <custom-table
      class="custom-table"
      :headData="tableHeaderData"
      :loopData="tableLoopData"
      :tableData="slidersData"
      @edit-item="editItem"
      @delete-item="deleteItem"
    >
      <template v-slot:default="slotProps">
        <slider-custom-table
          :dataTable="slotProps.value"
          :dataKey="slotProps.value_loop"
        />
      </template>
    </custom-table>
  </layout-app>
</template>

<script>
import CustomTable from "../../../components/tables/CustomTable.vue";
import SliderCustomTable from "./SliderCustomTable.vue";
import Pagination from "../../../components/pagination/Pagination.vue";
import SuccessLinkBtn from "../../../components/button/SuccessLinkBtn.vue";
import axios from "axios";

export default {
  components: {
    Pagination,
    SuccessLinkBtn,
    CustomTable,
    SliderCustomTable,
  },
  data() {
    return {
      tableHeaderData: ["#", "Name", "Description", "Image", "Action"],
      tableLoopData: ["id", "name", "description", "image_path"],
      sliderCreate: laroute.route("slider.create"),
      sliderIndex: laroute.route("slider.index"),
    };
  },
  props: {
    sliders: {
      type: Object,
    },
  },
  computed: {
    slidersData() {
      return this.sliders["data"];
    },
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
    editItem(id) {
      let edit = laroute.route("slider.edit", { slider: id });
      Turbolinks.visit(edit);
    },
    deleteItem(id) {
      let del = laroute.route("slider.destroy", { slider: id });
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
};
</script>

<style scoped>

</style>
