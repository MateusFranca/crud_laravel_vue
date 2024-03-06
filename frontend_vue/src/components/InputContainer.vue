<template>
  <div class="form-group">
    <label :for="id" class="form-label text-black">{{ titulo }}</label>
    <slot></slot>
    <div :id="idAjuda" class="form-text <!--text-white-->">{{ obrigatorio ? `O preenchimento do campo ${titulo} é obrigatório.` : textoAjuda }}</div>
  </div>
</template>

<script>

export default {
  props: {
    id: String,
    titulo: String,
    idAjuda: String,
    textoAjuda: String,
    obrigatorio: Boolean,
  }
}
</script>
