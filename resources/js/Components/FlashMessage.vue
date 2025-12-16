<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const message = computed(() => usePage().props.flash?.message ?? '');
const show = computed(() => message.value !== '');
</script>   

<template>
    <div v-if="show" class="fixed bottom-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg">
            {{ message }}
        </div>
    </div>
</template>
