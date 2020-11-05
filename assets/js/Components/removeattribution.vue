
<template>
  <v-dialog v-model="dialog" max-width="600px">
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
        <v-icon color="red" small>mdi-minus</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        {{ ordinateur.name }} : Suppression d'une attribution pour
        {{ horaire }}h
      </v-card-title>

      <v-card-text>
        <v-container>

                <span>
                    Souhaitez vous supprimer l'attribution de l'ordinateur
                    {{ ordinateur.name }} à {{ attribution.name }}
                    {{ attribution.firstname }} à {{ horaire }}h ?
                </span>
        </v-container>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn outlined text @click="dialog = false">Non</v-btn>
        <v-btn outlined color="red" @click="supprimer" class="mr-2">Supprimer</v-btn>
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
    attribution: {
      required: true
    },
  },
  data() {
    return {
      dialog: false,
    }
  },
  methods: {
    supprimer: function () {
      const data = {
        id: this.attribution.id,
      };
      axios.post('/api/attributions/remove', data)
          .then(({ data }) => {
            this.$emit('removeAttribution', this.horaire)
            this.dialog = false
          })
          .catch(error => {
            //TODO catch error
            console.log(error);
          });

    },
  }
}
</script>
