<template>
  <div class="col-md-12">
    <a :href="link" class="btn btn-success float-right m-2">{{ alias }}</a>
  </div>
</template>

<script>
export default {
  props: {
    link: {
      type: String,
    },
    alias: {
      type: String,
    },
  },
};
</script>

<style>
</style>
