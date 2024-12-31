/**
 * App eCommerce Category List
 */

'use strict';

// Comment editor

const commentEditor = document.querySelector('.comment-editor');


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

  // Variable declaration for category list table
  var dt_category_list_table = $('.datatables-category-list');

  //select2 for dropdowns in offcanvas

  var select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: $this.data('placeholder') //for dynamic placeholder
      });
    });
  }

  // Customers List Datatable

  if (dt_category_list_table.length) {
    var dt_category = dt_category_list_table.DataTable({
      ajax: {
        url: baseUrl + 'table/jabatan'
      },
        columns: [
            // columns according to JSON
            { data: '' },
            { data: 'id' },
            { data: 'name_jabatan' },
            { data: 'department'},
            { data: 'Total_Pegawai' },
            { data: '' }
        ],
        columnDefs: [
            {
                // For Responsive
                className: 'control',
                searchable: false,
                orderable: false,
                responsivePriority: 1,
                targets: 0,
                render: function (data, type, full, meta) {
                    return '';
                }
            },
            {
                // For Checkboxes
                targets: 1,
                orderable: false,
                searchable: false,
                responsivePriority: 4,
                checkboxes: true,
                render: function () {
                    return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                },
                checkboxes: {
                    selectAllRender: '<input type="checkbox" class="form-check-input">'
                }
            },
            {
                targets: 2,
                responsivePriority: 2,
                render: function (data, type, full, meta) {
                    var $name = full['name_jabatan'];
                    // Render only the Nama Departement as plain text
                    return '<span class="text-heading text-wrap fw-medium">' + $name + '</span>';
                }
            },
            {
              targets: 3,
              responsivePriority: 3,
              render: function (data, type, full, meta) {
                  var $name = full['name_department'];
                  // Render only the Nama Departement as plain text
                  return '<div class="text-center">' + $name + '</span>';
              }
          },
            {
                // Total products
                targets: 4,
                responsivePriority: 4,
                render: function (data, type, full, meta) {
                    var $total_products = full['total_products'];
                    return '<div class="text-center">' + $total_products + '</div>';
                }
            },
            {
              // Actions
              targets: -1,
              title: 'Actions',
              searchable: false,
              orderable: false,
              render: function (data, type, full, meta) {
                const editUrl = full['id'];
                const deleteId = full['id']; // Retrieve the ID for the delete button

                return (
                  '<div class="d-flex align-items-sm-center justify-content-sm-center">' +
                  `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-url="${editUrl}"><i class="ti ti-edit"></i></button>` +
                  `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${deleteId}"><i class="ti ti-trash"></i></button>` +
                  '</div>'
                );
              }
            }
        ],
        order: [2, 'desc'], // set any columns order asc/desc
        dom:
            '<"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"' +
            '<f>' +
            '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"lB>>' +
            '>t' +
            '<"row mx-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        lengthMenu: [7, 10, 20, 50, 70, 100], // for length of menu
        language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search Category',
            paginate: {
                next: '<i class="ti ti-chevron-right ti-sm"></i>',
                previous: '<i class="ti ti-chevron-left ti-sm"></i>'
            }
        },
        // Button for offcanvas
        buttons: [
            {
                text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Jabatan</span>',
                className: 'add-new btn btn-primary ms-2 waves-effect waves-light',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#addCategoryJabatan'
                }
            }
        ],
        // For responsive popup
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details of ' + data['Nama Departement'];
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
                                '<td> ' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td class="ps-0">' +
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
    $('.dt-action-buttons').addClass('pt-0');
    $('.dataTables_filter').addClass('me-3 mb-sm-6 mb-0 ps-0');
}


  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_filter .form-control').addClass('ms-0');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
    $('.dataTables_length .form-select').addClass('ms-0');
  }, 300);
});

// Event handler for Delete button
$(document).on('click', '.delete-record', function () {
  var id = $(this).data('id'); // Retrieve the department ID from the data-id attribute

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
        url: `/destroy/jabatan/${id}`, // Properly formatted DELETE endpoint
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

// Event handler for Edit button
$(document).on('click', '.edit-record', function () {
  var id = $(this).data('id'); // Retrieve the department ID from the data-id attribute

  // Fetch the data for the department to edit
  $.ajax({
    url: `/edit/jabatan/${id}`, // Endpoint to get data by ID
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.data) {
        // Fill the form with the fetched data
        $('#name_jabatan').val(response.data.name_jabatan); // Fill the input with the jabatan name
        $('#id_department').val(response.data.id_department).trigger('change'); // Fill the dropdown and trigger change for select2

        // Store the category ID to be edited (this will be used when updating the data)
        $('#addCategoryJabatanForm').data('id', id); // Store ID in the form

        // Update modal title for editing
        $('#addCategoryJabatan .modal-title').text('Edit Category Jabatan');
        $('#addCategoryJabatan p').text('Edit the form below to update the category.');

        // Show the modal for editing
        const modalElement = document.getElementById('addCategoryJabatan');
        const modalInstance = new bootstrap.Modal(modalElement); // Create instance of modal
        modalInstance.show();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Data Not Found!',
          text: 'No data available for the selected department.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    },
    error: function (xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Error Occurred!',
        text: 'Failed to load department data.',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }
  });
});

// Submit form (update the department)
$('#addCategoryDepartmentForm').on('submit', function(e) {
  e.preventDefault(); // Prevent the form from submitting the traditional way

  var id = $(this).data('categoryId');  // Get the stored category ID
  var name = $('#name_department').val(); // Get the updated department name

  // Send the updated data to the server using an AJAX PUT request
  $.ajax({
    url: '/category/department/' + id,  // Endpoint for updating the department
    method: 'PUT',  // Use PUT for update
    data: {
      name_department: name
    },
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF token for security
    },
    success: function(response) {
      Swal.fire({
        icon: 'success',
        title: 'Successfully Updated!',
        text: response.message || 'Department has been updated.',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });

      // Close the modal after successful update
      const modalElement = document.getElementById('addCategoryDepartment');
      const modalInstance = bootstrap.Modal.getInstance(modalElement);
      modalInstance.hide();

      // Refresh DataTable or the related list to show updated data
      if (typeof dt_category !== 'undefined') {
        dt_category.draw(); // Redraw the table to reflect changes
      }
    },
    error: function(xhr) {
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
});

// Tambahkan event listener untuk form submission
$('#addCategoryJabatanForm').submit(function (e) {
  e.preventDefault(); // Mencegah reload halaman secara default

  // Ambil nilai input dari form dengan ID yang benar
  const nameJabatan = $('#name_jabatan').val().trim(); // Input untuk nama jabatan
  const idDepartment = $('#id_department').val(); // Input untuk ID department

  // Validasi input
  if (!nameJabatan || !idDepartment) {
    Swal.fire({
      icon: 'warning',
      title: 'Warning',
      text: 'Please fill in all required fields.',
      customClass: {
        confirmButton: 'btn btn-warning'
      }
    });
    return; // Hentikan eksekusi jika validasi gagal
  }

  // Siapkan data untuk dikirim
  const formData = {
    name_jabatan: nameJabatan,
    id_department: idDepartment,
  };

  // Kirim data ke server menggunakan AJAX
  $.ajax({
    url: '/category/jabatan/store', // Endpoint API yang sesuai dengan route Laravel
    method: 'POST', // Metode HTTP POST
    data: JSON.stringify(formData), // Data dikirim dalam format JSON
    cache: false, // Tidak menggunakan cache
    contentType: 'application/json', // Header Content-Type JSON
    processData: false, // Tidak memproses data (karena sudah dalam format JSON)
    dataType: 'json', // Respons dari server diharapkan dalam format JSON
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Tambahkan CSRF token untuk keamanan
    },
    success: function (response) {
      // Refresh tabel atau elemen terkait jika berhasil
      if (typeof dt_category !== 'undefined') {
        dt_category.draw(); // Refresh DataTable (jika ada)
      }

      // Tutup modal
      const modalElement = document.getElementById('addCategoryJabatan');
      const modalInstance = bootstrap.Modal.getInstance(modalElement);
      if (modalInstance) {
        modalInstance.hide(); // Sembunyikan modal
      }

      // SweetAlert untuk notifikasi sukses
      Swal.fire({
        icon: 'success',
        title: 'Successfully Added!',
        text: response.message || 'New jabatan has been added successfully.',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(() => {
        // Refresh halaman setelah SweetAlert selesai
        location.reload();
      });
    },

    error: function (xhr) {
      // Debugging log jika terjadi error
      console.error('Error:', xhr.responseJSON);

      // SweetAlert untuk notifikasi error
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
});