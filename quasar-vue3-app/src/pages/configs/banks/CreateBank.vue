<template>
  <q-card class="q-mt-sm no-shadow" bordered>
    <q-card-section class="row q-pa-sm">
      <q-item class="full-width">
        <q-item-section>
          <q-item-label
            class="text-h6 text-weight-bolder text-grey-8"
            lines="1"
            >{{ title }}</q-item-label
          >
        </q-item-section>
        <q-item-section side>
          <q-icon
            name="cancel"
            clickable
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
        <q-item-section> Bank Name </q-item-section>
      </q-item>
      <q-item
        class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
        style="margin-top: -18px"
      >
        <q-item-section>
          <q-input
            type="password"
            dense
            outlined
            color="green"
            round
            v-model="bank_details.bank_name"
            label="Bank Name"
          />
        </q-item-section>
      </q-item>
      <q-item class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <q-item-section> Branch Name </q-item-section>
      </q-item>
      <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="margin-top: -18px"
      >
        <q-item-section>
          <q-input
            type="text"
            dense
            outlined
            color="green"
            round
            v-model="bank_details.branch_name"
            label="Branch Name"
          />
        </q-item-section>
      </q-item>
      <q-item class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <q-item-section> Account Name </q-item-section>
      </q-item>
      <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="margin-top: -18px"
      >
        <q-item-section>
          <q-input
            type="text"
            dense
            outlined
            round
            color="green"
            v-model="bank_details.account_name"
            label="Account Name"
          />
        </q-item-section>
      </q-item>
      <q-item class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <q-item-section> Account Number </q-item-section>
      </q-item>

      <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="margin-top: -18px"
      >
        <q-item-section>
          <q-input
            type="number"
            dense
            outlined
            round
            color="green"
            v-model="bank_details.account_number"
            label="Account Number"
          />
        </q-item-section>
      </q-item>

      <q-item class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <q-item-section> Routing Number </q-item-section>
      </q-item>

      <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="margin-top: -18px"
      >
        <q-item-section>
          <q-input
            type="number"
            dense
            outlined
            round
            color="green"
            v-model="bank_details.routing_number"
            label="Routing Number"
          />
        </q-item-section>
      </q-item>

      <q-item class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <q-item-section> Swift Code </q-item-section>
      </q-item>

      <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="margin-top: -18px"
      >
        <q-item-section>
          <q-input
            type="text"
            dense
            outlined
            round
            color="green"
            v-model="bank_details.swift_code"
            label="Swift Code"
          />
        </q-item-section>
      </q-item>

      <q-item class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <q-item-section> Address </q-item-section>
      </q-item>
      <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="margin-top: -18px"
      >
        <q-item-section>
          <q-input
            type="text"
            dense
            outlined
            round
            color="green"
            v-model="bank_details.address"
            label="Address"
          />
        </q-item-section>
      </q-item>

      <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="float: right"
      >
        <q-item-section>
          <q-btn
            type="button"
            color="green"
            style="width: 20%; margin-left: 80%"
            >Submit</q-btn
          >
        </q-item-section>
      </q-item>
    </q-card-section>
  </q-card>
</template>

<script>
export default {
  props: ["title"],
  data() {
    return {
      bank_details: {},
    };
  },
};
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}
</style>