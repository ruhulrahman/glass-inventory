<template>
  <q-card class="bg-primary text-white no-shadow wait_me" bordered>
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label class="text-h6 text-weight-bolder" lines="1">{{ weekend.id ? $t('update') : $t('add_new_weekend') }}</q-item-label>
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
          <q-item-section
            style="margin-top: -20px !important; font-size: 12px !important"
          >
            <q-select
              dark
              color="white"
              v-model="weekend.day_name"
              :label="$t('weekend_name')"
              :options="weekendNameList"
              emit-value
              map-options
            >
            </q-select>
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
      weekend: {
        id: '',
        day_name: null,
      },
      weekendNameList: [
        { value: 'Saturday', label: 'Saturday' },
        { value: 'Sunday', label: 'Sunday' },
        { value: 'Monday', label: 'Monday' },
        { value: 'Tuesday', label: 'Tuesday' },
        { value: 'Wednesday', label: 'Wednesday' },
        { value: 'Thursday', label: 'Thursday' },
        { value: 'Friday', label: 'Friday' },
      ]
    }
  },
  created () {
    if (this.editItem) {
      this.weekend = this.editItem
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
        if (this.weekend.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_weekend_data'), this.weekend);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_weekend_data'), this.weekend);
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
