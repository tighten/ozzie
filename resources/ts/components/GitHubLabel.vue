<template>
    <a
        :href="'https://github.com/' + namespace + '/' + name + '/labels/' + label.name"
        :style="`background-color: #${label.color};`"
        :title="`See all items labelled '${label.name}' on GitHub`"
        target="_blank"
        rel="noopener noreferrer"
        class="mr-1 mt-2 inline-flex items-center py-1 pl-1 pr-2 hover:bg-grey-blue-light font-sans font-semibold no-underline leading-none text-xs rounded-full">
        <span
            class="ml-1"
            :style="'color: ' + getCorrectTextColor(label.color)">{{ label.name }}</span>
    </a>
</template>
<script lang="ts">
import { PropType } from 'vue';
import { Label } from '../ozzie';

export default {
    name: 'GitHubLabel',
    props: {
        label: {
            type: Object as PropType<Label>,
            default: null,
        },
        namespace: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
    },
    methods: {
        // REFACTOR : Extract this method to a mixin
        getCorrectTextColor(hex): string {
            function cutHex(h) { return (h.charAt(0) === '#') ? h.substring(1, 7) : h; }
            function hexToR(h) { return parseInt((cutHex(h)).substring(0, 2), 16); }
            function hexToG(h) { return parseInt((cutHex(h)).substring(2, 4), 16); }
            function hexToB(h) { return parseInt((cutHex(h)).substring(4, 6), 16); }

            /* about half of 256. Lower threshold equals more dark text on dark background  */
            const threshold = 120;

            const hRed = hexToR(hex);
            const hGreen = hexToG(hex);
            const hBlue = hexToB(hex);

            const cBrightness = ((hRed * 299) + (hGreen * 587) + (hBlue * 114)) / 1000;
            if (cBrightness > threshold) {
                return '#000000';
            }
            return '#ffffff';
        },

    },
};
</script>
