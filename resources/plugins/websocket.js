import "pusher-js";
import Echo from "laravel-echo";

export default ({ app, ENV }) => {
    const laravelEcho = new Echo({
        broadcaster: "pusher",
        key: ENV.MIX_PUSHER_APP_KEY,
        wsHost: ENV.MIX_PUSHER_HOST,
        wsPort: ENV.MIX_PUSHER_PORT,
        wssPort: ENV.MIX_PUSHER_PORT,
        forceTLS: false,
        encrypted: true,
        disableStats: true,
        enabledTransports: ["ws", "wss"],
    });

    laravelEcho.private(`message`).listen("OrderShipmentStatusUpdated", (e) => {
        console.log(e.order);
    });
};
