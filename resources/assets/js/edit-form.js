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
          url: '/get-kabupaten-edit',
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
          url: '/get-kecamatan-edit',
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
          url: '/get-desa-edit',
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
        url: '/get-kabupaten-edit',
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
        url: '/get-kecamatan-edit',
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
        url: '/get-desa-edit',
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
        url: '/get-kabupaten-edit',
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
        url: '/get-kecamatan-edit',
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
        url: '/get-desa-edit',
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

  function loadUserData(userId) {
    $.ajax({
        url: `/karyawan/${userId}/edit`,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.data) {
                const data = response.data;

                $('#user_id').val(data.user_id);
                $('#nama_lengkap').val(data.nama_lengkap);
                $('#jenis_kelamin').val(data.jenis_kelamin);
                $('#tempat_lahir').val(data.tempat_lahir);
                $('#tanggal_lahir').val(data.tanggal_lahir);
                $('#email').val(data.email);
                $('#agama').val(data.agama);
                $('#nomor_nik_ktp').val(data.nomor_nik_ktp);
                $('#nomor_hp').val(data.nomor_hp);
                $('#golongan_darah').val(data.golongan_darah);
                $('#ibu_kandung').val(data.ibu_kandung);
                $('#status_pernikahan').val(data.status_pernikahan);

                if (data.alamat_ktp) {
                    $('#jalan_ktp').val(data.alamat_ktp.jalan);
                    $('#rt_ktp').val(data.alamat_ktp.rt);
                    $('#rw_ktp').val(data.alamat_ktp.rw);
                    $('#provinsi_ktp').val(data.alamat_ktp.provinsi).trigger('change');
                }

                if (data.alamat_domisili) {
                    $('#jalan_domisili').val(data.alamat_domisili.jalan);
                    $('#rt_domisili').val(data.alamat_domisili.rt);
                    $('#rw_domisili').val(data.alamat_domisili.rw);
                    $('#provinsi_domisili').val(data.alamat_domisili.provinsi).trigger('change');
                }
            }
        },
        error: function () {
            Swal.fire('Error', 'Gagal memuat data.', 'error');
        }
    });
  }

  document.querySelector('#form-data-pribadi').addEventListener('submit', function (e) {
    e.preventDefault();

    // Ambil nilai input form (sama seperti yang sebelumnya)
    const userId = document.querySelector('#user_id').value;
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
    const provinsiKtp = document.querySelector('#provinsi_ktp').value;
    const kabupatenKtp = document.querySelector('#kabupaten_ktp').value;
    const kecamatanKtp = document.querySelector('#kecamatan_ktp').value;
    const desaKtp = document.querySelector('#desa_ktp').value;

    // Alamat Domisili
    const jalanDomisili = document.querySelector('#jalan_domisili').value;
    const rtDomisili = document.querySelector('#rt_domisili').value;
    const rwDomisili = document.querySelector('#rw_domisili').value;
    const provinsiDomisili = document.querySelector('#provinsi_domisili').value;
    const kabupatenDomisili = document.querySelector('#kabupaten_domisili').value;
    const kecamatanDomisili = document.querySelector('#kecamatan_domisili').value;
    const desaDomisili = document.querySelector('#desa_domisili').value;

    const isSameAddress = document.querySelector('#same-address').checked;

    // Validasi (seperti yang sebelumnya)

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

    // Kirim data ke server untuk memperbarui data
    $.ajax({
      url: '/form/karyawan/updateKaryawan',  // Endpoint untuk memperbarui data
      method: 'put', // Gunakan metode PUT untuk update
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
          title: 'Successfully Updated!',
          text: 'Data pribadi berhasil diperbarui.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(result => {
          if (result.isConfirmed) {
            //
          }
        });
      }
    });
  });
});
