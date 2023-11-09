<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('sales_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('sales')" icon="widgets" to="/sale-list" />
      <q-breadcrumbs-el>{{ $t('invoice_details') }}</q-breadcrumbs-el>
    </q-breadcrumbs>

    <q-card class="no-shadow q-mb-xl" bordered id="element-to-convert">
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">{{ $t('invoice_details') }}</div>
          <div class="col-2 text-right">

            <!-- <q-btn glossy @click="printDocument()" flat color="white" class="bg-secondary d-block" -->
            <q-btn glossy @click="downloadInvoice()" flat color="white" class="bg-secondary d-block"
              style="text-transform: capitalize; padding: 0px 10px 0 19px">
              Download
            </q-btn>
            <!-- <a :href="download_url" download class="q-btn q-btn-item">Download</a> -->
            <!-- <q-btn glossy flat color="white" class="bg-green-7 d-block"
              style="text-transform: capitalize; padding: 0px 10px 0 19px" @click="openAddNewDialog()">
              <q-icon name="add_circle" style="margin-left: -13px !important"></q-icon>
              Add New Sale
            </q-btn> -->
          </div>
        </div>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-none" id="divToPrint">
        <q-list class="row q-mt-md">

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('customer') }}</q-item-label>
              <q-item-label caption>{{ submitForm.customer ? submitForm.customer.name : '' }}</q-item-label>
              <q-item-label caption>{{ submitForm.customer ? submitForm.customer.phone : '' }}</q-item-label>
            </q-item-section>
          </q-item>

          <q-item v-if="showCustomerAddField" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="submitForm.customer_name" label="Customer name" />
            </q-item-section>
          </q-item>

          <q-item v-if="showCustomerAddField" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="submitForm.customer_phone" label="Customer phone"
                :rules="[val => val && val.length > 0 && showCustomerAddField == true || 'Please enter customer phone']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('invoice_code') }}</q-item-label>
              <q-item-label caption>#{{ submitForm.invoice_code }}</q-item-label>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('invoice_date') }}</q-item-label>
              <q-item-label caption>{{ dDate(submitForm.invoice_date) }}</q-item-label>
            </q-item-section>
          </q-item>

        </q-list>
        <q-table dense hide-pagination flat bordered class="no-shadow" :rows="submitForm.details" :columns="columns"
          row-key="name">
          <template v-slot:header="props">
            <q-tr :props="props" class="bg-blue-grey-2 text-primary">
              <q-th v-for="col in props.cols" :key="col.name" :props="props">
                {{ col.label }}
              </q-th>
            </q-tr>
          </template>
          <template v-slot:body="props">
            <q-tr :props="props" class="q-mt-md">
              <q-td key="sl" :props="props">
                {{ props.pageIndex + 1 }}
              </q-td>
              <q-td key="product_type" :props="props" class="q-mt-md">
                {{ props.row.product_type }}
              </q-td>
              <q-td key="category" :props="props" class="q-mt-md">
                {{ props.row.category }}
              </q-td>
              <q-td key="color" :props="props" class="q-mt-md">
                {{ props.row.color }}
              </q-td>
              <q-td key="unit" :props="props" class="q-mt-md">
                {{ props.row.unit }}
              </q-td>
              <q-td key="price" :props="props" class="q-mt-md">
                {{ props.row.price }}
              </q-td>
              <q-td key="quantity" :props="props" class="q-mt-md">
                {{ props.row.quantity }}
              </q-td>
              <q-td key="amount" :props="props" class="q-mt-md" width="15%">
                {{ props.row.amount }}
              </q-td>
            </q-tr>
          </template>
          <template v-slot:bottom-row>
            <q-tr class="bg-blue-grey-1">
              <q-td colspan="7" class="text-right">
                <b>{{ $t('sub_total') }}</b>
              </q-td>
              <q-td class="text-right">
                {{ subTotalAmount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>{{ $t('discount') }} ({{ submitForm.discount_percentage }}%)</b>
              </q-td>
              <q-td class="text-right">
                {{ submitForm.discount_amount }}
              </q-td>
            </q-tr>
            <!-- <q-tr>
              <q-td colspan="7" class="text-right">
                <b>{{ $t('vat') }} ({{ submitForm.vat_percentage }}%)</b>
              </q-td>
              <q-td class="text-right">
                {{ submitForm.vat_amount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>{{ $t('tax') }} ({{ submitForm.tax_percentage }}%)</b>
              </q-td>
              <q-td class="text-right">
                {{ submitForm.tax_amount }}
              </q-td>
            </q-tr> -->
            <q-tr class="bg-blue-grey-1">
              <q-td colspan="7" class="text-right">
                <b>{{ $t('total_payable_amount') }}</b>
              </q-td>
              <q-td class="text-right">
                {{ submitForm.total_payable_amount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>{{ $t('paid_amount') }}</b>
              </q-td>
              <q-td class="text-right">
                {{ submitForm.paid_amount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>{{ $t('due_amount') }}</b>
              </q-td>
              <q-td class="text-right">
                <q-badge :color="submitForm.due_amount > 0 ? 'red' : 'black'">
                  {{ submitForm.due_amount }}
                </q-badge>
              </q-td>
            </q-tr>
            <q-tr v-if="submitForm.due_amount > 0">
              <q-td :colspan="showDueAmount ? '7' : '8'" class="text-right">
                <q-btn glossy @click="showDueAmount = !showDueAmount" flat color="white" class="bg-red d-block"
                  style="text-transform: capitalize; padding: 0px 10px 0 19px">
                  {{ $t('pay_now') }}
                </q-btn>
              </q-td>
              <q-td v-if="showDueAmount" class="text-right">
                <q-input bg-color="green-1" type="number" filled dense v-model="pay_due_amount" label="Pay Due Amount"
                  input-class="text-right" />
              </q-td>
            </q-tr>
            <q-tr v-if="submitForm.notes || showDueAmount">
              <q-td colspan="5" class="text-right"></q-td>
              <q-td colspan="4" class="text-right">
                <q-input bg-color="green-1" type="text" filled dense v-model="submitForm.notes" :label="$t('note')"
                  input-class="text-right" />
              </q-td>
            </q-tr>
            <q-tr v-if="showDueAmount">
              <q-td colspan="7" class="text-right">
                <b>{{ $t('payable_later') }}</b>
              </q-td>
              <q-td class="text-right">
                {{ submitForm.due_amount - pay_due_amount }}{{ submitForm.due_amount - pay_due_amount ? '' : '.00' }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>{{ $t('payment_status') }}</b>
              </q-td>
              <q-td class="text-right">
                <q-select :bg-color="submitForm.due_amount > 0 ? 'red-3' : 'green-3'"
                  :disable="submitForm.due_amount > 0 ? false : true" filled dense v-model="submitForm.payment_status_id"
                  label="Status" :options="dropdownList.paymentStatuses" emit-value map-options>
                </q-select>
              </q-td>
            </q-tr>
            <q-tr v-if="submitForm.due_amount > 0">
              <q-td colspan="8" class="text-right">
                <q-btn glossy @click="saveInvoicePayment()" flat color="white" class="bg-green-7 d-block"
                  style="text-transform: capitalize; padding: 0px 10px 0 19px">
                  {{ $t('payment_update') }}
                </q-btn>
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>

    </q-card>
    <!-- <vue3-html2pdf
        :show-layout="false"
        :float-layout="true"
        :enable-download="true"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        :filename="'hee-hee'"
        :pdf-quality="2"
        :manual-pagination="false"
        pdf-format="a4"
        pdf-orientation="landscape"
        pdf-content-width="800px"
        ref="html2Pdf"
    >
        <template  v-slot:pdf-content>
            <h1>Hello World</h1>
        </template>
    </vue3-html2pdf> -->

  </q-page>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'
import pdfMake from 'pdfmake';
// import pdfFonts from 'pdfmake/build/vfs_fonts';
import htmlToPdfmake from 'html-to-pdfmake';
// import Vue3Html2pdf from 'vue3-html2pdf'

export default {
  props: [],
  mixins: [helperMixin],
  components: {
    // flatPickr
    // Vue3Html2pdf
  },
  data() {
    return {
      download_url: '#',
      dropdownList: [],
      showCustomerAddField: false,
      showDueAmount: false,
      pay_due_amount: 0.00,
      datePickerShow: true,
      config: {
        dateFormat: 'Y-m-d',
      },
      submitForm: {
        id: '',
        invoice_code: '',
        customer_id: '',
        customer_name: '',
        customer_phone: '',
        invoice_date: '',
        due_date: '',
        notes: '',
        po_no: '',
        payment_status_id: '',
        sub_total: 0,
        discount_percentage: 0,
        discount_amount: 0.00,
        vat_percentage: 0,
        vat_amount: 0.00,
        tax_percentage: 0,
        tax_amount: 0.00,
        total_payable_amount: 0.00,
        paid_amount: 0.00,
        due_amount: 0.00,
        sending_email_to_customer_count: 0,
        category_id: '',
        unit_id: '',
        color_id: '',
        supplier_id: '',
        product_code: '',
        active: true,
        details: [
          {
            id: '',
            product_type_id: '',
            category_id: '',
            color_id: '',
            unit_id: '',
            product_invoice_id: '',
            product_stock_id: '',
            quantity: 0,
            price: 0.00,
            amount: 0.00,
          }
        ]
      }
    }
  },
  computed: {
    columns: function () {
      return [
        { name: "sl", field: "sl", label: "SL.", align: "left" },
        { name: "product_type", field: "product_type", label: "Product Type", align: "left" },
        { name: "category", align: "center", label: "Category", field: "category", align: "left" },
        { name: "color", label: "Color", field: "color", align: "left" },
        { name: "unit", label: "Unit", field: "unit", align: "left" },
        { name: "price", label: "Unit price", field: "price", align: "center" },
        { name: "quantity", label: "Quantity", field: "quantity", align: "center" },
        { name: "amount", label: "Amount", field: "amount", align: "right" },
      ]
    },
    subTotalAmount: function () {

      let payable_amount = 0.00

      this.submitForm.details.forEach(function (row) {
        if (row.amount && row.amount > 0) {
          payable_amount += parseFloat(row.amount)
        }
      })

      if (this.submitForm.discount_percentage > 0) {
        const discountAmount = parseFloat((this.submitForm.discount_percentage * payable_amount) / 100).toFixed(2)
        this.submitForm.discount_amount = discountAmount
      }

      if (this.submitForm.vat_percentage > 0.1 && payable_amount > 0) {
        this.submitForm.vat_amount = parseFloat((this.submitForm.vat_percentage / 100) * payable_amount).toFixed(2)
      } else {
        this.submitForm.vat_amount = 0
      }

      if (this.submitForm.tax_percentage > 0.1 && payable_amount > 0) {
        this.submitForm.tax_amount = parseFloat((this.submitForm.tax_percentage / 100) * payable_amount).toFixed(2)
      } else {
        this.submitForm.tax_amount = 0
      }

      // this.submitForm.total_payable_amount = ((payable_amount + this.submitForm.vat_amount + this.submitForm.tax_amount) - this.submitForm.discount_amount)
      this.submitForm.total_payable_amount = parseFloat(parseFloat(payable_amount + parseFloat(this.submitForm.vat_amount) + parseFloat(this.submitForm.tax_amount)) - parseFloat(this.submitForm.discount_amount)).toFixed(2)
      this.submitForm.due_amount = parseFloat(this.submitForm.total_payable_amount - this.submitForm.paid_amount).toFixed(2)

      return parseFloat(payable_amount).toFixed(2)
    },
  },
  created() {
    this.getInitialData()
    const productInvoiceId = this.hash_id(this.$route.params.id, false)[0]
    if (productInvoiceId) {
      this.getProductInvoiceDataById(productInvoiceId)
    } else {
      this.$router.push('/sale-list')
    }
    // this.gen_download_url()
  },
  mounted() {
  },
  methods: {
    calculateUnitWisePrice: function (index) {
      var quantity = 0;
      var unit_price = 0;

      if (this.submitForm.details[index].quantity) {
        quantity = this.submitForm.details[index].quantity;
      }

      if (this.submitForm.details[index].price) {
        unit_price = this.submitForm.details[index].price;
      }

      if (quantity >= 0 && unit_price >= 0) {
        this.submitForm.details[index].amount = parseFloat(quantity) * parseFloat(unit_price);
      }
    },
    filterFn(val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.dropdownList.customerList = this.dropdownList.customers.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    removeRow: async function (index) {
      this.submitForm.details.splice(index, 1)
    },
    addNewRow: async function () {
      this.submitForm.details.push({
        id: '',
        product_type_id: null,
        color_id: 10,
        category_id: null,
        product_invoice_id: null,
        product_stock_id: null,
        quantity: 0,
        price: 0,
        amount: 0,
      })
    },
    getProductInvoiceDataById: async function (productInvoiceId) {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_invoice_data_by_id'), { id: productInvoiceId });
        this.submitForm = res.data.productInvoice

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    generateInvoicePdf: async function (productInvoiceId) {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        await jq.get(ref.apiUrl('api/v1/admin/ajax/generate_invoice_pdf'), { id: productInvoiceId });
        // this.submitForm = res.data.productInvoice

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    getInitialData: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_initial_dropdown_list'));
        this.dropdownList = res.data
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      }
    },
    saveInvoicePayment: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        // this.loading(true)
        const params = {
          payment_status_id: this.submitForm.payment_status_id,
          product_invoice_id: this.submitForm.id,
          paid_amount: this.pay_due_amount,
          notes: this.submitForm.notes,
        }
        const res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_product_invoice_payment_data'), params);
        this.notify(res.msg)
        this.$router.push('/sale-list')
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        // this.loading(false)
      }
    },
    gen_download_url: function () {
        var ref=this;
        var jq=this.jq();
        this.download_url = ref.apiUrl('api/v1/admin/download/generate_invoice_pdf/1');
        const search = {
          user_id: localStorage.getItem('auth_user_id'),
          id: 1,
        }
        var search_query = jq.param(search)
        this.download_url += '?' + search_query

    },
    downloadInvoice: function () {
      var ref=this;
      var jq=this.jq();
      this.download_url = ref.apiUrl('api/v1/admin/download/generate_invoice_pdf');
      const search = {
        auth_user_id: localStorage.getItem('auth_user_id'),
        product_invoice_id: this.submitForm.id,
      }
      var search_query = jq.param(search)
      this.download_url += '?' + search_query
      window.location.href = this.download_url
    },
    printDocument() {

      //get table html
      const pdfTable = document.getElementById('divToPrint');
      //html to pdf format
      var html = htmlToPdfmake(pdfTable.innerHTML);

      const documentDefinition = { content: html };
      // pdfMake.vfs = pdfFonts.pdfMake.vfs;
      pdfMake.createPdf(documentDefinition).print();

    }
  },
}
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}
</style>
