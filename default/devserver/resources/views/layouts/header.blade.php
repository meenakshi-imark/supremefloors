<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Supreme Floors | Welcome</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('front/favicon.png')}}" sizes="32x32" type="image/x-icon">

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('front/css/supreme-superfastech.css') }}">

</head>

<body>

  <header id="header" class="header">

    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <a class="navbar-brand" href="#">
          <img src="{{ asset('front/images/logo.png') }}" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/product">Get Quotation</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/warranty-check">Warranty Check</a>
            </li>
            <li class="nav-item">
				@if(Auth::check())
					<form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <span class="nav-link btn">Logout</span>
                            </x-dropdown-link>
                    </form>
				 
				@else
				<a class="nav-link btn" href="{{ route('login') }}">Log In</a>
				@endif	
				
             
              <!-- <a class="nav-link btn btnn" href="#" tabindex="-1" aria-disabled="false">Log In</a> -->
            </li>
          </ul>
        </div>

      </nav>
    </div>

  </header>