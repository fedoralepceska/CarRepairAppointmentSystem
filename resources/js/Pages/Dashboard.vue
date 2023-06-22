<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Carousel from "@/Components/Carousel.vue";
import Calendar from "@/Components/Calendar.vue";
import Portfolio from "@/Components/Portfolio.vue";
import Heading from "@/Components/Heading.vue";
import ListGroup from "@/Components/ListGroup.vue";

const props = defineProps({appointments: Array});

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout style="background-image: url('/img/transparent-bg.png');background-size: cover; background-position: center; background-repeat: no-repeat">
        <div className="py-12">
<!--            <Carousel></Carousel>-->
            <div class="mx-auto sm:px-6 flex justify-center">
                <Heading title="Car Appointment" colored-title="System"></Heading>
            </div>
            <div className="max-w-xl mx-auto sm:px-6 lg:px-8 flex justify-center">
                <div className="overflow-hidden shadow-sm sm:rounded-lg" style="text-decoration: underline">
                    <div class="p-6 text-gray-900 text-xl"><a href="/appointments">Check available dates</a></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <div class="ml-32 mb-16">
        <Heading title="Upcoming" colored-title="Appointments"></Heading>
    </div>
    <div  class="max-w-7xl ml-32">
        <ListGroup :appointments="appointments"></ListGroup>
    </div>
    <div class="ml-32">
        <Heading :title="'Our'" :colored-title="'Gallery'"></Heading>
    </div>
    <Portfolio></Portfolio>
</template>

<style>
</style>
