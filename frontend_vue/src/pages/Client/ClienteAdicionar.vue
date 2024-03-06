<template>
  <div class="container mt-5">
    <h2>Adicionar Cliente</h2>
    <form @submit.prevent="adicionarCliente">

      <Alerta v-if="mensagem.texto" :tipo="mensagem.tipo" :mensagem="mensagem.texto"></Alerta>

      <Input titulo="Nome" :id="'inputNome'" id-ajuda="nomeAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
        <input type="text" v-model="nome" class="form-control" id="inputNome" aria-describedby="nomeAjuda" placeholder="Nome do cliente" required>
      </Input>
    
      <Input titulo="Email" :id="'inputEmail'" id-ajuda="emailAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
        <input v-model="email" type="email" class="form-control" id="inputEmail" aria-describedby="emailAjuda" placeholder="Email" required>
      </Input>

      <Input titulo="Telefone" :id="'inputTelefone'" id-ajuda="telefoneAjuda" texto-ajuda="Obrigratorio. Informe um número de telefone de cliente">
        <input v-model="telefone" type="tel" class="form-control" id="inputTelefone" aria-describedby="telefoneAjuda" placeholder="Telefone" required>
      </Input>

      <Input titulo="Sexo" :id="'inputSexo'" id-ajuda="sexoAjuda" texto-ajuda="Obrigratorio. Informe o sexo do cliente">
        <input v-model="sexo" type="text" class="form-control" id="inputSexo" aria-describedby="sexoAjuda" placeholder="Sexo" required>
      </Input>

      <Input titulo="Foto" :id="'inputFoto'" id-ajuda="fotoAjuda" texto-ajuda="Foto no formato PNG, JPE ou SVG">
        <input accept="image/*" @change="handleFileChange" type="file" class="form-control-file" id="inputFoto" aria-describedby="fotoAjuda" required>
      </Input>


      <button type="submit" class="btn btn-primary">Adicionar</button>
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
      telefone: '',
      sexo: '',
      foto: null,
      mensagem: {
        tipo: null,
        texto: null,
      },
    };
  },
  methods: {
    handleFileChange(event) {
      this.foto = event.target.files[0];
    },
    adicionarCliente() {
      let formData = new FormData();
      formData.append('nome', this.nome);
      formData.append('email', this.email);
      formData.append('telefone', this.telefone);
      formData.append('sexo', this.sexo);
      formData.append('foto', this.foto);

      axios.post('clientes', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      })
      .then(() => {
        this.mensagem = { tipo: 'success', texto: 'Cliente adicionado com sucesso!' };
        setTimeout(() => {
          this.$router.push({ name: 'Clientes' });
        }, 2000);
      })
      .catch(error => {
        this.mensagem = { tipo: 'danger', texto: 'Ocorreu um erro ao salvar as alterações.' };
        console.error(error);
        });
      }
    }
  };
</script>