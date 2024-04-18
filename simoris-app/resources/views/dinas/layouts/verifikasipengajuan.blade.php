@extends('dinas.layouts.dashboard')

@section('content')
  @if(session()->has('success'))
  <div class="p-1 alert absolute top-10 left-96 w-60 text-sm bg-green-500 text-white rounded-xl">
    {{ session('success') }}
  </div>
  @endif
  <div class="content-container w-[70vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[22vw] mt-10">
    <div class="table-container w-[65vw] justify-center items-center flex flex-col ml-20 bg-white rounded-2xl">
      <div class="text flex flex-row mt-5 w-full justify-start ml-10">
        <p class="font-bold text-slate-700 mt-1 2xl:text-xl">Verifikasi Pengajuan</p>
        <input id="search-nama" type="text" class="search-nama p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari Nama....">
      </div>
      <table class="mt-5 cursor-pointer rounded-xl w-full table-size text-sm">
        <thead class="rounded-xl">
          <tr class=" text-gray-700 rounded-2xl bg-gray-200">
            <th scope="col" class="px-2 py-2 font-medium">No.</th>
            <th scope="col" class="px-2 py-2 font-medium">Nama</th>
            <th scope="col" class="px-2 py-2 font-medium">Alamat</th>
            <th scope="col" class="px-2 py-2 font-medium">Wilayah Kerja</th>
            <th scope="col" class="px-2 py-2 font-medium"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($dataMantri as $mantri)
              <tr class="text-center clickable-row border-b"">
                <td class="px-4 py-4">
                  {{ $loop->iteration }}.
                </td>
                <td class="px-4 py-4">
                  {{ $mantri->name }}
                </td>
                <td class="px-4 py-4">
                  {{ $mantri->alamat['detail'] }},
                  {{ $mantri->alamat->kelurahan['kelurahan'] }},
                  {{ $mantri->alamat->kecamatan['kecamatan'] }},
                  {{ $mantri->alamat->kabupaten['kabupaten'] }}
                </td>
                <td class="px-4 py-4">
                  @foreach($mantri->wilayah_kerja as $wilayah)
                    {{ $wilayah->kecamatan['kecamatan'] }}
                  @endforeach
                </td>
                <td class="px-4 py-4">
                  <a href="#" data-target="#modal-{{ $mantri->id }}" class="open-modal">
                      <img src="{{ asset('assets/icon/view.svg') }}" alt="View" class="h-5 w-5">
                  </a>
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
    @foreach($dataMantri as $mantri)
        <div id="modal-{{ $mantri->id }}" class="hidden modal absolute top-10 left-[28%] pb-10 2xl:top-10">
          <span class="close-modal relative top-0 right-0 m-2 text-gray-500 hover:text-gray-800 cursor-pointer 2xl:text-2xl">< Kembali</span>
          <div class="modal-content bg-white rounded-2xl w-[55rem] h-[50rem] shadow-lg p-6 items-center flex flex-col text-sm 2xl:w-[1228px] 2xl:h-[900px] 2xl:text-lg">
            <img src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="Logo Dinas" class="h-24 w-24 mt-8 rounded-full border border-gray-800 bg-gray-800">
            <div class="info-content flex flex-row justify-center items-center mt-12 gap-16 w-8/12">
              <div class="nama-tanggal-notelp w-6/12 flex flex-col gap-8">
                <div class="nama">
                  <p class="text-gray-400">Nama</p>
                  <p class="">{{ $mantri->name }}</p>
                </div>
                <div class="nama">
                  <p class="text-gray-400">Tanggal Lahir</p>
                  <p class="">{{ $mantri->tgl_lahir }}</p>
                </div>
                <div class="notelp">
                  <p class="text-gray-400">Nomor Telepon</p>
                  <p class="">{{ $mantri->no_telp }}</p>
                </div>
              </div>
              <div class="nik-wilayah-alamat w-6/12 flex flex-col gap-8">
                <div class="nik">
                  <p class="text-gray-400">Nomor Induk Kependudukan</p>
                  <p class="">{{ $mantri->nik }}</p>
                </div>
                <div class="nik">
                  <p class="text-gray-400">Wilayah Kerja</p>
                  <p class="">{{ $wilayah->kecamatan['kecamatan'] }}</p>
                </div>
                <div class="email">
                  <p class="text-gray-400">Email</p>
                  @foreach($mantri->userAccounts as $akun)
                    <p class="">{{ $akun->email }}</p>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="alamat w-8/12 mt-12">
              <p class="text-gray-400">Alamat</p>
              <p class="">{{ $mantri->alamat['detail'] }}, {{ $mantri->alamat->kelurahan['kelurahan'] }}, {{ $mantri->alamat->kecamatan['kecamatan'] }}, {{ $mantri->alamat->kabupaten['kabupaten'] }}</p>
            </div>

            <hr class="bg-gray-300 w-9/12 mt-6 h-[2px]"> 

            
            <form class="persuratan flex flex-col gap-x-10 mt-8 gap-y-5 justify-center items-center" action="" method="post">
              @csrf
              @method('PUT')
              <div class="flex flex-row gap-10">
                @foreach($mantri->sertifikasi as $sertif)
                <div class="sertif flex flex-col gap-x-3">
                  <p class="text-gray-400">No. Sertifikasi Keahlian</p>
                  <p class="mb-2">{{ $sertif->nomor_sertifikasi }}</p>
                  <div class="tanggal-sertif flex flex-row gap-5">
                    <div class="pembuatan">
                      <p class="text-gray-400">Tanggal Pembuatan</p>
                      <p class="mb-2">{{ $sertif->tanggal_pembuatan }}</p>
                    </div>
                    <div class="expired">
                      <p class="text-gray-400">Tanggal Expired</p>
                      <p class="mb-2">{{ $sertif->tanggal_expired }}</p>
                    </div>
                  </div>
                  <div id="bukti-sertifikasi-{{ $mantri->id }}" class="preview-gambar w-72 h-14 flex items-center justify-center bg-gray-200 text-xs rounded-xl">{{ ($sertif->bukti) }}</div>
                  <div class="flex flex-row w-full justify-center items-center gap-x-3 mt-2">
                    <button type="button" class="px-12 py-1 rounded-lg text-white font-semibold text-sm bg-[#FE6666] hover:bg-[#d15353]" id="tolakSertif-{{ $mantri->id }}">Tolak</button>
                    <button type="button" class="px-12 py-1 rounded-lg text-white font-semibold text-sm bg-[#66C57A] hover:bg-[#5db671]" id="setujuSertif-{{ $mantri->id }}">Setujui</button>
                    <input type="hidden" name="is_accepted_sertif" class="bg-transparent" id="is_accepted-sertif-{{ $mantri->id }}">
                    <input type="hidden" name="id" value="{{ $mantri->id }}">
                  </div>
                  <!-- <p class="text-xs mt-5 2xl:text-md">* klik teks untuk memunculkan & klik gambar menghilangkan</p> -->
                </div>
                @endforeach
                @foreach($mantri->surat_izin as $izin)
                <div class="suratizin flex flex-col gap-x-3">
                  <p class="text-gray-400">No. Surat Izin Praktik</p>
                  <p class="mb-2">{{ $izin->nomor_surat }}</p>
                  <div class="tanggal-suratizin flex flex-row gap-5">
                    <div class="pembuatan">
                      <p class="text-gray-400">Tanggal Pembuatan</p>
                      <p class="mb-2">{{ $izin->tanggal_pembuatan }}</p>
                    </div>
                    <div class="expired">
                      <p class="text-gray-400">Tanggal Expired</p>
                      <p class="mb-2">{{ $izin->tanggal_expired }}</p>
                    </div>
                  </div>
                  <div id="bukti-izin-{{ $mantri->id }}" class="preview-gambar w-72 h-14 flex items-center justify-center bg-gray-200 text-xs rounded-xl">{{ ($izin->bukti) }}</div>
                  <div class="flex flex-row w-full justify-center items-center gap-x-3 mt-2">
                    <button type="button" class="px-12 py-1 rounded-lg text-white font-semibold text-sm bg-[#FE6666] hover:bg-[#d15353]" id="tolakIzin-{{ $mantri->id }}">Tolak</button>
                    <button type="button" class="px-12 py-1 rounded-lg text-white font-semibold text-sm bg-[#66C57A] hover:bg-[#5db671]" id="setujuIzin-{{ $mantri->id }}">Setujui</button>
                    <input type="hidden" name="is_accepted_izin" class="bg-transparent" id="is_accepted-izin-{{ $mantri->id }}">
                    <input type="hidden" name="id" value="{{ $mantri->id }}">
                  </div>
                </div>
                @endforeach
              </div>
              <button type="submit" class="w-44 rounded-lg text-white font-semibold text-sm bg-[#427D9D] hover:bg-[#4f96bd] p-2">Kirim</button>
            </form>
            
      </div>
    </div>
    @endforeach
</div>


  <script>
    const modals = document.querySelectorAll('.modal');
    const openModalButtons = document.querySelectorAll('.open-modal');
    const table = document.querySelector('.table-container');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    openModalButtons.forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();

            modals.forEach(modal => {
                modal.classList.add('hidden');
            });
            
            const modalId = event.currentTarget.getAttribute('data-target');
            const modal = document.querySelector(modalId);
            modal.classList.remove('hidden');

            table.classList.add('hidden');
        });
    });

    closeModalButtons.forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const modal = event.currentTarget.closest('.modal');
            modal.classList.add('hidden');
            table.classList.remove('hidden');
            table.classList.add('table-container');
        });
    });

    window.addEventListener('click', function(event) {
        modals.forEach(modal => {
            if (event.target == modal) {
                modal.classList.add('hidden');
                table.classList.remove('hidden');
                table.classList.add('table-container');
            }
        });
    });

    const previewGambar = document.querySelectorAll('.preview-gambar');

    previewGambar.forEach(preview => {
        preview.addEventListener('click', function() {
            const existingImage = this.querySelector('img');
            
            if(existingImage) {
                existingImage.remove();

            } else {
                const gambar = document.createElement('img');
                gambar.src = "/storage/" + this.innerHTML;
                gambar.style.maxWidth = '100px';
                gambar.classList.add('absolute');
                gambar.classList.add('absolute');
                gambar.classList.add('top-0');
                gambar.classList.add('left-0');
                gambar.classList.add('2xl:left-40');
                this.appendChild(gambar);
            }
        });
    });

    const setuju = document.querySelectorAll('[id^=setujuSertif-]');
    const tolak = document.querySelectorAll('[id^=tolakSertif-]');

    setuju.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.id.split('-')[1];
            const input = document.getElementById('is_accepted-sertif-' + id);
            const info = document.getElementById('informationSertif-' + id);
            input.value = 1;
            info.innerHTML = 'Sertifikasi Disetujui';
        });
    });

    tolak.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.id.split('-')[1];
            const input = document.getElementById('is_accepted-sertif-' + id);
            input.value = 0;
            const info = document.getElementById('informationSertif-' + id);
            info.innerHTML = 'Sertifikasi Ditolak';
        });
    });
    
    const setuju2 = document.querySelectorAll('[id^=setujuIzin-]');
    const tolak2 = document.querySelectorAll('[id^=tolakIzin-]');

    setuju2.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.id.split('-')[1];
            const input = document.getElementById('is_accepted-izin-' + id);
            const info = document.getElementById('informationIzin-' + id);
            input.value = 1;
            info.innerHTML = 'Surat Izin Disetujui';
        });
    });

    tolak2.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.id.split('-')[1];
            const input = document.getElementById('is_accepted-izin-' + id);
            input.value = 0;
            const info = document.getElementById('informationIzin-' + id);
            info.innerHTML = 'Surat Izin Ditolak';
        });
    });
    
  </script>
@endsection