<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const deletePost = (id) => {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(route('posts.destroy', id));
    }
};

const props = defineProps({
    posts: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl font-bold">All Posts</h1>
                            <Link
                                :href="route('posts.create')"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
                            >
                                New Post
                            </Link>
                        </div>
                        <div class="mt-6">
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <ul class="divide-y divide-gray-200">
                                    <li v-for="post in props.posts.data" :key="post.id" class="p-6 hover:bg-gray-50 transition">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <Link
                                                    :href="route('posts.show', post.id)"
                                                    class="text-lg font-semibold text-indigo-600 hover:text-indigo-700"
                                                >
                                                    {{ post.title }}
                                                </Link>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    {{ post.excerpt }}
                                                </p>
                                                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                                    <span>By {{ post.author }}</span>
                                                    <span>{{ post.created_at }}</span>
                                                    <span class="px-2 py-1 rounded-full text-xs" 
                                                        :class="post.status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'"
                                                    >
                                                        {{ post.status }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <Link
                                                    :href="route('posts.edit', post.id)"
                                                    class="text-sm text-blue-600 hover:text-blue-700"
                                                >
                                                    Edit
                                                </Link>
                                                <button
                                                    @click="deletePost(post.id)"
                                                    class="text-sm text-red-600 hover:text-red-700"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div v-if="props.posts.links.length > 3" class="mt-6">
                            <div class="flex justify-between items-center">
                                <Link
                                    v-if="props.posts.prev_page_url"
                                    :href="props.posts.prev_page_url"
                                    class="px-4 py-2 text-sm border rounded hover:bg-gray-50"
                                >
                                    Previous
                                </Link>
                                <Link
                                    v-if="props.posts.next_page_url"
                                    :href="props.posts.next_page_url"
                                    class="px-4 py-2 text-sm border rounded hover:bg-gray-50"
                                >
                                    Next
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
