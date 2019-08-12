<template>
  <FullCalendar :plugins="calendarPlugins" weekly defaultView="dayGridMonth" :events="event"></FullCalendar>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'

export default {
  components: {
    FullCalendar,
    dayGridPlugin
  },
  data () {
    return {
      calendarPlugins: [dayGridPlugin],
      
    }
  },
  props: ["event"],
  methods: {
    clearCalendar () {
      this.event = null
    }

  }
}
</script>

<style lang="scss">
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
</style>