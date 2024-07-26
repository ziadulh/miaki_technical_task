<!-- ParentComponent.vue -->
<template>
    <div>
        <AppLayout>
            <template v-slot:main_content>
                <div class="row">
                    <div v-if="showList">
                        <button class="float-end m-2 btn btn-primary" @click="AddNewField()">List</button>
                    </div>
                    <div v-if="!showList">
                        <button class="float-end m-2 btn btn-primary" @click="AddNewField()">Add New</button>
                    </div>
                </div>
                <div class="row">
                    <!-- <form action="/input-field" method="post" v-if="showList" @submit.prevent="submit"> -->
                    <form v-if="showList" @submit.prevent="submit">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Type</span>
                            <select class="form-select" id="inputGroupSelect02" v-model="formData.type">
                                <option value="Text">Text</option>
                                <option value="Select">Select</option>
                                <option value="CheckBox">CheckBox</option>
                                <option value="TextArea">TextArea</option>
                                <option value="Radio">Radio</option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
                            <input v-model="formData.name" type="text" class="form-control"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Label</span>
                            <input v-model="formData.label" type="text" class="form-control"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Placeholder</span>
                            <input v-model="formData.placeholder" type="text" class="form-control"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
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
                    <table class="table table-sm" v-if="!showList">
                        <thead>
                            <tr>
                                <th scope="col">Type</th>
                                <th scope="col">Name</th>
                                <th scope="col">Label</th>
                                <th scope="col">PlaceHolder</th>
                                <th scope="col">Required</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="input in inputs">
                                <td scope="row">{{ input.type }}</td>
                                <td>{{ input.name }}</td>
                                <td>{{ input.label }}</td>
                                <td>{{ input.placeholder }}</td>
                                <td>{{ input.required ? 'true' : 'false' }}</td>
                                <td>
                                    <Link :href="'/input-field/'+input.id" class="btn btn-info" >Edit</Link>
                                    <button class="btn btn-danger mx-2" @click="DeleteField(input.id)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>
        </AppLayout>
    </div>
</template>

<script>
// Import the child component
import AppLayout from './AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3'

export default {
    name: 'Welcome',
    components: {
        AppLayout, Link
    },
    props: {
        inputs: Array
    },
    data() {
        return {
            showList: true,
            formData: {
                type: 'Text',
                name: null,
                label: null,
                placeholder: null,
                required: '1'
            }
        }
    },
    methods: {
        AddNewField() {
            this.showList = !this.showList;
        },
        submit() {
            var _this = this;
            if(this._checkInput()){
                Inertia.post('/input-field', _this.formData);
            }
        },

        DeleteField(id) {
            if(confirm('Are you sure! ')){
                Inertia.delete('/input-field/'+id);
            }
        },

        _checkInput(){
            var flag = true;
            if (!this.formData.name) {
                flag = false;
            }
            if (!this.formData.label) {
                flag = false;
            }
            if (!this.formData.placeholder) {
                flag = false;
            }
            return flag;
        }
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>