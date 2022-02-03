<template>
  <header id="header">
    <!--header-->
    <div class="header_top">
      <!--header_top-->
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="contactinfo">
              <ul class="nav nav-pills">
                <li>
                  <a href="#"
                    ><i class="fa fa-phone"></i> {{ phone_contact }}
                  </a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-envelope"></i> {{ email }} </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="social-icons pull-right">
              <ul class="nav navbar-nav">
                <li>
                  <a :href="face_book"><i class="fa fa-facebook"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/header_top-->
    <div class="header-middle">
      <!--header-middle-->
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <div class="logo pull-left">
              <a href="index.html"
                ><img src="/eshopper/images/home/logo.png" alt=""
              /></a>
            </div>
            <!-- <div class="btn-group pull-right">
              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-default dropdown-toggle usa"
                  data-toggle="dropdown"
                >
                  USA
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="#">Canada</a></li>
                  <li><a href="#">UK</a></li>
                </ul>
              </div>

              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-default dropdown-toggle usa"
                  data-toggle="dropdown"
                >
                  DOLLAR
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="#">Canadian Dollar</a></li>
                  <li><a href="#">Pound</a></li>
                </ul>
              </div>
            </div> -->
          </div>
          <div class="col-sm-8">
            <div class="shop-menu pull-right">
              <ul class="nav navbar-nav">
                <li>
                  <a href="#"><i class="fa fa-user"></i> Account</a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-star"></i> Wishlist</a>
                </li>
                <li>
                  <a href="checkout.html"
                    ><i class="fa fa-crosshairs"></i> Checkout</a
                  >
                </li>
                <li>
                  <a :href="showCartRoute"
                    ><i class="fa fa-shopping-cart"></i> Cart</a
                  >
                </li>
                <li>
                  <a v-if="checkEmptyUser()" href="login.html"
                    ><i class="fa fa-lock"></i> Login</a
                  >
                  <a v-else href="#"> {{ user.email }} </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/header-middle-->
    <div class="header-bottom">
      <!--header-bottom-->
      <div class="container">
        <div class="row">
          <div class="col-sm-9">
            <div class="navbar-header">
              <button
                type="button"
                class="navbar-toggle"
                data-toggle="collapse"
                data-target=".navbar-collapse"
              >
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div class="mainmenu pull-left">
              <ul class="nav navbar-nav collapse navbar-collapse">
                <li><a href="index.html" class="active">Home</a></li>
                <li class="dropdown">
                  <a href="#">Shop<i class="fa fa-angle-down"></i></a>
                  <ul role="menu" class="sub-menu">
                    <li><a href="shop.html">Products</a></li>
                    <li><a href="product-details.html">Product Details</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                    <li><a href="cart.html">Cart</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#">Blog<i class="fa fa-angle-down"></i></a>
                  <ul role="menu" class="sub-menu">
                    <li><a href="blog.html">Blog List</a></li>
                    <li><a href="blog-single.html">Blog Single</a></li>
                  </ul>
                </li>
                <li><a href="404.html">404</a></li>
                <li><a href="contact-us.html">Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="search_box pull-right">
              <input type="text" placeholder="Search" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/header-bottom-->
  </header>
</template>

<script>
import axios from "axios";
export default {
  props: {},
  data() {
    return {
      face_book: {
        type: String,
        default() {
          return "";
        },
      },
      email: {
        type: String,
        default() {
          return "";
        },
      },
      phone_contact: {
        type: String,
        default() {
          return "";
        },
      },
      isEmpty: {
        type: Boolean,
        default() {
          return false;
        },
      },
      user: {
        type: Object,
        default() {
          return {};
        },
      },
      showCartRoute: laroute.route("shop.products.cart-show"),
    };
  },
  created() {
    axios.get("/page-config/facebook_link").then((resp) => {
      this.face_book = resp.data;
    });
    axios.get("/page-config/email").then((resp) => {
      this.email = resp.data;
    });
    axios.get("/page-config/phone_contact").then((resp) => {
      this.phone_contact = resp.data;
    });
    axios.get(laroute.route("logged.user")).then((resp) => {
      this.user = resp.data;
    });
    this.isEmpty = objectIsEmpty(this.user);
  },
  computed: {},
  mounted() {},
  methods: {
    checkEmptyUser() {
      return (
        Object.keys(this.user).filter(
          (keys) => !["type", "default"].includes(keys)
        ).length == 0
      );
    },
  },
};
</script>

<style>
</style>
