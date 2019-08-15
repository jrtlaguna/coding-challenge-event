<template>
<div>
  <Navbar></Navbar>
<b-container fluid>
  <b-row class="mt-5">
    <!-- formfield -->
    <b-col cols="4" sm="10" lg="4" offset="1">
      <Form v-on:add-event="renderEvent"></Form>
    </b-col>

<!-- calendar -->
    <b-col cols="6" xs="10" sm="10" lg="6" md="auto">
      <Calendar v-bind:event="event"></Calendar>
    </b-col>
  </b-row>
</b-container>
</div>
</template>

<script>
import Form from './Form'
import Calendar from './Calendar'
import Navbar from './Navbar'
export default {
  components: {
    Form,
    Calendar,
    Navbar
  },
  data() {
    return {
      event: []
    }
  },
  methods: {
    renderEvent(event) {
      this.event = []
      this.event.push(event)
    }
  }
}
</script>

<style scoped>
  b-container {
    margin: 5px;
  }
</style>