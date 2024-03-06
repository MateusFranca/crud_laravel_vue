<template>
  <div class="container mt-5">
    <h2 class="mb-4">Login</h2>
    <form @submit.prevent="login">
      <Alerta v-if="mensagem.texto" :tipo="mensagem.tipo" :mensagem="mensagem.texto"></Alerta>
      
      <div class="form-group mb-3">
        <Input titulo="Email" :id="'inputLoginEmail'" id-ajuda="emailLoginAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
          <input v-model="email" type="email" class="form-control" id="inputLoginEmail" aria-describedby="emailLoginAjuda" placeholder="Email" required>
        </Input>
      </div>

      <div class="form-group mb-3">
        <Input titulo="Senha" :id="'inputLoginSenha'" id-ajuda="emailLoginSenhaAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
          <input v-model="password" type="password" class="form-control" id="inputLoginSenha" aria-describedby="emailLoginSenhaAjuda" placeholder="senha" required>
        </Input>
      </div>

      <button type="submit" class="btn btn-primary mb-3">Entrar</button>

      <div class="form-group mb-4">
        <p class="m-0">Não tem uma Conta? <router-link to="/registro" class="btn btn-link p-0">Cadastre-se</router-link></p>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Input from '../../components/InputContainer.vue';
import Alerta from "../../components/AlertaComponente.vue";

export default {
  components: { Input, Alerta },
  data() {
    return {
      email: '',
      password: '',
      mensagem: {
        tipo: null,
        texto: null,
      },
    };
  },
  methods: {
    login() {
      axios.post('http://127.0.0.1:8000/api/login', {
        email: this.email,
        password: this.password
      })
      .then(response => {
        const token = response.token;
        console.log('Token recebido:', token);
        localStorage.setItem('token', token);
        this.mensagem = { tipo: 'success', texto: 'Login realizado com sucesso!' };
        setTimeout(() => {
            this.$router.push({ name: 'Clientes' });
          }, 1000);
      })
      .catch(error => {
        if (error.response.status === 401) {
        this.mensagem = { tipo: 'danger', texto: 'E-mail ou senha inválidos. Verifique e tente novamente.' };
        } else {
            this.mensagem = { tipo: 'danger', texto: 'Ocorreu um erro ao fazer login.' };
        }
      });
    }
  }
};
</script>