<template>
  <shopper-app>
    <section id="cart_items">
      <div class="container">
        <div class="breadcrumbs">
          <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Shopping Cart</li>
          </ol>
        </div>
        <div class="table-responsive cart_info">
          <table class="table table-condensed">
            <thead>
              <tr class="cart_menu">
                <td class="image">Item</td>
                <td class="description"></td>
                <td class="price">Price</td>
                <td class="quantity">Quantity</td>
                <td class="total">Total</td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, id) in cart" :key="id" :id="`cart-info-${id}`">
                <td class="cart_product">
                  <a href=""
                    ><img class="feature-img" :src="item.image" alt=""
                  /></a>
                </td>
                <td class="cart_description">
                  <h4>
                    <a href=""> {{ item.name }} </a>
                  </h4>
                </td>
                <td class="cart_price">
                  <p :id="`cart-price-${id}`">{{ item.price }}</p>
                </td>
                <td class="cart_quantity">
                  <div class="cart_quantity_button">
                    <a
                      class="cart_quantity_up"
                      href=""
                      @click.prevent="updateCartQuantity($event, 1, id)"
                    >
                      +
                    </a>
                    <input
                      class="cart_quantity_input"
                      type="text"
                      name="quantity"
                      :value="item.quantity"
                      autocomplete="off"
                      size="2"
                      :id="`cart-quantity-${id}`"
                    />
                    <a
                      class="cart_quantity_down"
                      href=""
                      @click.prevent="updateCartQuantity($event, -1, id)"
                    >
                      -
                    </a>
                  </div>
                </td>
                <td class="cart_total">
                  <p
                    class="cart_total_price"
                    :id="`cart-price-each-total-${id}`"
                  >
                    {{ eachItemTotal(id) }}
                  </p>
                </td>
                <td class="cart_delete">
                  <a
                    class="cart_quantity_delete"
                    href=""
                    @click.prevent="deleteCart($event, id)"
                    ><i class="fa fa-times"></i
                  ></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
    <section id="do_action">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="total_area">
              <ul>
                <li>
                  Cart Sub Total
                  <span id="total-user-cart-price"> </span>
                </li>
                <li>Eco Tax <span id="eco-tax">2</span></li>
                <li>Shipping Cost <span>Free</span></li>
                <li>Total <span id="total-with-eco-tax">$61</span></li>
              </ul>
              <a class="btn btn-default update" href="">Update</a>
              <a
                class="btn btn-default check_out"
                href=""
                @click.prevent="checkOut()"
                >Check Out</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>
  </shopper-app>
</template>

<script>
import axios from "axios";
export default {
  props: {
    cart: {
      type: Object,
      default() {
        return [];
      },
    },
  },
  mounted() {
    this.setPrice();
  },
  methods: {
    eachItemTotal(id) {
      const _cart = this.cart[id];
      return _cart.price * _cart.quantity;
    },
    cartSubTotal(cartPriceClassName) {
      let carts_price = [
        ...document.getElementsByClassName(cartPriceClassName),
      ];
      return carts_price.reduce((pre, cur) => {
        return pre + Number.parseInt(cur.innerHTML);
      }, 0);
    },
    updateCartQuantity($event, quantity, id) {
      let _form = { quantity: quantity };
      const cart_quantity = document.getElementById(`cart-quantity-${id}`);
      const cart_price = document.getElementById(`cart-price-each-total-${id}`);
      const cart_info = document.getElementById(`cart-info-${id}`);
      axios
        .post(laroute.route("shop.products.cart", { id: id }), _form)
        .then((resp) => {
          if (resp.data.length == 0) {
            cart_quantity.value = 0;
            cart_price.innerHTML = 0;
            console.log(cart_info);
            cart_info.remove();
            this.setPrice();
            return;
          }
          let data = resp.data[0];
          cart_quantity.value = data.quantity;
          cart_price.innerHTML = data.quantity * data.price;
          this.setPrice();
        });
    },
    setPrice() {
      document.getElementById("total-user-cart-price").innerHTML =
        this.cartSubTotal("cart_total_price");
      document.getElementById("total-with-eco-tax").innerHTML =
        document.getElementById("total-user-cart-price").innerHTML -
        0 +
        (document.getElementById("eco-tax").innerHTML - 0);
    },
    deleteCart($event, id) {
      const cart_quantity = document.getElementById(`cart-quantity-${id}`);
      this.updateCartQuantity($event, -cart_quantity.value, id);
    },
    checkOut() {
      axios
        .post(laroute.route("shop.check-out"))
        .then((resp) => {
          Turbolinks.visit("/");
        })
        .catch((error) => {
          console.log(error.response.status);
          if (error.response.status === 401) {
            Turbolinks.visit("/login");
          }
        });
    },
  },
};
</script>

<style scoped>
.feature-img {
  max-width: 150px;
}
</style>
