const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.copy('node_modules/@coreui/coreui/dist/js/coreui.bundle.min.*', '../../public/js');
mix.copy('node_modules/@coreui/icons/css/all.min.*', '../../public/css');
mix.copy('node_modules/@coreui/icons/sprites/', '../../public/icons/sprites');
mix.copy('node_modules/@coreui/icons/fonts', '../../public/fonts');
mix.copy('Resources/assets/brand', '../../public/assets/brand');
mix.copy('Resources/assets/icons', '../../public/assets/icons');
mix.copy('Resources/assets/img', '../../public/assets/img');

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/admin.js')
    .js('node_modules/@coreui/utils/dist/coreui-utils.js', 'js/coreui-utils.js');

mix.sass(__dirname + '/Resources/assets/sass/app.scss', 'css/admin.css')
    .sass(__dirname + '/Resources/assets/sass/coreui/style.scss', 'css/style.css');

if (mix.inProduction()) {
    mix.version();
}
