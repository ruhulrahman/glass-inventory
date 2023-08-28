<template>
  <q-card
    class="card-bg text-white no-shadow"
    bordered
    style="width: 700px; max-width: 80vw"
  >
    <q-card-section class="text-center bg-transparent">
      <q-avatar size="100px" class="shadow-10">
        <img
          v-if="editItem.photo"
          :src="apiUrl('/uploads/photo/') + editItem.photo"
        />
        <img v-else :src="apiUrl('/uploads/demo.jpg')" />
      </q-avatar>
      <div class="text-h6">{{ editItem.name }}</div>
      <div class="text-h6 q-mt-md">
        Attendance List of {{ dMonth(new Date().toISOString().slice(0, 10)) }}
      </div>
      <div class="text-h6 q-mt-md">
        Total Attendance : 
          <q-badge
            style="margin-right: 5px"
            rounded
            color="orange"
            title="Current Month Total Present"
            :label="'Present - ' + count_present"
          />

          <q-badge
            rounded
            color="red"
            title="Current Month Total Absent"
            :label="'Absent - ' + count_absent"
          />
        <div class="">
          
        </div>
      </div>

      <div class="text-h6">
        Current Salary : 
          <q-badge
            style="margin-right: 5px;color: #000;font-weight: 700;font-size: 18px;padding:5px"
            rounded
            color="info"
            :label="editItem.current_salary+'TK'"
          />
      </div>
      <div class="text-h6">
        Per Day Salary : 
          <q-badge
            style="margin-right: 5px;color: #000;font-weight: 700;font-size: 15px;padding:5px;margin-left: 5px;"
            rounded
            color="info"
            :label="per_day_amount+'TK'"
          />
      </div>

      <div class="text-h6">
        Attendance wise Current Month Salary : 
          <q-badge
            style="margin-right: 5px;color: #000;font-weight: 700;font-size: 15px;padding:5px;margin-left: 5px;"
            rounded
            color="info"
            :label="total_amount+'TK'"
          />
      </div>
      
    </q-card-section>
    <q-card-section
      style="min-width: 600px !important; overflow-x: hidden"
      v-if="attendance.length > 0"
    >
      <div
        class="text-body2 text-center row"
        style="margin-bottom: 5px"
        v-for="(item, i) in attendance"
        :key="i"
      >
        <div class="col-5 text-left offset-3">
          <span class="block" style="margin-left: 2rem" v-if="item.date">
            {{ i + 1 }}.
            {{ dDayDate(item.date) }}
          </span>
        </div>
        <div class="col-1" v-if="item.date && item.present != null">
          <!-- <span class="block">{{ editItem.name }}</span> -->
          <div style="display: flex">
            <q-badge
              rounded
              :color="item.present == 'Yes' ? 'orange' : 'red'"
              title="Current Month Total Present"
              :label="item.present == 'Yes' ? 'Present' : 'Absent'"
            />
            
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
      attendance: [{
        date: null,
        present: null,
      }],
        count_present: null,
        count_absent: null,
        total_amount: 0,
        per_day_amount: 0,
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
        let res = await jq.get(
          ref.apiUrl("api/v1/admin/ajax/get_employee_attendance_list"),
          {id: ref.editItem.id}
        );
       ref.attendance = res.data.data
        if (this.attendance.length > 0) {
          ref.per_day_amount = ref.float2(ref.editItem.current_salary / ref.getDaysInCurrentMonth());
          var amount = ref.editItem.current_salary / ref.getDaysInCurrentMonth();
          var present_count = this.attendance.filter(item => item.present == 'Yes').length;
          ref.total_amount = ref.float2(amount * present_count)
        }
       ref.count_present = res.data.count_present
       ref.count_absent = res.data.count_absent
      } catch (err) {
       ref.notify(this.err_msg(err), "negative");
      } finally {
       ref.loading = false;
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
