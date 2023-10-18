<template>
  <q-dialog ref="dialog" @hide="onDialogHide" :position="position? position : 'right'">
    <q-card class="q-dialog-plugin bg-primary">

      <q-card-section class="q-pa-sm ">
        <q-list class="row">
          <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
            <q-item-section>
              <h5 class="text-center">Are you sure to delete?</h5>
              <p class='text-center'>You won't be able to revert this!</p>
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>

      <!-- buttons example -->
      <q-card-actions align="center">
        <q-btn color="negative" label="Cancel" @click="onCancelClick" />
        <q-btn color="positive" label="Yes" @click="onOKClick" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
export default {
  props: ['title', 'message', 'position'],

  emits: [
    // REQUIRED
    'ok', 'hide'
  ],

  methods: {
    // following method is REQUIRED
    // (don't change its name --> "show")
    show () {
      this.$refs.dialog.show()
    },

    // following method is REQUIRED
    // (don't change its name --> "hide")
    hide () {
      this.$refs.dialog.hide()
    },

    onDialogHide () {
      // required to be emitted
      // when QDialog emits "hide" event
      this.$emit('hide')
    },

    onOKClick () {
      // on OK, it is REQUIRED to
      // emit "ok" event (with optional payload)
      // before hiding the QDialog
      this.$emit('ok')
      // or with payload: this.$emit('ok', { ... })

      // then hiding dialog
      this.hide()
    },

    onCancelClick () {
      // we just need to hide the dialog
      this.hide()
    }
  }
}
</script>
