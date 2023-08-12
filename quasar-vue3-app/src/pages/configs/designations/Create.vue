<template>
  <q-card class="card-bg text-white no-shadow" bordered>
    <q-card-section class="row q-pa-sm">
      <q-item class="full-width">
        <q-item-section>
          <q-item-label class="text-h6 text-weight-bolder" lines="1">{{
            title
          }}</q-item-label>
        </q-item-section>
        <q-item-section side>
          <q-icon
            name="cancel"
            color="white"
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
    <q-card-section class="q-pa-sm">
      <q-list class="row">
        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              dark
              color="white"
              dense
              v-model="designation.name"
              label="Designation Name"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section
            style="margin-top: -15px !important; font-size: 15px !important"
          >
            <!-- <q-input dark color="white" dense v-model="designation.name" label="designation Name"/> -->
            <q-select
              dark
              color="white"
              v-model="designation.department"
              :options="departments"
              label="Department"
            >
              <!-- <template v-slot:prepend>
                <q-icon name="event" />
              </template> -->
            </q-select>
          </q-item-section>
        </q-item>
        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              dark
              color="white"
              dense
              v-model="designation.level"
              label="Level Name"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-toggle
              color="green"
              size="md"
              v-model="designation.status"
              val="md"
              label="Is Active"
            />
            <!-- <q-input dark color="white" dense v-model="designation.status" label="Is Active"/> -->
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
    <q-card-actions align="right">
      <q-btn
        class="text-capitalize bg-white"
        style="color: #162b4d; margin-right: 15px"
        >Submit</q-btn
      >
    </q-card-actions>
  </q-card>
</template>

<script>
export default {
  props: ["title"],
  data() {
    return {
      designation: {},
      departments: ["Marketing", "Sales"],
    };
  },
};
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}
</style>