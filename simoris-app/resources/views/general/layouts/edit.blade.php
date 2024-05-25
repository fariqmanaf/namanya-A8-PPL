@extends('general.layouts.main')

@section('content')
<div class="formcontainer h-[100dvh] w-screen flex flex-col justify-center items-center bg-[#DDF2FD]">
      
  <img src="{{asset("assets/bg.png")}}" class="z-0 absolute top-0 mt-7 w-full" alt="">
  
  <form action="/back" method="POST" class="z-10">
    @csrf
    <button class="mb-2 z-10 mr-80 text-sm 2xl:mr-[470px] 2xl:text-xl" type="submit ">< Kembali</button>
  </form>
  <div class="form-regist3 z-10 w-[434px] h-[550px] bg-[#FFFF] rounded-2xl shadow-xl">
    <p class="text-center py-6 text-2xl font-bold text-[#427D9D] 2xl:py-8">Perbaiki Datamu!</p>
    <form action="" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2 justify-center items-center z-10">
      @csrf
      @method('PUT')
      <div class="form-container flex flex-col items-center gap-3 mb-5 2xl:gap-6">
          @if($sertifikasi->is_accepted == 1)
              <p class="text-green-500 text-sm ml-40 2xl:ml-72">✅ Sertifikasi Diterima</p>
          @else
              <p class="text-red-500 text-sm ml-40 2xl:ml-72">❌ Sertifikasi Ditolak</p>
          @endif
          <input name="no_sertifikasi" type="text" value="{{ $sertifikasi->nomor_sertifikasi }}" class="input-regist3 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
          <div class="tanggal1">
            <input
            class="w-[165px] bg-[#F1F1F1] border-transparent rounded-xl text-xs 2xl:h-[50px] 2xl:text-lg 2xl:w-[230px] 2xl:p-2" 
            name="tanggal-pembuatan-sertif" 
            type="date"
            value="{{ $sertifikasi->tanggal_pembuatan }}"
            onchange="setExpiredDate(this.value)">
            <input
            class="w-[165px] bg-[#F1F1F1] border-transparent rounded-xl text-xs 2xl:h-[50px] 2xl:text-lg 2xl:w-[230px] 2xl:p-2" 
            name="tanggal-expired-sertif" 
            type="date"
            value="{{ $sertifikasi->tanggal_expired }}"
            readonly>
          </div>
          <div class="flex items-center justify-center w-full 2xl:w-[470px]">
            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-14 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-[#F1F1F1] hover:bg-gray-100 dark:border-gray-400 dark:hover:border-gray-500 dark:hover:bg-slate-200 2xl:h-20">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <p id="file-name" class="text-sm text-gray-500 dark:text-gray-400  2xl:text-lg">Klik Untuk Unggah Sertifikasi</p>
                </div>
                <input id="dropzone-file" onchange="displayFileName()" name="bukti_sertifikasi" type="file" class="hidden" />
            </label>
          </div> 
          @if($suratizin->is_accepted == 1)
              <p class="text-green-500 text-sm ml-40 2xl:ml-72">✅ Surat Izin Diterima</p>
          @else
              <p class="text-red-500 text-sm ml-40 2xl:ml-72">❌ Surat Izin Ditolak</p>
          @endif
          <input name="no_suratizin" type="text" value="{{ $suratizin->nomor_surat }}" class="input-regist3 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
          
          <div class="tanggal2">
            <input
            class="w-[165px] bg-[#F1F1F1] border-transparent rounded-xl text-xs 2xl:h-[50px] 2xl:text-lg 2xl:w-[230px] 2xl:p-2" 
            name="tanggal-pembuatan-suratizin" 
            type="date"
            value="{{ $suratizin->tanggal_pembuatan }}"
            onchange="setExpiredDate2(this.value)">
            <input
            class="w-[165px] bg-[#F1F1F1] border-transparent rounded-xl text-xs 2xl:h-[50px] 2xl:text-lg 2xl:w-[230px] 2xl:p-2" 
            name="tanggal-expired-suratizin" 
            type="date"
            value="{{ $suratizin->tanggal_expired }}"
            readonly>
          </div>
          <div class="flex items-center justify-center w-full 2xl:w-[470px]">
            <label for="dropzone-file2" class="flex flex-col items-center justify-center w-full h-14 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-[#F1F1F1] hover:bg-gray-100 dark:border-gray-400 dark:hover:border-gray-500 dark:hover:bg-slate-200 2xl:h-20">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <p id="file-name2" class="text-sm text-gray-500 dark:text-gray-400  2xl:text-lg">Klik Untuk Unggah Surat Izin</p>
                </div>
                <input id="dropzone-file2" onchange="displayFileName2()" name="bukti_suratizin" type="file" class="hidden" />
            </label>
          </div> 
          <button type="submit" class="input-regist3 p-1 w-[334px] bg-[#427D9D] text-white border-transparent rounded-xl mt-3">Submit</button>
      </div>
    </form>
  </div>
</div>
<script>
  function displayFileName() {
      const fileInput = document.getElementById('dropzone-file');
      const fileNameParagraph = document.getElementById('file-name');
      
      if (fileInput.files.length > 0) {
        fileNameParagraph.textContent = fileInput.files[0].name;
      } else {
        fileNameParagraph.textContent = "Klik Untuk Unggah Sertifikasi";
      }
    }
    function displayFileName2() {
      const fileInput = document.getElementById('dropzone-file2');
      const fileNameParagraph = document.getElementById('file-name2');
      
      if (fileInput.files.length > 0) {
        fileNameParagraph.textContent = fileInput.files[0].name;
      } else {
        fileNameParagraph.textContent = "Klik Untuk Unggah Surat Izin";
      }
    }
    function setExpiredDate(createDate) {
      const expiredDateInput = document.querySelector('input[name="tanggal-expired-sertif"]');
      const createDateObj = new Date(createDate);
      const expiredDateObj = new Date(createDateObj.setFullYear(createDateObj.getFullYear() + 4));
      const formattedExpiredDate = expiredDateObj.getFullYear() + '-' + String(expiredDateObj.getMonth() + 1).padStart(2, '0') + '-' + String(expiredDateObj.getDate()).padStart(2, '0');
      expiredDateInput.value = formattedExpiredDate;
    }
    function setExpiredDate2(createDate) {
      const expiredDateInput = document.querySelector('input[name="tanggal-expired-suratizin"]');
      const createDateObj = new Date(createDate);
      const expiredDateObj = new Date(createDateObj.setFullYear(createDateObj.getFullYear() + 4));
      const formattedExpiredDate = expiredDateObj.getFullYear() + '-' + String(expiredDateObj.getMonth() + 1).padStart(2, '0') + '-' + String(expiredDateObj.getDate()).padStart(2, '0');
      expiredDateInput.value = formattedExpiredDate;
    }
</script>
@endsection