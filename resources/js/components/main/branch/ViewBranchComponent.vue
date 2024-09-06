<template>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h4>Branch Overview</h4></div>
                <div class="card-body">
                    <data-table
                        :columns="columns"
                        :dataSource="branchData"
                        @limitChanged="
                            (limit) => {
                                getQueryLimit(limit);
                            }
                        "
                        @paginationChanged="
                            (page) => {
                                getAllBranchData(page);
                            }
                        "
                        @keywordSearched="
                            (keyword) => {
                                getSpecificBranch(keyword);
                            }
                        "
                    >
                        <template v-slot:tbody="{ item: { item } }">
                            <td scope="row">{{ item.id }}</td>
                            <td scope="row">{{ item.code }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.address }}</td>
                            <td>
                                <ul class="m-0 p-0 mb-1">
                                    <li
                                        v-for="phone in item.phones"
                                        :key="phone.id"
                                    >
                                        <a :href="`tel:${phone.number}`">
                                            {{ phone.type | nameStandard }} -
                                            {{ phone.number }}
                                        </a>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <a href="#" @click="showUpdateBranch(item)"
                                    ><i
                                        class="
                                            fa fa-edit
                                            icon-button
                                            text-primary
                                        "
                                    ></i
                                ></a>
                            </td>
                        </template>
                    </data-table>
                </div>
            </div>
        </div>

        <!-- update branch details start -->
        <!-- Modal -->
        <div
            class="modal fade"
            id="update_branch"
            ref="update_branch"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modelTitleId"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Branch Data</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-8">
                                <label for="">Branch Name:</label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Type Branch Name"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('name')"
                                    v-html="form.errors.get('name')"
                                />
                            </div>
                            <div class="col-4">
                                <label for="">Branch Code:</label>
                                <input
                                    v-model="form.code"
                                    type="text"
                                    class="form-control"
                                    placeholder="Type Branch Code"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('code')"
                                    v-html="form.errors.get('code')"
                                />
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-8">
                                <label for="">Branch Address:</label>
                                <input
                                    v-model="form.address"
                                    type="textarea"
                                    placeholder="Type Branch Address"
                                    class="form-control"
                                />
                                <div
                                    class="invalid-feedback"
                                    v-if="form.errors.has('address')"
                                    v-html="form.errors.get('address')"
                                />
                            </div>
                        </div>
                        <div
                            class="row mb-1"
                            v-for="(phone, index) in form.phones"
                            :key="index"
                        >
                            <div class="col-8">
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <label for="">Phone Type</label>
                                        <input
                                            v-model="phone.type"
                                            type="text"
                                            placeholder="Ex:Front-Office, Manager"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    `phones.${index}.type`
                                                ),
                                            }"
                                        />

                                        <div
                                            class="invalid-feedback"
                                            v-if="
                                                form.errors.has(
                                                    `phones.${index}.type`
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    `phones.${index}.type`
                                                )
                                            "
                                        />
                                    </div>
                                    <div class="col-6">
                                        <label for="">Phone Number</label>
                                        <input
                                            v-model="phone.number"
                                            type="text"
                                            placeholder="Ex: +94 #########"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    `phones.${index}.number`
                                                ),
                                            }"
                                        />

                                        <div
                                            class="invalid-feedback"
                                            v-if="
                                                form.errors.has(
                                                    `phones.${index}.number`
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    `phones.${index}.number`
                                                )
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="row mt-4">
                                    <div class="col-4 ml-1">
                                        <button
                                            @click="
                                                removePhoneNumberRow(
                                                    index,
                                                    phone
                                                )
                                            "
                                            class="
                                                btn btn-danger
                                                mt-4
                                                cursor-pointer
                                            "
                                            style="border-radius: 5px"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="col-4 mr-1">
                                        <button
                                            v-if="
                                                form.phones.length == index + 1
                                            "
                                            @click="addPhoneNumberRow"
                                            class="
                                                btn btn-success
                                                mt-4
                                                cursor-pointer
                                            "
                                            style="border-radius: 5px"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            @click="updateBranchDetails"
                            type="button"
                            class="btn btn-primary"
                        >
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- update branch details End -->
    </div>
</template>

<script>
export default {
    mounted() {
        $(this.$refs.update_branch).on("hidden.bs.modal", () => {
            this.form.reset();
            this.form.clear();
        });
    },
    data() {
        return {
            //data table
            branchData: {},
            keyword: "",
            limit: "",
            columns: [
                { name: "ID", sortName: "id", sortVal: "asc" },
                { name: "Branch Code", sortName: "code", sortVal: "asc" },
                { name: "Branch Name", sortName: "name", sortVal: "asc" },
                { name: "Address" },
                { name: "Telephones" },
                { name: "Action" },
            ],

            form: new Form({
                id: "",
                name: "",
                address: "",
                code: "",
                phones: [{ id: "", number: "", type: "" }],
            }),
        };
    },
    methods: {
        getQueryLimit(limit) {
            this.limit = limit;
            this.getAllBranchData();
        },

        getSpecificBranch(keyword) {
            this.keyword = keyword;
            this.getAllBranchData();
        },

        getAllBranchData(page = 1) {
            axios
                .get("/api/branch", {
                    params: {
                        page,
                        keyword: this.keyword,
                        limit: this.limit,
                    },
                })
                .then((response) => {
                    if (response.status == 200) {
                        this.branchData = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showUpdateBranch(branch) {
            let item = Object.create(branch);

            if (branch.phones.length == 0) {
                item.phones.push({ id: null, number: "", type: "" });
            }
            this.form.fill(item);
            $("#update_branch").modal("show");
        },

        addPhoneNumberRow() {
            this.form.phones.push({ id: null, number: "", type: "" });
        },

        removePhoneNumberRow(index, phone) {
            if (phone.id == null) {
                return this.form.phones.splice(index, 1);
            }

            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/api/branch/${phone.id}`, {
                            params: {
                                only: "number",
                            },
                        })
                        .then((response) => {
                            if (response.status == 200) {
                                swal.fire(
                                    "Deleted!",
                                    response.data.message,
                                    "success"
                                );
                                this.form.phones.splice(index, 1);
                            }
                        })
                        .catch((error) => {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: error.response.data.message,
                            });
                        });
                }
            });
        },

        updateBranchDetails() {
            this.form
                .patch(`/api/branch/${this.form.id}`)
                .then((response) => {
                    if (response.status == 200) {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                        this.getAllBranchData();
                        $("#update_branch").modal("hide");
                    }
                })
                .catch((error) => {
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.response.data.message,
                    });
                });
        },
    },
};
</script>

<style></style>
