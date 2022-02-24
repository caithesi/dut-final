<template>
  <div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Features Items</h2>
    <div v-for="(items, index) in feature_products" :key="index">
      <div class="col-sm-4">
        <div class="product-image-wrapper">
          <div class="single-products">
            <div class="productinfo text-center">
              <a :href="productDetails(items.id)">
                <img :src="items.feature_img_path" alt="" />
              </a>
              <h2>${{ items.price }}</h2>
              <p>{{ items.name }}</p>
              <a
                href="#"
                class="btn btn-default add-to-cart"
                @click.prevent="addToCart($event)"
                :data-url="items.id"
                ><i class="fa fa-shopping-cart"></i>Add to cart</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    feature_products: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  methods: {
    addToCart($event) {
      this.$emit("add-to-cart", $event.target.getAttribute("data-url"));
    },
    productDetails() {
      return function (id) {
        return laroute.route("shop.product.show", { product: id });
      };
    },
  },
};
</script>

<style>
</style>
