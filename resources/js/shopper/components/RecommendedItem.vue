<template>
  <div class="recommended_items">
    <!--recommended_items-->
    <h2 class="title text-center">recommended items</h2>

    <div
      id="recommended-item-carousel"
      class="carousel slide"
      data-ride="carousel"
    >
      <div class="carousel-inner">
        <div
          v-for="(contain_count, index) in item_contain_count"
          :key="index"
          :class="itemActiveClass(index)"
        >
          <div
            class="col-sm-4"
            v-for="(item, id) in getItemCount(contain_count)"
            :key="id"
          >
            <div class="product-image-wrapper">
              <div class="single-products">
                <div class="productinfo text-center">
                  <a :href="productDetails(getRecPro(index, id)['id'])">
                    <img
                      :src="getRecPro(index, id)['feature_img_path']"
                      alt=""
                    />
                  </a>
                  <h2>{{ getRecPro(index, id)["name"] }}</h2>
                  <p>{{ getRecPro(index, id)["price"] }}</p>
                  <a
                    href="#"
                    class="btn btn-default add-to-cart"
                    @click.prevent="addToCart($event)"
                    :data-url="getRecPro(index, id)['id']"
                    ><i class="fa fa-shopping-cart"></i>Add to cart</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a
        class="left recommended-item-control"
        href="#recommended-item-carousel"
        data-slide="prev"
      >
        <i class="fa fa-angle-left"></i>
      </a>
      <a
        class="right recommended-item-control"
        href="#recommended-item-carousel"
        data-slide="next"
      >
        <i class="fa fa-angle-right"></i>
      </a>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      recommend: [],
      item_count: 3,
      item_contain_count: 1,
      rec_pro: {},
    };
  },
  beforeCreate() {
    axios
      .get(laroute.route("shop.product.recommend"))
      .then((resp) => resp.data)
      .then((data) => {
        this.recommend = data;
        this.item_contain_count = Math.ceil(this.recommend.length / 3);
      });
  },
  created() {},
  mounted() {},
  computed: {
    itemActiveClass() {
      return function (id) {
        return id == 0 ? "item active" : "item";
      };
    },
    getItemCount() {
      return function (index) {
        if (this.recommend.length - this.item_count * index > 0) {
          return this.item_count;
        } else {
          return this.recommend.length - this.item_count * (index - 1);
        }
      };
    },
    productDetails() {
      return function (id) {
        return laroute.route("shop.product.show", { product: id });
      };
    },
  },
  methods: {
    computedProductIndex(loopCount, index) {
      return this.item_count * loopCount + index;
    },
    getRecPro(index, id) {
      return this.recommend[this.computedProductIndex(index, id)];
    },
    addToCart($event) {
      console.log($event.target.getAttribute("data-url"));
      this.$emit("add-to-cart", $event.target.getAttribute("data-url"));
    },
  },
};
</script>

<style>
</style>
