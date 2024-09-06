<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Customer</h5>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="customer_name">Customer Name:</label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                placeholder="Enter customer name"
                                :class="{ 'is-invalid': form.errors.has('name') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('name')"
                                v-html="form.errors.get('name')"
                            />
                        </div>
                        <div class="col-6">
                            <label for="customer_email">Email:</label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="form-control"
                                placeholder="Enter customer email"
                                :class="{ 'is-invalid': form.errors.has('email') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('email')"
                                v-html="form.errors.get('email')"
                            />
                        </div>
                    </div>

                    <div class="row mt-4">
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
                        <div class="col-6">
                            <label for="address">Address:</label>
                            <input
                                v-model="form.address"
                                type="text"
                                class="form-control"
                                placeholder="Enter address"
                                :class="{ 'is-invalid': form.errors.has('address') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('address')"
                                v-html="form.errors.get('address')"
                            />
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-secondary">
                                Cancel
                            </button>
                            <button
                                type="button"
                                @click="submitForm"
                                class="btn btn-primary col-2"
                            >
                                Submit
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
                email: "",
                phone: "",
                address: "",
            }),
        };
    },
    methods: {
        submitForm() {
            swal.fire({
                title: "Are you sure?",
                text: "You want to add this customer!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Add it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form
                        .post("/api/customers/store")
                        .then((response) => {
                            if (response.status == 200) {
                                swal.fire(
                                    "Success!",
                                    "Customer added successfully.",
                                    "success"
                                );
                                this.form.clear();
                                this.form.reset();
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            });
        },
    },
};
</script>

<style scoped>
/* Add any custom styles if needed */
</style>
