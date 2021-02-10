<template>
    <div>
        <div class="bg-white border-t-4 border-indigo relative z-10">
            <section class="max-w-4xl mx-auto px-2">
                <div class="flex justify-between items-center">
                    <InertiaLink
                        href="/inertia"
                        method="get"
                    >
                        <h1 class="flex items-center">
                            <span class="font-light text-5xl text-indigo">O</span>
                            <span class="uppercase text-2xl leading-normal text-black-light font-semibold font-sans tracking-wide">zzie</span>
                        </h1>
                    </InertiaLink>
                    <p class="font-sans italic font-normal leading-normal tracking-tight text-grey-blue-darkest">
                        Addressing our open source debt
                    </p>
                </div>
            </section>
        </div>
        <div class="bg-frost font-sans relative overflow-x-auto z-0">
            <div class="max-w-4xl mx-auto px-2 py-6">
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
            handler(title) {
                document.title = title;
            },
        },
    },
};
</script>
