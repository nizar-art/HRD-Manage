<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Employee Registation</h4>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-database-add"></i> ADD
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="employee-form" method="post">

                                <div class="row">
                                    <div class="col-lg">
                                        <label>Name</label>
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                    <div class="col-lg">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <label>Address</label>
                                        <input type="text" name="address" id="address" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <label>Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="employee-form">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-form" method="post">
                                <input type="hidden" id="edit-id" name="id">
                                <div class="row">
                                    <div class="col-lg">
                                        <label>Name</label>
                                        <input type="text" id="edit-name" name="name" class="form-control">
                                    </div>
                                    <div class="col-lg">
                                        <label>Email</label>
                                        <input type="email" id="edit-email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <label>Address</label>
                                        <input type="text" id="edit-address" name="address" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <label>Phone</label>
                                        <input type="text" id="edit-phone" name="phone" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="edit-form">Edit</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            var table = $('#myTable').DataTable({
                "ajax": {
                    "url": "{{ route('getall') }}",
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
                        if (response.status === 200) {
                            return response.employees;
                        } else {
                            return [];
                        }
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "address" },
                    { "data": "phone" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="'+data.id+'" data-name="'+data.name+'" data-email="'+data.email+'" data-address="'+data.address+'" data-phone="'+data.phone+'">Edit</a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="'+data.id+'">Delete</a>';


                        }
                    }
                ]
            });

            $('#myTable tbody').on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var address = $(this).data('address');
                var phone = $(this).data('phone');

                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-email').val(email);
                $('#edit-address').val(address);
                $('#edit-phone').val(phone);
                $('#editModal').modal('show');
            });


            $('#employee-form').submit(function (e) {
                e.preventDefault();
                const employeedata = new FormData(this);

                $.ajax({
                    url: '{{ route('store') }}',
                    method: 'post',
                    data: employeedata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            alert("Saved successfully");
                            $('#employee-form')[0].reset();
                            $('#exampleModal').modal('hide');
                            $('#myTable').DataTable().ajax.reload();
                        }
                    }
                });
            });

        });


        $('#edit-form').submit(function (e) {
                e.preventDefault();
                const employeedata = new FormData(this);

                $.ajax({
                    url: '{{ route('update') }}',
                    method: 'POST',
                    data: employeedata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            alert(response.message);
                            $('#edit-form')[0].reset();
                            $('#editModal').modal('hide');
                            $('#myTable').DataTable().ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');

                if (confirm('Are you sure you want to delete this employee?')) {
                    $.ajax({
                        url: '{{ route('delete') }}',
                        type: 'DELETE',
                        data: {id: id},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response); // Debugging: log the response
                            if (response.status === 200) {
                                alert(response.message); // Show success message
                                $('#myTable').DataTable().ajax.reload(); // Reload the table data
                            } else {
                                alert(response.message); // Show error message
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr); // Debugging: log the error
                            alert('Error: ' + error); // Show generic error message
                        }
                    });
                }
            });




            /**
 * App eCommerce Add Product Script
 */
'use strict';

import { file } from 'jszip';
import { baseApiUrl } from 'mapbox-gl';

(function () {
  // Initialize Quill editor for product description
  const commentEditor = document.querySelector('.comment-editor');
  if (commentEditor) {
    const quill = new Quill(commentEditor, {
      modules: {
        toolbar: '.comment-toolbar'
      },
      placeholder: 'Product Description',
      theme: 'snow'
    });

    // Sync Quill content with hidden input
    quill.on('text-change', function () {
      const description = quill.root.innerHTML.trim();
      const descriptionInput = document.querySelector('#description-input');
      if (descriptionInput) {
        descriptionInput.value = description !== '<p><br></p>' ? description : '';
      }
    });
  }

  const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

  // Initialize Dropzone for product image upload
  // Basic Dropzone

  let uploadedFile = null; // Declare the variable

  const myDropzone = new Dropzone('#dropzone-basic', {
    previewTemplate: previewTemplate,
    maxFilesize: 5, // Max file size in MB
    acceptedFiles: '.jpg,.jpeg,.png',
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: 'Drag & drop an image or click to browse',
    init: function () {
      this.on('addedfile', function (file) {
        uploadedFile = file; // Save file reference
        console.log('Image ready for upload:', file.name);
      });

      this.on('removedfile', function () {
        uploadedFile = null; // Clear file reference
        console.log('Image removed');
      });
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    const dropzoneElement = document.querySelector('#dropzone-basic');
    const hiddenImageInput = document.querySelector('#hidden-image-name');

    if (dropzoneElement && hiddenImageInput) {
      const existingImage = hiddenImageInput.value; // Nama file gambar sebelumnya
      const dropzone = Dropzone.forElement(dropzoneElement);

      if (existingImage) {
        // URL gambar lama
        const imageUrl = /assets/img/products/${existingImage};

        // Simulasi file pratinjau
        const mockFile = { name: existingImage, size: 12345, accepted: true };
        dropzone.emit('addedfile', mockFile);
        dropzone.emit('thumbnail', mockFile, imageUrl);
        dropzone.emit('complete', mockFile);
        dropzone.files.push(mockFile);
      }
      return () => uploadedFile || hiddenImageInput?.value || null;
    }
  });

  // Select2 Initialization
  var select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: $this.data('placeholder') // for dynamic placeholder
      });
    });
  }
  document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi Quill
    const quillEditor = new Quill('#ecommerce-category-description', {
      modules: {
        toolbar: '.comment-toolbar'
      },
      placeholder: 'Product Description',
      theme: 'snow'
    });

    // Ambil nilai dari input hidden
    const descriptionInput = document.querySelector('#description-input');
    if (descriptionInput && descriptionInput.value) {
      quillEditor.root.innerHTML = descriptionInput.value; // Set content ke editor
    }

    // Sinkronkan perubahan di Quill ke input hidden
    quillEditor.on('text-change', function () {
      const description = quillEditor.root.innerHTML.trim();
      descriptionInput.value = description !== '<p><br></p>' ? description : '';
    });
  });

  // Handle Publish Product button click

    const publishButton = document.querySelector('.publish')
    if (publishButton) {
      publishButton.addEventListener('click', function (e) {
        e.preventDefault();

        // Collect form data
        const productName = document.querySelector('#ecommerce-product-name').value;
        const category = document.querySelector('#category-org').value;
        const project = document.querySelector('#project').value;
        const status = document.querySelector('#status-org').value;
        const description = document.querySelector('#description-input').value;
        const image = uploadedFile || document.querySelector('#hidden-image-name')?.value;
        const size = document.querySelector('#size').value;
        const length = document.querySelector('#length').value;
        const thickness = document.querySelector('#thickness').value;

        if (!uploadedFile) {
          Swal.fire({
            icon: 'warning',
            title: 'No Image',
            text: 'Please upload a product image!',
            timer: 3000,
            showConfirmButton: false
          });
          return;
        }

        if (!image) {
          Swal.fire({
            icon: 'warning',
            title: 'No Image',
            text: 'Please upload a product image or ensure the previous image is available!',
            timer: 3000,
            showConfirmButton: false,
          });
          return;
        }

        // Validate required fields
        if (!productName || !category || !status || !project) {
          Swal.fire({
            icon: 'warning',
            title: 'Incomplete Fields',
            text: 'Please fill in all required fields!',
            timer: 3000,
            showConfirmButton: false
          });
          return;
        }
        const isEditMode = window.location.pathname.includes('/edit');

        // SweetAlert2 Confirmation
        Swal.fire({
          title: isEditMode ? 'Updating Product...' : 'Publishing Product...',
          text: 'Please wait while we save your product.',
          icon: 'info',
          timer: 3000,
          showConfirmButton: false,
          didClose: () => {
            // Prepare FormData
            const formData = new FormData();
            formData.append('product_name', productName);
            formData.append('category_id', category);
            formData.append('description', description);
            formData.append('project', project);
            formData.append('status', status);

            if (image instanceof File) {
              formData.append('image', image);
            } else {
              formData.append('existing_image', image);
            }

            formData.append('size', size);
            formData.append('length', length);
            formData.append('thickness', thickness);

            // Add _method if editing
            // if (isEditMode) {
            //   formData.append('_method', 'PUT');
            // }

            // Set URL based on mode
            const slug = window.location.pathname.split('/').slice(-2, -1)[0];
            const url = isEditMode ? /product/${slug}/update : '/product/store';

            // Send AJAX request
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
              url: url,
              type: 'POST', // Always POST, Laravel will interpret _method
              data: formData,
              // enctype:'multipart/form-data',
              processData: false, // Prevent jQuery from processing the FormData
              contentType: false, // Let the browser set the Content-Type
              success: data => {
                if (data.success) {
                  Swal.fire({
                    icon: 'success',
                    title: isEditMode ? 'Product Updated' : 'Product Published!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false
                  }).then(() => {
                    // Redirect to product list
                    window.location.href = data.redirect_url;
                  });
                }
              },
              error: (jqXHR, textStatus, errorThrown) => {
                console.error('Error:', textStatus, errorThrown);
                Swal.fire({
                  icon: 'error',
                  title: isEditMode ? 'Failed to Update' : 'Failed to Publish',
                  text: 'An error occurred. Please try again.',
                  timer: 3000,
                  showConfirmButton: false
                });
              }
            });
          }
        });
      });
    }

})();


    </script>

</body>
</html>
