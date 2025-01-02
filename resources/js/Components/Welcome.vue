<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

// Function to copy the phone number to clipboard
const copyPhoneNumber = () => {
  navigator.clipboard
    .writeText("09552719688")
    .then(() => alert("Phone number copied to clipboard!"))
    .catch((err) => alert("Failed to copy phone number. Please try again."));
};

// State for modal visibility
const showModal = ref(false);

// Function to toggle modal visibility
const toggleModal = () => {
  showModal.value = !showModal.value;
};
</script>

<template>
  <div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
      <h1 class="text-3xl font-medium text-gray-900">Elevate Digital PH</h1>

      <p class="my-5">You can pay using GCash by following the steps below:</p>

      <ol class="list-decimal pl-6 text-gray-700">
        <li>
          Select a Course
        </li>
        <li>
          Scan the QR code using the GCash app or send the amount to the phone
          number
          <button
            @click="copyPhoneNumber"
            class="mt-2 px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-1"
          >
            Copy Phone Number
          </button>
        </li>

        <div class="mt-2">
          <img
            src="/images/gcash_qr_2024.png"
            alt="GCash QR Code"
            class="h-auto w-52 border border-gray-300 shadow cursor-pointer"
            @click="toggleModal"
          />
        </div>
        <li class="mt-2">Take a screenshot of your successfull payment.</li>
        <!-- <li>Save the reference number for verification purposes.</li> -->
        <li>
          Submit your screenshot and reference number on
          <Link
            :href="route('payment.index')"
            class="text-blue-600 underline hover:text-blue-800"
          >
            this page
          </Link>
          for completion.
        </li>
      </ol>
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
  </div>
</template>
