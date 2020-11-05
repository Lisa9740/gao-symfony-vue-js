<template>
  <v-dialog v-model="dialog" max-width="600px">
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on" @click="init">
        <v-icon color="green" small>mdi-plus</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        {{ ordinateur.name }} : Attribuer client à {{ horaire }}h
        <v-spacer></v-spacer>
        <v-btn icon @click="ajouter = true" color="success">
          <v-icon>mdi-account-plus</v-icon>
        </v-btn>
      </v-card-title>

      <v-card-text>
        <v-container>
          <v-row v-if="!ajouter">
            <v-col cols="12" md="6" sm="8">
              <v-autocomplete :loading="loading" :items="clients" :search-input.sync="search" v-model="client" item-text="name" return-object cache-items hide-no-data hide-details label="Sélection le client">
              </v-autocomplete>
            </v-col>
          </v-row>

          <v-row v-if="ajouter">
            <v-col cols="12" md="6">
              <v-text-field v-model="lastname" color="success" label="Nom : " required />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field v-model="firstname" color="success" label="Prénom : " required />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn outlined color="red" text @click="dialog = false">Annuler</v-btn>
        <v-btn outlined color="success" @click="attribuer" :disabled="!validate" class="mr-2">Ajouter</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import axios from 'axios';
import _ from 'lodash';

export default {
  props: {
    ordinateur: {
      required: true
    },
    horaire: {
      required: true
    },
    date: {
      required: true
    },
  },
  components: {
  },
  data() {
    return {
      name: '',
      firstname: '',
      lastname : '',
      ajouter: false,
      client: {},
      dialog: false,
      //
      loading: false,
      search: null,
      clients: [],
    }
  },

  created() {
  },

  watch: {
    search: function (val) {
      if (val && val.length > 1) {
        this.loading = true
        axios.get('/api/customers/search', { params: { query: val } })
            .then(({ data }) => {
              this.loading = false;
              data.forEach(client => {
                this.clients.push(this.formattedClient(client))
              });

            });
      }
    },
  },
  methods: {
    init: function () {
      this.name = ''
      this.lastname = ''
      this.firstname = ''
      this.ajouter = false
      this.client = {}
    },

    attribuer: function () {
      if (this.isValid()) {
        axios.post('/api/attributions', this.theCustomer())
            .then(({ data }) => {
              this.$emit('addAttribution', data[0])
              this.dialog = false
            })
            .catch(error => {
              //TODO catch error
              console.log(error);
            });
      }

    },
    theCustomer: function () {
      return {
        id_ordinateur: this.ordinateur.id,
        date: this.date,
        horaire: this.horaire,
        id_client: typeof (this.client.id) ? this.client.id : '',
        name: this.name,
        firstname: this.firstname,
        lastname: this.lastname
      };
    },
    formattedClient: function (client) {
      return {
        id: client.id,
        name: client.name,
      }
    },
    isValid() {
      return ((!_.isEmpty(this.client)) || (!_.isEmpty(this.firstname)) || (!_.isEmpty(this.lastname)))
    }
  },
  computed: {
    validate() {
      return this.isValid()
    }
  }
}
</script>
