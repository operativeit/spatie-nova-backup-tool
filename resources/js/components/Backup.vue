<template>
    <tr :class="{ 'is-deleting': deleting }">
        <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">{{ path }}</td>
        <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">{{ date }}</td>
        <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">{{ size }}</td>
        <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900 text-right flex items-center justify-center">
            <a
                :href="downloadUrl"
                target="_blank"
                rel="noopener nofollow"
                :title="__('Download')"
                class="inline-flex items-center justify-center h-9 text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 dark:hover:[&:not(:disabled)]:text-primary-500"

            >
                <icon type="download" view-box="0 0 24 24" width="24" height="24" />
            </a>
            <SimpleButton
                :title="__('Restore')"
                class="inline-flex items-center justify-center h-9 text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 dark:hover:[&:not(:disabled)]:text-primary-500"
                @click.prevent="$emit('restore')"
            >
                <icon type="refresh" view-box="0 0 24 24" width="24" height="24" />
            </SimpleButton>
            <SimpleButton
                :title="__('Delete')"
                class="inline-flex items-center justify-center h-9 text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 dark:hover:[&:not(:disabled)]:text-primary-500"
                :disabled="!deletable"
                @click.prevent="$emit('delete')"
                v-if="deletable"
            >
                <icon type="trash" view-box="0 0 24 24" width="24" height="24" />
            </SimpleButton>
        </td>
    </tr>
</template>

<script>
import SimpleButton from './SimpleButton.vue';

export default {
    components: {
       SimpleButton
    },
    props: {
        date: { required: true },
        path: { required: true },
        size: { required: true },
        disk: { required: true },
        restorable: { required: true },
        deletable: { required: true },
        deleting: { required: true },
    },

    computed: {
        downloadUrl() {
            const endpoint = '/nova-vendor/spatie/backup-tool/download-backup';

            return `${endpoint}?disk=${this.disk}&path=${this.path}`;
        },
    },
};
</script>

<style scoped>
.is-deleting td {
    color: var(--60);
}
</style>
