<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Module</title>
    @vite(['modules/Candidate/resources/assets/scss/app.scss', 'modules/Candidate/resources/assets/js/app.js'])
</head>
<body>
    <div id="candidate"></div>
    <script type="module">
        import { createApp } from 'vue';
        import CandidateApp from '../assets/js/components/App.vue';

        createApp(CandidateApp).mount('#candidate');
    </script>
</body>
</html>
