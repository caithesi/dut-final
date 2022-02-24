<template>
  <div class="shopper-informations">
    <div class="row">
      <div class="">
        <div class="bill-to">
          <p>Bill To</p>
          <div class="form-one">
            <div class="form-group">
              <input
                v-model="form.user_name"
                type="text"
                placeholder="Reciver"
                id="reciever-name"
                size="30"
              />
            </div>
            <div class="form-group">
              <input
                type="text"
                placeholder="Phone"
                id="phone"
                size="30"
                v-model="form.user_phone"
              />
            </div>
            <div class="form-group">
              <p>Shipping Order</p>
              <textarea
                v-model="form.ship_msg"
                name="message"
                placeholder="Notes about your order, Special Notes for Delivery"
                rows="4"
                id="delivery-message"
              ></textarea>
            </div>
          </div>
          <div class="form-two">
            <div class="form-group">
              <label :for="select_province_id">Select Province</label>
              <select
                v-model="form.province_id"
                class="form-control"
                :id="select_province_id"
                @change.prevent="changeProvince($event)"
              ></select>
            </div>
            <div class="form-group">
              <label :for="select_district_id">Select District</label>
              <select
                v-model="form.district_id"
                class="form-control"
                :id="select_district_id"
                @change.prevent="changeDistrict($event)"
              ></select>
            </div>
            <div class="form-group">
              <label :for="select_ward_id">Select Ward</label>
              <select
                v-model="form.ward_code"
                class="form-control"
                :id="select_ward_id"
                @change.prevent="changeWard($event)"
              ></select>
            </div>
            <div class="form-group">
              <label :for="select_ship_service_id">Select Ship Service</label>
              <select
                v-model="form.ship_service_id"
                class="form-control"
                :id="select_ship_service_id"
                @change.prevent="changeShipService($event)"
              ></select>
            </div>
            <input
              type="text"
              placeholder="Total"
              disabled
              value="0"
              :id="ship_fee_show_id"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import axios from "axios";

export default {
  name: "app",
  data() {
    return {
      form: {
        province_id: null,
        district_id: null,
        ward_code: null,
        ship_service_id: null,
        ship_service_fee: 0,
        user_name: null,
        user_phone: null,
        ship_msg: null,
      },

      select_province_id: "provinceSelect",
      select_district_id: "districtSelect",
      select_ward_id: "wardSelect",
      select_ship_service_id: "shipService",
      ship_fee_show_id: "total-ship-fee",
    };
  },
  components: {
    Multiselect,
  },
  methods: {
    changeSelectOptions(data, id, key, value, selected = false) {
      let select = document.getElementById(id);
      let options = data;
      for (let i = 0; i < options.length; i++) {
        let opt = options[i];
        let el = document.createElement("option");
        el.text = opt[value];
        el.value = opt[key];
        if (i == 0) {
          if (selected) {
            el.setAttribute("selected", "selected");
          }
        }
        select.add(el);
      }
    },
    async getProvince() {
      return axios
        .get(laroute.route("delivery.address.province"))
        .then((resp) => resp.data);
    },
    async getDistrict(provine_id) {
      return axios
        .get(
          laroute.route("delivery.address.district", {
            provine_id: provine_id,
          })
        )
        .then((resp) => resp.data);
    },
    async getWard(district_id) {
      return axios
        .get(
          laroute.route("delivery.address.ward", {
            district_id: district_id,
          })
        )
        .then((resp) => resp.data);
    },
    async getAvailableService(district_id) {
      const resp = await axios.get(
        laroute.route("delivery.available-service", {
          district_id: district_id,
        })
      );
      return resp.data;
    },
    async getFee() {
      let service_id = await document.getElementById("shipService").value;
      const district_id = await document.getElementById("districtSelect").value;
      const ward_code = await document.getElementById("wardSelect").value;
      while (service_id == "") {
        service_id = document.getElementById("shipService").value;
      }
      const resp = await axios.get(
        laroute.route("delivery.fee", {
          district_id: district_id,
          ward_code: ward_code,
          service_id: service_id,
        })
      );
      this.changeShippingFee(resp.data);
      return resp.data;
    },
    createProvineSelect(data, id, key, value) {
      document.getElementById(id).textContent = "";
      let newData = [
        {
          ProvinceID: 0,
          ProvinceName: "Select Province",
        },
      ];
      this.changeSelectOptions(newData.concat(data), id, key, value);
    },
    createDistrictSelect(data, id, key, value) {
      document.getElementById(id).textContent = "";
      let newData = [
        {
          DistrictID: 0,
          DistrictName: "Select District",
        },
      ];
      this.changeSelectOptions(newData.concat(data), id, key, value);
    },
    createWardSelect(data, id, key, value) {
      document.getElementById(id).textContent = "";
      let newData = [
        {
          WardCode: 0,
          WardName: "Select Ward",
        },
      ];
      this.changeSelectOptions(newData.concat(data), id, key, value);
    },
    createServiceSelect(data, id, key, value) {
      document.getElementById(id).textContent = "";
      let newData = [
        {
          service_id: 0,
          short_name: "Select Service",
        },
      ];
      this.changeSelectOptions(newData.concat(data), id, key, value, true);
    },

    async changeProvince($event) {
      this.getDistrict($event.target.value).then((resp) => {
        this.clearText([
          this.select_ward_id,
          this.select_ship_service_id,
          this.ship_fee_show_id,
        ]);
        this.createDistrictSelect(
          resp,
          "districtSelect",
          "DistrictID",
          "DistrictName"
        );
      });
    },
    async changeDistrict($event) {
      let district_id = $event.target.value;
      this.getWard(district_id).then((resp) => {
        this.clearText([this.select_ship_service_id, this.ship_fee_show_id]);
        this.createWardSelect(resp, "wardSelect", "WardCode", "WardName");
        this.getAvailableService(district_id).then((resp) => {
          this.createServiceSelect(
            resp,
            "shipService",
            "service_id",
            "short_name"
          );
        });
      });
    },
    async changeWard($event) {
      const district_id = document.getElementById("districtSelect").value;
      this.getAvailableService(district_id).then((resp) => {
        this.clearText([this.ship_fee_show_id]);
        this.createServiceSelect(
          resp,
          "shipService",
          "service_id",
          "short_name"
        );
      });
    },
    changeShipService($event) {
      this.getFee().then(
        (resp) => (document.getElementById("total-ship-fee").value = resp)
      );
    },
    clearText(ids = []) {
      ids.forEach((id) => {
        if (id === this.ship_fee_show_id) {
          document.getElementById(id).value = 0;
        } else {
          document.getElementById(id).textContent = "";
        }
      });
    },
    changeShippingFee(fee) {
      this.form.ship_service_fee = fee;
      this.$emit("change-fee", this.form);
    },
  },
  mounted() {
    this.getProvince().then((data) =>
      this.createProvineSelect(
        data,
        "provinceSelect",
        "ProvinceID",
        "ProvinceName"
      )
    );
  },
};
</script>

<style>
</style>
