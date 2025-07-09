// public/js/dashboard.js
document.addEventListener('DOMContentLoaded', function () {
    const dashboardUserRoleTitleEl = document.getElementById('dashboardUserRoleTitle');
    const dashboardTabEl = document.getElementById('dashboardTab');
    const dashboardTabContentEl = document.getElementById('dashboardTabContent');
    const dashboardLoadingEl = document.getElementById('dashboardLoading');

    // --- Simulate user role (replace with actual auth logic in a real app) ---
    // To test different views, change this value: 'admin', 'vendor', or 'user'
    const currentUserRole = 'admin';
    // const currentUser = { name: 'Admin User', email: 'admin@royalvows.com', role: 'admin' }; // Example user object

    function initDashboard() {
        if (!dashboardTabEl || !dashboardTabContentEl || !dashboardUserRoleTitleEl) {
            console.error('Dashboard tab elements not found.');
            if(dashboardLoadingEl) dashboardLoadingEl.innerHTML = '<p class="text-danger">Error loading dashboard structure.</p>';
            return;
        }

        dashboardTabEl.innerHTML = ''; // Clear any existing tabs
        dashboardTabContentEl.innerHTML = ''; // Clear any existing content

        let tabsConfig = [];
        let firstTabId = '';

        switch (currentUserRole) {
            case 'admin':
                dashboardUserRoleTitleEl.textContent = 'Admin';
                tabsConfig = [
                    { id: 'manage-vendors', title: 'Manage Vendors', contentFunc: getAdminManageVendorsContent },
                    { id: 'manage-services', title: 'Manage Services', contentFunc: getAdminManageServicesContent },
                    { id: 'view-bookings', title: 'Site Bookings', contentFunc: getAdminSiteBookingsContent },
                    // { id: 'manage-users', title: 'Manage Users', contentFunc: getAdminManageUsersContent },
                ];
                break;
            case 'vendor':
                // Assume we have vendor data, e.g., from an Auth::user()->vendor relationship
                // const vendorData = sampleVendors.find(v => v.id === '1'); // Example: first vendor
                dashboardUserRoleTitleEl.textContent = 'Vendor'; // Could be vendorData.name
                tabsConfig = [
                    { id: 'my-services', title: 'My Services', contentFunc: getVendorMyServicesContent },
                    { id: 'vendor-bookings', title: 'My Bookings', contentFunc: getVendorBookingsContent },
                    { id: 'vendor-profile', title: 'My Profile', contentFunc: getVendorProfileContent },
                ];
                break;
            case 'user':
            default:
                dashboardUserRoleTitleEl.textContent = 'My'; // "My Dashboard"
                tabsConfig = [
                    { id: 'user-bookings', title: 'My Bookings', contentFunc: getUserMyBookingsContent },
                    { id: 'user-favorites', title: 'My Favorites', contentFunc: getUserFavoritesContent },
                    { id: 'user-profile', title: 'My Profile', contentFunc: getUserProfileContent },
                ];
                break;
        }

        if (tabsConfig.length > 0) {
            firstTabId = tabsConfig[0].id;
        }

        tabsConfig.forEach((tab, index) => {
            const isActive = index === 0;
            // Create Nav Link
            const navItem = document.createElement('li');
            navItem.className = 'nav-item';
            navItem.setAttribute('role', 'presentation');
            navItem.innerHTML = `
                <button class="nav-link ${isActive ? 'active' : ''}" id="${tab.id}-tab" data-bs-toggle="tab" data-bs-target="#${tab.id}-tab-pane" type="button" role="tab" aria-controls="${tab.id}-tab-pane" aria-selected="${isActive ? 'true' : 'false'}">
                    ${tab.title}
                </button>
            `; // Using translated titles from Blade if possible for tab.title
            dashboardTabEl.appendChild(navItem);

            // Create Tab Pane
            const tabPane = document.createElement('div');
            tabPane.className = `tab-pane fade ${isActive ? 'show active' : ''}`;
            tabPane.id = `${tab.id}-tab-pane`;
            tabPane.setAttribute('role', 'tabpanel');
            tabPane.setAttribute('aria-labelledby', `${tab.id}-tab`);
            tabPane.setAttribute('tabindex', '0');
            tabPane.innerHTML = tab.contentFunc(); // Call function to get content
            dashboardTabContentEl.appendChild(tabPane);
        });

        if(dashboardLoadingEl) dashboardLoadingEl.style.display = 'none';

    }

    // --- Content Generation Functions (Now Async for API calls) ---

    // Helper for authenticated fetch
    async function fetchDashboardData(endpoint) {
        const token = getToken(); // from auth.js
        if (!token) {
            return { success: false, message: "Authentication token not found. Please login.", data: [] };
        }
        try {
            const response = await fetch(`${API_BASE_URL}${endpoint}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                }
            });
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({ message: `HTTP error! status: ${response.status}` }));
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            return { success: true, data: result.data || result }; // Adjust based on API (e.g. if paginated)
        } catch (error) {
            console.error(`Error fetching ${endpoint}:`, error);
            return { success: false, message: error.message, data: [] };
        }
    }


    // Admin Content Functions
    function getAdminManageVendorsContent() {
        const contentId = 'admin-vendors-content';
        // Initial loading state for the tab pane
        setTimeout(async () => {
            const container = document.getElementById(contentId);
            if (!container) return;
            container.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            const result = await fetchDashboardData('/admin/vendors'); // Endpoint from plan
            if (result.success && Array.isArray(result.data)) {
                let tableRows = '';
                if (result.data.length === 0) {
                    tableRows = '<tr><td colspan="4" class="text-center">No vendors found.</td></tr>';
                } else {
                    result.data.forEach(vendor => {
                        tableRows += `
                            <tr>
                                <td>${vendor.name || 'N/A'}</td>
                                <td>${vendor.email || 'N/A'}</td>
                                <td><span class="badge ${vendor.verified ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis'}">${vendor.verified ? 'Verified' : 'Pending'}</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary me-1" title="View" onclick="alert('View vendor ${vendor.id}')"><i class="bi bi-eye-fill"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary me-1" title="Edit" onclick="alert('Edit vendor ${vendor.id}')"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete" onclick="alert('Delete vendor ${vendor.id}')"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                }
                container.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-serif mb-0">Manage Vendors</h4>
                        <button class="btn btn-royal btn-sm"><i class="bi bi-plus-circle-fill me-2"></i>Add New Vendor</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped card-royal">
                            <thead class="table-light">
                                <tr><th>Name</th><th>Email</th><th>Status</th><th class="text-end">Actions</th></tr>
                            </thead>
                            <tbody>${tableRows}</tbody>
                        </table>
                    </div>`;
            } else {
                container.innerHTML = `<div class="alert alert-danger">${result.message || 'Failed to load vendors.'}</div>`;
            }
        }, 100); // Small delay to ensure tab pane is in DOM
        return `<div id="${contentId}"><div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div></div>`;
    }

    function getAdminManageServicesContent() {
        const contentId = 'admin-services-content';
        setTimeout(async () => {
            const container = document.getElementById(contentId);
            if (!container) return;
            container.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            const result = await fetchDashboardData('/admin/services'); // Endpoint from plan
            if (result.success && Array.isArray(result.data)) {
                let serviceCards = '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">';
                if (result.data.length === 0) {
                    serviceCards = '<p class="text-center col-12">No services to display.</p>';
                } else {
                     result.data.forEach(service => {
                        serviceCards += `
                        <div class="col">
                            <div class="card card-royal h-100 shadow-sm">
                                <img src="${service.images && service.images[0]?.path || 'https://placehold.co/300x200/EEE/666?text=Service'}" class="card-img-top" alt="${service.title}" style="height:150px; object-fit:cover;">
                                <div class="card-body py-2 px-3">
                                    <h6 class="card-title font-serif small mb-1 text-truncate" title="${service.title}">${service.title || 'N/A'}</h6>
                                    <p class="card-text text-muted small mb-1">By: ${service.vendor?.name || 'N/A'}</p>
                                    <span class="badge ${service.is_active || service.isActive ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis'}">${service.is_active || service.isActive ? 'Active' : 'Inactive'}</span>
                                    ${service.featured ? '<span class="badge bg-primary-subtle text-primary-emphasis ms-1">Featured</span>' : ''}
                                </div>
                                <div class="card-footer bg-transparent border-0 py-2 px-3 text-end">
                                    <button class="btn btn-sm btn-outline-secondary" title="Toggle Status" onclick="alert('Toggle status for ${service.id}')"><i class="bi bi-toggles"></i></button>
                                    <button class="btn btn-sm btn-outline-primary ms-1" title="Edit" onclick="alert('Edit service ${service.id}')"><i class="bi bi-pencil-fill"></i></button>
                                </div>
                            </div>
                        </div>`;
                    });
                    serviceCards += '</div>';
                }
                container.innerHTML = `
                    <h4 class="font-serif mb-3">Manage Services</h4>
                    ${serviceCards}`;
            } else {
                 container.innerHTML = `<div class="alert alert-danger">${result.message || 'Failed to load services.'}</div>`;
            }
        }, 100);
        return `<div id="${contentId}"><div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div></div>`;
    }

    function getAdminSiteBookingsContent() {
        // Similar async loading structure as above for /api/admin/bookings (if that's the endpoint)
        return `<h4 class="font-serif">Site-wide Bookings Overview</h4><p>Content for all site bookings will go here (e.g., charts, recent bookings table). API integration pending.</p>`;
    }

    // Vendor Content Functions (to be refactored similarly)
    function getVendorMyServicesContent() {
        const contentId = 'vendor-my-services-content';
        setTimeout(async () => {
            const container = document.getElementById(contentId);
            if(!container) return;
            container.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            const result = await fetchDashboardData('/vendor/services');
             if (result.success && Array.isArray(result.data)) {
                let serviceCards = '<div class="row row-cols-1 row-cols-md-2 g-3">';
                 if (result.data.length === 0) {
                    serviceCards = '<p class="text-center col-12">You have no services listed yet.</p>';
                } else {
                    result.data.forEach(service => { // Using a simplified card for brevity
                         serviceCards += `
                         <div class="col">
                            <div class="card card-royal">
                                <div class="card-body">
                                    <h5 class="card-title font-serif">${service.title}</h5>
                                    <p class="card-text small text-muted">${service.category}</p>
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                            </div>
                         </div>`;
                    });
                }
                serviceCards += '</div>';
                 container.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-serif mb-0">My Services</h4>
                        <button class="btn btn-royal btn-sm"><i class="bi bi-plus-circle-fill me-2"></i>Add New Service</button>
                    </div>
                    ${serviceCards}`;
             } else {
                container.innerHTML = `<div class="alert alert-danger">${result.message || 'Failed to load your services.'}</div>`;
             }
        },100);
        return `<div id="${contentId}"><div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div></div>`;
    }
    function getVendorBookingsContent() { return `<h4 class="font-serif">My Booking Requests</h4><p>Table/list of booking requests for this vendor's services. API integration pending.</p>`; }
    function getVendorProfileContent() { return `<h4 class="font-serif">My Vendor Profile</h4><p>Form to edit vendor profile details. API integration pending.</p>`; }

    // User Content Functions (can also be refactored for API calls if needed, e.g. /api/user/bookings)
    function getUserMyBookingsContent() { return `<h4 class="font-serif">My Bookings</h4><p>List of user's current and past bookings. <a href="/bookings" class="btn btn-sm btn-royal-outline">View All Bookings</a> (This page also needs API integration)</p>`; }
    function getUserFavoritesContent() { return `<h4 class="font-serif">My Favorite Services</h4><p>Grid of user's favorited services. API integration pending.</p>`; }
    function getUserProfileContent() { return `<h4 class="font-serif">My Profile</h4><p>Form to edit user profile information. API integration pending.</p>`; }

    // --- Initialize ---
    initDashboard();
});
