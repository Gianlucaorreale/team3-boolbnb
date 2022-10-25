import Vue from 'vue'
import VueRouter from 'vue-router'

import HomePage from './components/pages/HomePage.vue'
import ApartmentDetailPage from './components/pages/ApartmentDetailPage.vue'
import ApartmentsList from './components/pages/ApartmentsList.vue'

Vue.use(VueRouter)

const routes = new VueRouter({
  mode: 'history',
  linkExactActiveClass: 'active',
  routes:[
    {path: '/',component: HomePage , name:'HomePage'},
    {path: '/apartments',component: ApartmentsList ,name:'ApartmentsList'},
    {path: '/apartment/:id',component: ApartmentDetailPage ,name:'ApartmentDetailPage'},
  ]
});
export default routes;