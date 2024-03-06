<template>
  <div id="app">
    <NavBar />
    <router-view></router-view>
  </div>
</template>

<script>
import NavBar from './components/NavbarComponent.vue';

export default {
  name: 'App',
  components: {
    NavBar,
  }
}
</script>

<style>

</style>
