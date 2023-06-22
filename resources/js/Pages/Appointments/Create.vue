<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import {onMounted} from "vue";
import flatpickr from "flatpickr";
import InputLabel from "@/Components/InputLabel.vue";
import Heading from "@/Components/Heading.vue";


defineProps(['appointments']);

const form = useForm({
    date: '',
    time: '',
    car_brand: '',
    issue: ''
});

onMounted(() => {
    flatpickr(document.getElementById('date-input'), {
        dateFormat: 'Y-m-d',
    });

    flatpickr(document.getElementById('time-input'), {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
    });
});

const showFlatpickr = () => {
    const datePicker = flatpickr(document.getElementById('date-input'));
    const timePicker = flatpickr(document.getElementById('time-input'));

    datePicker.show();
    timePicker.show();
};
</script>

<template>
    <Head title="Appointments">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    </Head>

    <AuthenticatedLayout>
        <div class="flex justify-center">
            <Heading title="Please fill all" colored-title="Fields"></Heading>
        </div>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('appointments.store'), { onSuccess: () => {form.reset(); showFlatpickr();}, preserveScroll: true })">
                <input-label>Pick a date</input-label><input
                ref="dateInput"
                id="date-input"
                type="text"
                v-model="form.date"
                class="date-picker-input"
            />
                <InputError :message="form.errors.date" class="mt-2" />
                <input-label>Pick a time</input-label><input
                ref="timeInput"
                id="time-input"
                type="text"
                v-model="form.time"
                class="time-picker-input"
            />
                <InputError :message="form.errors.time" class="mt-2" />
                <textarea v-model="form.car_brand" placeholder="What car do you have?" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.car_brand" class="mt-2" />
                <textarea v-model="form.issue" placeholder="What's your issue?" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.issue" class="mt-2" />
                <PrimaryButton class="mt-4">Create Appointment</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
