const routes = [
  {
    path: '/login',
    component: () => import('layouts/UserLogin.vue'),
    meta: { requiresAuth : false },
  },
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    meta: { requiresAuth : true },
    children: [
      {path: '', component: () => import('pages/Dashboard.vue')},
      {path: '/logout', component: () => import('pages/Logout.vue')},

      // company-management
      {path: '/permission-list', component: () => import('pages/company-management/permission/List.vue')},
      {path: '/role-list', component: () => import('pages/company-management/role/List.vue')},
      {path: '/add-or-update-role/:role_id?', component: () => import('pages/company-management/role/AddOrUpdate.vue')},
      {path: '/company-list', component: () => import('pages/company-management/companies/List.vue')},
      {path: '/company-bank-list', component: () => import('pages/company-management/banks/List.vue')},
      {path: '/department-list', component: () => import('pages/company-management/departments/List.vue')},
      {path: '/designation-list', component: () => import('pages/company-management/designations/List.vue')},
      {path: '/weekends', component: () => import('pages/company-management/weekends/List.vue')},
      {path: '/holidays', component: () => import('pages/company-management/holidays/List.vue')},
      {path: '/user-list', component: () => import('pages/company-management/users/List.vue')},

      {path: '/color-list', component: () => import('pages/product-management/color/List.vue')},
      {path: '/unit-list', component: () => import('pages/product-management/unit/List.vue')},
      {path: '/category-list', component: () => import('pages/product-management/category/List.vue')},
      {path: '/product-type-list', component: () => import('pages/product-management/product-type/List.vue')},
      {path: '/supplier-list', component: () => import('pages/product-management/supplier/List.vue')},
      {path: '/product-stock-list', component: () => import('pages/product-management/product-stock/List.vue')},
      {path: '/sale-list', component: () => import('pages/product-management/sale/List.vue')},
      {path: '/benefit-or-loss-list', component: () => import('pages/product-management/benefit/List.vue')},
      {path: '/due-list', component: () => import('pages/product-management/due/List.vue')},
      {path: '/benefit-or-loss-details/:id', component: () => import('pages/product-management/benefit/BenefitOrLossDetails.vue')},
      {path: '/add-or-update-invoice/:id?', component: () => import('pages/product-management/sale/AddOrUpdate.vue')},
      {path: '/invoice-details/:id', component: () => import('pages/product-management/sale/InvoiceDetails.vue')},
      {path: '/customer-list', component: () => import('pages/product-management/customer/List.vue')},

      {path: '/employee-list', component: () => import('pages/employee-management/employees/List.vue')},
      {path: '/employee-attendances', component: () => import('pages/employee-management/attendance/List.vue')},
      {path: '/Dashboard2', component: () => import('pages/Dashboard2.vue')},
      {path: '/Profile', component: () => import('pages/UserProfile.vue')},
      {path: '/Map', component: () => import('pages/Map.vue')},
      {path: '/MapMarker', component: () => import('pages/MapMarker.vue')},
      {path: '/TreeTable', component: () => import('pages/TreeTable.vue')},
      {path: '/StreetView', component: () => import('pages/StreetView.vue')},
      {path: '/Cards', component: () => import('pages/Cards.vue')},
      {path: '/Tables', component: () => import('pages/Tables.vue')},
      {path: '/Contact', component: () => import('pages/Contact.vue')},
      {path: '/Checkout', component: () => import('pages/Checkout.vue')},
      {path: '/Ecommerce', component: () => import('pages/ProductCatalogues.vue')},
      {path: '/Pagination', component: () => import('pages/Pagination.vue')},
      {path: '/Charts', component: () => import('pages/Charts.vue')},
      {path: '/Calendar', component: () => import('components/CalendarComponent.vue')},
      {path: '/Directory', component: () => import('pages/Directory.vue')},
      {path: '/Footer', component: () => import('pages/Footer.vue')},
      {path: '/CardHeader', component: () => import('pages/CardHeader.vue')},

      // Not completed yet
      // {path: '/Taskboard', component: () => import('pages/TaskBoard.vue')},
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  },
  {
    path: '/Mail',
    component: () => import('layouts/Mail.vue'),
    meta: { requiresAuth : true },
  },
  {
    path: '/Maintenance',
    component: () => import('pages/Maintenance.vue'),
    meta: { requiresAuth : true },
  },
  {
    path: '/Pricing',
    component: () => import('pages/Pricing.vue'),
    meta: { requiresAuth : true },
  },
  {
    path: '/Login-1',
    component: () => import('pages/Login-1.vue'),
    meta: { requiresAuth : true },
  },
  {
    path: '/Lock',
    component: () => import('pages/LockScreen.vue'),
    meta: { requiresAuth : false },
  },
  {
    path: '/Lock-2',
    component: () => import('pages/LockScreen-2.vue'),
    meta: { requiresAuth : false },
  }
]

export default routes
