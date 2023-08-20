<template>
    <q-card class="card-bg text-white no-shadow" bordered style="width: 700px; max-width: 80vw;">
          <q-card-section class="text-center bg-transparent">
            <q-avatar size="100px" class="shadow-10">
              <img v-if="editItem.photo" :src="apiUrl('/uploads/photo/')+editItem.photo">
              <img v-else :src="apiUrl('/uploads/demo.jpg')">
            </q-avatar>
            <div class="text-h6 q-mt-md">{{editItem.name}}</div>
            <div class="text-h6 q-mt-md">{{editItem.phone1}}</div>
          </q-card-section>
          <q-card-section style="min-width: 600px !important;overflow-x: hidden;">
            <div class="text-body2 text-justify row">
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Name</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.name}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Email</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.email}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Primary Phone</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.phone1}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Secondary Primary Phone</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.phone2}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Date Of Birth</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.dob}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">NID</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.nid}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Gender</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.gender}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Religion</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.religion}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Present Address</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.present_address}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Permanent Address</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.permanent_address}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Designation</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.designation}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Current Salary</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.current_salary}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Joining Date</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.joining_date}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">Status</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.active ? 'Active' : 'Inactive'}}</span>
                </div>
            </div>
          </q-card-section>
    </q-card>
</template>

<script>
import helperMixin from "../../../mixins/helper_mixin.js";
export default {
    props:["editItem"],
    mixins: [helperMixin]
}
</script>

<style>
    .card-bg {
        background-color: #162b4d;
    }
</style>
