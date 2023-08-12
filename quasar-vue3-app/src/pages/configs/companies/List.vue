<template>
  <q-card class="no-shadow" bordered>
    <q-card-section>
      <div class="row">
        <div class="text-h6 col-10 text-grey-8">Company List</div>
        <div class="col-2 text-right">
          <q-btn
            flat
            color="white"
            class="bg-blue d-block"
            style="text-transform: capitalize; padding: 0px 10px 0 19px"
            @click="
              () => {
                $refs.company_modal.show();
              }
            "
          >
            <q-icon
              name="home"
              style="margin-left: -13px !important"
            ></q-icon>
            Create Company
          </q-btn>
        </div>
      </div>
    </q-card-section>
    <q-separator></q-separator>
    <q-card-section class="q-pa-none">
      <q-table
        square
        class="no-shadow user-list"
        :rows="data"
        :columns="columns"
        row-key="name"
        :filter="filter"
      >
        <template v-slot:top-right>
          <q-input
            v-if="show_filter"
            filled
            borderless
            dense
            debounce="300"
            v-model="filter"
            placeholder="Search"
          >
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>

          <q-btn
            class="q-ml-sm"
            icon="filter_list"
            @click="show_filter = !show_filter"
            flat
          />
        </template>
        <template v-slot:body-cell-Action="props">
          <q-td :props="props">
            <q-btn icon="edit" size="sm" flat dense />
            <q-btn icon="delete" size="sm" class="q-ml-sm" flat dense />
          </q-td>
        </template>
      </q-table>
    </q-card-section>

    <q-dialog ref="company_modal">
      <create-company
        :title="'Create Company'"
        @closeModal="
          () => {
            $refs.company_modal.hide();
          }
        "
      />
    </q-dialog>
  </q-card>
</template>

<script>
import { useMeta } from 'quasar'
import helperMixin from '../../../mixins/helper_mixin.js'
import {ref} from 'vue'
const metaData = {
  title: 'Company List',
  titleTemplate: title => `${title} - Inventory App`,
}
import createCompany from "./CreateCompany.vue";
const data = [
  {
    name: "Frozen Yogurt",
    title: "Company Title",
    address: "Address",
    email: "email",
    logo: "logo",
    total_emp: 10
  },
];
const columns = [
  {
    name: "name",
    required: true,
    label: "Company Name",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "title",
    align: "center",
    label: "Title",
    field: "title",
    sortable: true,
  },
  { name: "address", label: "Address", field: "address", sortable: true },
  { name: "logo", label: "logo", field: "logo" },
  { name: "total_emp", label: "Total Employee", field: "total_emp" },
  {
    name: "Action",
    label: "Action",
    field: "Action",
    sortable: false,
    align: "center",
  },
];

export default({
  name: "CompanyList",
  mixins: [helperMixin],
  components: {
    createCompany,
  },
  setup() {
    useMeta(metaData);
    const show_filter = ref(false);

    return {
      filter: ref(""),
      show_filter,
      data,
      columns,
    };
  },
  data() {
    return {
      opened: false,
    };
  },
  mounted(){
    //  this.getUsers();
  },
  methods:{
    getUsers:async function(){
        let ref = this;
        let jq = ref.jq();
        ref.wait_me(".user-list");

        try {
            // let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_user_list'));
            // this.notify(res.msg)
            // console.log(res.data);
            // localStorage.setItem('api_token', res.data.api_token);

            // this.$router.replace(sessionStorage.getItem('redirectPath') || '/')
            // sessionStorage.removeItem('redirectPath')

            // ref.$router.push('/')

        } catch (err) {
            this.notify(this.err_msg(err), 'negative')
            // $q.notify({ type: 'negative', message: ref.err_msg(err) })
        } finally{
            ref.wait_me(".user-list", "hide");
        }
    }
  
    
  }
});
</script>

<style scoped>
</style>

