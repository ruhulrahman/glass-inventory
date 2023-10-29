<template>
  <q-card
    class="bg-primary text-white no-shadow wait_me"
    style="margin-top: 25px"
    bordered
  >
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label
              class="text-h6 text-weight-bolder text-white-8"
              lines="1"
              >{{ title }}</q-item-label
            >
          </q-item-section>
          <q-item-section side>
            <q-icon
              name="cancel"
              clickable
              color="white"
              style="cursor: pointer"
              @click="
                () => {
                  $emit('closeModal', true);
                }
              "
            ></q-icon>
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-sm row">
        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="email"
              dark
              color="white"
              round
              readonly
              v-model="user.email"
              :label="$t('email')"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="password"
              dark
              color="white"
              round
              v-model="user.old_password"
              :label="$t('old_password')"
              :rules="[(val) => (val && val != '') || 'Please enter old password']"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="password"
              dark
              color="white"
              v-model="user.password"
              :label="$t('new_password')"
              :rules="[(val) => (val && val != '') || 'Please enter new password']"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="password"
              dark
              color="white"
              v-model="user.confirm_password"
              :label="$t('confirm_password')"
              :rules="[(val) => (val && val != '') || 'Please enter confirm password']"
            />
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn
          glossy
          type="submit"
          class="text-capitalize bg-white q-mr-md q-mb-md text-primary"
          >
          {{ $t('update') }}
          </q-btn
        >
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script>
import helperMixin from "src/mixins/helper_mixin.js";

export default {
  props: ["title", "editItem", "company"],
  mixins: [helperMixin],
  data() {
    return {
      user: {
        id:null,
        email: '',
        old_password: '',
        password: '',
        confirm_password: ''
      },
    };
  },
  created() {
  var ref = this;
    if (ref.editItem) {
        ref.user = ref.editItem;
    }
  },
  mounted() {},
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();

      ref.wait_me(".wait_me");

      try {
        let url = '';
        let res = await jq.post(ref.apiUrl('api/v1/admin/ajax/forgot_password'), this.user);
        ref.notify(res.msg)
        ref.$emit('closeModal', true)

     } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    }
  },
};
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}

.q-field--dark:not(.q-field--highlighted) .q-field__label {
  margin-top: 12px !important;
  color: rgba(255, 255, 255, 0.7);
}
/* .q-anchor--skip .q-field__native .q-placeholder {
    margin-top: 20px !important;
} */
.q-btn__content {
  width: 60px !important;
}
</style>
