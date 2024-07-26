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
                                <option value="select">Select</option>
                                <option value="checkbox">CheckBox</option>
                                <option value="textarea">TextArea</option>
                                <option value="radio">Radio</option>
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
                </div>
            </template>
        </AppLayout>
    </div>
</template>

<script>
// Import the child component
import AppLayout from './AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    name: 'Welcome',
    components: {
        AppLayout,
    },
    props: {
        field: Array
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
                Inertia.post('/input-field/'+this.field.id , _this.formData);
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

    mounted() {
        this.formData = {
            type: this.field.type,
            name: this.field.name,
            label: this.field.label,
            placeholder: this.field.placeholder,
            required: this.field.required
        }
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>