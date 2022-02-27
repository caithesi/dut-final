<template>
  <shopper-app>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <div class="left-sidebar">
              <shopper-category :categories="categories" />
            </div>
          </div>
          <div class="col-sm-9 padding-right">
            <div class="features_items">
              <!--features_items-->
              <h2 class="title text-center">Features Items</h2>
              <div>
                <div
                  class="col-sm-4"
                  v-for="(item, index) in products.data"
                  :key="index"
                >
                  <div class="product-image-wrapper">
                    <div class="single-products">
                      <div class="productinfo text-center feature-product">
                        <a :href="productDetails(item.id)"
                          ><div class="feature-image-container">
                            <img
                              :src="item.feature_img_path"
                              alt=""
                              class="feature-image"
                            /></div
                        ></a>

                        <h2>{{ item.price }}</h2>
                        <p>{{ item.name }}</p>
                        <a href="#" class="btn btn-default add-to-cart"
                          ><i class="fa fa-shopping-cart"></i>Add to cart</a
                        >
                      </div>
                    </div>
                    <div class="choose">
                      <ul class="nav nav-pills nav-justified">
                        <li>
                          <a href=""
                            ><i class="fa fa-plus-square"></i>Add to wishlist</a
                          >
                        </li>
                        <li>
                          <a href=""
                            ><i class="fa fa-plus-square"></i>Add to compare</a
                          >
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <pagination
              :links="this.products.links"
              :current_page="this.products.current_page"
              @change-page="changePage"
            />
            <!--features_items-->
          </div>
        </div>
      </div>
    </section>
  </shopper-app>
</template>

<script>
import Pagination from "../../../components/pagination/Pagination.vue";
import ShopperCategory from "../../components/ShopperCategory.vue";
export default {
  components: { ShopperCategory, Pagination },
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      },
    },
    products: {
      type: Object,
      default() {
        return [];
      },
    },
  },
  mounted() {
    console.log(laroute.route("shop.product.show"));
  },
  methods: {
    changePage(url) {
      Turbolinks.visit(url);
    },
  },
  computed: {
    productDetails() {
      return function (id) {
        return laroute.route("shop.product.show", { product: id });
      };
    },
  },
};
</script>

<style scoped>
.feature-product {
  max-height: 600px;
  min-height: 500px;
}
.feature-image {
  max-height: 400px;
}
.feature-image-container {
  min-height: 400px;
}
</style>
