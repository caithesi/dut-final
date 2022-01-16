<template>
  <div class="category-tab">
    <!--category-tab-->
    <div class="col-sm-12">
      <ul class="nav nav-tabs">
        <li
          v-for="(item, index) in categories"
          :key="index"
          :class="categoryItemActiveClass(index)"
        >
          <a :href="`#${item.id}`" data-toggle="tab">
            {{ item.name }}
          </a>
        </li>
      </ul>
    </div>
    <div class="tab-content">
      <div
        v-for="(item, index) in categories"
        :key="index"
        :class="tabContentActiveClass(index)"
        :id="item.id"
      >
        <div
          class="col-sm-3"
          v-for="(product, product_index) in item.products"
          :key="product_index"
        >
          <div class="product-image-wrapper">
            <div class="single-products">
              <div class="productinfo text-center">
                <img :src="'/eshopper/images/home/gallery1.jpg'" alt="" />
                <h2>$56</h2>
                <p>Easy Polo Black Edition</p>
                <a href="#" class="btn btn-default add-to-cart"
                  ><i class="fa fa-shopping-cart"></i>Add to cart</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {};
  },
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  computed: {
    categoryItemActiveClass() {
      return function (index) {
        return index == 0 ? "active" : "";
      };
    },
    tabContentActiveClass() {
      return function (index) {
        return index == 0 ? "tab-pane fade active in" : "tab-pane fade";
      };
    },
  },
  mounted() {
    console.log(this.categories);
  },
};
</script>

<style>
</style>
