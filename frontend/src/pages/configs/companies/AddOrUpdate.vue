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
      <q-card-section class="q-pa-sm row">
        <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              round
              v-model="company.name"
              label="Company Name *"
              :rules="[
                (val) => (val && val.length > 0) || 'Please enter company name',
              ]"
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
              v-model="company.title"
              label="Title"
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
              v-model="company.phone"
              label="Phone 1"
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
              v-model="company.phone2"
              label="Phone 2"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="email"
              dark
              color="white"
              round
              v-model="company.email"
              label="Email"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="number"
              dark
              color="white"
              v-model="company.number_of_employees"
              label="Total Employees"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-file
            class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
            v-model="files"
            label="Choose Company Logo"
            dark
            color="white"
            clearable
            accept=".jpg,.png,.gif"
            max-files="10"
            max-file-size="5120000"
          >
            <q-icon dark color="white" name="attach_file" />
          </q-file>
        </q-item>

        <q-item class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="company.address"
              label="Address"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
          <q-item-section>
            <q-input
              type="textarea"
              dark
              color="white"
              v-model="company.description"
              label="Description"
            />
          </q-item-section>
        </q-item>

        <!-- <q-item
        class="col-lg-8 col-md-12 col-sm-12 col-xs-12"
        style="float: right"
      >
        <q-item-section>
          <q-btn
            type="button"
            color="white"
            style="width: 20%; margin-left: 80%"
            >Submit</q-btn
          >
        </q-item-section>
      </q-item> -->
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
      company: {
        id:null,
        name: '',
        phone: '',
        phone2: '',
        email: '',
        title: '',
        logo: '',
        address: '',
        description: '',
        number_of_employees: 0
      },
      files: [],
    };
  },
  created() {
  var ref = this;
  if (ref.editItem) {
        ref.company.department = ref.editItem;
        ref.company.id =ref.editItem.id,
        ref.company.name = ref.editItem.name
        ref.company.phone = ref.editItem.phone
        ref.company.phone2 = ref.editItem.phone2
        ref.company.email = ref.editItem.email
        ref.company.title = ref.editItem.title
        ref.company.address = ref.editItem.address
        ref.company.description = ref.editItem.description
        ref.company.number_of_employees = ref.editItem.number_of_employees
    }
  },
  mounted() {},
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();
    //   console.log(ref.files);
      const formData = new FormData()
      formData.append('id',ref.company.id);
      formData.append('name',ref.company.name);
      formData.append('title',ref.company.title);
      formData.append('number_of_employees',ref.company.number_of_employees);
      formData.append('logo',ref.files);
      formData.append('address',ref.company.address);
      formData.append('description',ref.company.description);
        ref.wait_me(".wait_me");

      try {
        let url = '';
        if (ref.company.id) {
          url = ref.apiUrl('api/v1/admin/ajax/update_company_data');
        } else {
          url = ref.apiUrl('api/v1/admin/ajax/store_company_data');
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
    onSubmit(evt) {
      this.loading = true; // add loading state to submit button
      const formData = new FormData();

      if (this.files && this.files.length > 0) {
        for (let i = 0; i < this.files.length; i++) {
          formData.append("files[" + i + "]", this.files[i]);
        }
      }
      for (const [key, value] of Object.entries(this.form)) {
        formData.append(key, value);
      }

      // this.$axios.get('/sanctum/csrf-cookie').then(response => {
      //   this.$axios({
      //     method: 'post',
      //     url: '/api/request',
      //     data: formData,
      //     headers: {
      //       'Content-Type': 'multipart/form-data'
      //     }
      //   })
      //     .then((response) => {
      //       this.loading = false

      //       this.$q.notify({
      //         color: 'positive',
      //         position: 'top',
      //         message: 'Request sent! We\'ll contact you soon.',
      //         icon: 'done'
      //       })
      //     })
      //     .catch(() => {
      //       this.loading = false

      //       this.$q.notify({
      //         color: 'negative',
      //         position: 'top',
      //         message: 'An error occurred',
      //         icon: 'report_problem'
      //       })
      //     })
      // })
    },

    // onRejected(entries) {
    //   if (entries.length > 0) {
    //     switch (entries[0].failedPropValidation) {
    //       case "max-file-size":
    //         this.$q.notify({
    //           position: "top",
    //           type: "negative",
    //           message: "File exceeds 5MB.",
    //         });

    //         break;

    //       case "max-files":
    //         this.$q.notify({
    //           position: "top",
    //           type: "negative",
    //           message: "You can upload up to 10 files.",
    //         });

    //         break;
    //     }
    //   }
    // },
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
