<template>
  <div class="form-group">
    <label for="">{{ labelSelect }}</label>

    <select
      ref="parent-select"
      class="form-select form-control"
      aria-label="Default select example"
      v-model="selected"
      @change="selectParent"
    ></select>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

function createParentOption(value, text) {
  const optEle = document.createElement("option");
  optEle.setAttribute("value", value);
  optEle.innerText = text;

  if (this.childParentId == value) {
    optEle.setAttribute("selected", "selected");
  }

  return optEle;
}

function createRecursiveParent(parentSelectElement) {
  //default parent
  parentSelectElement.appendChild(
    createParentOption.call(this, 0, this.labelSelect)
  );

  function recursiveParent(parentId, prefix) {
    this.parentData.forEach((element) => {
      if (element.parent_id !== parentId) {
        return;
      }
      parentSelectElement.appendChild(
        createParentOption.call(this, element.id, prefix + element.name)
      );
      recursiveParent.call(this, element.id, prefix + "--");
    });
  }

  return recursiveParent.bind(this);
}

export default {
  data() {
    return {
      selected: "",
    };
  },
  props: {
    parentData: {
      type: Array,
    },
    labelSelect: {
      type: String,
      default() {
        return "Select parent id";
      },
    },
    childParentId: {
      type: Number,
      default() {
        return 0;
      },
    },
  },
  computed: {
    parentRecursive() {},
  },
  mounted() {
    createRecursiveParent.call(this, this.$refs["parent-select"])(0, "");
  },
  methods: {
    selectParent() {
      this.$emit("select-parent", this.selected);
    },
  },
  components: {
    Multiselect,
  },
};
</script>

<style>
</style>
