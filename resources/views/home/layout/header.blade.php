<header class="fixed-top">
    <nav class="navbar navbar-expand-lg bg-custom py-2">
        <div class="container">
            <a class="navbar-brand d-flex flex-row align-items-center gap-2 justify-content-center" href="/">
                <img src="{{ asset('homeassets/img/Ctxailogo.png') }}" alt="Logo" width="40"
                    class="d-inline-block align-text-top">
                <h3 class="text-white fs-5 pb-0 mb-0 px-1 d-none d-sm-none d-lg-block"
                    style="letter-spacing: 1px!important;"><b>Nxcai</b> <span class="text-success"
                        style="color:#40ffdd!important;"><b>BOT</b></span></h3>

            </a>

            {{-- mobile --}}
            <a href="/user/register/null"
                class="btn btn-primary btn-lg w-50 text-white d-flex align-items-center justify-content-center d-lg-none d-sm-block float-end fw-bold text-uppercase" style="font-size: 13px;"
                type="button">Start Trading
            </a>
            <div class="gtranslate_wrapper d-lg-none d-sm-block"></div>
            <div class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list text-white fs-1"></i>
            </div>
            <div class="collapse navbar-collapse justify-content-start justify-content-lg-center d-hidden d-lg-block" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item animated-border">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item  animated-border">
                        <a class="nav-link" href="/#features">Features</a>
                    </li>
                    <li class="nav-item  animated-border">
                        <a class="nav-link" href="/#faq">FAQ</a>
                    </li>
                    <li class="nav-item  animated-border">
                        <a class="nav-link" href="/user/login">Login</a>
                    </li>
                    <li class="nav-item  animated-border">
                        <a class="nav-link" href="/user/register/null">Sign up</a>
                    </li>
                </ul>
                <!-- <div class="header-buttons d-flex flex-row gap-3 d-lg-none d-sm-block justify-content-center">
                        <a class="btn btn-outline-success text-white"href="/signup">Login</a>
                        <a class="btn btn-success" href="/signup">Get started</a>
                    </div> -->
            </div>
            {{-- mobile --}}
            <!-- <div class="gtranslate_wrapper"></div> -->
            <div class="gtranslate_wrapper d-none d-sm-none d-lg-block pe-3"></div>
            <div class="header-buttons d-flex flex-row gap-3 d-none d-sm-none d-lg-block justify-content-center">

                <!-- <a class="btn btn-outline-success text-white"href="/signup">Login</a> -->
                <a class="btn btn-lg btn-primary fw-bold text-uppercase" href="/user/register/null" type="button" style="font-size: 13px;">Start trading</a>
            </div>



        </div>
    </nav>
</header>
