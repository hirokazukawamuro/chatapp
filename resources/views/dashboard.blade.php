<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-app-layout>
    <div class="bg-orggray h-screen flex">
        <div id="app" class="flex-grow">
        </div>
    </div>
</x-app-layout>

</body>

</html>