<template>
  <div>
    <div :class="estilo" role="alert">
      {{ mensagem }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    mensagem: String,
    tipo: String,
  },
  computed: {
    estilo() {
      return 'alert alert-' + this.tipo;
    },
  },
};
</script>
