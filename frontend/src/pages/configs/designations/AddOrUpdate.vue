<template>
  <q-card class="bg-primary text-white no-shadow wait_me" bordered>
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label class="text-h6 text-weight-bolder" lines="1">{{ designation.id ? $t('update') : $t('add_new_designation') }}</q-item-label>
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
              <q-input dark color="white" dense v-model="designation.name" :label="$t('designation_name')" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -15px !important; font-size: 15px !important">
              <q-select dark color="white" v-model="designation.department_id" :options="departments" :label="$t('department')"
                emit-value map-options>
              </q-select>
            </q-item-section>
          </q-item>
          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input type="number" dark color="white" dense v-model="designation.ranking_number" :label="$t('ranking_number')" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-toggle color="green" size="md" v-model="designation.active" val="md" :label="$t('is_active')" />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn glossy type="submit" class="text-capitalize bg-white q-mr-md q-mb-md text-primary">{{ $t('save') }}</q-btn>
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'

export default {
  props: ['title', 'editItem', 'departments'],
  mixins: [helperMixin],
  data() {
    return {
      designation: {
        id: '',
        department_id: null,
        name: '',
        ranking_number: '',
        active: true,
      }
    }
  },
  created() {
    if (this.editItem) {
      this.designation = this.editItem
    }
  },
  mounted() {
  },
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        ref.wait_me(".wait_me");
        let res = ''
        if (this.designation.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_designation_data'), this.designation);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_designation_data'), this.designation);
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
