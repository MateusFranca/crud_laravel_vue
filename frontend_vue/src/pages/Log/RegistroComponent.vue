<template>
  <div class="container mt-5">
    <h2>Criar Conta</h2>
    <form @submit.prevent="criarConta">

      <Alerta v-if="mensagem.texto" :tipo="mensagem.tipo" :mensagem="mensagem.texto"></Alerta>
      
      <div class="form-group">
        <Input titulo="Nome" :id="'inputRegistroNome'" id-ajuda="nomeRegistroAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
          <input type="text" v-model="nome" class="form-control" id="inputRegistroNome" aria-describedby="nomeRegistroAjuda" placeholder="Nome do cliente" required>
        </Input>
      </div>

      <div class="form-group">
        <Input titulo="Email" :id="'inputRegistroEmail'" id-ajuda="emailRegistroAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
          <input v-model="email" type="email" class="form-control" id="inputRegistroEmail" aria-describedby="emailRegistroAjuda" placeholder="Email" required>
        </Input>
      </div>

      <div class="form-group">
        <Input titulo="Senha" :id="'inputRegistroSenha'" id-ajuda="emailRegistroSenhaAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
          <input v-model="senha" type="password" class="form-control" id="inputRegistroSenha" aria-describedby="emailRegistroSenhaAjuda" placeholder="senha" required>
        </Input>
      </div>

      <div class="form-group">
        <Input titulo="Confirmar Senha" :id="'inputRegistroNovaSenha'" id-ajuda="emailRegistroNovaSenhaAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
          <input v-model="confirmarSenha" type="password" class="form-control" id="inputRegistroNovaSenha" aria-describedby="emailRegistroNovaSenhaAjuda" placeholder="senha" required>
        </Input>
      </div>
      
      <button type="submit" class="btn btn-primary">Registrar</button>
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
      nome: '',
      email: '',
      senha: '',
      confirmarSenha: '',
      mensagem: {
        tipo: null,
        texto: null,
      },
    };
  },
  methods: {
    criarConta() {
      if (this.senha !== this.confirmarSenha) {
        return this.mensagem = { tipo: 'danger', texto: 'As senhas não coincidem.' };
      }

      axios.post('http://127.0.0.1:8000/api/register', {
        name: this.nome,
        email: this.email,
        password: this.senha
      })
        .then(response => {
          localStorage.setItem('token', response.data.token);
          this.mensagem = { tipo: 'success', texto: 'Os dados foram cadastrados com sucesso!' };
          setTimeout(() => {
            this.$router.push({ name: 'Login' });
          }, 2000);
        })
        .catch(error => {
          if (error.response) {
          this.mensagem = { tipo: 'danger', texto: 'E-mail já cadastrado. Verifique e tente novamente.' };
          }
        });
    }
  }
};
</script>
