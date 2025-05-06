<script setup>
defineProps({
    step: Number,
    title: String,
    description: String,
    linkText: String,
    linkHref: String,
});
</script>

<template>
    <div class="flex w-full max-w-xs flex-col items-start gap-2">
        <div class="flex items-center">
            <div class="flex flex-col gap-2">
                <div class="relative inline-block">
                    <img src="/images/step.png" alt="" class="size-fit" />
                    <p class="absolute top-2 left-3.5 text-3xl font-semibold text-white">
                        {{ step }}
                    </p>
                </div>
                <h3 class="text-base font-semibold">{{ title }}</h3>
                <hr class="h-1 w-12 bg-[#006662]" />
                <p class="text-sm text-gray-600">{{ description }}</p>
                <a :href="linkHref" class="text-sm font-semibold text-teal-800 hover:underline">
                    {{ linkText }}
                </a>
            </div>
            <img src="/images/arrow.png" alt="" class="size-fit" />
        </div>
    </div>
</template>
