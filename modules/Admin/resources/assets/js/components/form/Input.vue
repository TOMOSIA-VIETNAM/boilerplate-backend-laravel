<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <input
            :type="type"
            :id="id"
            :name="name"
            :value="value"
            :placeholder="placeholder"
            @input="$emit('update:value', $event.target.value)"
            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
            :required="required"
        />
    </div>
</template>

<script>
export default {
    props: {
        label: { type: String, required: true },
        id: { type: String, required: true },
        name: { type: String, required: true },
        type: { type: String, default: 'text' },
        value: { type: String, default: '' },
        placeholder: { type: String, default: '' },
        required: { type: Boolean, default: false }
    }
};
</script>
