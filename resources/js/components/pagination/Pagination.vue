<template>
  <!-- Pagination -->
  <nav>
    <ul class="pagination">
      <li v-for="(page, i) in links" :key="i" v-bind:class="pageClass(page)">
        <a
          class="page-link"
          :href="page.url"
          @click.prevent="changePage(page)"
          >{{ pageLabel(page) }}</a
        >
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  computed: {},
  methods: {
    pageClass(page) {
      if (page.active) return "page-item active";
      return "page-item";
    },
    pageLabel(page) {
      if (page.label == "Next &raquo;") return ">";
      if (page.label == "&laquo; Previous") return "<";
      return page.label;
    },
    changePage(page) {
      this.$emit("change-page", page.url);
    },
  },
  props: {
    current_page: {
      type: Number,
    },
    first_page_url: {
      type: String,
    },
    from: {
      type: Number,
    },
    last_page: {
      type: Number,
    },
    last_page_url: {
      type: String,
    },
    links: {
      type: Array,
    },
    next_page_url: {
      type: String,
    },
    prev_page_url: {
      type: String,
    },
  },
};
</script>

<style>
</style>
