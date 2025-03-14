
        <footer class="footer-section">
            <div class="footer-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="footer-wrapper">
                                <h3>About</h3>

                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi</p>

                                <ul class="social-icon">
                                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                </ul>
                            </div> <!-- footer-wrapper -->
                        </div>


                        <div class="col-sm-6">
                            <div class="footer-wrapper">
                                <h3>Navigation</h3>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="wrapper-option">
                                        <li><a href="{{ url('home') }}">Home</a></li>
                                        <li><a href="{{ url('home/about') }}">About</a></li>
                                        <li><a href="{{ url('home/contact') }}">Contact</a></li>
                                        <li><a href="{{ url('user/login') }}">Login</a></li>
                                        <li><a href="{{ url('user/signup') }}">Signup</a></li>
                                        </ul> <!-- wrapper-option -->
                                    </div>

                                    <!-- <div class="col-sm-6">
                                        <ul class="wrapper-option">
                                            <li><a href="#">Testimonials</a></li>
                                            <li><a href="#">Gallery</a></li>
                                            <li><a href="#">Contact Us</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                        </ul> 
                                    </div> -->
                                </div>
                            </div> <!-- footer-wrapper -->
                        </div>
                    </div>
                </div>
            </div> <!-- footer-container -->

            <div class="copy-right text-center">
                <p>2023 &copy; All Rights Reserved by <a href="#">{{ env[APP_NAME] }}</a></p>
            </div> <!-- copy-right -->
        </footer> <!-- footer-section -->

        <!-- Off-Canvas View Only -->
        <div id="offcanvas-menu" class="visible-xs visible-sm">
            
            <span class="close-menu"><i class="fa fa-times" aria-hidden="true"></i></span>

            <ul class="menu-wrapper">
                
                <li><a href="{{ url('home') }}">Home</a></li>
                <li><a href="{{ url('home/about') }}">About</a></li>
                <li><a href="{{ url('home/contact') }}">Contact</a></li>
                <li><a href="{{ url('user/login') }}">Login</a></li>
                <li><a href="{{ url('user/signup') }}">Signup</a></li>

                
            </ul> <!-- menu-wrapper -->      
        </div>
        <!-- Off-Canvas View Only -->