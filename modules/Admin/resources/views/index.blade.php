<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Module</title>
    @vite(['modules/Admin/resources/assets/scss/app.scss', 'modules/Admin/resources/assets/js/app.js'])
</head>
<body>
    <div id="admin"></div>
    <script type="module">
        import { createApp } from 'vue';
        import AdminApp from '../assets/js/components/App.vue';
        console.log('admim', AdminApp);

        createApp(AdminApp).mount('#admin');
    </script>
</body>
</html>
