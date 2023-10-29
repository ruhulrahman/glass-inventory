<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('product_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('product_stock_list')" />
    </q-breadcrumbs>

    <q-card class="no-shadow" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">{{ $t('product_stock_list') }}</div>
          <div class="col-2 text-right">
            <q-btn glossy flat color="white" class="bg-green-7 d-block"
              style="text-transform: capitalize; padding: 0px 10px 0 19px" @click="openAddNewDialog()">
              <q-icon name="add_circle" style="margin-left: -13px !important"></q-icon>
              {{ $t('add_new_product_stock') }}
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
          <!-- <template v-slot:loading>
            <q-inner-loading showing color="primary" />
          </template> -->
          <template v-slot:top-right>
            <q-input v-if="show_filter" clearable filled borderless dense debounce="300" v-model="filter"
              placeholder="Search">
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
                {{ props.pageIndex + 1 }}
              </q-td>
              <q-td key="type_name" :props="props">
                {{ props.row.type_name }}
              </q-td>
              <q-td key="category_name" :props="props">
                {{ props.row.category_name }}
              </q-td>
              <q-td key="color_name" :props="props">
                {{ props.row.color_name }}
              </q-td>
              <q-td key="unit_name" :props="props">
                {{ props.row.unit_name }}
              </q-td>
              <q-td key="price" :props="props">
                {{ props.row.price }}
              </q-td>
              <q-td key="quantity" :props="props">
                {{ props.row.quantity + ' ' + props.row.unit_name }}
              </q-td>
              <q-td key="cost" :props="props">
                {{ props.row.cost }}
              </q-td>
              <q-td key="stock" :props="props">
                <q-badge rounded color="red">
                  {{ props.row.product_in_stock }}
                </q-badge>
                {{ props.row.unit_name }}
              </q-td>
              <q-td key="selling_price" :props="props">
                {{ props.row.selling_price }}
              </q-td>
              <q-td key="status" :props="props">
                <q-badge :color="props.row.status_color">
                  {{ props.row.status }}
                </q-badge>
              </q-td>
              <q-td key="action" :props="props">
                <q-btn @click="viewDetails(props.row)" icon="visibility" size="sm" class="text-blue" flat dense>
                  <!-- <q-tooltip class="bg-primary" transition-show="scale" transition-hide="scale" anchor="bottom middle" self="center middle">
                    View History
                  </q-tooltip> -->
                </q-btn>
                <q-btn @click="editData(props.row)" icon="edit" size="sm" class="text-teal" flat dense></q-btn>
                <q-btn @click="deleteData(props.row)" icon="delete" size="sm" class="text-red" flat dense />
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>

    </q-card>

    <q-dialog v-model="showAddNewDialog" position="right">
      <add-or-update :dropdownList="dropdowns" :editItem="editItem" @reloadListData="getListData"
        @closeModal="showAddNewDialog = false" />
    </q-dialog>

    <q-dialog fullWidth v-model="showDetailDialog">
      <detail-dialog :listData="detailItems" @reloadListData="getListData" @closeModal="showDetailDialog = false" />
    </q-dialog>

  </q-page>
</template>

<script>
import { useMeta, useQuasar, Dialog, Loading } from 'quasar'
import helperMixin from 'src/mixins/helper_mixin.js'
import DialogConfirmationComponent from 'src/components/DialogConfirmationComponent.vue'
import { ref } from 'vue'
import AddOrUpdate from "./AddOrUpdate.vue"
import DetailDialog from "./DetailDialog.vue"

const metaData = { title: 'Product Stock List' }

const columns = [
  { name: "sl", label: "Sl.", field: "sl", sortable: true, align: "left" },
  { name: "type_name", field: "type_name", label: "Product Type", sortable: true, align: "left" },
  { name: "category_name", align: "center", label: "Category", field: "category_name", sortable: true, align: "left" },
  { name: "color_name", label: "Color", field: "color_name", sortable: true, align: "left" },
  // { name: "unit_name", label: "unit", field: "unit_name", sortable: true, align: "center" },
  { name: "price", label: "Unit price", field: "price", sortable: true, align: "right" },
  { name: "quantity", label: "Quantity", field: "quantity", sortable: true, align: "left" },
  { name: "cost", label: "Cost", field: "cost", sortable: true, align: "right" },
  { name: "stock", label: "Stock", field: "stock", sortable: true, align: "left" },
  { name: "selling_price", label: "Selling price", field: "selling_price", sortable: true, align: "right" },
  { name: "status", label: "Status", field: "status", sortable: true, align: "center" },
  {
    name: "action",
    label: "Action",
    field: "Action",
    sortable: false,
    align: "center",
  },
];

export default ({
  name: "ProductStockList",
  mixins: [helperMixin],
  components: {
    AddOrUpdate, DetailDialog
  },
  setup() {
    useMeta(metaData);
    const show_filter = ref(false);

    return {
      filter: ref(""),
      show_filter,
      columns,
    };
  },
  data() {
    return {
      dropdowns: {
        categories: [],
        suppliers: [],
        productUnits: [],
        productColors: [],
        productTypes: [],
      },
      showAddNewDialog: false,
      showDetailDialog: false,
      loading: false,
      listData: [],
      detailItems: [],
      editItem: '',
    };
  },
  computed: {
    tableRow: function () {
      if (this.listData.length) {
        return this.listData.map(item => {
          item.type_name = item.type ? item.type.name : ''
          item.color_name = item.color ? item.color.name : ''
          item.unit_name = item.unit ? item.unit.name : ''
          item.unit_price = `${item.price} ${item.unit_name}`
          item.category_name = item.category ? item.category.name : ''
          item.supplier_name = item.supplier ? item.supplier.name : ''
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
        { name: "type_name", field: "type_name", label: this.$t('product_type'), sortable: true, align: "left" },
        { name: "category_name", align: "center", label: this.$t('category_name'), field: "category_name", sortable: true, align: "left" },
        { name: "color_name", label: this.$t('color_name'), field: 'color_name', sortable: true, align: "left" },
        // { name: "unit_name", label: "unit", field: "unit_name", sortable: true, align: "center" },
        { name: "price", label: this.$t('unit_price'), field: "price", sortable: true, align: "right" },
        { name: "quantity", label: this.$t('quantity'), field: "quantity", sortable: true, align: "left" },
        { name: "cost", label: this.$t('cost'), field: "cost", sortable: true, align: "right" },
        { name: "stock", label: this.$t('stock'), field: "stock", sortable: true, align: "left" },
        { name: "selling_price", label: this.$t('selling_price'), field: "selling_price", sortable: true, align: "right" },
        { name: "status", label: this.$t('status'), field: "status", sortable: true, align: "center" },
        {
          name: "action",
          label: this.$t('action'),
          field: "Action",
          sortable: false,
          align: "center",
        },
      ];
    }
  },
  mounted() {
    this.getListData();
    this.getInitialData();
  },
  methods: {
    openAddNewDialog: function () {
      this.editItem = ''
      this.showAddNewDialog = true
    },
    getInitialData: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_initial_dropdown_list'));
        this.dropdowns = res.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    getListData: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_stock_list'));
        this.listData = res.data.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    viewDetails: async function (item) {
      console.log('item', item)
      this.detailItems = item.histories
      this.showDetailDialog = true
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
        let res = await jq.post(ref.apiUrl('api/v1/admin/ajax/delete_product_stock_data'), item);
        this.notify(res.msg)
        this.getListData()

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    }
  }
});
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

