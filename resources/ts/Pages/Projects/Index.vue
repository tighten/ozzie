<template>
    <layout title="Ozzie">
        <BreadCrumb />
        <div class="flex items-start justify-between">
            <p class="my-6 text-black-lighter">
                Projects in descending order of "debt" (how much attention it needs)
            </p>
            <a
                v-if="hacktoberfest"
                href="https://github.com/search?o=desc&amp;q=label%3Ahacktoberfest+is%3Aopen+type%3Aissue+user%3Atighten&amp;s=created&amp;type=Issues"
                target="_blank"
                class="px-4 py-3 bg-grey-blue hover:bg-halloween-orange no-underline text-black-lighter hover:text-white hover-pop"
            >
                Hacktoberfest is here! 👻
            </a>
        </div>
        <DebtTable
            :hacktoberfest="hacktoberfest"
            :projects="projects"
        />
    </layout>
</template>

<script lang="ts">
import { PropType } from 'vue';
import { Project } from '../../ozzie';
import Layout from '../Layout';
import DebtTable from '../../components/DebtTable/DebtTable';
import BreadCrumb from '../Partials/BreadCrumb.vue';

export default {
    components: {
        BreadCrumb,
        DebtTable,
        Layout,
    },
    props: {
        projects: {
            type: Object as PropType<Project[]>,
            required: true,
        },
        hacktoberfest: {
            type: Boolean,
            required: true,
        },
        organization: {
            type: String,
            required: true,
        },
    },
};
</script>
