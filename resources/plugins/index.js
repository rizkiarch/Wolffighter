import websocket from "./websocket";

const ENV = import.meta.env;
export const localPlugins = {
    install(app, options) {
        // websocket({ app, ENV });
    },
};
