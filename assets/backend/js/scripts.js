$(function() {
	"use strict";
	$(function() {
			$(".preloader").fadeOut();
		}),

		jQuery(document).on("click", ".mega-dropdown", function(i) {
			i.stopPropagation();
		});
	var i = function() {
		(window.innerWidth > 0 ? window.innerWidth : this.screen.width) < 1170 ? ($("body").addClass("mini-sidebar"),
			$(".navbar-brand span").hide(),
			$(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
			$(".sidebartoggler i").addClass("ti-menu")) : ($("body").removeClass("mini-sidebar"),
			$(".navbar-brand span").show());
		var i = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1;
		(i -= 70) < 1 && (i = 1), i > 70 && $(".page-wrapper").css("min-height", i + "px");
	};

	var i = function() {
		(window.innerWidth > 0 ? window.innerWidth : this.screen.width) < 1170 ? ($("body").addClass("mini-sidebar"),
			$(".navbar-brand span").hide(), $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
			$(".sidebartoggler i").addClass("ti-menu")) : ($("body").removeClass("mini-sidebar"),
			$(".navbar-brand span").show());
		var i = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1;
		(i -= 70) < 1 && (i = 1), i > 70 && $(".page-wrapper").css("min-height", i + "px");
	};


	$(window).ready(i), $(window).on("resize", i), $(".sidebartoggler").on("click", function() {
			$("body").hasClass("mini-sidebar") ? ($("body").trigger("resize"), $(".scroll-sidebar, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible"),
				$("body").removeClass("mini-sidebar"), $(".navbar-brand span").show()) : ($("body").trigger("resize"),
				$(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
				$("body").addClass("mini-sidebar"), $(".navbar-brand span").hide());
		}),



		$(".fix-header .header").stick_in_parent({}), $(".nav-toggler").click(function() {
			$("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
				$(".nav-toggler i").addClass("mdi mdi-close");
		}),

		$(".search-box a, .search-box .app-search .srh-btn").on("click", function() {
			$(".app-search").slideToggle(200);
		}), 1

	$(".floating-labels .form-control").on("focus blur", function(i) {
			$(this).parents(".form-group").toggleClass("focused", "focus" === i.type || this.value.length > 0);
		}).trigger("blur"), $(function() {
			for (var i = window.location, o = $("ul#sidebarnav a").filter(function() {
					return this.href == i;
				}).addClass("active").parent().addClass("active");;) {
				if (!o.is("li")) break;
				o = o.parent().addClass("in").parent().addClass("active");
			}
		}),

		$(function() {
			$("#sidebarnav").metisMenu();
		}),

		$(".scroll-sidebar").slimScroll({
			position: "left",
			size: "5px",
			height: "100%",
			color: "#dcdcdc"
		}),

		$(".message-center").slimScroll({
			position: "right",
			size: "5px",
			color: "#dcdcdc"
		}),

		$(".aboutscroll").slimScroll({
			position: "right",
			size: "5px",
			height: "80",
			color: "#dcdcdc"
		}),

		$(".message-scroll").slimScroll({
			position: "right",
			size: "5px",
			height: "570",
			color: "#dcdcdc"
		}),

		$(".chat-box").slimScroll({
			position: "right",
			size: "5px",
			height: "470",
			color: "#dcdcdc"
		}),

		$(".slimscrollright").slimScroll({
			height: "100%",
			position: "right",
			size: "5px",
			color: "#dcdcdc"
		}),

		$("body").trigger("resize"), $(".list-task li label").click(function() {
			$(this).toggleClass("task-done");
		}),

		$("#to-recover").on("click", function() {
			$("#loginform").slideUp(), $("#recoverform").fadeIn();
		}),

		$('a[data-action="collapse"]').on("click", function(i) {
			i.preventDefault(), $(this).closest(".card").find('[data-action="collapse"] i').toggleClass("ti-minus ti-plus"),
				$(this).closest(".card").children(".card-body").collapse("toggle");
		}),

		$('a[data-action="expand"]').on("click", function(i) {
			i.preventDefault(), $(this).closest(".card").find('[data-action="expand"] i').toggleClass("mdi-arrow-expand mdi-arrow-compress"),
				$(this).closest(".card").toggleClass("card-fullscreen");
		}),

		$('a[data-action="close"]').on("click", function() {
			$(this).closest(".card").removeClass().slideUp("fast");
		});

	$('input#tanggal, input#tanggal_pesan, input#tanggal_transaksi, input#tanggal_kerja, input#tanggal_awal, input#tanggal_akhir').Zebra_DatePicker();
});

// Functions
function refreshPageForChangeRecordCount(content) {
	var recordPerPage = $('select#record_per_page').val();
	// console.log(recordPerPage);
	$.ajax({
		url: '../functions/function_responds.php?content=change_record_count',
		// url : '/service-panggil/admin/?content=' + content,
		type: 'POST',
		// async: false,
		data: {
			record_count: recordPerPage
		},
		success: function(data) {
			// console.log(data);
			window.location.replace('/service-panggil/admin/?content=' + content);
			// window.location.location('/service-panggil/admin/?content=' + content);
		}
	});
}

function search(page, record_count, content, key_word) {
	$.ajax({
		url: '../functions/function_responds.php?content=search_' + content,
		type: 'POST',
		data: {
			page: page,
			record_count: record_count,
			key_word: key_word
		},
		success: function(data) {
			$('tbody#data_list').html(data);
			// console.log(data);
		}
	});
}

function confirmDelete(urlDelete, urlRefresh) {
	swal({
		title: 'Anda yakin ingin menghapus data ini?',
		// text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya',
		cancelButtonText: 'Tidak'
	}).then((result) => {
		if (result.value == true) {
			$.ajax({
				url: urlDelete,
				type: "GET",
				dataType: "text",
				success: function() {
					// window.location.replace(urlRefresh);
					refreshPage(urlRefresh);
					// swal("Suskses!", "Data berhasil dihapus.", "success");
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(thrownError);
					swal("Error!", "Data tidak berhasil dihapus.", "error");
				}
			});
		}
	})
}

function refreshPage(sendURL) {
	window.location.replace(sendURL);
}

function toastrNotification(type, info, message) {
	toastr[type]("</b>" + info  + "</b> " + message);
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "0",
		"hideDuration": "1000",
		"timeOut": "0",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
}

// JQuery
$("select#select_id_pelanggan").select2({
	// minimumInputLength: 3,
	// tags: [],
	theme: "bootstrap",
	width: '100%',
	dropdownAutoWidth : true,
	placeholder: '...Semua Pelanggan...',
	ajax: {
		url: '../functions/function_responds.php?content=select_pelanggan',
		type: "POST",
		dataType: 'json',
		// quietMillis: 50,
		delay: 250,
		data: function(params) {
			return {
				key_word: params.term
			};
		},
		processResults: function(data) {
			return {
				results: $.map(data, function(item) {
					return {
						id: item.id_pelanggan,
						text: item.nama_lengkap
					};
				})
			};
		},
		cache: true
	},
	templateSelection: function(data) {
		if (!data.text) { // !data.id
			return data.id;
		}
		var $formatList = $('<span>' + data.text + '</span>');
		return $formatList;
	},
	templateResult: function(data) {
		if (!data.text) { // !data.id
			return data.id;
		}
		var $formatList = $('<span>' + data.text + '</span>');
		return $formatList;
	},
	selectOnClose: true
});

$('body').on('click', 'button#detail_pemesanan', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	var content = $(this).data('content');
	console.log(id);
	$.ajax({
			url: '../functions/function_responds.php?content=get_' + content,
			type: 'POST',
			dataType: 'html',
			data: {
				id: id
			},
		}).done(function(data) {
			$('tbody#form_list').html(data);
			console.log("success");
		}).fail(function() {
			console.log("error");
		})
		// .always(function() {
		//     console.log("complete");
		// })
	;

});

$('body').on('click', 'button#detail_pengguna', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	var content = $(this).data('content');
	console.log(id);
	$.ajax({
			url: '../functions/function_responds.php?content=get_' + content,
			type: 'POST',
			dataType: 'html',
			data: {
				id: id
			},
		}).done(function(data) {
			$('tbody#form_list').html(data);
			console.log("success");
		}).fail(function() {
			console.log("error");
		})
		// .always(function() {
		//     console.log("complete");
		// })
	;

});

$('body').on('click', 'button#bukti_pembayaran', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	var content = $(this).data('content');
	console.log(id);
	$.ajax({
			url: '../functions/function_responds.php?content=get_bukti_pembayaran',
			type: 'POST',
			dataType: 'html',
			data: {
				id: id
			},
		}).done(function(data) {
			$('div#content').html(data);
			console.log("success");
		}).fail(function() {
			console.log("error");
		})
		// .always(function() {
		//     console.log("complete");
		// })
	;

});

$('#modal_edit_pengerjaan').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget);
	var id_pemesanan_detail = button.data('id_pemesanan_detail');
	var id_pemesanan = button.data('id_pemesanan');
	var id_kategori = button.data('id_kategori');
	var modal = $(this);
	$.ajax({
		url: '../functions/function_responds.php?content=modal_pengerjaan_by_id_kategori',
		type: 'POST',
		dataType: 'html',
		data: {
			id_pemesanan_detail: id_pemesanan_detail,
			id_pemesanan: id_pemesanan,
			id_kategori: id_kategori
		},
	}).done(function(data) {
		modal.find('input#id_pemesanan_detail').val(id_pemesanan_detail);
		modal.find('input#id_pemesanan').val(id_pemesanan);
		modal.find('input#id_kategori').val(id_kategori);
		modal.find('div#accordion').html(data);
		// console.log("success");
	}).fail(function() {
		// console.log("error");
	});
});

$('#modal_edit_processing').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget);
	var id_pemesanan_detail = button.data('id_pemesanan_detail');
	var id_pemesanan = button.data('id_pemesanan');
	var id_kategori = button.data('id_kategori');
	var id_jenis_layanan_sparepart = button.data('id_jenis_layanan_sparepart');
	var jenis_pengerjaan = button.data('jenis_pengerjaan');
	var modal = $(this);
	$.ajax({
		url: '../functions/function_responds.php?content=modal_processing_by_id_kategori',
		type: 'POST',
		dataType: 'html',
		data: {
			id_pemesanan_detail: id_pemesanan_detail,
			id_pemesanan: id_pemesanan,
			id_kategori: id_kategori,
			id_jenis_layanan_sparepart: id_jenis_layanan_sparepart,
			jenis_pengerjaan: jenis_pengerjaan
		},
	}).done(function(data) {
		modal.find('input#id_pemesanan_detail').val(id_pemesanan_detail);
		modal.find('input#id_pemesanan').val(id_pemesanan);
		modal.find('input#id_kategori').val(id_kategori);
		modal.find('div#accordion').html(data);
		// console.log("success");
	}).fail(function() {
		// console.log("error");
	});
});

$("body").on('click change', 'input#pengerjaan', function() { // input:checkbox
	// in the handler, 'this' refers to the box clicked on
	var $box = $(this);
	if ($box.is(":checked")) {
		// the name of the box is retrieved using the .attr() method
		// as it is assumed and expected to be immutable
		var group = "input:checkbox[id='" + $box.attr("id") + "']";
		// the checked state of the group/box on the other hand will change
		// and the current value is retrieved using .prop() method
		$(group).prop("checked", false);
		$box.prop("checked", true);
		// console.log('Success, True');
	} else {
		$box.prop("checked", false);
		// console.log('Success, False');
	}
});

$('#modal_form_biaya_tambahan').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget);
	var id_biaya_tambahan = button.data('id_biaya_tambahan');
	var id_pemesanan = button.data('id_pemesanan');
	var action = button.data('action');
	var modal = $(this);
	if (action == 'ubah') {
		// Get ID Biaya Tambahan
		modal.find('input#id_biaya_tambahan').val(id_biaya_tambahan);
		// Get Keterangan
		$.ajax({
			url: '../functions/function_responds.php?content=get_data_biaya_tambahan',
			type: 'POST',
			dataType: 'html',
			data: {
				id_biaya_tambahan: id_biaya_tambahan,
				id_pemesanan: id_pemesanan,
				filter: 'keterangan'
			},
		}).done(function(data) {
			modal.find('input#keterangan').val(data);
			// console.log("Success Keterangan.");
		}).fail(function() {
			// console.log("Error Keterangan.");
		});
		// Get Jumlah
		$.ajax({
			url: '../functions/function_responds.php?content=get_data_biaya_tambahan',
			type: 'POST',
			dataType: 'html',
			data: {
				id_biaya_tambahan: id_biaya_tambahan,
				id_pemesanan: id_pemesanan,
				filter: 'jumlah'
			},
		}).done(function(data) {
			modal.find('input#jumlah').val(parseInt(data));
			// console.log("Success Jumlah.");
		}).fail(function() {
			// console.log("Error Jumlah.");
		});
		modal.find('form#form_biaya_tambahan').attr("action", "?content=biaya_tambahan_proses&proses=edit&id_pemesanan=" + id_pemesanan);
	} else {
		modal.find('input#id_biaya_tambahan').val('');
		modal.find('input#keterangan').val('');
		modal.find('input#jumlah').val('');
		modal.find('form#form_biaya_tambahan').attr("action", "?content=biaya_tambahan_proses&proses=add&id_pemesanan=" + id_pemesanan);
	}
});

$('#modal_form_additional_cost').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget);
	var id_biaya_tambahan = button.data('id_biaya_tambahan');
	var id_array = button.data('id_array');
	var id_pemesanan = button.data('id_pemesanan');
	var action = button.data('action');
	var modal = $(this);
	if (action == 'ubah') {
		// Get ID Biaya Tambahan
		modal.find('input#id_biaya_tambahan').val(id_biaya_tambahan);
		modal.find('input#id_array').val(id_array);
		// Get Keterangan
		$.ajax({
			url: '../functions/function_responds.php?content=get_data_additional_cost',
			type: 'POST',
			dataType: 'html',
			data: {
				id_biaya_tambahan: id_biaya_tambahan,
				id_pemesanan: id_pemesanan,
				filter: 'keterangan'
			},
		}).done(function(data) {
			modal.find('input#keterangan').val(data);
			// console.log("Success Keterangan.");
		}).fail(function() {
			// console.log("Error Keterangan.");
		});
		// Get Jumlah
		$.ajax({
			url: '../functions/function_responds.php?content=get_data_additional_cost',
			type: 'POST',
			dataType: 'html',
			data: {
				id_biaya_tambahan: id_biaya_tambahan,
				id_pemesanan: id_pemesanan,
				filter: 'jumlah'
			},
		}).done(function(data) {
			modal.find('input#jumlah').val(parseInt(data));
			// console.log("Success Jumlah.");
		}).fail(function() {
			// console.log("Error Jumlah.");
		});
		modal.find('form#form_biaya_tambahan').attr("action", "?content=biaya_tambahan_proses&proses=edit_additional_cost&id_pemesanan=" + id_pemesanan);
	} else {
		modal.find('input#id_biaya_tambahan').val('');
		modal.find('input#keterangan').val('');
		modal.find('input#jumlah').val('');
		modal.find('form#form_biaya_tambahan').attr("action", "?content=biaya_tambahan_proses&proses=add&id_pemesanan=" + id_pemesanan);
	}
});

$('body').on('click', '#image_gallery', function (event) {

	// event.preventDefault();
	var pswpElement = document.querySelectorAll('.pswp')[0];

	var items = [];

	$(this).each(function () {
		items.push({
			src: $(this).attr('src'),
			w: 600,
			h: 600
		});
	});

	// define options (if needed)
	var options = {
		// history & focus options are disabled on CodePen        
		history: false,
		focus: true,

		// getDoubleTapZoom: function(isMouseClick, item) {
		//     // isMouseClick          - true if mouse, false if double-tap
		//     // item                  - slide object that is zoomed, usually current
		//     // item.initialZoomLevel - initial scale ratio of image
		//     //                         e.g. if viewport is 700px and image is 1400px,
		//     //                              initialZoomLevel will be 0.5

		//     if(isMouseClick) {

		//         // is mouse click on image or zoom icon

		//         // zoom to original
		//         return 1;

		//         // e.g. for 1400px image:
		//         // 0.5 - zooms to 700px
		//         // 2   - zooms to 2800px

		//     } else {

		//         // is double-tap

		//         // zoom to original if initial zoom is less than 0.7x,
		//         // otherwise to 1.5x, to make sure that double-tap gesture always zooms image
		//         return item.initialZoomLevel < 0.7 ? 1 : 1.5;
		//     }
		// },

		showHideOpacity: true,
		bgOpacity: 1,
		showAnimationDuration: 500,
		hideAnimationDuration: 500

	};

	var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

	gallery.init();
});