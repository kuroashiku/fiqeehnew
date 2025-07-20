
<footer class="px-6 lg:px-36 bg-neutral-600">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 border-b border-neutral-400 pt-12 lg:py-20">
            <div class="brand mb-8 lg:mb-0">
                @php
                    $logoUrl = asset('assets/images/logo-white.png');
                @endphp

                @if($logoUrl)
                    <img src="{{asset('assets/images/logo-white.png')}}" class="h-8 mb-4" alt="{{get_option('site_title')}}" />
                @else
                    <img src="{{asset('assets/images/logo-white.png')}}" class="h-8 mb-4" alt="{{get_option('site_title')}}" />
                @endif
                <p class="text-xs lg:text-sm font-normal text-neutral-100">
                    {{ \App\Option::where('option_key', 'site_address')->first()->option_value }}
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="mb-10 lg:mb-0">
                    <p class="text-xs lg:text-sm font-semibold text-brand-500 mb-4 uppercase">
                        Produk
                    </p>
                    <a href="{{route('blog')}}" class="block text-xs lg:text-sm font-normal text-white mb-4">
                        Artikel
                    </a>
                    <a href="{{route('kbp')}}" class="block text-xs lg:text-sm font-normal text-white mb-4">
                        Kebijakan Privasi
                    </a>
                    <a href="{{route('snk')}}" class="block text-xs lg:text-sm font-normal text-white mb-4">
                        Syarat & Ketentuan
                    </a>
                    {{-- <a href="{{route('free_ebook')}}" class="block text-xs lg:text-sm font-normal text-white">
                        E-Book Gratis
                    </a> --}}
                </div>
                <div class="mb-10 lg:mb-0">
                    <p class="text-xs lg:text-sm font-semibold text-brand-500 mb-4 uppercase">
                        Perusahaan
                    </p>
                    <a href="{{route('about_us')}}" class="block text-xs lg:text-sm font-normal text-white mb-4">
                        Tentang Kami
                    </a>
                    <a href="{{route('faq')}}" class="block text-xs lg:text-sm font-normal text-white">
                        Tanya Jawab
                    </a>
                </div>
                <div class="mb-10 lg:mb-0">
                    <p class="text-xs lg:text-sm font-semibold text-brand-500 mb-4 uppercase">
                        Hubungi Kami
                    </p>
                    <a href="https://wa.me/{{ old('site_phone')? old('site_phone') : get_option('site_phone') }}" target="_blank" class="block text-xs lg:text-sm font-normal text-white">
                        Whatsapp
                    </a>
                </div>
            </div>
        </div>
        <div class="block md:flex justify-between items-center py-6 lg:py-8">
            <div class="text-xs lg:text-base font-normal text-neutral-100 mb-8 md:mb-0">
                Copyright © 2020 PT. Kampusnya Pengusaha Hijrah
            </div>
            <div>
                <a href="https://facebook.com/hijrahacademy-103906547711979" class="text-2xl font-normal inline-block text-neutral-300" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/fiqeehcom?igsh=ejBybzAzcnd0cWF3" class="ml-8 lg:ml-10 text-2xl font-normal inline-block text-neutral-300" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="ml-8 lg:ml-10 text-2xl font-normal inline-block text-neutral-300" target="_blank">
                    <i class="fa-brands fa-telegram"></i>
                </a>
                <a href="#" class="ml-8 lg:ml-10 text-2xl font-normal inline-block text-neutral-300" target="_blank">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="https://www.youtube.com/channel/UC3otfnjgbju4saf3lNppTJg" class="ml-8 lg:ml-10 text-2xl font-normal inline-block text-neutral-300" target="_blank">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/vendor/slick/slick.js')}}"></script>

@if (isset($user))
    <script>
        $(document).ready(function() {
            if ($("#countdown").length) {
                const getDate = $("#countdown").val();
                var countDownDate = new Date(getDate).getTime();

                var x = setInterval(function () {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;

                    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                    );
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // if (days < 10) {
                    //     days = '0' + days;
                    // }
                    if (hours < 10) {
                    hours = "0" + hours;
                    }
                    if (minutes < 10) {
                    minutes = "0" + minutes;
                    }
                    if (seconds < 10) {
                    seconds = "0" + seconds;
                    }

                    document.getElementById("hours").innerText = hours;
                    document.getElementById("minutes").innerText = minutes;
                    document.getElementById("seconds").innerText = seconds;

                    if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("hours").innerText = "00";
                    document.getElementById("minutes").innerText = "00";
                    document.getElementById("seconds").innerText = "00";
                    }
                }, 1000);
            }
            
            Date.prototype.addHours = function(h) {
                this.setTime(this.getTime() + (h*60*60*1000));
                return this;
            }
            // Set the date we're counting down to
            var countDownDate = new Date('{!! $user->created_at !!}').addHours(6);

            // Update the count down every 1 second
            var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            }, 1000);
        });
        
    </script>
@else
    <script>
        $(document).ready(function() {
            if ($("#countdown").length) {
                const getDate = $("#countdown").val();
                var countDownDate = new Date(getDate).getTime();

                var x = setInterval(function () {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;

                    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                    );
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // if (days < 10) {
                    //     days = '0' + days;
                    // }
                    if (hours < 10) {
                    hours = "0" + hours;
                    }
                    if (minutes < 10) {
                    minutes = "0" + minutes;
                    }
                    if (seconds < 10) {
                    seconds = "0" + seconds;
                    }

                    document.getElementById("hours").innerText = hours;
                    document.getElementById("minutes").innerText = minutes;
                    document.getElementById("seconds").innerText = seconds;

                    if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("hours").innerText = "00";
                    document.getElementById("minutes").innerText = "00";
                    document.getElementById("seconds").innerText = "00";
                    }
                }, 1000);
            }
            
            Date.prototype.addHours = function(h) {
                this.setTime(this.getTime() + (h*60*60*1000));
                return this;
            }
            // Set the date we're counting down to
            var countDownDate = new Date('{!! date("Y-m-d H:i:s") !!}').addHours(6);

            // Update the count down every 1 second
            var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            }, 1000);
        });
        
    </script>
@endif

<script src="{{asset('assets/vendor/flowbite/flowbite.js')}}"></script>
<script src="{{asset('assets/vendor/plyr/plyr.polyfilled.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>

<script src="{{asset('assets/vendor/loadmore/btnloadmore.js')}}"></script>

<script>
    showDrawer = () => {
        $( "#drawer-top-example" ).toggleClass('hidden');
    }
</script>



<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    {{ csrf_field() }}
</form>

@yield('page-js')
<script>
    
const player = new Plyr('#player', {});


window.player = player;

</script>
<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "la-eye-slash" );
                $('#show_hide_password i').removeClass( "la-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "la-eye-slash" );
                $('#show_hide_password i').addClass( "la-eye" );
            }
        });
        $("#form-search").trigger('submit');
    });
</script>
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        alert('text copied');
    }
    function copyToClip(text) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
        alert('text copied');
    }
</script>

</body>
</html>
