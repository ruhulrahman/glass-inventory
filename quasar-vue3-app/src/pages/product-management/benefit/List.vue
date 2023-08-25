<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el label="Dashboard" icon="home" to="/" />
      <q-breadcrumbs-el label="Product Management" icon="widgets" to="/" />
      <q-breadcrumbs-el label="Benefit & Loss" />
    </q-breadcrumbs>

    <q-card class="no-shadow" bordered>
      <q-card-section class="q-pa-none">
        <div class="">
          <div style="max-width: 600px">
            <q-tabs v-model="tab" align="justify" narrow-indicator class="q-mb-xs">
              <q-tab class="text-purple" name="invoice_wise" label="Invoice Wise" />
              <q-tab class="text-orange" name="product_wise" label="Product Wise" />
            </q-tabs>
          </div>

          <q-separator></q-separator>

          <q-tab-panels v-model="tab" animated transition-prev="scale" transition-next="scale">
            <q-tab-panel name="invoice_wise" class="q-pa-none">
              <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow  q-pa-none q-ma-none" :rows="tableRow"
                :columns="columns" row-key="name" no-data-label=" I didn't find anything for you" :loading="loading"
                :pagination="initialPagination" :filter="filter">
                <template v-slot:loading>
                  <q-inner-loading showing color="primary" />
                </template>
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
                    <q-td key="invoice_code" :props="props">
                      <router-link class="text-blue text-weight-bold"
                        :to="`/invoice-details/${hash_id(props.row.id)}`">#{{
                          props.row.invoice_code }}</router-link>
                    </q-td>
                    <q-td key="invoice_date" :props="props">
                      {{ props.row.invoice_date }}
                    </q-td>
                    <q-td key="benefit_amount" :props="props">
                      {{ props.row.benefit_amount }}
                    </q-td>
                    <q-td key="loss_amount" :props="props">
                      {{ props.row.loss_amount }}
                    </q-td>
                    <q-td key="action" :props="props">
                      <q-btn @click="viewDetails(props.row)" icon="visibility" size="sm" class="text-blue" flat dense>
                        <q-tooltip class="bg-primary" transition-show="scale" transition-hide="scale"
                          anchor="bottom middle" self="center middle">
                          View Benefit & Loss Details
                        </q-tooltip>
                      </q-btn>
                    </q-td>
                  </q-tr>
                </template>
              </q-table>
            </q-tab-panel>
            <q-tab-panel name="product_wise" class="q-pa-none">

              <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow  q-pa-none q-ma-none" :rows="tableRow"
                :columns="columns" row-key="name" no-data-label=" I didn't find anything for you" :loading="loading"
                :pagination="initialPagination" :filter="filter">
                <template v-slot:loading>
                  <q-inner-loading showing color="primary" />
                </template>
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
                    <q-td key="invoice_code" :props="props">
                      <router-link class="text-blue text-weight-bold"
                        :to="`/invoice-details/${hash_id(props.row.id)}`">#{{
                          props.row.invoice_code }}</router-link>
                    </q-td>
                    <q-td key="invoice_date" :props="props">
                      {{ props.row.invoice_date }}
                    </q-td>
                    <q-td key="benefit_amount" :props="props">
                      {{ props.row.benefit_amount }}
                    </q-td>
                    <q-td key="loss_amount" :props="props">
                      {{ props.row.loss_amount }}
                    </q-td>
                    <q-td key="action" :props="props">
                      <q-btn @click="viewDetails(props.row)" icon="visibility" size="sm" class="text-blue" flat dense>
                        <q-tooltip class="bg-primary" transition-show="scale" transition-hide="scale"
                          anchor="bottom middle" self="center middle">
                          View Benefit & Loss Details
                        </q-tooltip>
                      </q-btn>
                    </q-td>
                  </q-tr>
                </template>
              </q-table>
            </q-tab-panel>
          </q-tab-panels>
        </div>
      </q-card-section>
    </q-card>

    <q-dialog fullWidth v-model="showDetailDialog">
      <detail-dialog :listData="detailItems" @reloadListData="getInvoiceWiseLis" @closeModal="showDetailDialog = false" />
    </q-dialog>

  </q-page>
</template>

<script>
import { useMeta, useQuasar, Dialog, Loading } from 'quasar'
import helperMixin from 'src/mixins/helper_mixin.js'
import DialogConfirmationComponent from 'src/components/DialogConfirmationComponent.vue'
import { ref } from 'vue'
import DetailDialog from "./DetailDialog.vue"

const metaData = { title: 'Benefit List' }

const columns = [
  { name: "sl", label: "Sl.", field: "sl", sortable: true, align: "left" },
  { name: "invoice_code", field: "invoice_code", label: "Invoice Code", sortable: true, align: "left" },
  { name: "invoice_date", field: "invoice_date", label: "Invoice Date", sortable: true, align: "left" },
  { name: "benefit_amount", field: "benefit_amount", label: "Benefit Amount", sortable: true, align: "right" },
  { name: "loss_amount", field: "loss_amount", label: "Loss Amount", sortable: true, align: "right" },
  { name: "action", field: "Action", label: "Action", sortable: false, align: "center" },
];

export default ({
  name: "BenefitList",
  mixins: [helperMixin],
  components: {
    DetailDialog
  },
  setup() {
    useMeta(metaData);
    const show_filter = ref(false);

    return {
      filter: ref(""),
      show_filter,
      columns,
      tab: ref('invoice_wise')
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
          item.customer_name = item.customer ? item.customer.name : ''
          item.customer_phone = item.customer ? item.customer.phone : ''
          item.payment_status_name = item.payment_status ? item.payment_status.name : ''
          item.payment_status_color = item.payment_status ? item.payment_status.color_name : ''
          return Object.assign(item)
        })
      } else {
        return []
      }
    }
  },
  mounted() {
    this.getInvoiceWiseLis();
    this.getProductWiseLis();
  },
  methods: {
    openAddNewDialog: function () {
      this.editItem = ''
      this.showAddNewDialog = true
    },
    getInvoiceWiseLis: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_benefit_and_loss_by_invoice_wise'));
        this.listData = res.data.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    getProductWiseLis: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_benefit_and_loss_by_product_wise'));
        this.listData = res.data.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    viewDetails: function (item) {
      this.$router.push(`/benefit-or-loss-details/${this.hash_id(item.id)}`)
    },
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

