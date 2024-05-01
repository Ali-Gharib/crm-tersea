import Vue from "vue";

import LoginComponent from "./components/LoginComponent.vue";

Vue.component("login-component", LoginComponent);

const app = new Vue({
    el: "#app",
});
