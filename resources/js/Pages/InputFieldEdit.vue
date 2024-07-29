<!-- ParentComponent.vue -->
<template>
    <div>
        <AppLayout>
            <template v-slot:main_content>
                <div class="row">
                    <form v-if="showList" @submit.prevent="submit">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Type</span>
                            <select class="form-select" id="inputGroupSelect02" v-model="formData.type">
                                <option value="text">Text</option>
                                <option value="email">Email</option>
                                <option value="password">Password</option>
                                <option value="select">Select</option>
                                <option value="checkbox">CheckBox</option>
                                <option value="textarea">TextArea</option>
                                <option value="radio">Radio</option>
                            </select>
                        </div>
                        <div v-if="formData.type == 'select'" class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Enter Options <sub> (option must seperate with comma)</sub></span>
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
                </div>
            </template>
        </AppLayout>
    </div>
</template>

<script lang="ts">

import { defineComponent, ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
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
    options: String|null
}

export interface FormErrors {
    name?: string;
    label?: string;
    placeholder?: string;
}

export default {
    name: 'InputFieldEdit',
    components: {
        AppLayout,
    },
    props: {
        field: Object
    },
    setup(props, { emit }) {
        const showList = ref(true);
        const formData = reactive<FormData>({
            type: props.field.type,
            name: props.field.name,
            label: props.field.label,
            placeholder: props.field.placeholder,
            required: props.field.required,
            options: props.field.options,
        });
        const errors = reactive<FormErrors>({});

        const validateForm = (): boolean => {
            let isValid = true;
            errors.name = formData.name ? '' : 'Name is required';
            errors.label = formData.label ? '' : 'Label is required';
            errors.placeholder = formData.placeholder ? '' : 'Placeholder is required';

            if (!formData.name || !formData.label || !formData.placeholder) {
                isValid = false;
            }

            return isValid;
        };

        const submit = () => {
            if (validateForm()) {
                axios.post('/input-field/'+props.field.id , formData)
                    .then((res) => {
                        toastr.success(res.data.msg, 'Success')
                        emit('update:inputs', res.data.inputs);
                    })
                    .catch(error => {
                        toastr.error('Oops! Error', 'Error')
                    });
                // Inertia.post('/input-field', formData);
            }
        };

        return {
            showList,
            formData,
            errors,
            submit,
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
    //         if(this._checkInput()){
    //             Inertia.post('/input-field/'+this.field.id , _this.formData);
    //         }
    //     },
    //     _checkInput(){
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

    // mounted() {
    //     this.formData = {
    //         type: this.field.type,
    //         name: this.field.name,
    //         label: this.field.label,
    //         placeholder: this.field.placeholder,
    //         required: this.field.required
    //     }
    // },
};
</script>

<style scoped>
/* Add your styles here */
</style>