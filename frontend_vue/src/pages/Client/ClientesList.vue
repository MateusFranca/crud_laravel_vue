<template>
  <div class="container mt-5">
    <h2>Lista de Clientes</h2>
    <table class="table table-striped table-hover">
      <thead class="text-center">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Telefone</th>
          <th>Sexo</th>
          <th>Foto</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr v-for="cliente in clientes" :key="cliente.id">
          <td>{{ cliente.id }}</td>
          <td>{{ cliente.nome }}</td>
          <td>{{ cliente.email }}</td>
          <td>{{ cliente.telefone }}</td>
          <td>{{ cliente.sexo }}</td>
          <td>
            <img v-if="cliente.foto" :src="'http://127.0.0.1:8000/' + cliente.foto" alt="Foto do Cliente" width="50" height="50">
          </td>
          <td>
            <div class="btn-group" role="group">
              <button @click="abrirModalEditar(cliente)" data-toggle="modal" data-target="#modalEditar" class="btn btn-primary">Editar</button>
              <button @click="abrirModalExcluir(cliente)" data-toggle="modal" data-target="#modalExcluir" class="btn btn-danger mx-2">Excluir</button>
              <button class="btn btn-secondary" data-toggle="modal" data-target="#modalDetalhes" @click="exibirDetalhes(cliente)">Detalhes</button>
          </div>
          </td>
        </tr>
      </tbody>
    </table>

    <!--  MODAL DE EDIÇÃO  -->

    <ModalComponent v-if="mostrarModalEditar" id="modalEditar" titulo="Editar Cliente">
      <template v-slot:conteudo>

        <Alerta v-if="mensagem.texto" :tipo="mensagem.tipo" :mensagem="mensagem.texto">
          <template v-slot:alertas>
            {{ mensagem.texto }}
          </template>
        </Alerta>
        
        <form  @submit.prevent="editarCliente" enctype="multipart/form-data">

          <div class="form-group">
            <Input titulo="Nome" :id="'novoNome'" id-ajuda="novoNomeAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
              <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeAjuda" placeholder="Novo nome" v-model="cliente.nome"/>
            </Input>
          </div>

          <div class="form-group">
            <Input titulo="Email" :id="'novoEmail'" id-ajuda="novoEmailAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
              <input type="email" class="form-control" id="novoEmail" aria-describedby="novoEmailAjuda" placeholder="Novo Email" v-model="cliente.email"/>
            </Input>
          </div>

          <div class="form-group">
            <Input titulo="Telefone" :id="'inputTelefone'" id-ajuda="telefoneAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
              <input v-model="cliente.telefone" type="tel" class="form-control" id="inputTelefone" aria-describedby="telefoneAjuda" placeholder="Telefone" required>
            </Input>
          </div>

          <div class="form-group">
            <Input titulo="Sexo" :id="'inputSexo'" id-ajuda="sexoAjuda" texto-ajuda="O preenchimento deste campo é obrigatório." :obrigatorio="true">
              <input v-model="cliente.sexo" type="text" class="form-control" id="inputSexo" aria-describedby="sexoAjuda" placeholder="Sexo" required>
            </Input>
          </div>

          <div class="form-group">
            <Input titulo="Foto" :id="'novoFoto'" id-ajuda="novoFotoAjuda" texto-ajuda="Foto no formato PNG, JPE ou SVG">
                <input accept="image/*" @change="handleFileChangeEdicao" type="file" class="form-control-file" id="novoFoto" aria-describedby="novoFotoAjuda">
            </Input>
          </div>

        </form>
      </template>

      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="fecharModalEditar">Fechar</button>
        <button type="button" class="btn btn-primary" @click="editarCliente">Salvar</button>
      </template>

    </ModalComponent>

   <!-- MODAL DE EXCLUSÃO -->
  <ModalComponent v-if="mostrarModalExcluir" id="modalExcluir" titulo="Excluir Cliente">
    <template v-slot:conteudo>
      <Alerta v-if="mensagem.texto" :tipo="mensagem.tipo" :mensagem="mensagem.texto">
        <template v-slot:alertas>
          {{ mensagem.texto }}
        </template>
      </Alerta>
      <p><strong>Nome:</strong> {{clienteParaExcluir.nome}}</p>
      <p><strong>Email:</strong> {{clienteParaExcluir.email}}</p>
      <p><strong>Telefone:</strong> {{clienteParaExcluir.telefone}}</p>
      <p><strong>Sexo:</strong> {{clienteParaExcluir.sexo}}</p>
      <p><strong>Foto:</strong></p>
        <img :src="'http://127.0.0.1:8000/' + clienteParaExcluir.foto" alt="Foto do Cliente" width="100" height="100">
    </template>
    <template v-slot:rodape>
      <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="fecharModalExcluir">Cancelar</button>
      <button type="button" class="btn btn-danger" @click="confirmarExclusao">Excluir</button>
    </template>
  </ModalComponent>

  <!--  MODAL DE DETALHES -->

  <ModalComponent v-if="mostrarModalDetalhes" id="modalDetalhes" titulo="Detalhes do Cliente">
    <template v-slot:detalhes>
      <p><strong>Nome:</strong> {{clienteParaDetalhes.nome}}</p>
      <p><strong>Email:</strong> {{clienteParaDetalhes.email}}</p>
      <p><strong>Telefone:</strong> {{clienteParaDetalhes.telefone}}</p>
      <p><strong>Sexo:</strong> {{clienteParaDetalhes.sexo}}</p>
      <p><strong>Foto:</strong></p>
        <img :src="'http://127.0.0.1:8000/' + clienteParaDetalhes.foto" alt="Foto do Cliente" width="100" height="100">
    </template>

    <template v-slot:rodape>
      <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="fecharModalDetalhes">Fechar</button>
    </template>

  </ModalComponent>

  </div>
</template>

<script>
import ModalComponent from "../../components/ModalComponent.vue";
import Input from "../../components/InputContainer.vue";
import Alerta from "../../components/AlertaComponente.vue";
import axios from 'axios';

export default {
  components: { ModalComponent, Alerta, Input },
  data() {
    return {
      clientes: [],
      cliente: {
        nome: '',
        email: '',
        telefone: '',
        sexo: '',
        foto: '',
      },
      mostrarModalEditar: false,
      mostrarModalExcluir: false,
      clienteParaExcluir: null,
      mostrarModalDetalhes: false,
      clienteParaDetalhes: null,
      mensagem: {
        tipo: null,
        texto: null,
      },
    };
  },
  mounted() {
    axios.get('/clientes')
    .then(response => {
      this.clientes = response.data;
    })
    .catch(error => {
      console.error(error);
      });
  },
  methods: {
    handleFileChangeEdicao(event) {
      this.cliente.foto = event.target.files[0];
    },
    confirmarExclusao() {
      const id = this.clienteParaExcluir.id;
        axios.delete(`clientes/${id}`)
          .then(() => {
            this.clientes = this.clientes.filter(cliente => cliente.id !== id);
            this.mensagem = { tipo: 'success', texto: 'Cliente excluído com sucesso!' }; 
            setTimeout(() => {
              this.fecharModalExcluir();
              window.location.reload();
            }, 1000);
          })
          .catch(error => {
            this.mensagem = { tipo: 'danger', texto: 'Erro ao excluir cliente' };
            console.error('Erro ao excluir cliente:', error);
          });
    },
    editarCliente() {
      const id = this.cliente.id;
      let formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('nome', this.cliente.nome);
      formData.append('email', this.cliente.email);
      formData.append('telefone', this.cliente.telefone);
      formData.append('sexo', this.cliente.sexo);
      formData.append('foto', this.cliente.foto);

      axios.post(`clientes/${id}`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      })
      .then(() => {
        this.mensagem = { tipo: 'success', texto: 'Alterações salvas com sucesso!' };
        setTimeout(() => {
          this.fecharModalEditar();
          window.location.reload();
        }, 1000);
      })
      .catch(error => {
        this.mensagem = { tipo: 'danger', texto: 'Ocorreu um erro ao salvar as alterações.' };
        console.error(error);
      });
    },
    abrirModalEditar(cliente) {
      this.cliente = { ...cliente };
      this.mostrarModalEditar = true;
    },
    fecharModalEditar() {
      this.mostrarModalEditar = false;
    },
    abrirModalExcluir(cliente) {
      this.clienteParaExcluir = { ...cliente };
      this.mostrarModalExcluir = true;
    },
    fecharModalExcluir() {
      this.mostrarModalExcluir = false;
    },
    fecharModalDetalhes() {
      this.mostrarModalDetalhes = false;
    },
    exibirDetalhes(cliente) {
      this.clienteParaDetalhes = { ...cliente };
      this.mostrarModalDetalhes = true;
    },
  },
};
</script>







