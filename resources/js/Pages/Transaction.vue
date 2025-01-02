<script setup>
import { ref, computed } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

// Props for selected course and list of courses
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

// State for additional courses
const additionalCourses = ref([]);

// Modal state and toggle function
const showModal = ref(false);
const toggleModal = () => {
  showModal.value = !showModal.value;
};

// Copy GCash phone number
const copyPhoneNumber = () => {
  navigator.clipboard
    .writeText("09552719688")
    .then(() => alert("Phone number copied to clipboard!"))
    .catch(() => alert("Failed to copy phone number. Please try again."));
};

// Form initialization
const form = useForm({
  course_id: props.selectedCourse?.id || null,
  additional_course_ids: [],
  payment_amount: props.selectedCourse?.price || 0,
  reference_number: "",
  screenshot: null,
});

// Update payment amount dynamically
const updatePaymentAmount = () => {
  const selectedMainCourse = props.courses.find(
    (course) => course.id === form.course_id
  );
  const mainCoursePrice = selectedMainCourse
    ? parseFloat(selectedMainCourse.price)
    : 0;

  const additionalCoursePrices = additionalCourses.value.reduce(
    (total, courseId) => {
      const course = props.courses.find((course) => course.id === courseId);
      return total + (course ? parseFloat(course.price) : 0);
    },
    0
  );

  form.payment_amount = parseFloat(
    mainCoursePrice + additionalCoursePrices
  ).toFixed(2);
};

// Add or remove additional courses
const addAdditionalCourse = () => additionalCourses.value.push(null);
const removeAdditionalCourse = (index) => {
  additionalCourses.value.splice(index, 1);
  updatePaymentAmount();
};

// Handle file upload
const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.screenshot = file;
};

// Handle form submission
const submitForm = () => {
  form.additional_course_ids = additionalCourses.value.filter((id) => id !== null);

  form.post(route("payment.store"), {
    onSuccess: () => {
      alert("Transaction submitted successfully!");
      form.reset();
      additionalCourses.value = [];
    },
    onError: (errors) => {
      console.error("Form submission errors:", errors);
    },
  });
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
          <h3 class="text-lg font-semibold mb-4">New Transaction</h3>

          <!-- Payment Steps -->
          <div class="mb-6">
            <h4 class="text-md font-semibold mb-2">Payment Steps:</h4>
            <ol class="list-decimal pl-6 text-gray-700 space-y-2">
              <li>Select a course and any additional courses below.</li>
              <li>
                Scan the QR code or send payment to:
                <button
                  @click="copyPhoneNumber"
                  class="ml-2 px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700 focus:ring focus:ring-blue-300"
                >
                  Copy Phone Number
                </button>
              </li>
              <li>
                Take a screenshot of the successful payment or save the
                reference number.
              </li>
              <li>Submit the screenshot and/or reference number below.</li>
            </ol>
            <div class="mt-4">
              <img
                src="/images/gcash_qr_2024.png"
                alt="GCash QR Code"
                class="w-40 h-auto border border-gray-300 shadow cursor-pointer"
                @click="toggleModal"
              />
            </div>
          </div>

          <!-- Select Course -->
          <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Select Course</label>
            <select
              v-model="form.course_id"
              class="w-full p-2 border border-gray-300 rounded"
              @change="updatePaymentAmount"
            >
              <option disabled value="">-- Select a Course --</option>
              <option v-for="course in courses" :key="course.id" :value="course.id">
                {{ course.name }} - ₱{{ course.price }}
              </option>
            </select>
          </div>

          <!-- Additional Courses -->
          <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">
              Additional Courses
            </label>
            <div v-for="(additionalCourse, index) in additionalCourses" :key="index" class="flex items-center mb-2">
              <select
                v-model="additionalCourses[index]"
                class="w-full p-2 border border-gray-300 rounded mr-2"
                @change="updatePaymentAmount"
              >
                <option disabled value="">-- Select an Additional Course --</option>
                <option v-for="course in courses" :key="course.id" :value="course.id">
                  {{ course.name }} - ₱{{ course.price }}
                </option>
              </select>
              <button
                @click="removeAdditionalCourse(index)"
                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
              >
                Remove
              </button>
            </div>
            <button
              @click="addAdditionalCourse"
              class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
            >
              Add Additional Course
            </button>
          </div>

          <!-- Reference Number & Screenshot -->
          <div class="my-4">
            <label class="block font-medium text-gray-700 mb-2">GCash Payment Proof (One Required)</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Reference Number</label>
                <input
                  v-model="form.reference_number"
                  type="text"
                  placeholder="Enter Reference Number"
                  class="w-full p-2 border border-gray-300 rounded"
                  :class="{ 'border-red-500': !form.reference_number && !form.screenshot }"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Upload Payment Screenshot</label>
                <input
                  type="file"
                  @change="handleFileChange"
                  class="w-full p-2 border border-gray-300 rounded"
                  :class="{ 'border-red-500': !form.reference_number && !form.screenshot }"
                />
              </div>
            </div>
          </div>

          <!-- Total Payment Amount -->
          <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Total Payment Amount</label>
            <input
              type="text"
              :value="form.payment_amount"
              class="w-full p-2 border border-gray-300 rounded bg-gray-300"
              readonly
            />
          </div>

          <!-- Submit Button -->
          <button
            @click="submitForm"
            class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            :disabled="!form.reference_number && !form.screenshot"
          >
            Submit Transaction
          </button>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
    >
      <div class="relative max-w-md p-4 bg-white rounded shadow-lg">
        <img
          src="/images/gcash_qr_2024.png"
          alt="GCash QR Code Enlarged"
          class="h-auto w-full max-w-xs mx-auto border border-gray-300"
        />
        <button
          @click="toggleModal"
          class="mt-4 px-4 py-2 w-full text-sm text-white bg-red-600 rounded hover:bg-red-700"
        >
          Close
        </button>
      </div>
    </div>
  </AppLayout>
</template>
