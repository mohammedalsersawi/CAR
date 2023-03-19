import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    key: 'laravelwebsocetkey',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});


window.Echo.private(`orderUser`)
    .listen('UserOrderEvent', (e) => {
            console.log('fdddddds');
            var count=$('#count').text();
        console.log(count);
            table.draw();
        $('#count').html(parseInt(count)+1)
        }
    );
window.Echo.private(`countuserorder`)
    .listen('CountUserOrderEvent', (e) => {
            console.log('count');
        console.log(e.count);
            var count=$('#count').text();
            console.log(count);
            $('#count').html(parseInt(count)-e.count)
        }
    );
