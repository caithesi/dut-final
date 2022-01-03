<template>
  <form>
    <div class="form-group">
      <label :for="id">{{ computedLabel }}</label>
      <input
        type="file"
        class="form-control-file"
        :id="id"
        :placeholder="placeHoder"
        :accept="fileAccept"
        @change="onChangeFileUpload($event)"
      />
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: {
    id: {
      type: String,
    },
    label: {
      type: String,
    },
    fileAccept: {
      type: String,
      default() {
        return "*";
      },
    },
    multiple: {
      type: String,
      default() {
        return "";
      },
    },
    errorName: {
      type: Boolean,
    },
    errorData: {
      type: String,
    },
  },
  computed: {
    placeHoder() {
      return `Enter ${this.computedLabel}`;
    },
    computedLabel() {
      if (!this.label == null) {
        return this.label;
      }
      let tmpResult = this.id
        .match(/([A-Z]?[^A-Z]*)/g)
        .slice(0, -1)
        .join(" ");
      return tmpResult.charAt(0).toUpperCase() + tmpResult.slice(1);
    },
  },
  methods: {
    onChangeFileUpload($event) {
      this.$emit("change-file-input", $event.target.files[0]);
    },
  },
};
</script>

<style>
</style>
