<template>
  <q-page class="q-pa-sm">
    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('company_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('role_list')" />
    </q-breadcrumbs>
    <q-card class="no-shadow" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">{{ $t('role_list') }}</div>
          <div class="col-2 text-right">
            <q-btn glossy flat color="white" class="bg-green-7 d-block"
              style="text-transform: capitalize; padding: 0px 10px 0 19px" @click="openAddNewDialog()">
              <q-icon name="add_circle" style="margin-left: -13px !important"></q-icon>
              {{ $t('add_new_role') }}
            </q-btn>
          </div>
        </div>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-none">
        <!-- <q-toggle v-model="loading" label="Loading state" class="q-mb-md" /> -->
        <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow wait_me" :rows="tableRow" :columns="columns"
          row-key="name" no-data-label=" I didn't find anything for you" :loading="loading"
          :pagination="initialPagination" :filter="filter">
          <template v-slot:top-right>
            <q-input v-if="show_filter" filled borderless dense debounce="300" v-model="filter" placeholder="Search">
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>

            <q-btn class="q-ml-sm" icon="filter_list" @click="show_filter = !show_filter" flat />
          </template>
          <template v-slot:no-data="{ icon, message, filter }">
            <div class="full-width row flex-center text-red q-gutter-sm">
              <q-icon size="2em" name="sentiment_dissatisfied" />
              <span>
                Well this is sad... {{ message }}
              </span>
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
              <q-td key="type" :props="props">
                {{ props.row.type }}
              </q-td>
              <q-td key="name" :props="props">
                {{ props.row.name }}
              </q-td>
              <q-td key="status" :props="props">
                <q-badge :color="props.row.status_color">
                  {{ props.row.status }}
                </q-badge>
              </q-td>
              <q-td key="action" :props="props">
                <q-btn @click="editData(props.row)" icon="edit" size="sm" flat dense></q-btn>
                <q-btn @click="deleteData(props.row)" icon="delete" size="sm" class="q-ml-sm" flat dense />
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>
    </q-card>
    <!-- <q-dialog v-model="showAddNewDialog" position="right">
        <add-or-update :title="editItem.id ? $t('update') : $t('add_new_permission')" :parentList="parentList"
        :editItem="editItem" @reloadListData="getListData" @closeModal="showAddNewDialog = false" />
    </q-dialog> -->
  </q-page>
</template>

<script>
import { useMeta, Dialog } from "quasar";
import helperMixin from "../../../mixins/helper_mixin.js";
import DialogConfirmationComponent from 'src/components/DialogConfirmationComponent.vue'
import { ref } from "vue";
const metaData = {
  title: "Permission List",
  titleTemplate: (title) => `${title} - Inventory App`,
};
// import AddOrUpdate from "./AddOrUpdate.vue";

export default {
  name: "PermissionList",
  mixins: [helperMixin],
  components: {
    // AddOrUpdate,
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
      loading: false,
      departments: [],
      listData: [],
      parentList: [],
      editItem: '',
      search: {
        name: '',
        code: '',
        type: null
      },
      typeList: [
        { value: 'Page', label: 'Page' },
        { value: 'Feature', label: 'Feature' }
      ]
    };
  },
  computed: {
    tableRow: function () {
      if (this.listData.length) {
        return this.listData.map((item, i) => {
          item.sl = i + 1
          item.active = item.active ? true : false
          item.status = item.active ? 'Active' : 'Inactive'
          item.status_color = item.active ? 'green' : 'red'
          return Object.assign(item)
        })
      } else {
        return []
      }
    },
    columns: function () {
      return [
        { name: "sl", required: true, label: this.$t('sl'), align: "left", field: (row) => row.sl, format: (val) => `${val}`, sortable: true },
        { name: "type", label: this.$t('type'), align: "left", field: (row) => row.name, format: (val) => `${val}`, sortable: true },
        { name: "name", label: this.$t('name'), field: "name", align: "left" },
        { name: "status", label: this.$t('status'), field: "status", align: "left" },
        { name: "action", label: this.$t('action'), field: "action", sortable: false, align: "center" },
      ];
    }
  },
  mounted() {
    this.getListData();
  },
  methods: {
    openAddNewDialog: function () {
      this.$router.push('/add-or-update-role')
    },
    getListData: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_role_list'), this.search);
        this.listData = res.data.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    editData: async function (item) {
      this.editItem = this.clone_object(item)
      this.showAddNewDialog = true
    },
    deleteData: async function (item) {
      Dialog.create({
        componentProps: {
          title: 'something',
          message: 'something',
          // position: 'standard',
        },
        component: DialogConfirmationComponent,
      }).onOk(() => {
        this.deleteDataConfirmed(item)
      })
    },
    deleteDataConfirmed: async function (item) {
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me");

      try {
        let res = await jq.post(ref.apiUrl('api/v1/admin/ajax/delete_role_permission_data'), item);
        this.notify(res.msg)
        this.getListData()

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    }
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

