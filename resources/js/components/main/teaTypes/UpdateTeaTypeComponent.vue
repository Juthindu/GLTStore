<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Update Tea Type</h5>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="tea_name">Tea Name:</label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                placeholder="Enter tea name"
                                :class="{ 'is-invalid': form.errors.has('name') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('name')"
                                v-html="form.errors.get('name')"
                            />
                        </div>
                        <div class="col-6">
                            <label for="tea_code">Tea Code:</label>
                            <input
                                v-model="form.code"
                                type="text"
                                class="form-control"
                                placeholder="Enter tea code"
                                :class="{ 'is-invalid': form.errors.has('code') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('code')"
                                v-html="form.errors.get('code')"
                            />
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="description">Description:</label>
                            <textarea
                                v-model="form.description"
                                class="form-control"
                                placeholder="Enter tea description"
                                :class="{ 'is-invalid': form.errors.has('description') }"
                            ></textarea>
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('description')"
                                v-html="form.errors.get('description')"
                            />
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-secondary" @click="cancelUpdate">
                                Cancel
                            </button>
                            <button
                                type="button"
                                @click="submitForm"
                                class="btn btn-primary col-2"
                            >
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                name: "",
                code: "",
                description: ""
            }),
            teaTypeId: null
        };
    },
    created() {
        this.teaTypeId = this.$route.params.id;
        this.fetchTeaTypeDetails();
    },
    methods: {
        fetchTeaTypeDetails() {
            axios
                .get(`/api/tea-types/${this.teaTypeId}`)
                .then((response) => {
                    this.form.name = response.data.name;
                    this.form.code = response.data.code;
                    this.form.description = response.data.description;
                })
                .catch((error) => {
                    console.error("Error fetching tea type details:", error);
                });
        },
        submitForm() {
            swal.fire({
                title: "Are you sure?",
                text: "You want to update this tea type!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Update it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form
                        .put(`/api/tea-types/${this.teaTypeId}`)
                        .then((response) => {
                            if (response.status === 200) {
                                swal.fire(
                                    "Success!",
                                    "Tea Type updated successfully.",
                                    "success"
                                );
                                this.$router.push({ name: "tea-types.index" });
                            }
                        })
                        .catch((error) => {
                            console.error("Error updating tea type:", error);
                        });
                }
            });
        },
        cancelUpdate() {
            this.$router.push({ name: "tea-types.index" });
        }
    },
};
</script>

<style scoped>
</style>
