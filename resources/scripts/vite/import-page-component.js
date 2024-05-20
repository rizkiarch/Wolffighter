export function importPageComponent(name, pages) {
    for (const path in pages) {
        // if (path.includes("index") && !name.includes("index")) {
        //     name = `${name}/index`;
        // }

        if (path.endsWith(`${name.replaceAll(".", "/")}.vue`)) {
            return typeof pages[path] === "function"
                ? pages[path]()
                : pages[path];
        }
    }

    throw new Error(`Page not found: ${name}`);
}
