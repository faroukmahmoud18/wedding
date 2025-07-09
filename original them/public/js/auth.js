// public/js/auth.js

// Assuming API_BASE_URL is globally available from config.js or injected by Blade
// If not, you might need to include config.js before this script or pass API_BASE_URL
// const API_BASE_URL = window.APP_CONFIG?.API_BASE_URL || "http://localhost:8000/api"; // Example if using window config

const AUTH_TOKEN_KEY = 'royalVowsAuthToken';
const USER_INFO_KEY = 'royalVowsUserInfo'; // For storing basic user info (name, role)

// --- Token Management ---
function storeToken(token) {
    localStorage.setItem(AUTH_TOKEN_KEY, token);
}

function getToken() {
    return localStorage.getItem(AUTH_TOKEN_KEY);
}

function removeToken() {
    localStorage.removeItem(AUTH_TOKEN_KEY);
}

// --- User Info Management (Optional, but useful for UI updates) ---
function storeUserInfo(user) {
    if (user) {
        localStorage.setItem(USER_INFO_KEY, JSON.stringify({
            name: user.name,
            email: user.email,
            role: user.role
            // Add other non-sensitive info you want to cache
        }));
    } else {
        localStorage.removeItem(USER_INFO_KEY);
    }
}

function getUserInfo() {
    const userInfo = localStorage.getItem(USER_INFO_KEY);
    return userInfo ? JSON.parse(userInfo) : null;
}

function removeUserInfo() {
    localStorage.removeItem(USER_INFO_KEY);
}


// --- Authentication Status ---
function isAuthenticated() {
    return !!getToken();
}

function getCurrentUserRole() {
    const userInfo = getUserInfo();
    return userInfo ? userInfo.role : null;
}


// --- API Calls ---
async function loginUser(email, password) {
    try {
        const response = await fetch(`${API_BASE_URL}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || `HTTP error! status: ${response.status}`);
        }

        if (data.token && data.user) {
            storeToken(data.token);
            storeUserInfo(data.user); // Store user info
            updateAuthUI(); // Update UI elements like header
            return { success: true, user: data.user, message: data.message || 'Login successful!' };
        } else {
            throw new Error(data.message || 'Login failed: No token or user data received.');
        }
    } catch (error) {
        console.error('Login API error:', error);
        return { success: false, message: error.message };
    }
}

async function registerUser(userData) { // { name, email, password, password_confirmation, role }
    try {
        const response = await fetch(`${API_BASE_URL}/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(userData),
        });

        const data = await response.json();

        if (!response.ok) {
            // Handle validation errors (often 422)
            if (response.status === 422 && data.errors) {
                const errorMessages = Object.values(data.errors).flat().join('<br>');
                throw new Error(errorMessages);
            }
            throw new Error(data.message || `HTTP error! status: ${response.status}`);
        }

        // Assuming registration doesn't auto-login and issue a token by default from the stub
        // If it does, handle token and user info storage like in loginUser
        return { success: true, message: data.message || 'Registration successful! Please login.' };

    } catch (error) {
        console.error('Registration API error:', error);
        return { success: false, message: error.message };
    }
}

async function logoutUser() {
    const token = getToken();
    if (!token) {
        // Already logged out or no token exists
        removeUserInfo(); // Ensure user info is also cleared
        updateAuthUI();
        window.location.href = '/'; // Redirect to home or login page
        return;
    }

    try {
        await fetch(`${API_BASE_URL}/logout`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            },
        });
        // Even if API call fails, clear client-side session
    } catch (error) {
        console.error('Logout API error:', error);
        // Still proceed to clear client-side session
    } finally {
        removeToken();
        removeUserInfo();
        updateAuthUI();
        // Redirect to home or login page. Using '/' for simplicity.
        // In a real app, you might want to redirect to '/login'
        window.location.href = '/';
    }
}

// --- UI Updates (Example for header) ---
// This function would be called after login/logout to update the header display.
// It's a simplified example; more robust UI updates might involve custom events or more direct DOM manipulation.
function updateAuthUI() {
    const navUserDropdown = document.getElementById('userDropdownMenu'); // From header.blade.php
    const navUserName = document.getElementById('navUserName'); // Custom ID to add for username display
    const navGuestActions = document.getElementById('navGuestActions'); // Custom ID for guest login/signup
    const navUserActions = document.getElementById('navUserActions'); // Custom ID for authenticated user actions (dropdown)

    if (isAuthenticated()) {
        const userInfo = getUserInfo();
        if (navUserName && userInfo) {
            navUserName.textContent = userInfo.name || 'User';
        }
        if (navGuestActions) navGuestActions.style.display = 'none';
        if (navUserActions) navUserActions.style.display = 'flex'; // Or 'block' or as appropriate
    } else {
        if (navGuestActions) navGuestActions.style.display = 'flex'; // Or 'block'
        if (navUserActions) navUserActions.style.display = 'none';
    }
    // This is a very basic example. More sophisticated UI updates might be needed across the site.
    // For example, dynamically changing what the dashboard link points to, or showing/hiding elements.
}


// --- Global Helper for Fetching with Auth ---
async function fetchWithAuth(url, options = {}) {
    const token = getToken();
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers, // Spread any custom headers from options
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const response = await fetch(url, { ...options, headers });

    if (response.status === 401) { // Unauthorized
        console.warn('Unauthorized API request. Logging out.');
        logoutUser(); // Force logout if token is invalid or expired
        throw new Error('Unauthorized'); // Or redirect to login
    }
    return response;
}


// Initial UI update on page load & attach logout listener
document.addEventListener('DOMContentLoaded', function() {
    updateAuthUI();

    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            logoutUser();
        });
    }
});

// Expose functions to global scope if they need to be called from inline HTML event handlers (generally not recommended)
// window.auth = { loginUser, registerUser, logoutUser, isAuthenticated, getCurrentUserRole, getToken, fetchWithAuth };
console.log("auth.js loaded.");
