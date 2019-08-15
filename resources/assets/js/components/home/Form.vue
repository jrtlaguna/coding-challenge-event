<template>
<div>
  <b-form @submit.prevent="validateEvent">
    <b-form-group
      id="input-group-1"
      label="Event Name:"
      label-for="event-name">
    <b-form-input
      id="event-name"
      name="event-name"
      required
      v-bind:disabled="loading"
      v-model="eventName"
      placeholder="eg. Fyre Festival">
      </b-form-input>
      </b-form-group>
    <b-row>
    <b-col cols="6">
      <label>Date Start:</label>
      <Datepicker v-bind:disabled="loading" v-model="dateFrom" full-month-name clearButton placeholder="Select Date"></Datepicker>
    </b-col>
    <b-col cols="6">
      <label>Date End:</label>
      <Datepicker v-bind:disabled="loading" required v-model="dateTo" full-month-name clearButton placeholder="Select Date"></Datepicker>
    </b-col>
    </b-row>
    
    
    <b-form-group>
      <label for="weeks">Pick days of the week:</label>
      <b-col offset="1">
      <b-form-checkbox-group
        id="weeks-checkbox"
        v-model="weeks"
        :options="options"
        name="weeks"
      ></b-form-checkbox-group>
    </b-col>
    </b-form-group>
    <b-row>
    <b-col cols="9">
    <b-button block type="submit" variant="primary">Submit</b-button>
    </b-col>
    <b-col><b-spinner v-show=loading variant="info" label="Spinning"></b-spinner></b-col>
    </b-row>
  </b-form>
  <br>
  <b-alert class="pt-15"
  :show="dismissCountDown"
      dismissible
      fade
      variant="warning"
      @dismiss-count-down="countDownChanged">Please input correct date fields.</b-alert>
      <b-alert class="pt-15"
      :show="dismissSuccess"
      dismissible
      fade
      variant="info"
      @dismiss-count-down="successChanged">Event successfully added.</b-alert>
</div>
</template>

<script>
import {validationMixin} from 'vuelidate'
import {required} from 'vuelidate/lib/validators'
import Datepicker from 'vuejs-datepicker';
import moment from 'moment'
import axios from 'axios'
export default {
  components: {Datepicker},
  name: 'EventForm',
  mixins: [validationMixin],
  validations: {
    eventName: {required},
    dateFrom: {required},
    dateTo: {required},
  },
  data () {
    return {
      eventName: null,
      dateTo: null,
      dateFrom: null,
      weeks: [],
      options: [
        {text: 'Sun', value: '0'},
        {text: 'Mon', value: '1'},
        {text: 'Tue', value: '2'},
        {text: 'Wed', value: '3'},
        {text: 'Thu', value: '4'},
        {text: 'Fri', value: '5'},
        {text: 'Sat', value: '6'},
      ],
      dismissSecs: 5,
      dismissCountDown: 0,
      successSecs: 5,
      dismissSuccess: 0,
      loading: false
    }
  },
  sending: false,
  methods: {
    validateEvent() {
      this.$v.$touch()
      if(!this.$v.dateTo.required && !this.$v.dateFrom.required || this.dateFrom>this.dateTo){
        this.showAlert()
      }
      else {
        this.submitEvent()
      }

    },
    async submitEvent() {
      this.loading = true
      const arr = this.weeks.map(Number)
      if(arr.length === 0){
        arr.push(0, 1, 2, 3, 4, 5, 6)
      }

      

      this.dateFrom = this.formatDate(this.dateFrom)
      this.dateTo = this.formatDate(this.dateTo)
      const newEvent = {
        title: this.eventName,
        daysOfWeek: arr,
        startRecur: this.dateFrom,
        endRecur: this.dateTo
      }

      const event = {
        eventName: this.eventName,
        dateTo: this.dateTo,
        dateFrom: this.dateFrom,
        weeks: this.weeks.toString()
      }
      const res = await axios.post('api/event', event, {
          'headers': {
            'content-type': 'applcation/json'
          }
        })
      
      this.loading = false

      if([201, 202].includes(res.status))
      {
        this.showSuccess()
      }
      
      this.$emit('add-event', newEvent)


    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs
    },
    successChanged(dismissSuccess) {
      this.dismissSuccess = dismissSuccess
    },
    showSuccess() {
      this.dismissSuccess = this.successSecs
    },
    formatDate(date){
      return moment(date).format('YYYY-MM-DD')
    }
    
  }
}
</script>

<style>

</style>