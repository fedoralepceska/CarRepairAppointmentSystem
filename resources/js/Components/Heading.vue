<template>
    <h1 class="mb-4 mt-20 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-black">{{ title }} <span class="text-gray-600 dark:text-gray-600">{{ coloredTitle }}</span></h1>
</template>

<script>
export default {
    name: "Heading",
    props: {
        title: String,
        coloredTitle: String
    }
}
</script>

<style scoped>

</style>
