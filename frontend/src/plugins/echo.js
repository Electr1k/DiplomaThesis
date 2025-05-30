import Pusher from 'pusher-js';

const pusher = new Pusher(
    process.env.VUE_APP_PUSHER_KEY,
    {
        cluster: process.env.VUE_APP_PUSHER_CLUSTER
    }
);

const channelNotification = pusher.subscribe('notifications');

export default channelNotification
