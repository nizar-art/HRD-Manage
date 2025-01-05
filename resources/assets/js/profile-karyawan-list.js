/**
 * app-ecommerce-product-list
 */

'use strict';

$(function () {
  // Initialize Select2 and SelectPicker for Dropdowns
  const select2 = $('.select2'),
    selectPicker = $('.selectpicker');

  // Bootstrap select
  if (selectPicker.length) {
    selectPicker.selectpicker();
  }

  // select2 initialization
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  }
});

// Datatable (jquery)
$(function () {
  let borderColor, bodyBg, headingColor;

  if (isDarkStyle) {
    borderColor = config.colors_dark.borderColor;
    bodyBg = config.colors_dark.bodyBg;
    headingColor = config.colors_dark.headingColor;
  } else {
    borderColor = config.colors.borderColor;
    bodyBg = config.colors.bodyBg;
    headingColor = config.colors.headingColor;
  }

  // Variable declaration for table
  var dt_product_table = $('.datatables-products'),
    ProfileKaryawanAdd = baseUrl + 'profile/add',
    statusObj = {
      1: { title: 'Scheduled', class: 'bg-label-warning' },
      2: { title: 'Publish', class: 'bg-label-success' },
      3: { title: 'Inactive', class: 'bg-label-danger' }
    },
    categoryObj = {
      0: { title: 'Household' },
      1: { title: 'Office' },
      2: { title: 'Electronics' },
      3: { title: 'Shoes' },
      4: { title: 'Accessories' },
      5: { title: 'Game' }
    },
    stockObj = {
      0: { title: 'Out_of_Stock' },
      1: { title: 'In_Stock' }
    },
    stockFilterValObj = {
      0: { title: 'Out of Stock' },
      1: { title: 'In Stock' }
    };

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // E-commerce Products datatable

  if (dt_product_table.length) {
    var dt_products = dt_product_table.DataTable({
      ajax: {
        url: baseUrl + 'table/profile-karyawan'
      },
      columns: [
        { data: '' },
        { data: 'id' },
        { data: 'nama_lengkap' },
        { data: 'jenis_kelamin' },
        { data: 'tempat_lahir' },
        { data: 'tanggal_lahir' },
        { data: 'email' },
        { data: 'nomor_hp' },
        { data: 'actions' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return ''; // Control column (Empty for now)
          }
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          checkboxes: {
            selectAllRender: '<input type="checkbox" class="form-check-input">'
          },
          render: function () {
            return '<input type="checkbox" class="dt-checkboxes form-check-input">';
          },
          searchable: false
        },
        {
          // Nama Lengkap
          targets: 2,
          render: function (data, type, full, meta) {
            var namaLengkap = full['nama_lengkap'];
            return '<span class="text-heading text-wrap fw-medium">' + namaLengkap + '</span>';
          }
        },
        {
          // Jenis Kelamin
          targets: 3,
          render: function (data, type, full, meta) {
            var jenisKelamin = full['jenis_kelamin'];
            var badgeClass;
            switch (jenisKelamin) {
              case 'Laki-laki':
                badgeClass = 'bg-label-info';
                break;
              case 'Perempuan':
                badgeClass = 'bg-label-danger';
                break;
            }
            return (
              '<div class="d-flex justify-content-center align-items-center">' +
              '<span class="badge ' +
              badgeClass +
              ' text-capitalize">' +
              jenisKelamin +
              '</span>' +
              '</div>'
            );
          }
        },
        {
          // Tempat Lahir
          targets: 4,
          render: function (data, type, full, meta) {
            var tempatLahir = full['tempat_lahir'];
            return '<span class="text-heading text-wrap fw-medium">' + tempatLahir + '</span>';
          }
        },
        {
          // Tanggal Lahir
          targets: 5,
          render: function (data, type, full, meta) {
            var tanggalLahir = full['tanggal_lahir'];
            return '<span class="text-heading text-wrap fw-medium">' + tanggalLahir + '</span>';
          }
        },
        {
          // Alamat Email
          targets: 6,
          render: function (data, type, full, meta) {
            var alamatEmail = full['email'];
            return '<span class="text-heading text-wrap fw-medium">' + alamatEmail + '</span>';
          }
        },
        {
          // Nomer HP
          targets: 7,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var nomerHp = full['nomor_hp'];
            return '<span class="text-heading text-wrap fw-medium">' + nomerHp + '</span>';
          }
        },
        {
          // Actions (this can include buttons like edit, delete, etc.)
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            const baseUrl = 'http://127.0.0.1:8000/'; // Ganti dengan base URL aplikasi Anda
            const id = full.id; // Pastikan 'id' adalah nama kolom di data Anda yang berisi ID karyawan
            const editPribadi = full['id'];
            const Delete = full['id'];

            return (
              '<div class="d-flex align-items-center">' +
              `<a href="javascript:;" data-bs-toggle="tooltip" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record" data-id="${Delete}" data-bs-placement="top" title="Delete">` +
              '<i class="ti ti-trash mx-2 ti-md"></i>' +
              '</a>' +
              '<a href="' +
              baseUrl +
              'detail/karyawan/' +
              id +
              '" data-bs-toggle="tooltip" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" data-bs-placement="top" title="Preview Invoice">' +
              '<i class="ti ti-eye mx-2 ti-md"></i>' +
              '</a>' +
              '<div class="dropdown">' +
              '<a href="javascript:;" class="btn dropdown-toggle hide-arrow btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill p-0" data-bs-toggle="dropdown">' +
              '<i class="ti ti-dots-vertical ti-md"></i>' +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +
              `<button id="btnEditPribadi" class="dropdown-item edit-pribadi" data-id="${editPribadi}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditUser">Edit Pribadi</button>` +
              '<a id="btnEditPendidikan" class="dropdown-item" href="/pages/misc-under-maintenance">Edit Pendidikan</a>' +
              '<a id="btnEditKeluarga" class="dropdown-item" href="/pages/misc-under-maintenance">Edit Keluarga</a>' +
              '</div>' +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [2, 'asc'], //set any columns order asc/desc
      dom:
        '<"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"' +
        '<"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f>' +
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"lB>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [7, 10, 20, 50, 70, 100], //for length of menu
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search Karyawan',
        info: 'Displaying _START_ to _END_ of _TOTAL_ entries',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ti ti-upload me-1 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('product-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                // Customize print view for dark
                $(win.document.body)
                  .css('color', headingColor)
                  .css('border-color', borderColor)
                  .css('background-color', bodyBg);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-export me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('product-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-text me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('product-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
          ]
        },
        {
          text: '<i class="ti ti-copy me-0 me-scopm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Copy Link</span>',
          className: 'copy-link btn btn-primary ms-2 ms-sm-0 waves-effect waves-light',
          action: function () {
            navigator.clipboard.writeText('http://127.0.0.1:8000/auth/login-basic').then(function () {
              alert('Link copied to clipboard!');
            }, function () {
              alert('Failed to copy the link.');
            });
          }
        }

      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['product_name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      },
      initComplete: function () {
        // Adding status filter once table initialized
        this.api()
          .columns(-2)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="ProductStatus" class="form-select text-capitalize"><option value="">Status</option></select>'
            )
              .appendTo('.product_status')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + statusObj[d].title + '">' + statusObj[d].title + '</option>');
              });
          });
        // Adding category filter once table initialized
        this.api()
          .columns(3)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="ProductCategory" class="form-select text-capitalize"><option value="">Category</option></select>'
            )
              .appendTo('.product_category')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + categoryObj[d].title + '">' + categoryObj[d].title + '</option>');
              });
          });
        // Adding stock filter once table initialized
        this.api()
          .columns(4)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="ProductStock" class="form-select text-capitalize"><option value=""> Stock </option></select>'
            )
              .appendTo('.product_stock')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + stockObj[d].title + '">' + stockFilterValObj[d].title + '</option>');
              });
          });
      }
    });
    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');
  }
  const select2 = $('.select2');

  // Initialize Select2 for all select elements with class select2
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.select2({
        placeholder: 'Pilih Opsi',
        dropdownParent: $this.parent()
      });
    });
  }

  // Copy address from KTP to Domisili when checkbox is checked
  $('#same-address').on('change', function () {
    if ($(this).is(':checked')) {
      $('#jalan_domisili').val($('#jalan_ktp').val());
      $('#rt_domisili').val($('#rt_ktp').val());
      $('#rw_domisili').val($('#rw_ktp').val());
      $('#provinsi_domisili').val($('#provinsi_ktp').val()).trigger('change');

      $('#provinsi_domisili').on('change', function () {
        let kabupatenKtp = $('#kabupaten_ktp').val();
        $('#kabupaten_domisili').html('<option>Loading...</option>');

        $.ajax({
          url: '/get-kabupaten',
          type: 'GET',
          data: { provinsi_id: $('#provinsi_domisili').val() },
          success: function (response) {
            $('#kabupaten_domisili').empty().append('<option>Pilih Kabupaten</option>');
            response.forEach(function (kabupaten) {
              $('#kabupaten_domisili').append(
                '<option value="' +
                  kabupaten.id +
                  '" ' +
                  (kabupaten.id == kabupatenKtp ? 'selected' : '') +
                  '>' +
                  kabupaten.name +
                  '</option>'
              );
            });
            $('#kabupaten_domisili').trigger('change');
          }
        });
      });

      $('#kabupaten_domisili').on('change', function () {
        let kecamatanKtp = $('#kecamatan_ktp').val();
        $('#kecamatan_domisili').html('<option>Loading...</option>');

        $.ajax({
          url: '/get-kecamatan',
          type: 'GET',
          data: { kabupaten_id: $(this).val() },
          success: function (response) {
            $('#kecamatan_domisili').empty().append('<option>Pilih Kecamatan</option>');
            response.forEach(function (kecamatan) {
              $('#kecamatan_domisili').append(
                '<option value="' +
                  kecamatan.id +
                  '" ' +
                  (kecamatan.id == kecamatanKtp ? 'selected' : '') +
                  '>' +
                  kecamatan.name +
                  '</option>'
              );
            });
            $('#kecamatan_domisili').trigger('change');
          }
        });
      });

      $('#kecamatan_domisili').on('change', function () {
        let desaKtp = $('#desa_ktp').val();
        $('#desa_domisili').html('<option>Loading...</option>');

        $.ajax({
          url: '/get-desa',
          type: 'GET',
          data: { kecamatan_id: $(this).val() },
          success: function (response) {
            $('#desa_domisili').empty().append('<option>Pilih Desa</option>');
            response.forEach(function (desa) {
              $('#desa_domisili').append(
                '<option value="' +
                  desa.id +
                  '" ' +
                  (desa.id == desaKtp ? 'selected' : '') +
                  '>' +
                  desa.name +
                  '</option>'
              );
            });
          }
        });
      });
    } else {
      // Reset address fields when checkbox is unchecked
      $('#jalan_domisili, #rt_domisili, #rw_domisili').val('');
      $('#provinsi_domisili, #kabupaten_domisili, #kecamatan_domisili, #desa_domisili').val('').trigger('change');
    }
  });

  // Dynamic Kabupaten Filter
  $('#provinsi_ktp').on('change', function () {
    let provinsiId = $(this).val();
    $('#kabupaten_ktp').html('<option>Loading...</option>');

    $.ajax({
      url: '/get-kabupaten',
      type: 'GET',
      data: { provinsi_id: provinsiId },
      success: function (response) {
        $('#kabupaten_ktp').empty().append('<option>Pilih Kabupaten</option>');
        response.forEach(function (kabupaten) {
          $('#kabupaten_ktp').append('<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>');
        });
      }
    });
  });
  // Filter Kecamatan berdasarkan Kabupaten
  $('#kabupaten_ktp').on('change', function () {
    let kabupatenId = $(this).val();
    $('#kecamatan_ktp').html('<option selected disabled>Loading...</option>');

    $.ajax({
      url: '/get-kecamatan',
      type: 'GET',
      data: { kabupaten_id: kabupatenId },
      success: function (response) {
        $('#kecamatan_ktp').empty();
        $('#kecamatan_ktp').append('<option selected disabled>Pilih Kecamatan</option>');
        response.forEach(function (kecamatan) {
          $('#kecamatan_ktp').append(`<option value="${kecamatan.id}">${kecamatan.name}</option>`);
        });
      }
    });
  });

  // Filter Desa berdasarkan Kecamatan
  $('#kecamatan_ktp').on('change', function () {
    let kecamatanId = $(this).val();
    $('#desa_ktp').html('<option selected disabled>Loading...</option>');

    $.ajax({
      url: '/get-desa',
      type: 'GET',
      data: { kecamatan_id: kecamatanId },
      success: function (response) {
        $('#desa_ktp').empty();
        $('#desa_ktp').append('<option selected disabled>Pilih Desa</option>');
        response.forEach(function (desa) {
          $('#desa_ktp').append(`<option value="${desa.id}">${desa.name}</option>`);
        });
      }
    });
  });

  $('.datatables-products').on('click', '.edit-pribadi', function (e) {
    const id = $(this).data('id'); // Ambil ID dari atribut data-id tombol
    const dtrModal = $('.dtr-bs-modal.show');

    // Sembunyikan modal responsif (jika ada)
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // Ubah judul offcanvas
    $('#offcanvasEditUserLabel').html('Edit Data Pribadi');

    // Panggil data berdasarkan ID
    $.get(`/profile/karyawan/editKaryawan/${id}`, function (response) {
      if (response) {
        const karyawan = response.karyawan;
        const alamatKtp = response.alamat_ktp;
        const alamatDomisili = response.alamat_domisili;

        // Populate the form with the karyawan data
        $('#id').val(karyawan.id);
        $('#nama_lengkap').val(karyawan.nama_lengkap);
        $('#jenis_kelamin').val(karyawan.jenis_kelamin).trigger('change'); // Dropdown
        $('#tempat_lahir').val(karyawan.tempat_lahir);
        $('#tanggal_lahir').val(karyawan.tanggal_lahir);
        $('#email').val(karyawan.email);
        $('#agama').val(karyawan.agama).trigger('change'); // Dropdown
        $('#nomor_nik_ktp').val(karyawan.nomor_nik_ktp);
        $('#nomor_npwp').val(karyawan.nomor_npwp);
        $('#nomor_rekening').val(karyawan.nomor_rekening);
        $('#nomor_hp').val(karyawan.nomor_hp);
        $('#golongan_darah').val(karyawan.golongan_darah).trigger('change'); // Dropdown
        $('#ibu_kandung').val(karyawan.ibu_kandung);
        $('#status_pernikahan').val(karyawan.status_pernikahan).trigger('change'); // Dropdown

        // Populate Alamat KTP
        if (alamatKtp) {
          $('#jalan_ktp').val(alamatKtp.jalan || '');
          $('#rt_ktp').val(alamatKtp.rt || '');
          $('#rw_ktp').val(alamatKtp.rw || '');
          $('#desa_ktp').val(alamatKtp.desa || '');
          $('#kecamatan_ktp').val(alamatKtp.kecamatan || '');
          $('#kabupaten_ktp').val(alamatKtp.kabupaten || '');
          $('#provinsi_ktp')
            .val(alamatKtp.provinsi || '')
            .trigger('change');
        }

        // Populate Alamat Domisili
        if (alamatDomisili) {
          $('#same-address').prop('checked', false); // Uncheck "Alamat Sama"
          $('#jalan_domisili').val(alamatDomisili.jalan || '');
          $('#rt_domisili').val(alamatDomisili.rt || '');
          $('#rw_domisili').val(alamatDomisili.rw || '');
          $('#desa_domisili').val(alamatDomisili.desa || '');
          $('#kecamatan_domisili').val(alamatDomisili.kecamatan || '');
          $('#kabupaten_domisili').val(alamatDomisili.kabupaten || '');
          $('#provinsi_domisili')
            .val(alamatDomisili.provinsi || '')
            .trigger('change');
        } else {
          // If no domisili address, assume it's the same as KTP
          $('#same-address').prop('checked', true); // Check "Alamat Sama"
          $('#jalan_domisili').val('');
          $('#rt_domisili').val('');
          $('#rw_domisili').val('');
          $('#desa_domisili').val('');
          $('#kecamatan_domisili').val('');
          $('#kabupaten_domisili').val('');
          $('#provinsi_domisili').val('').trigger('change');
        }

        // Open the offcanvas
        $('#offcanvasEditUser').offcanvas('show');
      }
    }).fail(function (jqXHR) {
      if (jqXHR.status === 404) {
        alert('Data karyawan tidak ditemukan.');
      } else {
        alert('Terjadi kesalahan. Silakan coba lagi.');
      }
    });
  });

  // Checkbox "Sama dengan Alamat KTP"
  $('#same-address').on('change', function () {
    if ($(this).is(':checked')) {
      $('#jalan_domisili').val($('#jalan_ktp').val());
      $('#rt_domisili').val($('#rt_ktp').val());
      $('#rw_domisili').val($('#rw_ktp').val());
      $('#desa_domisili').val($('#desa_ktp').val());
      $('#kecamatan_domisili').val($('#kecamatan_ktp').val());
      $('#kabupaten_domisili').val($('#kabupaten_ktp').val());
      $('#provinsi_domisili').val($('#provinsi_ktp').val()).trigger('change');
    } else {
      // Reset domisili fields
      $('#jalan_domisili').val('');
      $('#rt_domisili').val('');
      $('#rw_domisili').val('');
      $('#desa_domisili').val('');
      $('#kecamatan_domisili').val('');
      $('#kabupaten_domisili').val('');
      $('#provinsi_domisili').val('').trigger('change');
    }
  });

  // User form validation and submission
  $('#form-data-pribadi').submit(function (e) {
    e.preventDefault();

    // Validasi ID
    const id = $('#id').val();
    if (!id) {
      Swal.fire({
        title: 'Error!',
        text: 'ID tidak ditemukan.',
        icon: 'error'
      });
      return;
    }

    // Ambil nilai dari input fields menggunakan jQuery
    const namaLengkap = $('#nama_lengkap').val();
    const jenisKelamin = $('#jenis_kelamin').val();
    const tempatLahir = $('#tempat_lahir').val();
    const tanggalLahir = $('#tanggal_lahir').val();
    const email = $('#email').val();
    const agama = $('#agama').val();
    const nomorNikKtp = $('#nomor_nik_ktp').val();
    const nomorNpwp = $('#nomor_npwp').val() || '-';
    const nomorRek = $('#nomor_rekening').val() || '-';
    const nomorHp = $('#nomor_hp').val();
    const ibuKandung = $('#ibu_kandung').val();
    const golonganDarah = $('#golongan_darah').val();
    const statusPernikahan = $('#status_pernikahan').val();

    // Alamat KTP
    const jalanKtp = $('#jalan_ktp').val();
    const rtKtp = $('#rt_ktp').val();
    const rwKtp = $('#rw_ktp').val();
    const provinsiKtp = $('#provinsi_ktp').find(':selected').text(); // Ambil nama provinsi, bukan ID
    const kabupatenKtp = $('#kabupaten_ktp').find(':selected').text(); // Ambil nama kabupaten
    const kecamatanKtp = $('#kecamatan_ktp').find(':selected').text(); // Ambil nama kecamatan
    const desaKtp = $('#desa_ktp').find(':selected').text();

    // Alamat Domisili
    const jalanDomisili = $('#jalan_domisili').val();
    const rtDomisili = $('#rt_domisili').val();
    const rwDomisili = $('#rw_domisili').val();
    const provinsiDomisili = $('#provinsi_domisili').find(':selected').text();
    const kabupatenDomisili = $('#kabupaten_domisili').find(':selected').text();
    const kecamatanDomisili = $('#kecamatan_domisili').find(':selected').text();
    const desaDomisili = $('#desa_domisili').find(':selected').text();

    const isSameAddress = $('#same-address').prop('checked');

    // Validasi
    if (
      !namaLengkap ||
      !jenisKelamin ||
      !tempatLahir ||
      !tanggalLahir ||
      !email ||
      !agama ||
      !nomorNikKtp ||
      !nomorHp ||
      !ibuKandung ||
      !statusPernikahan ||
      !jalanKtp ||
      !rtKtp ||
      !rwKtp ||
      !provinsiKtp ||
      !kabupatenKtp ||
      !kecamatanKtp ||
      !desaKtp
    ) {
      Swal.fire('Warning', 'Please fill in all required fields.', 'warning');
      return;
    }

    if (rtKtp.length > 3 || rwKtp.length > 3) {
      Swal.fire('Warning', 'RT/RW in KTP must not be greater than 3 characters.', 'warning');
      return;
    }

    if (!isSameAddress && (rtDomisili.length > 3 || rwDomisili.length > 3)) {
      Swal.fire('Warning', 'RT/RW in domisili must not be greater than 3 characters.', 'warning');
      return;
    }

    if (
      !isSameAddress &&
      (!jalanDomisili ||
        !rtDomisili ||
        !rwDomisili ||
        !provinsiDomisili ||
        !kabupatenDomisili ||
        !kecamatanDomisili ||
        !desaDomisili)
    ) {
      Swal.fire('Warning', 'Please complete your domisili address.', 'warning');
      return;
    }

    // Siapkan data untuk dikirim dalam format JSON
    const formData = {
      id: id,
      nama_lengkap: namaLengkap,
      jenis_kelamin: jenisKelamin,
      tempat_lahir: tempatLahir,
      tanggal_lahir: tanggalLahir,
      email: email,
      agama: agama,
      nomor_nik_ktp: nomorNikKtp,
      nomor_npwp: nomorNpwp,
      nomor_rekening: nomorRek,
      nomor_hp: nomorHp,
      ibu_kandung: ibuKandung,
      golongan_darah: golonganDarah,
      status_pernikahan: statusPernikahan,
      alamat_ktp: {
        jalan: jalanKtp,
        rt: rtKtp,
        rw: rwKtp,
        provinsi: provinsiKtp,
        kabupaten: kabupatenKtp,
        kecamatan: kecamatanKtp,
        desa: desaKtp
      }
    };

    if (!isSameAddress) {
      formData.alamat_domisili = {
        jalan: jalanDomisili,
        rt: rtDomisili,
        rw: rwDomisili,
        provinsi: provinsiDomisili,
        kabupaten: kabupatenDomisili,
        kecamatan: kecamatanDomisili,
        desa: desaDomisili
      };
    }

    // Kirim data dengan AJAX
    $.ajax({
      url: `/profile/karyawan/updateKaryawan/${id}`,
      method: 'PUT',
      data: formData,
      success: function (response) {
        // Sukses
        dt_products.draw();
        $('#offcanvasEditUser').offcanvas('hide');
        Swal.fire({
          icon: 'success',
          title: 'Successfully Updated!',
          text: response.message || 'Data berhasil diperbarui.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(function() {
          // Reload halaman setelah dialog ditutup
          window.location.reload();
        });
      },
      error: function () {
        // Gagal
        $('#offcanvasEditUser').offcanvas('hide');
        Swal.fire({
          title: 'Gagal Memperbarui Data!',
          text: 'Silakan coba lagi',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Delete Record
  $(document).on('click', '.delete-record', function () {
    var id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // Show confirmation dialog
    Swal.fire({
      icon: 'warning',
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary'
      }
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/profile/karyawan/${id}`, // Properly formatted DELETE endpoint
          method: 'DELETE', // HTTP DELETE method
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
          },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Successfully Deleted!',
              text: response.message || 'Department has been deleted.',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(() => {
              // Refresh halaman setelah SweetAlert selesai
              location.reload();
            });

            // Refresh DataTable or the related list
            if (typeof dt_category !== 'undefined') {
              dt_category.draw(); // Redraw the table to reflect changes
            }
          },
          error: function (xhr) {
            console.log('Error:', xhr.responseJSON); // Log error for debugging
            Swal.fire({
              icon: 'error',
              title: 'Error Occurred!',
              text: xhr.responseJSON?.message || 'An error occurred while processing your request.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      }
    });
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
