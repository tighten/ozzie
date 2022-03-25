<template>
    <div>
        <div class="relative z-10 border-t-4 border-indigo-600 bg-white shadow">
            <section class="mx-auto max-w-4xl px-2">
                <div class="flex items-center justify-between h-16">
                    <InertiaLink
                        :href="$route('projects.index')"
                        method="get">
                        <h1 class="flex items-center">
                            <span class="text-5xl font-light text-indigo-600">O</span>
                            <span class="font-sans text-2xl font-semibold uppercase leading-normal tracking-wide text-black-light">zzie</span>
                        </h1>
                    </InertiaLink>
                    <p class="font-sans font-normal italic leading-normal tracking-tight text-gray-blue-darkest">
                        Addressing our open source debt
                    </p>
                </div>
            </section>
        </div>
        <div class="relative z-0 overflow-x-auto bg-frost font-sans">
            <div class="mx-auto max-w-4xl px-2 pb-6">
                <slot />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    name: 'Layout',
    props: {
        title: {
            type: String,
            default: 'Ozzie',
        },
    },
    watch: {
        title: {
            immediate: true,
            handler(title: string): void {
                document.title = title;
            },
        },
    },
};
</script>
