/* ダークモード設定 */
let userMod = window.matchMedia("(prefers-color-scheme: dark)").matches;
let sMode = window.sessionStorage.getItem("user");
let el = document.documentElement;
const THEME = "theme";

if (sMode) {
    el.setAttribute(THEME, sMode);
}
else {
    if (userMod == true) {
        el.setAttribute(THEME, "dark");
    } else {
        el.setAttribute(THEME, "light");
    }
}