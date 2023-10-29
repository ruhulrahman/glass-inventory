<template>
  <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
    <q-card class="fit no-shadow" bordered>
      <q-tabs v-model="tab" dense class="text-grey" active-color="green-7 bg-green-1" indicator-color="green-7" align="justify">
        <q-tab name="mostSelling" :class="tab == 'mostSelling' ? 'text-blue' : ''" icon="inventory" :label="$t('most_selling_products')" />
        <q-tab name="topTenCustomer" :class="tab=='topTenCustomer'?'text-blue':''" icon="people" :label="$t('top_10_customers')">
          <!-- <q-badge color="red" floating>{{ messages.length }}</q-badge> -->
        </q-tab>
        <q-tab name="topTenPurchaseCustomer" :class="tab=='topTenPurchaseCustomer'?'text-red':''" icon="favorite" :label="$t('top_10_valuable_customers')">
        </q-tab>
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="mostSelling" class="q-pa-sm">
          <q-list class="rounded-borders" separator>

            <q-item v-for="(item, index) in dashboardData.productStocks" :key="index" clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="inventory" color="accent"/>
              </q-item-section>

              <q-item-section>
                <q-item-label lines="1">{{ cn(item, 'category.name') + ' ' + cn(item, 'color.name') + ' ' + cn(item, 'type.name') }}</q-item-label>
                <q-item-label caption lines="2">
                  <!-- <span class="text-weight-bold">{{ item.position }}</span> -->
                </q-item-label>
              </q-item-section>

              <q-item-section side>
                <div class="text-grey-8 q-gutter-xs">
                  <span>{{ item.sale_count }} {{ $t('piece_sold') }}</span>
                </div>
              </q-item-section>
            </q-item>
          </q-list>

        </q-tab-panel>
        <q-tab-panel name="topTenCustomer" class="q-pa-sm">
          <q-list class="rounded-borders" separator>

            <q-item v-for="(item, index) in dashboardData.topTenCustomers" :key="index" clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="people" color="purple"/>
              </q-item-section>

              <q-item-section>
                <q-item-label lines="1">{{ cn(item, 'customer.name') }}</q-item-label>
                <q-item-label caption lines="2">
                  <span class="text-weight-bold">{{ cn(item, 'customer.phone') }}</span>
                </q-item-label>
              </q-item-section>

              <q-item-section side>
                <div class="text-grey-8 q-gutter-xs">
                  <span>{{ item.product_buy_count }} {{ $t('times_buy') }}</span>
                </div>
              </q-item-section>
            </q-item>
          </q-list>

        </q-tab-panel>
        <q-tab-panel name="topTenPurchaseCustomer" class="q-pa-sm">
          <q-list class="rounded-borders" separator>

            <q-item v-for="(item, index) in dashboardData.topTenPurchaseCustomers" :key="index" clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="people" color="purple"/>
              </q-item-section>

              <q-item-section>
                <q-item-label lines="1">{{ cn(item, 'customer.name') }}</q-item-label>
                <q-item-label caption lines="2">
                  <span class="text-weight-bold">{{ cn(item, 'customer.phone') }}</span>
                </q-item-label>
              </q-item-section>

              <q-item-section side>
                <div class="text-grey-8 q-gutter-xs">
                  <span>{{ item.purchase_total }} {{ $t('tk_product_buy') }}</span>
                </div>
              </q-item-section>
            </q-item>
          </q-list>

        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { ref } from 'vue'

import helperMixin from 'src/mixins/helper_mixin.js'

export default defineComponent({
  name: 'TabSocial',
  mixins: [helperMixin],
  props: ['dashboardData'],
  setup() {
    return {
      tab: ref('mostSelling'),
    }
  }
})
</script>
