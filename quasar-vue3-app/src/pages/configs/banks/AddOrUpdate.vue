<template>
  <q-card
    class="bg-primary text-white no-shadow wait_me1"
    style="margin-top: 25px;"
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
        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="bank_info.bank_name"
              label="Bank Name"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="bank_info.branch_name"
              label="Branch Name"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="bank_info.account_name"
              label="Account Name"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="number"
              dark
              color="white"
              v-model="bank_info.account_number"
              label="Account Number"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="number"
              dark
              color="white"
              v-model="bank_info.routing_number"
              label="Routing Number"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="bank_info.swift_code"
              label="Swift Code"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-toggle color="green" size="md" v-model="bank_info.status" val="md" label="Is Active" />
            </q-item-section>
          </q-item>

        <q-item
          class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="bank_info.address"
              label="Address"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="textarea"
              dark
              color="white"
              v-model="bank_info.details"
              label="Details"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
          style="float: right"
        >
          <q-item-section>
            <q-btn
              type="submit"
              color="green"
              style="width: 10%; margin-left: 90%"
              >
              {{editItem.id ? 'Update' : 'Save'}}
              </q-btn
            >
          </q-item-section>
        </q-item>
      </q-card-section>
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
      bank_info: {
        id: null,
        bank_name: "",
        branch_name: "",
        account_name: "",
        account_number: "",
        routing_number: "",
        swift_code: "",
        address: "",
        details: "",
        status: "",
      },
    };
  },
  created() {
    var ref = this;
    if (ref.editItem) {
      ref.bank_info = ref.editItem;
      ref.bank_info.status = ref.editItem.status == 1 ? true : false;
    }
  },
  mounted() {},
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me1");

      try {
        let res = ''
        if (this.bank_info.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_company_bank_data'), this.bank_info);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_company_bank_data'), this.bank_info);
        }
        this.notify(res.msg)
        this.$emit('closeModal', true)
        this.$emit('reloadListData', true)

      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        ref.wait_me(".wait_me1", "hide");
      }
    },
  },
};
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}
.q-dialog__inner--minimized > div {
    max-width: 800px !important;
}

</style>
