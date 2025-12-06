<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="post.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    View Post
                </h2>
                <Link
                    :href="route('posts.edit', post.id)"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
                >
                    Edit Post
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6">
                            <h1 class="text-3xl font-bold mb-2">{{ post.title }}</h1>
                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                <img v-if="post.featured_image" :src="'/storage/' + post.featured_image" alt="Featured Image" class="w-full h-64 object-cover rounded">
                                <span>By {{ post.author }}</span>
                                <span>{{ post.created_at }}</span>
                                <span class="px-2 py-1 rounded-full text-xs"
                                    :class="post.status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                                    {{ post.status }}
                                </span>
                            </div>
                        </div>

                        <div class="prose max-w-none">
                            <p class="text-lg text-gray-600 mb-6">{{ post.excerpt }}</p>
                            <div class="mt-6 text-gray-800">
                                {{ post.content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
