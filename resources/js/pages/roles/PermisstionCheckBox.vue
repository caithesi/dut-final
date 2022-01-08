<template>
  <div class="col-md-12">
    <div class="row">
      <div
        class="card bg-light mb-3 col-md-12 text-primary"
        v-for="(permission, permission_index) in permissions"
        :key="permission_index"
      >
        <div class="card-header">
          <label for="">
            <input
              class="checkbox_wrapper"
              type="checkbox"
              value=""
              @change.prevent="checkAll($event)"
            />
          </label>
          {{ permission.display_name }}
        </div>
        <div class="row">
          <div
            class="card-body col-md-3"
            v-for="(val, index) in permission.permissions_children"
            :key="index"
          >
            <h5 class="card-title">
              <label for="">
                <input
                  class="checkbox_children"
                  type="checkbox"
                  v-model="checkedPermission[val.id]"
                  :value="val.id"
                  @change.prevent="checkPermission($event, val.id)"
                />
              </label>
              {{ val.display_name }}
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: {
    permissions: {
      type: Array,
      default() {
        return [];
      },
    },
    role_permission: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  methods: {
    checkPermission($event, id) {
      let acestorLvl = 5;
      let cousinCheckBox = [
        ...this.getAcestor($event.target, acestorLvl).getElementsByClassName(
          "checkbox_children"
        ),
      ];
      let checkbox_wrapper = this.getAcestor(
        $event.target,
        acestorLvl
      ).getElementsByClassName("checkbox_wrapper")[0];
      if ($event.target.checked == true) {
        if (
          cousinCheckBox.filter((e) => e.checked == true).length ==
          cousinCheckBox.length
        ) {
          checkbox_wrapper.checked = true;
        }
      } else {
        checkbox_wrapper.checked = false;
      }

      this.$emit("check-permisstion", id);
    },
    checkAll($event) {
      let allCheck = $event.target.checked;
      [
        ...this.getAcestor($event.target, 3).getElementsByClassName(
          "checkbox_children"
        ),
      ].forEach((e) => {
        this.$emit(
          allCheck ? "check-all-permisstion" : "remove-all-permisstion",
          e.value - 0
        );
        e.checked = allCheck;
      });
    },
    getAcestor(target, acesstor_lvl) {
      if (acesstor_lvl == 0) {
        return target;
      }
      return this.getAcestor(target.parentElement, acesstor_lvl - 1);
    },
    setCheckWrapper() {
      let check_all = [...document.getElementsByClassName("checkbox_wrapper")];

      check_all.forEach((e) => {
        let checkbox_children = [
          ...this.getAcestor(e, 3).getElementsByClassName("checkbox_children"),
        ];

        if (
          checkbox_children.filter((e) => e.checked == true).length ==
          checkbox_children.length
        ) {
          e.checked = true;
        }
      });
    },
  },
  computed: {
    checkedPermission() {
      let result = {};
      this.permissions.map((value) => {
        return value.permissions_children.forEach((value) => {
          result[value.id] = this.role_permission.indexOf(value.id) != -1;
        });
      });
      return result;
    },
  },
  mounted() {
    this.setCheckWrapper();
  },
};
</script>

<style scoped>
.card-header {
  background-color: aquamarine;
}
</style>
