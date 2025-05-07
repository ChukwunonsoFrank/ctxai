<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exvb - AI Trading bot</title>
    
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

<style>
  * {
  font-family: "Inter", serif;
}

.btn-disabled {
  background: #2c917e;
  border-radius: 0.375rem;
  border: none;
  cursor: not-allowed;
}
</style>

    <link rel="stylesheet" href="/homeassets/css/main.css">

    <!--Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <script async src="https://www.google.com/recaptcha/api.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
    @vite('resources/js/app.js')

</head>
<body>
    <!-- partial:partials/_navbar.html -->
    @include('home.layout.header')
      <!-- partial -->

      <!-- 
        =============================================
            Theme Main Banner
        ============================================== 
        -->
        @yield('content')
        <!--
        =====================================================
            Footer
        =====================================================
        -->
        <!-- partial:partials/_footer.html -->
    @include('home.layout.footer')
    <!-- partial -->
    <script>
        const togglePassword1 = document.querySelector('#togglePassword1');
        const password1 = document.querySelector('#password1');
        togglePassword1.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password1
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password1.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye-fill');
        });

        const togglePassword2 = document.querySelector('#togglePassword2');
        const password2 = document.querySelector('#password2');
        togglePassword2.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password2
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password2.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye-fill');
        });
    </script>

    <!-- <div class="gtranslate_wrapper"></div>
    <script>window.gtranslateSettings = {"default_language":"en","wrapper_selector":".gtranslate_wrapper"}</script>
    <script src="https://cdn.gtranslate.net/widgets/latest/dwf.js" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $("[id^=login-btn]").each(function () {
            $(this).click(function () {
                let stateObj = { id: "100" };
                
                window.history.replaceState(stateObj,"Page", "/user/login");
            });
        });

        $("[id^=register-btn]").each(function () {
            $(this).click(function () {
                let stateObj = { id: "100" };
			
			    window.history.replaceState(stateObj,"Page", "/user/register/null");
            });
        });

        $(document).ready(function(){
            $('.gt_switcher-popup').find('span').hide();
        })
    </script>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        "@0.00": {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        "@0.75": {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        "@1.00": {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        "@1.50": {
          slidesPerView: 3,
          spaceBetween: 20,
        },
      },
    });
  </script>

<script>window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","flag_size":24,"flag_style":"3d"}</script>
<script src="https://cdn.gtranslate.net/widgets/latest/popup.js" defer></script>
    @yield('footer')

  <script src="//code.jivosite.com/widget/16gjtRWVEp" async></script>
  
  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const loginButton = document.getElementById('loginBtn');
        
        // Disable button immediately on submit
        loginButton.disabled = true;
        loginButton.classList.remove('btn-primary', 'btn', 'text-white');
        loginButton.classList.add('btn-disabled', 'text-black');
    });
    
    // Check for errors after page load
    document.addEventListener('DOMContentLoaded', function() {
        const loginButton = document.getElementById('loginBtn');
        
        // Check if there are any errors (Laravel adds .errors to the session)
        @if ($errors->any())
            loginButton.disabled = false;
            loginButton.classList.remove('btn-disabled', 'text-black');
            loginButton.classList.add('btn-primary', 'btn', 'text-white');
        @endif
    });
    </script>

<script>
  document.getElementById('registerForm').addEventListener('submit', function(e) {
      const registerButton = document.getElementById('registerBtn');
      
      // Disable button immediately on submit
      registerButton.disabled = true;
      registerButton.classList.remove('btn-primary', 'btn', 'text-white');
      registerButton.classList.add('btn-disabled', 'text-black');
  });
  
  // Check for errors after page load
  document.addEventListener('DOMContentLoaded', function() {
      const registerButton = document.getElementById('registerBtn');
      
      // Check if there are any errors (Laravel adds .errors to the session)
      @if ($errors->any())
          registerButton.disabled = false;
          registerButton.classList.remove('btn-disabled', 'text-black');
          registerButton.classList.add('btn-primary', 'btn', 'text-white');
      @endif
  });
  </script>
</body>
</html>