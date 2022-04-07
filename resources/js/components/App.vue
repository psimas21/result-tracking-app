<template>
  <v-app id="inspire" dark>
    <v-navigation-drawer v-model="drawer" app>
      <!-- Below are the content of the drawer -->
      <v-list>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                Sulaiman Idris
              </v-list-item-title>
              <!-- <v-list-item-subtitle>Admin II</v-list-item-subtitle> -->
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list nav>
            <v-list-item-group v-model="model">
                <v-list-item v-for="item in items" :key="item.title" @click="navigate(item.route)">
                  <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>e-Result Tracker</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <!-- Page content -->
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data(){
      return {
        model: 0,
        drawer: null,
        items: [
        { title: 'Dashboard', icon: 'mdi-view-dashboard', route: 'home' },
        { title: 'Manage Roles', icon: 'mdi-order-bool-descending-variant', route: 'roles' },
        { title: 'Manage Users', icon: 'mdi-account-cog', route: 'users' },
        { title: 'Manage Parties', icon: 'mdi-diving-scuba-flag', route: 'parties' },
        { title: 'Result Upload', icon: 'mdi-account-multiple', route: 'result' },
        ]
      }
    },
    methods:{
      navigate(i){
         this.$router.push({ name: i});
      }
    }
  }
</script>
<style lang="scss" scoped>
  .vuetify-class {
    ::v-deep other-class {
      // your custom css properties
      .btn {
        text-transform: unset !important;
      }

    }
  }
</style>