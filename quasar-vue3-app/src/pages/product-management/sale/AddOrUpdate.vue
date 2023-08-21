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
                :options="dropdowns.customers" emit-value map-options>
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
              <q-input filled dense v-model="submitForm.invoice_date" label="Invoice Date"
                :rules="[val => val && val.length > 0 || 'Please enter invoice date']" />
            </q-item-section>
          </q-item>

        </q-list>
        <q-table flat bordered class="no-shadow">
          <q-tr class="bg-blue-grey-2 text-primary">
            <q-th>SL.</q-th>
            <q-th>Product Type</q-th>
          </q-tr>
          <q-tr>
            <q-td>01</q-td>
            <q-td>
              <q-btn icon="edit" size="sm" class="text-teal" flat dense></q-btn>
              <q-btn icon="delete" size="sm" class="text-red" flat dense />
            </q-td>
          </q-tr>
        </q-table>
      </q-card-section>

    </q-card>

  </q-page>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'
import { ref } from 'vue'

export default {
  props: ['editItem'],
  mixins: [helperMixin],
  // setup(props) {
  //   const stringOptions = props.dropdownList.categories
  //   console.log('stringOptions', stringOptions)
  //   const options = ref(stringOptions)

  //   return {
  //     model: ref(null),
  //     stringOptions,
  //     options,

  //     filterFn(val, update) {
  //       if (val === '') {
  //         update(() => {
  //           options.value = stringOptions
  //         })
  //         return
  //       }

  //       update(() => {
  //         const needle = val.toLowerCase()
  //         options.value = stringOptions.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
  //       })
  //     }
  //   }
  // },
  data() {
    return {
      // stringOptions: [],
      // options: [],
      dropdowns: [],
      loadingState: false,
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
    // totalCost: function () {
    //   let totalCostValue = 0
    //   if (this.submitForm.price) {
    //     totalCostValue = this.submitForm.price * this.submitForm.quantity
    //   }

    //   return totalCostValue
    // }
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
