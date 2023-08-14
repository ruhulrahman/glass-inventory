<template>
  <q-card class="bg-primary text-white no-shadow wait_me" bordered>
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label class="text-h6 text-weight-bolder" lines="1">{{ department.id ? 'Update' : 'Add New' }} Department</q-item-label>
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
              v-model="department.parent_id"
              label="Department"
              :options="departments"
              emit-value
              map-options
            >
            </q-select>
          </q-item-section>
        </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input dark color="white" dense v-model="department.name" label="Department Name"
                :rules="[val => val && val.length > 0 || 'Please enter department name']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-toggle color="green" size="md" v-model="department.active" val="md" label="Is Active" />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn type="submit" class="text-capitalize bg-white q-mr-md q-mb-md text-primary">Save</q-btn>
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
      department: {
        id: '',
        parent_id: null,
        name: '',
        active: true,
      }
    }
  },
  created () {
    if (this.editItem) {
      this.department = this.editItem
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
        if (this.department.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_department_data'), this.department);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_department_data'), this.department);
        }
        this.notify(res.msg)
        this.$emit('closeModal', true)
        this.$emit('reloadtListData', true)
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
