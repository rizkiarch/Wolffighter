import { date, Notify, useQuasar } from "quasar";

export const currentDate = (params = Date()) => new Date(params);

export function formatDate(params = null, format = "YYYY-MM-DD") {
    let timeStamp = currentDate();
    if (params !== null) {
        timeStamp = currentDate(params);
    }
    return date.formatDate(timeStamp, format);
}
