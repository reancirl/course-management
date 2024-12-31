<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

// Destructure props
const props = defineProps({
  selectedCourse: {
    type: Object,
    default: () => ({
      id: null,
      name: "None",
      price: 0,
    }),
  },
  courses: {
    type: Array,
    default: () => [],
  },
});

// Debugging props
console.log("Selected Course:", props.selectedCourse || "No course provided");
console.log("Courses:", props.courses || "No courses provided");

// Use computed property to safely access selectedCourse
const safeSelectedCourse = computed(() => props.selectedCourse || { id: null, name: "None", price: 0 });

// Form initialization with safeSelectedCourse
const form = useForm({
  course_id: safeSelectedCourse.value.id || null,
  additional_course_ids: [],
  payment_amount: safeSelectedCourse.value.price || 0,
});

// Update payment amount dynamically based on additional courses
const updatePaymentAmount = () => {
  const selectedAdditionalCourses = props.courses.filter(course =>
    form.additional_course_ids.includes(course.id)
  );
  form.payment_amount = selectedAdditionalCourses.reduce(
    (total, course) => total + course.price,
    safeSelectedCourse.value.price || 0
  );
};
</script>


<template>
  <AppLayout title="Transactions">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Transactions
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-4">Create a New Transaction</h3>

          <!-- Selected Course -->
          <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Selected Course</label>
            <input
              type="text"
              :value="selectedCourse ? selectedCourse.name : 'None'"
              class="w-full p-2 border border-gray-300 rounded"
              readonly
            />
          </div>

          <!-- Dropdown for Additional Courses -->
          <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Additional Courses</label>
            <select
              v-model="form.additional_course_ids"
              multiple
              class="w-full p-2 border border-gray-300 rounded"
              @change="updatePaymentAmount"
            >
              <option v-for="course in courses" :key="course.id" :value="course.id">
                {{ course.name }} - ₱{{ course.price }}
              </option>
            </select>
          </div>

          <!-- Payment Amount -->
          <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Total Payment Amount</label>
            <input
              type="text"
              :value="form.payment_amount"
              class="w-full p-2 border border-gray-300 rounded"
              readonly
            />
          </div>

          <!-- Submit Button -->
          <button
            @click="form.post(route('payment.store'))"
            class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            Submit Transaction
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
