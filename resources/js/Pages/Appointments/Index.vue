<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Appointment from '@/Components/Appointment.vue';
import { onMounted, onUnmounted, ref, watch} from "vue";
import { Inertia } from "@inertiajs/inertia";
import flatpickr from "flatpickr";
import Calendar from '@/Components/Calendar.vue'
import Heading from "@/Components/Heading.vue";

defineProps({ appointments: Array, filters: Object });

const search = ref('');
const selectedDate = ref('');
let searchTimeout = null;


const handleSearch = () => {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        const params = { search: search.value, date: selectedDate.value };
        Inertia.get(route('appointments.index', params), {
            preserveState: true,
            replace: true,
        });
    }, 100);
};

const handleKeyPress = event => {
    if (event.key === 'Enter') {
        handleSearch();
    }
};

watch(selectedDate, () => {
    handleSearch();
});

onMounted(() => {
    const datePicker = flatpickr("#date-input", {
        dateFormat: 'Y-m-d',
        onChange: (selectedDates, dateStr) => {
            selectedDate.value = dateStr;
        },
    });

    datePicker.config.onClose.push(() => {
        handleSearch();
    });
});

onUnmounted(() => {
    clearTimeout(searchTimeout);
});
</script>

<template>
    <Head title="Appointments">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <title>Appointments</title>
    </Head>

    <AuthenticatedLayout style="background-color: #4a556830">
        <div class="flex justify-center">
            <Heading title="Available" colored-title="Dates"></Heading>
        </div>
            <Calendar :appointments="appointments"></Calendar>

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="flex justify-center">
                <Heading title="All" colored-title="Appointments"></Heading>
            </div>
            <div>
                <div class="flex justify-evenly mt-8 mb-8">
                    <h1 class="text-xl mt-2">Filters:</h1>
                    <input v-model="search" @keypress="handleKeyPress" type="text" placeholder="Search here" class="border px-2 rounded-lg" />
                    <input v-model="selectedDate" type="text" placeholder="Select date" class="border px-2 rounded-lg" id="date-input">
                </div>
            </div>
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Appointment
                    v-for="appointment in appointments"
                    :key="appointment.id"
                    :appointment="appointment"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
