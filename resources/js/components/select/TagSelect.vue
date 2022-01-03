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

export default {};
</script>

<style>
</style>
