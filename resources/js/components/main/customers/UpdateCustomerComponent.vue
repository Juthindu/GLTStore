<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Update Customer</h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="first_name">First Name:</label>
                                <input
                                    v-model="form.first_name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter first name"
                                    :class="{ 'is-invalid': form.errors.has('first_name') }"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('first_name')"
                                    v-html="form.errors.get('first_name')"
                                />
                            </div>
                            <div class="col-6">
                                <label for="last_name">Last Name:</label>
                                <input
                                    v-model="form.last_name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter last name"
                                    :class="{ 'is-invalid': form.errors.has('last_name') }"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('last_name')"
                                    v-html="form.errors.get('last_name')"
                                />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <label for="email">Email:</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="form-control"
                                    placeholder="Enter email"
                                    :class="{ 'is-invalid': form.errors.has('email') }"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('email')"
                                    v-html="form.errors.get('email')"
                                />
                            </div>
                            <div class="col-6">
                                <label for="phone">Phone:</label>
                                <input
                                    v-model="form.phone"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter phone number"
                                    :class="{ 'is-invalid': form.errors.has('phone') }"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('phone')"
                                    v-html="form.errors.get('phone')"
                                />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <label for="address">Address:</label>
                                <textarea
                                    v-model="form.address"
                                    class="form-control"
                                    placeholder="Enter address"
                                    :class="{ 'is-invalid': form.errors.has('address') }"
                                ></textarea>
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('address')"
                                    v-html="form.errors.get('address')"
                                />
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12 text-right">
                                <button type="button" @click="cancel" class="btn btn-secondary">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary col-2">
                                    Update
                                </button>
                            </div>
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
                first_name: "",
                last_name: "",
                email: "",
                phone: "",
                address: "",
            }),
        };
    },
    created() {
        this.fetchCustomer();
    },
    methods: {
        fetchCustomer() {
            axios
                .get(`/api/customers/${this.$route.params.id}`)
                .then((response) => {
                    this.form.fill(response.data);
                })
                .catch((error) => {
                    console.error("Error fetching customer data:", error);
                });
        },
        submitForm() {
            this.form
                .put(`/api/customers/${this.$route.params.id}`)
                .then((response) => {
                    swal.fire({
                        title: "Success!",
                        text: "Customer updated successfully.",
                        icon: "success",
                    });
                    this.$router.push({ name: "customers" });
                })
                .catch((error) => {
                    console.error("Error updating customer:", error);
                });
        },
        cancel() {
            this.$router.push({ name: "customers" });
        },
    },
};
</script>

<style scoped>
.form-control {
    margin-bottom: 10px;
}
</style>
