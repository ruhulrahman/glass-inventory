<template>
  <q-card class="bg-primary text-white no-shadow wait_me" style="margin-top: 25px" bordered>
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label class="text-h6 text-weight-bolder text-white-8" lines="1">{{ title }}</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-icon name="cancel" clickable color="white" style="cursor: pointer" @click="() => {
                $emit('closeModal', true);
              }
              "></q-icon>
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-sm row">
        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input type="text" dark color="white" round v-model="customer.name" :label="$t('name')"
              :rules="[(val) => (val && val != '') || 'Please enter your name']" />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input type="email" dark color="white" round v-model="customer.email" :label="$t('email')" />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input type="number" dark color="white" v-model="customer.phone" :label="$t('phone')"
              :rules="[(val) => (val && val != '') || 'Please enter your phone']" />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input type="url" dark color="white" v-model="customer.website" :label="$t('website')" />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: -18px">
          <q-item-section>
            <q-input type="text" dark color="white" v-model="customer.address" :label="$t('address')" />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-toggle color="green" size="md" v-model="customer.is_active" val="md" :label="$t('is_active')" />
          </q-item-section>
        </q-item>

      </q-card-section>
      <q-card-actions align="right">
        <q-btn glossy type="submit" class="text-capitalize bg-white q-mr-md q-mb-md text-primary">
          {{ $t('save') }}
        </q-btn>
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
      customer: {
        id: null,
        name: '',
        email: '',
        phone: '',
        address: '',
        website: '',
        is_active: false
      }
    };
  },
  created() {
    var ref = this;
    if (ref.editItem) {
      ref.customer = ref.editItem;
      ref.customer.is_active = ref.editItem.is_active == 1 ? true : false;
    }
  },
  mounted() { },
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();

      try {

        let res = ''
        if (this.customer.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_customer_data'), this.customer);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_customer_data'), this.customer);
        }

        this.notify(res.msg)
        this.$emit('closeModal', true)
        this.$emit('reloadListData', true)

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
