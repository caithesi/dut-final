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
              <a :href="homeUrl"
                ><img src="/eshopper/images/home/logo.png" alt=""
              /></a>
            </div>
          </div>
          <div class="col-sm-8">
            <div class="shop-menu pull-right">
              <ul class="nav navbar-nav">
                <li>
                  <search-bar />
                </li>
                <li>
                  <a :href="showCartRoute"
                    ><i class="fa fa-shopping-cart"></i> Cart</a
                  >
                </li>
                <li>
                  <a v-if="checkEmptyUser()" href="login"
                    ><i class="fa fa-lock"></i> Login</a
                  >
                  <template v-else>
                    <ul class="nav navbar-nav">
                      <li>
                        <a href="#" class=""
                          ><i class="fa fa-user"></i> {{ user.email }}</a
                        >
                      </li>
                      <li><a href="#" class="">Logout</a></li>
                      <li></li>
                    </ul>
                  </template>
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
    </div>
    <!--/header-bottom-->
  </header>
</template>

<script>
import axios from "axios";
import SearchBar from "../components/SearchBar.vue";
export default {
  components: { SearchBar },
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
  computed: {
    homeUrl() {
      return laroute.route("shopper-home");
    },
  },
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

<style scoped>
</style>
