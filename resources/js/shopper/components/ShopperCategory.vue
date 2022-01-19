<template>
  <div>
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian">
      <!--category-productsr-->
      <!-- :href="`#${item.id}`"-->
      <div
        class="panel panel-default"
        v-for="(item, index) in categories"
        :key="index"
      >
        <div class="panel-heading">
          <h4 class="panel-title">
            <a
              :data-toggle="panelData(item)['data-toggle']"
              data-parent="#accordian"
              :href="getParentHref(item)"
            >
              <span
                v-if="item.categories_children.length > 0"
                class="badge pull-right"
                ><i class="fa fa-plus"></i
              ></span>
              {{ item.name }}
            </a>
          </h4>
        </div>
        <div
          v-if="item.categories_children.length > 0"
          :id="item.id"
          class="panel-collapse collapse"
        >
          <div class="panel-body">
            <ul>
              <li
                v-for="(child, child_index) in item.categories_children"
                :key="child_index"
              >
                <a :href="getCategoryRoute(child.slug, child.id)"
                  >{{ child.name }}
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    categories: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  mounted() {
    // console.log(this.categories);
    // console.log(laroute.route("shopper.category"));
  },
  computed: {
    genHrefPanel(id) {
      return `#${id}`;
    },
    getCategoryRoute() {
      return function (slug, id) {
        return laroute.route("shopper.category", { slug: slug, id: id });
      };
    },
    getParentHref() {
      return function (item) {
        if (item.categories_children.length > 0) {
          return `#${item.id}`;
        }
        return laroute.route("shopper.category", {
          slug: item.slug,
          id: item.id,
        });
      };
    },
    panelData() {
      return function (item) {
        if (item.categories_children.length > 0) {
          return {
            "data-toggle": "collapse",
            "data-parent": "#accordian",
          };
        }
        return {
          "data-toggle": "",
          " data-parent": "",
        };
      };
    },
  },
};
</script>

<style>
</style>
