
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@2.6.6/dist/quasar.umd.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        var ajax = axios.create({
            baseURL: '{{  url('/') }}'
        });

        var vueApp = {    
            setup () {
            return {}
            }
        }
    </script>
 @stack('scripts')

    <script>
      const app = Vue.createApp(vueApp)

      app.use(Quasar, {
        config: {
        }
      })
      app.mount('#q-app')
    </script>