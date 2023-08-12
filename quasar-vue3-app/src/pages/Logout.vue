<template>
  <q-page class="q-pa-sm">

    <div class="container">
        <div class="row">
          <div class="col">
            <h3 class="text-center text-primary">
              Logging Out...
            </h3>
          </div>
        </div>
      </div>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import helperMixin from '../mixins/helper_mixin.js'

export default defineComponent({
  name: 'Logout',
  mixins: [helperMixin],
  components: {
  },
  created () {
    this.logOut()
  },
  methods: {
    logOut: async function  (){
        let ref = this;
        let jq = ref.jq();

        try {
            let res = await jq.post(ref.apiUrl('api/v1/admin/logout'));
            this.notify(res.msg)

            ref.$router.push('/login')

        } catch (err) {
            this.notify(this.err_msg(err), 'negative')
        }
    }
  },

})
</script>
