@php
    $currentLocale = app()->getLocale();
@endphp

<div class="flex items-center mr-4">
    <select 
        id="language-select"
        class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md pl-3 pr-8 py-2 text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer min-w-[120px] appearance-none">
        
        <option value="en" {{ $currentLocale === 'en' ? 'selected' : '' }}>
            🇺🇸 English
        </option>
        
        <option value="ja" {{ $currentLocale === 'ja' ? 'selected' : '' }}>
            🇯🇵 日本語
        </option>
    </select>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('language-select');
    if (select) {
        select.addEventListener('change', function() {
            window.location.href = '{{ route("admin.lang.switch", "") }}/' + this.value;
        });
    }
});
</script>

<style>
select#language-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-position: right 8px center;
    background-repeat: no-repeat;
    background-size: 16px;
    padding-right: 1.5rem;
}

.dark select#language-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23d1d5db' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
}
</style> 
