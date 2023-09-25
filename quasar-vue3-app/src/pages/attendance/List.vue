<template>
  <q-page class="q-pa-sm">
    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el label="Dashboard" icon="home" to="/" />
      <q-breadcrumbs-el label="Configuration" icon="widgets" to="/" />
      <q-breadcrumbs-el label="Attendance" />
    </q-breadcrumbs>
    <q-card class="no-shadow" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">Attendance List</div>
        </div>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-none">
        <!-- <q-toggle v-model="loading" label="Loading state" class="q-mb-md" /> -->
        <q-table
          :dense="$q.screen.lt.md"
          flat
          bordered
          class="no-shadow wait_me"
          :rows="tableRow"
          :columns="columns"
          row-key="name"
          no-data-label=" I didn't find anything for you"
          :loading="loading"
          :pagination="initialPagination"
          :filter="filter"
        >
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
                <q-select
                  filled
                  dense
                  clearable
                  v-model="search_query.employee_id"
                  label="Employee"
                  :options="employees"
                  emit-value
                  map-options
                  use-input
                >
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
                <q-select
                  filled
                  dense
                  clearable
                  v-model="search_query.status_type"
                  label="Type"
                  :options="status_arr"
                  emit-value
                  map-options
                  use-input
                >
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
            <!-- <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <q-item-section style="font-size: 12px !important">
                <q-select
                  filled
                  borderless
                  dense
                  v-model="search_query.status_type"
                  :options="status_arr"
                  emit-value
                  map-options
                >
                </q-select>
              </q-item-section>
            </q-item> -->
            <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <q-item-section>
                <div class="d-flex q-mb-sm">
                  <span class="q-mr-sm">Invoice Date</span>
                  <flat-pickr filled dense class="text-black bg-grey-3 q-m-lg" style="padding: 10px; border:none" v-model="search_query.date" :config="configFlatPickr" placeholder="Select Date"></flat-pickr>
                  <!-- <q-btn icon="event" round color="primary">
                    <q-tooltip
                      class="bg-primary"
                      transition-show="scale"
                      transition-hide="scale"
                      anchor="bottom middle"
                      self="center middle"
                    >
                      Select Invoice Date
                    </q-tooltip>
                    <q-popup-proxy
                      @before-show="updateProxy"
                      cover
                      transition-show="scale"
                      transition-hide="scale"
                    >
                      <q-date @click="get_date()" v-model="date_range" range>
                        <div class="row items-center justify-end q-gutter-sm">
                          <q-btn
                            label="Cancel"
                            color="primary"
                            flat
                            v-close-popup
                          />
                        </div>
                      </q-date>
                    </q-popup-proxy>
                  </q-btn> -->
                </div>
                <!-- <q-badge color="teal" v-if="date_range">{{
                  search_input
                }}</q-badge> -->
              </q-item-section>
            </q-item>
            <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <q-item-section>
                <q-btn
                  glossy
                  @click="getListData()"
                  flat
                  color="white"
                  class="bg-green-7"
                  style="text-transform: capitalize; padding: 0px 10px 0 19px"
                >
                  Search
                </q-btn>
              </q-item-section>
            </q-item>

            <q-btn class="q-ml-sm" icon="refresh" @click="reset()" flat />
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
              <q-td key="date" :props="props">
                {{ props.row.date }}
              </q-td>
              <q-td key="present" :props="props">
                <q-toggle
                  :label="props.row.present"
                  :color="props.row.present == false ? 'red' : 'green'"
                  size="md"
                  false-value="Absent"
                  true-value="Present"
                  v-model="props.row.present"
                  @click="change_status(props.row)"
                />
              </q-td>
              <q-td key="count_attendance" :props="props">
                <div class="q-pa-md q-gutter-md">
                  <q-badge
                    rounded
                    color="orange"
                    title="Current Month Total Present"
                    :label="'P - ' + props.row.count_present"
                  />
                  <q-badge
                    rounded
                    color="red"
                    title="Current Month Total Absent"
                    :label="'Ab - ' + props.row.count_absent"
                  />
                </div>
              </q-td>

              <q-td key="action" :props="props">
                <q-btn
                  @click="detailsData(props.row)"
                  class="text-blue"
                  icon="visibility"
                  size="sm"
                  flat
                  dense
                ></q-btn>
                <q-btn
                  @click="deleteData(props.row)"
                  icon="delete"
                  size="sm"
                  class="q-ml-sm"
                  flat
                  dense
                />
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
          <q-btn
            flat
            label="OK"
            color="primary"
            @click="getListData()"
            v-close-popup
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <div class="q-pa-md q-gutter-sm">
      <q-dialog v-model="showDetailsDialog">
        <attendance-details
          :title="editItem.name + ' Attendance list'"
          :editItem="editItem"
          @closeModal="showDetailsDialog = false"
        />
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

const columns = [
  {
    name: "sl",
    required: true,
    label: "#SL",
    align: "left",
    field: (row) => row.sl,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "name",
    required: true,
    label: "Employee Name",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "date",
    required: true,
    align: "center",
    label: "Date",
    field: "date",
  },
  { name: "present", label: "Status", field: "present" },
  {
    name: "count_attendance",
    label: "Total Attendance",
    field: "count_attendance",
  },

  {
    name: "action",
    label: "Action",
    field: "action",
    sortable: false,
    align: "center",
  },
];

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
      columns,
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
        employee_id: null,
        from: null,
        to: null,
        status_type: null,
        date: this.dDate(new Date()),
      },
      configFlatPickr: {
        // wrap: true, // set wrap to true only when using 'input-group'
        dateFormat: 'd-m-Y',
      },
      status_arr: [
        { id: "Yes", label: "Present" },
        { id: "No", label: "Absent" },
      ],
      alert: false,
      holiday_name: null,
      employees: [],
    };
  },
  computed: {
    tableRow: function () {
      if (this.listData.length) {
        return this.listData.map((item, i) => {
          item.sl = i + 1;
          item.name = item.name;
          item.date = item.date;
          item.present = item.present;
          item.count_attendance == "";
          return Object.assign(item);
        });
      } else {
        return [];
      }
    },
  },
  mounted() {
    this.getListData();
    // this.getCompanytList();
  },
  methods: {
    openAddNewDialog: function () {
      this.editItem = "";
      this.showAddNewDialog = true;
    },
    getListData: async function () {
      let ref = this;
      let jq = ref.jq();
      // console.log('this.search_input.date', this.search_query.date)
      if (!this.search_query.date) {
        return ;
      }

      try {
        this.loading = true;
        let res = await jq.get(
          ref.apiUrl("api/v1/admin/ajax/get_attendance_employee_list_v2"),
          ref.search_query
        );
        ref.calander = false;
        if(res.data.data != null && res.data.data.length){
          // const searchingDate = this.dDate(new Date(this.search_query.date))
          // const searchingDate = new Date(this.search_query.date)
          const myDate = Date.parse(this.search_query.date+'T00:00:00.000Z');
          console.log('myDate',myDate)
          // const searchingDate = this.dDate(this.search_query.date, 'D')
          // console.log('searchingDate',searchingDate)
          this.listData = res.data.data.map((item) => {
            item.present = item.present == "Yes" ? "Present" : "Absent";
            item.date = this.search_query.date;
            // item.date = item.date
            //   ? ref.dDate(item.date)
            //   : ref.dDate(new Date().toISOString().slice(0, 10));
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

        }else{
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
        if(res.data.data.length > 0){
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

        }else{
          this.listData = []
          ref.employees = []
        }
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        this.loading = false;
      }
    },
    reset: async function () {
      var ref = this;
      ref.search_input = "";
      ref.search_query.from = null;
      ref.search_query.to = null;
      ref.search_query.status_type = null;
      ref.getListData();
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

      if (item.holiday == true) {
        ref.alert = true;
        ref.holiday_name = item.holiday_name;
        return;
      } else {
        ref.alert = false;
        try {
          this.loading = true;
          let res = await jq.post(
            ref.apiUrl("api/v1/admin/ajax/update_attendance"),
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

