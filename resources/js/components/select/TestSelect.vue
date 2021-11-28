<template>
  <div class="form-group">
    <multiselect
      v-model="selected"
      :options="options"
      label="display_name"
      track-by="id"
      @input="testSelectParent"
      @select="onSelect"
    >
    </multiselect>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

function createParentObjects() {
  let result = [];
  function recursiveParent(parentId, prefix) {
    this.parentData.forEach((element) => {
      if (element.parent_id !== parentId) {
        return;
      }
      element["display_name"] = prefix + element.name;
      result.push(element);
      recursiveParent.call(this, element.id, prefix + "--");
    });
  }

  recursiveParent.call(this, 0, "");
  return result;
}

export default {
  data() {
    return {
      selected: [],
      options: createParentObjects.call(this),
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
  computed: {},
  components: {
    Multiselect,
  },
  methods: {
    testSelectParent() {
      console.log(this.selected);
      this.$emit("test-select-parent", this.selected);
    },
    onSelect() {
      console.log(this.selected);
    },
  },
};
</script>

<style scoped>
* {
  font-family: "Lato", "Avenir", sans-serif;
}
.multiselect_input {
  width: 100% !important;
}
</style>

