<template>
    <div>
        <div v-if="inputElement.type == 'text' || inputElement.type == 'password' || inputElement.type == 'email'"
            class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">{{ inputElement.name }}</span>
            <input :type="inputElement.type" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-sm">
        </div>
        <div v-if="inputElement.type == 'textarea'" class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">{{ inputElement.name }}</span>
            <textarea class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-sm"></textarea>
        </div>
        <div v-if="inputElement.type == 'checkbox'" class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">{{ inputElement.name }}</span>
            <div class="input-group-text">
                <input class="form-check-input mt-0" :type="inputElement.type"
                    aria-label="Checkbox for following text input">
            </div>
        </div>
        <div v-if="inputElement.type == 'radio'" class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">{{ inputElement.name }}</span>
            <div class="input-group-text">
                <input class="form-check-input mt-0" :type="inputElement.type"
                    aria-label="Checkbox for following text input">
            </div>
        </div>
        <div v-if="inputElement.type == 'select'" class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                <option v-for="item in (inputElement.options).split(',')" :value="item">{{item}}</option>
            </select>
            <label for="floatingSelect">Select One</label>
        </div>
    </div>
</template>

<script>

export default {
    name: 'InputElement',
    components: {
    },
    props: {
        inputElement: Object | String
    },
    mounted() {
    },

};
</script>

<style scoped></style>