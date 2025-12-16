<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    publicPosts: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Blog Posts" />

    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100 px-4 py-3">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <Link href="/blog">
                    <ApplicationLogo class="h-12 w-12" />
                </Link>
                <Link
                    href="/login"
                    class="text-sm text-gray-700 underline"
                >
                    Login
                </Link>
            </div>
        </nav>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="post in publicPosts.data" :key="post.id" 
                        class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                        <Link :href="`/blog/${post.slug}`">
                            <img v-if="post.featured_image" 
                                :src="post.featured_image.startsWith('http') ? post.featured_image : '/storage/' + post.featured_image" 
                                :alt="post.title"
                                class="w-full h-48 object-cover"
                            />
                            <div class="p-6">
                                <h2 class="text-xl font-bold mb-2">{{ post.title }}</h2>
                                <p class="text-gray-600 mb-4">{{ post.excerpt }}</p>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>{{ post.created_at }}</span>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6" v-if="publicPosts.data.links && publicPosts.data.links.length > 3">
                    <div class="flex justify-center gap-2">
                        <Link v-for="link in publicPosts.data.links" 
                            :key="link.label"
                            :href="link.url"
                            class="px-4 py-2 border rounded"
                            :class="{
                                'bg-indigo-600 text-white': link.active,
                                'text-gray-700 hover:bg-gray-50': !link.active
                            }"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>