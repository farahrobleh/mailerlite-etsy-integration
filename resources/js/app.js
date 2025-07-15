import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import EtsyDashboard from './components/EtsyDashboard.vue';

createInertiaApp({
    resolve: name => {
        const pages = {
            'EtsyDashboard': EtsyDashboard
        };
        return pages[name];
    },
    setup({ el, App, props }) {
        createApp({ render: () => h(App, props) })
            .mount(el);
    },
});
