<template>
  <q-page class="q-pa-sm">


    <q-card class="bg-transparent no-shadow no-border q-mb-sm" bordered>
      <q-card-section class="q-pa-none">
        <div class="row q-col-gutter-sm ">
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-green-9">
                <q-icon name="account_balance_wallet" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-green-8">
                <q-item-label>{{ $t('earning_today') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_earning_today }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-green-9">
                <q-icon name="account_balance_wallet" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-green-8">
                <q-item-label>{{ $t('earning_this_month') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_earning_this_month }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-green-9">
                <q-icon name="account_balance_wallet" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-green-8">
                <q-item-label>{{ $t('earning_last_six_month') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_earning_last_6th_month }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-green-9">
                <q-icon name="account_balance_wallet" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-green-8">
                <q-item-label>{{ $t('earning_this_year') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_earning_this_year }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-pink-9">
                <q-icon name="point_of_sale" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-pink-8">
                <q-item-label>{{ $t('sale_today') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_sale_today }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-pink-9">
                <q-icon name="point_of_sale" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-pink-8">
                <q-item-label>{{ $t('sale_this_month') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_sale_this_month }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-pink-9">
                <q-icon name="point_of_sale" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-pink-8">
                <q-item-label>{{ $t('sale_last_six_month') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_sale_last_6th_month }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-pink-9">
                <q-icon name="point_of_sale" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-pink-8">
                <q-item-label>{{ $t('sale_this_year') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_sale_this_year }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-orange-9">
                <q-icon name="balance" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-orange-8">
                <q-item-label>{{ $t('due_today') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_due_today }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-orange-9">
                <q-icon name="balance" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-orange-8">
                <q-item-label>{{ $t('due_this_month') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_due_this_month }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <!-- <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-orange-9">
                <q-icon name="balance" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-orange-8">
                <q-item-label>Due Last 6th Month</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_due_last_6th_month }}</q-item-label>
              </q-item-section>
            </q-item>
          </div> -->
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-orange-9">
                <q-icon name="balance" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-orange-8">
                <q-item-label>{{ $t('due_this_year') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_due_this_year }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <q-item class="q-pa-none">
              <q-item-section side class="q-pa-lg q-mr-none text-white bg-orange-9">
                <q-icon name="balance" color="white" size="24px"></q-icon>
              </q-item-section>
              <q-item-section class="q-pa-md q-ml-none text-white bg-orange-8">
                <q-item-label>{{ $t('total_due') }}</q-item-label>
                <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_due }}</q-item-label>
              </q-item-section>
            </q-item>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <router-link to="/customer-list" class="text-white text-decoration-none">
              <q-item class="q-pa-none">
                <q-item-section side class="q-pa-lg q-mr-none text-white bg-purple-9">
                  <q-icon name="people" color="white" size="24px"></q-icon>
                </q-item-section>
                <q-item-section class="q-pa-md q-ml-none text-white bg-purple-8">
                  <q-item-label>{{ $t('total_customers') }}</q-item-label>
                  <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_customer }}</q-item-label>
                </q-item-section>
              </q-item>
            </router-link>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <router-link to="/supplier-list" class="text-white text-decoration-none">
              <q-item class="q-pa-none">
                <q-item-section side class="q-pa-lg q-mr-none text-white bg-indigo-9">
                  <q-icon name="airport_shuttle" color="white" size="24px"></q-icon>
                </q-item-section>
                <q-item-section class="q-pa-md q-ml-none text-white bg-indigo-8">
                  <q-item-label>{{ $t('total_suppliers') }}</q-item-label>
                  <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_supplier }}</q-item-label>
                </q-item-section>
              </q-item>
            </router-link>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <router-link to="/employee-list" class="text-white text-decoration-none">
              <q-item class="q-pa-none">
                <q-item-section side class="q-pa-lg q-mr-none text-white bg-teal-9">
                  <q-icon name="badge" color="white" size="24px"></q-icon>
                </q-item-section>
                <q-item-section class="q-pa-md q-ml-none text-white bg-teal-8">
                  <q-item-label>{{ $t('total_employees') }}</q-item-label>
                  <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_employee }}</q-item-label>
                </q-item-section>
              </q-item>
            </router-link>
          </div>
          <div class="col-md-3 col-sm-12 col-xs-12">
            <router-link to="/user-list" class="text-white text-decoration-none">
              <q-item class="q-pa-none">
                <q-item-section side class="q-pa-lg q-mr-none text-white bg-lime-9">
                  <q-icon name="person" color="white" size="24px"></q-icon>
                </q-item-section>
                <q-item-section class="q-pa-md q-ml-none text-white bg-lime-8">
                  <q-item-label>{{ $t('total_users') }}</q-item-label>
                  <q-item-label class="text-white text-h6 text-weight-bolder">{{ dashboardData.total_user }}</q-item-label>
                </q-item-section>
              </q-item>
            </router-link>
          </div>
        </div>
      </q-card-section>
    </q-card>


    <div class="row q-col-gutter-sm  q-py-sm">
      <tab-most-favorite
      :dashboardData="dashboardData"
      />
    </div>

    <card-charts />

    <!-- <div class="row q-col-gutter-sm  q-pb-sm">
      <todo-list />

      <card-time-line/>
    </div> -->

    <!-- <table-visits /> -->
  </q-page>
</template>

<script>
import { defineComponent, defineAsyncComponent } from 'vue'
import helperMixin from 'src/mixins/helper_mixin.js'

export default defineComponent({
  name: 'PageIndex',
  mixins: [helperMixin],
  components: {
    TabMostFavorite: defineAsyncComponent(() => import('components/tabs/TabMostFavorite.vue')),
    // CalenderComponent: defineAsyncComponent(() => import('components/tabs/CalenderComponent.vue')),
    // CardCharts: defineAsyncComponent(() => import('components/cards/CardCharts.vue')),
    // CardSocial: defineAsyncComponent(() => import('components/cards/CardSocial.vue')),
    // TabSocial: defineAsyncComponent(() => import('components/tabs/TabSocial.vue')),
    // CardWithImage: defineAsyncComponent(() => import('components/cards/CardWithImage.vue')),
    // CardTimeLine: defineAsyncComponent(() => import('components/cards/CardTimeLine.vue')),
    // TodoList: defineAsyncComponent(() => import('components/list/TodoList.vue')),
    // TableVisits: defineAsyncComponent(() => import('components/tables/TableVisits.vue')),
  },
  setup() {
    return {
      mode: 'list',
    }
  },
  data () {
    return {
      dashboardData: '',
    }
  },
  created () {},
  mounted () {
    this.getDashboardCouterList()
  },
  methods: {
    getDashboardCouterList: async function () {
      let ref = this;
      let jq = ref.jq();
      try {
        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_dashboard_caculation_data'));
        this.dashboardData = res.data.dashboardData

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }
    },
  }

})
</script>

<style>
.text-decoration-none { text-decoration: none !important;}
.text-decoration-none:hover {
  text-decoration: underline !important;
}
</style>
