$(function () {
  const select2 = $('.select2');

  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.select2({
        placeholder: 'Pilih Opsi',
        dropdownParent: $this.parent()
      });
    });
  }

  // Load Provinsi saat halaman dimuat
  function loadProvinsi() {
    $.ajax({
      url: 'https://ibnux.github.io/data-indonesia/provinsi.json',
      type: 'GET',
      success: function (response) {
        let provinsiOptions = '<option selected disabled>Pilih Provinsi</option>';
        response.forEach(function (provinsi) {
          provinsiOptions += `<option value="${provinsi.nama}" data-id="${provinsi.id}">${provinsi.nama}</option>`;
        });

        $('#provinsi_ktp, #provinsi_domisili').html(provinsiOptions);
      },
      error: function () {
        alert('Gagal memuat daftar provinsi.');
      }
    });
  }

  loadProvinsi();

  // Event checkbox "Sama dengan Alamat KTP"
  $('#same-address').on('change', function () {
    if ($(this).is(':checked')) {
      // Salin alamat jalan, RT, RW
      $('#jalan_domisili').val($('#jalan_ktp').val());
      $('#rt_domisili').val($('#rt_ktp').val());
      $('#rw_domisili').val($('#rw_ktp').val());

      // Salin Provinsi
      let provinsiNama = $('#provinsi_ktp option:selected').text();
      let provinsiId = $('#provinsi_ktp option:selected').data('id');
      $('#provinsi_domisili').val(provinsiNama).trigger('change');

      // Load Kabupaten setelah Provinsi terpilih
      $.ajax({
        url: `https://ibnux.github.io/data-indonesia/kabupaten/${provinsiId}.json`,
        type: 'GET',
        success: function (response) {
          let kabupatenOptions = '<option selected disabled>Pilih Kabupaten</option>';
          response.forEach(function (kabupaten) {
            kabupatenOptions += `<option value="${kabupaten.nama}" data-id="${kabupaten.id}">${kabupaten.nama}</option>`;
          });
          $('#kabupaten_domisili').html(kabupatenOptions);

          let kabupatenNama = $('#kabupaten_ktp option:selected').text();
          let kabupatenId = $('#kabupaten_ktp option:selected').data('id');
          $('#kabupaten_domisili').val(kabupatenNama).trigger('change');

          // Load Kecamatan setelah Kabupaten terpilih
          $.ajax({
            url: `https://ibnux.github.io/data-indonesia/kecamatan/${kabupatenId}.json`,
            type: 'GET',
            success: function (response) {
              let kecamatanOptions = '<option selected disabled>Pilih Kecamatan</option>';
              response.forEach(function (kecamatan) {
                kecamatanOptions += `<option value="${kecamatan.nama}" data-id="${kecamatan.id}">${kecamatan.nama}</option>`;
              });
              $('#kecamatan_domisili').html(kecamatanOptions);

              let kecamatanNama = $('#kecamatan_ktp option:selected').text();
              let kecamatanId = $('#kecamatan_ktp option:selected').data('id');
              $('#kecamatan_domisili').val(kecamatanNama).trigger('change');

              // Load Desa setelah Kecamatan terpilih
              $.ajax({
                url: `https://ibnux.github.io/data-indonesia/kelurahan/${kecamatanId}.json`,
                type: 'GET',
                success: function (response) {
                  let desaOptions = '<option selected disabled>Pilih Desa</option>';
                  response.forEach(function (desa) {
                    desaOptions += `<option value="${desa.nama}" data-id="${desa.id}">${desa.nama}</option>`;
                  });
                  $('#desa_domisili').html(desaOptions);

                  let desaNama = $('#desa_ktp option:selected').text();
                  $('#desa_domisili').val(desaNama);
                }
              });
            }
          });
        }
      });
    } else {
      // Jika checkbox dicentang ulang, kosongkan field domisili
      $('#jalan_domisili, #rt_domisili, #rw_domisili').val('');
      $('#provinsi_domisili, #kabupaten_domisili, #kecamatan_domisili, #desa_domisili').val('').trigger('change');
    }
  });

  // Manual Dropdown Handling untuk Alamat KTP
  $('#provinsi_ktp').on('change', function () {
    let provinsiId = $(this).find(':selected').data('id');
    $('#kabupaten_ktp').html('<option>Loading...</option>');

    $.ajax({
      url: `https://ibnux.github.io/data-indonesia/kabupaten/${provinsiId}.json`,
      type: 'GET',
      success: function (response) {
        $('#kabupaten_ktp').empty().append('<option selected disabled>Pilih Kabupaten</option>');
        response.forEach(function (kabupaten) {
          $('#kabupaten_ktp').append(
            `<option value="${kabupaten.nama}" data-id="${kabupaten.id}">${kabupaten.nama}</option>`
          );
        });
      }
    });
  });

  $('#kabupaten_ktp').on('change', function () {
    let kabupatenId = $(this).find(':selected').data('id');
    $('#kecamatan_ktp').html('<option selected disabled>Loading...</option>');

    $.ajax({
      url: `https://ibnux.github.io/data-indonesia/kecamatan/${kabupatenId}.json`,
      type: 'GET',
      success: function (response) {
        $('#kecamatan_ktp').empty().append('<option selected disabled>Pilih Kecamatan</option>');
        response.forEach(function (kecamatan) {
          $('#kecamatan_ktp').append(
            `<option value="${kecamatan.nama}" data-id="${kecamatan.id}">${kecamatan.nama}</option>`
          );
        });
      }
    });
  });

  $('#kecamatan_ktp').on('change', function () {
    let kecamatanId = $(this).find(':selected').data('id');
    $('#desa_ktp').html('<option selected disabled>Loading...</option>');

    $.ajax({
      url: `https://ibnux.github.io/data-indonesia/kelurahan/${kecamatanId}.json`,
      type: 'GET',
      success: function (response) {
        $('#desa_ktp').empty().append('<option selected disabled>Pilih Desa</option>');
        response.forEach(function (desa) {
          $('#desa_ktp').append(
            `<option value="${desa.nama}" data-id="${desa.id}">${desa.nama}</option>`
          );
        });
      }
    });
  });
});
