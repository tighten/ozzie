<template>
    <HeadlessMenu
        as="div"
        class="group relative inline-block text-left">
        <div>
            <MenuButton
                class="
                    focus:ring-indigo-500
                    inline-flex
                    w-full
                    items-center
                    justify-center
                    bg-white
                    px-4
                    py-2
                    text-sm
                    font-medium
                    text-gray-500
                    focus:outline-none
                    focus:ring-0
                    focus:ring-inset
                    focus:ring-offset-gray-100
                ">
                <div>
                    <img
                        class="inline-block h-8 w-8 rounded-full"
                        :src="user.avatar_url"
                        alt="">
                </div>
                <ChevronDownIcon
                    class="-mr-1 ml-2 h-5 w-5 group-hover:text-gray-700"
                    aria-hidden="true" />
            </MenuButton>
        </div>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <MenuItems
                class="
                    absolute
                    right-0
                    z-10
                    mt-2
                    w-56
                    origin-top-right
                    divide-y divide-gray-100
                    rounded-md
                    bg-white
                    shadow-lg
                    ring-1 ring-black ring-opacity-5
                    focus:outline-none
                ">
                <div class="px-4 py-3">
                    <p class="text-sm">
                        Signed in as
                    </p>
                    <p class="truncate text-sm font-medium text-gray-900">
                        {{ user.email }}
                    </p>
                </div>
                <div class="py-1">
                    <MenuItem v-slot="{ active }">
                        <a href="/nova">
                            <div
                                :class="[
                                    active
                                        ? 'bg-gray-100 text-gray-900'
                                        : 'text-gray-700',
                                    'block w-full px-4 py-2 text-left text-sm',
                                ]">
                                Nova Dashboard
                            </div>
                        </a>
                    </MenuItem>

                    <MenuItem v-slot="{ active }">
                        <InertiaLink
                            :href="$route('logout')"
                            method="get">
                            <div
                                :class="[
                                    active
                                        ? 'bg-gray-100 text-gray-900'
                                        : 'text-gray-700',
                                    'block w-full px-4 py-2 text-left text-sm',
                                ]">
                                Logout
                            </div>
                        </InertiaLink>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </HeadlessMenu>
</template>

<script lang="ts">
import {
    Menu as HeadlessMenu, MenuButton, MenuItem, MenuItems,
} from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import { PropType } from 'vue';
import { User } from '@/ozzie';

export default {
    name: 'UserMenu',
    components: {
        HeadlessMenu,
        MenuButton,
        MenuItem,
        MenuItems,
        ChevronDownIcon,
    },
    props: {
        user: {
            type: Object as PropType<User> | null,
            required: true,
        },
    },
};
</script>
