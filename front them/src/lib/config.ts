// src/lib/config.ts

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || "http://localhost:8000/api";

if (!API_BASE_URL) {
  console.warn(
    "Warning: VITE_API_BASE_URL is not defined in your .env file. " +
    "Falling back to default 'http://localhost:8000/api'. " +
    "Create a .env file in the project root with VITE_API_BASE_URL to customize the API endpoint."
  );
}

export const config = {
  apiBaseUrl: API_BASE_URL,
  // Add other global configurations here if needed
  appName: "Royal Vows",
  defaultToastDuration: 5000,
};

// Example of how to define it in your .env file (create this file in the project root if it doesn't exist)
/*
VITE_API_BASE_URL=http://my-laravel-app.test/api
*/
