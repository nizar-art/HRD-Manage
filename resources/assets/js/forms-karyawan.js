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

  $('#same-address').on('change', function () {
    if ($(this).is(':checked')) {
      // Salin input jalan, RT, RW dari KTP ke domisili
      $('#jalan_domisili').val($('#jalan_ktp').val());
      $('#rt_domisili').val($('#rt_ktp').val());
      $('#rw_domisili').val($('#rw_ktp').val());

      // Salin provinsi dan trigger onchange untuk memicu AJAX kabupaten
      let provinsiKtp = $('#provinsi_ktp').val();
      $('#provinsi_domisili').val(provinsiKtp).trigger('change');

      // Tunggu sampai data kabupaten selesai dimuat
      $('#provinsi_domisili').on('change', function () {
        let kabupatenKtp = $('#kabupaten_ktp').val();
        $('#kabupaten_domisili').html('<option>Loading...</option>');

        $.ajax({
          url: '/get-kabupaten',
          type: 'GET',
          data: { provinsi_id: provinsiKtp },
          success: function (response) {
            $('#kabupaten_domisili').empty();
            response.forEach(function (kabupaten) {
              $('#kabupaten_domisili').append(
                `<option value="${kabupaten.id}" ${kabupaten.id == kabupatenKtp ? 'selected' : ''}>${kabupaten.name}</option>`
              );
            });

            // Panggil pemuatan kecamatan setelah kabupaten selesai
            $('#kabupaten_domisili').trigger('change');
          }
        });
      });

      // Panggil kecamatan setelah kabupaten terisi
      $('#kabupaten_domisili').on('change', function () {
        let kecamatanKtp = $('#kecamatan_ktp').val();
        let kabupatenDomisili = $(this).val();

        $('#kecamatan_domisili').html('<option>Loading...</option>');

        $.ajax({
          url: '/get-kecamatan',
          type: 'GET',
          data: { kabupaten_id: kabupatenDomisili },
          success: function (response) {
            $('#kecamatan_domisili').empty();
            response.forEach(function (kecamatan) {
              $('#kecamatan_domisili').append(
                `<option value="${kecamatan.id}" ${kecamatan.id == kecamatanKtp ? 'selected' : ''}>${kecamatan.name}</option>`
              );
            });

            // Panggil pemuatan desa setelah kecamatan selesai
            $('#kecamatan_domisili').trigger('change');
          }
        });
      });

      // Panggil desa setelah kecamatan terisi
      $('#kecamatan_domisili').on('change', function () {
        let desaKtp = $('#desa_ktp').val();
        let kecamatanDomisili = $(this).val();

        $('#desa_domisili').html('<option>Loading...</option>');

        $.ajax({
          url: '/get-desa',
          type: 'GET',
          data: { kecamatan_id: kecamatanDomisili },
          success: function (response) {
            $('#desa_domisili').empty();
            response.forEach(function (desa) {
              $('#desa_domisili').append(
                `<option value="${desa.id}" ${desa.id == desaKtp ? 'selected' : ''}>${desa.name}</option>`
              );
            });
          }
        });
      });
    } else {
      // Reset semua input domisili jika checkbox tidak dicentang
      $('#jalan_domisili, #rt_domisili, #rw_domisili').val('');
      $('#provinsi_domisili, #kabupaten_domisili, #kecamatan_domisili, #desa_domisili').val('').trigger('change');
    }
  });

  $(document).ready(function () {
    // Filter Kabupaten berdasarkan Provinsi
    $('#provinsi_ktp').on('change', function () {
      let provinsiId = $(this).val();
      $('#kabupaten_ktp').html('<option selected disabled>Loading...</option>');

      $.ajax({
        url: '/get-kabupaten',
        type: 'GET',
        data: { provinsi_id: provinsiId },
        success: function (response) {
          $('#kabupaten_ktp').empty();
          $('#kabupaten_ktp').append('<option selected disabled>Pilih Kabupaten</option>');
          response.forEach(function (kabupaten) {
            $('#kabupaten_ktp').append(`<option value="${kabupaten.id}">${kabupaten.name}</option>`);
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
  });

  $(document).ready(function () {
    // Filter Kabupaten berdasarkan Provinsi untuk Domisili
    $('#provinsi_domisili').on('change', function () {
      let provinsiId = $(this).val();
      $('#kabupaten_domisili').html('<option selected disabled>Loading...</option>');

      $.ajax({
        url: '/get-kabupaten',
        type: 'GET',
        data: { provinsi_id: provinsiId },
        success: function (response) {
          $('#kabupaten_domisili').empty();
          $('#kabupaten_domisili').append('<option selected disabled>Pilih Kabupaten</option>');
          response.forEach(function (kabupaten) {
            $('#kabupaten_domisili').append(`<option value="${kabupaten.id}">${kabupaten.name}</option>`);
          });
        }
      });
    });

    // Filter Kecamatan berdasarkan Kabupaten untuk Domisili
    $('#kabupaten_domisili').on('change', function () {
      let kabupatenId = $(this).val();
      $('#kecamatan_domisili').html('<option selected disabled>Loading...</option>');

      $.ajax({
        url: '/get-kecamatan',
        type: 'GET',
        data: { kabupaten_id: kabupatenId },
        success: function (response) {
          $('#kecamatan_domisili').empty();
          $('#kecamatan_domisili').append('<option selected disabled>Pilih Kecamatan</option>');
          response.forEach(function (kecamatan) {
            $('#kecamatan_domisili').append(`<option value="${kecamatan.id}">${kecamatan.name}</option>`);
          });
        }
      });
    });

    // Filter Desa berdasarkan Kecamatan untuk Domisili
    $('#kecamatan_domisili').on('change', function () {
      let kecamatanId = $(this).val();
      $('#desa_domisili').html('<option selected disabled>Loading...</option>');

      $.ajax({
        url: '/get-desa',
        type: 'GET',
        data: { kecamatan_id: kecamatanId },
        success: function (response) {
          $('#desa_domisili').empty();
          $('#desa_domisili').append('<option selected disabled>Pilih Desa</option>');
          response.forEach(function (desa) {
            $('#desa_domisili').append(`<option value="${desa.id}">${desa.name}</option>`);
          });
        }
      });
    });
  });

  document.querySelector('#form-data-pribadi').addEventListener('submit', function (e) {
    e.preventDefault();

    // Ambil nilai input form
    const userId = document.querySelector('#user_id').value; // Pastikan #user_id adalah ID yang sesuai di HTML
    const namaLengkap = document.querySelector('#nama_lengkap').value;
    const jenisKelamin = document.querySelector('#jenis_kelamin').value;
    const tempatLahir = document.querySelector('#tempat_lahir').value;
    const tanggalLahir = document.querySelector('#tanggal_lahir').value;
    const email = document.querySelector('#email').value;
    const agama = document.querySelector('#agama').value;
    const nomorNikKtp = document.querySelector('#nomor_nik_ktp').value;
    const nomorNpwp = document.querySelector('#nomor_npwp').value || '-';
    const nomorHp = document.querySelector('#nomor_hp').value;
    const ibuKandung = document.querySelector('#ibu_kandung').value;
    const golonganDarah = document.querySelector('#golongan_darah').value;
    const statusPernikahan = document.querySelector('#status_pernikahan').value;

    // Alamat KTP
    const jalanKtp = document.querySelector('#jalan_ktp').value;
    const rtKtp = document.querySelector('#rt_ktp').value;
    const rwKtp = document.querySelector('#rw_ktp').value;
    const provinsiKtp = document.querySelector('#provinsi_ktp').selectedOptions[0].text; // Ambil nama provinsi, bukan ID
    const kabupatenKtp = document.querySelector('#kabupaten_ktp').selectedOptions[0].text; // Ambil nama kabupaten
    const kecamatanKtp = document.querySelector('#kecamatan_ktp').selectedOptions[0].text; // Ambil nama kecamatan
    const desaKtp = document.querySelector('#desa_ktp').selectedOptions[0].text;

    // Alamat Domisili
    const jalanDomisili = document.querySelector('#jalan_domisili').value;
    const rtDomisili = document.querySelector('#rt_domisili').value;
    const rwDomisili = document.querySelector('#rw_domisili').value;
    // Sama untuk alamat domisili jika diperlukan
    const provinsiDomisili = document.querySelector('#provinsi_domisili').selectedOptions[0].text;
    const kabupatenDomisili = document.querySelector('#kabupaten_domisili').selectedOptions[0].text;
    const kecamatanDomisili = document.querySelector('#kecamatan_domisili').selectedOptions[0].text;
    const desaDomisili = document.querySelector('#desa_domisili').selectedOptions[0].text;

    const isSameAddress = document.querySelector('#same-address').checked;

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
      user_id: userId,
      nama_lengkap: namaLengkap,
      jenis_kelamin: jenisKelamin,
      tempat_lahir: tempatLahir,
      tanggal_lahir: tanggalLahir,
      email: email,
      agama: agama,
      nomor_nik_ktp: nomorNikKtp,
      nomor_npwp: nomorNpwp,
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

    // Kirim data ke server menggunakan AJAX
    $.ajax({
      url: '/form/karyawan/storeKaryawan',
      method: 'post',
      data: JSON.stringify(formData),
      cache: false,
      contentType: 'application/json',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Successfully Added!',
          text: 'Data pribadi berhasil disimpan.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(result => {
          if (result.isConfirmed) {
            // Pindah ke step 2 menggunakan BS Stepper
            stepper.next();
            disableStepperNavigation(false);
          }
        });

      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText); // Log jika terjadi error dari server
      }
    });
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
