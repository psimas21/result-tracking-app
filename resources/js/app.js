 require('./bootstrap');
 import common from './common';

 window.Vue = require('vue').default;
 import vuetify from './vuetify'
 import App from './components/App'
 import ViewUI from 'view-design';
 import 'view-design/dist/styles/iview.css';
 import VueRouter from 'vue-router';

 Vue.mixin(common)
 Vue.use(VueRouter);
 Vue.use(ViewUI);

import Dashboard from './components/pages/Dashboard'
import Roles from './components/pages/Roles'
import Users from './components/pages/Users'
import Parties from './components/pages/Parties'

  const router = new VueRouter({
     mode: 'history',
     routes: [
         {
             path: '/',
             name: 'home',
             component: Dashboard
         },
         {
             path: '/',
             name: 'roles',
             component: Roles
         },
         {
             path: '/',
             name: 'users',
             component: Users
         },
         {
             path: '/',
             name: 'parties',
             component: Parties
         },
     ],
  });

 const app = new Vue({
     vuetify,
     router,
     components: { App },
     el: '#app',
 });