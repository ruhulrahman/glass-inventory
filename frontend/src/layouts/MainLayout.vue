<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn flat dense round @click="toggleLeftDrawer" icon="menu" aria-label="Menu" />
        <q-toolbar-title class="text-green-14">
          {{ $t('welcome_to_glass_garden') }}
        </q-toolbar-title>
        <q-space />
        <div class="q-gutter-sm row items-center no-wrap">
          <q-btn-toggle
            size="sm"
            name="genre"
            v-model="lang"
            push
            glossy
            toggle-color="teal"
            :options="[
              {label: 'BN', value: 'bn'},
              {label: 'EN', value: 'en'},
            ]"
          />
          <q-btn round dense flat color="white" :icon="$q.fullscreen.isActive ? 'fullscreen_exit' : 'fullscreen'"
            @click="$q.fullscreen.toggle()" v-if="$q.screen.gt.sm">
          </q-btn>
          <!-- <q-btn round dense flat style="color:red !important;" type="a" href="https://github.com/sponsors/pratik227"
                 target="_blank">
            <i class="fa fa-heart fa-2x fa-beat"></i>
          </q-btn> -->
          <!-- <q-btn round dense flat color="white" icon="notifications">
            <q-badge color="red" text-color="white" floating>
              5
            </q-badge>
            <q-menu>
              <q-list style="min-width: 100px">
                <messages></messages>
                <q-card class="text-center no-shadow no-border">
                  <q-btn label="View All" style="max-width: 120px !important;" flat dense class="text-indigo-8"></q-btn>
                </q-card>
              </q-list>
            </q-menu>
          </q-btn> -->
          <q-btn round flat>
            <q-avatar size="26px">
              <img v-if="authUserData && authUserData.avatar" :src="authUserData.avatar">
              <img v-else src="https://cdn.quasar.dev/img/boy-avatar.png">
            </q-avatar>

            <q-menu>
              <q-list>
                <q-item clickable @click="detailsData()" active-class="q-item-no-link-highlighting">
                  <q-item-section avatar>
                    <q-icon name="account_circle" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Profile</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable @click="(() => { showAddNewDialog = true })" active-class="q-item-no-link-highlighting">
                  <q-item-section avatar>
                    <q-icon name="key" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Forgot Password</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-menu>
            <!-- <q-menu style="">
              <q-list style="padding: 5px 10px !important;">

                <q-item clickable @click="detailsData()" active-class="q-item-no-link-highlighting">
                  <q-item-section avatar>
                    <q-icon name="account_circle" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>Profile</q-item-label>
                  </q-item-section>
                </q-item>
                <q-card class="text-left no-shadow no-border" @click="detailsData()">
                  <q-icon name="person"></q-icon>
                  <q-btn label="Profile" style="text-transform: capitalize;" flat dense class="text-black"></q-btn>
                </q-card>
                <q-card class="text-left no-shadow no-border" @click="(() => { showAddNewDialog = true })">
                  <q-icon name="key"></q-icon>
                  <q-btn label="Forgot Password" style="text-transform: capitalize;" flat dense
                    class="text-black"></q-btn>
                </q-card>
              </q-list>
            </q-menu> -->
          </q-btn>
          <q-btn round dense flat style="color:red !important;">
            <i class="fa-solid fa-power-off fa-2x" @click="logOut()"></i>
          </q-btn>
          <!-- <router-link to="/logout" round dense flat style="color:red !important;">
              <q-tooltip class="bg-red" transition-show="scale" transition-hide="scale" anchor="bottom middle" self="center middle">
                Logout
              </q-tooltip>
              <i class="fa-solid fa-power-off fa-2x"></i>
            </router-link> -->
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered class="bg-primary text-white">
      <q-list>
        <q-item active-class="q-item-no-link-highlighting">
          <q-item-section>
            <q-item-label class="text-h6 text-green-13">{{ $t('glass_inventory') }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item to="/" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="dashboard" />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ $t('dashboard') }}</q-item-label>
          </q-item-section>
        </q-item>


        <q-expansion-item v-if="has_permission('product_management')" icon="inventory" :label="$t('product_management')">
          <q-list class="q-pl-lg">

            <q-item v-if="has_permission('supplier_list')" to="/supplier-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="airport_shuttle" color="light-blue" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('supplier_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('customer_list')" to="/customer-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="people" color="deep-purple-11" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('customer_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('color_list')" to="/color-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="palette" color="warning" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('color_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('unit_list')" to="/unit-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="straighten" color="positive" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('unit_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('category_list')" to="/category-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="category" color="pink" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('category_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('product_type_list')" to="/product-type-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="keyboard_alt" color="teal" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('product_type_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('products_stock')" to="/product-stock-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="inventory" color="accent" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('products_stock') }}</q-item-label>
              </q-item-section>
            </q-item>

          </q-list>
        </q-expansion-item>


        <q-expansion-item v-if="has_permission('sales_management')">
          <template v-slot:header>
            <q-item-section avatar>
              <!-- <q-avatar icon="flag" color="primary" text-color="yellow" /> -->
              <q-icon name="fab fa-sellcast" color="yellow" />
            </q-item-section>
            <q-item-section>
              {{ $t('sales_management') }}
            </q-item-section>
          </template>
          <q-list class="q-pl-lg">

            <q-item v-if="has_permission('sales')" to="/sale-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="point_of_sale" color="light-green-14" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('sales') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('benefit_and_loss')" to="/benefit-or-loss-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="account_balance_wallet" color="indigo-4" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('benefit_and_loss') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('due')" to="/due-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="money" color="deep-orange-13" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('due') }}</q-item-label>
              </q-item-section>
            </q-item>

          </q-list>
        </q-expansion-item>


        <q-expansion-item icon="fas fa-building" :label="$t('company_management')" v-if="has_permission('company_management')">
          <q-list class="q-pl-lg">

            <q-item v-if="has_permission('company_list')" to="/company-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="business" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('company_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('department_list')" to="/department-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="apartment" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('department_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('designation_list')" to="/designation-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="business_center" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('designation_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('bank_list')" to="/company-bank-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="account_balance" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('bank_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('weekend_list')" to="/weekends" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="watch" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('weekend_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('holiday_list')" to="/holidays" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="watch" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('holiday_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('permission_list')" to="/permission-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="lock_person" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('permission_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('role_list')" to="/role-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="accessibility" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('role_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('user_list')" to="/user-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="person" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('user_list') }}</q-item-label>
              </q-item-section>
            </q-item>

          </q-list>
        </q-expansion-item>


        <q-expansion-item icon="far fa-address-card" :label="$t('employee_management')" v-if="has_permission('employee_management')">
          <q-list class="q-pl-lg">

            <q-item v-if="has_permission('employee_list')" to="/employee-list" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="badge" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('employee_list') }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item v-if="has_permission('attendance')" to="/employee-attendances" active-class="q-item-no-link-highlighting">
              <q-item-section avatar>
                <q-icon name="fas fa-clipboard-user" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ $t('attendance') }}</q-item-label>
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

        <!-- <q-expansion-item
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
        </q-expansion-item> -->

        <!-- <q-expansion-item
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
        </q-item> -->

        <!--        not completed-->
        <!-- <q-item to="/Calendar" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="date_range"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Calendar</q-item-label>
          </q-item-section>
        </q-item> -->

        <!--        not completed-->
        <!--        <q-item to="/Taskboard" active-class="q-item-no-link-highlighting">-->
        <!--          <q-item-section avatar>-->
        <!--            <q-icon name="done"/>-->
        <!--          </q-item-section>-->
        <!--          <q-item-section>-->
        <!--            <q-item-label>Taskboard</q-item-label>-->
        <!--          </q-item-section>-->
        <!--        </q-item>-->

        <!-- <q-item to="/Pagination" active-class="q-item-no-link-highlighting">
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
        </q-expansion-item> -->
      </q-list>
    </q-drawer>

    <q-page-container class="bg-grey-2">
      <router-view />

      <q-card class="no-shadow" bordered>
        <q-card-section class="row q-pa-lg">
          <span class="text-body1 text-grey-8 text-weight-bold">
            {{ $t('software_developed_by') }} <a href="https://www.facebook.com/Ruhul14.02/" target="_blank">
              Ruhul Amin
              <q-tooltip class="bg-primary" transition-show="scale" transition-hide="scale" anchor="bottom middle"
                self="center middle">
                Phone: 01638584622
              </q-tooltip>
            </a>
          </span>
          <q-space></q-space>
          <q-btn icon="fab fa-facebook" href="https://www.facebook.com/Ruhul14.02/" target="_blank" flat dense
            color="blue"></q-btn>
          <q-btn icon="fab fa-github" href="https://github.com/ruhulrahman" target="_blank" flat dense
            color="grey-8"></q-btn>
        </q-card-section>
      </q-card>

      <q-dialog v-model="showAddNewDialog" position="right">
        <forgot-pass :title="$t('reset_password')" :editItem="user" @closeModal="showAddNewDialog = false" />
      </q-dialog>

      <div class="q-pa-md q-gutter-sm">
        <q-dialog v-model="showDetailsDialog">

          <user-profile :title="user.name + ' Details'" :editItem="user" @closeModal="showDetailsDialog = false" />
        </q-dialog>
      </div>
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'
import Messages from "./Messages.vue";
import helperMixin from 'src/mixins/helper_mixin.js'

import { defineComponent, ref } from 'vue'
import { useQuasar, useMeta } from "quasar";
import ForgotPass from "../pages/company-management/users/ForgotPass.vue";
import UserProfile from "../pages/company-management/users/Profile.vue";

import { computed } from 'vue';
import { useAuthStore } from 'src/stores/auth-store.js';


const metaData = {
  // optional; sets final title as "Login Page - nventory App", useful for multiple level meta
  titleTemplate: title => `${title} - Inventory App`,
}

export default defineComponent({
  name: 'MainLayout',

  components: {
    EssentialLink,
    Messages,
    ForgotPass,
    UserProfile
  },
  mixins: [helperMixin],
  setup() {
    useMeta(metaData)
    const leftDrawerOpen = ref(false)
    const $q = useQuasar()

    const store = useAuthStore()
    const authUserData = computed(() => store.authUser);
    const userPermissions = computed(() => store.userPermissions);

    return {
      $q,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      },
      store,
      authUserData,
      userPermissions
    }
  },
  data() {
    return {
      showAddNewDialog: false,
      user: null,
      showDetailsDialog: false,
      lang: this.$i18n.locale
    }
  },
  watch: {
    'lang': function (lang) {
      this.$i18n.locale = lang
      // set quasar's language too!!
      // import(`quasar/lang/${lang}`).then(language =>
      // {this.$q.lang.set(language.default)
      // })
    }
  },
  created() {

    // store.authUser = res.data.auth_user
    // store.userPermissions = res.data.user_permissions

    let api_token = localStorage.getItem('api_token');

    if (api_token) {

      // this.$store.commit('setApiToken', api_token);
      this.ajax_setup();
      // this.getAuthUserInfo();

    }
  },
  mounted: async function () {

    // this.getCommonDropdownList();
    this.authUser()

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

    authUser: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_auth_user'));
        ref.user = res.data.auth_user
        
        const store = useAuthStore()
        store.authUser = res.data.auth_user
        store.userPermissions = res.data.user_permissions

      } catch (error) {
        this.alert(ref.err_msg(error), 'error')
      }
    },
    logOut: async function () {
      let ref = this;
      let jq = ref.jq();

      try {
        let res = await jq.post(ref.apiUrl('api/v1/admin/logout'));
        this.notify(res.msg)
        localStorage.removeItem('api_token');
        localStorage.removeItem('auth_user_id');
        ref.$router.push('/login')

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      }
    },
    detailsData: async function () {
      this.showDetailsDialog = true
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

.waitMe {
  position: absolute !important;
  top: 0px !important;
  width: 100% !important;
  height: 100% !important;
  /* text-align: center; */
}

.waitMe_text {
  margin-top: 30% !important;
  text-align: center;
}

.q-router-link--exact-active {
  background: #00000036 !important;
}

.font-size-10 {
  font-size: 10px !important;
}

.font-size-11 {
  font-size: 11px !important;
}

.font-size-12 {
  font-size: 12px !important;
}

.font-size-13 {
  font-size: 13px !important;
}

.font-size-14 {
  font-size: 14px !important;
}

.font-size-15 {
  font-size: 15px !important;
}

.font-size-16 {
  font-size: 16px !important;
}

.font-size-18 {
  font-size: 18px !important;
}

.font-size-20 {
  font-size: 20px !important;
}

.font-size-22 {
  font-size: 22px !important;
}

.font-size-24 {
  font-size: 24px !important;
}

.font-size-26 {
  font-size: 26px !important;
}

.font-size-28 {
  font-size: 28px !important;
}

.font-size-30 {
  font-size: 30px !important;
}

.font-size-32 {
  font-size: 32px !important;
}

.font-size-34 {
  font-size: 34px !important;
}

.font-size-36 {
  font-size: 36px !important;
}

.font-weight-400 {
  font-weight: 400 !important;
}

.font-weight-500 {
  font-weight: 500 !important;
}

.font-weight-600 {
  font-weight: 600 !important;
}

.font-weight-700 {
  font-weight: 700 !important;
}

.font-weight-800 {
  font-weight: 800 !important;
}

.font-weight-900 {
  font-weight: 900 !important;
}
</style>
