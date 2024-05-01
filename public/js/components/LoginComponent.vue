<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    v-model="password"
                    required
                />
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script setup>
const email = ref("");
const password = ref("");

const login = () => {
    // Add your login logic here
    console.log("Login with:", email.value, password.value);
};
</script>
