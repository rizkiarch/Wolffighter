const PLUGIN_NAME = "vite:inertia:layout";
const TEMPLATE_LAYOUT_REGEX =
    /<template +layout(?: *= *['"](?:(?:(\w+):)?(\w+))['"] *)?>/;

/**
 * A basic Vite plugin that adds a <template layout="name"> syntax to Vite SFCs.
 * It must be used before the Vue plugin.
 */
export default (layouts = "@/views/layouts/") => ({
    name: PLUGIN_NAME,
    transform: (code) => {
        if (!TEMPLATE_LAYOUT_REGEX.test(code)) {
            return;
        }

        return code.replace(
            TEMPLATE_LAYOUT_REGEX,
            (_, __, layoutName) => `
			<script>
			import layout from '${layouts}${layoutName ?? "default"}.vue'
			export default { layout }
			</script>
			<template>
		`
        );
    },
});
