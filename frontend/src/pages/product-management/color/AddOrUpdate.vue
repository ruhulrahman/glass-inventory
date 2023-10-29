<template>
  <q-card class="bg-primary text-white no-shadow wait_me" bordered>
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label class="text-h6 text-weight-bolder" lines="1">{{ submitForm.id ? $t('update_color') : $t('add_new_color') }} </q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-icon name="cancel" color="white" clickable style="cursor: pointer;"
              @click="(() => { $emit('closeModal', true) })"></q-icon>
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-card-section class="q-pa-sm ">
        <q-list class="row">

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input dark color="white" dense v-model="submitForm.name" :label="$t('color_name')"
                :rules="[val => val && val.length > 0 || 'Please enter color name']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-toggle color="green" size="md" v-model="submitForm.active" val="md" :label="$t('is_active')" />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn type="submit" glossy class="text-capitalize bg-white text-primary q-mr-md q-mb-md q-pa-md ">{{ $t('save') }}</q-btn>
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'

export default {
  props: ['title', 'editItem'],
  mixins: [helperMixin],
  data() {
    return {
      submitForm: {
        id: '',
        parent_id: null,
        name: '',
        active: true,
      }
    }
  },
  created () {
    if (this.editItem) {
      this.submitForm = this.editItem
    }
  },
  mounted () {
  },
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        ref.wait_me(".wait_me");
        let res = ''
        if (this.submitForm.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_product_color_data'), this.submitForm);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_product_color_data'), this.submitForm);
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
}
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}
</style>
