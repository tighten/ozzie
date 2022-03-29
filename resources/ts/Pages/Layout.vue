<template>
    <div>
        <div class="relative z-10 bg-white border-t-4 border-indigo-600 shadow dark:border-b dark:border-b-gray-700 dark:border-t-indigo-600 dark:bg-gray-800">
            <section class="max-w-4xl px-2 mx-auto">
                <div class="flex items-center justify-between h-16">
                    <InertiaLink
                        :href="$route('projects.index')"
                        method="get">
                        <h1 class="flex items-center">
                            <span class="text-5xl font-light text-indigo-600 dark:text-indigo-400">O</span>
                            <span class="font-sans text-2xl font-semibold leading-normal tracking-wide text-gray-900 uppercase dark:text-gray-200">zzie</span>
                        </h1>
                    </InertiaLink>
                    <p class="font-sans italic font-normal leading-normal tracking-tight text-gray-700 dark:text-gray-400">
                        Addressing our open source debt
                    </p>
                </div>
            </section>
        </div>
        <div class="relative z-0 overflow-x-auto font-sans bg-gray-100 dark:bg-gray-900">
            <div class="max-w-4xl px-2 pb-6 mx-auto">
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
