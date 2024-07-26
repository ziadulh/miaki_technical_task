<!-- ParentComponent.vue -->
<template>
    <div>
        <AppLayout>
            <template v-slot:main_content>
                <h2>Custom Header Content</h2>
            </template>
        </AppLayout>
    </div>
</template>

<script>
// Import the child component
import AppLayout from './AppLayout.vue';

export default {
    name: 'Welcome',
    components: {
        AppLayout,
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>