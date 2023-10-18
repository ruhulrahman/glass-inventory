<template>
  <q-card class="card-bg text-white no-shadow" bordered style="width: 700px; max-width: 80vw">
    <q-card-section class="text-center bg-transparent">
      <q-avatar size="100px" class="shadow-10">
        <img v-if="editItem.photo" :src="apiUrl('/uploads/photo/') + editItem.photo" />
        <img v-else :src="apiUrl('/uploads/demo.jpg')" />
      </q-avatar>
      <div class="text-h6">{{ editItem.name }}</div>
      <div class="text-h6 q-mt-md">
        Attendance List of {{ month }}
      </div>
      <div class="text-h6 q-mt-md">
        Attendance History :
        <q-badge class="q-mr-sm" rounded color="green" :label="'Present - ' + attendanceCount.present" />
        <q-badge class="q-mr-sm" rounded color="teal" :label="'Holiday - ' + attendanceCount.holiday" />
        <q-badge class="q-mr-sm" rounded color="orange" :label="'Leave - ' + attendanceCount.leave" />
        <q-badge class="q-mr-sm" rounded color="red" :label="'Absent - ' + attendanceCount.absent" />
      </div>
      <div class="text-h6 q-mt-md">
        Total Attendance Count: {{ attendanceCount.present + attendanceCount.leave + attendanceCount.holiday }} Days
      </div>

      <div class="text-h6">
        Monthly Salary :
        <q-badge v-if="editItem.current_salary" style="margin-right: 5px;color: #000;font-weight: 700;font-size: 18px;padding:5px" rounded color="info"
          :label="editItem.current_salary + 'TK'" />
      </div>
      <div class="text-h6">
        Per Day Salary :
        <q-badge style="margin-right: 5px;color: #000;font-weight: 700;font-size: 15px;padding:5px;margin-left: 5px;"
          rounded color="info" :label="perDaySalary + 'TK'" />
      </div>

      <div class="text-h6 q-mt-md">
        Attendance Wise <b class="text-green">{{ month }}</b> Month Salary :
        <q-badge style="margin-right: 5px;color: #000;font-weight: 700;font-size: 15px;padding:5px;margin-left: 5px;"
          rounded color="green" :label="attendanceWiseSalary + 'TK'" />
      </div>

    </q-card-section>
    <q-card-section style="min-width: 600px !important; overflow-x: hidden" v-if="attendance.length > 0">
      <div class="text-body2 text-center row" style="margin-bottom: 5px" v-for="(item, i) in attendance" :key="i">
        <div class="col-5 text-left offset-3">
          <span class="block" style="margin-left: 2rem" v-if="item.attendance_date">
            {{ dDate(item.attendance_date) }}
          </span>
        </div>
        <div class="col-1" v-if="item.attendance">
          <div style="display: flex">
            <q-badge glossy rounded :color="getColorName(item.attendance)" :label="item.attendance" />
          </div>
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import helperMixin from "../../mixins/helper_mixin.js";
export default {
  props: ["editItem"],
  mixins: [helperMixin],
  data() {
    return {
      attendance: [],
      attendanceCount: {
        present: 0,
        absent: 0,
        holiday: 0,
        leave: 0,
      },
      count_present: null,
      count_absent: null,
      total_amount: 0,
      per_day_amount: 0,
      perDaySalary: 0,
      attendanceWiseSalary: 0,
      month: '',
    };
  },
  mounted() {
    if (this.editItem) {
      this.get_attendance();
    }
  },
  methods: {
    get_attendance: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true;
        const params = {
          employee_id: ref.editItem.id,
          attendance_date: ref.editItem.attendance_date
        }
        let res = await jq.get(ref.apiUrl("api/v1/admin/ajax/get_employee_monthly_attendance_list"), params);
        ref.month = res.data.month
        ref.attendance = res.data.data
        ref.attendanceCount = res.data.attendanceCount
        ref.perDaySalary = res.data.perDaySalary
        ref.attendanceWiseSalary = res.data.attendanceWiseSalary
      } catch (err) {
        ref.notify(this.err_msg(err), "negative");
      } finally {
        ref.loading = false;
      }
    },
    getColorName(attendance) {
      if (attendance == 'Present') {
        return 'green'
      } else if (attendance == 'Absent') {
        return 'red'
      } else if (attendance == 'Leave') {
        return 'orange'
      } else if (attendance == 'Holiday') {
        return 'teal'
      }
    },
    getDaysInCurrentMonth() {
      const date = new Date();

      return new Date(
        date.getFullYear(),
        date.getMonth() + 1,
        0,
      ).getDate();
    }
  },
};
</script>

<style>
.card-bg {
  background-color: #162b4d;
}
</style>
