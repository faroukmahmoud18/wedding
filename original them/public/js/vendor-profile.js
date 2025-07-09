// public/js/vendor-profile.js
document.addEventListener('DOMContentLoaded', function () {
    const vendorProfileContentEl = document.getElementById('vendorProfileContent');
    const vendorProfileLoadingEl = document.getElementById('vendorProfileLoading');
    const vendorNotFoundEl = document.getElementById('vendorNotFound');
    const vendorInfoCardContainerEl = document.getElementById('vendorInfoCardContainer');
    const vendorServicesTitleEl = document.getElementById('vendorServicesTitle');
    const vendorServiceListingEl = document.getElementById('vendorServiceListing');
    const noVendorServicesFoundEl = document.getElementById('noVendorServicesFound');
    const noVendorServicesTextEl = document.getElementById('noVendorServicesText');

    // --- Helper Functions ---
    function getVendorIdFromURL() {
        const pathParts = window.location.pathname.split('/');
        // Assuming URL like /vendors/{vendorId}
        const vendorsIndex = pathParts.indexOf('vendors');
        if (vendorsIndex !== -1 && vendorsIndex < pathParts.length - 1) {
            return pathParts[vendorsIndex + 1];
        }
        return null;
    }

    function formatPrice(price) { // Re-defined here, or move to a global utility JS file
        return '$' + Number(price).toLocaleString();
    }

    function createVendorInfoCardHTML(vendor) {
        let verifiedBadgeHTML = '';
        if (vendor.verified) {
            verifiedBadgeHTML = `
                <span class="badge vendor-verified-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-patch-check-fill me-1" viewBox="0 0 16 16">
                        <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89.01-.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89-.01.622-.636zM7.646 6.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707l-1.146 1.147a.5.5 0 0 1-.708-.708l2-2z"/>
                    </svg>
                    Verified Vendor
                </span>`;
        }
         // Star icon for rating
        let ratingStarsHTML = '';
        if (vendor.rating && vendor.rating > 0) {
            for (let i = 0; i < 5; i++) {
                ratingStarsHTML += `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="${i < Math.round(vendor.rating) ? 'var(--royal-gold)' : 'var(--border-color)'}" class="bi bi-star-fill me-1" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>`;
            }
        }


        return `
            <div class="card card-royal shadow-lg vendor-info-display-card">
                <div class="card-header text-center bg-transparent border-bottom-0 pt-4 pb-3 position-relative">
                    <div class="position-absolute top-0 end-0 m-3 opacity-25">
                        <svg class="royal-motif" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" style="color: var(--royal-gold);"><path d="M12 3L10 8L12 12L14 8L12 3Z" /><path d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z" /><path d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z" /><path d="M10 16L12 20L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="vendor-logo-placeholder rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <svg class="royal-motif" width="50" height="50" viewBox="0 0 24 24" fill="currentColor"><path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="4" r="1"/><circle cx="12" cy="8" r="1"/><circle cx="15" cy="4" r="1"/><path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z"/></svg>
                    </div>
                    <h1 class="font-serif h2 vendor-name mb-1">${vendor.name}</h1>
                    ${verifiedBadgeHTML}
                    <div class="mt-1 small text-muted d-flex justify-content-center align-items-center">
                        ${ratingStarsHTML}
                        <span class="ms-2">(${vendor.rating} / ${vendor.reviewCount} reviews)</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="font-serif h6 text-muted mb-3 text-center">About ${vendor.name}</h5>
                    <p class="text-muted small lh-lg">${vendor.about}</p>
                    <hr class="my-4" style="border-color: var(--border-color);">
                    <h5 class="font-serif h6 text-muted mb-3 text-center">Contact Information</h5>
                    <ul class="list-unstyled contact-info-list">
                        ${vendor.address ? `<li class="d-flex align-items-center mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill flex-shrink-0 me-2 icon-contact" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg> <span class="small">${vendor.address}</span></li>` : ''}
                        ${vendor.phone ? `<li class="d-flex align-items-center mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill flex-shrink-0 me-2 icon-contact" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg> <a href="tel:${vendor.phone}" class="text-decoration-none contact-link small">${vendor.phone}</a></li>` : ''}
                        ${vendor.email ? `<li class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill flex-shrink-0 me-2 icon-contact" viewBox="0 0 16 16"><path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/></svg> <a href="mailto:${vendor.email}" class="text-decoration-none contact-link small">${vendor.email}</a></li>` : ''}
                    </ul>
                </div>
            </div>
        `;
    }

    // Re-use createServiceCardHTML from service-category.js or redefine if different
    // For this example, assume it's available or we'll copy a simplified one
    function createServiceCardHTML_VendorPage(service) { // Copied and slightly adapted if needed
        const vendorName = service.vendor ? service.vendor.name : 'Unknown Vendor';
        const primaryImage = service.images && service.images.length > 0 ?
                             service.images.find(img => img.isPrimary) || service.images[0] :
                             { path: 'https://placehold.co/600x400/EEE/333?text=Service', alt: 'Placeholder' };
        const serviceDetailUrl = `/services/${service.category}/${service.slug}`;

        return `
            <div class="col">
                <div class="card card-royal h-100 service-card hover-lift shadow-sm position-relative">
                    ${service.featured ? `<div class="position-absolute top-0 start-0 m-2" style="z-index: 1;"><span class="badge px-2 py-1" style="font-size: 0.7rem; background-color: var(--royal-gold); color: var(--deep-brown);">Featured</span></div>` : ''}
                    <a href="${serviceDetailUrl}" class="text-decoration-none service-card-image-link">
                        <img src="${primaryImage.path}" class="card-img-top service-card-img" alt="${primaryImage.alt}">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <span class="badge category-badge mb-2 align-self-start">${service.category.charAt(0).toUpperCase() + service.category.slice(1)}</span>
                        <h3 class="font-serif h6 card-title mb-2 flex-grow-1">
                            <a href="${serviceDetailUrl}" class="text-decoration-none service-title-link">${service.title}</a>
                        </h3>
                        <p class="card-text small mb-3 service-short-description">${service.shortDescription.substring(0, 70)}${service.shortDescription.length > 70 ? '...' : ''}</p>
                        <div class="d-flex justify-content-between align-items-center text-sm mb-3 service-meta">
                            <div class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-geo-alt-fill me-1 icon-gold" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg> ${service.location}</div>
                            <div class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-star-fill me-1 icon-amber" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg> ${service.rating} (${service.reviewCount})</div>
                        </div>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 fw-bold service-price">${formatPrice(service.priceFrom)} <span class="text-muted fw-normal small">/ ${service.unit}</span></p>
                                <a href="${serviceDetailUrl}" class="btn btn-sm btn-royal">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }


    // --- Main Logic ---
    const vendorId = getVendorIdFromURL();

    async function loadVendorProfileData() {
        if (!vendorId) {
            if (vendorProfileLoadingEl) vendorProfileLoadingEl.style.display = 'none';
            if (vendorNotFoundEl) vendorNotFoundEl.style.display = 'block';
            console.error("Vendor ID not found in URL.");
            return;
        }

        if (vendorProfileLoadingEl) vendorProfileLoadingEl.style.display = 'block';
        if (vendorProfileContentEl) vendorProfileContentEl.style.display = 'none';
        if (vendorNotFoundEl) vendorNotFoundEl.style.display = 'none';
        if (noVendorServicesFoundEl) noVendorServicesFoundEl.style.display = 'none';


        try {
            // Fetch Vendor Details
            const vendorResponse = await fetch(`${API_BASE_URL}/vendors/${vendorId}`);
            if (!vendorResponse.ok) {
                if (vendorResponse.status === 404) {
                    if (vendorNotFoundEl) vendorNotFoundEl.style.display = 'block';
                    if (vendorProfileLoadingEl) vendorProfileLoadingEl.style.display = 'none';
                    return;
                }
                throw new Error(`API error (vendor)! status: ${vendorResponse.status}`);
            }
            const vendor = await vendorResponse.json();

            // Populate Vendor Info
            if (vendor) {
                if (vendorProfileContentEl) vendorProfileContentEl.style.display = 'block';
                document.title = (vendor.name || 'Vendor Profile') + " - Royal Vows";
                if (vendorInfoCardContainerEl) {
                    vendorInfoCardContainerEl.innerHTML = createVendorInfoCardHTML(vendor);
                }
                if (vendorServicesTitleEl) {
                    vendorServicesTitleEl.textContent = `Services by ${vendor.name || 'this Vendor'}`;
                }

                // Fetch Services by this Vendor
                // const servicesResponse = await fetch(`${API_BASE_URL}/vendors/${vendorId}/services`);
                // For now, let's assume the main /api/services endpoint can be filtered by vendor_id
                // This depends on your API design.
                const servicesResponse = await fetch(`${API_BASE_URL}/services?vendor_id=${vendorId}`);

                if (!servicesResponse.ok) {
                    // Handle case where vendor exists but services fetch fails, or no services
                    console.warn(`Could not fetch services for vendor ${vendorId}: ${servicesResponse.status}`);
                    displayVendorServices([]); // Show "no services" message
                } else {
                    const servicesData = await servicesResponse.json();
                    const servicesByVendor = servicesData.data || servicesData; // Adjust based on API pagination

                    // The services from this endpoint might not have the full vendor object nested.
                    // We already have the main vendor object, so createServiceCardHTML_VendorPage might need adjustment
                    // or ensure the service card function can work with just vendor_id if needed.
                    // For now, assuming createServiceCardHTML_VendorPage can handle it or we pass the main vendor object.
                    servicesByVendor.forEach(service => {
                        if (!service.vendor) service.vendor = vendor; // Attach main vendor object if not present
                    });
                    displayVendorServices(servicesByVendor, vendor.name || 'This vendor');
                }
            } else { // Vendor not found from the first API call
                if (vendorNotFoundEl) vendorNotFoundEl.style.display = 'block';
            }

        } catch (error) {
            console.error("Failed to load vendor profile data:", error);
            if (vendorNotFoundEl) vendorNotFoundEl.style.display = 'block';
        } finally {
            if (vendorProfileLoadingEl) vendorProfileLoadingEl.style.display = 'none';
        }
    }

    function displayVendorServices(services, vendorName) {
        if (vendorServiceListingEl && noVendorServicesFoundEl && noVendorServicesTextEl) {
            vendorServiceListingEl.innerHTML = ''; // Clear
            if (services && services.length > 0) {
                noVendorServicesFoundEl.style.display = 'none';
                vendorServiceListingEl.style.display = 'flex'; // or 'grid' if it's a row
                services.forEach(service => {
                    vendorServiceListingEl.innerHTML += createServiceCardHTML_VendorPage(service);
                });
            } else {
                vendorServiceListingEl.style.display = 'none';
                noVendorServicesTextEl.textContent = `${vendorName} has not listed any services yet.`;
                noVendorServicesFoundEl.style.display = 'block';
            }
        }
    }

    loadVendorProfileData();
});
