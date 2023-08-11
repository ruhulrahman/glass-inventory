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
            <q-form
              class="q-gutter-md"
            >
              <q-input
                filled
                v-model="email"
                label="Email"
                lazy-rules
                type="email"
              />

              <q-input
                type="password"
                filled
                v-model="password"
                label="Password"
                lazy-rules

              />

              <div>
                <q-btn label="Login" style="float: right; margin-bottom: 10px;" @click="submitData" type="button" color="secondary"/>
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>

export default({
  data(){
    return{
        email: null,
        password: null
    }
  },
  methods:{
    submitData(){
        var ref = this
        if(ref.email != null && ref.password != null) ref.$router.push('/dashboard');
        else alert("Invalid Credentials!");
    }
  }
})
</script>

<style>

.bg-image {
  background-image: linear-gradient(135deg, #7028e4 0%, #e5b2ca 100%);
}
</style>
