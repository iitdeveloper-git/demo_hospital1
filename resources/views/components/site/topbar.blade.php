<div class="top-bar" aria-label="Hospital contact bar">
    <div class="top-bar__left">
        <a href="tel:+911800123456"><i class="fa-solid fa-truck-medical"></i> Emergency: +91 1800 123 456</a>
        <a href="mailto:care@aarogyacare.com"><i class="fa-solid fa-envelope"></i> care@aarogyacare.com</a>
        <span><i class="fa-solid fa-clock"></i> Mon-Sun: 24 Hours</span>
    </div>
    <div class="top-bar__right">
        <div class="social-links" aria-label="Social media links">
            <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <label class="language-switcher">
            <span class="sr-only">Language</span>
            <select aria-label="Language switcher">
                <option>EN</option>
                <option>HI</option>
                <option>TA</option>
            </select>
        </label>
        <a class="top-login" href="{{ route('dashboard.role', 'patient') }}">Patient Login</a>
        <a class="top-login" href="{{ route('dashboard.role', 'doctor') }}">Doctor Login</a>
        <a class="top-appointment" href="{{ route('public.page', 'appointment') }}">Book Appointment</a>
    </div>
</div>
