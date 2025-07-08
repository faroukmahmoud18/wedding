// public/js/booking-form.js
document.addEventListener('DOMContentLoaded', function () {
    const bookingModalEl = document.getElementById('bookingModal');
    const bookingForm = document.getElementById('bookingServiceForm');
    const bookingServiceTitleEl = document.getElementById('bookingModalServiceTitle');
    const bookingServiceIdField = document.getElementById('bookingServiceIdField');
    const formFeedbackEl = document.getElementById('bookingFormFeedback');

    if (bookingModalEl && bookingForm && bookingServiceTitleEl && bookingServiceIdField) {

        // Event listener for when the modal is about to be shown
        bookingModalEl.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const serviceTitle = button ? button.getAttribute('data-bs-service-title') : 'Service';
            const serviceId = button ? button.getAttribute('data-bs-service-id') : '';

            // Update the modal's content.
            bookingServiceTitleEl.textContent = serviceTitle;
            bookingServiceIdField.value = serviceId;

            // Clear previous feedback and validation
            if (formFeedbackEl) formFeedbackEl.innerHTML = '';
            bookingForm.classList.remove('was-validated');
            // bookingForm.reset(); // Optionally reset form fields each time modal opens
        });

        bookingForm.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (formFeedbackEl) formFeedbackEl.innerHTML = ''; // Clear previous feedback

            if (!bookingForm.checkValidity()) {
                bookingForm.classList.add('was-validated');
                 if(formFeedbackEl) {
                    formFeedbackEl.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                             'Please correct the errors in the form.' +
                                             '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                           '</div>';
                }
                return;
            }

            bookingForm.classList.add('was-validated');

            const formData = new FormData(bookingForm);
            const bookingData = {};
            formData.forEach((value, key) => bookingData[key] = value);

            console.log('Booking Request Submitted (Mock):', bookingData);

            // Simulate API call
            if(formFeedbackEl) {
                 formFeedbackEl.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                         '<strong>Booking Request Sent!</strong> Your request for "' + (bookingServiceTitleEl.textContent || 'this service') + '" has been sent. The vendor will contact you shortly.' +
                                         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                       '</div>';
            }

            bookingForm.reset();
            bookingForm.classList.remove('was-validated');

            const submitButton = bookingForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
            submitButton.disabled = true;

            // Real API submission
            const token = getToken(); // From auth.js (ensure auth.js is loaded before this script)
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            };
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            // Add CSRF token if your API routes are protected by web middleware AND you are not using token based auth for this route
            // const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            // if (csrfToken) {
            //     headers['X-CSRF-TOKEN'] = csrfToken;
            // }

            fetch(`${API_BASE_URL}/bookings`, { // API_BASE_URL from config.js
                method: 'POST',
                headers: headers,
                body: JSON.stringify(bookingData),
            })
            .then(async response => {
                const responseData = await response.json();
                if (!response.ok) {
                    // Handle Laravel validation errors (status 422)
                    if (response.status === 422 && responseData.errors) {
                        const errorMessages = Object.values(responseData.errors).flat().join('<br> ');
                        throw new Error(errorMessages);
                    }
                    throw new Error(responseData.message || `HTTP error! status: ${response.status}`);
                }
                return responseData;
            })
            .then(result => {
                console.log('Booking Success:', result);
                if(formFeedbackEl) {
                    formFeedbackEl.innerHTML =
                        `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Booking Request Sent!</strong> Your request for "${bookingServiceTitleEl.textContent || 'this service'}" has been successfully submitted. The vendor will contact you.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>`;
                }
                bookingForm.reset();
                bookingForm.classList.remove('was-validated');
                setTimeout(() => {
                    const modalInstance = bootstrap.Modal.getInstance(bookingModalEl);
                    if (modalInstance) modalInstance.hide();
                }, 3000); // Close modal after 3 seconds
            })
            .catch(error => {
                console.error('Booking Error:', error);
                let errorMessage = error.message || 'An error occurred. Please try again.';
                if(formFeedbackEl) {
                    formFeedbackEl.innerHTML =
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ${errorMessage}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>`;
                }
            })
            .finally(() => {
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
            });
        });
    }
});
