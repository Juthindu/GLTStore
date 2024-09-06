<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Adjust Stock</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="item-select">Select Item:</label>
                        <select
                            v-model="selectedItemId"
                            @change="fetchItemDetails"
                            class="form-control"
                        >
                            <option value="" disabled>Select an item</option>
                            <option
                                v-for="item in inventoryItems"
                                :key="item.id"
                                :value="item.id"
                            >
                                {{ item.name }} ({{ item.code }})
                            </option>
                        </select>
                    </div>

                    <div v-if="selectedItem">
                        <div class="form-group mt-3">
                            <label for="current-quantity">Current Quantity:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="selectedItem.quantity"
                                disabled
                            />
                        </div>

                        <div class="form-group mt-3">
                            <label for="adjust-quantity">Adjust Quantity:</label>
                            <input
                                v-model.number="adjustmentQuantity"
                                type="number"
                                class="form-control"
                                placeholder="Enter quantity to adjust"
                            />
                        </div>

                        <div class="form-group mt-3">
                            <label for="adjustment-type">Adjustment Type:</label>
                            <select
                                v-model="adjustmentType"
                                class="form-control"
                            >
                                <option value="increase">Increase</option>
                                <option value="decrease">Decrease</option>
                            </select>
                        </div>

                        <div class="form-group mt-4">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="adjustStock"
                            >
                                Adjust Stock
                            </button>
                        </div>
                    </div>
                    <div v-else class="mt-4">
                        <p>Please select an item to adjust its stock.</p>
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
            inventoryItems: [],
            selectedItemId: null,
            selectedItem: null,
            adjustmentQuantity: 0,
            adjustmentType: "increase",
        };
    },
    created() {
        this.fetchInventoryItems();
    },
    methods: {
        fetchInventoryItems() {
            axios
                .get("/api/inventory")
                .then((response) => {
                    this.inventoryItems = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching inventory items:", error);
                });
        },
        fetchItemDetails() {
            if (this.selectedItemId) {
                axios
                    .get(`/api/inventory/${this.selectedItemId}`)
                    .then((response) => {
                        this.selectedItem = response.data;
                    })
                    .catch((error) => {
                        console.error("Error fetching item details:", error);
                    });
            }
        },
        adjustStock() {
            if (!this.adjustmentQuantity || this.adjustmentQuantity <= 0) {
                alert("Please enter a valid quantity to adjust.");
                return;
            }

            const adjustment = {
                quantity: this.adjustmentQuantity,
                type: this.adjustmentType,
            };

            axios
                .post(`/api/inventory/${this.selectedItemId}/adjust`, adjustment)
                .then((response) => {
                    this.selectedItem.quantity = response.data.updatedQuantity;
                    alert("Stock adjusted successfully.");
                })
                .catch((error) => {
                    console.error("Error adjusting stock:", error);
                });
        },
    },
};
</script>

<style scoped>
.form-group {
    margin-bottom: 20px;
}
</style>
