// public/js/contact-form.js
document.addEventListener('DOMContentLoaded', function () {
    const contactForm = document.getElementById('contactForm');
    const formFeedback = document.getElementById('formSubmissionFeedback');

    if (contactForm) {
        contactForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default browser submission
            event.stopPropagation();

            // Remove previous feedback
            if(formFeedback) formFeedback.innerHTML = '';

            // Use Bootstrap's built-in validation display
            if (!contactForm.checkValidity()) {
                contactForm.classList.add('was-validated');
                if(formFeedback) {
                    formFeedback.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                             '<strong>{{ __("Oops!") }}</strong> {{ __("Please correct the errors in the form.") }}' +
                                             '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                           '</div>';
                }
                return;
            }

            contactForm.classList.add('was-validated'); // Show validation styles if all good too

            // If valid, proceed with mock submission
            const formData = new FormData(contactForm);
            const data = {};
            formData.forEach((value, key) => data[key] = value);

            console.log('Contact Form Submitted (mock):', data);

            // Display success message
            if(formFeedback) {
                formFeedback.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                         '<strong>{{ __("Message Sent!") }}</strong> {{ __("Thank you for contacting Royal Vows. We will be in touch soon!") }}' +
                                         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                       '</div>';
            }

            contactForm.reset();
            contactForm.classList.remove('was-validated'); // Reset validation state

            // In a real application, you would use fetch() or XMLHttpRequest to send data to the server
            // For example:
            /*
            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    // Add other headers like 'Accept: application/json' if your backend expects it
                }
            })
            .then(response => response.json()) // Or response.text() depending on backend
            .then(result => {
                console.log('Success:', result);
                if(formFeedback) {
                     formFeedback.innerHTML = '<div class="alert alert-success">...</div>';
                }
                contactForm.reset();
                contactForm.classList.remove('was-validated');
            })
            .catch(error => {
                console.error('Error:', error);
                 if(formFeedback) {
                    formFeedback.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                }
                contactForm.classList.add('was-validated'); // Keep validation styles if server error related to input
            });
            */
        });
    }
});
