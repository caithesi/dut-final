<template>
  <table class="table">
    <thead>
      <tr>
        <th scope="col" v-for="(value, key) in headData" :key="key">
          {{ value }}
        </th>
      </tr>
    </thead>
    <tbody class="custom-table-body">
      <tr v-for="(value, key) in tableData" :key="key">
        <th scope="row">{{ value.id }}</th>

        <td
          v-for="(value_loop, key_loop) in getLoopDataExceptPrimaryValue"
          :key="key_loop"
        >
          <slot :value="value" :value_loop="value_loop">
            {{ value[value_loop] }}
          </slot>
        </td>
        <td>
          <a
            @click.prevent.stop="$emit('edit-item', value.id)"
            class="btn btn-default"
            >Edit</a
          >
          <a
            @click.prevent.stop="$emit('delete-item', value.id)"
            class="btn btn-danger"
            >Delete</a
          >
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import TdTable from "./TdTable.vue";
export default {
  components: { TdTable },
  props: {
    primaryValue: {
      type: String,
      default() {
        return "id";
      },
    },
    headData: {
      type: Array,
      default() {
        return [];
      },
    },
    loopData: {
      type: Array,
      default() {
        return [];
      },
    },
    tableData: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  computed: {
    getLoopDataExceptPrimaryValue() {
      return this.loopData.filter((data) => data != this.primaryValue);
    },
  },
};
</script>

<style scoped>
</style>
