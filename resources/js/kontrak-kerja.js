/**
 * kontrak-kerja List
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
        url: baseUrl + 'table/kontrak-kerja'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'nama_lengkap' },
        { data: 'start_date' },
        { data: 'end_date' },
        { data: 'total_days' },
        { data: 'duration' },
        { data: 'status' },
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
          // Nama Karyawan
          targets: 2,
          render: function (data, type, full, meta) {
            var namaKaryawan = full['nama_lengkap'];
            return '<span class="text-heading text-wrap fw-medium">' + namaKaryawan + '</span>';
          }
        },
        {
          // Start Date
          targets: 3,
          render: function (data, type, full, meta) {
            var startDate = full['start_date'];
            return '<span class="text-heading text-wrap fw-medium">' + startDate + '</span>';
          }
        },
        {
          // End Date
          targets: 4,
          render: function (data, type, full, meta) {
            var endDate = full['end_date'];
            return '<span class="text-heading text-wrap fw-medium">' + endDate + '</span>';
          }
        },
        {
          // Start Date
          targets: 5,
          render: function (data, type, full, meta) {
            var totalKontrak = full['duration'];
            return '<span class="text-heading text-wrap fw-medium">' + totalKontrak + '</span>';
          }
        },
        {
          // End Date
          targets: 6,
          render: function (data, type, full, meta) {
            var sisaKontrak = full['remaining_duration'];
            return '<span class="text-heading text-wrap fw-medium">' + sisaKontrak + '</span>';
          }
        },
        {
          // Status
          targets: 7,
          render: function (data, type, full, meta) {
            var status = full['status'];
            var badgeClass;
            switch (status) {
              case 'Baru':
                badgeClass = 'bg-label-success';
                break;
              case 'Lanjut':
                badgeClass = 'bg-label-warning';
                break;
            }
            return (
              '<div class="d-flex justify-content-center align-items-center">' +
              '<span class="badge ' +
              badgeClass +
              ' text-capitalize">' +
              status +
              '</span>' +
              '</div>'
            );
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
              '<a href="javascript:;" class="dropdown-item view-record" data-id="' +
              full['id'] +
              '">View</a>' +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'asc']],
      dom:
        '<"row"' +
        '<"col-md-2"<"ms-n2"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0"fB>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [7, 10, 20, 50, 70, 100], //for length of menu
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search User',
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
          className: 'btn btn-label-secondary dropdown-toggle mx-4 waves-effect waves-light',
          text: '<i class="ti ti-upload me-2 ti-xs"></i>Export',
          buttons: [
            {
              extend: 'print',
              title: '<div style="text-align: center;">Data Kontrak Kerja</div>',
              text: '<i class="ti ti-printer me-2"></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6],
                // Prevent avatar from being printed
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                // Customize print view for dark mode
                $(win.document.body)
                  .css('color', config.colors.headingColor)
                  .css('border-color', config.colors.borderColor)
                  .css('background-color', config.colors.body);
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
              title: 'Data Kontrak',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6],
                // Prevent avatar from being displayed
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              title: 'Data Kontrak Kerja',
              text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6],
                // Prevent avatar from being displayed
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }
                    });
                    return result;
                  }
                }
              }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New Kontrak</span>',
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
          url: `/delete/kontrak-kerja/${id}`, // Properly formatted DELETE endpoint
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
    $('#offcanvasAddUserLabel').html('Edit Kontrak Kerja');

    // Send GET request to fetch data
    $.get(`/edit/kontrak-kerja/${id}`, function (response) {
      if (response.data) {
        const data = response.data;

        // Populate the form with the data
        $('#id').val(data.id);
        $('#id_karyawan').val(data.id_karyawan); // Assuming dropdown or input
        $('#start_date').val(data.star_date);
        $('#end_date').val(data.and_date);
        $('#status').val(data.status); // Assuming dropdown or input

        // Open the modal or show the edit form
        $('#editModal').modal('show'); // Assuming you're using a Bootstrap modal
      }
    });
  });

  // changing the title
  $('.add-new').on('click', function () {
    $('#user_id').val(''); //reseting input field
    $('#offcanvasAddUserLabel').html('Add Kontrak Kerja');
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
      start_date: {
        validators: {
          notEmpty: {
            message: 'Silakan masukkan tanggal mulai'
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Format tanggal tidak valid'
          }
        }
      },
      end_date: {
        validators: {
          notEmpty: {
            message: 'Silakan masukkan tanggal selesai'
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Format tanggal tidak valid'
          },
          callback: {
            message: 'Tanggal selesai harus setelah tanggal mulai',
            callback: function (input) {
              const startDate = document.getElementById('kontrak-kerja-start-date').value;
              return !startDate || new Date(input.value) > new Date(startDate);
            }
          }
        }
      },
      status: {
        validators: {
          notEmpty: {
            message: 'Silakan pilih status'
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
    // Ambil ID kontrak kerja (jika ada)
    const kontrakKerjaId = $('#id').val();
    const url = kontrakKerjaId
      ? `${baseUrl}update/kontrak-kerja/${kontrakKerjaId}` // Endpoint untuk update
      : `${baseUrl}kontrak-kerja/store`; // Endpoint untuk create
    const method = kontrakKerjaId ? 'PUT' : 'POST'; // Metode HTTP (PUT untuk update, POST untuk create)

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
          title: kontrakKerjaId ? 'Successfully Updated!' : 'Successfully Added!',
          text:
            response.message ||
            (kontrakKerjaId
              ? 'Kontrak Kerja has been updated successfully.'
              : 'New Kontrak Kerja has been added successfully.'),
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {
        offCanvasForm.offcanvas('hide');
        Swal.fire({
          title: 'Gagal Menyimpan Data!',
          text: 'Silakan coba lagi.',
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
