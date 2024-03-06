<template>
  <div class="modal fade custom-modal" :id="id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{titulo}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            
          </div>
          <div class="modal-body">
            <slot name="alertas"></slot>
            <slot name="conteudo"></slot>
            <slot name="detalhes"></slot>
          </div>

          <div class="modal-footer">
            <slot name="rodape"></slot>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  props: {
    id: String,
    titulo: String,
    detalhesCliente: Object
  },
};
</script>

<!--
<style scoped>
  .custom-modal .modal-content {
    background-color: #343a40;
    color: #ffffff;
  }

  .custom-modal .close{
    color: #ffffff;
  }
</style>
-->