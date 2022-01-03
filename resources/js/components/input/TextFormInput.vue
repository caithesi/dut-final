<template>
  <div class="form-group">
    <label :for="id">{{ computedLabel }}</label>
    <input
      type="text"
      class="form-control"
      :id="id"
      :placeholder="placeHoder"
      v-model="contentData"
      @change="changeInput"
    />
    <div class="text-danger" v-if="errorName">
      {{ errorData }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contentData: this.formdata,
    };
  },
  props: {
    id: {
      type: String,
    },
    label: {
      type: String,
    },
    formdata: {
      type: String,
    },
    defaultText: {
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
    changeInput() {
      this.$emit("change-input", this.contentData);
    },
  },
};
</script>

<style>
</style>
