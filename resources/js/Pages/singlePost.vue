<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
    singlePost: {
        type: Object,
        required: true,
    },
});

console.log(props.singlePost);
</script>

<template>
    <Head :title="singlePost.title" />

    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100 px-4 py-3">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <Link href="/blog">
                    <ApplicationLogo class="h-12 w-12" />
                </Link>
                <div class="space-x-4">
                    <Link
                        href="/blog"
                        class="text-sm text-gray-700 hover:text-gray-900"
                    >
                        ← Back to Blog
                    </Link>
                    <Link
                        href="/login"
                        class="text-sm text-gray-700 underline"
                    >
                        Login
                    </Link>
                </div>
            </div>
        </nav>

        <main class="py-12">
            <article class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <img 
                        v-if="singlePost.featured_image" 
                        :src="singlePost.featured_image.startsWith('http') ? singlePost.featured_image : '/storage/' + singlePost.featured_image" 
                        :alt="singlePost.title"
                        class="w-full h-96 object-cover"
                    />
                    <div class="p-8">
                        <h1 class="text-4xl font-bold mb-4">{{ singlePost.title }}</h1>
                        <div class="flex items-center text-gray-500 text-sm mb-8">
                            <span>{{ singlePost.created_at }}</span>
                        </div>
                        
                        <div class="prose max-w-none" v-html="singlePost.content"></div>
                    </div>
                </div>
            </article>
        </main>
    </div>
</template>
