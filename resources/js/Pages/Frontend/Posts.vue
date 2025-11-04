<template>
    <div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Success Alert - Green -->
            <div
                v-if="$page.props.flash?.success"
                class="fixed top-5 right-5 z-50 max-w-md bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center justify-between"
            >
                <div class="flex items-center">
                    <svg
                        class="w-6 h-6 mr-3"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <p class="font-bold">{{ $page.props.flash.success }}</p>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-white mb-4">
                    Trending Posts 🔥
                </h1>
                <p class="text-xl text-gray-400">
                    Explore what’s happening now ✨
                </p>
            </div>

            <!-- Create Post Button - Blue -->
            <div class="mb-8 flex">
                <a
                    :href="route('posts.create')"
                    class="inline-flex items-center bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl"
                >
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Create New Post
                </a>
            </div>

            <!-- Posts Grid -->
            <div
                v-if="posts.length > 0"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
            >
                <div
                    v-for="post in posts"
                    :key="post.id"
                    class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden"
                >
                    <!-- Top Bar - Blue to Green gradient -->
                    <div
                        class="h-1 bg-gradient-to-r from-blue-500 to-green-500"
                    ></div>

                    <!-- Post Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h2
                            class="text-xl font-bold text-white mb-3 hover:text-blue-400 transition-colors"
                        >
                            {{ post.title }}
                        </h2>

                        <!-- Content Preview -->
                        <p class="text-gray-400 mb-4 line-clamp-3">
                            {{ post.body }}
                        </p>

                        <h2
                            class="text-xl font-bold text-green-500 mb-3 hover:text-blue-400 transition-colors"
                        >
                            {{ post.category.name }}
                        </h2>

                        <!-- Tags Display -->
                        <div
                            v-if="post.tags && post.tags.length > 0"
                            class="flex flex-wrap gap-2 mb-3"
                        >
                            <span
                                v-for="tag in post.tags"
                                :key="tag.id"
                                class="inline-flex items-center bg-purple-600 text-white px-2 py-1 rounded-full text-xs font-semibold"
                            >
                                🏷️ {{ tag.name }}
                            </span>
                        </div>

                        <!-- Meta Info -->
                        <div
                            class="flex items-center justify-between text-sm text-gray-500 mb-4"
                        >
                            <span class="flex items-center">
                                <svg
                                    class="w-4 h-4 mr-1 text-green-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                {{ formatDate(post.created_at) }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <!-- Edit Button - Blue -->

                            <a
                                :href="route('posts.edit', post.id)"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center"
                            >
                                <svg
                                    class="w-4 h-4 mr-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>
                                Edit
                            </a>

                            <!-- Delete Button - Red -->
                            <button
                                @click="deletePost(post.id)"
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center"
                            >
                                <svg
                                    class="w-4 h-4 mr-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    />
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center py-12 bg-gray-800 rounded-lg border border-gray-700"
            >
                <svg
                    class="mx-auto h-12 w-12 text-gray-600 mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    />
                </svg>
                <h3 class="text-xl font-bold text-white mb-2">No posts</h3>
                <p class="text-gray-400">Get started by creating a new post.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};

const deletePost = (postId) => {
    if (confirm("Are you sure you want to delete this post?")) {
        const form = useForm({});
        form.delete(route("posts.destroy", postId));
    }
};
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
