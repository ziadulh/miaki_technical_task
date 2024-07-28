<!-- ParentComponent.vue -->
<template>
    <div>
        <AppLayout>
            <template v-slot:main_content>
                <div class="row" v-if="initData.showList">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-3">
                        <input type="text" name="title" v-model="initData.formData.title" placeholder="Title">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="method" v-model="initData.formData.method" placeholder="Method">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="action" v-model="initData.formData.action" placeholder="Action">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" @click="UpdateFormData(form.id)">Submit</button>
                    </div>
                </div>
                <div class="containerTemp" v-if="initData.showList">
                    <div class="left-panel" @dragover.prevent @drop="dropInLeftPanel">
                        <div v-for="(field, index) in initData.fields" :key="field.id" class="draggable-item" draggable="true"
                            @dragstart="dragStart(field, 'left', index)">
                            {{ field.label }}
                        </div>
                    </div>
                    <div class="right-panel" @dragover.prevent @drop="dropInRightPanel">
                        <div v-for="(field, index) in initData.droppedFields" :key="field.id" class="draggable-item"
                            draggable="true" @dragstart="onDragStart(index)" @dragover.prevent
                            @dragenter="onDragEnter(index)" @dragend="onDragEnd">
                            <FieldType :fieldData="field" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-sm" v-if="!initData.showList">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Method</th>
                                <th scope="col">Form Action</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="form in props.forms">
                                <td scope="row">{{ form.title }}</td>
                                <td>{{ form.method }}</td>
                                <td>{{ form.action }}</td>
                                <!-- <td><button class="btn btn-primary" type="button" @click="ViewForm()">View</button></td> -->
                                <td>
                                    <Link class="btn btn-primary" :href="'form-builder/' + form.id">View</Link>
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
// Import the child component
import { defineComponent, ref, reactive } from 'vue';
import AppLayout from './AppLayout.vue';
import FieldType from './FieldType.vue'
import { Inertia } from '@inertiajs/inertia';

import { Link } from '@inertiajs/vue3'
import axios from 'axios';
// Import Toastr CSS
import 'toastr/build/toastr.min.css';
// Import Toastr JS
import toastr from 'toastr';

// Define interfaces for the form data and inputs
export interface initData {
    showList: boolean,
    fields: Array<Object>,
    droppedFields: Array<Object>,
    draggedField: Object,
    dragSource: String | null,
    dragStartIndex: Number | null,
    dragIndex: Number | null,
    formData: {
        title: String,
        method: String,
        action: String,
        fields: Array<Object> | String
    }
}

export interface FormErrors {
    title?: string;
    method?: string;
    action?: String,
    fields?: String
}

export default {
    name: 'Welcome',
    components: {
        AppLayout, FieldType, Link
    },
    props: {
        inputs: Array,
        form: Object
    },
    setup(props) {

        const initData = reactive<initData>({
            showList: true,
            fields: [],
            droppedFields: [],
            draggedField: {},
            dragSource: null,
            dragStartIndex: 0,
            dragIndex: 0,
            formData: {
                title: '',
                method: '',
                action: '',
                fields: []
            }
        });

        var left_array = [];
        var right_array = [];

        (JSON.parse(props.form.fields)).forEach(el => {
            props.inputs.forEach(iel => {
                if (el.id == iel.id) {
                    right_array.push({
                        id: el.id,
                        name: el.name,
                        type: el.type,
                        label: el.label,
                        placeholder: el.placeholder,
                        required: el.required
                    });
                }
            })
        });

        (JSON.parse(props.form.fields)).forEach(el => {
            props.inputs.forEach(iel => {
                if (el.id != iel.id) {
                    left_array.push({
                        id: iel.id,
                        name: iel.name,
                        type: iel.type,
                        label: iel.label,
                        placeholder: iel.placeholder,
                        required: iel.required
                    });
                }
            })
        });

        const errors = reactive<FormErrors>({});

        initData.fields = left_array;
        initData.droppedFields = right_array;

        initData.formData = {
            title: props.form.title,
            method: props.form.method,
            action: props.form.action,
            fields: props.droppedFields
        }

        const dragStart = (field: Object, source: String, index: Number) => {
            initData.draggedField = field;
            initData.dragSource = source;
            initData.dragStartIndex = null;

        };

        const dropInRightPanel = () => {
            if (initData.dragSource === 'left') {
                initData.droppedFields.push(initData.draggedField);
                initData.fields.splice(Number(initData.dragStartIndex), 1);
            } else if (initData.dragSource === 'right') {
                const draggedItem = initData.droppedFields.splice(Number(initData.dragStartIndex), 1)[0];
                initData.droppedFields.push(draggedItem);
            }
            resetDrag();
        };

        const dropInLeftPanel = () => {
            if (initData.dragSource === 'right') {
                initData.fields.push(initData.draggedField);
                initData.droppedFields.splice(Number(initData.dragStartIndex), 1);
            }
            resetDrag();
        };

        const onDragStart = (index: Number) => {
            initData.dragIndex = index;
        };

        const onDragEnter = (index: Number) => {
            if (index !== initData.dragIndex) {
                const temp = initData.droppedFields.splice(Number(initData.dragIndex), 1)[0];
                initData.droppedFields.splice(Number(index), 0, temp);
                initData.dragIndex = index;
            }
        };

        const onDragEnd = () => {
            initData.dragIndex = null;
        };

        const resetDrag = () => {
            initData.draggedField = {};
            initData.dragSource = null;
            initData.dragStartIndex = null;
        };

        const AddNewField = () => {
            initData.showList = !initData.showList;
        };

        const UpdateFormData = (id: Number) => {
            var _this = initData;
            initData.formData.fields = JSON.stringify(_this.droppedFields);
            if (checkInput()) {
                axios.post('/form-builder/' + id + '/update', initData.formData)
                    .then((res) => {
                        toastr.success(res.data.msg, 'Success')
                    })
                    .catch(error => {
                        toastr.error('Oops! Error', 'Error')
                    });
                // Inertia.post('/form-builder/' + id + '/update', _this.formData);
            }
        }
        const checkInput = () => {
            let isValid = true;
            errors.title = initData.formData.title ? '' : 'Title is required';
            errors.method = initData.formData.method ? '' : 'Method is required';
            errors.action = initData.formData.action ? '' : 'Action is required';
            errors.fields = initData.droppedFields.length <= 0 ? '' : 'Field is required';

            if (!initData.formData.title) {
                isValid = false;
                toastr.error(errors.title, 'Error')
            }
            if (!initData.formData.method) {
                isValid = false;
                toastr.error(errors.method, 'Error')
            }
            if (!initData.formData.action) {
                isValid = false;
                toastr.error(errors.action, 'Error')
            }
            console.log(initData.droppedFields.length);
            
            if ( initData.droppedFields.length <= 0) {
                isValid = false;
                toastr.error('Add at least one filed', 'Error')
            }
            return isValid;
        };

        const DeleteForm = (id: Number) => {
            if (confirm('Are you sure')) {
                Inertia.post('/form-builder/' + id + '/destroy');
            }
        };

        return {
            initData,
            dragStart,
            dropInRightPanel,
            dropInLeftPanel,
            onDragStart,
            onDragEnter,
            onDragEnd,
            resetDrag,
            AddNewField,
            UpdateFormData,
            checkInput,
            DeleteForm
        };
    }
};
</script>

<style scoped>
.containerTemp {
    display: flex;
    height: 80vh;
}

.left-panel {
    width: 20%;
    background-color: #f8f8f8;
    border-right: 1px solid #ddd;
    padding: 10px;
    overflow-y: auto;
}

.right-panel {
    width: 80%;
    background-color: #fff;
    padding: 10px;
    overflow-y: auto;
}

.draggable-item {
    padding: 10px;
    margin: 5px;
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    cursor: move;
}
</style>
