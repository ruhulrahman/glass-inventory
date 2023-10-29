<template>
  <q-card
    class="bg-primary text-white no-shadow wait_me1"
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
                :label="$t('choose_photo')"
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
        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="employee.name"
              :label="$t('employee_name')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="email"
              dark
              color="white"
              v-model="employee.email"
              :label="$t('email')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="number"
              dark
              color="white"
              v-model="employee.phone1"
              :label="$t('phone')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="number"
              dark
              color="white"
              v-model="employee.phone2"
              :label="$t('phone2')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="employee.nid"
              :label="$t('nid')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <label style="margin-bottom: -18px">{{ $t('date_of_birth') }}</label>
            <q-input type="date" dark color="white" v-model="employee.dob" />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="employee.religion"
              :label="$t('religion')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <div class="q-pa-md q-gutter-sm">
              <div class="q-gutter-sm">
                <q-radio
                  dark
                  color="white"
                  v-model="employee.gender"
                  val="Male"
                  :label="$t('male')"
                />
                <q-radio
                  dark
                  color="white"
                  v-model="employee.gender"
                  val="Female"
                  :label="$t('female')"
                />
              </div>
            </div>
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="employee.present_address"
              :label="$t('present_address')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <q-input
              type="text"
              dark
              color="white"
              v-model="employee.permanent_address"
              :label="$t('permanent_address')"
            />
          </q-item-section>
        </q-item>

        <q-item
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: -18px"
        >
          <q-item-section>
            <label style="margin-bottom: -18px; margin-top: 15px">{{ $t('joining_date') }}</label
            >
            <q-input
              type="date"
              dark
              color="white"
              v-model="employee.joining_date"
            />
          </q-item-section>
        </q-item>

        <q-item
          v-if="employee.id == null"
          class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
          style="margin-top: 0px"
        >
          <q-item-section>
            <q-input
              type="number"
              dark
              color="white"
              v-model="employee.current_salary"
              :label="$t('salary')"
            />
          </q-item-section>
        </q-item>

        <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <q-item-section
            style="margin-top: -20px !important; font-size: 12px !important"
          >
            <q-select
              dark
              color="white"
              v-model="employee.designation_id"
              :label="$t('designation')"
              :options="designations"
              emit-value
              map-options
            >
            </q-select>
          </q-item-section>
        </q-item>

        <q-item class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <q-item-section>
            <q-toggle
              color="green"
              size="md"
              v-model="employee.active"
              val="md"
              :label="$t('is_active')"
            />
          </q-item-section>
        </q-item>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn glossy type="submit" class="text-capitalize bg-white q-mr-md q-mb-md text-primary">{{ $t('save') }}</q-btn>
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
      employee: {
        id: null,
        name: "",
        email: "",
        phone1: null,
        phone2: null,
        dob: null,
        gender: null,
        religion: "",
        nid: null,
        present_address: "",
        permanent_address: "",
        designation_id: null,
        joining_date: null,
        current_salary: null,
        active: true,
        photo: null,
      },
      designations: [],
      file: null,
      view_file: null,
    };
  },
  created() {
    var ref = this;
    if (ref.editItem) {
      ref.employee = ref.editItem;
      ref.employee.active = ref.editItem.active == 1 ? true : false;
    }
  },
  mounted() {
    this.get_designations();
  },
  methods: {
    saveData: async function () {
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me");

      const formData = new FormData();
      formData.append("id", ref.employee.id);
      formData.append("name", ref.employee.name);
      formData.append("phone1", ref.employee.phone1);
      formData.append("phone2", ref.employee.phone2);
      formData.append("email", ref.employee.email);
      formData.append("photo", ref.file);
      formData.append("dob", ref.employee.dob);
      formData.append("gender", ref.employee.gender);
      formData.append("religion", ref.employee.religion);
      formData.append("nid", ref.employee.nid);
      formData.append("present_address", ref.employee.present_address);
      formData.append("permanent_address", ref.employee.permanent_address);
      formData.append("designation_id", ref.employee.designation_id);
      formData.append("joining_date", ref.employee.joining_date);
      formData.append("current_salary", ref.employee.current_salary);
      formData.append("active", ref.employee.active);

      try {
        let url = "";
        if (ref.employee.id) {
          url = ref.apiUrl("api/v1/admin/ajax/update_employee_data");
        } else {
          url = ref.apiUrl("api/v1/admin/ajax/store_employee_data");
        }

        jq.ajax({
          type: "POST",
          url: url,
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (res) {
            ref.notify(res.msg);
            ref.$emit("closeModal", true);
            ref.$emit("reloadListData", true);
          },
          error: function (err) {
            ref.notify(ref.err_msg(err), "negative");
          },
        });
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        ref.wait_me(".wait_me", "hide");
      }
    },
    get_designations: async function () {
      let ref = this;
      let jq = ref.jq();
      ref.wait_me(".wait_me1");

      try {
        let res = "";
        res = await jq.get(
          ref.apiUrl("api/v1/admin/ajax/get_designation_list")
        );
        ref.designations = res.data.data;
        // console.log(ref.designations);
      } catch (err) {
        this.notify(this.err_msg(err), "negative");
      } finally {
        ref.wait_me(".wait_me1", "hide");
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
.q-dialog__inner--minimized > div {
  max-width: 800px !important;
}
</style>
