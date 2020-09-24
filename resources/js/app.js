import Vue from 'vue';
import StopsInput from './components/StopsInput.vue';

require('./bootstrap');


const app = new Vue({
  el: '#app',
  components: {
    StopsInput,
  },
});
