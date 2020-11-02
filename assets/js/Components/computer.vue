<template>
  <v-card>

    <v-card-title>

      {{ ordinateur.name }}
    </v-card-title>
<!--    <v-card-text>-->
<!--      <v-row v-for="(horaire, key) in horaires" :key="key">-->
<!--        <v-col cols="2"> {{ horaire.index }}h</v-col>-->
<!--        <v-col cols="8">-->
<!--                <span v-if="horaire.attribution">-->
<!--                    {{ horaire.attribution.name + " " + horaire.attribution.firstname }}-->
<!--                </span>-->
<!--        </v-col>-->
<!--        <v-col cols="2">-->
<!--          <RemoveAttribution v-if="horaire.attribution" :ordinateur="ordinateur" :attribution="horaire.attribution" :horaire="horaire.index" @removeAttribution="removeAttribution" />-->

<!--          <AddAttribution v-if="!horaire.attribution" :ordinateur="ordinateur" :horaire="horaire.index" :date="date" @addAttribution="addAttribution" />-->
<!--        </v-col>-->
<!--      </v-row>-->
<!--    </v-card-text>-->
  </v-card>
</template>
<script>
export default {
  props: {
    ordinateur: {
      required: true
    },
    // date: {
    //   required: true
    // },
  },

}
</script>
