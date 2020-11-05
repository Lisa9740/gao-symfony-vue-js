<template>
  <v-card>

    <v-card-title>
      {{ ordinateur.name }}
    </v-card-title>
    <v-card-text>
      <v-row v-for="(horaire, key) in horaires" :key="key">
        <v-col cols="2"> {{ horaire.index }}h</v-col>
        <v-col cols="8">
                <span v-if="horaire.attribution">
                    {{ horaire.attribution.name  }}
                </span>
        </v-col>
        <v-col cols="2">
       <RemoveAttribution v-if="horaire.attribution" :ordinateur="ordinateur" :attribution="horaire.attribution" :horaire="horaire.index" @removeAttribution="removeAttribution" />

          <AddAttribution v-if="!horaire.attribution" :ordinateur="ordinateur" :horaire="horaire.index" :date="date" @addAttribution="addAttribution" />
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>
<script>
import AddAttribution from './addattribution.vue'
import RemoveAttribution from './removeattribution'

export default {
  props: {
    ordinateur: {
      required: true
    },
    date: {
      required: true
    },
  },
  watch: {
    ordinateur: function () {
      this.initialise();
    }
  },
  components: {
    AddAttribution,
    RemoveAttribution
  },
  data() {
    return {

      horaires: [],
      attributions: {}
    }
  },
  created() {
    this.initialise();
  },
  computed: {
  },
  methods : {
      initialise() {
          for (let i=0; i < this.ordinateur.attributions.length; i++) {
            let attribution = this.ordinateur.attributions[i]
            this.attributions[attribution.hour] = {
              id: attribution.id,
              name: attribution.customer,
            }
          }
        this.buildHoraires();
      },
      buildHoraires() {
        this.horaires = [];
        for (let i = 0; i < 10; i++) {
          this.horaires.push({
            index: i + 8,
            attribution: (typeof this.attributions[i + 8] !== 'undefined' ) ? this.attributions[i + 8] : false
          })
        }

      },
    addAttribution: function (attribution) {
      this.ordinateur.attributions.push(attribution)
      this.initialise();
    },
    removeAttribution: function(horaire){
      _.unset(this.attributions,horaire)
      this.buildHoraires();
    }
  }
}
</script>
