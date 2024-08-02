<template>
    <div>
        <div>
            Label: {{ fieldData.label }} 
        </div>
        <div>
            Name: {{ fieldData.name }} 
        </div>
        <div>
            Type: {{ fieldData.type }} 
        </div>
        <div>
            Placeholder: {{ fieldData.placeholder }}
        </div>
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
