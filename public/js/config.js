// public/js/config.js

// In a Blade + Vanilla JS setup, there's no direct .env access like Vite provides for VITE_ prefixed variables.
// Option 1: Hardcode for development (simplest for now)
const API_BASE_URL = "http://localhost:8000/api"; // Replace with your actual Laravel backend URL

// Option 2: Inject from Blade (more flexible)
// You could define this in your main Blade layout (e.g., layouts/app.blade.php) like:
// <script>
//   window.APP_CONFIG = {
//     API_BASE_URL: "{{ url('/api') }}" // Or config('app.api_url') if you set it in Laravel's config
//   };
// </script>
// Then access it in other JS files: const API_BASE_URL = window.APP_CONFIG.API_BASE_URL;

// For this exercise, we'll use the hardcoded version.
// If you use the Blade injection method, you can remove the const API_BASE_URL above
// and ensure window.APP_CONFIG.API_BASE_URL is used in other JS files.

console.log("Frontend API Base URL configured to:", API_BASE_URL);

// You can add other global JS configurations here if needed.
// Example:
// const DEFAULT_REQUEST_TIMEOUT = 10000; // 10 seconds
