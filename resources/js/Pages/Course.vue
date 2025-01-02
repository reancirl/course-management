<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from '@inertiajs/vue3';

// Define props for the courses array and a title for the page
defineProps({
  courses: Array,
  title: String,
  userBoughtCourses: Array, // Array of course IDs that the user has bought
});

const defaultImg = "/images/elevate_logo.webp";
</script>

<template>
  <AppLayout :title="title">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ title }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 bg-white">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div
                v-for="course in courses"
                :key="course.id"
                class="border rounded-lg shadow-sm overflow-hidden bg-gray-50"
              >
                <img
                  :src="course.img || defaultImg"
                  :alt="course.name"
                  class="w-full h-48 object-cover"
                />
                <div class="p-4">
                  <h2 class="font-semibold text-lg">{{ course.name }}</h2>
                  <p class="text-sm text-gray-500 mb-2">
                    {{ course.description || "No description available." }}
                  </p>
                  <p v-if="course.is_free" class="text-green-500 font-bold">
                    Free
                  </p>
                  <p v-else class="text-gray-900 font-bold">
                    ₱{{ course.price }}
                  </p>

                  <!-- Button Logic -->
                  <div class="mt-4">
                    <a
                      v-if="
                        course.is_free || userBoughtCourses.includes(course.id)
                      "
                      :href="course.gdrive_link"
                      target="_blank"
                      class="block px-4 py-2 text-center bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                      View Resource
                    </a>

                    <div v-else>
                      <Link
                        :href="route('payment.index', { courseId: course.id })"
                        class="block w-full px-4 py-2 text-center bg-green-600 text-white rounded hover:bg-green-700 mb-2"
                      >
                        Buy this Course
                      </Link>

                      <a
                        href="#"
                        target="_blank"
                        class="block px-4 py-2 text-center bg-gray-600 text-white rounded hover:bg-gray-700"
                      >
                        View Resource Snippets
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
