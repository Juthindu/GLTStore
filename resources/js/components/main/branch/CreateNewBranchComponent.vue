<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5>New Branch</h5></div>
                <div class="card-body mb-2">
                    <div class="row mt-2">
                        <div class="col-8">
                            <label for="">Branch Name:</label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                placeholder="Type Branch Name"
                                :class="{
                                    'is-invalid': form.errors.has('name'),
                                }"
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
                                :class="{
                                    'is-invalid': form.errors.has('code'),
                                }"
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
                                :class="{
                                    'is-invalid': form.errors.has('address'),
                                }"
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
                        v-for="(input, index) in form.phones"
                        :key="index"
                    >
                        <div class="col-8">
                            <div class="row mt-4">
                                <div class="col-6">
                                    <label for="">Phone Type</label>
                                    <input
                                        v-model="input.type"
                                        type="text"
                                        class="form-control"
                                        placeholder="Ex:Front-Office, Manager"
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
                                        v-model="input.number"
                                        type="text"
                                        class="form-control"
                                        placeholder="Ex: 077#######"
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
                                <div class="col-3 ml-0">
                                    <button
                                        v-show="form.phones.length > 1"
                                        @click="removePhoneNumberRow(index)"
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
                                <div class="col-3 mr-o">
                                    <button
                                        v-if="form.phones.length == index + 1"
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
    created() {},
    data() {
        return {

            form: new Form({
                name: "",
                address: "",
                code: "",
                phones: [{ number: "", type: "" }],
            }),
        };
    },
    methods: {
        addPhoneNumberRow() {
            this.form.phones.push({ number: "", type: "" });
        },
        removePhoneNumberRow(index) {
            this.form.phones.splice(index, 1);
        },
        submitForm() {
            swal.fire({
                title: "Are you sure?",
                text: "You want to create this branch!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Create it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form
                        .post("/api/branch")

                        .then((response) => {
                            if (response.status == 200) {
                                swal.fire(
                                    "Success!",
                                    "Branch Created Successfull.",
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
