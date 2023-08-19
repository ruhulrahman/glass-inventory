<template>
  <q-card
    class="bg-primary text-white no-shadow wait_me"
    style="margin-top: 25px"
    bordered
  >
    <q-form @submit="saveData">
      <q-card-section class="row q-pa-sm">
        <q-item class="full-width">
          <q-item-section>
            <q-item-label
              class="text-h6 text-weight-bolder text-white-8"
              lines="1"
              >{{ title }}</q-item-label
            >
          </q-item-section>
          <q-item-section side>
            <q-icon
              name="cancel"
              clickable
              color="white"
              style="cursor: pointer"
              @click="
                () => {
                  $emit('closeModal', true);
                }
              "
            ></q-icon>
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-separator></q-separator>
      <q-card-section>
        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section side>
            <q-avatar size="100px">
              <img v-if="view_file != null || editItem.photo != null" :src="view_file != null ? view_file : apiUrl('uploads/photo/'+editItem.photo)" />
              <img v-else :src="apiUrl('uploads/demo.jpg')" />
            </q-avatar>
          </q-item-section>
          <q-item-section>
            <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <q-file
                class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                v-model="file"
                label="Choose Photo"
                dark
                color="white"
                clearable
                accept=".jpg,.png,.gif"
                max-files="10"
                max-file-size="5120000"
                @update:model-value="selectImg()"
              >
                <q-icon dark color="white" name="attach_file" />
              </q-file>
            </q-item>
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-card-section class="q-pa-sm row">
        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              round
              v-model="user.name"
              label="Full Name *"
              :rules="[(val) => (val && val != '') || 'Please enter your name']"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              round
              v-model="user.username"
              label="Username *"
              :rules="[(val) => (val && val != '') || 'Please enter your username']"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="email"
              dark
              color="white"
              v-model="user.email"
              label="Email *"
              :rules="[(val) => (val && val != '') || 'Please enter your email']"
            />
          </q-item-section>
        </q-item>

        <!-- <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-file
            class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
            v-model="files"
            label="Choose Photo"
            dark
            color="white"
            clearable
            accept=".jpg,.png,.gif"
            max-files="10"
            max-file-size="5120000"
          >
            <q-icon dark color="white" name="attach_file" />
          </q-file>
        </q-item> -->

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section
            style="margin-top: -20px !important; font-size: 12px !important"
          >
            <q-select
              dark
              color="white"
              v-model="user.user_type"
              label="User Type"
              :options="userTypes"
              emit-value
              map-options
            >
            </q-select>
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <q-item-section>
              <q-toggle color="green" size="md" v-model="user.is_employee" val="md" label="Is Employee" />
            </q-item-section>
          </q-item>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn
          glossy
          type="submit"
          class="text-capitalize bg-white q-mr-md q-mb-md text-primary"
          >
          {{editItem.id ? 'Update' : 'Save'}}
          </q-btn
        >
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script>
import helperMixin from "src/mixins/helper_mixin.js";

export default {
  props: ["title", "editItem", "company"],
  mixins: [helperMixin],
  data() {
    return {
      user: {
        id:null,
        name: '',
        username: '',
        photo: '',
        email: '',
        user_type: '',
        is_employee: false
      },
      userTypes:[
        'Admin',
        'System Admin',
        'Super Admin',
        'User'
      ],
      file: null,
      view_file: null,
    };
  },
  created() {
  var ref = this;
  if (ref.editItem) {
        ref.user = ref.editItem;
        ref.user.is_employee = ref.editItem.is_employee == 1 ? true : false;
    }
  },
  mounted() {},
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();
    //   console.log(ref.files);
      const formData = new FormData()
      formData.append('id',ref.user.id);
      formData.append('name',ref.user.name);
      formData.append('username',ref.user.username);
      formData.append('email',ref.user.email);
      formData.append('photo',ref.file);
      formData.append('user_type',ref.user.user_type);
      formData.append('is_employee',ref.user.is_employee);
        ref.wait_me(".wait_me");

      try {
        let url = '';
        if (ref.user.id) {
          url = ref.apiUrl('api/v1/admin/ajax/update_user_data');
        } else {
          url = ref.apiUrl('api/v1/admin/ajax/store_user_data');
        }

      jq.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res) {
           ref.notify(res.msg)
           ref.$emit('closeModal', true)
           ref.$emit('reloadListData', true)
        },
        error: function(err) {
           ref.notify(ref.err_msg(err), 'negative')
        },
      });
     } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    },
    selectImg() {
      if (this.file) {
        // console.log(this.file);
        this.view_file = URL.createObjectURL(this.file);
      }
    },
  },
};
</script>

<style scoped>
.card-bg {
  background-color: #162b4d;
}

.q-field--dark:not(.q-field--highlighted) .q-field__label {
  margin-top: 12px !important;
  color: rgba(255, 255, 255, 0.7);
}
/* .q-anchor--skip .q-field__native .q-placeholder {
    margin-top: 20px !important;
} */
.q-btn__content {
  width: 60px !important;
}
</style>
