<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Order List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orders" :key="order.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ order.order_id }}</td>
                                <td>{{ order.customer_name }}</td>
                                <td>{{ order.total | currency }}</td>
                                <td>
                                    <span :class="statusClass(order.status)">
                                        {{ order.status }}
                                    </span>
                                </td>
                                <td>{{ order.date | formatDate }}</td>
                                <td>
                                    <button
                                        @click="viewOrder(order.id)"
                                        class="btn btn-sm btn-info"
                                    >
                                        View
                                    </button>
                                    <button
                                        v-if="order.status !== 'Delivered'"
                                        @click="markAsDelivered(order.id)"
                                        class="btn btn-sm btn-success"
                                    >
                                        Mark as Delivered
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!orders.length">
                                <td colspan="7" class="text-center">No orders found.</td>
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
            orders: [],
        };
    },
    created() {
        this.fetchOrders();
    },
    methods: {
        fetchOrders() {
            axios
                .get("/api/orders")
                .then((response) => {
                    this.orders = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching orders:", error);
                });
        },
        viewOrder(id) {
            this.$router.push({ name: "orders.view", params: { id } });
        },
        markAsDelivered(id) {
            if (confirm("Are you sure you want to mark this order as delivered?")) {
                axios
                    .put(`/api/orders/${id}/deliver`)
                    .then(() => {
                        const order = this.orders.find((order) => order.id === id);
                        order.status = "Delivered";
                        alert("Order marked as delivered.");
                    })
                    .catch((error) => {
                        console.error("Error marking order as delivered:", error);
                    });
            }
        },
        statusClass(status) {
            return {
                'badge badge-primary': status === 'Pending',
                'badge badge-warning': status === 'Processing',
                'badge badge-success': status === 'Delivered',
            };
        },
    },
    filters: {
        currency(value) {
            return `$${parseFloat(value).toFixed(2)}`;
        },
        formatDate(value) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(value).toLocaleDateString(undefined, options);
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
.badge {
    font-size: 0.9rem;
}
</style>
