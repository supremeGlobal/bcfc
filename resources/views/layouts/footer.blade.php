<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/js/overlayscrollbars.browser.es6.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/adminlte.min.js') }}"></script>

<script src="//cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dataTables').DataTable({
            pageLength: 15,
            lengthMenu: [
                [15, 25, 50, -1],
                [15, 25, 50, "All"]
            ],
			order: [[0, 'desc']]
        });
    });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
	flatpickr(".datepicker", {
		dateFormat: "Y-m-d",
		maxDate: "2025-10-24", 
		minDate: "2011-10-24",
		// allowInput: true
	});
</script>