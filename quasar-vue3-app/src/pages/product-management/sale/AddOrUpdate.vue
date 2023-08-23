<template>
  <q-page class="q-pa-sm">

    <q-breadcrumbs class="text-grey q-mb-sm q-mt-sm" active-color="green">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="green" />
      </template>
      <q-breadcrumbs-el label="Dashboard" icon="home" to="/" />
      <q-breadcrumbs-el label="Product Management" icon="widgets" to="/" />
      <q-breadcrumbs-el label="Sales" icon="widgets" to="/sale-list" />
      <q-breadcrumbs-el label="Add New Sale" />
    </q-breadcrumbs>

    <q-card class="no-shadow" bordered>
      <q-card-section>
        <div class="row">
          <div class="text-h6 col-10 text-grey-8">Add New Sale</div>
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

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
              <q-select filled dense clearable v-model="submitForm.customer_id" label="Customer"
                :options="dropdownList.customers" emit-value map-options>
              </q-select>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="submitForm.invoice_code" label="Invoice Code"
                :rules="[val => val && val.length > 0 || 'Please enter invoice code']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input filled dense v-model="submitForm.invoice_date" label="Invoice Date" :rules="['date']">
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
          </q-item>

        </q-list>
        <q-table flat bordered class="no-shadow" :rows="submitForm.details" :columns="columns" row-key="name">
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
                <q-select filled dense v-model="props.row.product_type_id" label="Product Type" style="max-width: 150px"
                  :options="dropdownList.productTypes" emit-value map-options
                  :rules="[val => val > 0 || 'Please select product type']">
                </q-select>
              </q-td>
              <q-td key="category" :props="props" class="q-mt-md">
                <q-select @update:model-value="getProductPrice(props.row, props.pageIndex)" filled dense
                  v-model="props.row.category_id" label="Product Category" style="max-width: 150px"
                  :options="dropdownList.categories" emit-value map-options
                  :rules="[val => val > 0 || 'Please select category']">
                </q-select>
              </q-td>
              <q-td key="color" :props="props" class="q-mt-md">
                <q-select @update:model-value="getProductPrice(props.row, props.pageIndex)" filled dense
                  v-model="props.row.color_id" label="Product color" style="max-width: 150px"
                  :options="dropdownList.productColors" emit-value map-options
                  :rules="[val => val > 0 || 'Please select color']">
                </q-select>
              </q-td>
              <q-td key="unit" :props="props" class="q-mt-md">
                <q-select @update:model-value="getProductPrice(props.row, props.pageIndex)" filled dense
                  v-model="props.row.unit_id" label="Product unit" style="max-width: 150px"
                  :options="dropdownList.productUnits" emit-value map-options
                  :rules="[val => val > 0 || 'Please select unit']">
                </q-select>
              </q-td>
              <q-td key="price" :props="props" class="q-mt-md">
                <q-input type="number" filled dense v-model="props.row.price" label="Price" input-class="text-right" style="max-width: 130px"
                  :rules="[val => val && val.length > 0 || 'Please enter price']" />
              </q-td>
              <q-td key="quantity" :props="props" class="q-mt-md">
                <q-input @blur="calculateUnitWisePrice(props.pageIndex)" @focus="calculateUnitWisePrice(props.pageIndex)" @update:model-value="calculateUnitWisePrice(props.pageIndex)" type="number" filled dense v-model="props.row.quantity" label="Quantity" input-class="text-right" style="max-width: 130px"
                  :rules="[val => val && val.length > 0 || 'Please enter quantity']" />
              </q-td>
              <q-td key="amount" :props="props" class="q-mt-md">
                <q-input :disable="true" type="number" filled dense v-model="props.row.amount" label="Amount" input-class="text-right" style="max-width: 130px" />
              </q-td>
              <q-td key="action" :props="props">
                <q-btn v-if="props.pageIndex > 0" @click="removeRow(props.pageIndex)" icon="remove_circle" size="md"
                  class="text-red" flat dense></q-btn>
                <q-btn @click="addNewRow(props.row)" icon="add_circle" size="md" class="text-green" flat dense />
              </q-td>
            </q-tr>
          </template>
          <template v-slot:bottom-row>
            <q-tr>
              <q-td colspan="6" class="text-right">
                <b>Sub-Total</b>
              </q-td>
              <q-td class="text-right">
                {{ subTotalAmount }}
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
import { ref } from 'vue'
// import flatPickr from 'vue-flatpickr-component';
// import 'flatpickr/dist/flatpickr.css';
// import 'bootstrap/dist/css/bootstrap.css';

const columns = [
  { name: "product_type", field: "product_type", label: "Product Type", align: "left" },
  { name: "category", align: "center", label: "Category", field: "category", align: "left" },
  { name: "color", label: "Color", field: "color", align: "left" },
  { name: "unit", label: "Unit", field: "unit", align: "left" },
  { name: "price", label: "Unit price", field: "price", align: "center" },
  { name: "quantity", label: "Quantity", field: "quantity", align: "center" },
  { name: "amount", label: "Amount", field: "amount", align: "center" },
  { name: "action", label: "Action", field: "Action", align: "right" },
];

export default {
  props: ['editItem'],
  mixins: [helperMixin],
  components: {
    // flatPickr
  },
  setup(props) {
    // const stringOptions = props.dropdownList.categories
    // console.log('stringOptions', stringOptions)
    // const options = ref(stringOptions)

    return {
      // model: ref(null),
      // stringOptions,
      // options,

      // filterFn(val, update) {
      //   if (val === '') {
      //     update(() => {
      //       options.value = stringOptions
      //     })
      //     return
      //   }

      //   update(() => {
      //     const needle = val.toLowerCase()
      //     options.value = stringOptions.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
      //   })
      // },
      columns
    }
  },
  data() {
    return {
      // stringOptions: [],
      // options: [],
      dropdownList: [],
      loadingState: false,
      datePickerShow: true,
      config: {
        dateFormat: 'Y-m-d',
      },
      submitForm: {
        id: '',
        invoice_code: null,
        customer_id: null,
        invoice_date: null,
        due_date: null,
        note: null,
        po_no: null,
        payment_status_id: null,
        sub_total: 0,
        discount_percentage: 0,
        discount_amount: 0,
        vat_percentage: 0,
        vat_amount: 0,
        tax_percentage: 0,
        tax_amount: 0,
        paid_amount: 0,
        sending_email_to_customer_count: 0,
        discount_amount: 0,
        category_id: null,
        unit_id: null,
        color_id: null,
        supplier_id: null,
        product_code: null,
        active: true,
        details: [
          {
            id: '',
            product_type_id: null,
            category_id: null,
            color_id: null,
            unit_id: null,
            product_invoice_id: null,
            product_stock_id: null,
            quantity: 0,
            price: 0,
            amount: 0,
          }
        ]
      }
    }
  },
  computed: {
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

      this.submitForm.total_payable_amount = parseFloat(payable_amount + parseFloat(this.submitForm.vat_amount) + parseFloat(this.submitForm.tax_amount)) - (parseFloat(this.submitForm.discount_amount)).toFixed(2)

      return parseFloat(payable_amount).toFixed(2)
    },
  },
  created() {
    if (this.editItem) {
      this.submitForm = this.editItem
    }
    // this.stringOptions = this.dropdownList.categories
    // this.options = this.stringOptions
  },
  mounted() {
    this.getInitialData()
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
    getProductPrice: async function (item, rowIndex) {

      console.log('this.submitForm', this.submitForm)

      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_price_by_filter'), item);
        console.log('res.data.data', res.data.data)
        // const importedListCopy = this.submitForm.details.map(item => item.index === this.editItem.index ? {...this.importedList, ...this.editItem} : item );
        // this.submitForm.details = importedListCopy
        const objIndex = this.submitForm.details.findIndex((item, index) => index == rowIndex)

        this.submitForm.details[objIndex].price = res.data.data ? res.data.data.selling_price : ''

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
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();
      this.submitForm.cost = this.totalCost

      try {
        this.loading(true)
        let res = ''
        if (this.submitForm.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_product_invoice_data'), this.submitForm);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_product_invoice_data'), this.submitForm);
        }
        this.notify(res.msg)
        this.$emit('closeModal', true)
        this.$emit('reloadListData', true)
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading(false)
      }
    },
    // filterFn (val, update) {
    //   console.log('val', val)
    //   if (val === '') {
    //     update(() => {
    //       this.options.value = this.stringOptions
    //     })
    //     return
    //   }

    //   update(() => {
    //     const needle = val.toLowerCase()
    //     this.options.value = this.stringOptions.filter(v => v.toLowerCase().indexOf(needle) > -1)
    //   })
    // }
  },
}
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}
</style>
