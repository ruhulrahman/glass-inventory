<template>
  <q-page class="q-pa-sm">
    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('company_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('role_list')" icon="widgets" to="/role-list" />
      <q-breadcrumbs-el :label="$t('add_new_role_permission')" />
    </q-breadcrumbs>
    <q-form @submit="saveData">
      <q-card class="bg-primary text-white no-shadow wait_me" bordered>
        <q-card-section class="row q-pa-sm">
          <q-item class="full-width">
            <q-item-section>
              <q-item-label class="text-h6 text-weight-bolder text-white-8" lines="1">{{ $t('add_new_role_permission')
              }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-card-section>
        <q-separator></q-separator>
        <q-card-section class="q-pa-sm row">
          <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input type="text" dark color="white" round v-model="form.name" :label="$t('role_name')" :rules="[
                (val) => (val && val.length > 0) || 'Enter role name',
              ]" />
            </q-item-section>
          </q-item>
        </q-card-section>
      </q-card>

      <div v-for="(item, index) in permissionList" :key="index">

        <q-card class="bg-primary text-white no-shadow q-mt-lg" bordered>

          <div class="q-pa-sm row">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <q-checkbox
                size="xs"
                :id="'checkbox-' + index"
                :val="item.id"
                v-model="form.role_permission_ids"
                :label="item.name"
                color="green"
                keep-color
                />
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right">
              <q-checkbox
                size="xs"
                :id="'selectAll-' + index"
                class="text-right"
                v-model="item.checkAll"
                :value="true"
                :unchecked-value="false"
                @click="selectAllPermissionDownThisRow(item.checkAll, index)"
                label="Check All"
                color="green"
                keep-color
                />
            </div>
          </div>


          <div class="q-pa-sm row">
            <div class="col-lg-12">
              <q-separator v-if="item.children_pages.length"></q-separator>
              <h6 v-if="item.children_pages.length" style="margin: 10px 10px;">Page</h6>
              <div class="row q-mb-lg" v-if="item.children_pages.length">
                <div class="col-lg-3" v-for="(childPage, childPageIndex) in item.children_pages" :key="childPageIndex">
                  <q-checkbox
                    size="xs"
                    :id="'page-'+index+childPageIndex"
                    v-model="form.role_permission_ids"
                    :val="childPage.id"
                    :label="childPage.name"
                    color="green"
                    keep-color
                    />
                </div>
              </div>

              <q-separator v-if="item.children_operations.length"></q-separator>
              <h6 v-if="item.children_operations.length" style="margin: 10px 10px;">Operation</h6>
              <div class="row" v-if="item.children_operations.length">
                <div class="col-lg-3" v-for="(childOperation, childOperationIndex) in item.children_operations" :key="childOperationIndex">
                  <q-checkbox
                    size="xs"
                    :id="'operation-'+index+childOperationIndex"
                    v-model="form.role_permission_ids"
                    :val="childOperation.id"
                    :label="childOperation.name"
                    color="green"
                    keep-color
                    />
                </div>
              </div>

            </div>
          </div>

        </q-card>
      </div>

      <q-card-actions align="right">
        <q-btn glossy type="submit" color="green-7" class="text-capitalize q-mr-md q-mb-md text-primary">
          {{ $t('save') }}
        </q-btn>
      </q-card-actions>
    </q-form>
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
import AddOrUpdate from "./AddOrUpdate2.vue";

export default {
  name: "PermissionList",
  mixins: [helperMixin],
  components: {
    AddOrUpdate,
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
      showAddNewDialog: false,
      loading: false,
      listData: [],
      editItem: '',
      form: {
        name: '',
        type: 'Users',
        code: '',
        role_permission_ids: []
      },
      permissionList: [],
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
  watch: {
    'form.name': function (name) {
      const nameLowerCase = name.toLowerCase()
      const roleCode = nameLowerCase.replaceAll(' ', '_')
      this.form.code = roleCode
    },
  },
  mounted() {
    const roleId = this.$route.params.role_id
    if (roleId) {
      this.getPermissionsByRole()
    }
    this.getPermissionList()
  },
  methods: {
    selectAllPermissionDownThisRow(checkAll, index) {
      const permissionObj = this.permissionList.find((item, localIndex) => localIndex === index)
      if (checkAll) {
        if (permissionObj.children_pages.length) {
          permissionObj.children_pages.forEach(item => {
            this.form.role_permission_ids.push(item.id)
          })
        }
        if (permissionObj.children_operations.length) {
          permissionObj.children_operations.forEach(item => {
            this.form.role_permission_ids.push(item.id)
          })
        }
        this.form.role_permission_ids.push(permissionObj.id)
      } else {
        if (permissionObj.children_pages.length) {
          permissionObj.children_pages.forEach(item => {
            const itemIndex = this.form.role_permission_ids.indexOf(item.id)
            this.form.role_permission_ids.splice(itemIndex, 1)
          })
          // console.log('pagePermissionIds', pagePermissionIds)
        }
        if (permissionObj.children_operations.length) {
          permissionObj.children_operations.forEach(item => {
            const itemIndex = this.form.role_permission_ids.indexOf(item.id)
            this.form.role_permission_ids.splice(itemIndex, 1)
          })
        }
        const itemIndex = this.form.role_permission_ids.indexOf(permissionObj.id)
        this.form.role_permission_ids.splice(itemIndex, 1)
      }
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
    goToRole() {
      this.$router.go(-1)
    },
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        ref.wait_me(".wait_me");
        let res = ''
        if (this.form.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_role_permission_data'), this.form);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_role_permission_data'), this.form);
        }
        this.notify(res.msg)
        this.$router.push('/role-list')
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    },
    async getPermissionsByRole() {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_permissions_by_role_id'), { role_id: this.$route.params.role_id });
        this.form = res.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    async getPermissionList() {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_permission_parent_and_child_list'), { role_id: this.$route.params.role_id });
        this.permissionList = res.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
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

