<template>
  <div v-if="dataKey == 'image_path'">
    <img :src="dataTable[dataKey]" alt="" style="" />
  </div>
  <div v-else-if="dataKey == 'price'">
    {{ Number(dataTable[dataKey]).toLocaleString() }}
  </div>
  <div v-else>{{ dataTable[dataKey] }}</div>
</template>

<script>
import CustomTable from "../../../components/tables/CustomTable.vue";
export default {
  components: { CustomTable },
  props: {
    dataTable: {
      type: Object,
      default() {
        return {};
      },
    },
    dataKey: {
      type: String,
      default() {
        return "";
      },
    },
  },
};
</script>

<style scoped>
img {
  width: 150px;
  height: 100px;
  object-fit: cover;
}
</style>
