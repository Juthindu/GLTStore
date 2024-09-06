<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Create New Order</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
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

                    <div class="form-group">
                        <label for="customer_email">Customer Email:</label>
                        <input
                            v-model="form.customer_email"
                            type="email"
                            class="form-control"
                            placeholder="Enter customer email"
                            :class="{ 'is-invalid': form.errors.has('customer_email') }"
                        />
                        <div
                            class="invalid-feedback"
                            v-if="form.errors.has('customer_email')"
                            v-html="form.errors.get('customer_email')"
                        />
                    </div>

                    <div class="form-group">
                        <label for="items">Select Items:</label>
                        <div v-for="(item, index) in form.items" :key="index" class="row align-items-center mb-3">
                            <div class="col-6">
                                <select
                                    v-model="item.inventory_item_id"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`items.${index}.inventory_item_id`) }"
                                >
                                    <option value="">Select item</option>
                                    <option v-for="inventoryItem in inventoryItems" :key="inventoryItem.id" :value="inventoryItem.id">
                                        {{ inventoryItem.name }} (Stock: {{ inventoryItem.quantity }})
                                    </option>
                                </select>
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has(`items.${index}.inventory_item_id`)"
                                    v-html="form.errors.get(`items.${index}.inventory_item_id`)"
                                />
                            </div>
                            <div class="col-3">
                                <input
                                    v-model="item.quantity"
                                    type="number"
                                    class="form-control"
                                    placeholder="Quantity"
                                    :class="{ 'is-invalid': form.errors.has(`items.${index}.quantity`) }"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has(`items.${index}.quantity`)"
                                    v-html="form.errors.get(`items.${index}.quantity`)"
                                />
                            </div>
                            <div class="col-3">
                                <button
                                    v-if="form.items.length > 1"
                                    @click="removeItem(index)"
                                    class="btn btn-danger"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                        <button @click="addItem" class="btn btn-primary">Add Item</button>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button type="button" @click="submitForm" class="btn btn-primary">
                            Submit Order
                        </button>
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
            form: new Form({
                customer_name: '',
                customer_email: '',
                items: [
                    {
                        inventory_item_id: '',
                        quantity: 1
                    }
                ],
            }),
        };
    },
    created() {
        this.fetchInventoryItems();
    },
    methods: {
        fetchInventoryItems() {
            axios.get('/api/inventory')
                .then(response => {
                    this.inventoryItems = response.data;
                })
                .catch(error => {
                    console.error('Error fetching inventory items:', error);
                });
        },
        addItem() {
            this.form.items.push({ inventory_item_id: '', quantity: 1 });
        },
        removeItem(index) {
            this.form.items.splice(index, 1);
        },
        submitForm() {
            swal.fire({
                title: "Are you sure?",
                text: "You want to create this order!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Create it!",
            }).then(result => {
                if (result.isConfirmed) {
                    this.form.post('/api/orders')
                        .then(response => {
                            if (response.status == 200) {
                                swal.fire("Success!", "Order created successfully.", "success");
                                this.form.reset();
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });
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
