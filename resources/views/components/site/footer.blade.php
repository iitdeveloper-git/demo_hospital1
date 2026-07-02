<footer class="site-footer premium-footer">
    <div class="footer-brand">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark"><i class="fa-solid fa-heart-pulse"></i></span>
            <span>AarogyaCare</span>
        </a>
        <p>Advanced AI Powered Hospital Management System for hospitals, clinics, diagnostics, pharmacy, and connected patient care.</p>
        <div class="social-links">
            <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
        </div>
    </div>
    <div>
        <h3>Quick Links</h3>
        <a href="{{ route('public.page', 'about') }}">About</a>
        <a href="{{ route('public.page', 'services') }}">Services</a>
        <a href="{{ route('public.page', 'doctors') }}">Doctors</a>
        <a href="{{ route('public.page', 'contact') }}">Contact</a>
    </div>
    <div>
        <h3>Departments</h3>
        <a href="{{ route('public.page', 'departments') }}">Cardiology</a>
        <a href="{{ route('public.page', 'departments') }}">Neurology</a>
        <a href="{{ route('public.page', 'departments') }}">Radiology</a>
        <a href="{{ route('public.page', 'departments') }}">Emergency</a>
    </div>
    <div>
        <h3>Working Hours</h3>
        <p>Emergency: 24x7</p>
        <p>OPD: 8:00 AM - 8:00 PM</p>
        <p>Diagnostics: 6:00 AM - 10:00 PM</p>
        <form class="footer-newsletter">
            <label class="sr-only" for="footer-email">Newsletter email</label>
            <input id="footer-email" type="email" placeholder="Email address" required>
            <button class="btn btn-primary" type="submit">Subscribe</button>
        </form>
    </div>
    <div class="footer-bottom">
        <span>Copyright {{ date('Y') }} AarogyaCare. All rights reserved.</span>
        <div>
            <a href="{{ route('public.page', 'privacy-policy') }}">Privacy</a>
            <a href="{{ route('public.page', 'terms') }}">Terms</a>
        </div>
    </div>
</footer>
