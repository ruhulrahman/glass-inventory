<template>

  <q-page class="q-pa-sm">
    <div class="row q-col-gutter-lg">
      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <q-card class="no-shadow" bordered>
          <q-card-section>
            <div class="text-h6 text-grey-8">
              Product Category
            </div>
          </q-card-section>
          <q-separator/>
          <q-card-section>
            {{ text }}
          </q-card-section>
          <q-card-actions align="left">
            <q-btn label="Save Category" class="text-capitalize q-ma-sm" color="indigo-7"/>
          </q-card-actions>
        </q-card>
      </div>
    </div>
  </q-page>

</template>

<script>
import {defineComponent} from 'vue';

export default defineComponent({
  name: "Category",
  setup() {
    return {
      text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
    }
  }
})
</script>

<style scoped>

</style>
