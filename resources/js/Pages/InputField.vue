<!-- ParentComponent.vue -->
<template>
    <div>
        <AppLayout>
            <template v-slot:main_content>
                <div class="row">

                    <div>
                        <button class="float-end m-2 btn btn-primary" @click="toggleJson()">Toggle</button>
                    </div>

                    <div v-if="showList">
                        <button class="float-end m-2 btn btn-primary" @click="addNewField()">List</button>
                    </div>
                    <div v-if="!showList">
                        <button class="float-end m-2 btn btn-primary" @click="addNewField()">Add New</button>
                    </div>
                </div>
                <div class="row">
                    <!-- <form action="/input-field" method="post" v-if="showList" @submit.prevent="submit"> -->
                    <form v-if="showList && !tempData.isJson" @submit.prevent="submit">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Type</span>
                            <select class="form-select" id="inputGroupSelect02" v-model="formData.type">
                                <option value="text">Text</option>
                                <option value="email">Email</option>
                                <option value="password">Password</option>
                                <option value="select">Select</option>
                                <option value="checkbox">CheckBox</option>
                                <option value="radio">Radio</option>
                                <option value="textarea">TextArea</option>
                            </select>
                        </div>
                        <div v-if="formData.type == 'select'" class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Enter Options <sub> (option must
                                    seperate with comma)</sub></span>
                            <textarea class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" v-model="formData.options"></textarea>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
                            <input v-model="formData.name" type="text" class="form-control"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            <span class="text-danger">{{ errors.name }}</span>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Label</span>
                            <input v-model="formData.label" type="text" class="form-control"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            <span class="text-danger">{{ errors.label }}</span>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Placeholder</span>
                            <input v-model="formData.placeholder" type="text" class="form-control"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            <span class="text-danger">{{ errors.placeholder }}</span>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Required</span>
                            <select class="form-select" id="inputGroupSelect02" v-model="formData.required">
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                        </div>
                        <div><button type="submit" class="btn btn-primary float-end">Submit</button></div>
                    </form>
                    <form v-if="showList && tempData.isJson" @submit.prevent="submitJson">
                        <div class="input-group input-group-sm mb-3">
                            <label for="">Enter Data</label>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <textarea class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" v-model="tempData.jsonData"></textarea>
                        </div>
                        <div><button type="submit" class="btn btn-primary float-end">Submit</button></div>
                    </form>
                    <table class="table table-sm" v-if="!showList">
                        <thead>
                            <tr>
                                <th scope="col">Field</th>
                                <th scope="col">Type</th>
                                <th scope="col">Name</th>
                                <th scope="col">Label</th>
                                <th scope="col">PlaceHolder</th>
                                <th scope="col">Required</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="input in all_inputs">
                                <td>Input</td>
                                <td scope="row">{{ input.type }}</td>
                                <td>{{ input.name }}</td>
                                <td>{{ input.label }}</td>
                                <td>{{ input.placeholder }}</td>
                                <td>{{ input.required ? 'true' : 'false' }}</td>
                                <td>
                                    <Link :href="'/input-field/input/' + input.id" class="btn btn-info">Edit</Link>
                                    <button class="btn btn-danger mx-2" @click="deleteField('input', input.id)">Delete</button>
                                </td>
                            </tr>
                            <tr  v-for="json_inputs in all_json_inputs">
                                <td>Json</td>
                                <td scope="row">{{ JSON.parse(json_inputs.json_data).name }}</td>
                                <td>{{ JSON.parse(json_inputs.json_data).name }}</td>
                                <td>{{ JSON.parse(json_inputs.json_data).label }}</td>
                                <td>{{ JSON.parse(json_inputs.json_data).placeholder }}</td>
                                <td>{{ JSON.parse(json_inputs.json_data).required ? 'true' : 'false' }}</td>
                                <td>
                                    <Link :href="'/input-field/json_input/' + json_inputs.id" class="btn btn-info">Edit</Link>
                                    <button class="btn btn-danger mx-2" @click="deleteField('json_input', json_inputs.id)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>
        </AppLayout>
    </div>
</template>

<script lang="ts">

import { defineComponent, ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3'
import axios from 'axios';
// Import Toastr CSS
import 'toastr/build/toastr.min.css';
// Import Toastr JS
import toastr from 'toastr';
// Import the child component
import AppLayout from './AppLayout.vue';

// Define interfaces for the form data and inputs
export interface FormData {
    type: string;
    name: string | null;
    label: string | null;
    placeholder: string | null;
    required: string;
    options: String | null
}

export interface FormErrors {
    name?: string;
    label?: string;
    placeholder?: string;
}

export interface TempData {
    isJson: boolean,
    jsonData: string
}

export default {
    name: 'InputField',
    components: {
        AppLayout, Link
    },
    props: {
        inputs: Array,
        json_inputs: Array
    },
    setup(props, { emit }) {
        const showList = ref(true);
        const formData = reactive<FormData>({
            type: 'text',
            name: null,
            label: null,
            placeholder: null,
            required: '1',
            options: null,
        });

        const tempData = reactive<TempData>({
            isJson: false,
            jsonData: ''
        });

        const errors = reactive<FormErrors>({});

        const all_inputs = ref(props.inputs);
        const all_json_inputs = ref(props.json_inputs);

        const validateForm = (): boolean => {
            
            let isValid = true;

            if (isValidJson(tempData.jsonData) && Object.keys(JSON.parse(tempData.jsonData)).length != 0) {
                return isValid;
            }

            errors.name = formData.name ? '' : 'Name is required';
            errors.label = formData.label ? '' : 'Label is required';
            errors.placeholder = formData.placeholder ? '' : 'Placeholder is required';

            if (!formData.name || !formData.label || !formData.placeholder) {
                isValid = false;
            }

            return isValid;
        };

        const addNewField = () => {
            showList.value = !showList.value;
        };

        const submit = () => {
            if (validateForm()) {
                axios.post('/input-field', formData)
                    .then((res) => {
                        toastr.success(res.data.msg, 'Success')
                        all_inputs.value = res.data.inputs;
                    })
                    .catch(error => {
                        toastr.error('Oops! Error', 'Error')
                    });
                // Inertia.post('/input-field', formData);
            }
        };

        const submitJson = () => {
            if (validateForm()) {
                axios.post('/input-field', tempData)
                    .then((res) => {
                        toastr.success(res.data.msg, 'Success')
                        all_inputs.value = res.data.inputs;
                    })
                    .catch(error => {
                        toastr.error('Oops! Error', 'Error')
                    });
                // Inertia.post('/input-field', formData);
            }
        };

        const toggleJson = () => {
            tempData.isJson = !tempData.isJson;
        };

        const deleteField = (type: string, id: number) => {
            if (confirm('Are you sure!')) {
                axios.delete(`/input-field/${type}/${id}`)
                    .then((res) => {
                        toastr.success(res.data.msg, 'Success')
                        all_inputs.value = res.data.inputs;
                    })
                    .catch(error => {
                        toastr.error('Oops! Error', 'Error')
                    });
                // Inertia.delete(`/input-field/${id}`);
            }
        };

        const  isValidJson = (str: string) => {
            try {
                JSON.parse(str);
                return true;
            } catch (error) {
                return false;
            }
        }

        return {
            all_json_inputs,
            tempData,
            submitJson,
            showList,
            all_inputs,
            formData,
            errors,
            addNewField,
            submit,
            deleteField,
            toggleJson
        };
    },
    // data() {
    //     return {
    //         showList: true,
    //         formData: {
    //             type: 'Text',
    //             name: null,
    //             label: null,
    //             placeholder: null,
    //             required: '1'
    //         }
    //     }
    // },
    // methods: {
    //     AddNewField() {
    //         this.showList = !this.showList;
    //     },
    //     submit() {
    //         var _this = this;
    //         if (this._checkInput()) {
    //             Inertia.post('/input-field', _this.formData);
    //         }
    //     },

    //     DeleteField(id) {
    //         if (confirm('Are you sure! ')) {
    //             Inertia.delete('/input-field/' + id);
    //         }
    //     },

    //     _checkInput() {
    //         var flag = true;
    //         if (!this.formData.name) {
    //             flag = false;
    //         }
    //         if (!this.formData.label) {
    //             flag = false;
    //         }
    //         if (!this.formData.placeholder) {
    //             flag = false;
    //         }
    //         return flag;
    //     }
    // },
};
</script>

<style scoped>
/* Add your styles here */
</style>