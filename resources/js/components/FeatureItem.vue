<template>
    <div class="flex w-full max-w-xs items-start space-x-4">
        <div class="flex-shrink-0">
            <img :src="icon" class="text-teal-600" />
        </div>
        <div>
            <h3 class="text-xl font-semibold text-gray-800">{{ title }}</h3>
            <p class="text-sm text-gray-600">{{ description }}</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    icon: String,
    title: String,
    description: String,
});
</script>
