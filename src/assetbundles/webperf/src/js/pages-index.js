import Vue from 'vue';
import VueEvents from 'vue-events';
import PagesIndexBarChart from '../vue/PagesIndexBarChart.vue';
import PagesIndexTable from '../vue/PagesIndexTable.vue';
import SampleRangePicker from '../vue/SampleRangePicker.vue';
import PageDetailAreaChart from '../vue/PageDetailAreaChart.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'pages-index-bar-chart': PagesIndexBarChart,
        'pages-index-table': PagesIndexTable,
        'sample-range-picker': SampleRangePicker,
        'page-detail-area-chart': PageDetailAreaChart,
    },
    data: {
    },
    methods: {
        onTableRefresh(vuetable) {
            Vue.nextTick(() => vuetable.refresh());
        }
    },
    mounted() {
        this.$events.$on('refresh-table', eventData => this.onTableRefresh(eventData));
    },
});
