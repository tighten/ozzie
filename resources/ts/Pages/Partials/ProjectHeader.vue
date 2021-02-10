<template>
    <section
        :id="`project-${project.namespace}-${project.name}`"
        class="items-center pb-6"
    >
        <div class="flex justify-between items-center">
            <h2 class="text-3xl text-black-lightest font-semibold tracking-wide">
                <a
                    :href="project.url"
                    aria-label="Launch"
                >
                    {{ project.namespace }} | {{ project.name }}
                    <IconLaunch />
                </a>
            </h2>
            <p class="text-black-lightest">
                Maintained by
                <a
                    v-for="maintainer in project.maintainers"
                    :key="maintainer"
                    class="text-indigo no-underline"
                    :href="`https://github.com/${maintainer}`"
                    target="_blank"
                >
                    @{{ maintainer }}
                </a>
            </p>
        </div>
        <p class="mt-1 text-grey-dark font-light">
            Synced {{ $luxon.fromISO(project.updated_at).toRelative() }}
        </p>
        <p
            v-if="project.hasDownloads"
            class="text-grey-dark font-light"
        >
            {{ new Intl.NumberFormat().format(project.downloads_total) }} downloads ({{ new Intl.NumberFormat().format(project.downloads_last_30_days) }}  per month)
        </p>
    </section>
</template>

<script lang="ts">
import { PropType } from 'vue';
import IconLaunch from '../../components/svg/Launch';
import { Project } from '../../ozzie.ts';

export default {
    name: 'ProjectHeader',
    components: {
        IconLaunch,
    },
    props: {
        project: {
            type: Object as PropType<Project>,
            required: true,
        },
    },
};
</script>
