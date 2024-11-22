export default {
    getBackupStatuses() {
        return Nova.request()
            .get('/nova-vendor/spatie/backup-tool/backup-statuses')
            .then(response => response.data);
    },

    getBackups(disk) {
        return Nova.request()
            .get(`/nova-vendor/spatie/backup-tool/backups?disk=${disk}`)
            .then(response => response.data);
    },

    createBackup() {
        return Nova.request().post(`/nova-vendor/spatie/backup-tool/backups`);
    },

    createPartialBackup(option) {
        return Nova.request().post(`/nova-vendor/spatie/backup-tool/backups`, { option });
    },

    restoreBackup({ disk, path }) {
        return Nova.request().put(`/nova-vendor/spatie/backup-tool/backups`, {  disk, path });
    },

    deleteBackup({ disk, path }) {
        return Nova.request().delete(`/nova-vendor/spatie/backup-tool/backups`, {
            params: { disk, path },
        });
    },
};
