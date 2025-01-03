$(function () {
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
                '<option value="' + kabupaten.id + '" ' + (kabupaten.id == kabupatenKtp ? 'selected' : '') + '>' + kabupaten.name + '</option>'
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
                '<option value="' + kecamatan.id + '" ' + (kecamatan.id == kecamatanKtp ? 'selected' : '') + '>' + kecamatan.name + '</option>'
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
                '<option value="' + desa.id + '" ' + (desa.id == desaKtp ? 'selected' : '') + '>' + desa.name + '</option>'
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


  // Form validation and submission
  $('#form-data-pribadi').on('submit', function (e) {
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
    const nomorRek = document.querySelector('#nomor_rekening').value || '-';
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
        }).then(() => {
          window.location.href = '/form/karyawan';
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
          $('#kabupaten_ktp').append(
            '<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>'
          );
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
