<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el :label="$t('dashboard')" icon="home" to="/" />
      <q-breadcrumbs-el :label="$t('sales_management')" icon="widgets" to="/" />
      <q-breadcrumbs-el :label="$t('sales')" icon="widgets" to="/sale-list" />
      <q-breadcrumbs-el>{{ submitForm.id ? $t('update_sale') : $t('add_new_sale') }}</q-breadcrumbs-el>
    </q-breadcrumbs>

    <q-card class="no-shadow q-mb-xl" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">{{ submitForm.id ? $t('update_sale') : $t('add_new_sale') }}</div>
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
        <!-- <div class="row q-pa-md">
          <div class="col-3">two thirds</div>
          <div class="col-3">two thirds</div>
          <div class="col-3">two thirds</div>
        </div> -->
        <q-list class="row q-mt-md">

          <q-item v-if="!showCustomerAddField" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
              <q-select :disable="submitForm.id ? true : false" filled dense clearable v-model="submitForm.customer_id" :label="$t('customer')"
                :options="dropdownList.customerList" emit-value map-options use-input @filter="filterFn">
                <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      No results
                      <q-btn glossy @click="toggleCustomerAddField()" flat color="white" size="sm" class="bg-red-12 d-block">
                        {{ $t('add_new_customer') }}
                      </q-btn>
                    </q-item-section>
                  </q-item>
                </template>
              </q-select>
            </q-item-section>
          </q-item>

          <q-item v-if="showCustomerAddField" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="submitForm.customer_name" :label="$t('customer_name')" />
            </q-item-section>
          </q-item>

          <q-item v-if="showCustomerAddField" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="submitForm.customer_phone" :label="$t('customer_phone')"
                :rules="[val => val && val.length > 0 && showCustomerAddField==true || 'Please enter customer phone']" />
            </q-item-section>
          </q-item>

          <!-- <q-item v-if="submitForm.id" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input :disable="submitForm.id && submitForm.invoice_code ? true : false" filled dense v-model="submitForm.invoice_code" label="Invoice Code"
                :rules="[val => val && val.length > 0 || 'Please enter invoice code']" />
            </q-item-section>
          </q-item> -->

          <!-- <q-item v-if="submitForm.id" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input :disable="true" filled dense v-model="submitForm.invoice_date" label="Invoice Date" :rules="['date']">
                <template v-slot:append>
                  <q-icon name="event" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-date v-model="submitForm.invoice_date">
                        <div class="row items-center justify-end" v-close-popup>
                          <q-btn v-close-popup label="Close" color="primary" flat />
                        </div>
                      </q-date>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </q-item-section>
          </q-item> -->

          <q-item v-if="submitForm.id" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('invoice_code') }}</q-item-label>
              <q-item-label caption><router-link class="text-blue text-weight-bold" :to="`/invoice-details/${hash_id(submitForm.id)}`">#{{ submitForm.invoice_code }}</router-link></q-item-label>
            </q-item-section>
          </q-item>

          <q-item v-if="submitForm.id" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label>{{ $t('invoice_date') }}</q-item-label>
              <q-item-label caption>{{ dDate(submitForm.invoice_date) }}</q-item-label>
            </q-item-section>
          </q-item>

        </q-list>
        <q-table hide-pagination flat bordered class="no-shadow" :rows="submitForm.details" :columns="columns" row-key="name">
          <template v-slot:header="props">
            <q-tr :props="props" class="bg-blue-grey-2 text-primary">
              <q-th v-for="col in props.cols" :key="col.name" :props="props">
                {{ col.label }}
              </q-th>
            </q-tr>
          </template>
          <template v-slot:body="props">
            <q-tr :props="props" class="q-mt-md">
              <!-- <q-td key="sl" :props="props">
                {{ props.pageIndex + 1 }}
              </q-td> -->
              <q-td key="product_type" :props="props" class="q-mt-md">
                <q-select filled dense v-model="props.row.product_type_id" :label="$t('product_type')" style="min-width: 120px; max-width: 150px"
                  :options="dropdownList.productTypes" emit-value map-options
                  :rules="[val => val > 0 || 'Please select product type']">
                </q-select>
              </q-td>
              <q-td key="category" :props="props" class="q-mt-md">
                <q-select @update:model-value="getProductPrice(props.row, props.pageIndex)" filled dense
                  v-model="props.row.category_id" :label="$t('product_category')" style="min-width: 120px; max-width: 150px"
                  :options="dropdownList.categories" emit-value map-options
                  :rules="[val => val > 0 || 'Please select category']">
                </q-select>
              </q-td>
              <q-td key="color" :props="props" class="q-mt-md">
                <q-select @update:model-value="getProductPrice(props.row, props.pageIndex)" filled dense
                  v-model="props.row.color_id" :label="$t('color')" style="min-width: 120px; max-width: 150px"
                  :options="dropdownList.productColors" emit-value map-options
                  :rules="[val => val > 0 || 'Please select color']">
                </q-select>
              </q-td>
              <q-td key="unit" :props="props" class="q-mt-md">
                <q-select @update:model-value="getProductPrice(props.row, props.pageIndex)" filled dense
                  v-model="props.row.unit_id" :label="$t('product_unit')" style="min-width: 120px; max-width: 150px"
                  :options="dropdownList.productUnits" emit-value map-options
                  :rules="[val => val > 0 || 'Please select unit']">
                </q-select>
              </q-td>
              <q-td key="price" :props="props" class="q-mt-md">
                <q-input type="number" filled dense v-model="props.row.price" :label="$t('price')" input-class="text-right"
                  style="max-width: 130px" :rules="[val => val && val.length > 0 || 'Please enter price']" />
              </q-td>
              <q-td key="stock" :props="props" class="q-mt-md">
                {{ props.row.product_in_stock }}
              </q-td>
              <q-td key="quantity" :props="props" class="q-mt-md">
                <q-input @blur="calculateUnitWisePrice(props.pageIndex)" @focus="calculateUnitWisePrice(props.pageIndex)"
                  @update:model-value="calculateUnitWisePrice(props.pageIndex)" type="number" filled dense
                  v-model="props.row.quantity" :label="$t('quantity')" input-class="text-right" style="max-width: 130px"
                  :error-message="quantityRule(props)"
                  :error="!quantityIsValid(props)"/>
                <!-- <q-input @blur="calculateUnitWisePrice(props.pageIndex)" @focus="calculateUnitWisePrice(props.pageIndex)"
                  @update:model-value="calculateUnitWisePrice(props.pageIndex)" type="number" filled dense
                  v-model="props.row.quantity" :label="$t('quantity')" input-class="text-right" style="max-width: 130px"
                  :rules="[val => val && val.length > 0 || 'Please enter quantity']"/> -->
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
              <q-td colspan="6" class="text-right">
                <b>{{ $t('sub_total') }}</b>
              </q-td>
              <q-td class="text-right">
                {{ subTotalAmount }}
                <!-- <q-input :disable="true" bg-color="green-2" type="number" filled dense v-model="subTotalAmount" label="Sub-Total" input-class="text-right" /> -->
              </q-td>
              <q-td></q-td>
            </q-tr>
            <q-tr>
              <q-td :colspan="submitForm.discount_type.label == 'Percentage' ? 4 : 5" class="text-right">
                <b>{{ $t('discount') }}</b>
              </q-td>
              <q-td class="text-right">
                <q-select filled dense
                  v-model="submitForm.discount_type" :label="$t('discount_type')" style="min-width: 120px; max-width: 150px"
                  :options="discountTypes">
                </q-select>
              </q-td>
              <q-td v-if="submitForm.discount_type.label == 'Percentage'" class="text-right">
                <q-input type="number" suffix="%" filled dense v-model="submitForm.discount_percentage" label="Percentage"
                    input-class="text-right" />
              </q-td>
              <q-td class="text-right">
                <q-input type="number" filled dense v-model="submitForm.discount_amount" label="Amount"
                  input-class="text-right" />
              </q-td>
              <q-td></q-td>
            </q-tr>
            <!-- <q-tr>
              <q-td colspan="6" class="text-right">
                <b>{{ $t('vat') }}</b>
              </q-td>
              <q-td class="text-right">
                <div class="row">
                  <div class="col-sm-6">
                    <q-input type="number" suffix="%" filled dense v-model="submitForm.vat_percentage" label="Percentage"
                    input-class="text-right" />
                  </div>
                  <div class="col-sm-6 text-right">
                    <span class="text-right q-mt-sm">{{ submitForm.vat_amount }}</span>
                  </div>
                </div>
              </q-td>
              <q-td></q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="6" class="text-right">
                <b>{{ $t('tax') }}</b>
              </q-td>
              <q-td class="text-right">
                <div class="row">
                  <div class="col-sm-6">
                    <q-input type="number" suffix="%" filled dense v-model="submitForm.tax_percentage" label="Percentage"
                    input-class="text-right"/>
                  </div>
                  <div class="col-sm-6 text-right">
                    <span class="text-right q-mt-sm">{{ submitForm.tax_amount }}</span>
                  </div>
                </div>
              </q-td>
              <q-td></q-td>
            </q-tr> -->
            <q-tr class="bg-blue-grey-1">
              <q-td colspan="6" class="text-right">
                <b>{{ $t('total_payable_amount') }}</b>
              </q-td>
              <q-td class="text-right">
                {{ submitForm.total_payable_amount }}
              </q-td>
              <q-td></q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="6" class="text-right">
                <b>{{ $t('paid_amount') }}</b>
              </q-td>
              <q-td class="text-right">
                <q-input bg-color="green-1" type="number" filled dense v-model="submitForm.paid_amount"
                  label="Paid Amount" input-class="text-right" />
              </q-td>
              <q-td></q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="6" class="text-right">
                <b>{{ $t('due_amount') }}</b>
              </q-td>
              <q-td class="text-right">
                <q-input :bg-color="submitForm.due_amount > 0 ? 'red-1' : ''" :disable="true" type="number" filled dense
                  v-model="submitForm.due_amount" label="Due Amount" input-class="text-right" />
              </q-td>
              <q-td></q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="6" class="text-right">
                <b>{{ $t('payment_status') }}</b>
              </q-td>
              <q-td class="text-right">
                <q-select filled dense v-model="submitForm.payment_status_id" label="Status"
                  :options="dropdownList.paymentStatuses" emit-value map-options>
                </q-select>
              </q-td>
              <q-td></q-td>
            </q-tr>
            <q-tr>
              <q-td colspan="7" class="text-right">

                <q-btn glossy @click="saveInvoiceData()" flat color="white" class="bg-green-7 d-block"
                  style="text-transform: capitalize; padding: 0px 10px 0 19px">
                  {{ submitForm.id ? $t('update_invoice') : $t('save_invoice') }}
                </q-btn>
              </q-td>
              <q-td></q-td>
            </q-tr>
          </template>
        </q-table>
      </q-card-section>

    </q-card>

  </q-page>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'
// import { ref } from 'vue'
// import flatPickr from 'vue-flatpickr-component';
// import 'flatpickr/dist/flatpickr.css';
// import 'bootstrap/dist/css/bootstrap.css';

// const columns = ;

export default {
  props: ['editItem'],
  mixins: [helperMixin],
  components: {
    // flatPickr
  },
  data() {
    return {
      // stringOptions: [],
      // options: [],
      dropdownList: [],
      showCustomerAddField: false,
      loadingState: false,
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
        discount_type: 'Amount',
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
            product_in_stock: '',
            amount: 0.00,
          }
        ]
      },
      discountTypes: [
        { id: "Amount", label: "Amount" },
        { id: "Percentage", label: "Percentage" },
      ]
    }
  },
  computed: {
    columns: function () {
      return [
        { name: "product_type", field: "product_type", label: this.$t('product_type'), align: "left" },
        { name: "category", align: "center", label: this.$t('category'), field: "category", align: "left" },
        { name: "color", label: "Color", field: this.$t('color'), align: "left" },
        { name: "unit", label: "Unit", field: this.$t('unit'), align: "left" },
        { name: "price", label: this.$t('unit_price'), field: "price", align: "center" },
        { name: "stock", label: this.$t('stock'), field: "stock", align: "center" },
        { name: "quantity", label: this.$t('quantity'), field: "quantity", align: "center" },
        { name: "amount", label: this.$t('amount'), field: "amount", align: "right" },
        { name: "action", label: this.$t('action'), field: "Action", align: "right" },
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

      if (this.submitForm.due_amount == this.submitForm.total_payable_amount) {
        this.submitForm.payment_status_id = 15
      } else if (this.submitForm.due_amount > 0) {
        this.submitForm.payment_status_id = 17
      } else {
        this.submitForm.payment_status_id = 16
      }

      return parseFloat(payable_amount).toFixed(2)
    },
  },
  created() {
    this.getInitialData()
    const productInvoiceId = this.hash_id(this.$route.params.id, false)[0]
    if (productInvoiceId) {
      this.getProductInvoiceDataById(productInvoiceId)
    }
    // this.stringOptions = this.dropdownList.categories
    // this.options = this.stringOptions
  },
  mounted() {
  },
  methods: {
    quantityIsValid: function (props) {
      if (props.row.quantity){
        const quantity = parseFloat(props.row.quantity)
        const stock = parseFloat(props.row.product_in_stock)
        if (quantity > stock) {
          // console.log('quantity', quantity)
          // console.log('stock', stock)
          return 'Quantity crossed the stock limit'
        } else {
          return ''
        }
      } else {
        return 'Please enter quantity'
      }
    },
    quantityRule: function (props) {

      if (props.row.quantity){
        const quantity = parseFloat(props.row.quantity)
        const stock = parseFloat(props.row.product_in_stock)
        if (quantity > stock) {
          // console.log('quantity', quantity)
          // console.log('stock', stock)
          return 'Quantity crossed the stock limit'
        }
      } else {
        return 'Please enter quantity'
      }
    },
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
    toggleCustomerAddField: async function () {
      this.submitForm.customer_id = ''
      this.showCustomerAddField = !this.showCustomerAddField
    },
    removeRow: async function (index) {
      this.submitForm.details.splice(index, 1)
    },
    addNewRow: async function () {
      this.submitForm.details.push({
        id: '',
        product_type_id: '',
        color_id: '',
        category_id: '',
        product_invoice_id: '',
        product_stock_id: '',
        quantity: 0,
        price: 0,
        amount: 0,
      })
    },
    getProductPrice: async function (item, rowIndex) {

      // console.log('this.submitForm', this.submitForm)

      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_price_by_filter'), item);
        // console.log('res.data.data', res.data.data)
        // const importedListCopy = this.submitForm.details.map(item => item.index === this.editItem.index ? {...this.importedList, ...this.editItem} : item );
        // this.submitForm.details = importedListCopy
        const objIndex = this.submitForm.details.findIndex((item, index) => index == rowIndex)

        this.submitForm.details[objIndex].price = res.data.data ? res.data.data.selling_price : ''
        this.submitForm.details[objIndex].product_stock_id = res.data.data ? res.data.data.id : ''
        this.submitForm.details[objIndex].product_in_stock = res.data.data ? res.data.data.product_in_stock : 0

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    getProductInvoiceDataById: async function (productInvoiceId) {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_invoice_data_by_id'), { id: productInvoiceId});
        this.submitForm = res.data.productInvoice
        ref.form_data.discount_type = this.submitForm.discount_percentage > 0 ? 'Percentage' : 'Amount';

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
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_initial_dropdown_list'));
        this.dropdownList = res.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    saveInvoiceData: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        // this.loading(true)
        let res = ''
        this.submitForm.sub_total = this.subTotalAmount
        // console.log('this.submitForm', this.submitForm)
        // return 0;
        if (this.submitForm.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_product_invoice_data'), this.submitForm);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_product_invoice_data'), this.submitForm);
        }
        this.notify(res.msg)
        // this.$router.push('/sale-list')
        this.$router.push(`/invoice-details/${this.hash_id(res.data.productInvoice.id)}`)
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        // this.loading(false)
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
