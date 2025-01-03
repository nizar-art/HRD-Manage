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

// Form Wizard (Modern Stepper) Setup
$(function () {
  const wizardModern = document.querySelector('.wizard-modern-example');

  if (wizardModern) {
    const modernStepper = new Stepper(wizardModern, {
      linear: false
    });
  }
  const stepper = new Stepper(document.querySelector('.bs-stepper'));

  const stepperLinks = document.querySelectorAll('.bs-stepper-header .step-trigger');

  // Nonaktifkan navigasi stepper kecuali langkah pertama selesai
  function disableStepperNavigation(disable = true) {
    stepperLinks.forEach(link => {
      if (disable) {
        link.classList.add('disabled');
        link.style.pointerEvents = 'none';
      } else {
        link.classList.remove('disabled');
        link.style.pointerEvents = 'auto';
      }
    });
  }

  // Blokir stepper klik pada langkah pertama
  disableStepperNavigation(true);
  // Validasi sebelum pindah ke langkah berikutnya
  // Tombol Next dari Riwayat Pendidikan
  document.querySelector('#nextToFamily').addEventListener('click', function () {
    const submittedItems = document.querySelectorAll('#educationContainer [data-submitted="true"]');

    if (submittedItems.length > 0) {
      stepper.next();
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Form Belum Disubmit',
        text: 'Harap tambahkan dan submit setidaknya satu item pendidikan sebelum melanjutkan.',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }
  });
  // Tombol Selesai
  document.querySelector('.btn-selesai').addEventListener('click', function () {
    const submittedItems = document.querySelectorAll('#familyContainer [data-submitted="true"]');

    if (submittedItems.length > 0) {
      window.location.href = '/view/karyawan';
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Form Belum Disubmit',
        text: 'Harap tambahkan dan submit setidaknya satu data keluarga sebelum menyelesaikan proses.',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }
  });

  document.getElementById('addEducation').addEventListener('click', function (e) {
    e.preventDefault();

    const container = document.getElementById('educationContainer');
    const template = document.getElementById('educationItemTemplate');

    if (!template) {
      console.error('Education template not found');
      return;
    }

    const clone = template.cloneNode(true);
    clone.style.display = '';
    clone.removeAttribute('id');

    // Inisialisasi Select2 untuk elemen yang baru ditambahkan
    const educationSelect = clone.querySelector('.education');

    // Inisialisasi ulang Select2 hanya pada elemen baru
    if (!$(educationSelect).data('select2')) {
      $(educationSelect).select2({
        placeholder: 'Pilih Jenjang',
        allowClear: true
      });
    }

    // Tambahkan event listener untuk tombol delete
    const deleteButton = clone.querySelector('.deleteBtn');
    deleteButton.addEventListener('click', function () {
      clone.remove();
    });

    // Tambahkan event listener untuk tombol save (Khusus item ini saja)
    const saveButton = clone.querySelector('.saveBtn');
    saveButton.addEventListener('click', function () {
      // Ambil nilai dari input dalam elemen ini
      // Pastikan id_karyawan di dalam elemen clone mendapatkan nilai yang benar
      const karyawanId = clone.querySelector('#id_karyawan').value; // Ambil id_karyawan dari elemen di halaman
      const jenjang = clone.querySelector('#jenjang').value;
      const namaSekolah = clone.querySelector('#nama_sekolah').value;
      const jurusan = clone.querySelector('#jurusan').value || '-';
      const tahunLulus = clone.querySelector('#tahun_lulus').value;

      // Validasi input
      if (!jenjang || !namaSekolah || !tahunLulus) {
        Swal.fire({
          icon: 'error',
          title: 'Input Tidak Lengkap',
          text: 'Harap lengkapi semua field sebelum menyimpan.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
        return;
      }

      const formData = {
        id_karyawan: karyawanId,
        jenjang: jenjang,
        nama_sekolah: namaSekolah,
        jurusan: jurusan,
        tahun_lulus: tahunLulus
      };

      // Kirim data ke server menggunakan AJAX
      $.ajax({
        url: '/form/karyawan/storeRiwayatPendidikan', // Endpoint Laravel
        method: 'POST',
        data: JSON.stringify(formData),
        processData: false,
        contentType: 'application/json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token Laravel
        },
        success: function (response) {
          // Tandai item ini sebagai sudah disimpan
          clone.setAttribute('data-submitted', 'true');

          Swal.fire({
            icon: 'success',
            title: 'Successfully Added!',
            text: 'Data pendidikan berhasil disimpan.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(result => {
            if (result.isConfirmed) {
              // Jika berhasil, ubah tombol Save menjadi Edit
              saveButton.textContent = 'Edit';
              saveButton.classList.replace('btn-primary', 'btn-warning');

              // Tambahkan fungsi untuk edit (toggle edit mode)
              saveButton.addEventListener('click', function () {
                const fields = clone.querySelectorAll('input, select');
                fields.forEach(field => (field.disabled = !field.disabled));

                // Toggle button text
                if (fields[0].disabled) {
                  saveButton.textContent = 'Edit';
                  saveButton.classList.replace('btn-warning', 'btn-primary');
                } else {
                  saveButton.textContent = 'Save';
                  saveButton.classList.replace('btn-primary', 'btn-warning');
                }
              });

              // Disable input setelah save
              const fields = clone.querySelectorAll('input, select');
              fields.forEach(field => (field.disabled = true));
            }
          });
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Failed to Save!',
            text: 'Terjadi kesalahan saat menyimpan data.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          console.log(xhr.responseText); // Log error dari server
        }
      });
    });

    // Tambahkan item ke dalam container
    container.appendChild(clone);
  });

  document.getElementById('addFamily').addEventListener('click', function (e) {
    e.preventDefault();

    const container = document.getElementById('familyContainer');
    const template = document.getElementById('familyItemTemplate');

    if (!template) {
      console.error('Family template not found');
      return;
    }

    const clone = template.cloneNode(true);
    clone.style.display = '';
    clone.removeAttribute('id');

    // Event listener untuk tombol Delete
    const deleteButton = clone.querySelector('.deleteBtn');
    deleteButton.addEventListener('click', function () {
      clone.remove();
    });

    // Event listener untuk tombol Save
    const saveButton = clone.querySelector('.saveBtn');
    saveButton.addEventListener('click', function () {
      const karyawanId = clone.querySelector('#id_karyawan').value;
      const status = clone.querySelector('#status').value;
      const namaLengkap = clone.querySelector('#nama_lengkap').value;
      const nomerHp = clone.querySelector('#nomer_hp').value || '-';

      // Validasi input
      if (!status || !namaLengkap) {
        Swal.fire({
          icon: 'error',
          title: 'Input Tidak Lengkap',
          text: 'Harap lengkapi semua field sebelum menyimpan.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
        return;
      }

      const formData = {
        id_karyawan: karyawanId,
        status: status,
        nama_lengkap: namaLengkap,
        nomer_hp: nomerHp
      };

      // Kirim data ke server menggunakan AJAX
      $.ajax({
        url: '/form/karyawan/storeKeluarga', // Endpoint Laravel
        method: 'POST',
        data: JSON.stringify(formData),
        cache: false,
        contentType: 'application/json',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token Laravel
        },
        success: function (response) {
          clone.setAttribute('data-submitted', 'true'); // Tandai item ini sebagai submitted

          Swal.fire({
            icon: 'success',
            title: 'Successfully Added!',
            text: 'Data keluarga berhasil disimpan.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(result => {
            if (result.isConfirmed) {
              saveButton.textContent = 'Edit';
              saveButton.classList.replace('btn-primary', 'btn-warning');

              saveButton.addEventListener('click', function () {
                const fields = clone.querySelectorAll('input, select');
                fields.forEach(field => (field.disabled = !field.disabled));

                if (fields[0].disabled) {
                  saveButton.textContent = 'Edit';
                  saveButton.classList.replace('btn-warning', 'btn-primary');
                } else {
                  saveButton.textContent = 'Save';
                  saveButton.classList.replace('btn-primary', 'btn-warning');
                }
              });

              const fields = clone.querySelectorAll('input, select');
              fields.forEach(field => (field.disabled = true));
            }
          });
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Failed to Save!',
            text: 'Terjadi kesalahan saat menyimpan data.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    container.appendChild(clone);
  });
});
