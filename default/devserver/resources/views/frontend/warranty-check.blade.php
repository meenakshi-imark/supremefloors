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
                                    Warranty Check
                                </h1>
                                <p>
                                    Please check the box below to proceed.
                                </p>
                            </div>

                            <figure class="w-50 m-auto mb-4">
                                <img src="{{ asset('front/images/capcha.png') }}" alt="img">
                            </figure>

                            <cite class="get-help">Having Issues? <a href="#">Get Help</a></cite>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>


@include('layouts.footer')