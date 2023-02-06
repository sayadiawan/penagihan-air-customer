<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('admin-assets/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('admin-assets/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin-assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('admin-assets/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('admin-assets/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('admin-assets/assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('admin-assets/assets/js/dashboards-analytics.js') }}"></script>

{{-- select 2 --}}
{{-- <script src="{{ asset('admin-assets/vendor/select2/dist/js/select2.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

{{-- DATATABLES --}}
{{-- <script src="{{ asset('assets/admin/vendors/datatables/datatables.min.js') }}"></script> --}}
<script src="{{ asset('admin-assets/vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendor/datatables/DataTables-1.12.1/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendor/datatables/FixedHeader-3.2.3/js/fixedHeader.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendor/datatables/Responsive-2.3.0/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendor/datatables/Responsive-2.3.0/js/responsive.dataTables.min.js') }}"></script>

{{-- jquery tambahan --}}
<script src="{{ asset('admin-assets/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/jquery-file-upload.js') }}"></script>

{{-- sweetalert --}}
<script src="{{ asset('admin-assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

{{-- Tag Input --}}
<script src="{{ asset('admin-assets/vendor/taginput/src/jquery.tagsinput.js') }}"></script>

{{-- Dragula dragable --}}
<script src="{{ asset('admin-assets/vendor/dragula-master/dist/dragula.min.js') }}"></script>

{{-- custm script --}}
<script>
  $('.table-responsive').on('show.bs.dropdown', function() {
    $('.table-responsive').css("overflow", "inherit");
  });

  $('.table-responsive').on('hide.bs.dropdown', function() {
    $('.table-responsive').css("overflow", "auto");
  })

  $(document).ready(function() {
    if ($('.laravel-select2').length) {
      $('.laravel-select2').select2({
        theme: "bootstrap-5",
        width: '100%'
      });
    }

    // bind change event to select
    $('#laravel_navigation').on('change', function() {
      var url = $(this).val(); // get selected value
      if (url) { // require a URL
        window.location = url; // redirect
      }
      return false;
    });

    // check active sub parent menu
    // check active sub parent menu
    var listItems = $('.layout-menu ul li.menu-sub-parent ul.menu-sub .menu-item');

    //Loop the listitems and check to see if any are active.
    $.each(listItems, function(key, litem) {
      if ($(litem).hasClass('active')) {
        $(this).parent().parent().addClass('active');
        return false;
      } else {
        $(this).parent().parent().removeClass('active');
      }
    })
  });
</script>
{{-- /custm script --}}
