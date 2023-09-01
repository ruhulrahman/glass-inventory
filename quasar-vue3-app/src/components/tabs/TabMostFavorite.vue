<template>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <q-card class="fit no-shadow" bordered>
      <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary" align="justify">
        <q-tab name="contact" :class="tab == 'contact' ? 'text-blue' : ''" icon="inventory" label="Most Selling Product List" />
        <!-- <q-tab name="message" :class="tab=='message'?'text-blue':''" icon="comment" label="Message">
          <q-badge color="red" floating>{{ messages.length }}</q-badge>
        </q-tab> -->
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="contact" class="q-pa-sm">
          <q-list class="rounded-borders" separator>

            <q-item v-for="(item, index) in productStocks" :key="index" clickable v-ripple>
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
                  <span>{{ item.sale_count }} piece sold</span>
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
  props: ['productStocks'],
  setup() {
    return {
      tab: ref('contact'),
      contacts: [
        {
          name: 'Pratik Patel',
          position: 'Developer',
          avatar: 'https://avatars2.githubusercontent.com/u/34883558?s=400&v=4'
        },
        {
          name: 'Razvan Stoenescu',
          position: 'Developer',
          avatar: 'https://cdn.quasar.dev/team/razvan_stoenescu.jpeg'
        },
        {
          name: 'Jeff Galbraith',
          position: 'Developer',
          avatar: 'https://cdn.quasar.dev/team/jeff_galbraith.jpg'
        },
        {
          name: 'Brunhilde Panswick',
          position: 'Administrator',
          avatar: 'https://cdn.quasar.dev/img/avatar2.jpg'
        },
        {
          name: 'Winfield Stapforth',
          position: 'Administrator',
          avatar: 'https://cdn.quasar.dev/img/avatar6.jpg'
        },
      ],
      messages: [
        {
          id: 5,
          name: 'Pratik Patel',
          msg: ' -- I\'ll be in your neighborhood doing errands this\n' +
            '            weekend. Do you want to grab brunch?',
          avatar: 'https://avatars2.githubusercontent.com/u/34883558?s=400&v=4',
          time: '10:42 PM'
        }, {
          id: 6,
          name: 'Winfield Stapforth',
          msg: ' -- I\'ll be in your neighborhood doing errands this\n' +
            '            weekend. Do you want to grab brunch?',
          avatar: 'https://cdn.quasar.dev/img/avatar6.jpg',
          time: '11:17 AM'
        }, {
          id: 1,
          name: 'Boy',
          msg: ' -- I\'ll be in your neighborhood doing errands this\n' +
            '            weekend. Do you want to grab brunch?',
          avatar: 'https://cdn.quasar.dev/img/boy-avatar.png',
          time: '5:17 AM'
        }, {
          id: 2,
          name: 'Jeff Galbraith',
          msg: ' -- I\'ll be in your neighborhood doing errands this\n' +
            '            weekend. Do you want to grab brunch?',
          avatar: 'https://cdn.quasar.dev/team/jeff_galbraith.jpg',
          time: '5:17 AM'
        }, {
          id: 3,
          name: 'Razvan Stoenescu',
          msg: ' -- I\'ll be in your neighborhood doing errands this\n' +
            '            weekend. Do you want to grab brunch?',
          avatar: 'https://cdn.quasar.dev/team/razvan_stoenescu.jpeg',
          time: '5:17 AM'
        }
      ],
    }
  }
})
</script>
