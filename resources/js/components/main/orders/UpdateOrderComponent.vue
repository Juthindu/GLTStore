<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Update Order</h5>
                </div>
                <div class="card-body">
                    <form @submit.prevent="updateOrder">
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="order_id">Order ID:</label>
                                <input
                                    v-model="form.order_id"
                                    type="text"
                                    class="form-control"
                                    readonly
                                />
                            </div>
                            <div class="col-6">
                                <label for="customer_name">Customer Name:</label>
                                <input
                                    v-model="form.customer_name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter customer name"
                                    :class="{ 'is-invalid': form.errors.has('customer_name') }"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('customer_name')"
                                    v-html="form.errors.get('customer_name')"
                                />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <label for="product">Product:</label>
                                <input
                                    v-model="form.product"
                                    type="text"
                                    class="form-control"
                                    readonly
                                />
                            </div>
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
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <label for="status">Order Status:</label>
                                <select
                                    v-model="form.status"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('status') }"
                                >
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('status')"
                                    v-html="form.errors.get('status')"
                                />
                            </div>
                            <div class="col-6">
                                <label for="price">Total Price:</label>
                                <input
                                    v-model="form.total_price"
                                    type="number"
                                    class="form-control"
                                    readonly
                                />
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12 text-right">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    @click="cancelUpdate"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-primary col-2"
                                >
                                    Update Order
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
                order_id: "",
                customer_name: "",
                product: "",
                quantity: 0,
                status: "pending",
                total_price: 0,
            }),
        };
    },
    created() {
        this.loadOrder();
    },
    methods: {
        loadOrder() {
            axios
                .get(`/api/orders/${this.$route.params.id}`)
                .then((response) => {
                    this.form.fill(response.data);
                })
                .catch((error) => {
                    console.error("Error loading order:", error);
                });
        },
        updateOrder() {
            axios
                .put(`/api/orders/${this.form.order_id}`, this.form)
                .then((response) => {
                    swal.fire(
                        "Updated!",
                        "Order has been updated successfully.",
                        "success"
                    );
                    this.$router.push({ name: "orders" });
                })
                .catch((error) => {
                    console.error("Error updating order:", error);
                });
        },
        cancelUpdate() {
            this.$router.push({ name: "orders" });
        },
    },
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
