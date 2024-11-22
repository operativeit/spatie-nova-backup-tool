<template>
    <div>
        <div class="p-3 flex items-center"
            v-if="disks.length > 1">
            <SelectControl
                class="w-full md:w-1/5"
                :options="getDiscs()"
                :selected="activeDisk"
                @change="$emit('update:activeDisk', $event)"
            />
        </div>

        <div class="overflow-hidden overflow-x-auto relative rounded-lg">
            <table cellpadding="0" cellspacing="0" class="table-default w-full">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide px-2 py-2">
                            {{ __('Path') }}
                        </th>
                        <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide px-2 py-2">
                            {{ __('Created at') }}
                        </th>
                        <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide px-2 py-2">
                            {{ __('Size') }}
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <backup
                        v-for="backup in backups"
                        v-bind="backup"
                        :disk="activeDisk"
                        :restorable="backups.length > 1"
                        :deletable="backups.length > 1"
                        :restoring="
                            !restoreModalOpen && restoringBackup && backup.path === restoringBackup.path
                        "
                        :deleting="
                            !deleteModalOpen && deletingBackup && backup.path === deletingBackup.path
                        "
                        :key="backup.id"
                        @delete="openDeleteModal(backup)"
                        @restore="openRestoreModal(backup)"
                    />
                    <tr v-if="backups.length === 0">
                        <td class="text-center px-2 py-2" colspan="4">
                            {{ __('No backups present') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ConfirmActionModal
            :show="restoreModalOpen" 
            @close="closeRestoreModal"
            @confirm="confirmRestore"
            :action="{
		name: __('Restore backup'),
                fields: [],
                modalStyle: 'window',
                confirmText:  this.__('Are you sure you want to restore the backup created at :date ?' , {
                        date: restoringBackup?.date,
                    }),
                cancelButtonText: __('Cancel'),
                confirmButtonText: __('Restore'),
                destructive: false,
            }"
        >
        </ConfirmActionModal>


        <DeleteResourceModal
            mode="delete"
            :show="deleteModalOpen"
            @close="closeDeleteModal"
            @confirm="confirmDelete"
        >
            <ModalHeader v-text="__('Delete backup')" />
            <ModalContent>
                <p
                    class="leading-normal"
                    v-text="__('Are you sure you want to delete the backup created at :date ?', {
                        date: deletingBackup.date,
                    })"
                />
            </ModalContent>
        </DeleteResourceModal>
    </div>
</template>

<script>
import Backup from './Backup';

export default {
    emits: ['setModalVisibility', 'delete', 'restore'],

    props: {
        disks: { required: true, type: Array },
        activeDisk: { required: true, type: String },
        backups: { required: true, type: Array },
    },

    data() {
        return {
            restoringBackup: null,
            restoreModalOpen: false,
            deletingBackup: null,
            deleteModalOpen: false,
        };
    },

    components: {
        Backup,
    },

    methods: {
        getDiscs() {
            return this.disks.map(val => ({ value: val, label: val }));
        },

        openRestoreModal(backup) {
            this.$emit('setModalVisibility', true);
            this.restoreModalOpen = true;
            this.restoringBackup = backup;
        },

        openDeleteModal(backup) {
            this.$emit('setModalVisibility', true);
            this.deleteModalOpen = true;
            this.deletingBackup = backup;
        },

        closeRestoreModal() {
            this.$emit('setModalVisibility', false);
            this.restoreModalOpen = false;
            this.restoringBackup = null;
        },

        closeDeleteModal() {
            this.$emit('setModalVisibility', false);
            this.deleteModalOpen = false;
            this.deletingBackup = null;
        },

        confirmRestore() {
            this.$emit('setModalVisibility', false);
            this.restoreModalOpen = false;

            this.$emit('restore', {
                disk: this.activeDisk,
                path: this.restoringBackup.path,
            });
        },

        confirmDelete() {
            this.$emit('setModalVisibility', false);
            this.deleteModalOpen = false;

            this.$emit('delete', {
                disk: this.activeDisk,
                path: this.deletingBackup.path,
            });
        },
    },
};
</script>
