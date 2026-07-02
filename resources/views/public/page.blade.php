@extends('layouts.public')

@section('content')
<section class="page-banner">
    <nav aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><strong>{{ $title }}</strong></nav>
    <h1>{{ $title }}</h1>
    <p>Enterprise-grade hospital experiences built on secure, scalable workflows.</p>
</section>

<section class="section split-band">
    <div>
        <span class="eyebrow">AarogyaCare</span>
        <h2>{{ $title }} designed for modern care teams</h2>
        <p>This foundation page is wired into the CMS-ready public website structure with SEO metadata, accessible layout, responsive navigation, and conversion-ready calls to action.</p>
        <a class="btn btn-primary" href="{{ route('public.page', 'appointment') }}">Book Appointment</a>
    </div>
    <img class="band-image" src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1000&q=85" alt="Clinical care workspace">
</section>
@endsection
