<template>
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center text-red-500">Login to Admin</h1>

        <form @submit.prevent="submitForm">
            <Input
                label="Email"
                id="email"
                name="email"
                type="email"
                v-model="formData.email"
                required
            />
            <Input
                label="Password"
                id="password"
                name="password"
                type="password"
                v-model="formData.password"
                required
            />
            <Checkbox
                id="remember"
                name="remember"
                label="Remember Me"
                v-model:checked="formData.remember"
            />
            <div class="text-center">
                <Button type="submit" isPrimary>Login</Button>
            </div>
            <ErrorMessage :messages="errors" />

        </form>
    </div>
</template>

<script>
import Input from '../components/form/Input.vue';
import Button from '../components/form/Button.vue';
import Checkbox from '../components/form/Checkbox.vue';
import ErrorMessage from '../components/form/ErrorMessage.vue';

export default {
    components: {
        Input,
        Button,
        Checkbox,
        ErrorMessage
    },
    data() {
        return {
            formData: {
                email: '',
                password: ''
            },
            errors: []
        };
    },
    methods: {
        async submitForm() {
            try {
                this.errors = [];
                const response = await axios.post('/admin/login', this.formData);
                if (response.data.success) {
                    window.location.href = '/admin/';
                } else {
                    this.errors.push('Invalid credentials');
                }
            } catch (error) {
                console.error('Error logging in:', error);
                this.errors.push('Something went wrong, please try again.');
            }
        }
    }
};
</script>
