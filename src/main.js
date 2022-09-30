import { generateFilePath } from "@nextcloud/router";

import Vue from "vue";
import App from "./App";
import SmartTable from "vuejs-smart-table";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "bootstrap/dist/js/bootstrap.js";
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Datetime)
Vue.use(SmartTable);

// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, "", "js/");

Vue.mixin({ methods: { t, n } });

export default new Vue({
  el: "#content",
  render: (h) => h(App),
});
