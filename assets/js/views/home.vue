<template>
  <div>
    <v-app>
<!--      <v-main>-->
<!--        <v-container>Hello world-->
<!--        <Computer />-->
<!--        </v-container>-->
<!--      </v-main>-->
      <v-container>
        <v-row>
          <v-col cols="12" sm="8" md="4">
            <v-menu v-model="menuDate" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
              <template v-slot:activator="{ on, attrs }">
                <v-text-field v-model="date" label="Saisir une date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
              </template>
              <v-date-picker v-model="date" @change="initialize" @input="menuDate = false" locale="fr-fr"></v-date-picker>
            </v-menu>
          </v-col>
        </v-row>
        <addOrdinateur @add="addOrdinateur"/>
        <v-row>
          <v-col cols="12" sm="6" md="4" v-for="(ordinateur, key) in ordinateurs" :key="key">
            <Computer :ordinateur="ordinateur" :date="date"></Computer>
          </v-col>
        </v-row>
      </v-container>
    </v-app>
  </div>
</template>
<script>
import axios from 'axios';
import Computer from '../Components/computer.vue'
import AddOrdinateur from '../Components/addcomputer.vue'

export default {
  name : 'example',
  components: {
    Computer, AddOrdinateur
  },
  data() {
    return {
      ordinateurs: [],
      date: new Date().toISOString().substr(0, 10),
      menuDate: false,
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
      axios.get('/api/computers',  { params: { date : this.date } } )
          .then(({data}) => {
            console.log("date" , this.date )
            this.ordinateurs = data;
             console.log("recupération des ordis" , data)
          }).catch(error => {
        console.log(error);
      });
    },
    addOrdinateur: function (ordinateur) {
      this.ordinateurs.push(ordinateur);
    },
  }
}

</script>
<style scoped>
</style>
