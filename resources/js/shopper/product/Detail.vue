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
            <!--features_items-->
          </div>
          <div class="col-sm-9 padding-right">
            <div class="product-details">
              <!--product-details-->
              <div class="col-sm-5">
                <div class="view-product">
                  <img :src="product.feature_img_path" alt="" />
                  <!-- <h3>ZOOM</h3> -->
                </div>
                <div
                  id="similar-product"
                  class="carousel slide"
                  data-ride="carousel"
                >
                  <!-- Controls -->
                  <a
                    class="left item-control"
                    href="#similar-product"
                    data-slide="prev"
                  >
                    <i class="fa fa-angle-left"></i>
                  </a>
                  <a
                    class="right item-control"
                    href="#similar-product"
                    data-slide="next"
                  >
                    <i class="fa fa-angle-right"></i>
                  </a>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="product-information">
                  <h2>{{ product.name }}</h2>

                  <span>
                    <span> {{ product.price }} </span>
                    <label>Quantity:</label>
                    <input type="text" value="3" />
                    <button
                      type="button"
                      class="btn btn-fefault cart"
                      @click.prevent="addToCart"
                    >
                      <i class="fa fa-shopping-cart"></i>
                      Add to cart
                    </button>
                  </span>
                  <div>
                    <span> Total: {{ all_rate.length }} rates </span>
                    <br />
                    <span style="margin-top: 2px"
                      >Rating : {{ rateCalculate() }}/5
                    </span>
                  </div>
                  <star-rating
                    :increment="0.5"
                    @rating-selected="setRating"
                    :rating="rate"
                  />
                </div>
                <!--/product-information-->
              </div>
            </div>
            <!--/product-details-->

            <div class="category-tab shop-details-tab">
              <!--category-tab-->
              <div class="col-sm-12">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#details" data-toggle="tab">Details</a>
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <div class="tab-pane fade active in" id="details">
                  <div
                    class="col-sm-3"
                    v-for="(img, ids) in product_img"
                    :key="ids"
                  >
                    <div class="product-image-wrapper">
                      <div class="single-products">
                        <div class="productinfo text-center">
                          <img :src="img.image_path" alt="" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/category-tab-->

            <!--/recommended_items-->
          </div>
        </div>
      </div>
    </section>
  </shopper-app>
</template>

<script>
import axios from "axios";
import StarRating from "vue-star-rating";
import ShopperCategory from "../components/ShopperCategory.vue";
export default {
  components: { ShopperCategory, StarRating },
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      },
    },
    product: {
      type: Object,
      default() {
        return [];
      },
    },
    rate: {
      type: Number,
      default() {
        return 0;
      },
    },
    product_img: {
      type: Array,
      default() {
        return [];
      },
    },
    all_rate: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  methods: {
    setRating(rating) {
      const formData = new FormData();
      console.log(laroute.route("shop.products.rating"));
      //   formData.append("product_id", this.product.id);
      formData.append("rating", rating);
      axios
        .post(
          laroute.route("shop.products.rating", { id: this.product.id }),
          formData
        )
        .then((resp) => resp.data.rating)
        .then((resp) => {
          alert("Thank you for rating");
        })
        .catch((err) => {
          if (err.response.status === 401) {
            alert("you need to login first");
          }
        });
    },
    rateCalculate() {
      return (
        this.all_rate.reduce((pre, current) => pre + current.rating, 0) /
        this.all_rate.length
      );
    },
    addToCart() {
      let _form = { quantity: 1 };
      axios
        .post(
          laroute.route("shop.products.cart", { id: this.product.id }),
          _form
        )
        .then((resp) => resp.data[0])
        .then((data) => {
          this.$swal(
            `Added to your cart`,
            `${this.product.name} is in your cart, check it now`,
            "success"
          );
        });
    },
  },
  mounted() {
    console.log();
  },
};
</script>

<style>
</style>
