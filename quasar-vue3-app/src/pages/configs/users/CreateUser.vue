<template>
      <q-card class="card-bg text-white no-shadow" bordered>
          <!-- <q-card-section class="text-h6 ">
            <div class="row">
            <div class="text-h6 col-10">Create New User</div>
            <div class="col-2">
                <q-icon name=""></q-icon>
            </div>
            </div>
          </q-card-section> -->
          <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label class="text-h6 text-weight-bolder" lines="1">{{title}}</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-icon name="cancel" color="white" clickable style="cursor: pointer;" @click="(()=>{$emit('closeModal', true)})"></q-icon>
          </q-item-section>
        </q-item>
      </q-card-section>
          <q-card-section class="q-pa-sm">
            <q-list class="row">
              <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <q-item-section side>
                  <q-avatar size="100px">
                    <img src="https://cdn.quasar.dev/img/boy-avatar.png">
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-btn label="Add Photo" class="text-capitalize" rounded color="info"
                         style="max-width: 120px"></q-btn>
                </q-item-section>
              </q-item>

              <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" dense v-model="user_details.user_name" label="Full Name"/>
                </q-item-section>
              </q-item>

              <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" dense v-model="user_details.user_name" label="User Name"/>
                </q-item-section>
              </q-item>
              <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" type="email" dense v-model="user_details.email" label="Email Address"/>
                </q-item-section>
              </q-item>
              <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" type="password" dense v-model="user_details.first_name" label="Password"/>
                </q-item-section>
              </q-item>
              <!-- <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" dense v-model="user_details.last_name" label="Last Name"/>
                </q-item-section>
              </q-item>
              <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" autogrow dense v-model="user_details.address" label="Address"/>
                </q-item-section>
              </q-item> -->
              <!-- <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" dense v-model="user_details.city" label="City"/>
                </q-item-section>
              </q-item>
              <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" dense v-model="user_details.post_code" label="Postal Code"/>
                </q-item-section>
              </q-item>
              <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input dark color="white" type="textarea" dense v-model="user_details.about" label="About"/>
                </q-item-section>
              </q-item> -->
            </q-list>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn class="text-capitalize bg-white" style="color: #162b4d;margin-right: 15px;">Submit</q-btn>
          </q-card-actions>
        </q-card>
</template>

<script>
export default {
    props:['title'],
    data(){
        return{
            user_details:{}
        }
    }
}
</script>

<style scoped>

.card-bg {
  background-color: #162b4d;
}
</style>
