<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $title }}</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="">
  <div class="container-content flex flex-row gap-16 h-screen bg-[#DDF2FD] items-center justify-center">
    <a href="/home/profile" class="absolute top-10 left-10 p-1 px-2 bg-[#427D9D] text-white rounded-full">< Kembali</a>
    <div class="flex p-6 flex-col bg-white h-[400px] w-[550px] justify-start items-center rounded-2xl shadow-xl 2xl:h-[500px] 2xl:w-[700px]">
      <p class="text-center text-xl font-semibold mb-6 text-[#427D9D]">Sertifikat Keahlian</p>
      <label for="" class="text-sm mb-1">Nomor Sertifikasi</label>
      <input type="text" value="{{ $sertifikasi['nomor_sertifikasi'] }}" class="w-[80%] text-center mb-4 text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm">
      <div class="tanggal flex flex-row w-[80%] gap-2">
        <div class="tanggal-pembuatan">
          <label for="" class="text-sm mb-1">Tanggal Pembuatan</label>
          <input type="text" value="{{  Carbon\Carbon::parse($sertifikasi->tanggal_pembuatan)->formatLocalized('%d %B %Y') }}" class="text-center mb-4 text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm">
        </div>
        <div class="tanggal-expired">
          <label for="" class="text-sm mb-1">Tanggal Expired</label>
          <input type="text" value="{{  Carbon\Carbon::parse($sertifikasi->tanggal_expired)->formatLocalized('%d %B %Y') }}" class="text-center mb-4 text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm">
        </div>
      </div>
      <p class="text-xs text-gray-600 text-center italic w-[80%]">*tanggal expired pada dokumen akan me-nonaktifkan akun anda. mohon siapkan dokumen sebelum tanggal expired</p>
      <a data-name="{{ $sertifikasi->bukti }}" class="preview-gambar p-6 mt-6 rounded-xl text-white font-semibold hover:bg-transparent hover:border-[#427D9D] hover:border-2 hover:text-[#427D9D] bg-[#427D9D] w-[80%] text-center">Cek Dokumen</a>
    </div>
    <div class="flex p-6 flex-col bg-white h-[400px] w-[550px] justify-start items-center rounded-2xl shadow-xl 2xl:h-[500px] 2xl:w-[700px]">
      <p class="text-center text-xl font-semibold mb-6 text-[#427D9D]">Surat Izin</p>
      <label for="" class="text-sm mb-1">Nomor Surat Izin</label>
      <input type="text" value="{{ $suratIzin['nomor_surat'] }}" class="w-[80%] text-center mb-4 text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm">
      <div class="tanggal flex flex-row w-[80%] gap-2">
        <div class="tanggal-pembuatan">
          <label for="" class="text-sm mb-1">Tanggal Pembuatan</label>
          <input type="text" value="{{  Carbon\Carbon::parse($suratIzin->tanggal_pembuatan)->formatLocalized('%d %B %Y') }}" class="text-center mb-4 text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm">
        </div>
        <div class="tanggal-expired">
          <label for="" class="text-sm mb-1">Tanggal Expired</label>
          <input type="text" value="{{  Carbon\Carbon::parse($suratIzin->tanggal_expired)->formatLocalized('%d %B %Y') }}" class="text-center mb-4 text-gray-500 bg-[#F1F1F1] border-transparent rounded-xl text-sm">
        </div>
      </div>
      <p class="text-xs text-gray-600 text-center italic w-[80%]">*tanggal expired pada dokumen akan me-nonaktifkan akun anda. mohon siapkan dokumen sebelum tanggal expired</p>
      <a data-name="{{ $suratIzin->bukti }}" class="preview-gambar p-6 mt-6 rounded-xl text-white font-semibold hover:bg-transparent hover:border-[#427D9D] hover:border-2 hover:text-[#427D9D] bg-[#427D9D] w-[80%] text-center">Cek Dokumen</a>
    </div>
  </div>
</body>
<script>
    const previewGambar = document.querySelectorAll('.preview-gambar');
    previewGambar.forEach(preview => {
        preview.addEventListener('click', function() {
          const bukti = this.getAttribute('data-name');
          const gambarPath = "{{ asset('storage') . '/'}}" + bukti;
          window.open(gambarPath, '_blank')
        });
    });
</script>
</html>