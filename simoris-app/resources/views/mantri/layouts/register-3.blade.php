@extends('general.layouts.main')

@section('content')
  <div class="formcontainer h-[100dvh] w-screen flex flex-col justify-center items-center bg-[#DDF2FD]">
    @if($errors->any())
      <div class="alert absolute">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <img src="{{asset("assets/bg.png")}}" class="z-0 absolute top-0 mt-7 w-full" alt="">
    <a href="/register/mantri/step-2" class="mb-2 z-10 mr-80 2xl:mr-[470px] 2xl:text-xl">< Kembali</a>
    <div class="form-regist3 z-10 w-[434px] h-[500px] bg-[#FFFF] rounded-2xl shadow-xl">
      <p class="text-center py-6 text-2xl font-bold text-[#427D9D] 2xl:py-8">Yuk Lengkapi Datamu!</p>
      <form action="" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2 justify-center items-center z-10">
        @csrf
        <div class="form-container flex flex-col items-center gap-5 mb-5 2xl:gap-8">
            <select name="wilayah_kerja" id="wilayah_kerja" class="input-regist3 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
              <option value="" disabled selected>Wilayah Kerja</option>
              @foreach ($kecamatan as $item)
                <option value="{{ $item->kecamatan }}">{{ $item->kecamatan }}</option>
              @endforeach
            </select>
            <input name="no_sertifikasi" type="text" placeholder="No Sertifikasi" class="input-regist3 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
            <div class="flex items-center justify-center w-full 2xl:w-[470px]">
              <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-14 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-[#F1F1F1] hover:bg-gray-100 dark:border-gray-400 dark:hover:border-gray-500 dark:hover:bg-slate-200 2xl:h-20">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                      <p id="file-name" class="text-sm text-gray-500 dark:text-gray-400  2xl:text-lg">Klik Untuk Unggah Sertifikasi</p>
                  </div>
                  <input id="dropzone-file" onchange="displayFileName()" name="bukti_sertifikasi" type="file" class="hidden" />
              </label>
            </div> 
            <input type="hidden" name="is_accepted_sertifikasi" value="random">
            <input name="no_suratizin" type="text" placeholder="No Surat Izin" class="input-regist3 text-sm w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
            <div class="flex items-center justify-center w-full 2xl:w-[470px]">
              <label for="dropzone-file2" class="flex flex-col items-center justify-center w-full h-14 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-[#F1F1F1] hover:bg-gray-100 dark:border-gray-400 dark:hover:border-gray-500 dark:hover:bg-slate-200 2xl:h-20">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                      <p id="file-name2" class="text-sm text-gray-500 dark:text-gray-400  2xl:text-lg">Klik Untuk Unggah Surat Izin</p>
                  </div>
                  <input id="dropzone-file2" onchange="displayFileName2()" name="bukti_suratizin" type="file" class="hidden" />
              </label>
            </div> 
            <input type="hidden" name="is_accepted_suratizin" value="random">
            <button type="submit" class="input-regist3 p-2 w-[334px] bg-[#427D9D] text-white border-transparent rounded-xl">Daftar</button>
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
  </script>
@endsection