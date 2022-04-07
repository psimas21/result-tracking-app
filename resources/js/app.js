 require('./bootstrap');
 import common from './common';

 window.Vue = require('vue').default;
 import vuetify from './vuetify'
 import App from './components/App'
 import ViewUI from 'view-design';
 import 'view-design/dist/styles/iview.css';
 import VueRouter from 'vue-router';

 Vue.use(ViewUI);
 Vue.mixin(common)
 Vue.use(VueRouter);

import Dashboard from './components/pages/Dashboard'
import Roles from './components/pages/Roles'
import Users from './components/pages/Users'
import Parties from './components/pages/Parties'
import Result from './components/pages/Result'

  const router = new VueRouter({
     mode: 'history',
     routes: [
         {
             path: '/home',
             name: 'home',
             component: Dashboard
         },
         {
             path: '/roles',
             name: 'roles',
             component: Roles
         },
         {
             path: '/users',
             name: 'users',
             component: Users
         },
         {
             path: '/parties',
             name: 'parties',
             component: Parties
         },
         {
             path: '/result',
             name: 'result',
             component: Result
         },
     ],
  });

 const app = new Vue({
     vuetify,
     router,
     components: { App },
     el: '#app',
 });