// public/js/service-category.js
document.addEventListener('DOMContentLoaded', function () {
    const categoryHeader = document.getElementById('categoryHeader');
    const categoryIconContainer = document.getElementById('categoryIconContainer');
    const categoryTitleEl = document.getElementById('categoryTitle');
    const categoryDescriptionEl = document.getElementById('categoryDescription');
    const serviceListingContainer = document.getElementById('serviceListing');
    const noServicesFoundEl = document.getElementById('noServicesFound');
    const categoryLoadingEl = document.getElementById('categoryLoading');
    const categoryNotFoundEl = document.getElementById('categoryNotFound');
    const filtersSection = document.getElementById('filtersSection');
    const applyFiltersBtn = document.getElementById('applyFiltersBtn');

    // --- Helper Functions ---
    function getCategorySlugFromURL() {
        const pathParts = window.location.pathname.split('/');
        // Assuming URL like /services/{categorySlug}
        // Find 'services' and take the next part as slug
        const servicesIndex = pathParts.indexOf('services');
        if (servicesIndex !== -1 && servicesIndex < pathParts.length - 1) {
            return pathParts[servicesIndex + 1];
        }
        return null;
    }

    function formatPrice(price) {
        return '$' + Number(price).toLocaleString();
    }

    function createServiceCardHTML(service) {
        const vendorName = service.vendor ? service.vendor.name : 'Unknown Vendor';
        const primaryImage = service.images && service.images.length > 0 ?
                             service.images.find(img => img.isPrimary) || service.images[0] :
                             { path: 'https://placehold.co/600x400/EEE/333?text=Service', alt: 'Placeholder' };

        // Use Laravel's url() function for links if this were a Blade template being processed by PHP.
        // Since this is client-side JS, we construct paths manually.
        const serviceDetailUrl = `/services/${service.category}/${service.slug}`; // Adjust if Laravel routes are different
        const vendorProfileUrl = `/vendors/${service.vendorId}`; // Adjust

        return `
            <div class="col">
                <div class="card card-royal h-100 service-card hover-lift shadow-sm position-relative">
                    ${service.featured ? `
                        <div class="position-absolute top-0 start-0 m-2" style="z-index: 1;">
                            <span class="badge px-2 py-1" style="font-size: 0.7rem; background-color: var(--royal-gold); color: var(--deep-brown);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-patch-check-fill me-1" viewBox="0 0 16 16" style="margin-top:-2px;">
                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89.01-.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89-.01.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                </svg>
                                Featured
                            </span>
                        </div>
                    ` : ''}
                    <a href="${serviceDetailUrl}" class="text-decoration-none service-card-image-link">
                        <img src="${primaryImage.path}" class="card-img-top service-card-img" alt="${primaryImage.alt}">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <a href="${vendorProfileUrl}" class="text-muted text-decoration-none hover-underline small vendor-link">
                                ${vendorName}
                            </a>
                            <span class="badge category-badge">${service.category.charAt(0).toUpperCase() + service.category.slice(1)}</span>
                        </div>
                        <h3 class="font-serif h6 card-title mb-2 flex-grow-1">
                            <a href="${serviceDetailUrl}" class="text-decoration-none service-title-link">
                                ${service.title}
                            </a>
                        </h3>
                        <p class="card-text small mb-3 service-short-description">
                            ${service.shortDescription.substring(0, 70)}${service.shortDescription.length > 70 ? '...' : ''}
                        </p>
                        <div class="d-flex justify-content-between align-items-center text-sm mb-3 service-meta">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-geo-alt-fill me-1 icon-gold" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                                ${service.location}
                            </div>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-star-fill me-1 icon-amber" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                                ${service.rating} (${service.reviewCount})
                            </div>
                        </div>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 fw-bold service-price">
                                    ${formatPrice(service.priceFrom)}
                                    <span class="text-muted fw-normal small">/ ${service.unit}</span>
                                </p>
                                <a href="${serviceDetailUrl}" class="btn btn-sm btn-royal">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function displayServices(servicesToDisplay) {
        if (!serviceListingContainer || !noServicesFoundEl) return;
        serviceListingContainer.innerHTML = ''; // Clear previous listings

        if (servicesToDisplay.length === 0) {
            noServicesFoundEl.style.display = 'block';
            serviceListingContainer.style.display = 'none';
        } else {
            noServicesFoundEl.style.display = 'none';
            serviceListingContainer.style.display = 'flex'; // Or 'grid' if you prefer grid for row display
            servicesToDisplay.forEach(service => {
                serviceListingContainer.innerHTML += createServiceCardHTML(service);
            });
        }
    }

    // --- Main Logic ---
    const categorySlug = getCategorySlugFromURL();

    async function loadCategoryData() {
        if (!categorySlug) {
            if (categoryLoadingEl) categoryLoadingEl.style.display = 'none';
            if (categoryNotFoundEl) categoryNotFoundEl.style.display = 'block';
            console.error("Category slug not found in URL.");
            return;
        }

        if (categoryLoadingEl) categoryLoadingEl.style.display = 'block';
        if (categoryHeader) categoryHeader.style.display = 'none';
        if (filtersSection) filtersSection.style.display = 'none';
        if (serviceListingContainer) serviceListingContainer.style.display = 'none';
        if (noServicesFoundEl) noServicesFoundEl.style.display = 'none';
        if (categoryNotFoundEl) categoryNotFoundEl.style.display = 'none';


        try {
            // First, attempt to get category config details (if you have an endpoint for it, or use local config)
            // For this conversion, we'll assume categoryConfig is still available from data.js for icons/descriptions
            // or that the service API provides enough detail.
            // If categoryConfig itself were from an API:
            // const categoryConfigResponse = await fetch(`${API_BASE_URL}/categories/${categorySlug}`);
            // if (!categoryConfigResponse.ok) throw new Error('Category config not found');
            // const currentCategory = await categoryConfigResponse.json();

            // Using local categoryConfig for now, assuming it's loaded before this script or part of data.js
            const localCategoryConfig = typeof categoryConfig !== 'undefined' ? categoryConfig : null;
            const currentCategory = localCategoryConfig ? localCategoryConfig[categorySlug] : null;

            if (currentCategory) {
                if (categoryHeader && categoryIconContainer && categoryTitleEl && categoryDescriptionEl) {
                    categoryIconContainer.textContent = currentCategory.icon || '👑';
                    categoryTitleEl.textContent = currentCategory.title || categorySlug.charAt(0).toUpperCase() + categorySlug.slice(1);
                    categoryDescriptionEl.textContent = currentCategory.description || `Services in the ${categorySlug} category.`;
                    categoryHeader.style.display = 'block';
                    document.title = (currentCategory.title || categorySlug) + " - Royal Vows";
                }
            } else {
                // Fallback if local categoryConfig doesn't have the slug
                 if (categoryHeader && categoryTitleEl) {
                    categoryTitleEl.textContent = categorySlug.charAt(0).toUpperCase() + categorySlug.slice(1);
                    if(categoryIconContainer) categoryIconContainer.textContent = '👑';
                    if(categoryDescriptionEl) categoryDescriptionEl.textContent = `Services in the ${categorySlug} category.`;
                    categoryHeader.style.display = 'block';
                    document.title = categorySlug + " - Royal Vows";
                 }
            }


            // Fetch services for the category
            // const response = await fetch(`${API_BASE_URL}/services/category/${categorySlug}`); // Or your actual endpoint
            const response = await fetch(`${API_BASE_URL}/services?category=${categorySlug}`); // Assuming an endpoint like this

            if (!response.ok) {
                if (response.status === 404) {
                    displayServices([]); // Show "no services found"
                } else {
                    throw new Error(`API error! status: ${response.status}`);
                }
            } else {
                const servicesData = await response.json();
                // The services data might be paginated, e.g., servicesData.data
                const servicesToDisplay = servicesData.data || servicesData; // Adjust based on your API structure

                // The API response for services should ideally include necessary vendor info (name)
                // If not, you might need another fetch or adjust the createServiceCardHTML function
                displayServices(servicesToDisplay);
            }

            if (filtersSection) filtersSection.style.display = 'block';

        } catch (error) {
            console.error("Failed to load category data:", error);
            if (categoryNotFoundEl) categoryNotFoundEl.style.display = 'block'; // Generic error display
            if (categoryHeader) categoryHeader.style.display = 'none';
            if (filtersSection) filtersSection.style.display = 'none';
        } finally {
            if (categoryLoadingEl) categoryLoadingEl.style.display = 'none';
        }
    }

    loadCategoryData();

    // Filter button functionality (placeholder, would also make API calls)
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            const sortBy = document.getElementById('sortBy').value;
            const priceMin = document.getElementById('priceMin').value;
            const priceMax = document.getElementById('priceMax').value;
            const minRating = document.getElementById('minRating').value;
            console.log("Applying Filters (mock):", { sortBy, priceMin, priceMax, minRating, categorySlug });

            // Actual filtering logic would go here, re-calling displayServices with new list
            // For now, just re-displaying the same category services as an example
            const currentServices = sampleServices.filter(service => service.category === categorySlug);
            displayServices(currentServices);

            alert('Filter functionality is for demonstration and not fully implemented in this static version.');
        });
    }

});
