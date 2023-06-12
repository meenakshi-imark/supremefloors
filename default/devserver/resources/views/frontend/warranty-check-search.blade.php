@include('layouts.header')

<main id="main">


    <section class="sec-p height-screen login-sec search-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="login-grid search-grid">
                        <div class="search-inner-grid">

                            <div class="p-box">
                                <p>
                                    Check your warranty status with a single click by entering your postal code.
                                </p>
                            </div>

                            <form>
                                <div class="form-group">
                                    <i class="fa fa-search"></i>
                                    <label class="form-label">Search</label>
                                    <input type="text" class="form-control" placeholder="Enter Postal Code">
                                </div>
                            </form>

                            <div class="p-box">
                                <b>Note:</b>
                                <p>
                                    Enter your postal code in the search bar. If your address is in our database, you will see the status of your warranty.
                                </p>
                                <br>
                                <p>
                                    If you require help, contact us at +65 4444-4444.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-7 p-0">
                    <div class="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.557255445572!2d103.80405571533079!3d1.4405927616770473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da13de7742f72d%3A0x98be6e35e4230fde!2sKimly%20Seafood%20(691%20Woodlands%20Drive%2073)!5e0!3m2!1sen!2sin!4v1656568949260!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>


@include('layouts.footer')