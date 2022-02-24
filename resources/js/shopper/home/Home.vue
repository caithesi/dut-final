<template>
  <shopper-app>
    <shopper-slider :sliders="sliders" />
    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <div class="left-sidebar">
              <shopper-category :categories="categories" />
            </div>
          </div>

          <div class="col-sm-9 padding-right">
            <recommended-item />
            <feature-item
              :feature_products="feature_products"
              @add-to-cart="addToCart"
            />
          </div>
        </div>
      </div>
    </section>
  </shopper-app>
</template>

<script>
import CategoryTab from "../components/CategoryTab.vue";
import FeatureItem from "./FeatureItem.vue";
import RecommendedItem from "../components/RecommendedItem.vue";
import ShopperBrand from "./ShopperBrand.vue";
import ShopperCategory from "../components/ShopperCategory.vue";
import ShopperSlider from "../components/ShopperSlider.vue";
import axios from "axios";
export default {
  components: {
    ShopperSlider,
    ShopperCategory,
    ShopperBrand,
    FeatureItem,
    RecommendedItem,
    CategoryTab,
  },
  props: {
    sliders: {
      type: Array,
      default() {
        return [];
      },
    },
    categories: {
      type: Array,
      default() {
        return [];
      },
    },
    feature_products: {
      type: Array,
      default() {
        return [];
      },
    },
    category_products: {
      type: Array,
      default() {
        return [];
      },
    },
    user: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  mounted() {},
  data() {
    return {};
  },
  methods: {
    addToCart(id) {
      let _form = { quantity: 1 };
      axios
        .post(laroute.route("shop.products.cart", { id: id }), _form)
        .then((resp) => resp.data[0])
        .then((data) => {
          this.$swal(
            `Added to your cart`,
            `${data.name} is in your cart, check it now`,
            "success"
          );
          console.log(data);
        });
    },
  },
};
</script>

<style>
</style>
