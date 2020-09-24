<template>
  <div>
    <div class="row" v-for="stop in stops" :key="stop.id" style="margin-top: 10px">
      <div class="col-md-6">
        <label>City</label>
        <button class="btn btn-sm btn-danger align-self-bottom" @click.prevent="removeStop(stop.id)">
          <i class="fa fa-trash"></i>
        </button>
        <select class="form-control" v-model="stop.city_id">
          <option value="" selected disabled>Select the city</option>
          <option v-for="city in availableCities" :key="`${stop.id}-${city.id}`" :value="city.id">
            {{ city.name }}
          </option>
        </select>
      </div>
    </div>
    <br>
    <div class="row justify-content-center">
      <div class="col-md-3">
        <button class="btn btn-primary" @click.prevent="addStop">Add Stop</button>
      </div>
    </div>
    <input type="hidden" name="stops[]" v-for="input in stopsInput" :key="`input-${input}`" :value="input">
  </div>
</template>

<script>
export default {
  name: 'stops-input',
  props: {
    cities: {
      type: Array,
      required: true,
    },
  },
  data: () => ({
    availableCities: [],
    stops: [],
  }),
  computed: {
    stopsInput() {
      return this.stops.reduce((input, stop, index) => {
        input.push(stop.city_id);
        return input;
      }, []);
    },
  },
  methods: {
    removeStop(id) {
      this.stops = this.stops.filter((stop) => stop.id !== id);
    },
    addStop() {
      this.stops.push({
        id: Math.random().toString(36).substring(7),
        city_id: '',
      });
    },
  },
  created() {
    this.availableCities = this.cities;
  },
};
</script>
