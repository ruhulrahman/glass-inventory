<template>
  <q-page class="q-pa-sm">
    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('company_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('user_list')" />
    </q-breadcrumbs>
    <q-card class="no-shadow" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">{{ $t('user_list') }}</div>
          <div class="col-2 text-right">
            <q-btn glossy flat color="white" class="bg-green-7 d-block"
              style="text-transform: capitalize; padding: 0px 10px 0 19px" @click="openAddNewDialog()">
              <q-icon name="add_circle" style="margin-left: -13px !important"></q-icon>
              {{ $t('add_new_user') }}
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
              <q-td key="name" :props="props">
                {{ props.row.name }}
              </q-td>
              <q-td key="username" :props="props">
                {{ props.row.username }}
              </q-td>
              <q-td key="email" :props="props">
                {{ props.row.email }}
              </q-td>
              <!-- <q-td key="user_type" :props="props">
                {{ props.row.user_type }}
              </q-td> -->
              <q-td key="user_role" :props="props">
                {{ props.row.role ? props.row.role.name : ''}}
              </q-td>
              <q-td key="photo" :props="props">
                <img v-if="props.row.avatar" style="width: 50px; height: 50px; border-radius: 100%;"
                  :src="props.row.avatar">
                <img v-else style="width: 50px;border-radius: 50px;" :src="apiUrl('uploads/demo.jpg')">
              </q-td>
              <q-td key="status" :props="props">
                <q-badge :color="props.row.status_color">
                  {{ props.row.status }}
                </q-badge>
              </q-td>
              <q-td key="action" :props="props">
                <q-btn @click="detailsData(props.row)" icon="visibility" class="text-blue" size="sm" flat dense></q-btn>
                <q-btn @click="editData(props.row)" icon="edit" size="sm" flat dense></q-btn>
                <q-btn v-if="props.row.role.code != 'super_admin'" @click="deleteData(props.row)" icon="delete" size="sm" class="q-ml-sm" flat dense />
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>
    </q-card>
    <q-dialog v-model="showAddNewDialog" position="right">
      <create-user :title="editItem.id ? $t('update') : $t('add_new_user')"
        :companies="companies"
        :editItem="editItem"
        :roleList="roleList"
        @reloadListData="getListData"
        @closeModal="showAddNewDialog = false"
        />
    </q-dialog>

    <div class="q-pa-md q-gutter-sm">
      <q-dialog v-model="showDetailsDialog">

        <details-component :title="editItem.name + ' Details'" :editItem="editItem"
          @closeModal="showDetailsDialog = false" />
      </q-dialog>
    </div>

  </q-page>
</template>

<script>
import { useMeta, Dialog } from "quasar";
import helperMixin from 'src/mixins/helper_mixin.js'
import DialogConfirmationComponent from 'src/components/DialogConfirmationComponent.vue'
import { ref } from "vue";
const metaData = {
  title: "User List",
  titleTemplate: (title) => `${title} - Inventory App`,
};
import createUser from "./AddOrUpdate.vue";
import DetailsComponent from "./Profile.vue";

export default {
  name: "CompanyList",
  mixins: [helperMixin],
  components: {
    createUser,
    DetailsComponent
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
      roleList: [],
      editItem: '',
      showDetailsDialog: false
    };
  },
  computed: {
    tableRow: function () {
      if (this.listData.length) {
        return this.listData.map((item, i) => {
          item.sl = i + 1
          item.name = item.name
          item.username = item.username
          item.emaill = item.emaill
          item.photo = item.photo ? item.photo : 'NA'
          item.user_type = item.user_type
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
        { name: "sl", label: this.$t('sl'), field: "sl", sortable: true, align: "left" },
        { name: "name", required: true, label: this.$t('name'), align: "left", field: (row) => row.name, format: (val) => `${val}`, sortable: true },
        { name: "username", required: true, align: "left", label: this.$t('username'), field: "username" },
        { name: "email", label: this.$t('email'), field: "email", align: "left" },
        // { name: "user_type", label: this.$t('user_type'), field: "user_type" },
        { name: "user_role", label: this.$t('user_role'), field: "user_role", align: "left" },
        { name: "photo", label: this.$t('photo'), field: "photo" },
        { name: "status", label: this.$t('status'), field: "status", sortable: true },
        { name: "action", field: "Action", label: this.$t('action'), sortable: false, align: "center" }
      ];
    }
  },
  mounted() {
    this.getListData();
    this.getRoleList();
  },
  methods: {
    openAddNewDialog: function () {
      this.editItem = ''
      this.showAddNewDialog = true
    },
    getListData: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_user_list_with_pagination'));
        this.listData = res.data.data.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    getRoleList: async function () {
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me1");

      try {
        let res = "";
        res = await jq.get(
          ref.apiUrl("api/v1/admin/ajax/get_role_dropdown_list")
        );
        ref.roleList = res.data;
        console.log('res.data.data', res.data)
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        ref.wait_me(".wait_me1", "hide");
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
        let res = await jq.post(ref.apiUrl('api/v1/admin/ajax/delete_user_data'), item);
        this.notify(res.msg)
        this.getListData()

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    },
    detailsData: async function (item) {
      this.editItem = this.clone_object(item)
      // console.log(this.editItem);
      this.showDetailsDialog = true
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

