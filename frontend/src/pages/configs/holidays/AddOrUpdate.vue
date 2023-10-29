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
              type="text"
              dark
              color="white"
              round
              v-model="holiday.name"
              :label="$t('holiday_name')"
              :rules="[
                (val) => (val && val.length > 0) || 'Please enter holiday name',
              ]"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <label style="margin-bottom: -18px">{{ $t('from') }}</label>
            <q-input type="date" dark color="white" v-model="holiday.from" />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <label style="margin-bottom: -18px">{{ $t('to') }}</label>
            <q-input type="date" dark color="white" v-model="holiday.to" />
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn
          glossy
          type="submit"
          class="text-capitalize bg-white q-mr-md q-mb-md text-primary"
          >
          {{ $t('save') }}
          </q-btn
        >
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script>
import helperMixin from "../../../mixins/helper_mixin.js";

export default {
  props: ["title", "editItem", "company"],
  mixins: [helperMixin],
  data() {
    return {
      holiday: {
        id:null,
        name: '',
        from:null,
        to: null
      },
      files: [],
    };
  },
  created() {
  var ref = this;
  if (ref.editItem) {
      ref.holiday.id =ref.editItem.id,
        ref.holiday.name = ref.editItem.name
        ref.holiday.from = ref.editItem.from
        ref.holiday.to = ref.editItem.to
        console.log(ref.holiday);
    }
  },
  mounted() {},
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();


    try {
        ref.wait_me(".wait_me");
        let res = ''
        if (this.holiday.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_holiday_data'), this.holiday);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_holiday_data'), this.holiday);
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
