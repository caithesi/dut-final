<template>
  <section id="slider">
    <!--slider-->
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div id="slider-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li
                data-target="#slider-carousel"
                data-slide-to="0"
                class="active"
              ></li>
              <li
                v-for="(item, index) in sliders.length - 1"
                :key="index"
                data-target="#slider-carousel"
                :data-slide-to="item"
              ></li>
            </ol>

            <div class="carousel-inner">
              <div
                v-for="(item, index) in sliders"
                :key="index"
                :class="sliderItemActiveClass(index)"
              >
                <div class="col-sm-6">
                  <h1><span>E</span>-SHOPPER</h1>
                  <h2>{{ item.name }}</h2>
                  <p>
                    {{ item.description }}
                  </p>
                  <button type="button" class="btn btn-default get">
                    Get it now
                  </button>
                </div>
                <div class="col-sm-6">
                  <img
                    :src="item.image_path"
                    class="girl img-responsive"
                    alt=""
                  />
                  <img
                    src="/eshopper/images/home/pricing.png"
                    class="pricing"
                    alt=""
                  />
                </div>
              </div>
            </div>

            <a
              href="#slider-carousel"
              class="left control-carousel hidden-xs"
              data-slide="prev"
            >
              <i class="fa fa-angle-left"></i>
            </a>
            <a
              href="#slider-carousel"
              class="right control-carousel hidden-xs"
              data-slide="next"
            >
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    sliders: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  computed: {
    sliderItemActiveClass() {
      return function (id) {
        return id == 0 ? "item active" : "item";
      };
    },
  },
};
</script>

<style>
</style>
