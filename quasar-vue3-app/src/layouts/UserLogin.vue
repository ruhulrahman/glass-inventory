<template>
  <q-layout>
    <q-page-container>
        <!-- bg-image  -->
      <q-page class="flex flex-center" style="background: #ddd;">
        <q-card class="" v-bind:style="$q.screen.lt.sm?{'width': '80%'}:{'width':'30%'}">
          <q-card-section>
            <q-avatar size="103px" class="absolute-center shadow-10">
              <img src="profile.svg">
            </q-avatar>
          </q-card-section>
          <q-card-section>
            <div class="text-center q-pt-lg">
              <div class="col text-h6 ellipsis">
                Log in
              </div>
            </div>
          </q-card-section>
          <q-card-section>
            <q-form @submit="submitData" class="q-gutter-md">
              <q-input
                rounded
                standout="bg-teal text-white"
                v-model="user.email"
                label="Email"
                lazy-rules
                type="email"
                :rules="[val => val && val.length > 0 || 'Please enter email']"
                spellcheck="false"
                autocapitalize="off"
                autocorrect="off"
              />

              <q-input
                rounded
                standout="bg-teal text-white"
                type="password"
                v-model="user.password"
                label="Password"
                lazy-rules
                :rules="[val => val && val.length > 0 || 'Please enter password']"
              />

              <div>
                <q-btn type="submit" label="Login" style="float: right; margin-bottom: 10px;" class="bg-teal" color="secondary"/>
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { useMeta, useQuasar, createMetaMixin } from 'quasar'
import { ref } from 'vue'
import helperMixin from '../mixins/helper_mixin.js'
// Vue.mixin(helperMixin);

const metaData = {
  // sets document title
  title: 'Login Page',
  // optional; sets final title as "Login Page - nventory App", useful for multiple level meta
  titleTemplate: title => `${title} - Inventory App`,
}

const $q = useQuasar()

export default({
  // mixins: [
  //   createMetaMixin({ helperMixin })
  // ],
  mixins: [helperMixin],
  data(){
    return{
        user: {
          email: null,
          password: null
        }
    }
  },
  created: function () {
        // this.setup_urls();
  },
  methods: {
    async submitData (){
          let ref = this;
          let jq = ref.jq();

          try {
              // ref.wait_me(".wait_me_ladder_users");
              let res = await jq.post(ref.apiUrl('api/v1/admin/sign_in'), this.user);
              Swal.fire({
                  // position: 'top-end',
                  icon: 'success',
                  title: res.msg,
                  showConfirmButton: false,
                  timer: 1500
              })

              // this.$emit('getBankInfos');
              // this.ladderUserListShow = true
              // this.getLadderUsersData();
          } catch (err) {
              ref.alert(ref.err_msg(err), "error");
          } finally{
              // ref.wait_me(".wait_me_ladder_users", "hide");
          }

          // $q.notify({
          //     type: 'positive',
          //     message: 'Login has been successfull.'
          //   })
          //   this.$router.push('/dashboard')
          // } else {
          //   $q.notify({
          //     type: 'negative',
          //     message: 'This is a "negative" type notification.'
          //   })
          // }
      }
  },
  setup () {
    useMeta(metaData)

    // const email = ref(null)
    // const password = ref(null)

    // return {
    //   email,
    //   password,
    // }

  }
})
</script>

<style>

.bg-image {
  background-image: linear-gradient(135deg, #7028e4 0%, #e5b2ca 100%);
}
</style>
