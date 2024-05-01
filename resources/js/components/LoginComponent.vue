<template>
Hello word
</template>

<script setup>
const email = ref("");
const password = ref("");

const login = () => {
    // Add your login logic here
    console.log("Login with:", email.value, password.value);
};
</script>
