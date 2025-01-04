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

            return (
              '<div class="d-flex align-items-center">' +
              '<a href="javascript:;" data-bs-toggle="tooltip" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" data-bs-placement="top" title="Delete">' +
              '<i class="ti ti-trash mx-2 ti-md"></i>' +
              '</a>' +
              '<a href="' +
              baseUrl +
              'detail/karyawan/' +
              id + // Ganti {id} dengan nilai ID dari data baris
              '" data-bs-toggle="tooltip" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" data-bs-placement="top" title="Preview Invoice">' +
              '<i class="ti ti-eye mx-2 ti-md"></i>' +
              '</a>' +
              '<div class="dropdown">' +
              '<a href="javascript:;" class="btn dropdown-toggle hide-arrow btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill p-0" data-bs-toggle="dropdown">' +
              '<i class="ti ti-dots-vertical ti-md"></i>' +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-end">' +
                  '<button id="btnEditPribadi" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditUser" class="dropdown-item">Edit Pribadi</button>' +
                  '<button id="btnEditPendidikan" class="dropdown-item">Edit Pendidikan</button>' +
                  '<button id="btnEditKeluarga" class="dropdown-item">Edit Keluarga</button>' +
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
              extend: 'csv',
              text: '<i class="ti ti-file me-2" ></i>Csv',
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
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2"></i>Copy',
              className: 'dropdown-item',
              action: function (e, dt, node, config) {
                // Link to copy
                var linkToCopy = 'http://127.0.0.1:8000/auth/login-basic';

                // Create a temporary input element to copy the link
                var tempInput = document.createElement('input');
                tempInput.value = linkToCopy;
                document.body.appendChild(tempInput);

                // Select and copy the text
                tempInput.select();
                tempInput.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');

                // Remove the temporary input element
                document.body.removeChild(tempInput);

                // Optional: Provide feedback to the user
                alert('Link copied: ' + linkToCopy);
              }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-scopm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add Karyawan</span>',
          className: 'add-new btn btn-primary ms-2 ms-sm-0 waves-effect waves-light',
          action: function () {
            window.location.href = ProfileKaryawanAdd;
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

  $(document).on('click', '.edit-record', function () {
    const id = $(this).data('id'); // Ambil ID dari tombol
    var dtrModal = $('.dtr-bs-modal.show');

    // Sembunyikan modal responsif (jika ada)
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // Ubah judul offcanvas
    $('#offcanvasEditUserLabel').html('Edit Data Pribadi');

    // Panggil data berdasarkan ID
    // Send GET request to fetch data
    $.get(`/profile/karyawan/editKaryawan/${id}`, function (response) {
      if (response.data) {
        const data = response.data;

        // Populate the form with the data
        $('#id').val(data.id);
        $('#nama_lengkap').val(data.nama_lengkap);
        $('#jenis_kelamin').val(data.jenis_kelamin).trigger('change'); // Assuming dropdown
        $('#tempat_lahir').val(data.tempat_lahir);
        $('#tanggal_lahir').val(data.tanggal_lahir);
        $('#email').val(data.email);
        $('#agama').val(data.agama).trigger('change'); // Assuming dropdown
        $('#nomor_nik_ktp').val(data.nomor_nik_ktp);
        $('#nomor_npwp').val(data.nomor_npwp);
        $('#nomor_rekening').val(data.nomor_rekening);
        $('#nomor_hp').val(data.nomor_hp);
        $('#golongan_darah').val(data.golongan_darah).trigger('change'); // Assuming dropdown
        $('#ibu_kandung').val(data.ibu_kandung);
        $('#status_pernikahan').val(data.status_pernikahan).trigger('change'); // Assuming dropdown

        // Populate Alamat KTP
        if (data.alamat_ktp) {
          $('#jalan_ktp').val(data.alamat_ktp.jalan || '');
          $('#rt_ktp').val(data.alamat_ktp.rt || '');
          $('#rw_ktp').val(data.alamat_ktp.rw || '');
          $('#desa_ktp').val(data.alamat_ktp.desa || '');
          $('#kecamatan_ktp').val(data.alamat_ktp.kecamatan || '');
          $('#kabupaten_ktp').val(data.alamat_ktp.kabupaten || '');
          $('#provinsi_ktp')
            .val(data.alamat_ktp.provinsi || '')
            .trigger('change');
        }

        // Populate Alamat Domisili
        if (data.alamat_domisili) {
          $('#same-address').prop('checked', false); // Uncheck "Alamat Sama"
          $('#jalan_domisili').val(data.alamat_domisili.jalan || '');
          $('#rt_domisili').val(data.alamat_domisili.rt || '');
          $('#rw_domisili').val(data.alamat_domisili.rw || '');
          $('#desa_domisili').val(data.alamat_domisili.desa || '');
          $('#kecamatan_domisili').val(data.alamat_domisili.kecamatan || '');
          $('#kabupaten_domisili').val(data.alamat_domisili.kabupaten || '');
          $('#provinsi_domisili')
            .val(data.alamat_domisili.provinsi || '')
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

        // Open the modal or offcanvas
        $('#offcanvasEditUser').offcanvas('show'); // Assuming you're using a Bootstrap offcanvas
      }
    }).fail(function () {
      alert('Gagal mengambil data. Silakan coba lagi.');
    });
  });

  // Delete Record
  $('.datatables-products tbody').on('click', '.delete-record', function () {
    dt_products.row($(this).parents('tr')).remove().draw();
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
