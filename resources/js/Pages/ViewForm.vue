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
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">{{field.name}}</span>
                                    <input :type="field.type" class="form-control"
                                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
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

export default {
    name: 'ViewForm',
    components: {
        AppLayout,
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