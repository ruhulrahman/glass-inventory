<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="toggleLeftDrawer"
          icon="menu"
          aria-label="Menu"
        />
        <q-toolbar-title class="text-green-14">
          Welcome to Glass Garden Invetory Software
        </q-toolbar-title>
        <q-space/>
        <div class="q-gutter-sm row items-center no-wrap">
          <q-btn round dense flat color="white" :icon="$q.fullscreen.isActive ? 'fullscreen_exit' : 'fullscreen'"
                  @click="$q.fullscreen.toggle()"
                  v-if="$q.screen.gt.sm">
          </q-btn>
          <!-- <q-btn round dense flat style="color:red !important;" type="a" href="https://github.com/sponsors/pratik227"
                 target="_blank">
            <i class="fa fa-heart fa-2x fa-beat"></i>
          </q-btn> -->
          <q-btn round dense flat color="white" icon="notifications">
            <q-badge color="red" text-color="white" floating>
              5
            </q-badge>
            <q-menu
            >
              <q-list style="min-width: 100px">
                <messages></messages>
                <q-card class="text-center no-shadow no-border">
                  <q-btn label="View All" style="max-width: 120px !important;" flat dense
                         class="text-indigo-8"></q-btn>
                </q-card>
              </q-list>
            </q-menu>
          </q-btn>
          <q-btn round flat>
            <q-avatar size="26px">
              <img src="https://cdn.quasar.dev/img/boy-avatar.png">
            </q-avatar>
          </q-btn>
            <router-link to="/logout" round dense flat style="color:red !important;">
              <q-tooltip class="bg-red" transition-show="scale" transition-hide="scale" anchor="bottom middle" self="center middle">
                Logout
              </q-tooltip>
              <i class="fa-solid fa-power-off fa-2x"></i>
            </router-link>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      class="bg-primary text-white"
    >
      <q-list>
        <q-item active-class="q-item-no-link-highlighting">
          <q-item-section>
            <q-item-label class="text-h6 text-green-13">Glass Inventory</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="dashboard"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Dashboard</q-item-label>
          </q-item-section>
        </q-item>


        <q-expansion-item
          icon="settings"
          label="Configuration"
        >
          <q-list class="q-pl-lg">
            <q-item to="/user-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="person"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>User List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/employee-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="person"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Employee List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/company-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="business"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Company List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/department-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="apartment"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Department List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/designation-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="business_center"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Designation List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/company-bank-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="account_balance"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Bank List</q-item-label>
              </q-item-section>
            </q-item>

          </q-list>
        </q-expansion-item>

        <q-item to="/employee-attendances" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="attendance"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Attendance</q-item-label>
          </q-item-section>
        </q-item>


        <q-expansion-item
          icon="inventory"
          label="Product Management"
        >

          <q-list class="q-pl-lg">

            <q-item to="/supplier-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="airport_shuttle" color="light-blue"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Supplier List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/customer-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="people" color="deep-purple-11"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Customer List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/color-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="palette" color="warning"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Color List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/unit-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="straighten" color="positive"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Unit List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/category-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="category" color="pink"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Category List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/product-type-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="keyboard_alt" color="teal"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Product Type List</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/product-stock-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="inventory" color="accent"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Products Stock</q-item-label>
              </q-item-section>
            </q-item>

            <q-item to="/sale-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="point_of_sale" color="light-green-14"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Sales</q-item-label>
              </q-item-section>
            </q-item>

          </q-list>
        </q-expansion-item>

        <!-- <q-item to="/Dashboard2" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="dashboard"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>CRM Dashboard</q-item-label>
          </q-item-section>
        </q-item> -->
        <q-expansion-item
          icon="pages"
          label="Pages"
        >
          <q-list class="q-pl-lg">
            <q-item to="/Login-1" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="email"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Login-1</q-item-label>
              </q-item-section>
            </q-item>
            <q-item to="/Lock" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="lock"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Lock Screen</q-item-label>
              </q-item-section>
            </q-item>
            <q-item to="/Lock-2" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="lock"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Lock Screen - 2</q-item-label>
              </q-item-section>
            </q-item>
            <q-item to="/Pricing" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="list"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Pricing</q-item-label>
              </q-item-section>
            </q-item>
            <q-item-label header class="text-weight-bolder text-white">Generic</q-item-label>
            <q-item to="/Profile" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="person"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>User Profile</q-item-label>
              </q-item-section>
            </q-item>
            <q-item to="/Maintenance" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="settings"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Maintenance</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-expansion-item>
        <q-expansion-item
          icon="map"
          label="Maps"
        >
          <q-list class="q-pl-lg">
            <q-item to="/Map" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="map"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Map</q-item-label>
              </q-item-section>
            </q-item>
            <q-item to="/MapMarker" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="location_on"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Map Marker</q-item-label>
              </q-item-section>
            </q-item>
            <q-item to="/StreetView" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="streetview"/>
              </q-item-section>
              <q-item-section>
                <q-item-label>Street View</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-expansion-item>

        <q-item to="/Mail" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="email"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Mail</q-item-label>
          </q-item-section>
        </q-item>

        <q-item to="/directory" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="card_giftcard"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Directory</q-item-label>
          </q-item-section>
        </q-item>

        <q-item to="/TreeTable" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="list"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>TreeTable</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/Charts" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="insert_chart"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Charts</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/Footer" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="info"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Footer</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/CardHeader" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="card_giftcard"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Card Header</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/Cards" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="card_giftcard"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Cards</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/Tables" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="table_chart"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Tables</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/Contact" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="person"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Contact</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/Checkout" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="check_circle_outline"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Checkout</q-item-label>
          </q-item-section>
        </q-item>

        <!--        not completed-->
        <q-item to="/Calendar" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="date_range"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Calendar</q-item-label>
          </q-item-section>
        </q-item>

        <!--        not completed-->
        <!--        <q-item to="/Taskboard" active-class="q-item-no-link-highlighting">-->
        <!--          <q-item-section avatar>-->
        <!--            <q-icon name="done"/>-->
        <!--          </q-item-section>-->
        <!--          <q-item-section>-->
        <!--            <q-item-label>Taskboard</q-item-label>-->
        <!--          </q-item-section>-->
        <!--        </q-item>-->

        <q-item to="/Pagination" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="date_range"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Pagination</q-item-label>
          </q-item-section>
        </q-item>
        <q-item to="/Ecommerce" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="shopping_cart"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Product Catalogues</q-item-label>
          </q-item-section>
        </q-item>
        <q-expansion-item
          icon="menu_open"
          label="Menu Levels"
        >
          <q-item class="q-ml-xl" active-class="q-item-no-link-highlighting">
            <q-item-section>
              <q-item-label>Level 1</q-item-label>
            </q-item-section>
          </q-item>
          <q-expansion-item
            :header-inset-level="0.85"
            label="Level 2"
          >
            <q-item class="q-ml-xl" style="margin-left: 55px  !important;" active-class="q-item-no-link-highlighting">
              <q-item-section>
                <q-item-label>Level 2.1</q-item-label>
              </q-item-section>
            </q-item>
            <q-expansion-item
              :header-inset-level="1"
              label="Level 2.2"
            >
              <q-item style="margin-left: 65px  !important;" active-class="q-item-no-link-highlighting">
                <q-item-section>
                  <q-item-label>Level 2.2.1</q-item-label>
                </q-item-section>
              </q-item>
              <q-item style="margin-left: 65px  !important;" active-class="q-item-no-link-highlighting">
                <q-item-section>
                  <q-item-label>Level 2.2.2</q-item-label>
                </q-item-section>
              </q-item>
            </q-expansion-item>
          </q-expansion-item>
        </q-expansion-item>
      </q-list>
    </q-drawer>

    <q-page-container class="bg-grey-2">
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'
import Messages from "./Messages.vue";
import helperMixin from 'src/mixins/helper_mixin.js'

import {defineComponent, ref} from 'vue'
import {useQuasar, useMeta} from "quasar";


const metaData = {
  // optional; sets final title as "Login Page - nventory App", useful for multiple level meta
  titleTemplate: title => `${title} - Inventory App`,
}

export default defineComponent({
  name: 'MainLayout',

  components: {
    EssentialLink,
    Messages
  },
  mixins: [helperMixin],
  setup() {
    useMeta(metaData)
    const leftDrawerOpen = ref(false)
    const $q = useQuasar()

    return {
      $q,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  },
  created () {

    let api_token=localStorage.getItem('api_token');

    if(api_token){

      // this.$store.commit('setApiToken', api_token);
      this.ajax_setup();
      // this.getAuthUserInfo();

    }
  },
  mounted: async function(){

    // this.getCommonDropdownList();


  },
  methods: {
    getCommonDropdownList: async function () {

      let ref = this;
      let url = `${this.base_url}/api/v1/get_common_dropdown_list`;
      let jq = ref.jq();

      try {
          let res = await jq.get(url);
          this.$store.commit('setDropdowns', res.data);
      } catch (error) {
          this.alert(ref.err_msg(error), 'error')
      }
    },
  },
})
</script>

<style>

/* FONT AWESOME GENERIC BEAT */
.fa-beat {
  animation: fa-beat 5s ease infinite;
}

@keyframes fa-beat {
  0% {
    transform: scale(1);
  }
  5% {
    transform: scale(1.25);
  }
  20% {
    transform: scale(1);
  }
  30% {
    transform: scale(1);
  }
  35% {
    transform: scale(1.25);
  }
  50% {
    transform: scale(1);
  }
  55% {
    transform: scale(1.25);
  }
  70% {
    transform: scale(1);
  }
}

.waitMe{
  position: absolute !important;
    top: 0px !important;
    width: 100% !important;
    height: 100% !important;
    /* text-align: center; */
}

.waitMe_text{
   margin-top: 30% !important;
    text-align: center;
}

</style>
