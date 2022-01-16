<template>
  <div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Features Items</h2>
    <div v-for="(items, index) in feature_products" :key="index">
      <div class="col-sm-4">
        <div class="product-image-wrapper">
          <div class="single-products">
            <div class="productinfo text-center">
              <img :src="items.feature_img_path" alt="" />
              <h2>${{ items.price }}</h2>
              <p>{{ items.name }}</p>
              <a href="#" class="btn btn-default add-to-cart"
                ><i class="fa fa-shopping-cart"></i>Add to cart</a
              >
            </div>
            <div class="product-overlay">
              <div class="overlay-content">
                <h2>${{ items.price }}</h2>
                <p>{{ items.name }}</p>
                <a href="#" class="btn btn-default add-to-cart"
                  ><i class="fa fa-shopping-cart"></i>Add to cart</a
                >
              </div>
            </div>
          </div>
          <div class="choose">
            <ul class="nav nav-pills nav-justified">
              <li>
                <a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a>
              </li>
              <li>
                <a href="#"><i class="fa fa-plus-square"></i>Add to compare</a>
              </li>
            </ul>
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
};
</script>

<style>
</style>
