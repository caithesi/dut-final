export function generateComponentName(key) {
    // and remove .vue
    let file = `${key}`.split(".vue").join("");
    // remove .
    file = file.split(".").join("")

    //replace "/" by "."
    file = file.split("/").filter(word => word.length > 0)

    file.forEach((ele, index, file) => {
        file[index] = ele.match(/([A-Z]?[^A-Z]*)/g).slice(0, -1).join("-").toLowerCase()
    })

    return file.join(".")
}
