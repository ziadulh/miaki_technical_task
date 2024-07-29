<template>
    <div>
        <AppLayout>
            <template v-slot:main_content>
                <div class="row">
                    <div class="text-center">
                        <h3>{{ form.title }}</h3>
                    </div>
                    <div class="col-md-12">
                        <form :action="form.action" :method="form.method" @submit.prevent="submit">
                            <span v-for="field in form.fields">
                                <InputElement :inputElement="field"></InputElement>
                            </span>
                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                        </form>
                    </div>
                </div>
            </template>
        </AppLayout>
    </div>
</template>

<script>
// Import the child component
import AppLayout from './AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import InputElement from './InputElement.vue'

export default {
    name: 'ViewForm',
    components: {
        AppLayout, InputElement
    },
    props: {
        form: Object
    },
    mounted() {
        this.form.fields = JSON.parse(this.form.fields)
    },
    
};
</script>

<style scoped>
</style>