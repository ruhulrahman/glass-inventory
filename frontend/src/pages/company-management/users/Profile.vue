<template>
    <q-card class="card-bg text-white no-shadow" bordered style="width: 700px; max-width: 80vw;">
          <q-card-section class="text-center bg-transparent">
            <q-avatar size="100px" class="shadow-10">
              <img v-if="editItem.photo" :src="apiUrl('/uploads/photo/')+editItem.photo">
              <img v-else :src="apiUrl('/uploads/demo.jpg')">
            </q-avatar>
            <div class="text-h6 q-mt-md">{{editItem.name}}</div>
            <!-- <div class="text-h6 q-mt-md">{{editItem.phone1}}</div> -->
          </q-card-section>
          <q-card-section style="min-width: 600px !important;overflow-x: hidden;">
            <div class="text-body2 text-justify row">
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">{{ $t('name') }}</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.name}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">{{ $t('email') }}</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.email}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">{{ $t('user_type') }}</span>
                </div>
                <div class="col-1">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="block">{{editItem.user_type}}</span>
                </div>
                <div class="col-5">
                    <span class="block" style="margin-left: 2rem;">{{ $t('status') }}</span>
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
