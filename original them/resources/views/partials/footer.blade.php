{{-- resources/views/partials/footer.blade.php --}}
@php
    // Placeholder for dynamic links, actual links would be generated via Laravel routes or config
    $footerServiceLinks = [
        ['name' => __('Photography'), 'href' => url('/services/photography')],
        ['name' => __('Venues'), 'href' => url('/services/venues')],
        ['name' => __('Dresses'), 'href' => url('/services/dresses')],
        ['name' => __('Makeup'), 'href' => url('/services/makeup')],
    ];
    $footerSupportLinks = [
        ['name' => __('Help Center'), 'href' => url('/help')],
        ['name' => __('Contact Us'), 'href' => url('/contact')],
        ['name' => __('Become a Vendor'), 'href' => url('/vendor/register')],
    ];
@endphp

<footer class="site-footer mt-auto pt-5 pb-4">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 text-center text-lg-start mb-4 mb-lg-0">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                    {{-- SVG Crown (from RoyalMotifs.tsx) - converted to inline SVG --}}
                    <svg class="royal-motif me-2" width="36" height="36" viewBox="0 0 24 24" fill="none" style="color: var(--royal-gold);">
                         <path d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="currentColor" />
                         <circle cx="9" cy="4" r="1" fill="currentColor" />
                         <circle cx="12" cy="8" r="1" fill="currentColor" />
                         <circle cx="15" cy="4" r="1" fill="currentColor" />
                         <path d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z" fill="currentColor" />
                    </svg>
                    <span style="font-family: var(--font-serif); font-size: 1.8rem; font-weight: bold; color: var(--royal-gold);">
                        {{ __('Royal Vows') }}
                    </span>
                </div>
                <p class="mb-0 small footer-tagline">
                    {{ __('Discover the finest wedding services from premium vendors. Create your perfect royal wedding experience.') }}
                </p>
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <h5 class="footer-heading">{{ __('Services') }}</h5>
                <ul class="list-unstyled footer-links">
                    @foreach ($footerServiceLinks as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <h5 class="footer-heading">{{ __('Support') }}</h5>
                <ul class="list-unstyled footer-links">
                    @foreach ($footerSupportLinks as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h5 class="footer-heading">{{ __('Stay Connected') }}</h5>
                <p class="small mb-2">{{ __('Sign up for our newsletter for exclusive offers and wedding inspirations.') }}</p>
                <form action="{{ url('/newsletter-subscribe') }}" method="POST" class="newsletter-form"> {{-- Add CSRF token if it's a real form submission --}}
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="{{ __('Your Email') }}" aria-label="{{ __('Your Email') }}" required>
                        <button class="btn btn-sm btn-royal-outline" type="submit">{{ __('Subscribe') }}</button>
                    </div>
                </form>
                {{-- Social media icons placeholder --}}
                <div class="social-icons mt-2">
                    <span class="small me-2">{{ __('Follow us:') }}</span>
                    <a href="#" class="social-icon" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/></svg></a>
                    <a href="#" class="social-icon ms-2" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.703.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372.527-.205.973-.478 1.417-.923.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.231s.008-2.389.046-3.232c.035-.78.166-1.204.275-1.486.145-.373.319-.64.599-.92.28-.28.546.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/></svg></a>
                    <a href="#" class="social-icon ms-2" aria-label="Pinterest"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pinterest" viewBox="0 0 16 16"><path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z"/></svg></a>
                </div>
            </div>
        </div>
        <hr class="footer-divider my-4">
        <div class="text-center small copyright-text">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', __('Royal Vows')) }}. {{ __('All rights reserved. Creating magical moments since forever.') }}</p>
        </div>
    </div>
</footer>

{{-- Styles for this footer are in public/css/style.css under .site-footer --}}
{{-- Or you can scope them here if preferred using a <style> tag, but external CSS is cleaner. --}}
{{-- Example of scoped style if needed for some reason (generally avoid for maintainability):
<style>
    .site-footer { /* styles from style.css are preferred */ }
</style>
--}}
