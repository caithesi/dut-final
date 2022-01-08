<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img
        :src="'/admin/dist/img/AdminLTELogo.png'"
        alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            :src="'/admin/dist/img/user2-160x160.jpg'"
            class="img-circle elevation-2"
            alt="User Image"
          />
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input
            class="form-control form-control-sidebar"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item" v-for="(value, key) in adminRoutes" :key="key">
            <a :href="value.index" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                {{ value.text }}
                <span class="right badge badge-danger">{{ value.symbol }}</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
export default {
  data() {
    return {
      adminRoutes: {
        category: {
          index: laroute.route("category.index"),
          text: "Category",
          symbol: "New",
        },
        menu: {
          index: laroute.route("menu.index"),
          text: "Menu",
          symbol: "New",
        },
        product: {
          index: laroute.route("product.index"),
          text: "Product",
          symbol: "New",
        },
        slider: {
          index: laroute.route("slider.index"),
          text: "Slider",
          symbol: "New",
        },
        setting: {
          index: laroute.route("setting.index"),
          text: "Setting",
        },
        emplyee: {
          index: laroute.route("user.index"),
          text: "User",
        },
      },
    };
  },
};
</script>

<style>
</style>
