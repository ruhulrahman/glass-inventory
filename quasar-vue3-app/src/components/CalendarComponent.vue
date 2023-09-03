<template>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <q-card class="fit no-shadow" bordered>
      <q-card-section class="q-mb-none q-pb-none">
        <span class="font-size-22 font-weight-800 text-accent">{{ getCurrentMonth }}</span>
      </q-card-section>

      <div class="row q-mb-sm">
        <div class="col text-center">
          <q-btn @click="onToday" class="glossy q-mr-sm" color="green" size="sm">Today</q-btn>
          <q-btn @click="onPrev" class="glossy q-mr-sm" color="purple" size="sm">Previous</q-btn>
          <q-btn @click="onNext" class="glossy" color="purple" size="sm">Next</q-btn>
        </div>
      </div>

      <q-calendar-month ref="calendar" v-model="selectedDate" animated bordered focusable hoverable no-active-date
        :day-min-height="140" :day-height="10" @change="onChange" @moved="onMoved" @click-date="onClickDate"
        @click-day="onClickDay" @click-workweek="onClickWorkweek" @click-head-workweek="onClickHeadWorkweek"
        @click-head-day="onClickHeadDay">
        <template #day="{ scope: { timestamp } }">
          <template v-for="event in eventsMap[timestamp.date]" :key="event.id">
            <div :class="badgeClasses(event, 'day')" :style="badgeStyles(event, 'day')" class="my-event">
              <abbr class="tooltip">
                <span class="title q-calendar__ellipsis">
                  {{ event.title + (event.time ? " - " + event.time : "") }}
                </span>
              </abbr>
            </div>
          </template>
        </template>
      </q-calendar-month>
    </q-card>
  </div>
</template>

<script>
import {
  QCalendarMonth,
  addToDate,
  parseDate,
  parseTimestamp,
  today,
} from "@quasar/quasar-ui-qcalendar";
import "@quasar/quasar-ui-qcalendar/src/QCalendarVariables.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarTransitions.sass";
import "@quasar/quasar-ui-qcalendar/src/QCalendarMonth.sass";
import helperMixin from "../mixins/helper_mixin.js";
import { defineComponent } from "vue";
// The function below is used to set up our demo data
const CURRENT_DAY = new Date();

function getCurrentDay(day) {
  const newDay = new Date(CURRENT_DAY);
  newDay.setDate(day);
  const tm = parseDate(newDay);
  console.log(tm);
  return tm.date;
}

export default defineComponent({
  name: "Calendar",
  mixins: [helperMixin],
  components: {
    QCalendarMonth,
  },
  data() {
    return {
      selectedDate: today(),
      events: [],
      holidays: [],
      currentDate: new Date()
    };
  },
  computed: {
    eventsMap() {
      const map = {};
      if (this.events.length > 0) {
        this.events.forEach((event) => {
          (map[event.date] = map[event.date] || []).push(event);
          if (event.days !== undefined) {
            let timestamp = parseTimestamp(event.date);
            let days = event.days;
            // add a new event for each day
            // skip 1st one which would have been done above
            do {
              timestamp = addToDate(timestamp, { day: 1 });
              if (!map[timestamp.date]) {
                map[timestamp.date] = [];
              }
              map[timestamp.date].push(event);
              // already accounted for 1st day
            } while (--days > 1);
          }
        });
      }
      console.log(map);
      return map;
    },
    getCurrentMonth: function () {
      const date = this.currentDate
      const month = date.toLocaleString('default', { month: 'long' })
      const year = date.getFullYear()
      return `${month} ${year}`
    }
  },
  mounted: async function () {
    await this.get_holidays()
    this.getHolidayList()
  },
  methods: {
    badgeClasses(event, type) {
      return {
        [`text-white bg-${event.bgcolor}`]: true,
        "rounded-border": true,
      };
    },
    badgeStyles(day, event) {
      const s = {};
      // s.left = day.weekday === 0 ? 0 : (day.weekday * this.parsedCellWidth) + '%'
      // s.top = 0
      // s.bottom = 0
      // s.width = (event.days * this.parsedCellWidth) + '%'
      return s;
    },
    onToday() {
      this.$refs.calendar.moveToToday();
    },
    onPrev() {
      this.$refs.calendar.prev();
    },
    onNext() {
      this.$refs.calendar.next();
    },
    onMoved(data) {
      console.log("onMoved", data);
      this.currentDate = new Date(data.date)
    },
    onChange(data) {
      console.log("onChange", data);
    },
    onClickDate(data) {
      console.log("onClickDate", data);
    },
    onClickDay(data) {
      console.log("onClickDay", data);
    },
    onClickWorkweek(data) {
      console.log("onClickWorkweek", data);
    },
    onClickHeadDay(data) {
      console.log("onClickHeadDay", data);
    },
    onClickHeadWorkweek(data) {
      console.log("onClickHeadWorkweek", data);
    },
    getHolidayList() {
      // const sundays = [];
      var ref = this
      var sunday = new Date();
      sunday.setDate(sunday.getDate() + 5 - sunday.getDay());

      for (var i = 0; i < 12; i++) {
        this.events.push({
          id: i + 1,
          title: "Weekend",
          details: "Today is off day",
          date: parseDate(sunday).date,
          bgcolor: "red",
        })
        sunday.setDate(sunday.getDate() + 7);

      }

      if (ref.holidays.length > 0) {
        ref.holidays.map(item => {
          this.events.push({
            id: this.events.length + 1,
            title: item.title,
            details: item.title,
            date: item.holiday,
            bgcolor: "green",
          })

        })

      }
    },
    get_holidays: async function () {

      let ref = this;
      let jq = ref.jq();

      try {

        this.loading = true
        let res = await jq.get(ref.apiUrl('api/v1/admin/ajax/get_holiday_list'));
        this.listData = res.data.data
        ref.holidays = [];
        if (res.data.data.length > 0) {
          res.data.data.map(item => {
            if (item.total > 1) {
              var splits = item.from.split("-");
              for (let index = 0; index < item.total; index++) {
                var next_date = parseInt(splits[2]) + parseInt(index);
                // item.holiday = splits[0]+'-'+splits[1]+'-'+next_date;
                // console.log(item);
                ref.holidays.push({
                  holiday: splits[0] + '-' + splits[1] + '-' + next_date,
                  title: item.name
                });
              }
            } else {
              // item.holiday = item.from;
              ref.holidays.push({
                holiday: item.from,
                title: item.name
              });
            }
          });
          console.log('dddd', ref.holidays);
        }

      } catch (err) {
        this.notify(this.err_msg(err), 'negative')
      } finally {
        this.loading = false
      }

    }
  },
});
</script>

<style>
.my-event {
  position: relative;
  font-size: 12px;
  width: 100%;
  margin: 1px 0 0 0;
  justify-content: center;
  text-overflow: ellipsis;
  overflow: hidden;
  cursor: pointer;
}

.title {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.text-white {
  color: white;
}

.bg-blue {
  background: blue;
}

.bg-green {
  background: green;
}

.bg-orange {
  background: orange;
}

.bg-red {
  background: red;
}

.bg-teal {
  background: teal;
}

.bg-grey {
  background: grey;
}

.bg-purple {
  background: purple;
}

.rounded-border {
  border-radius: 2px;
}

abbr.tooltip {
  text-decoration: none;
}
</style>
