import Vue from 'vue'
window.Vue = require('vue');

export let createComponent = {
    pages: importPages
}

function generateComponentName(prefix, key) {
    // and remove .vue
    let file = `${key}`.split(".vue").join("");
    // remove .
    file = file.split(".").join("")

    //replace "/" by "."
    file = file.split("/").filter(word => word.length > 0)

    file.forEach((ele, index, file) => {
        file[index] = file[index].match(/([A-Z]?[^A-Z]*)/g).slice(0, -1).join("-").toLowerCase()
    })

    return prefix + "." + file.join(".")
}

function importPages() {
    const files = require.context('./pages', true, /\.vue$/i);
    files.keys().map(key => {
        console.log(key);

        generateComponentName('pages', key), files(key).default
    })
}
