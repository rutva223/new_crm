<!-- Required vendors -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>

<script src="{{ asset('assets/vendor/draggable/draggable.js') }}"></script>
<script src="{{ asset('assets/vendor/chart-js/chart.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/wow-master/dist/wow.min.js') }}"></script>
<script src="{{ asset('assets/vendor/peity/jquery.peity.min.js') }}"></script>

<script src="{{ asset('assets/js/letter.avatar.js') }}"></script>
<script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>

<!--swiper-slider-->
<script src="{{ asset('assets/vendor/swiper/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/wow-master/dist/wow.min.js') }}"></script>
<script src="{{ asset('assets/vendor/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select-country/js/bootstrap-select-country.min.js') }}"></script>

<script src="{{ asset('assets/js/dlabnav-init.js') }}"></script>

<script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ asset('assets/js/plugins/dropzone-amd-module.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dragula.min.js') }}"></script>

{{-- like dropdown --}}
<script src="{{ asset('assets/js/dashboard/cms.js') }}"></script>

@if (Session::has('success'))
    <div id="toast" class="show">
        <div id="desc">{{ session('success') }}</div>
    </div>
@endif
@if (Session::has('info'))
    <div id="toast" class="show">
        <div id="desc">{{ session('info') }}</div>
    </div>
@endif
@if (Session::has('warning'))
    <div id="toast" class="show">
        <div id="desc">{{ session('warning') }}</div>
    </div>
@endif
@if (Session::has('error'))
    <div id="toast" class="show">
        <div id="desc">{{ session('error') }}</div>
    </div>
@endif


<!-- Datatable -->
<script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/responsive/responsive.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}"></script>


<script>
    $(document).ready(function() {
        function showToast() {
            var x = document.getElementById("toast");
            x.classList.add("show");
            setTimeout(function() {
                hideToast();
            }, 5000);
        }

        // Function to hide the toast
        function hideToast() {
            var x = document.getElementById("toast");
            x.classList.remove("show");
        }

        showToast();

        $("#desc").click(function() {
            hideToast();
        });
    });

    $(function() {
        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());

    });
    $(document).ready(function() {
        $(".booking-calender .fa.fa-clock-o").removeClass(this);
        $(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
    });
    $('.my-select').selectpicker();

</script>

<script>
    $("#theme_changes").click(function() {
        var body = $("body");
        var lightlogo = $(".nav-header .logo-abbr").attr('data-light');
        var logo = $(".nav-header .logo-abbr").attr('data-dark');
        $.ajax({
            type: 'POST',
            url: '{{ route('theme.setting') }}',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.theme == 'dark') {
                    $('#icon-dark').addClass('d-none');
                    $('#icon-light').removeClass('d-none');
                    body.attr("data-theme-version", "dark");
                    $(".nav-header .logo-abbr").attr(
                        "src",
                        lightlogo
                    );
                } else if (data.theme == 'light') {
                    $('#icon-dark').removeClass('d-none');
                    $('#icon-light').addClass('d-none');
                    body.attr("data-theme-version", "light");
                    $(".nav-header .logo-abbr").attr(
                        "src",
                        logo
                    );
                }
            },
        });
    });
</script>
