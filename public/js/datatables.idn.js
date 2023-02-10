(function ($, DataTable) {
	// Datatable global configuration
	$.extend(true, DataTable.defaults, {
		language: {
			"sEmptyTable":   "Tidak ada data yang tersedia pada tabel ini",
			"sProcessing":   "Sedang memproses...",
			"sLengthMenu":   "Tampilkan _MENU_ entri",
			"sZeroRecords":  "Tidak ditemukan data yang sesuai",
			"sInfo":         "Menampilkan _START_ s.d _END_ dari _TOTAL_ entri",
			"sInfoEmpty":    "Menampilkan 0 s.d. 0 dari 0 entri",
			"sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
			"sInfoPostFix":  "",
			"sSearch":       "Cari:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "Awal",
				"sPrevious": "Sebelumnya",
				"sNext":     "Selanjutnya",
				"sLast":     "Akhir"
			}
		}
	});
})(jQuery, jQuery.fn.dataTable);