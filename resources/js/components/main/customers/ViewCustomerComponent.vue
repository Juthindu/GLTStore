<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Customer List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, index) in customers" :key="customer.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ customer.name }}</td>
                                <td>{{ customer.email }}</td>
                                <td>{{ customer.phone }}</td>
                                <td>{{ customer.address }}</td>
                                <td>
                                    <button
                                        @click="editCustomer(customer.id)"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteCustomer(customer.id)"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!customers.length">
                                <td colspan="6" class="text-center">No customers found.</td>
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
            customers: [],
        };
    },
    created() {
        this.fetchCustomers();
    },
    methods: {
        fetchCustomers() {
            axios
                .get("/api/customers")
                .then((response) => {
                    this.customers = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching customers:", error);
                });
        },
        editCustomer(id) {
            this.$router.push({ name: "customers.edit", params: { id } });
        },
        deleteCustomer(id) {
            if (confirm("Are you sure you want to delete this customer?")) {
                axios
                    .delete(`/api/customers/${id}`)
                    .then(() => {
                        this.customers = this.customers.filter(
                            (customer) => customer.id !== id
                        );
                        alert("Customer deleted successfully.");
                    })
                    .catch((error) => {
                        console.error("Error deleting customer:", error);
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
