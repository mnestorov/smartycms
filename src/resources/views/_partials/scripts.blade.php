{{-- Third parties --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>

{{-- Main JS --}}
<script src="{{ asset('vendor/smartystudio/smartycms/js/admin.js') }}?v={{ File::lastModified(base_path('vendor/smartystudio/smartycms/src/resources/assets/dist/js/admin.js'))}}"></script>