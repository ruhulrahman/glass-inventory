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
              <!-- <q-tab class="text-orange" name="item_wise" label="Item Wise" /> -->
            </q-tabs>
          </div>

          <q-separator></q-separator>

          <q-tab-panels v-model="tab" animated transition-prev="scale" transition-next="scale">
            <q-tab-panel name="invoice_wise" class="q-pa-none">
              <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow  q-pa-none q-ma-none"
                :rows="invoiceWiseTableRow" :columns="columns" row-key="name"
                no-data-label=" I didn't find anything for you" :loading="loading" :pagination="initialPagination"
                :filter="filter">
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

              <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow  q-pa-none q-ma-none"
                :rows="productWiseTableRow" :columns="productWisecolumns" row-key="name"
                no-data-label=" I didn't find anything for you" :loading="loading" :pagination="initialPagination"
                :filter="filter">
                <template v-slot:loading>
                  <q-inner-loading showing color="primary" />
                </template>
                <template v-slot:top-left>
                  <q-list class="row q-mt-md">
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.product_type_id" label="Product Type"
                          :options="dropdownList.productTypes" emit-value map-options use-input
                          @filter="productTypefilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.category_id" label="Product Category"
                          :options="dropdownList.categories" emit-value map-options use-input @filter="categoryfilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.color_id" label="Product Color"
                          :options="dropdownList.productColors" emit-value map-options use-input @filter="colorfilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.unit_id" label="Product Unit"
                          :options="dropdownList.productUnits" emit-value map-options use-input @filter="unitfilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <div class="d-flex q-mb-sm">
                          <span class="q-mr-sm">Invoice Date</span>
                          <q-btn icon="event" round color="primary">
                            <q-tooltip class="bg-primary" transition-show="scale" transition-hide="scale"
                          anchor="bottom middle" self="center middle">
                          Select Invoice Date
                        </q-tooltip>
                            <q-popup-proxy @before-show="updateProxy" cover transition-show="scale" transition-hide="scale">
                              <q-date v-model="search.invoice_date" range>
                                <div class="row items-center justify-end q-gutter-sm">
                                  <q-btn label="Cancel" color="primary" flat v-close-popup />
                                  <q-btn label="OK" color="primary" flat @click="save" v-close-popup />
                                </div>
                              </q-date>
                            </q-popup-proxy>
                          </q-btn>
                        </div>
                        <q-badge color="teal" v-if="search.invoice_date">{{ search.invoice_date }}</q-badge>
                        <!-- <q-input type="text" filled dense v-model="search.invoice_date" label="Invoice Date">
                          <template v-slot:append>
                            <q-icon name="event" class="cursor-pointer">
                              <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                <q-date v-model="search.invoice_date" range>
                                  <div class="row items-center justify-end" v-close-popup>
                                    <q-btn v-close-popup label="Close" color="primary" flat />
                                  </div>
                                </q-date>
                              </q-popup-proxy>
                            </q-icon>
                          </template>
                        </q-input> -->
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <q-btn glossy @click="searchData()" flat color="white" class="bg-green-7"
                          style="text-transform: capitalize; padding: 0px 10px 0 19px">
                          Search
                        </q-btn>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <q-btn glossy @click="clearData()" flat color="white" class="bg-red-7"
                          style="text-transform: capitalize; padding: 0px 10px 0 19px">
                          Clear
                        </q-btn>
                      </q-item-section>
                    </q-item>
                  </q-list>
                  <q-list class="row q-ma-none q-pa-none">
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12 q-ma-none q-pa-none">
                      <q-item-section class=" q-ma-none q-pa-none">
                        <q-item-label class="text-weight-bold">Benefit Amount: {{ getProductWiseBenefitAmount
                        }}</q-item-label>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12 q-ma-none q-pa-none">
                      <q-item-section class=" q-ma-none q-pa-none">
                        <q-item-label class="text-weight-bold">Benefit Amount: {{ getProductWiseBenefitAmount
                        }}</q-item-label>
                      </q-item-section>
                    </q-item>
                    <!-- <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12 q-ma-none q-pa-none">
                      <q-item-section class=" q-ma-none q-pa-none">
                        <vue-flat-pickr v-model="date" :config="config" />
                      </q-item-section>
                    </q-item> -->
                  </q-list>
                </template>
                <!-- <template v-slot:top-left>
                  <q-list class="row">
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <q-item-label>Benefit Amount: {{ getProductWiseBenefitAmount }}</q-item-label>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <q-item-label>Loss Amount: {{ getProductWiseBenefitAmount }}</q-item-label>
                      </q-item-section>
                    </q-item>
                  </q-list>
                </template> -->
                <!-- <template v-slot:top-right>
                  <q-input v-if="show_filter" clearable filled borderless dense debounce="300" v-model="filter"
                    placeholder="Search">
                    <template v-slot:append>
                      <q-icon name="search" />
                    </template>
                  </q-input>

                  <q-btn class="q-ml-sm" icon="filter_list" @click="show_filter = !show_filter" flat />
                </template> -->
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
                    <q-td key="product_type_name" :props="props">
                      {{ props.row.product_type_name }}
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
                    <q-td key="benefit_per_product" :props="props">
                      {{ props.row.benefit_per_product }}
                    </q-td>
                    <q-td key="benefit_amount" :props="props">
                      {{ props.row.benefit_amount }}
                    </q-td>
                    <q-td key="loss_per_product" :props="props">
                      {{ props.row.loss_per_product }}
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
            <q-tab-panel name="item_wise" class="q-pa-none">

              <q-table :dense="$q.screen.lt.md" flat bordered class="no-shadow  q-pa-none q-ma-none"
                :rows="itemWiseTableRow" :columns="itemWiseColumns" row-key="name"
                no-data-label=" I didn't find anything for you" :loading="loading" :pagination="initialPagination"
                :filter="filter">
                <template v-slot:loading>
                  <q-inner-loading showing color="primary" />
                </template>
                <template v-slot:top-left>
                  <q-list class="row q-mt-md">
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.product_type_id" label="Product Type"
                          :options="dropdownList.productTypes" emit-value map-options use-input
                          @filter="productTypefilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.category_id" label="Product Category"
                          :options="dropdownList.categories" emit-value map-options use-input @filter="categoryfilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.color_id" label="Product Color"
                          :options="dropdownList.productColors" emit-value map-options use-input @filter="colorfilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section style="margin-top: -20px !important; font-size: 12px !important">
                        <q-select filled dense clearable v-model="search.unit_id" label="Product Unit"
                          :options="dropdownList.productUnits" emit-value map-options use-input @filter="unitfilter">
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                No results
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <q-input filled dense v-model="search.invoice_date" label="Invoice Date">
                          <template v-slot:append>
                            <q-icon name="event" class="cursor-pointer">
                              <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                <q-date v-model="search.invoice_date">
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
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <q-btn glossy @click="searchData()" flat color="white" class="bg-green-7 d-block"
                          style="text-transform: capitalize; padding: 0px 10px 0 19px">
                          Search
                        </q-btn>
                      </q-item-section>
                    </q-item>
                    <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <q-item-section>
                        <q-btn glossy @click="clearData()" flat color="white" class="bg-red-7 d-block"
                          style="text-transform: capitalize; padding: 0px 10px 0 19px">
                          Search
                        </q-btn>
                      </q-item-section>
                    </q-item>
                  </q-list>
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
                    <q-td key="item_name" :props="props">
                      {{ props.row.item_name }}
                    </q-td>
                    <q-td key="benefit_per_product" :props="props">
                      {{ props.row.benefit_per_product }}
                    </q-td>
                    <q-td key="benefit_amount" :props="props">
                      {{ props.row.benefit_amount }}
                    </q-td>
                    <q-td key="loss_per_product" :props="props">
                      {{ props.row.loss_per_product }}
                    </q-td>
                    <q-td key="loss_amount" :props="props">
                      {{ props.row.loss_amount }}
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
// import DateRange from 'datetimerangepicker'
// import { VueFlatPickr } from 'datetimerangepicker'

const metaData = { title: 'Benefit List' }

const columns = [
  { name: "sl", label: "Sl.", field: "sl", sortable: true, align: "left" },
  { name: "invoice_code", field: "invoice_code", label: "Invoice Code", sortable: true, align: "left" },
  { name: "invoice_date", field: "invoice_date", label: "Invoice Date", sortable: true, align: "left" },
  { name: "benefit_amount", field: "benefit_amount", label: "Benefit Amount", sortable: true, align: "right" },
  { name: "loss_amount", field: "loss_amount", label: "Loss Amount", sortable: true, align: "right" },
  { name: "action", field: "Action", label: "Action", sortable: false, align: "center" },
];

const productWisecolumns = [
  { name: "sl", label: "Sl.", field: "sl", sortable: true, align: "left" },
  { name: "invoice_date", field: "invoice_date", label: "Invoice Date", sortable: true, align: "left" },
  { name: "product_type_name", field: "product_type_name", label: "Product Name", sortable: true, align: "left" },
  { name: "category_name", field: "category_name", label: "Category", sortable: true, align: "left" },
  { name: "color_name", field: "color_name", label: "Color", sortable: true, align: "left" },
  { name: "unit_name", field: "unit_name", label: "Unit", sortable: true, align: "left" },
  { name: "benefit_per_product", field: "benefit_per_product", label: "Benefit Per Product", sortable: true, align: "right" },
  { name: "benefit_amount", field: "benefit_amount", label: "Benefit Amount", sortable: true, align: "right" },
  { name: "loss_per_product", field: "loss_per_product", label: "Loss Per Product", sortable: true, align: "right" },
  { name: "loss_amount", field: "loss_amount", label: "Loss Amount", sortable: true, align: "right" },
  { name: "action", field: "Action", label: "Action", sortable: false, align: "center" },
];

const itemWiseColumns = [
  { name: "item_name", field: "item_name", label: "Item Name", sortable: true, align: "left" },
  { name: "benefit_amount", field: "benefit_amount", label: "Benefit Amount", sortable: true, align: "right" },
  { name: "loss_amount", field: "loss_amount", label: "Loss Amount", sortable: true, align: "right" },
];

export default ({
  name: "BenefitList",
  mixins: [helperMixin],
  components: {
    DetailDialog,
    // DateRange,
    // VueFlatPickr
  },
  setup() {
    useMeta(metaData);
    const show_filter = ref(false);

    return {
      filter: ref(""),
      show_filter,
      columns,
      productWisecolumns,
      itemWiseColumns,
      tab: ref('invoice_wise')
    };
  },
  data() {
    return {
      date: new Date(),
      config: {
        wrap: true, // set wrap to true only when using 'input-group'
        altFormat: 'M j, Y',
        altInput: true,
        dateFormat: 'Y-m-d',
      },
      search: {
        product_type_id: '',
        category_id: '',
        color_id: '',
        unit_id: '',
        invoice_date: '',
      },
      dropdownList: {
        categories: [],
        suppliers: [],
        productUnits: [],
        productColors: [],
        productTypes: [],
      },
      dropdownList2: {
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
      productWiseBenefitAmount: 0,
      productWiseLossAmount: 0,
      productWiselistData: [],
      itemWiselistData: [],
      detailItems: [],
      dropdownList: [],
      editItem: '',
      // searchItemNameList: [
      //   { value: 'product_type', label: 'Product Type' },
      //   { value: 'category', label: 'Category' },
      //   { value: 'color', label: 'color' },
      //   { value: 'unit', label: 'unit' },
      // ]
    };
  },
  computed: {
    invoiceWiseTableRow: function () {
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
    },
    productWiseTableRow: function () {
      if (this.productWiselistData.length) {
        return this.productWiselistData.map(item => {
          item.invoice_date = item.invoice_date ? this.dDate(item.invoice_date) : ''
          return Object.assign(item)
        })
      } else {
        return []
      }
    },
    getProductWiseBenefitAmount: function () {
      let total = 0
      if (this.productWiselistData.length) {
        this.productWiselistData.forEach(item => {
          total = total + parseFloat(item.benefit_amount)
        })
      }
      return total
    },
    getProductWiseLossAmount: function () {
      let total = 0
      if (this.productWiselistData.length) {
        this.productWiselistData.forEach(item => {
          total = total + parseFloat(item.loss_amount)
        })
      }
      return total
    },
    itemWiseTableRow: function () {
      if (this.itemWiselistData.length) {
        return this.itemWiselistData.map(item => {
          item.invoice_date = item.invoice_date ? this.dDate(item.invoice_date) : ''
          return Object.assign(item)
        })
      } else {
        return []
      }
    }
  },
  mounted() {
    this.getInvoiceWiseLis();
    // this.getProductWiseList();
    // this.getItemWiseSearchList();
    this.getInitialData();
  },
  methods: {
    searchData: function () {
      this.getProductWiseList()
      // this.getItemWiseSearchList()
    },
    clearData: function () {
      this.search = {
        product_type_id: '',
        category_id: '',
        color_id: '',
        unit_id: '',
        invoice_date: '',
      }
      this.productWiselistData = []
    },
    openAddNewDialog: function () {
      this.editItem = ''
      this.showAddNewDialog = true
    },
    productTypefilter(val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.dropdownList.productTypes = this.dropdownList.productTypeList.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    categoryfilter(val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.dropdownList.categories = this.dropdownList.categoryList.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    unitfilter(val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.dropdownList.productUnits = this.dropdownList.productUnitList.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    colorfilter(val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.dropdownList.productColors = this.dropdownList.productColorList.filter(item => item.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    getInitialData: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_product_initial_dropdown_list'));
        this.dropdownList = res.data
        this.dropdownList2 = res.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
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
    getProductWiseList: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        const params = Object.assign(this.search, {
          invoice_start_date: typeof(this.search.invoice_date) == 'object' ? this.search.invoice_date.from : this.search.invoice_date,
          invoice_end_date: typeof(this.search.invoice_date) == 'object' ? this.search.invoice_date.to : this.search.invoice_date,
        })
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_benefit_and_loss_by_product_wise'), params);
        this.productWiselistData = res.data.data

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
    getItemWiseSearchList: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_benefit_and_loss_by_item_wise'), this.search);
        this.itemWiselistData = res.data.data

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

