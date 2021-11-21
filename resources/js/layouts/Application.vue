<template>
  <div >
    <nav-bar />
    <main-side-bar />

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- /.content-header -->
      <content-header />
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <slot />
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
import NavBar from "../components/NavBar.vue";
import MainSideBar from "../components/MainSideBar.vue";
import ControlSideBar from "../components/ControlSideBar.vue";
import CustomFooter from "../components/CustomFooter.vue";
import ContentHeader from "../components/ContentHeader.vue";
export default {
  components: {
    NavBar,
    MainSideBar,
    ControlSideBar,
    CustomFooter,
    ContentHeader,
  },
};
</script>

<style>
</style>
