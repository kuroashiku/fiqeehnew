if ($("#player").length) {
  const player = new Plyr("#player", {
    autoplay: true
  });
  // Code seek time
    player.on("ready", function() {
        // player.embed.seekTo(20);
    });

  $("#player").click(function (e) {
    $(".plyr__poster").show();
    $(".plyr__poster").css("display", "block");
  });
}
if ($("#player2").length) {
  const player = new Plyr("#player2", {
    autoplay: true
  });

  $("#player2").click(function (e) {
    $(".plyr__poster").show();
    $(".plyr__poster").css("display", "block");
  });
}

if ($(".slider-program-bisnis").length) {
  $(".slider-program-bisnis").slick({
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 3,
    arrows: true,
    autoplay: true,
    dots: true,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
}

if ($(".slider-program-bisnis2").length) {
  $(".slider-program-bisnis2").slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    arrows: false,
    autoplay: true,
    dots: true,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
}

if ($(".slider-testimoni").length) {
  $(".slider-testimoni").slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    dots: true,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
}

if ($(".slider-rencana-kelas").length) {
  $(".slider-rencana-kelas").slick({
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 5,
    arrows: false,
    autoplay: true,
    dots: false,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          arrows: false,
          dots: false,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          arrows: false,
          dots: false,
        },
      },
    ],
  });
}

if ($(".slider-tag").length) {
  if (window.matchMedia("(max-width: 480px)").matches) {
    $(".slider-tag").slick({
      infinite: false,
      slidesToShow: 3,
      slidesToScroll: 3,
      arrows: false,
      autoplay: false,
      dots: false,
      variableWidth: true,
    });
  }
}

if ($(".prev-program-bisnis").length) {
  $(".prev-program-bisnis").click(function (e) {
    $(".slider-program-bisnis").slick("slickPrev");
  });
}

if ($(".next-program-bisnis").length) {
  $(".next-program-bisnis").click(function (e) {
    $(".slider-program-bisnis").slick("slickNext");
  });
}

if ($(".slider-mitra").length) {
  $(".slider-mitra").slick({
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 5,
    arrows: false,
    autoplay: true,
    dots: false,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
}

if ($(".slider-kelas-terkait").length) {
  $(".slider-kelas-terkait").slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    arrows: false,
    autoplay: true,
    dots: false,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
}

function onlyNumberKey(evt) {
  var ASCIICode = evt.which ? evt.which : evt.keyCode;
  if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
  return true;
}

if ($('.form-input').length) {
    $(document).ready(function () {
        $('.form-input').blur(function () {
            // REQUIRED
            if (this.required && this.value === '') {
                $(this).next().text(`${this.placeholder} wajib diisi.`)
                $(this).next().removeClass('text-neutral-400 normal-case')
                $(this).next().addClass('text-danger-500 normal-case')
            }

            // MIN CHARACTER 
            if (this.minLength > 0 && this.value !== '' && this.minLength > this.value.length) {
                $(this).next().text(`Minimal ${this.minLength} karakter.`)
                $(this).next().removeClass('text-neutral-400 normal-case')
                $(this).next().addClass('text-danger-500 normal-case')
            }

            // EMAIL
            let validEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (this.type === 'email' && this.value !== '' && !validEmail.test(this.value)) {
                $(this).next().text('Email tidak valid!')
                $(this).next().removeClass('text-neutral-400 normal-case')
                $(this).next().addClass('text-danger-500 normal-case')
            }

            let arrInput = []
            let arrError = []
            $('.form-input').each(function (index, item) {
                item.required ? arrInput.push(item.value) : arrInput.push('-')
            })
            $('.error.text-danger-500').each(function (index, item) {
                arrError.push(item.innerHTML)
            })

            function checkInput(input) {
                return input === '';
            }

            function checkError(error) {
                return error !== '';
            }
        })

        $('.form-input').keydown(function () {
            if (this.value !== '') {
                if (!$(this).next().data('value')) {
                    $(this).next().text('')
                    $(this).next().removeClass('text-danger-500')
                    $(this).next().addClass('text-neutral-400')
                } else {
                    $(this).next().text(`Minimal ${this.minLength} karakter.`)
                    $(this).next().removeClass('text-danger-500')
                    $(this).next().addClass('text-neutral-400')
                }
            }
        })

        $(".show-pass").on('click', function (event) {
            if ($('#sandi').attr("type") == "text") {
                $('#sandi').attr('type', 'password');
            } else if ($('#sandi').attr("type") == "password") {
                $('#sandi').attr('type', 'text');
            }
        });
    });
}

function uploadFile() {
  $("input[type=file]").trigger("click");
}

function loadFile(event) {
  var output = document.getElementById("preview-image");

  if (event.target.files[0] === undefined) {
    output.classList.add("hidden");
    $("#submit").removeClass("text-brand-50 bg-brand-500 border-brand-50");
    $("#submit").addClass("text-neutral-300 bg-neutral-100 border-neutral-200");
    $("#submit").attr("disabled", true);
  } else {
    output.classList.remove("hidden");
    $("#submit").removeClass(
      "text-neutral-300 bg-neutral-100 border-neutral-200"
    );
    $("#submit").addClass("text-brand-50 bg-brand-500 border-brand-50");
    $("#submit").removeAttr("disabled");
  }
  output.src = URL.createObjectURL(event.target.files[0]);
  output.onload = function () {
    URL.revokeObjectURL(output.src);
  };
}

if ($(".click-rating").length) {
  $(".click-rating").on("click", function (event) {
    const indexClick = $(this).index();
    $(".click-rating").each(function (index, item) {
      $(this).removeClass("text-warning-500");
      $(this).addClass("text-neutral-200");

      if (index <= indexClick) {
        $(this).removeClass("text-neutral-200");
        $(this).addClass("text-warning-500");
      }
      $("#jumlahRating").val(indexClick + 1);
    });
  });
}

if ($("#deskripsi-tab-header-marketplace").length) {
  const tabElements = [
    {
      id: "deskripsi",
      triggerEl: document.querySelector("#deskripsi-tab-header-marketplace"),
      targetEl: document.querySelector("#deskripsi-tab-content"),
    },
    {
      id: "konten",
      triggerEl: document.querySelector("#konten-tab-header"),
      targetEl: document.querySelector("#konten-tab-content"),
    },
    {
      id: "ulasan",
      triggerEl: document.querySelector("#ulasan-tab-header"),
      targetEl: document.querySelector("#ulasan-tab-content"),
    },
    {
      id: "terkait",
      triggerEl: document.querySelector("#terkait-tab-header"),
      targetEl: document.querySelector("#terkait-tab-content"),
    },
  ];

  const options = {
    defaultTabId: window.matchMedia("(max-width: 480px)").matches
      ? "deskripsi"
      : "deskripsi",
    activeClasses: "text-brand-600 hover:text-brand-600 border-brand-600",
    inactiveClasses:
      "text-neutral-300 hover:text-neutral-400 border-neutral-50",
    onShow: () => {
      console.log("tab is shown");
    },
  };

  const tabs = new Tabs(tabElements, options);
}

if ($("#deskripsi-tab-header").length) {
  const tabElements = [
    {
      id: "konten",
      triggerEl: document.querySelector("#konten-tab-header"),
      targetEl: document.querySelector("#konten-tab-content"),
    },
    {
      id: "deskripsi",
      triggerEl: document.querySelector("#deskripsi-tab-header"),
      targetEl: document.querySelector("#deskripsi-tab-content"),
    },
    {
      id: "ulasan",
      triggerEl: document.querySelector("#ulasan-tab-header"),
      targetEl: document.querySelector("#ulasan-tab-content"),
    },
    {
      id: "terkait",
      triggerEl: document.querySelector("#terkait-tab-header"),
      targetEl: document.querySelector("#terkait-tab-content"),
    },
  ];

  const options = {
    defaultTabId: window.matchMedia("(max-width: 480px)").matches
      ? "konten"
      : "deskripsi",
    activeClasses: "text-brand-600 hover:text-brand-600 border-brand-600",
    inactiveClasses:
      "text-neutral-300 hover:text-neutral-400 border-neutral-50",
    onShow: () => {
      console.log("tab is shown");
    },
  };

  const tabs = new Tabs(tabElements, options);
} 

if ($("#overview").length) {
  const tabElements = [
    {
      id: "detail",
      triggerEl: document.querySelector("#detail-tab-header"),
      targetEl: document.querySelector("#detail-tab-content"),
    },
    {
      id: "konten",
      triggerEl: document.querySelector("#konten-tab-header"),
      targetEl: document.querySelector("#konten-tab-content"),
    },
    {
      id: "ulasan",
      triggerEl: document.querySelector("#ulasan-tab-header"),
      targetEl: document.querySelector("#ulasan-tab-content"),
    },
  ];

  const options = {
    defaultTabId: window.matchMedia("(max-width: 768px)").matches
      ? "detail"
      : "konten",
    activeClasses: "text-brand-600 hover:text-brand-600 border-brand-600",
    inactiveClasses:
      "text-neutral-300 hover:text-neutral-400 border-neutral-50",
    onShow: () => {
      console.log("tab is shown");
    },
  };

  const tabs = new Tabs(tabElements, options);
}

const pilihanJawaban = document.querySelectorAll(".pilihan-jawaban");
const inputJawaban = document.querySelectorAll(".jawaban");

pilihanJawaban.forEach((item, key) => {
  const allItem = item.querySelectorAll(".item-jawaban");
  allItem.forEach((i) => {
    i.addEventListener("click", function () {
      i.parentElement.querySelectorAll(".item-jawaban").forEach((el) => {
        el.classList.remove("bg-brand-50");
        el.classList.add("bg-white");
      });
      i.classList.remove("bg-white");
      i.classList.add("bg-brand-50");
      i.parentElement.previousElementSibling.value = i.children[0].innerText;
    });
  });
});

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function packageForm(harga, coret, code, total, bulan) {
  if (harga == coret) {
    $('#nominalPembayaran').replaceWith(`
    <div id="nominalPembayaran">
      <input type="hidden" name="amount" value="${harga}">
      <input type="hidden" name="unique_amount" value="${code}">
      <input type="hidden" name="bulan" value="${bulan}">
      <div class="flex justify-between text-sm font-normal text-neutral-500 mb-2 lg:mb-4">
          <p>
              Durasi Bulan
          </p>
          <p class="text-neutral-500" id="durasiBulan">
             ${bulan}
          </p>
      </div>
      <div class="flex justify-between text-sm font-normal text-neutral-500 mb-2 lg:mb-4">
          <p>
              Harga Normal
          </p>
          <p class="text-neutral-500" id="finalHargaNormal">
              Rp ${numberWithCommas(harga)}
          </p>
      </div>
      <div class="flex justify-between text-sm font-normal text-neutral-500 mb-2 lg:mb-4">
          <p>
              Kode unik
          </p>
          <p id="finalKodeUnik">
              Rp ${code}
          </p>
      </div>
      <div class="flex justify-between text-sm font-semibold text-neutral-500">
          <p>
              Total
          </p>
          <p id="finalHargaTotal">
              Rp ${numberWithCommas(total)}
          </p>
      </div>
    </div>`);
  } else {
    $('#nominalPembayaran').replaceWith(`
    <div id="nominalPembayaran">
      <input type="hidden" name="amount" value="${coret}">
      <input type="hidden" name="unique_amount" value="${code}">
      <input type="hidden" name="bulan" value="${bulan}">
      <div class="flex justify-between text-sm font-normal text-neutral-500 mb-2 lg:mb-4">
          <p>
              Durasi Bulan
          </p>
          <p class="text-neutral-500" id="durasiBulan">
             ${bulan}
          </p>
      </div>
      <div class="flex justify-between text-sm font-normal text-neutral-500 mb-2 lg:mb-4">
          <p>
              Harga Normal
          </p>
          <p class="text-danger-500 line-through" id="finalHargaNormal">
              Rp ${numberWithCommas(harga)}
          </p>
      </div>
      <div class="flex justify-between text-sm font-normal text-neutral-500 mb-2 lg:mb-4">
          <p>
              Harga Promo
          </p>
          <p id="finalHargaPromo">
              Rp ${numberWithCommas(coret)}
          </p>
      </div>
      <div class="flex justify-between text-sm font-normal text-neutral-500 mb-2 lg:mb-4">
          <p>
              Kode unik
          </p>
          <p id="finalKodeUnik">
              Rp ${code}
          </p>
      </div>
      <div class="flex justify-between text-sm font-semibold text-neutral-500">
          <p>
              Total
          </p>
          <p id="finalHargaTotal">
              Rp ${numberWithCommas(total)}
          </p>
      </div>
    </div>`);
  }
}
if($('.pilih-paket').length) {
    let getCoret0 =  $('.harga-paket').data('coret')
    let getHarga0 = $('.harga-paket').data('harga')
    let getBulan0 = $('.harga-paket').data('bulan')
    let code0 = Math.floor(Math.random() * 90 + 10)
    let total0 = parseInt(getHarga0) + parseInt(code0)

    packageForm(getCoret0, getHarga0, code0, total0, getBulan0)
    $('.pilih-paket').on('click', function (event) {
        const indexClick = $(this).index()
        let getData = $(this).data('value')
        let getType = $(this).data('type')
        $('#jenisPaket').val(getData)
        $('#titlePilihan').text('Akun '+getType+ ' ' +getData+ ' Bulan')

        $('.img-paket').each(function (index, item) {
            $(this).removeClass('flex') 
            $(this).addClass('hidden')

            if(index == indexClick-1) {
                $(this).removeClass('hidden')
                $(this).addClass('flex')
            }
        })

        $('.harga-paket').each(function (index, item) {
            if(index == indexClick-1) {
                let getCoret =  $(this).data('coret')
                let getHarga = $(this).data('harga')
                let getBulan = $(this).data('bulan')
                let code = Math.floor(Math.random() * 90 + 10)
                let total = parseInt(getHarga) + parseInt(code)

                packageForm(getCoret, getHarga, code, total, getBulan)
            }
        })

        $('.pilih-paket').each(function (index, item) {
            $(this).removeClass('border-brand-500 drop-shadow')
            $(this).addClass('border-neutral-100')

            $(this).find('.checked-circle').removeClass('border-brand-500 bg-brand-500')
            $(this).find('.checked-circle').addClass('border-neutral-500 bg-white')

            $(this).find('.checked-circle .child').addClass('hidden')
        })
        $(this).removeClass('border-neutral-100')
        $(this).addClass('border-brand-500 drop-shadow')

        $(this).find('.checked-circle').removeClass('border-neutral-500 bg-white')
        $(this).find('.checked-circle').addClass('border-brand-500 bg-brand-500')

        $(this).find('.checked-circle .child').removeClass('hidden')
    });
}

function copyClipboard(Text) {
  navigator.clipboard.writeText(Text);
}

// COUNTDOWN
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

if ($(".form-user").length) {
  $(document).ready(function () {
    $(".form-user").blur(function () {
      // REQUIRED
      if (this.required && this.value === "") {
        $(this).removeClass("border-neutral-100");
        $(this).addClass("border-danger-400 border-opacity-50");
        $(this).next().text(`error_outline`);
        $(this).parent().next().text(`Kolom wajib diisi.`);
        $(this).parent().next().removeClass("text-neutral-400 normal-case");
        $(this).parent().next().addClass("text-danger-500 normal-case");
      }

      // MIN CHARACTER
      if (
        this.minLength > 0 &&
        this.value !== "" &&
        this.minLength > this.value.length
      ) {
        $(this).removeClass("border-neutral-100");
        $(this).addClass("border-danger-400 border-opacity-50");
        $(this).next().text("error_outline");
        $(this).parent().next().text(`Minimal ${this.minLength} karakter.`);
        $(this).parent().next().removeClass("text-neutral-400 normal-case");
        $(this).parent().next().addClass("text-danger-500 normal-case");
      }

      let arrInput = [];
      let arrError = [];
      $(".form-user").each(function (index, item) {
        item.required ? arrInput.push(item.value) : arrInput.push("-");
      });
      $(".error.text-danger-500").each(function (index, item) {
        arrError.push(item.innerHTML);
      });

      function checkInput(input) {
        return input === "";
      }

      function checkError(error) {
        return error !== "";
      }

      const res1 = arrInput.find(checkInput);
      const res2 = arrError.find(checkError);

      if (res1 === undefined && res2 === undefined) {
        $("#submit").removeClass(
          "text-neutral-300 bg-neutral-100 border-neutral-200"
        );
        $("#submit").addClass("text-brand-50 bg-brand-500 border-brand-50");
        $("#submit").removeAttr("disabled");
      } else {
        $("#submit").removeClass("text-brand-50 bg-brand-500 border-brand-50");
        $("#submit").addClass(
          "text-neutral-300 bg-neutral-100 border-neutral-200"
        );
        $("#submit").attr("disabled", true);
      }
    });

    $(".form-user").change(function () {
      if (this.value !== "") {
        if (!$(this).parent().next().data("value")) {
          $(this).addClass("border-neutral-100");
          $(this).removeClass("border-danger-400 border-opacity-50");
          $(this).next().text("");
          $(this).parent().next().text("");
          $(this).parent().next().removeClass("text-danger-500");
          $(this).parent().next().addClass("text-neutral-400");
        } else {
          $(this).removeClass("border-neutral-100");
          $(this).addClass("border-danger-400 border-opacity-50");
          $(this).next().text("error_outline");
          $(this).parent().next().text(`Minimal ${this.minLength} karakter.`);
          $(this).parent().next().removeClass("text-danger-500");
          $(this).parent().next().addClass("text-neutral-400");
        }
      }
    });

    $(".show-pass").on("click", function (event) {
      if ($("#sandi").attr("type") == "text") {
        $("#sandi").attr("type", "password");
      } else if ($("#sandi").attr("type") == "password") {
        $("#sandi").attr("type", "text");
      }
    });
  });
}

if ($(".programs13list").length) {
  $(".programs13list").slick({
    infinite: false,
    slidesPerRow: 5,
    rows: 2,
    arrows: true,
    autoplay: false,
    dots: true,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesPerRow: 1,
          rows: 3,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
  $(".prev-program-bisnis").click(function (e) {
    $(".programs13list").slick("slickPrev");
  });
  $(".next-program-bisnis").click(function (e) {
    $(".programs13list").slick("slickNext");
  });
 
  let currentSlide =  $(".programs13list").slick('slickCurrentSlide') + 1
  let totalSlide = $(".programs13list").slick('getSlick').slideCount  
  $(".prev-program-bisnis").addClass("slick-disabled");
  if(currentSlide == totalSlide) {
    $(".next-program-bisnis").addClass("slick-disabled");
  }

	$(".programs13list").on("afterChange", function () {
		if ($(".slick-prev").hasClass("slick-disabled")) {
			$(".prev-program-bisnis").addClass("slick-disabled");
		} else {
			$(".prev-program-bisnis").removeClass("slick-disabled");
		}
		if ($(".slick-next").hasClass("slick-disabled")) {
			$(".next-program-bisnis").addClass("slick-disabled");
		} else {
			$(".next-program-bisnis").removeClass("slick-disabled");
		}
	});
}

if ($(".slider-banner").length) {
  $(".slider-banner").slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    dots: true,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
}

if ($("#searchList").length) {
  $("#searchList").slick({
    infinite: false,
    slidesPerRow: 5,
    rows: 2,
    arrows: true,
    autoplay: true,
    dots: true,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesPerRow: 1,
          rows: 3,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
  $(".prev-searchlist").click(function (e) {
    $("#searchList").slick("slickPrev");
  });
  $(".next-searchlist").click(function (e) {
    $("#searchList").slick("slickNext");
  });

  let currentSlide =  $("#searchList").slick('slickCurrentSlide') + 1
  let totalSlide = $("#searchList").slick('getSlick').slideCount  
  $(".prev-searchlist").addClass("slick-disabled");
  if(currentSlide == totalSlide) {
      $(".next-searchlist").addClass("slick-disabled");
  }

	$("#searchList").on("afterChange", function () {
		if ($(".slick-prev").hasClass("slick-disabled")) {
			$(".prev-searchlist").addClass("slick-disabled");
		} else {
			$(".prev-searchlist").removeClass("slick-disabled");
		}
		if ($(".slick-next").hasClass("slick-disabled")) {
			$(".next-searchlist").addClass("slick-disabled");
		} else {
			$(".next-searchlist").removeClass("slick-disabled");
		}
	});
}

if ($(".listcontents").length) {
  $(".listcontents").slick({
    infinite: false,
    slidesPerRow: 5,
    rows: 2,
    arrows: true,
    autoplay: false,
    dots: true,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 480,
        settings: {
          slidesPerRow: 1,
          rows: 3,
          arrows: false,
          dots: false,
          adaptiveHeight: true,
        },
      },
    ],
  });
  $(".prev-listcontents").click(function (e) {
    $(".listcontents").slick("slickPrev");
  });
  $(".next-listcontents").click(function (e) {
    $(".listcontents").slick("slickNext"); 
  });

  let currentSlide =  $("#searchList").slick('slickCurrentSlide') + 1
  let totalSlide = $("#searchList").slick('getSlick').slideCount  
  $(".prev-searchlist").addClass("slick-disabled");
  if(currentSlide == totalSlide) {
      $(".next-searchlist").addClass("slick-disabled");
  }

	$("#searchList").on("afterChange", function () {
		if ($(".slick-prev").hasClass("slick-disabled")) {
			$(".prev-searchlist").addClass("slick-disabled");
		} else {
			$(".prev-searchlist").removeClass("slick-disabled");
		}
		if ($(".slick-next").hasClass("slick-disabled")) {
			$(".next-searchlist").addClass("slick-disabled");
		} else {
			$(".next-searchlist").removeClass("slick-disabled");
		}
	});
}

