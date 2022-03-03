<template>
  <div id="search-area">
    <div class="search_box pull-right">
      <input
        type="text"
        placeholder="Search"
        v-model="searchText"
        @input="search()"
        id="search-input"
      />
    </div>
    <div id="searchResult-container">
      <ul id="searchResult"></ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      searchText: "",
    };
  },
  methods: {
    async search() {
      const search_result = document.getElementById("searchResult");

      while (search_result.lastElementChild) {
        search_result.removeChild(search_result.lastElementChild);
      }
      if (this.searchText.length == 0) {
        return;
      }
      axios
        .get(laroute.route("search.product", { name: this.searchText }))
        .then((response) => {
          console.log(response.data.length);
          return response.data;
        })
        .then((data) =>
          data.forEach((element) => {
            search_result.appendChild(this.createSearchResult(element));
          })
        );
    },
    createSearchResult(data) {
      // Create an "li" node:
      const node = document.createElement("li");
      node.style.width = "100%";
      // Append the text node to the "li" node:
      node.appendChild(this.createHref(data));
      return node;
    },
    createHref(data) {
      const node = document.createElement("a");
      // Create a text node:
      const textnode = document.createTextNode(data.name);
      node.style.width = "100%";
      node.style.color = "white";
      node.style.background = "black";
      node.style.opacity = "0.7";

      node.setAttribute(
        "href",
        laroute.route("shop.product.show", { product: data.id })
      );
      node.appendChild(textnode);

      return node;
    },
    clearText(ele) {
      ele.innerHTML = "";
    },
  },
};
</script>

<style scoped>
#searchResult-container {
  position: absolute;
  z-index: 9999;
  top: 32px;
}
.search_box.pull-right {
  display: block;
}
#searchResult {
  background: black;
  color: white;
  opacity: 0.7;
  width: 100%;
  padding: 0px 20px;
}
#search-input {
  color: black;
}
.search-result-li {
  width: 100%;
}
.search-result-li a {
  width: 100%;
  background: black;
  color: white;
  opacity: 0.7;
}
#li-test {
  width: 100%;
}
#search-area li {
  width: 100%;
}
</style>
