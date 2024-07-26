<template>
    <div>
        <input :type="fieldData.type" :name="fieldData.name" :placeholder="fieldData.placeholder">
    </div>
</template>

<script>

export default {
    name: 'FieldType',
    props: {
        fieldData: Object
    }
};
</script>

<style scoped>
</style>
