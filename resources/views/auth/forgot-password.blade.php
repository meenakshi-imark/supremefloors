<x-guest-layout>
@include('layouts.header')

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
                                <h1>
                                Forgot your Password?
                                </h1>
                                <p>
                                Don't worry! just fill in your email and we'll send you a link to reset your password.
                                </p>
                            </div>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control" placeholder="davidsmith@gmail.com">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="w-100 btn">Reset Password</button>
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


@include('layouts.footer')
</x-guest-layout>