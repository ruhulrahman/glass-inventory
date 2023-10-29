<template>
  <q-card class="bg-primary text-white no-shadow wait_me" bordered>
    <q-card-section class="row q-pa-sm">
      <q-item class="full-width">
        <q-item-section>
          <q-item-label class="text-h6 text-weight-bolder" lines="1">{{ $t('product_pricing_history') }}</q-item-label>
        </q-item-section>
        <q-item-section side>
          <q-icon name="cancel" color="white" clickable style="cursor: pointer;"
            @click="(() => { $emit('closeModal', true) })"></q-icon>
        </q-item-section>
      </q-item>
    </q-card-section>
    <q-card-section class="q-pa-sm ">
      <q-table flat bordered class="no-shadow wait_me" :rows="tableRow" :columns="columns" row-key="name"
        no-data-label=" I didn't find anything for you" :loading="loading" :pagination="initialPagination"
        :filter="filter">
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
            <q-td key="price" :props="props">
              {{ props.row.price }}
            </q-td>
            <q-td key="quantity" :props="props">
              {{ props.row.quantity }}
            </q-td>
            <q-td key="cost" :props="props">
              {{ props.row.cost }}
            </q-td>
            <q-td key="selling_price" :props="props">
              {{ props.row.selling_price }}
            </q-td>
            <q-td key="supplier" :props="props">
              {{ props.row.supplier ? props.row.supplier.name : '' }}
            </q-td>
            <q-td key="creator" :props="props">
              {{ props.row.creator ? props.row.creator.name : '' }}
            </q-td>
            <q-td key="created_at" :props="props">
              {{ dDate(props.row.created_at) }}
            </q-td>
            <q-td key="action" :props="props">
              <q-btn @click="deleteData(props.row)" icon="delete" size="sm" class="text-red" flat dense />
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </q-card-section>
  </q-card>
</template>

<script>
import helperMixin from 'src/mixins/helper_mixin.js'
import { ref } from 'vue'

export default {
  props: ['listData'],
  mixins: [helperMixin],
  setup() {
    const show_filter = ref(false);

    return {
      filter: ref(""),
      show_filter,
    };
  },
  data() {
    return {
    }
  },
  computed: {
    tableRow: function () {
      console.log('this.listData', this.listData)
      if (this.listData.length) {
        return this.listData.map(item => {
          return Object.assign(item)
        })
      } else {
        return []
      }
    },
    columns: function () {
      return [
        { name: "sl", label: this.$t('sl'), field: "sl", sortable: true, align: "left" },
        { name: "price", label: this.$t('unit_price'), field: "price", sortable: true, align: "right" },
        { name: "quantity", label: this.$t('quantity'), field: "quantity", sortable: true, align: "left" },
        { name: "cost", label: this.$t('cost'), field: "cost", sortable: true, align: "right" },
        { name: "selling_price", label: this.$t('selling_price'), field: "selling_price", sortable: true, align: "right" },
        { name: "supplier", label: this.$t('supplier'), field: "supplier", sortable: true, align: "left" },
        { name: "creator", label: this.$t('creator'), field: "creator", sortable: true, align: "left" },
        { name: "created_at", label: this.$t('created_at'), field: "created_at", sortable: true, align: "right" },
        {
          name: "action",
          label: this.$t('action'),
          field: "Action",
          sortable: false,
          align: "center",
        },
      ];
    }
  },
  created() {
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
        this.loadingState = true
        let res = ''
        if (this.submitForm.id) {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/update_product_data'), this.submitForm);
        } else {
          res = await jq.post(ref.apiUrl('api/v1/admin/ajax/store_product_data'), this.submitForm);
        }
        this.notify(res.msg)
        this.$emit('closeModal', true)
        this.$emit('reloadListData', true)
      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        // ref.wait_me(".wait_me", "hide");
        this.loadingState = false
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
