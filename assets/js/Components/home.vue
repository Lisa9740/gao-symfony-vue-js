<template>
  <div>
    <v-app>
      <v-main>
        <v-container>Hello world
        <Computer />
        </v-container>
      </v-main>
    </v-app>
  </div>
</template>
<script>
import axios from 'axios';
import Computer from '../Components/computer.vue'
export default {
  name : 'example',
  components: {
    Computer
  },
  data() {
    return {
      ordinateurs: [],
      // date: new Date().toISOString().substr(0, 10),
      // menuDate: false,
    }
  },

  computed: {
  },
  created() {
    this.initialize();

  },

  methods: {
    initialize: function () {
      this.ordinateurs = [];
      axios.get('/api/computers')
          .then(({ data }) => {
            this.ordinateurs = data;
            console.log(data);
          }).catch(error => {
        console.log(error);
      });
    },

  },
}

</script>
<style scoped>
</style>
