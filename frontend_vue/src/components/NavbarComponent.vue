<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <router-link :to="{ name: 'Clientes' }" class="navbar-brand">LARAVEL / VUE.JS</router-link>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">

          <div class="dropdown ml-2" v-if="token">
            <a class="navbar-brand dropdown-toggle" data-toggle="dropdown" href="#">Clientes</a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <router-link :to="{ name: 'ClienteAdicionar' }" class="dropdown-item">Adicionar Cliente</router-link>
              <router-link :to="{ name: 'Clientes' }" class="dropdown-item">Listar Clientes</router-link>
            </div>
          </div>
        </ul>
        
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              User
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <router-link v-if="!token" :to="{ name: 'Login' }" class="dropdown-item">Login</router-link>
              <router-link v-if="!token" :to="{ name: 'Registro' }" class="dropdown-item">Registrar</router-link>
              <button v-if="token" @click="logout" class="btn btn-link dropdown-item">Sair</button>
            </div>
          </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    token() {
      return localStorage.getItem('token');
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('token');
      this.$router.push({ name: 'Login' });

      location.reload(true);
    }
  }
};
</script>