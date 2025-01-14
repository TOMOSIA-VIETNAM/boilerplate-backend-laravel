<template>
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center text-red-500">Login to Admin</h1>

        <form @submit.prevent="submitForm" method="POST" action="{{ route('admin.login') }}">
            <!-- @csrf -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    v-model="formData.email"
                    id="email"
                    name="email"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                    required
                />
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    type="password"
                    v-model="formData.password"
                    id="password"
                    name="password"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                    required
                />
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-md">
                    Login
                </button>
            </div>

            <div v-if="errors.length" class="text-red-600">
                <ul>
                    <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                </ul>
            </div>
        </form>
    </div>
</template>

<script>
export default {
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
                this.errors = [];  // Reset errors

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

<style scoped>
</style>
