<template>
  <div v-if="keyData == 'feature_img_path'">
    <img :src="elementData[keyData]" alt="" style="" />
  </div>
  <div v-else>{{ elementData[keyData] }}</div>
</template>

<script>
import axios from "axios";

export default {
  props: ["elementData", "keyData"],
  mounted() {
    // console.log(this.keyData);
    // console.log(this.elementData[this.keyData]);
    // console.log(this.elementData['category'].name);
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
