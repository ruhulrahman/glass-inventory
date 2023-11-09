<template>
  <q-card class="bg-primary text-white no-shadow wait_me" bordered>
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label class="text-h6 text-weight-bolder" lines="1">{{ submitForm.id ? $t('update') : $t('add_new_product_stock') }}</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-icon name="cancel" color="white" clickable style="cursor: pointer;"
              @click="(() => { $emit('closeModal', true) })"></q-icon>
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-card-section class="q-pa-sm ">
        <q-list class="row">

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
              <q-select dark clearable color="white" v-model="submitForm.product_type_id" :label="$t('product_type')"
                :options="dropdownList.productTypes" emit-value map-options
                :rules="[val => val > 0 || 'Please select type']">
              </q-select>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
              <q-select dark clearable color="white" v-model="submitForm.category_id" :label="$t('category')" :options="options"
                use-input @filter="filterFn" emit-value map-options :rules="[val => val > 0 || 'Please select category']">
              </q-select>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
              <q-select dark clearable color="white" v-model="submitForm.color_id" :label="$t('color')"
                :options="dropdownList.productColors" emit-value map-options
                :rules="[val => val > 0 || 'Please select color']">
              </q-select>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
              <q-select dark clearable color="white" v-model="submitForm.unit_id" :label="$t('unit')"
                :options="dropdownList.productUnits" emit-value map-options
                :rules="[val => val > 0 || 'Please select unit']">
              </q-select>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input type="number" step="0.01" dark color="white" dense v-model="submitForm.price" :label="$t('unit_price')"
                :rules="[val => val > 0 || 'Please enter price']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input type="number" :disable="submitForm.id ? true : false" step="0.01" dark color="white" dense v-model="submitForm.quantity"
              :label="$t('product_quantity')" :rules="[val => val > 0 || 'Please enter quantity']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-item-label caption class="text-green">{{ $t('total_cost') }}</q-item-label>
              <q-item-label>{{ totalCost }}</q-item-label>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-input type="number" min="0" dark color="blue" dense v-model="submitForm.selling_price"
                :label="$t('product_selling_price')" :rules="[val => val > 0 || 'Please enter selling price']" />
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
              <q-select dark clearable color="white" v-model="submitForm.supplier_id" :label="$t('supplier')"
                :options="dropdownList.suppliers" emit-value map-options>
              </q-select>
            </q-item-section>
          </q-item>

          <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-toggle color="green" size="md" v-model="submitForm.active" val="md" :label="$t('is_active')" />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn type="submit" glossy class="text-capitalize bg-white text-primary q-mr-md q-mb-md q-pa-md ">Save</q-btn>
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'
import { ref } from 'vue'

export default {
  props: ['title', 'editItem', 'dropdownList'],
  mixins: [helperMixin],
  setup(props) {
    const stringOptions = props.dropdownList.categories
    const options = ref(stringOptions)

    return {
      model: ref(null),
      stringOptions,
      options,

      filterFn(val, update) {
        if (val === '') {
          update(() => {
            options.value = stringOptions
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          options.value = stringOptions.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
        })
      }
    }
  },
  data() {
    return {
      // stringOptions: [],
      // options: [],
      loadingState: false,
      submitForm: {
        id: '',
        product_type_id: null,
        price: 0,
        quantity: 0,
        cost: 0,
        selling_price: 0,
        in_stock: 0,
        min_stock: 0,
        category_id: null,
        unit_id: null,
        color_id: null,
        supplier_id: null,
        product_code: null,
        active: true,
      }
    }
  },
  computed: {
    totalCost: function () {
      let totalCostValue = 0
      if (this.submitForm.price) {
        totalCostValue = this.submitForm.price * this.submitForm.quantity
      }

      return totalCostValue
    }
  },
  created() {
    if (this.editItem) {
      this.submitForm = this.editItem
    }
    this.stringOptions = this.dropdownList.categories
    this.options = this.stringOptions
  },
  mounted() {
  },
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();
      this.submitForm.cost = this.totalCost

      try {
        // ref.wait_me(".wait_me");
        this.loading(true)
        let res = ''
        if (this.submitForm.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_product_stock_data'), this.submitForm);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_product_stock_data'), this.submitForm);
        }
        this.notify(res.msg)
        this.$emit('closeModal', true)
        this.$emit('reloadListData', true)
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        // ref.wait_me(".wait_me", "hide");
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
}</style>
