<script>
const { useQuasar } = Quasar
const { createApp, ref } = Vue

const app = Vue.createApp({
  setup (props, { refs }) {
    const $q = useQuasar()

    return {
    }
  }
})

app.use(Quasar, { config: {} })
app.mount('#q-app')
</script>