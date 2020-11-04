
<template>
  <v-dialog v-model="dialog" max-width="600px">
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
        <v-icon color="green" small>mdi-plus</v-icon>
      </v-btn>
      Ajouter un ordinateur
    </template>
    <v-card>
      <v-card-title> Ajouter un ordinateur </v-card-title>

      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field v-model="name" color="success" label="Nom : " required />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn outlined color="red" text @click="dialog = false">Annuler</v-btn>
        <v-btn outlined color="success" @click="addOrdinateur" :disabled="!validate" class="mr-2">Ajouter</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios';
export default {
  props: {
  },
  components: {
  },
  data() {
    return {
      name: '',
      dialog: false
    }
  },
  created() {
  },
  methods: {
    addOrdinateur: function () {
      if (this.isValid()) {
        const data = {
          name: this.name,
        };
        axios.post('/api/computers/create', data)
            .then(({ data }) => {
              console.log(data)
              this.$emit('add', data)
              this.dialog = false
            })
            .catch(error => {
              //TODO catch error
              console.log(error);
            });
      }

    },
    isValid() {
      return this.name !== ''
    }
  },
  computed: {
    validate() {
      return this.isValid()
    }
  }
}
</script>
