<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Tea Type</h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <div class="form-group">
                            <label for="tea_name">Tea Name:</label>
                            <input
                                v-model="form.name"
                                type="text"
                                id="tea_name"
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

                        <div class="form-group">
                            <label for="tea_description">Description:</label>
                            <textarea
                                v-model="form.description"
                                id="tea_description"
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

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
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
                description: ""
            }),
        };
    },
    methods: {
        submitForm() {
            this.form
                .post("/api/tea-types/store")
                .then((response) => {
                    if (response.status === 200) {
                        swal.fire("Success!", "Tea type added successfully.", "success");
                        this.form.clear();
                        this.form.reset();
                    }
                })
                .catch((error) => {
                    console.error("Error adding tea type:", error);
                });
        },
    },
};
</script>

<style scoped>
/* Optional: Add custom styles if needed */
</style>
