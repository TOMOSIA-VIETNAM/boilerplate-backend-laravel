<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Module</title>
    @vite(['modules/Company/resources/assets/scss/app.scss', 'modules/Company/resources/assets/js/app.js'])
</head>
<body>
    <div id="company"></div>
    <script type="module">
        import { createApp } from 'vue';
        import CompanyApp from '../assets/js/components/App.vue';

        createApp(CompanyApp).mount('#company');
    </script>
</body>
</html>
