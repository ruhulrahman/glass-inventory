<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('sales_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('benefit_and_loss')" icon="widgets" to="/benefit-or-loss-list"/>
      <q-breadcrumbs-el :label="$t('benefit_and_loss_details')"/>
    </q-breadcrumbs>

    <q-card class="no-shadow q-mb-xl" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">{{ $t('benefit_and_loss_details') }}</div>
          <div class="col-2 text-right">
            <!-- <q-btn glossy flat color="white" class="bg-green-7 d-block"
              style="text-transform: capitalize; padding: 0px 10px 0 19px" @click="openAddNewDialog()">
              <q-icon name="add_circle" style="margin-left: -13px !important"></q-icon>
              Add New Sale
            </q-btn> -->
          </div>
        </div>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section class="q-pa-none">
        <q-list class="row q-mt-md">

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('customer') }}</q-item-label>
              <q-item-label caption>{{ submitForm.customer ? submitForm.customer.name : '' }}</q-item-label>
              <q-item-label caption>{{ submitForm.customer ? submitForm.customer.phone : '' }}</q-item-label>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('invoice_code') }}</q-item-label>
              <q-item-label caption><router-link class="text-blue text-weight-bold" :to="`/invoice-details/${hash_id(submitForm.id)}`">#{{ submitForm.invoice_code }}</router-link></q-item-label>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('invoice_date') }}</q-item-label>
              <q-item-label caption>{{ dDate(submitForm.invoice_date) }}</q-item-label>
            </q-item-section>
          </q-item>

        </q-list>
        <q-table dense hide-pagination flat bordered class="no-shadow" :rows="submitForm.details" :columns="columns" row-key="name">
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
              <q-td key="amount" :props="props" class="q-mt-md">
                {{ props.row.amount }}
              </q-td>
              <q-td key="benefit_per_product" :props="props" class="q-mt-md">
                {{ props.row.benefit_per_product }}
              </q-td>
              <q-td key="benefit_amount" :props="props" class="q-mt-md">
                {{ props.row.benefit_amount }}
              </q-td>
              <q-td key="loss_per_product" :props="props" class="q-mt-md">
                {{ props.row.loss_per_product }}
              </q-td>
              <q-td key="loss_amount" :props="props" class="q-mt-md">
                {{ props.row.loss_amount }}
              </q-td>
            </q-tr>
          </template>
          <template v-slot:bottom-row>
            <q-tr class="bg-blue-grey-1">
              <q-td colspan="7" class="text-right">
                <b>{{ $t('total') }}</b>
              </q-td>
              <q-td class="text-right">
                <q-badge color="black">{{ totalAmount }}</q-badge>
              </q-td>
              <q-td></q-td>
              <q-td class="text-right">
                <q-badge color="green">{{ totalBenefitAmount }}</q-badge>
              </q-td>
              <q-td></q-td>
              <q-td class="text-right">
                <q-badge color="red">{{ totalLossAmount }}</q-badge>
              </q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>

    </q-card>

  </q-page>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'

export default {
  props: ['editItem'],
  mixins: [helperMixin],
  components: {
    // flatPickr
  },
  data() {
    return {
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
        note: '',
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
        { name: "sl", field: "sl", label: this.$t('sl'), align: "left" },
        { name: "product_type", field: "product_type", label: this.$t('product_type'), align: "left" },
        { name: "category", align: "center", label: this.$t('category'), field: "category", align: "left" },
        { name: "color", label: this.$t('color'), field: "color", align: "left" },
        { name: "unit", label: this.$t('unit'), field: "unit", align: "left" },
        { name: "price", label: this.$t('unit_price'), field: "price", align: "center" },
        { name: "quantity", label: this.$t('quantity'), field: "quantity", align: "center" },
        { name: "amount", label: this.$t('amount'), field: "amount", align: "right" },
        { name: "benefit_per_product", label: this.$t('benefit_per_product'), field: "benefit_per_product", align: "right" },
        { name: "benefit_amount", label: this.$t('benefit_amount'), field: "benefit_amount", align: "right" },
        { name: "loss_per_product", label: this.$t('loss_per_product'), field: "loss_per_product", align: "right" },
        { name: "loss_amount", label: this.$t('loss_amount'), field: "loss_amount", align: "right" },
      ]
    },
    totalAmount: function () {

      let amount = 0.00

      this.submitForm.details.forEach(function (row) {
        if (row.amount && row.amount > 0) {
          amount += parseFloat(row.amount)
        }
      })

      return parseFloat(amount).toFixed(2)
    },
    totalBenefitAmount: function () {

      let benefit_amount = 0.00

      this.submitForm.details.forEach(function (row) {
        if (row.benefit_amount && row.benefit_amount > 0) {
          benefit_amount += parseFloat(row.benefit_amount)
        }
      })

      return parseFloat(benefit_amount).toFixed(2)
    },
    totalLossAmount: function () {

      let loss_amount = 0.00

      this.submitForm.details.forEach(function (row) {
        if (row.loss_amount && row.loss_amount > 0) {
          loss_amount += parseFloat(row.loss_amount)
        }
      })

      return parseFloat(loss_amount).toFixed(2)
    },
  },
  created() {
    const productInvoiceId = this.hash_id(this.$route.params.id, false)[0]
    if (productInvoiceId) {
      this.getProductInvoiceDataById(productInvoiceId)
    } else {
      this.$router.push('/sale-list')
    }
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
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_invoice_data_by_id'), { id: productInvoiceId});
        this.submitForm = res.data.productInvoice

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    saveInvoicePayment: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        this.loading(true)
        const params = {
          payment_status_id: this.submitForm.payment_status_id,
          product_invoice_id: this.submitForm.id,
          paid_amount: this.pay_due_amount
        }
        const res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_product_invoice_payment_data'), params);
        this.notify(res.msg)
        this.$router.push('/sale-list')
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading(false)
      }
    },
  },
}
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}
</style>
