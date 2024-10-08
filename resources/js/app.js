import './bootstrap';
import '../css/app.css';
import 'clockwork-browser/toolbar';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import PrimeVue from "primevue/config";
import Tooltip from "primevue/tooltip";
import ConfirmationService from "primevue/confirmationservice";
import Lara from "../css/presets/lara";
import 'remixicon/fonts/remixicon.css';
import CKEditor from "@ckeditor/ckeditor5-vue";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                unstyled: true,
                ripple: true,
                pt: Lara,
            })
            .use(ConfirmationService)
            .use(CKEditor)
            .directive('tooltip', Tooltip)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
}).then(() => {
    document.getElementById('app').removeAttribute('data-page')
});
