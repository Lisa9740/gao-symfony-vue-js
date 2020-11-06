<template>
  <v-card>
    <v-card-title>
      {{ computer.name }}
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
       <RemoveAttribution v-if="horaire.attribution" :computer="computer" :attribution="horaire.attribution" :horaire="horaire.index" @removeAttribution="removeAttribution" />

          <AddAttribution v-if="!horaire.attribution" :computer="computer" :horaire="horaire.index" :date="date" @addAttribution="addAttribution" />
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>
<script src="./Computer.js"></script>
