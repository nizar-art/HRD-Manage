/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#offcanvasAddUser');

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'table/informasi-kepegawaian'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'nama_lengkap' },
        { data: 'perusahaan' },
        { data: 'nomer kerja' },
        { data: 'tanggal_masuk' },
        { data: 'nama_jabatan' },
        { data: 'nama_department' },
        { data: 'lokasi_kerja' },
        { data: '' }
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
          // perusahaan
          targets: 3,
          render: function (data, type, full, meta) {
            var jenisKelamin = full['perusahaan'];
            var badgeClass;
            switch (jenisKelamin) {
              case 'LKI':
                badgeClass = 'bg-label-primary';
                break;
              case 'Green Cold':
                badgeClass = 'bg-label-success';
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
          // Jenis Kelamin
          targets: 4,
          render: function (data, type, full, meta) {
            var nomerKerja = full['nomer_kerja'];
            return '<span class="text-heading text-wrap fw-medium">' + nomerKerja + '</span>';
          }
        },
        {
          // Tempat Lahir
          targets: 5,
          render: function (data, type, full, meta) {
            var tanggalMasuk = full['tanggal_masuk'];
            return '<span class="text-heading text-wrap fw-medium">' + tanggalMasuk + '</span>';
          }
        },
        {
          // Tanggal Lahir
          targets: 6,
          render: function (data, type, full, meta) {
            var jabatan = full['name_jabatan'];
            return '<span class="text-heading text-wrap fw-medium">' + jabatan + '</span>';
          }
        },
        {
          // Alamat Email
          targets: 7,
          render: function (data, type, full, meta) {
            var departemen = full['name_department'];
            return '<span class="text-heading text-wrap fw-medium">' + departemen + '</span>';
          }
        },
        {
          // Alamat Email
          targets: 8,
          render: function (data, type, full, meta) {
            var lokasiKerja = full['lokasi_kerja'];
            return '<span class="text-heading text-wrap fw-medium">' + lokasiKerja + '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            const editId = full['id'];
            const deleteId = full['id'];
            return (
              '<div class="d-flex align-items-center gap-50">' +
              `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${editId}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><i class="ti ti-edit"></i></button>` +
              `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${deleteId}"><i class="ti ti-trash"></i></button>` +
              '<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              '<a href="' +
              userView +
              '" class="dropdown-item">View</a>' +
              '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
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
        info: '',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-4 waves-effect waves-light',
          text: '<i class="ti ti-upload me-2 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              title: '<div style="text-align: center;">Informasi Kepegawaian</div>',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7], // Sesuai dengan kolom yang tersedia
                format: {
                  body: function (inner, colIndex) {
                    return $(inner).text();
                  }
                }
              }
            },
            {
              extend: 'excel',
              title: 'Informasi Kepegawaian',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7], // Sesuai dengan kolom yang tersedia
                format: {
                  body: function (inner, colIndex) {
                    return $(inner).text();
                  }
                }
              }
            },
            {
              extend: 'pdf',
              title: 'Informasi Kepegawaian',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7], // Sesuai dengan kolom yang tersedia
                format: {
                  body: function (inner, colIndex) {
                    return $(inner).text();
                  }
                }
              }
            },
            {
              extend: 'copy',
              title: 'Informasi Kepegawaian',
              text: '<i class="ti ti-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7], // Sesuai dengan kolom yang tersedia
                format: {
                  body: function (inner, colIndex) {
                    return $(inner).text();
                  }
                }
              }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add Kepegawaian</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
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
      }
    });
  }

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
          url: `/delete/kepegawaian/${id}`, // Properly formatted DELETE endpoint
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

  // edit record
  $(document).on('click', '.edit-record', function () {
    var id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // changing the title of offcanvas
    $('#offcanvasAddUserLabel').html('Edit Kepegawaian');

    // Send GET request to fetch data
    $.get(`/edit/kepegawaian/${id}`, function (response) {
      if (response.data) {
        const data = response.data;

        // Populate the form with the data
        $('#id').val(data.id);
        $('#id_karyawan').val(data.id_karyawan); // Assuming dropdown or input
        $('#perusahaan').val(data.perusahaan);
        $('#nomer_kerja').val(data.nomer_kerja);
        $('#tanggal_masuk').val(data.tanggal_masuk);
        $('#id_department').val(data.id_department); // Assuming dropdown or input
        $('#id_jabatan').val(data.id_jabatan); // Assuming dropdown or input
        $('#lokasi_kerja').val(data.lokasi_kerja);

        // Open the modal or show the edit form
        $('#editModal').modal('show'); // Assuming you're using a Bootstrap modal
      }
    });
  });

  // changing the title
  $('.add-new').on('click', function () {
    $('#id').val(''); //reseting input field
    $('#offcanvasAddUserLabel').html('Add Informasi Kepegawaian');
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

  // validating form and updating user's data
  const addNewUserForm = document.getElementById('addNewUserForm');

  // user form validation
  const fv = FormValidation.formValidation(document.getElementById('addNewUserForm'), {
    fields: {
      id_karyawan: {
        validators: {
          notEmpty: {
            message: 'Silakan pilih karyawan'
          }
        }
      },
      perusahaan: {
        validators: {
          notEmpty: {
            message: 'Silakan pilih perusahaan'
          }
        }
      },
      nomer_kerja: {
        validators: {
          notEmpty: {
            message: 'Silakan masukkan nik kerja'
          }
        }
      },
      tanggal_masuk: {
        validators: {
          notEmpty: {
            message: 'Silakan masukkan tanggal masuk'
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Format tanggal tidak valid'
          }
        }
      },
      id_jabatan: {
        validators: {
          notEmpty: {
            message: 'Silakan pilih jabatan'
          }
        }
      },
      id_department: {
        validators: {
          notEmpty: {
            message: 'Silakan pilih departemen'
          }
        }
      },
      lokasi_kerja: {
        validators: {
          notEmpty: {
            message: 'Silakan masukkan lokasi kerja'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: function (field, ele) {
          return '.mb-6';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // Ambil ID kepegawaian (jika ada)
    const kepegawaianId = $('#id').val();
    const url = kepegawaianId
      ? `${baseUrl}update/kepegawaian/${kepegawaianId}` // Endpoint untuk update
      : `${baseUrl}informasi/kepegawaian/store`; // Endpoint untuk create
    const method = kepegawaianId ? 'PUT' : 'POST'; // Metode HTTP (PUT untuk update, POST untuk create)

    $.ajax({
      data: $('#addNewUserForm').serialize(),
      url: url,
      type: method,
      success: function (response) {
        dt_user.draw();
        offCanvasForm.offcanvas('hide');
        // sweetalert
        Swal.fire({
          icon: 'success',
          title: kepegawaianId ? 'Successfully Updated!' : 'Successfully Added!',
          text:
            response.message ||
            (kepegawaianId
              ? 'Informasi Kepegawaian has been updated successfully.'
              : 'New informasi kepegawaian has been added successfully.'),
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {
        offCanvasForm.offcanvas('hide');
        Swal.fire({
          title: 'Gagal Created Data!',
          text: 'Silahkan coba lagi',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // clearing form data when offcanvas hidden
  offCanvasForm.on('hidden.bs.offcanvas', function () {
    fv.resetForm(true);
  });

  const phoneMaskList = document.querySelectorAll('.phone-mask');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'US'
      });
    });
  }
});
