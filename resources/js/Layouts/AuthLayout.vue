<!-- resources/js/Layouts/AuthLayout.vue -->

<script>
    // import components
    import Header from './Authenticated/general/Header.vue';
    import Main from './Authenticated/general/Main.vue';

    // use comopnents
    export default {
        components: {
            Header,
            Main,
        },
    };
</script>

<template>
    <Header />
    <Main>
        <slot />
    </Main>
</template>