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
                <div class="row" v-if="showList">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-3">
                        <input type="text" name="title" v-model="formData.title" placeholder="Title">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="method" v-model="formData.method" placeholder="Method">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="action" v-model="formData.action" placeholder="Action">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" @click="AddFormData()">Submit</button>
                    </div>
                </div>
                <div class="containerTemp" v-if="showList">
                    <div class="left-panel" @dragover.prevent @drop="dropInLeftPanel">
                        <div v-for="(field, index) in fields" :key="field.id" class="draggable-item" draggable="true"
                            @dragstart="dragStart(field, 'left', index)">
                            {{ field.label }}
                        </div>
                    </div>
                    <div class="right-panel" @dragover.prevent @drop="dropInRightPanel">
                        <div v-for="(field, index) in droppedFields" :key="field.id" class="draggable-item"
                            draggable="true" @dragstart="onDragStart(index)" @dragover.prevent
                            @dragenter="onDragEnter(index)" @dragend="onDragEnd">
                            <FieldType :fieldData="field" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-sm" v-if="!showList">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Method</th>
                                <th scope="col">Form Action</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="form in forms">
                                <td scope="row">{{ form.title }}</td>
                                <td>{{ form.method }}</td>
                                <td>{{ form.action }}</td>
                                <!-- <td><button class="btn btn-primary" type="button" @click="ViewForm()">View</button></td> -->
                                <td>
                                    <Link class="btn btn-primary" :href="'/form-builder/' + form.id">View</Link>
                                    <Link class="btn btn-info mx-2" :href="'/form-builder/' + form.id + '/show'">Edit</Link>
                                    <button class="btn btn-danger mx-2" @click="DeleteForm(form.id)">Delete</button>
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
import FieldType from './FieldType.vue'
import { Inertia } from '@inertiajs/inertia';

import { Link } from '@inertiajs/vue3'

export default {
    name: 'Welcome',
    components: {
        AppLayout, FieldType, Link
    },
    props: {
        inputs: Array,
        forms: Array
    },
    data() {
        return {
            showList: true,
            fields: [],
            droppedFields: [],
            draggedField: null,
            dragSource: null,
            dragStartIndex: null,
            dragIndex: null,
            formData: {
                title: null,
                method: null,
                action: null,
                fields: []
            }
        }
    },
    methods: {
        dragStart(field, source, index) {
            this.draggedField = field;
            this.dragSource = source;
            this.dragStartIndex = index;
        },
        dropInRightPanel() {
            if (this.dragSource === 'left') {
                this.droppedFields.push(this.draggedField);
                this.fields.splice(this.dragStartIndex, 1);
            } else if (this.dragSource === 'right') {
                const draggedItem = this.droppedFields.splice(this.dragStartIndex, 1)[0];
                this.droppedFields.push(draggedItem);
            }
            this.resetDrag();
        },
        dropInLeftPanel() {
            if (this.dragSource === 'right') {
                this.fields.push(this.draggedField);
                this.droppedFields.splice(this.dragStartIndex, 1);
            }
            this.resetDrag();
        },
        onDragStart(index) {
            this.dragIndex = index;
        },
        onDragEnter(index) {
            if (index !== this.dragIndex) {
                const temp = this.droppedFields.splice(this.dragIndex, 1)[0];
                this.droppedFields.splice(index, 0, temp);
                this.dragIndex = index;
            }
        },
        onDragEnd() {
            this.dragIndex = null;
        },
        resetDrag() {
            this.draggedField = null;
            this.dragSource = null;
            this.dragStartIndex = null;
        },

        AddNewField() {
            this.showList = !this.showList;
        },

        AddFormData() {
            var _this = this;
            _this.formData.fields = JSON.stringify(_this.droppedFields);
            if (_this._checkInput()) {
                Inertia.post('/form-builder', _this.formData);
            }
        },
        _checkInput() {
            var flag = true;
            return flag;
        },

        DeleteForm(id) {
            if (confirm('Are you sure')) {
                Inertia.post('/form-builder/' + id + '/destroy');
            }
        },

        ViewForm() {

        }
    },

    mounted() {
        var temp_arr = [];
        this.inputs.forEach(el => {
            temp_arr.push({
                id: el.id,
                name: el.name,
                type: el.type,
                label: el.label,
                placeholder: el.placeholder,
                required: el.required
            });
        });
        this.fields = temp_arr;
    },
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
