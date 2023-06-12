
@include('layouts.header')
<x-guest-layout>
<main id="main">


    <section class="sec-p height-screen login-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <figure>
                        <img src="{{ asset('front/images/login-img.jpg') }}" alt="img">
                    </figure>
                </div>

                <div class="col-lg-6">
                    <div class="login-grid">
                        <div class="login-inner-grid">
                            <div class="heading text-center">
                                <P style="font-weight:600;">Log in to Supreme Floor CRM</P>
                            </div>
                                <!-- Session Status -->
                                <x-auth-session-status class="mb-4" :status="session('status')" />

                                <!-- Validation Errors -->
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <!-- <input type="password" class="form-control"> -->
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control" type="password" name="password"placeholder="Password">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    @if (Route::has('password.request'))
                                    <cite><a  href="{{ route('password.request') }}">Forgot your Password?</a></cite>
                                    @endif
                                    <!-- href="forgot-password.php" -->
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="w-100 btn" style="background: #1FB25A;">Login</button>
                                </div>
                            </form>

                            <cite class="get-help">Having Issues? <a href="#">Get Help</a></cite>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
</x-guest-layout>

@include('layouts.footer')
