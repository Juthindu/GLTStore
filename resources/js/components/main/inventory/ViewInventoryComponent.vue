<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Inventory List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in inventoryItems" :key="item.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.code }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.price | currency }}</td>
                                <td>{{ item.description }}</td>
                                <td>
                                    <button
                                        @click="editItem(item.id)"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteItem(item.id)"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!inventoryItems.length">
                                <td colspan="7" class="text-center">No inventory items found.</td>
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
            inventoryItems: [],
        };
    },
    created() {
        this.fetchInventory();
            console.log('ViewInventoryComponent is created');
    this.fetchInventory();
    },
    methods: {
        fetchInventory() {
            axios
                .get("/api/inventory")
                .then((response) => {
                    this.inventoryItems = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching inventory:", error);
                });
        },
        editItem(id) {
            this.$router.push({ name: "inventory.edit", params: { id } });
        },
        deleteItem(id) {
            if (confirm("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/api/inventory/${id}`)
                    .then(() => {
                        this.inventoryItems = this.inventoryItems.filter(
                            (item) => item.id !== id
                        );
                        alert("Item deleted successfully.");
                    })
                    .catch((error) => {
                        console.error("Error deleting item:", error);
                    });
            }
        },
    },
    filters: {
        currency(value) {
            return `$${parseFloat(value).toFixed(2)}`;
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
