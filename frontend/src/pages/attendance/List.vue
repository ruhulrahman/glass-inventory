<template>
  <q-page class="q-pa-sm">
    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('employee_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('attendance_list')" />
    </q-breadcrumbs>
    <q-card class="no-shadow" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">{{ $t('attendance_list') }}</div>
        </div>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-none">
        <!-- <q-toggle v-model="loading" label="Loading state" class="q-mb-md" /> -->
        <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow wait_me" :rows="tableRow" :columns="columns"
          row-key="name" no-data-label=" I didn't find anything for you" :loading="loading"
          :pagination="initialPagination" :filter="filter">
          <template v-slot:top-right>
            <!-- <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section
            style="margin-top: -20px !important; font-size: 12px !important"
          >
            <q-select
              filled
                  borderless
                  dense
              v-model="search_query.employee_id"
              label="Employee"
              :options="employees"
              emit-value
              map-options
            >
            </q-select>
          </q-item-section>
        </q-item> -->
            <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <q-item-section style="font-size: 12px !important">
                <q-select filled dense clearable v-model="search_query.employee_id" :label="$t('employee_name')" :options="employees"
                  emit-value map-options use-input @filter="employeefilter">
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">
                        No results
                      </q-item-section>
                    </q-item>
                  </template>
                </q-select>
              </q-item-section>
            </q-item>
            <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <q-item-section style="font-size: 12px !important">
                <q-select filled dense clearable v-model="search_query.status_type" :label="$t('type')"
                  :options="attendanceStatusList" emit-value map-options use-input>
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">
                        No results
                      </q-item-section>
                    </q-item>
                  </template>
                </q-select>
              </q-item-section>
            </q-item>
            <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <q-item-section>
                <div class="d-flex q-mb-sm">
                  <span class="q-mr-sm">{{ $t('attendance_date') }}</span>
                  <flat-pickr filled dense class="text-black bg-grey-3 q-m-lg" style="padding: 10px; border:none"
                    v-model="search_query.attendance_date" :config="configFlatPickr"
                    placeholder="Select Date"></flat-pickr>
                </div>
              </q-item-section>
            </q-item>
            <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <q-item-section>
                <q-btn glossy @click="getListData()" flat color="white" class="bg-green-7"
                  style="text-transform: capitalize; padding: 0px 10px 0 19px">
                  Search
                </q-btn>
              </q-item-section>
            </q-item>

            <q-btn class="q-ml-sm" icon="refresh" @click="resetData()" flat />
            <!-- <q-date
              v-if="calander"
              @click="get_date()"
              style="position: absolute; top: 55px; z-index: 1; right: 78px"
              v-model="date_range"
              range
            /> -->
          </template>
          <template v-slot:no-data="{ icon, message, filter }">
            <div class="full-width row flex-center text-red q-gutter-sm">
              <q-icon size="2em" name="sentiment_dissatisfied" />
              <span> Well this is sad... {{ message }} </span>
              <q-icon size="2em" :name="filter ? 'filter_b_and_w' : icon" />
            </div>
          </template>
          <template v-slot:header="props">
            <q-tr :props="props" class="bg-blue-grey-2 text-primary">
              <q-th v-for="col in props.cols" :key="col.name" :props="props">
                {{ col.label }}
              </q-th>
            </q-tr>
          </template>
          <template v-slot:body="props">
            <q-tr :props="props">
              <q-td key="sl" :props="props">
                {{ props.row.sl }}
              </q-td>
              <q-td key="name" :props="props">
                {{ props.row.name }}
              </q-td>
              <q-td key="attendance_date" :props="props">
                {{ props.row.attendance_date }}
              </q-td>
              <q-td key="attendance" :props="props">
                <q-radio color="green" size="xs" v-model="props.row.attendance" @click="change_status(props.row)"
                  val="Present" label="Present" />
                <q-radio color="red" size="xs" v-model="props.row.attendance" @click="change_status(props.row)"
                  val="Absent" label="Absent" />
                <q-radio color="orange" size="xs" v-model="props.row.attendance" @click="change_status(props.row)"
                  val="Leave" label="Leave" />
                <q-radio color="teal" size="xs" v-model="props.row.attendance" @click="change_status(props.row)"
                  val="Holiday" label="Holiday" />
              </q-td>
              <q-td key="action" :props="props">
                <q-btn @click="detailsData(props.row)" class="text-blue" icon="visibility" size="sm" flat dense></q-btn>
                <q-btn @click="deleteData(props.row)" icon="delete" size="sm" class="q-ml-sm" flat dense />
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>
    </q-card>
    <q-dialog v-model="alert">
      <q-card>
        <q-card-section>
          <div class="text-h5">
            Today {{ dDate(new Date().toISOString().slice(0, 10)) }}
            <strong style="text-transform: capitalize">{{
              holiday_name
            }}</strong>
          </div>
        </q-card-section>

        <q-card-section class="q-pt-none text-warning">
          <q-icon name="warning"></q-icon>
          Attendance is not accepted on <strong>holidays</strong>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="OK" color="primary" @click="getListData()" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <div class="q-pa-md q-gutter-sm">
      <q-dialog v-model="showDetailsDialog">
        <attendance-details :title="editItem.name + ' Attendance list'" :editItem="editItem"
          @closeModal="showDetailsDialog = false" />
      </q-dialog>
    </div>
  </q-page>
</template>

<script>
import { useMeta, Dialog } from "quasar";
import helperMixin from "../../mixins/helper_mixin.js";
import DialogConfirmationComponent from "src/components/DialogConfirmationComponent.vue";
import { ref } from "vue";
const metaData = {
  title: "Employee List",
  titleTemplate: (title) => `${title} - Inventory App`,
};
// import createEmployee from "./AddOrUpdate.vue";
import AttendanceDetails from "./Details.vue";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
  name: "AttendanceList",
  mixins: [helperMixin],
  components: {
    // createEmployee,
    AttendanceDetails,
    flatPickr
  },
  setup() {
    useMeta(metaData);
    const show_filter = ref(false);

    return {
      filter: ref(""),
      show_filter,
    };
  },
  data() {
    return {
      opened: false,
      showAddNewDialog: false,
      showDetailsDialog: false,
      loading: false,
      departments: [],
      listData: [],
      editItem: "",
      date_range: null,
      calander: false,
      search_input: null,
      search_query: {
        employee_id: '',
        status_type: '',
        attendance_date: this.dDate(new Date()),
      },
      configFlatPickr: {
        // wrap: true, // set wrap to true only when using 'input-group'
        dateFormat: 'd-m-Y',
      },
      attendanceStatusList: [
        { value: "Absent", label: "Absent" },
        { value: "Leave", label: "Leave" },
        { value: "Present", label: "Present" },
        { value: "Holiday", label: "Holiday" },
      ],
      alert: false,
      holiday_name: null,
      employees: [],
      employees2: [],
    };
  },
  computed: {
    tableRow: function () {
      if (this.listData.length) {
        return this.listData.map((item, i) => {
          item.sl = i + 1;
          item.name = item.name;
          item.attendance_date = item.attendance_date;
          item.attendance = item.attendance;
          item.count_attendance == "";
          return Object.assign(item);
        });
      } else {
        return [];
      }
    },
    columns: function () {
      return [
        { name: "sl", required: true, label: this.$t('sl'), align: "left", field: (row) => row.sl, format: (val) => `${val}`, sortable: true },
        { name: "name", required: true, label: this.$t('employee_name'), align: "left", field: (row) => row.name, format: (val) => `${val}`, sortable: true },
        { name: "attendance_date", label: this.$t('attendance_date'), field: "attendance_date", align: "center" },
        { name: "attendance", label: this.$t('status'), field: "attendance", align: "center" },
        { name: "action", label: this.$t('action'), field: "action", align: "center" },
      ];
    }
  },
  created() {
    // this.getListData();
  },
  mounted() {
    this.getListData();
    // this.getCompanytList();
  },
  methods: {
    employeefilter(val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.employees = this.employees2.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    openAddNewDialog: function () {
      this.editItem = "";
      this.showAddNewDialog = true;
    },
    getListData: async function () {
      let ref = this;
      let jq = ref.jq();
      // console.log('this.search_input.date', this.search_query.date)
      if (!this.search_query.attendance_date) {
        return;
      }

      try {
        this.loading = true;
        let res = await jq.get(
          ref.apiUrl("api/v1/admin/ajax/get_attendance_employee_list_v2"),
          ref.search_query
        );
        ref.calander = false;
        if (res.data.data != null && res.data.data.length) {
          this.listData = res.data.data.map((item) => {
            item.attendance_date = this.dDate(item.attendance_date);
            return item;
          });

          ref.employees = this.listData.map((item) => {
            return {
              value: item.id,
              label: item.name,
            };
          });

          this.employees2 = this.employees

        } else {
          this.listData = []
          ref.employees = []
        }
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        this.loading = false;
      }
    },
    getListData2: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true;
        let res = await jq.get(
          ref.apiUrl("api/v1/admin/ajax/get_attendance_employee_list"),
          ref.search_query
        );
        ref.calander = false;
        if (res.data.data.length > 0) {
          this.listData = res.data.data.map((item) => {
            item.present = item.present == "Yes" ? "Present" : "Absent";
            item.date = item.date
              ? ref.dDate(item.date)
              : ref.dDate(new Date().toISOString().slice(0, 10));
            item.holiday = res.data.day;
            item.holiday_name = res.data.holiday_name;
            return item;
          });

          ref.employees = this.listData.map((item) => {
            return {
              id: item.id,
              label: item.name,
            };
          });

        } else {
          this.listData = []
          ref.employees = []
        }
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        this.loading = false;
      }
    },
    resetData: async function () {
      this.search_query.employee_id = '';
      this.search_query.status_type = '';
      this.search_query.attendance_date = this.dDate(new Date());
      this.getListData();
    },
    editData: async function (item) {
      this.editItem = this.clone_object(item);
      this.showAddNewDialog = true;
    },
    detailsData: async function (item) {
      this.editItem = this.clone_object(item);
      // console.log(this.editItem);
      this.showDetailsDialog = true;
    },
    deleteData: async function (item) {
      Dialog.create({
        componentProps: {
          title: "something",
          message: "something",
          // position: 'standard',
        },
        component: DialogConfirmationComponent,
      }).onOk(() => {
        this.deleteDataConfirmed(item);
      });
    },
    deleteDataConfirmed: async function (item) {
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me");

      try {
        let res = await jq.post(
          ref.apiUrl("api/v1/admin/ajax/delete_attendance_data"),
          item
        );
        this.notify(res.msg);
        this.getListData();
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    },
    change_status: async function (item) {
      // console.log(item);
      let ref = this;
      let jq = ref.jq();

      try {
        this.loading = true;
        let res = await jq.post(
          ref.apiUrl("api/v1/admin/ajax/update_employee_attendance"),
          item
        );
        await this.getListData();
        this.notify(res.msg);
        // this.listData = res.data.data.map((item) => {
        //   item.present = "Absent";
        //   item.date = ref.dDate(new Date().toISOString().slice(0, 10));
        //   return item;
        // });
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        this.loading = false;
      }
    },
    get_date() {
      var ref = this;
      if (ref.date_range != null && ref.date_range.from) {
        // console.log(ref.date_range);
        ref.search_input =
          "From:" + ref.date_range.from + " To:" + ref.date_range.to;
        ref.search_query.from = ref.date_range.from;
        ref.search_query.to = ref.date_range.to;
        const d = new Date(ref.date_range.from);
        ref.search_query.month = d.getMonth();
        // console.log(this.date_range.from);
        // console.log(this.date_range.to);
      } else {
        // console.log(ref.date_range);
        ref.search_input = "From:" + ref.date_range + " To:" + "";
        ref.search_query.from = ref.date_range;
        ref.search_query.to = null;
        const d = new Date(ref.date_range.from);
        ref.search_query.month = d.getMonth();
      }
    },
  },
};
</script>

<style scoped>
.swal2-confirm {
  border: 0;
  border-radius: 0.25em;
  background: initial;
  background-color: #28a745 !important;
  color: #fff;
  font-size: 1em;
  padding: 6px 21px !important;
}

.swal2-cancel {
  border: 0;
  border-radius: 0.25em;
  background: initial;
  /* background-color: #dc3741; */
  background-color: rgb(244 67 54);
  color: #fff;
  font-size: 1em;
  padding: 6px 21px !important;
}
</style>

