<template>
  <v-dialog v-model="dialog" max-width="600px">
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on" @click="init">
        <v-icon color="green" small>mdi-plus</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        {{ computer.name }} : Attribuer client à {{ horaire }}h
        <v-spacer></v-spacer>
        <v-btn icon @click="ajouter = true" color="success">
          <v-icon>mdi-account-plus</v-icon>
        </v-btn>
      </v-card-title>

      <v-card-text>
        <v-container>
          <v-row v-if="!ajouter">
            <v-col cols="12" md="6" sm="8">
              <v-autocomplete :loading="loading" :items="customers" :search-input.sync="search" v-model="customer" item-text="name" return-object cache-items hide-no-data hide-details label="Sélection le client">
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
        <v-btn outlined color="success" @click="attribute" :disabled="!validate" class="mr-2">Ajouter</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script src="./AddAttribution.js"></script>
