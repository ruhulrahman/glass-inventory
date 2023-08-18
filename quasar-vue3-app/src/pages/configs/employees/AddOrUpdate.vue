<template>
  <q-card
    class="bg-primary text-white no-shadow wait_me1"
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
        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="employee.name"
              label="Full Name"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="email"
              dark
              color="white"
              v-model="employee.email"
              label="Email"
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
              v-model="employee.phone1"
              label="Phone Number"
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
              v-model="employee.phone2"
              label="Secondary Phone Number"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="employee.nid"
              label="NID"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <label style="margin-bottom: -18px;">Date Of Birth</label>
            <q-input
              type="date"
              dark
              color="white"
              v-model="employee.dob"
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
              v-model="employee.religion"
              label="Religion"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <div class="q-pa-md q-gutter-sm">
              <div class="q-gutter-sm">
                <q-radio dark
              color="white" v-model="employee.gender" val="Male" label="Male" />
                <q-radio
                  dark
              color="white"
                  v-model="employee.gender"
                  val="Female"
                  label="Female"
                />
              </div>
            </div>
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
              v-model="employee.present_address"
              label="Present Address"
            />
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
              v-model="employee.permanent_address"
              label="Permanent Address"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <label style="margin-bottom: -18px;
    margin-top: 15px;">Joining Date</label>
            <q-input
              type="date"
              dark
              color="white"
              v-model="employee.joining_date"
            />
          </q-item-section>
        </q-item>

        <q-item v-if="employee.id == null"
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <q-input
              type="number"
              dark
              color="white"
              v-model="employee.current_salary"
              label="Salary"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section
            style="margin-top: -20px !important; font-size: 12px !important"
          >
            <q-select
              dark
              color="white"
              v-model="employee.designation_id"
              label="Designation"
              :options="designations"
              emit-value
              map-options
            >
            </q-select>
          </q-item-section>
        </q-item>

        <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <q-item-section>
            <q-toggle
              color="green"
              size="md"
              v-model="employee.active"
              val="md"
              label="Is Active"
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
              {{ editItem.id ? "Update" : "Save" }}
            </q-btn>
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
      employee: {
        id: null,
        name: "",
        email: "",
        phone1: null,
        phone2: null,
        dob: null,
        gender: null,
        religion: "",
        nid: null,
        present_address: '',
        permanent_address: '',
        designation_id: null,
        joining_date: null,
        current_salary: null,
        active: null,
      },
      designations:[]
    };
  },
  created() {
    var ref = this;
    if (ref.editItem) {
      ref.employee = ref.editItem;
      ref.employee.active = ref.editItem.active == 1 ? true : false;
    }
  },
  mounted() {
    this.get_designations()
  },
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me1");

      try {
        let res = "";
        if (this.employee.id) {
          res = await jq.post(
            ref.apiUrl("api/v1/admin/ajax/update_employee_data"),
            this.employee
          );
        } else {
          res = await jq.post(
            ref.apiUrl("api/v1/admin/ajax/store_employee_data"),
            this.employee
          );
        }
        this.notify(res.msg);
        this.$emit("closeModal", true);
        this.$emit("reloadListData", true);
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        ref.wait_me(".wait_me1", "hide");
      }
    },
    get_designations: async function(){
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me1");

      try {
        let res = "";
        res = await jq.get(ref.apiUrl("api/v1/admin/ajax/get_designation_list"));
        ref.designations = res.data.data
        // console.log(ref.designations);
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        ref.wait_me(".wait_me1", "hide");
      }
    }
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
