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
        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input type="text" dark color="white" round v-model="form.name" :label="$t('name')" :rules="[
              (val) => (val && val.length > 0) || 'Please enter name',
            ]" />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input type="text" dark color="white" round v-model="form.code" :label="$t('code')"  :rules="[(val) => (val && val.length > 0) || 'Please enter unique code',]" />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section style="margin-top: -15px !important; font-size: 15px !important">
            <q-select dark color="white" v-model="form.type" :options="typeList" :label="$t('type')" emit-value
              map-options :rules="[(val) => (val && val.length > 0) || 'Please select type',]" >
            </q-select>
          </q-item-section>
        </q-item>

        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section style="margin-top: -15px !important; font-size: 15px !important">
            <q-select dark color="white" v-model="form.parent_id" :options="parentList" :label="$t('parent')" emit-value
              map-options>
            </q-select>
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-toggle color="green" size="md" v-model="form.active" val="md" :label="$t('is_active')" />
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
  props: ["title", "editItem", "parentList"],
  mixins: [helperMixin],
  data() {
    return {
      form: {
        name: '',
        type: null,
        code: '',
        parent_id: null,
        active: true,
      },
      typeList: [
        { value: 'Page', label: 'Page' },
        { value: 'Feature', label: 'Feature' }
      ]
    };
  },
  watch: {
    'form.name': function (newVal) {
      const nameLowerCase = newVal.toLowerCase()
      const permisCode = nameLowerCase.replaceAll(' ', '_')
      this.form.code = permisCode
    }
  },
  created() {
    var ref = this;
    if (ref.editItem) {
      ref.form = ref.editItem
    }
    console.log('this.parentList', this.parentList)
  },
  mounted() { },
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        ref.wait_me(".wait_me");
        let res = ''
        if (this.form.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_permission_data'), this.form);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_permission_data'), this.form);
        }
        this.notify(res.msg)
        this.$emit('closeModal', true)
        this.$emit('reloadListData', true)
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    },
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
