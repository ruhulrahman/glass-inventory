import { defineStore } from 'pinia';

export const useAuthStore = defineStore('authStore', {
  state: () => ({
    permission_disable: false,
    authUser: '',
    userPermissions: ''
  }),
  getters: {
    // doubleCount: (state) => state.counter * 2,
  },
  actions: {
    setAuthUser (state, payload) {
      state.authUser = Object.assign({}, payload)
    },
    setUserPermissions (state, payload) {
      state.userPermissions = Object.assign({}, payload)
    },
    updateUserPermissions (state, payload) {
      state.userPermissions = Object.assign({}, state.userPermissions, payload)
    }
  },
});
