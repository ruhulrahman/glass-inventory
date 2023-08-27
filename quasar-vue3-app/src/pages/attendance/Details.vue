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
      <div class="text-h6 q-mt-md">{{ editItem.name }}</div>
      <div class="text-h6 q-mt-md">
        Attendance List of {{ dMonth(new Date().toISOString().slice(0, 10)) }}
      </div>
      <div class="text-h6 q-mt-md">
        Total
        <div class="">
            <q-badge
              style="margin-right: 5px;"
              rounded
              color="orange"
              title="Current Month Total Present"
              :label="'Present - '+count_present"
            />

            <q-badge
              rounded
              color="red"
              title="Current Month Total Absent"
              :label="'Absent - '+count_absent"
            />
          </div>
      </div>
    </q-card-section>
    <q-card-section style="min-width: 600px !important; overflow-x: hidden" v-if="attendance.length > 0">
      <div class="text-body2 text-center row" style="margin-bottom: 5px;" v-for="(item, i) in attendance" :key="i">
        
        <div class="col-5 text-left offset-3">
          <span class="block" style="margin-left: 2rem" v-if="item.date">
            {{ i + 1 }}.
            {{dDayDate(item.date)}}
          </span>
        </div>
        <div class="col-1" v-if="item.date && item.present != null">
          <!-- <span class="block">{{ editItem.name }}</span> -->
          <div class="">
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
        this.attendance = res.data.data
        this.count_present = res.data.count_present
        this.count_absent = res.data.count_absent
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style>
.card-bg {
  background-color: #162b4d;
}
</style>
