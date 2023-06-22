<template>
    <ul class="divide-y p-6 divide-gray-200 dark:divide-gray-700 p-1 mb-6" style="background-color: #6b728080; border-radius: 20px">
        <li v-for="a in upcomingAppointments" class="pb-3 sm:pb-4">
            <div class="flex items-center space-x-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-black font-semibold">
                        {{ a.car_brand }}
                    </p>
                    <p class="text-sm text-white truncate dark:text-gray-600">
                        {{ a.issue }}
                    </p>
                </div>
                <div class="inline-flex items-center text-base font-semibold text-gray-100 dark:text-gray-100">
                    {{ a.date }}
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
import { computed } from "vue";
import Heading from "@/Components/Heading.vue";

export default {
    name: "ListGroup",
    components: {Heading},
    props: {
        appointments: Array
    },
    setup(props) {
        const upcomingAppointments = computed(() => {
            const sortedAppointments = [...props.appointments].sort(
                (a, b) => new Date(b.date) - new Date(a.date)
            );

            return sortedAppointments.slice(0, 3);
        });

        return {
            upcomingAppointments
        };
    }
}
</script>

<style scoped>
p {
    font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    font-size: medium;
}
</style>
