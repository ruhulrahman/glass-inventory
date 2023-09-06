<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el label="Dashboard" icon="home" to="/"/>
      <q-breadcrumbs-el label="Product Management" icon="widgets" to="/" />
      <q-breadcrumbs-el label="Sales" />
    </q-breadcrumbs>

    <q-card class="no-shadow" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">Sales</div>
          <div class="col-2 text-right">
            <q-btn glossy to="/add-or-update-invoice" flat color="white" class="bg-green-7 d-block"
              style="text-transform: capitalize; padding: 0px 10px 0 19px">
              <q-icon name="add_circle" style="margin-left: -13px !important"></q-icon>
              Add New Sale
            </q-btn>
          </div>
        </div>
        <q-btn @click="downloadInvoice()">Download Pdf</q-btn>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-none">
        <!-- <q-toggle v-model="loading" label="Loading state" class="q-mb-md" /> -->
        <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow wait_me" :rows="tableRow" :columns="columns"
          row-key="name" no-data-label=" I didn't find anything for you"
          :loading="loading"
          :pagination="initialPagination"
          :filter="filter">
          <template v-slot:loading>
            <q-inner-loading showing color="primary" />
          </template>
          <template v-slot:top-right>
            <q-input v-if="show_filter" clearable filled borderless dense debounce="300" v-model="filter" placeholder="Search">
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
                <router-link class="text-blue text-weight-bold" :to="`/invoice-details/${hash_id(props.row.id)}`">#{{ props.row.invoice_code }}</router-link>
              </q-td>
              <q-td key="customer" :props="props">
                {{ props.row.customer_name }} <br/>
                <small>{{ props.row.customer_phone }}</small>
              </q-td>
              <q-td key="invoice_date" :props="props">
                {{ props.row.invoice_date }}
              </q-td>
              <q-td key="total_payable_amount" :props="props">
                {{ props.row.total_payable_amount }}
              </q-td>
              <q-td key="paid_amount" :props="props">
                {{ props.row.paid_amount }}
              </q-td>
              <q-td key="due_amount" :props="props">
                {{ props.row.due_amount }}
              </q-td>
              <q-td key="payment_status" :props="props">
                <q-badge :color="props.row.payment_status_color">
                  {{ props.row.payment_status_name }}
                </q-badge>
              </q-td>
              <q-td key="action" :props="props">
                <q-btn @click="getProductInvoiceDataById(props.row)" icon="cloud_download" size="sm" class="text-green" flat dense>
                <q-tooltip class="bg-primary" transition-show="scale" transition-hide="scale" anchor="bottom middle" self="center middle">
                    Download
                  </q-tooltip>
                </q-btn>
                <q-btn @click="viewDetails(props.row)" icon="visibility" size="sm" class="text-blue" flat dense>
                  <q-tooltip class="bg-primary" transition-show="scale" transition-hide="scale" anchor="bottom middle" self="center middle">
                    View Details
                  </q-tooltip>
                </q-btn>
                <q-btn @click="editData(props.row)" icon="edit" size="sm" class="text-teal" flat dense></q-btn>
                <q-btn @click="deleteData(props.row)" icon="delete" size="sm" class="text-red" flat dense />
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>

    </q-card>

    <!-- <vue-html2pdf
                :image="{ type: 'jpg', quality: 1 }"
                :html2canvas="{dpi: 192, letterRendering: true, useCORS: true}"
                :show-layout="false"
                :margin="[100, 100, 100, 100]"
                :float-layout="true"
                :enableLinks="false"
                :enable-download="false"
                :preview-modal="true"
                :paginate-elements-by-height="1400"
                :filename="invoiceDetails ? this.cn(this.invoiceDetails, 'client_lead.first_name') +'-id-' + invoiceDetails.invoice_code : 'Invoice Details'" :pdf-quality="2"
                :manual-pagination="true"
                pdf-format="a4"
                pdf-margin="20"
                pdf-orientation="landscape"
                pdf-content-width="1115px"
                @progress="onProgress($event)"
                ref="invoiceDetailsPdfRef">
                <section slot="pdf-content">

                </section>
            </vue-html2pdf> -->

            <!-- <vue3-html2pdf
            :show-layout="false"
        :float-layout="true"
        :enable-download="true"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        filename="hee hee"
        :pdf-quality="2"
        :manual-pagination="false"
        pdf-format="a4"
        pdf-orientation="landscape"
        pdf-content-width="800px"
              ref="invoiceDetailsPdfRef"
            >
              <template  v-slot:pdf-content>

            <invoice-details-pdf
                    :invoiceDetails="invoiceDetails"
                    />
              </template>
          </vue3-html2pdf> -->
            <!-- <invoice-details-pdf
                    :invoiceDetails="invoiceDetails"
                    /> -->
  </q-page>
</template>

<script>
import { ref } from 'vue'
import { useMeta, useQuasar, Dialog, Loading } from 'quasar'
import helperMixin from 'src/mixins/helper_mixin.js'
import DialogConfirmationComponent from 'src/components/DialogConfirmationComponent.vue'
import InvoiceDetailsPdf from './InvoiceDetailsPdf.vue'

// import VueHtml2pdf from 'vue3-html2pdf'
// import Vue3Html2pdf from 'vue3-html2pdf'
// Vue.use(VueHtml2pdf)

const metaData = { title: 'Sale List' }

const columns = [
  { name: "sl", label: "Sl.", field: "sl", sortable: true, align: "left" },
  { name: "invoice_code", field: "invoice_code", label: "Invoice Code", sortable: true, align: "left" },
  { name: "customer", field: "customer",  label: "Customer", sortable: true, align: "left" },
  { name: "invoice_date", field: "invoice_date",  label: "Invoice Date", sortable: true, align: "left" },
  { name: "total_payable_amount", field: "total_payable_amount",  label: "Payable Amount", sortable: true, align: "right" },
  { name: "paid_amount", field: "paid_amount",  label: "Paid Amount", sortable: true, align: "right" },
  { name: "due_amount", field: "due_amount",  label: "Due Amount", sortable: true, align: "right" },
  { name: "payment_status", field: "payment_status", label: "Payment Status", sortable: true, align: "center" },
  { name: "action", field: "Action", label: "Action", sortable: false, align: "center" },
];

export default ({
  name: "SaleList",
  mixins: [helperMixin],
  components: {
    // Vue3Html2pdf,
    InvoiceDetailsPdf
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
      invoiceDetails: '',
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
          item.invoice_date = item.invoice_date ? this.dDate(item.invoice_date) : ''
          return Object.assign(item)
        })
      } else {
        return []
      }
    }
  },
  mounted() {
    this.getListData();
    // this.getInitialData();
  },
  methods: {
    openAddNewDialog: function() {
      this.editItem = ''
      this.showAddNewDialog = true
    },
    getListData: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_invoice_list'));
        this.listData = res.data.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    viewDetails: function (item) {
      this.$router.push(`/invoice-details/${this.hash_id(item.id)}`)
    },
    editData: function (item) {
      // this.$router.push({path: '/add-or-update-invoice', params: { id: item.id }})
      this.$router.push(`/add-or-update-invoice/${this.hash_id(item.id)}`)
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
        let res = await jq.post(ref.apiUrl('api/v1/admin/ajax/delete_product_invoice_data'), item);
        this.notify(res.msg)
        this.getListData()

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    },
    getProductInvoiceDataById: async function (productInvoiceId) {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_invoice_data_by_id'), { id: productInvoiceId});
        this.invoiceDetails = res.data.productInvoice
        this.downloadInvoice()
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    downloadInvoice: async function () {
        // this.companyImageFile = await this.getBase64ImageFromURL(this.cn(this.companyInfo, 'logo_url'))
        // this.$refs.invoiceDetailsPdfRef.generatePdf()
        var ref=this;
        var jq=this.jq();
        // await jq.get(ref.apiUrl('api/v1/admin/ajax/generate_invoice_pdf'));
        window.location.href = ref.apiUrl('api/v1/admin/generate_invoice_pdf');
        // const search = {
        //   user_id: localStorage.getItem('auth_user_id'),
        //   id: 1,
        // }
        // var search_query = jq.param(search)
        // this.download_url += '?' + search_query
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

