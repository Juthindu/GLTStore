<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5>Add New Stock</h5></div>
                <div class="card-body mb-2">
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="item_name">Item Name:</label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                placeholder="Enter item name"
                                :class="{ 'is-invalid': form.errors.has('name') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('name')"
                                v-html="form.errors.get('name')"
                            />
                        </div>
                        <div class="col-6">
                            <label for="item_code">Item Code:</label>
                            <input
                                v-model="form.code"
                                type="text"
                                class="form-control"
                                placeholder="Enter item code"
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
                        <div class="col-6">
                            <label for="quantity">Quantity:</label>
                            <input
                                v-model="form.quantity"
                                type="number"
                                class="form-control"
                                placeholder="Enter quantity"
                                :class="{ 'is-invalid': form.errors.has('quantity') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('quantity')"
                                v-html="form.errors.get('quantity')"
                            />
                        </div>
                        <div class="col-6">
                            <label for="price">Price:</label>
                            <input
                                v-model="form.price"
                                type="number"
                                class="form-control"
                                placeholder="Enter price per unit"
                                :class="{ 'is-invalid': form.errors.has('price') }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="form.errors.has('price')"
                                v-html="form.errors.get('price')"
                            />
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="description">Description:</label>
                            <textarea
                                v-model="form.description"
                                class="form-control"
                                placeholder="Enter item description"
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
                code: "",
                quantity: "",
                price: "",
                description: ""
            }),
        };
    },
    methods: {
        submitForm() {
            swal.fire({
                title: "Are you sure?",
                text: "You want to add this stock!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Add it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form
                        .post("/api/inventory/store")
                        .then((response) => {
                            if (response.status == 200) {
                                swal.fire(
                                    "Success!",
                                    "Stock added successfully.",
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

<style></style>
