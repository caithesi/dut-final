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
export default {
  props: {
    headerPage: {
      type: Object,
    },
  },
};
</script>

<style>
</style>
