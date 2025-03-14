@extends('home.layout.layout')

@section('content')
    <section class="Hero bg-custom">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 mx-auto d-flex flex-column justify-content-center align-items-center">
                    <h1 class="text-white fw-bold text-center">AI <span class="text-primary">Powered</span> Trading Robot
                        </br> For Everyone</h1>
                    <p class="text-white fw-semibold"> AI Robot That Trades For You And Makes Daily Profit </p>
                    <a href="/user/register/null"
                        class="btn btn-primary btn-block w-100 btn-lg my-3 py-3 text-uppercase fw-bold"
                        style="font-size: 13px;" type="button">Start trading</a>
                </div>
            </div>
        </div>
    </section>

    <section class="inovation py-2 bg-custom">
        <div class="container">
            <div class="row gy-3 justify-content-center">
                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/metatrader.svg" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/chatgpt.svg" alt="">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/forex.svg" alt="">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/tradingview.svg" alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="inovation py-5 bg-light border">
        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/award/benzinga.svg" style="width: 120px;" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/award/fx-trading.svg" style="width: 120px;" alt="">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/award/invezz.svg" style="width: 120px;" alt="">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/award/slash-dot.svg" style="width: 80px;" alt="">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/award/source-forge.svg" style="width: 80px;" alt="" width="100%">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/award/techopedia.svg" style="width: 120px;" alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- <section class="testimonial py-5 bg-gray" id="testimonials">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide d-flex flex-column">
                            <div class="img-container">
                                <img src="/images/testimonial/bharti.webp" alt="" width="100%">
                                <div class="img-caption d-flex flex-column justify-content-center text-start">
                                    <p class="mb-0 fs-6">Trader</p>
                                    <h6 class="mb-0">Wouter Benjins</h6>

                                </div>
                            </div>

                            <div class="swipe-text bg-new w-100 text-start p-2">
                                <p class="mb-0 fw-bold fs-6">Monthly Gain</p>
                                <h1 class="mt-0 fw-bold">25%</h1>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex flex-column">
                            <div class="img-container">
                                <img src="/images/testimonial/bijnens.webp" alt="" width="100%">
                                <div class="img-caption d-flex flex-column justify-content-center text-start">
                                    <p class="mb-0 fs-6">Trader</p>
                                    <h6 class="mb-0">Wouter Benjins</h6>

                                </div>
                            </div>

                            <div class="swipe-text bg-new w-100 text-start p-2">
                                <p class="mb-0 fw-bold fs-6">Monthly Gain</p>
                                <h1 class="mt-0 fw-bold">25%</h1>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex flex-column">
                            <div class="img-container">
                                <img src="/images/testimonial/jca.webp" alt="" width="100%">
                                <div class="img-caption d-flex flex-column justify-content-center text-start">
                                    <p class="mb-0 fs-6">Trader</p>
                                    <h6 class="mb-0">Wouter Benjins</h6>

                                </div>
                            </div>
                            <div class="swipe-text bg-new w-100 text-start p-2">
                                <p class="mb-0 fw-bold fs-6">Monthly Gain</p>
                                <h1 class="mt-0 fw-bold">25%</h1>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex flex-column">
                            <div class="img-container">
                                <img src="/images/testimonial/lisa.webp" alt="" width="100%">
                                <div class="img-caption d-flex flex-column justify-content-center text-start">
                                    <p class="mb-0 fs-6">Trader</p>
                                    <h6 class="mb-0">Wouter Benjins</h6>

                                </div>
                            </div>
                            <div class="swipe-text bg-new w-100 text-start p-2">
                                <p class="mb-0 fw-bold fs-6">Monthly Gain</p>
                                <h1 class="mt-0 fw-bold">25%</h1>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex flex-column">
                            <div class="img-container">
                                <img src="/images/testimonial/petko.webp" alt="" width="100%">
                                <div class="img-caption d-flex flex-column justify-content-center text-start">
                                    <p class="mb-0 fs-6">Trader</p>
                                    <h6 class="mb-0">Wouter Benjins</h6>

                                </div>
                            </div>
                            <div class="swipe-text bg-new w-100 text-start p-2">
                                <p class="mb-0 fw-bold fs-6">Monthly Gain</p>
                                <h1 class="mt-0 fw-bold">25%</h1>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex flex-column">
                            <div class="img-container">
                                <img src="/images/testimonial/savell.webp" alt="" width="100%">
                                <div class="img-caption d-flex flex-column justify-content-center text-start">
                                    <p class="mb-0 fs-6">Trader</p>
                                    <h6 class="mb-0">Wouter Benjins</h6>

                                </div>
                            </div>
                            <div class="swipe-text bg-new w-100 text-start p-2">
                                <p class="mb-0 fw-bold fs-6">Monthly Gain</p>
                                <h1 class="mt-0 fw-bold">25%</h1>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex flex-column">
                            <div class="img-container">
                                <img src="/images/testimonial/siu.webp" alt="" width="100%">
                                <div class="img-caption d-flex flex-column justify-content-center text-start">
                                    <p class="mb-0 fs-6">Trader</p>
                                    <h6 class="mb-0">Wouter Benjins</h6>

                                </div>
                            </div>
                            <div class="swipe-text bg-new w-100 text-start p-2">
                                <p class="mb-0 fw-bold fs-6">Monthly Gain</p>
                                <h1 class="mt-0 fw-bold">25%</h1>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-lg-5 d-flex flex-column justify-content-center">
                <h1 class="text-black text-start fs-1">Proven By Real Success Stories, Backed By Experts</h1>
                <p>Elevate your trading with established Expert Advisors, renowned for their countless verified 5-star
                    reviews and authentic client testimonials. By placing your trust in an award-winning industry leader
                    endorsed by field experts, you’ll experience a world where excellence is not just promised but
                    consistently demonstrated.</p>
                <a href="/user/login" class="btn btn-primary btn-lg w-50 my-3 fw-bold" type="button"> Start
                    Trading</a>
            </div>
        </div>
    </div>
</section> --}}

    <section class="inovation py-5 bg-custom" id="about">
        <div class="container">
            <div class="row py-4">
                <div class="col-12">
                    <h1 class="text-white text-center fs-1" style="line-height: 32px;">Lead the way in trading innovation
                    </h1>
                </div>
            </div>
            <div class="row gy-3 justify-content-center">
                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/metatrader.svg" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/chatgpt.svg" alt="">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/forex.svg" alt="">
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <div class="inovation__wrap col-12">
                        <img src="/images/inovation/tradingview.svg" alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="what-about py-5" id="features">
        <div class="container">
            <div class="row py-4">
                <div class="col-12">
                    <h1 class="text-black text-center fs-1">What this means to you</h1>
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-lg-4 col-12">
                    <div class="what-about__wrap col-12">
                        <div class="d-flex flex-row justify-content-start gap-2">
                            <img src="/images/peace.svg" alt="">
                            <div class="d-flex flex-column">
                                <h5>Peace of Mind</h5>
                                <p class="text-white">
                                    At Nxcai, we prioritize your peace of mind above all. Our commitment to providing a secure, transparent, and reliable trading experience ensures that you maximize profits and funds secured.We employ cutting-edge security measures to protect your data, and our team is always available to provide clear communication and responsive support.</p>
                            </div>
                        </div>
                    </div>
    
                </div>
                <div class="col-lg-4 col-12">
                    <div class="what-about__wrap col-12">
                        <div class="d-flex flex-row justify-content-start gap-2">
                            <img src="/images/reliable.svg" alt="">
                            <div class="d-flex flex-column">
                                <h5>Guaranteed Reliability</h5>
                                <p class="text-white">
                                    You'll rely on our several years-long, proven track records on live accounts, validating
                                    your investment decisions with real performance data and not just claims. With a 100% guarantee and security on funds. Having acccess to withdraw our funds anytime without hassle.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="what-about__wrap col-12">
                        <div class="d-flex flex-row justify-content-start gap-2">
                            <img src="/images/proven.svg" alt="">
                            <div class="d-flex flex-column">
                                <h5>Proven Transparency</h5>
                                <p class="text-white">
                                    You'll experience reassurance through hundreds of verified 5-star reviews and video
                                    testimonials, demonstrating how you too can achieve your trading goals. With so many certications and affiliations with top trading bodies, be rest assured that our transperency is 100%.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="what-about__wrap col-12">
                        <div class="d-flex flex-row justify-content-start gap-2">
                            <img src="/images/longterm.svg" alt="">
                            <div class="d-flex flex-column">
                                <h5>Trading made Easy for you</h5>
                                <p class="text-white">
                                   Quick and easy setup for both new and experience traders, very easy to start the robot. $10,000 on Demo account to try out the robot and see how it works.Flexible use of robot, you can choose to stop the robot anytime, your capital is always returned after every trade. You don't need to be on the page for the robot to trade for you. It trades even when you're offline.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="what-about__wrap col-12">
                        <div class="d-flex flex-row justify-content-start gap-2">
                            <img src="/images/informed.svg" alt="">
                            <div class="d-flex flex-column">
                                <h5>Fully Powered by Ai</h5>
                                <p class="text-white">
                                    Nxcai robot uses Artificial Intelligence to trade the market with the best algorithm to minimize risk and maximize profits.No risk involved, why? This is because the robot closes and opens positions in Milliseconds, trades are not manually placed, the Ai handles all trades automatically.No skills required, you do not need any trading skill to use the Nxcai robot, it’s easy to use and it lets your money work for you.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="what-about__wrap col-12">
                        <div class="d-flex flex-row justify-content-start gap-2">
                            <img src="/images/market-cycle.svg" alt="">
                            <div class="d-flex flex-column">
                                <h5>Profitable Service</h5>
                                <p class="text-white">
                                    Our primary focus is ensuring that your trading experience is not only efficient but also highly profitable. Our AI-powered trading algorithms are built to maximize potential gains and help you achieve financial goals, and adapt to market changes in real time Your financial information and account details are securely stored and encrypted.The Nxcai robot is profitable for everyone whereby your money works for you on a daily basis with our fully automated trading robot..</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="Bottom-Hero bg-custom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto d-flex flex-column justify-content-center align-items-center">
                    <h1 class="text-white fw-bold">AI Powered Trading Robot For Everyone</h1>
                    <a href="/user/login" class="btn btn-primary btn-lg w-100 my-4 fw-bold text-uppercase py-3"
                        style="font-size: 13px;" type="button"> Start
                        Trading</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light border" id="tutorial">
        <div class="container">
            <div class="row justify-content-center text-center mb-4">
                <div class="col-lg-8 col-xxl-7">
                    <h1 class="display-5 fw-bold fs-1 text-black">How to get started</h1>
                    <p class="lead">Here's your easy to follow trading plan:</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center position-relative">
                        <div class="step-icon mx-auto border rounded-circle d-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;background-color:#40ffdd;">
                            <i class="bi bi-currency-dollar text-black" style="font-size: 32px;"></i>
                        </div>
                        <p class="lead text-uppercase text-black mt-4 px-lg-3 mb-1 fw-semibold" style="font-size: 14px;">
                            Step 1</p>
                        <h4 class="mt-3 fs-5 fw-semibold">Enter your desired trade amount</h4>
                        <p class="lead text-muted mt-4 px-lg-3 mb-5 mb-lg-0" style="font-size: 14px;">This will depend on
                            the minimum trading amount of your selected trading strategy</p>
                        <div class="arrow-icon position-absolute d-none d-lg-block" style="top:50px; right:-25px">
                            <svg class="bi bi-arrow-right" fill="currentColor" height="30" viewbox="0 0 16 16"
                                width="30" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                    fill-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center position-relative">
                        <div class="step-icon mx-auto border rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 70px;height: 70px;background-color:#40ffdd;">
                            <i class="bi bi-person-circle text-black" style="font-size: 32px;"></i>
                        </div>
                        <p class="lead text-uppercase text-black mt-4 px-lg-3 mb-1 fw-semibold" style="font-size: 14px;">
                            Step 2</p>
                        <h4 class="mt-3 fs-5 fw-semibold">Pick a trading account</h4>
                        <p class="lead text-muted mt-4 px-lg-3 mb-5 mb-lg-0" style="font-size: 14px;">You can either
                            practice using the Demo account and graduate to the Real account when ready</p>
                        <div class="arrow-icon position-absolute d-none d-lg-block" style="top:50px; right:-25px">
                            <svg class="bi bi-arrow-right" fill="currentColor" height="30" viewbox="0 0 16 16"
                                width="30" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                    fill-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center position-relative">
                        <div class="step-icon mx-auto border rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 70px;height: 70px;background-color:#40ffdd;">
                            <i class="bi bi-speedometer2 text-black" style="font-size: 32px;"></i>
                        </div>
                        <p class="lead text-uppercase text-black mt-4 px-lg-3 mb-1 fw-semibold" style="font-size: 14px;">
                            Step 3</p>
                        <h4 class="mt-3 fs-5 fw-semibold">Select a trading strategy</h4>
                        <p class="lead text-muted mt-4 px-lg-3 mb-5 mb-lg-0" style="font-size: 14px;">Select a list of
                            predefined strategies designed to maximize your trading capacity and profits</p>
                        <div class="arrow-icon position-absolute d-none d-lg-block" style="top:50px; right:-25px">
                            <svg class="bi bi-arrow-right" fill="currentColor" height="30" viewbox="0 0 16 16"
                                width="30" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                    fill-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center position-relative">
                        <div class="step-icon mx-auto border rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 70px;height: 70px;background-color:#40ffdd;">
                            <i class="bi bi-graph-up-arrow text-black" style="font-size: 32px;"></i>
                        </div>
                        <p class="lead text-uppercase text-black mt-4 px-lg-3 mb-1 fw-semibold" style="font-size: 14px;">
                            Step 4</p>
                        <h4 class="mt-3 fs-5 fw-semibold">Start trading</h4>
                        <p class="lead text-muted mt-4 px-lg-3 mb-5 mb-lg-0" style="font-size: 14px;">Click on the Start
                            Trade button and let the bot trade for you</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-5" id="faq">
        <div class="container">
            <div class="row justify-content-center text-center mb-3">
                <div class="col-lg-8 col-xl-7">
                    <h1 class="display-5 fw-bold fs-1">FAQs</h1>
                </div>
            </div>
            <div class="row justify-content-center py-lg-3">
                <div class="col-md-10">
                    <div class="row justify-content-center mb-4">
                        <div class="col-lg-8">
                            <div class="accordion" id="Tech-accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingOne"><button
                                            aria-controls="Tech-collapseOne" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseOne" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            How does Nxcai works?</button></h2>
                                    <div aria-labelledby="Tech-headingOne" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseOne">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            Nxcai is an automated Ai trading bot that helps you trade the forex and crypto
                                            market easily with a proven scalping strategy powered by a strong algorithm that
                                            trades the market, opens and closes trades within seconds targeting profits per
                                            trade which in end accumulates profits gradually. All you need to do is create
                                            an account, start a trade on demo to see how it works, then fund your account to
                                            make real profits.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingThree"><button
                                            aria-controls="Tech-collapseThree" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseThree" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            Do I need trading skills to earn?</button></h2>
                                    <div aria-labelledby="Tech-headingThree" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseThree">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            No, you don't need any trading skills to profit from this, you can earn from
                                            Nxcai with zero knowledge in trading. The Ai bot handles all the trades for you
                                            and make profits, all you need to do is start the robot.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingFour"><button
                                            aria-controls="Tech-collapseFour" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseFour" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            Are there any fees?</button></h2>
                                    <div aria-labelledby="Tech-headingFour" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseFour">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            Yes, there's a 1% fee charged from profits made by the bot. For example, when
                                            you trade and the AI makes $100 in profits, the company charges you 1% of the
                                            $100 profits made by the bot, not from your capital but only from the profits
                                            made.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingFive"><button
                                            aria-controls="Tech-collapseFive" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseFive" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            Is my funds safe?</button></h2>
                                    <div aria-labelledby="Tech-headingFive" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseFive">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            Yes! Your funds and capital is 100% safe and secured on the system, you don't
                                            have to be scared of loosing out, your capital is returned after every trade.
                                            You can choose to withdraw both your capital and profits anytime.100% guarantee
                                            on withdrawals.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingTen"><button
                                            aria-controls="Tech-collapseTen" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseTen" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            How fast is Deposit and withdrawal?</button></h2>
                                    <div aria-labelledby="Tech-headingTen" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseTen">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            Deposits and Withdrawals are instantly processed and should arrive within 30
                                            minutes maximum. There are no fees on deposits and withdrawals. Deposits and
                                            withdrawals are processed through crypto.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingSeven"><button
                                            aria-controls="Tech-collapseSeven" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseSeven" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            Does Nxcai Increase my returns daily?</button></h2>
                                    <div aria-labelledby="Tech-headingSeven" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseSeven">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            Yes, it does. Our AI Bot increases customer assets daily and tries to eliminate
                                            the potential for liquidation risk. By combining AI with a proven scalping
                                            trading strategy, we created an AI Bot that trades autonomously, buying low and
                                            selling high at the right time, while constantly modifying positions to
                                            potentially increase steady returns and cut down risk.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingSix"><button
                                            aria-controls="Tech-collapseSix" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseSix" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            What is the minimum deposit and withdrawal?</button></h2>
                                    <div aria-labelledby="Tech-headingSix" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseSix">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            The minimum deposit is $100, the minimum withdrawal is $10. There are no limits
                                            on deposits and withdrawals, you can choose to deposit and withdraw any amounts
                                            as the forex and crypto market is unlimited. Deposits and withdrawals are
                                            processed through cryptocurrency.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="Tech-headingNine"><button
                                            aria-controls="Tech-collapseNine" aria-expanded="false"
                                            class="fw-semibold accordion-button collapsed"
                                            data-bs-target="#Tech-collapseNine" style="font-size: 20px;"
                                            data-bs-toggle="collapse" type="button">
                                            What else do I need to know?</button></h2>
                                    <div aria-labelledby="Tech-headingNine" class="accordion-collapse collapse"
                                        data-bs-parent="#Tech-accordion" id="Tech-collapseNine">
                                        <div class="accordion-body" style="font-size: 14px;">
                                            Getting started with Nxcai is very easy, you don't need any technical knowledge
                                            to earn from this. there are 4 strategies you can choose from each of them has a
                                            certain minimum amount and a certain profit percentage, you will have to choose
                                            the strategy that matches your trade amount. This works for every country, the
                                            robot trades on both weekdays and weekends, trades forex and crypto during the
                                            week and trades only crypto during weekends. You can always contact our live
                                            support if you need further help.

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </section>
@endsection
