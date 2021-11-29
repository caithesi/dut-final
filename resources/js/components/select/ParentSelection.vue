<template>
  <div class="form-group">
    <label>{{ labelSelect }}</label>
    <multiselect
      v-model="selected"
      :options="options"
      label="display_name"
      :track-by="trackBy"
      @input="selectParent"
      :placeholder="labelSelect"
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
      selected: null,
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
    trackBy: {
      type: String,
      default() {
        return "id";
      },
    },
  },
  computed: {},
  components: {
    Multiselect,
  },
  methods: {
    selectParent() {
      this.$emit(
        "select-parent",
        this.selected === null ? 0 : this.selected.id
      );
    },
  },
  mounted() {
    this.selected = this.options.find(
      (option) => option.id === this.childParentId
    );
  },
};
</script>

<style scoped>
</style>

