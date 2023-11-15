<template>
  <q-layout>
    <q-page-container>
        <!-- bg-image  -->
      <q-page class="flex flex-center wait_me" style="background: #ddd;">
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
                v-model="user.identity"
                label="Email/Username"
                lazy-rules
                type="text"
                :rules="[val => val && val.length > 0 || 'Please enter email/username']"
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
import helperMixin from 'src/mixins/helper_mixin.js'
import {defineComponent} from 'vue'
import {ref} from 'vue'

import { computed } from 'vue';
import { useAuthStore } from 'src/stores/auth-store.js';
import { storeToRefs } from 'pinia';

const metaData = {
  // sets document title
  title: 'Login Page',
  // optional; sets final title as "Login Page - nventory App", useful for multiple level meta
  titleTemplate: title => `${title} - Inventory App`,
}


export default defineComponent({
  name: 'UserLogin',
  mixins: [helperMixin],
  data(){
    return{
        user: {
          identity: '',
          password: ''
        },
        authStore: {},
    }
  },
  created: function () {
    var api_token = localStorage.getItem('api_token');

    if(api_token){
      this.$router.replace('/');
    }
  },
  methods: {
    submitData: async function  (){
        let ref = this;
        let jq = ref.jq();

        try {
            ref.wait_me(".wait_me");
            let res = await jq.post(ref.apiUrl('api/v1/admin/sign_in'), this.user);
            this.notify(res.msg)

            const store = useAuthStore()
            store.authUser = res.data.auth_user
            store.userPermissions = res.data.user_permissions
            console.log('store.authUser', store.authUser)
            console.log('store.permission_disable', store.permission_disable)

            localStorage.setItem('api_token', res.data.api_token);
            localStorage.setItem('auth_user_id', res.data.auth_user.id);

            this.$router.replace(sessionStorage.getItem('redirectPath') || '/')
            sessionStorage.removeItem('redirectPath')

        } catch (err) {
            this.notify(this.err_msg(err), 'negative')
        } finally{
            ref.wait_me(".wait_me", "hide");
        }
    }
  },
  setup () {
    useMeta(metaData)
    const store = useAuthStore();
    const permission_disable = computed(() => store.permission_disable);
    // const email = ref(null)
    // const password = ref(null)

    return {
      // email,
      // password,
      store,
      permission_disable
    }

  }
})
</script>

<style>

.bg-image {
  background-image: linear-gradient(135deg, #7028e4 0%, #e5b2ca 100%);
}
</style>
