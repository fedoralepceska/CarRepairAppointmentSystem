<template>
    <div>
        <div style="background-color: white; border-radius: 20px" id="calendar" className="py-12 max-w-xl mx-auto sm:px-6 lg:px-8 flex"></div>
    </div>
</template>

<script>
import { onMounted, ref} from "vue";
import {Calendar} from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";

export default {
    name: 'Calendar',

    props: {
        appointments: Array,
    },

    setup(props) {
        const bookedDates = ref([]);

        bookedDates.value = props.appointments.map(appointment => appointment.date);

        let calendar;

        onMounted(() => {
            const calendarEl = document.getElementById('calendar');
            calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin],
                events: [],
                datesSet: (info) => {
                    const {start, end} = info.view.activeStart;
                    const disabledDates = bookedDates.value.map((date) => {
                        return {
                            start: date,
                            end: date,
                            display: 'background',
                            title: 'FULL',
                            classNames: 'title',
                            backgroundColor: '#2d3748',
                        };
                    });
                    calendar.removeAllEventSources();
                    calendar.addEventSource(disabledDates);
                }
            });

            calendar.render();
        });
    },
};
</script>

<style scoped>
.title {
    color: black;
}
</style>
