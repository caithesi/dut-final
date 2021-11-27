<template>
  <div>
    <h1>this is hello component</h1>
    <h2>{{ event.greeting }}</h2>
  </div>
</template>

<script>
export default {
  props: ['event'],
  mounted() {
    console.log(this.event);
  },
};
</script>

<style>
</style>
