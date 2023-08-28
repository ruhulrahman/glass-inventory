<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el label="Dashboard" icon="home" to="/" />
      <q-breadcrumbs-el label="Product Management" icon="widgets" to="/" />
      <q-breadcrumbs-el label="Sales" icon="widgets" to="/sale-list" />
      <q-breadcrumbs-el>Invoice Details</q-breadcrumbs-el>
    </q-breadcrumbs>

    <q-card class="no-shadow q-mb-xl" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">Invoice Details</div>
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
              <q-item-label>Customer</q-item-label>
              <q-item-label caption>{{ invoiceDetails.customer ? invoiceDetails.customer.name : '' }}</q-item-label>
              <q-item-label caption>{{ invoiceDetails.customer ? invoiceDetails.customer.phone : '' }}</q-item-label>
            </q-item-section>
          </q-item>

          <q-item v-if="showCustomerAddField" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="invoiceDetails.customer_name" label="Customer name" />
            </q-item-section>
          </q-item>

          <q-item v-if="showCustomerAddField" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="invoiceDetails.customer_phone" label="Customer phone"
                :rules="[val => val && val.length > 0 && showCustomerAddField==true || 'Please enter customer phone']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>Invoice Code</q-item-label>
              <q-item-label caption>#{{ invoiceDetails.invoice_code }}</q-item-label>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>Invoice Date</q-item-label>
              <q-item-label caption>{{ dDate(invoiceDetails.invoice_date) }}</q-item-label>
            </q-item-section>
          </q-item>

        </q-list>
        <q-table dense hide-pagination flat bordered class="no-shadow" :rows="invoiceDetails.details" :columns="columns" row-key="name">
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
              <q-td key="action" :props="props">
                <q-btn v-if="props.pageIndex > 0" @click="removeRow(props.pageIndex)" icon="remove_circle" size="md"
                  class="text-red" flat dense></q-btn>
                <q-btn @click="addNewRow(props.row)" icon="add_circle" size="md" class="text-green" flat dense />
              </q-td>
            </q-tr>
          </template>
          <template v-slot:bottom-row>
            <q-tr class="bg-blue-grey-1">
              <q-td colspan="7" class="text-right">
                <b>Sub-Total</b>
              </q-td>
              <q-td class="text-right">
                {{ subTotalAmount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>Discount</b>
              </q-td>
              <q-td class="text-right">
                {{ invoiceDetails.discount_amount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>Vat ({{ invoiceDetails.vat_percentage }}%)</b>
              </q-td>
              <q-td class="text-right">
                {{ invoiceDetails.vat_amount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>Tax ({{ invoiceDetails.tax_percentage }}%)</b>
              </q-td>
              <q-td class="text-right">
                {{ invoiceDetails.tax_amount }}
              </q-td>
            </q-tr>
            <q-tr class="bg-blue-grey-1">
              <q-td colspan="7" class="text-right">
                <b>Total Payable Amount</b>
              </q-td>
              <q-td class="text-right">
                {{ invoiceDetails.total_payable_amount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>Paid Amount</b>
              </q-td>
              <q-td class="text-right">
                {{ invoiceDetails.paid_amount }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>Due Amount</b>
              </q-td>
              <q-td class="text-right">
                <q-badge :color="invoiceDetails.due_amount > 0 ? 'red' : 'black'">
                  {{ invoiceDetails.due_amount }}
                </q-badge>
              </q-td>
            </q-tr>
            <q-tr v-if="invoiceDetails.due_amount > 0">
              <q-td colspan="7" class="text-right">
                <q-btn glossy @click="showDueAmount = !showDueAmount" flat color="white" class="bg-red d-block"
                  style="text-transform: capitalize; padding: 0px 10px 0 19px">
                  Pay Now
                </q-btn>
              </q-td>
              <q-td v-if="showDueAmount" class="text-right">
                <q-input bg-color="green-1" type="number" filled dense v-model="pay_due_amount"
                  label="Pay Due Amount" input-class="text-right" />
              </q-td>
            </q-tr>
            <q-tr v-if="showDueAmount">
              <q-td colspan="7" class="text-right">
                <b>Payable Later</b>
              </q-td>
              <q-td class="text-right">
                {{ invoiceDetails.due_amount - pay_due_amount }}{{ invoiceDetails.due_amount - pay_due_amount ? '' : '.00' }}
              </q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">
                <b>Payment Status</b>
              </q-td>
              <q-td class="text-right">
                <q-select :bg-color="invoiceDetails.due_amount > 0 ? 'red-3' : 'green-3'" :disable="invoiceDetails.due_amount > 0 ? false : true" filled dense v-model="invoiceDetails.payment_status_id" label="Status"
                  :options="dropdownList.paymentStatuses" emit-value map-options>
                </q-select>
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
  props: ['invoiceDetails'],
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
      // invoiceDetails: {
      //   id: '',
      //   invoice_code: '',
      //   customer_id: '',
      //   customer_name: '',
      //   customer_phone: '',
      //   invoice_date: '',
      //   due_date: '',
      //   note: '',
      //   po_no: '',
      //   payment_status_id: '',
      //   sub_total: 0,
      //   discount_percentage: 0,
      //   discount_amount: 0.00,
      //   vat_percentage: 0,
      //   vat_amount: 0.00,
      //   tax_percentage: 0,
      //   tax_amount: 0.00,
      //   total_payable_amount: 0.00,
      //   paid_amount: 0.00,
      //   due_amount: 0.00,
      //   sending_email_to_customer_count: 0,
      //   category_id: '',
      //   unit_id: '',
      //   color_id: '',
      //   supplier_id: '',
      //   product_code: '',
      //   active: true,
      //   details: [
      //     {
      //       id: '',
      //       product_type_id: '',
      //       category_id: '',
      //       color_id: '',
      //       unit_id: '',
      //       product_invoice_id: '',
      //       product_stock_id: '',
      //       quantity: 0,
      //       price: 0.00,
      //       amount: 0.00,
      //     }
      //   ]
      // }
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

      this.invoiceDetails.details.forEach(function (row) {
        if (row.amount && row.amount > 0) {
          payable_amount += parseFloat(row.amount)
        }
      })

      if (this.invoiceDetails.discount_percentage > 0) {
        const discountAmount = parseFloat((this.invoiceDetails.discount_percentage * payable_amount) / 100).toFixed(2)
        this.invoiceDetails.discount_amount = discountAmount
      }

      if (this.invoiceDetails.vat_percentage > 0.1 && payable_amount > 0) {
        this.invoiceDetails.vat_amount = parseFloat((this.invoiceDetails.vat_percentage / 100) * payable_amount).toFixed(2)
      } else {
        this.invoiceDetails.vat_amount = 0
      }

      if (this.invoiceDetails.tax_percentage > 0.1 && payable_amount > 0) {
        this.invoiceDetails.tax_amount = parseFloat((this.invoiceDetails.tax_percentage / 100) * payable_amount).toFixed(2)
      } else {
        this.invoiceDetails.tax_amount = 0
      }

      // this.invoiceDetails.total_payable_amount = ((payable_amount + this.invoiceDetails.vat_amount + this.invoiceDetails.tax_amount) - this.invoiceDetails.discount_amount)
      this.invoiceDetails.total_payable_amount = parseFloat(parseFloat(payable_amount + parseFloat(this.invoiceDetails.vat_amount) + parseFloat(this.invoiceDetails.tax_amount)) - parseFloat(this.invoiceDetails.discount_amount)).toFixed(2)
      this.invoiceDetails.due_amount = parseFloat(this.invoiceDetails.total_payable_amount - this.invoiceDetails.paid_amount).toFixed(2)

      return parseFloat(payable_amount).toFixed(2)
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

      if (this.invoiceDetails.details[index].quantity) {
        quantity = this.invoiceDetails.details[index].quantity;
      }

      if (this.invoiceDetails.details[index].price) {
        unit_price = this.invoiceDetails.details[index].price;
      }

      if (quantity >= 0 && unit_price >= 0) {
        this.invoiceDetails.details[index].amount = parseFloat(quantity) * parseFloat(unit_price);
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
