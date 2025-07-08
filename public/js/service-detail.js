// public/js/service-detail.js
document.addEventListener('DOMContentLoaded', function () {
    const serviceDetailContentEl = document.getElementById('serviceDetailContent');
    const serviceDetailLoadingEl = document.getElementById('serviceDetailLoading');
    const serviceNotFoundEl = document.getElementById('serviceNotFound');

    // Elements to populate
    const breadcrumbsContainer = document.getElementById('breadcrumbsContainer');
    const primaryServiceImageEl = document.getElementById('primaryServiceImage');
    const serviceTitleEl = document.getElementById('serviceTitle');
    const serviceRatingEl = document.getElementById('serviceRating');
    const serviceLocationEl = document.getElementById('serviceLocation');
    const serviceLongDescriptionEl = document.getElementById('serviceLongDescription');
    const serviceFeaturesListEl = document.getElementById('serviceFeaturesList');
    const vendorLogoPlaceholderEl = document.getElementById('vendorLogoPlaceholder'); // Or img if you have one
    const vendorNameEl = document.getElementById('vendorName');
    const vendorVerifiedBadgeEl = document.getElementById('vendorVerifiedBadge');
    const vendorAboutEl = document.getElementById('vendorAbout');
    const vendorProfileLinkEl = document.getElementById('vendorProfileLink');
    // const fullVendorProfileLinkEl = document.getElementById('fullVendorProfileLink'); // If you have this button
    const servicePriceEl = document.getElementById('servicePrice');
    const serviceUnitEl = document.getElementById('serviceUnit');
    const serviceCategoryLinkContainerEl = document.getElementById('serviceCategoryLinkContainer');

    // Booking Modal Trigger
    const bookNowButtonInCard = document.querySelector('[data-bs-target="#bookingModal"]');


    function getServiceParamsFromURL() {
        const pathParts = window.location.pathname.split('/');
        // Assuming URL like /services/{categorySlug}/{serviceSlugOrId}
        const servicesIndex = pathParts.indexOf('services');
        if (servicesIndex !== -1 && servicesIndex < pathParts.length - 2) {
            return {
                categorySlug: pathParts[servicesIndex + 1],
                serviceSlugOrId: pathParts[servicesIndex + 2]
            };
        }
        return null;
    }

    function formatPrice(price, unitText = 'unit') {
        return '$' + Number(price).toLocaleString() + (unitText ? ` <span class="text-muted fw-normal small">/ ${unitText}</span>` : '');
    }
    function formatPriceRange(priceFrom, priceTo, unitText = 'unit') {
        let priceStr = '$' + Number(priceFrom).toLocaleString();
        if (priceTo && Number(priceTo) > Number(priceFrom)) {
            priceStr += ` - $${Number(priceTo).toLocaleString()}`;
        }
        return priceStr + (unitText ? ` <span class="text-muted fw-normal small">/ ${unitText}</span>` : '');
    }


    const params = getServiceParamsFromURL();

    async function loadServiceDetail() {
        if (!params || !params.serviceSlugOrId) {
            if (serviceDetailLoadingEl) serviceDetailLoadingEl.style.display = 'none';
            if (serviceNotFoundEl) serviceNotFoundEl.style.display = 'block';
            console.error("Service slug/ID not found in URL.");
            return;
        }

        if (serviceDetailLoadingEl) serviceDetailLoadingEl.style.display = 'block';
        if (serviceDetailContentEl) serviceDetailContentEl.style.display = 'none';
        if (serviceNotFoundEl) serviceNotFoundEl.style.display = 'none';

        try {
            // Use API_BASE_URL from config.js (ensure it's loaded globally or imported if using modules)
            const response = await fetch(`${API_BASE_URL}/services/${params.serviceSlugOrId}`);

            if (!response.ok) {
                if (response.status === 404) {
                    if (serviceNotFoundEl) serviceNotFoundEl.style.display = 'block';
                } else {
                    throw new Error(`API error! status: ${response.status}`);
                }
                return; // Stop further processing
            }

            const service = await response.json();
            // Assuming the API for a single service also returns vendor details nested, e.g., service.vendor
            // And category details or that categoryConfig is still globally available from data.js for breadcrumbs etc.
            const localCategoryConfig = typeof categoryConfig !== 'undefined' ? categoryConfig : {};


            if (service) {
                if (serviceDetailContentEl) serviceDetailContentEl.style.display = 'block';

                // --- Populate Breadcrumbs ---
                if (breadcrumbsContainer && localCategoryConfig[service.category]) {
                    const category = localCategoryConfig[service.category];
                    breadcrumbsContainer.innerHTML = `
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/services/${service.category}">${category.title || service.category}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">${service.title}</li>
                    `;
                } else if (breadcrumbsContainer) {
                     breadcrumbsContainer.innerHTML = `
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/services/${service.category}">${service.category}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">${service.title}</li>`;
                }

                document.title = service.title + " - Royal Vows";

                const primaryImage = service.images && service.images.length > 0 ?
                                     service.images.find(img => img.isPrimary) || service.images[0] :
                                     { path: `https://placehold.co/1200x800/EEE/333?text=${encodeURIComponent(service.title)}`, alt: service.title };
                if (primaryServiceImageEl) {
                    primaryServiceImageEl.src = primaryImage.path;
                    primaryServiceImageEl.alt = primaryImage.alt;
                }

                if (serviceTitleEl) serviceTitleEl.textContent = service.title;
                if (serviceRatingEl) {
                    serviceRatingEl.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-star-fill me-1 icon-amber" viewBox="0 0 16 16" style="color: #ffc107;"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                        ${service.rating || 'N/A'} (${service.review_count || service.reviewCount || 0} reviews)
                    `;
                }
                if (serviceLocationEl) {
                     serviceLocationEl.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-geo-alt-fill me-1 icon-gold" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                        ${service.location || 'Not specified'}
                    `;
                }
                if (serviceLongDescriptionEl) serviceLongDescriptionEl.textContent = service.long_description || service.longDescription || service.short_description || 'No description available.';

                if (serviceFeaturesListEl && service.features && Array.isArray(service.features)) {
                    serviceFeaturesListEl.innerHTML = service.features.map(feature => `
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill icon-feature" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <span>${feature}</span>
                        </li>
                    `).join('');
                } else if (serviceFeaturesListEl) {
                    serviceFeaturesListEl.innerHTML = '<li>No specific features listed.</li>';
                }

                if (service.vendor) { // Assuming vendor data is nested in service response
                    const vendor = service.vendor;
                    if (vendorNameEl) vendorNameEl.textContent = vendor.name || 'Vendor details unavailable';
                    if (vendorAboutEl) vendorAboutEl.textContent = vendor.about ? (vendor.about.substring(0,150) + (vendor.about.length > 150 ? '...' : '')) : '';
                    if (vendorProfileLinkEl) vendorProfileLinkEl.href = `/vendors/${vendor.id}`;
                    if (vendorVerifiedBadgeEl) {
                        vendorVerifiedBadgeEl.innerHTML = vendor.verified ?
                            '<span class="badge ms-2" style="background-color: var(--royal-gold); color: var(--deep-brown); font-size:0.7rem;">Verified</span>' : '';
                    }
                } else {
                     if (vendorNameEl) vendorNameEl.textContent = 'Vendor details unavailable';
                }

                if (servicePriceEl) servicePriceEl.innerHTML = formatPriceRange(service.price_from || service.priceFrom, service.price_to || service.priceTo, null);
                if (serviceUnitEl) serviceUnitEl.textContent = `/ ${service.unit || 'service'}`;
                if (serviceCategoryLinkContainerEl && localCategoryConfig[service.category]) {
                     serviceCategoryLinkContainerEl.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag-fill me-1 icon-gold" viewBox="0 0 16 16"><path d="M2 2a2 2 0 0 1 2-2h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg>
                        Category: <a href="/services/${service.category}" class="ms-1 text-decoration-none hover-underline" style="color:var(--royal-gold);">${localCategoryConfig[service.category].title || service.category}</a>
                     `;
                } else if (serviceCategoryLinkContainerEl) {
                     serviceCategoryLinkContainerEl.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag-fill me-1 icon-gold" viewBox="0 0 16 16"><path d="M2 2a2 2 0 0 1 2-2h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg>
                        Category: <a href="/services/${service.category}" class="ms-1 text-decoration-none hover-underline" style="color:var(--royal-gold);">${service.category}</a>
                     `;
                }

                if (bookNowButtonInCard) {
                    bookNowButtonInCard.setAttribute('data-bs-service-title', service.title);
                    bookNowButtonInCard.setAttribute('data-bs-service-id', service.id);
                }

            } else { // Service not found from API
                if (serviceNotFoundEl) serviceNotFoundEl.style.display = 'block';
            }
        } catch (error) {
            console.error("Failed to load service details:", error);
            if (serviceNotFoundEl) serviceNotFoundEl.style.display = 'block'; // Show generic not found on error
        } finally {
            if (serviceDetailLoadingEl) serviceDetailLoadingEl.style.display = 'none';
        }
    }

    loadServiceDetail();
});
