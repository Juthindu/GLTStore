<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tea Types</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tea Type Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(teaType, index) in teaTypes" :key="teaType.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ teaType.name }}</td>
                                <td>{{ teaType.description }}</td>
                                <td>
                                    <button
                                        @click="editTeaType(teaType.id)"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteTeaType(teaType.id)"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!teaTypes.length">
                                <td colspan="4" class="text-center">No tea types found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            teaTypes: [],
        };
    },
    created() {
        this.fetchTeaTypes();
    },
    methods: {
        fetchTeaTypes() {
            axios
                .get("/api/tea-types")
                .then((response) => {
                    this.teaTypes = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching tea types:", error);
                });
        },
        editTeaType(id) {
            this.$router.push({ name: "tea-types.edit", params: { id } });
        },
        deleteTeaType(id) {
            if (confirm("Are you sure you want to delete this tea type?")) {
                axios
                    .delete(`/api/tea-types/${id}`)
                    .then(() => {
                        this.teaTypes = this.teaTypes.filter(
                            (teaType) => teaType.id !== id
                        );
                        alert("Tea type deleted successfully.");
                    })
                    .catch((error) => {
                        console.error("Error deleting tea type:", error);
                    });
            }
        },
    },
};
</script>

<style scoped>
.table th,
.table td {
    text-align: center;
    vertical-align: middle;
}
</style>
