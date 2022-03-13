<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title')</title>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="shortcut icon" href="{{ asset('images/gcc icon-01.png') }}">
  <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
  <link href="{{ asset('css/back.css') }}" rel="stylesheet">
  <link href="{{ asset('css/progressbar.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/jquery.expandable.js') }}"></script>
  <link href="{{ asset('css/jquery.expandable.css') }}" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
  <!--navigationbar-->
  <nav>
    <input type="checkbox" id="nav" class="hidden">
    <label for="nav" class="nav-btn">
      <i></i>
      <i></i>
      <i></i>
    </label>
    <div class="logo">
      @if (Auth::check())
      <a href="{{ url(Auth::user()->roles->getPrefix()) }}"><img src="/company_logo/{{ $company_logo->photo_name }}"></a>
      @else
      <a href="/"><img src="/company_logo/{{ $company_logo->photo_name }}"></a>
      @endif
    </div>
    <div class="nav-wrapper" style="margin-top:-5px">
      <ul class="nav justify-content-end">
        @if (Auth::check())
        <li class="nav-item">
          <a href="{{ url(Auth::user()->roles->getPrefix()) }}">HOME</a>
        </li>
        @else
        <li class="nav-item">
          <a href="/">HOME</a>
        </li>
        @endif
        <li class="nav-item">
         <a href="/"  data-toggle="modal" data-target=".bd-example-modal-lg">How It Works?</a>
       </li>
       <li class="nav-item">
         <a href="/faqs">FAQ</a>
       </li>
       <li class="nav-item">
        <a href="/jobs">Search Jobs</a>
      </li>
      <li class="nav-item">
        <a href="/companies">Companies</a>
      </li>
      @if (Auth::check() && Auth::user())
      <li class="nav-item dropdown">
        <a class="dropdown-toggle" id="btnaccount" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="{{ url(Auth::user()->roles->getPrefix(). '/profile') }}">My Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
      @else
      <li class="nav-item">
        <a href="{{ route('login') }}">LOGIN</a>
      </li>
      @endif
    </ul>
  </div>
</nav>
<!--end of navigationbar-->
<!--content-->
@yield('content')
<!--end of content-->

<!--footer-->
<footer>
  <p><a href="/"  data-toggle="modal" data-target=".bd-example-modal-lg">How It Works?</a> | <a href="/blog">Blog</a> | <a href="/about">About Us</a> | <a href="/testimony">Testimonials</a> | <a href="/contact">Contact Support</a> | <a href="/terms">Terms of Use</a> | <a href="/privacy">Privacy Policy</a> |  <a href="/help">Help</a> |  <a href="/feedback">Send Feedback</a></p>
  <p>All Right Reserved | Global Careers Creation | &copy; 2019-{{ now()->year }}</p>
</footer>
<!--end offooter-->
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
//for sliding animation
AOS.init({
  //disable all the aos animation when the screen turn to mobile size
  disable: 'mobile'
  once: 'true'
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@include('sweetalert::alert')
</html>
