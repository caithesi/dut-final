<template>
  <div>
    <nav-bar />
    <main-side-bar />

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- /.content-header -->
      <content-header :headerPage="headerPage" />
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <slot></slot>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <control-side-bar />
    <custom-footer />
  </div>
</template>

<script>
import ContentHeader from "../rare_components/ContentHeader.vue";
import ControlSideBar from "../rare_components/ControlSideBar.vue";
import CustomFooter from "../rare_components/CustomFooter.vue";
import MainSideBar from "../rare_components/MainSideBar.vue";
import NavBar from "../rare_components/NavBar.vue";
export default {
  components: {
    ContentHeader,
    ControlSideBar,
    CustomFooter,
    MainSideBar,
    NavBar,
  },
  props: {
    headerPage: {},
  },
};
</script>

<style>
</style>
