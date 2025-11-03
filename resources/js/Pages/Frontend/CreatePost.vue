<template>
    <div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-5xl font-bold text-white mb-4">
                    Create New Post
                </h1>
                <p class="text-gray-400 text-lg">
                    Share your thoughts with the world ✨
                </p>
            </div>

            <!-- Form Card -->
            <div
                class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl p-8"
            >
                <form @submit.prevent="submit">
                    <!-- Title Input -->
                    <div class="mb-6">
                        <label
                            for="title"
                            class="block text-sm font-bold text-gray-300 mb-2"
                        >
                            Post Title
                        </label>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            class="w-full px-4 py-3 bg-gray-700 border-2 border-gray-600 text-white rounded-lg focus:ring-4 focus:ring-green-500 focus:border-green-500 transition-all placeholder-gray-500"
                            placeholder="Enter your post title..."
                            required
                        />
                        <p
                            v-if="errors.title"
                            class="mt-2 text-sm text-red-500"
                        >
                            {{ errors.title }}
                        </p>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="mb-6">
                        <label
                            for="category"
                            class="block text-sm font-bold text-gray-300 mb-2"
                        >
                            Category
                        </label>
                        <select
                            id="category"
                            v-model="form.category_id"
                            class="w-full px-4 py-3 bg-gray-700 border-2 border-gray-600 text-white rounded-lg focus:ring-4 focus:ring-green-500 focus:border-green-500 transition-all"
                            required
                        >
                            <option value="" disabled>Select a category</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <p
                            v-if="errors.category_id"
                            class="mt-2 text-sm text-red-500"
                        >
                            {{ errors.category_id }}
                        </p>
                    </div>

                    <!-- Body Textarea -->
                    <div class="mb-6">
                        <label
                            for="body"
                            class="block text-sm font-bold text-gray-300 mb-2"
                        >
                            Post Content
                        </label>
                        <textarea
                            id="body"
                            v-model="form.body"
                            rows="10"
                            class="w-full px-4 py-3 bg-gray-700 border-2 border-gray-600 text-white rounded-lg focus:ring-4 focus:ring-green-500 focus:border-green-500 transition-all resize-none placeholder-gray-500"
                            placeholder="Write your post content here..."
                            required
                        ></textarea>
                        <p v-if="errors.body" class="mt-2 text-sm text-red-500">
                            {{ errors.body }}
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                        >
                            <svg
                                v-if="form.processing"
                                class="animate-spin h-5 w-5 mr-2"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            {{
                                form.processing ? "Creating..." : "Create Post"
                            }}
                        </button>

                        <a
                            :href="route('posts.index')"
                            class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 text-center"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    title: "",
    body: "",
    category_id: "", // Category field add කරන්න
});

const submit = () => {
    form.post(route("posts.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
