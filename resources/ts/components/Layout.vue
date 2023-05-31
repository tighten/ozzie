<template>
    <div>
        <div class="relative z-10 border-t-4 border-indigo bg-white">
            <section class="mx-auto max-w-4xl px-2">
                <div class="flex items-center justify-between">
                    <InertiaLink
                        :href="$route('projects.index')"
                        method="get">
                        <h1 class="flex items-center">
                            <span class="text-5xl font-light text-indigo">O</span>
                            <span class="font-sans text-2xl font-semibold uppercase leading-normal tracking-wide text-black-light">zzie</span>
                        </h1>
                    </InertiaLink>
                    <div v-if="user">
                        <UserMenu :user="user" />
                    </div>
                    <div v-else>
                        <a
                            :href="$route('auth.github')"
                            @click="loading = true">
                            <div class="flex h-6 items-center">
                                <div><IconGitHub /></div>
                                <div class="pl-2 pt-1">
                                    {{ loginButtonText }}
                                </div>
                            </div>
                        </a>
                    </div>
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
import { User } from '@/ozzie';
import UserMenu from '@/components/UserMenu.vue';
import IconGitHub from '@/components/IconGitHub.vue';

export default {
    name: 'Layout',
    components: {
        UserMenu,
        IconGitHub,
    },
    props: {
        title: {
            type: String,
            default: 'Ozzie',
        },
    },
    data(): { loading: boolean } {
        return {
            loading: false,
        };
    },
    computed: {
        user(): User | null {
            return this.$page.props.user;
        },
        loginButtonText(): string {
            return this.loading ? 'Loading...' : 'Tighten Login';
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
