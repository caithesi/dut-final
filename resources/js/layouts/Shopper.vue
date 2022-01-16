<template>
  <div>
    <shopper-header />
    <slot></slot>
    <shopper-footer />
  </div>
</template>

<script>
import ShopperFooter from "../shopper/rare_components/ShopperFooter.vue";
import ShopperHeader from "../shopper/rare_components/ShopperHeader.vue";

export default {
  mounted() {},
  components: { ShopperHeader, ShopperFooter },
};
</script>

<style>
</style>
