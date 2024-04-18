@extends('dinas.layouts.dashboard')

@section('content')
  @if(session()->has('success'))
  <div class="p-1 alert absolute top-10 left-96 w-60 text-sm bg-green-500 text-white rounded-xl">
    {{ session('success') }}
  </div>
  @endif
  <div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[15vw] mt-20">
    <div class="c w-8/12">
      <table class="mt-5 cursor-pointer rounded-xl w-full table-size">
        <thead class="rounded-xl">
          <tr class="text-gray-700 rounded-xl bg-gray-200">
            <th scope="col" class="px-2 py-2 font-medium">Nama</th>
            <th scope="col" class="px-2 py-2 font-medium">Alamat</th>
            <th scope="col" class="px-2 py-2 font-medium">Wilayah Kerja</th>
            <th scope="col" class="px-2 py-2 font-medium">Detail</th>
          </tr>
        </thead>
        <tbody>
            @foreach($dataMantri as $mantri)
              <tr class="text-center clickable-row border-b"">
                <td class="px-4 py-4">
                  {{ $mantri->name }}
                </td>
                <td class="px-4 py-4">
                    {{ $mantri->alamat->kabupaten['kabupaten'] }},
                    {{ $mantri->alamat->kecamatan['kecamatan'] }},
                    {{ $mantri->alamat->kelurahan['kelurahan'] }},
                    {{ $mantri->alamat['detail'] }}
                </td>
                <td class="px-4 py-4">
                  @foreach($mantri->wilayah_kerja as $wilayah)
                    {{ $wilayah->kecamatan['kecamatan'] }}
                  @endforeach
                </td>
                <td class="px-4 py-4">
                  <a href="#" data-target="#modal-{{ $mantri->id }}" class="open-modal">
                      detail
                  </a>
                </td>
                <div id="modal-{{ $mantri->id }}" class="hidden modal  absolute top-6 left-[40%] inset-0 z-1 overflow-auto">
                  <div class="modal-content bg-white rounded-lg shadow-lg p-6 max-w-md justify-center items-center flex flex-col">
                    <span class="close-modal relative top-0 right-0 m-2 text-gray-500 hover:text-gray-800 cursor-pointer">&times;</span>
                    <p class="mb-4">Nama : {{ $mantri->name }}</p>
                    <p class="mb-4">NIK : {{ $mantri->nik }}</p>
                    <p class="mb-2">Wilayah Kerja: {{ $wilayah->kecamatan['kecamatan'] }}</p>
                    @foreach($mantri->userAccounts as $akun)
                      <p class="mb-2">Email: {{ $akun->email }}</p>
                    @endforeach
                    <p class="mb-2">Tanggal Lahir: {{ $mantri->tgl_lahir }}</p>
                    <p class="mb-2">Nomor Telepon: {{ $mantri->no_telp }}</p>
                    <p class="mb-2">Alamat:
                      {{ $mantri->alamat->kabupaten['kabupaten'] }},
                      {{ $mantri->alamat->kecamatan['kecamatan'] }},
                      {{ $mantri->alamat->kelurahan['kelurahan'] }},
                      {{ $mantri->alamat['detail'] }}                         
                    </p>
                    <form action="" method="post">
                      @csrf
                      @method('PUT')
                      @foreach($mantri->sertifikasi as $sertif)
                          <p class="mb-2">No. Sertifikasi Keahlian: {{ $sertif->nomor_sertifikasi }}</p>
                          <div id="bukti-sertifikasi-{{ $mantri->id }}" class="preview-gambar">{{ ($sertif->bukti) }}</div>
                          <p class="mb-2">Tanggal Pembuatan: {{ $sertif->tanggal_pembuatan }}</p>
                          <p class="mb-2">Tanggal Expired: {{ $sertif->tanggal_expired }}</p>
                            <button type="button" class="p-1 bg-green-700" id="setujuSertif-{{ $mantri->id }}">Setujui</button>
                            <button type="button" class="p-1 bg-red-700" id="tolakSertif-{{ $mantri->id }}">Tolak</button>
                            <p id="informationSertif-{{ $mantri->id }}"></p>
                            <input type="hidden" name="is_accepted_sertif" class="bg-transparent" id="is_accepted-sertif-{{ $mantri->id }}">
                            <input type="hidden" name="id" value="{{ $mantri->id }}">
                        @endforeach
                        @foreach($mantri->surat_izin as $izin)
                          <p class="mb-2">No. Surat Izin Praktik: {{ $izin->nomor_surat }}</p>
                          <div id="bukti-izin-{{ $mantri->id }}" class="preview-gambar">{{ ($izin->bukti) }}</div>
                          <p class="mb-2">Tanggal Pembuatan: {{ $izin->tanggal_pembuatan }}</p>
                          <p class="mb-2">Tanggal Expired: {{ $izin->tanggal_expired }}</p>
                          <button type="button" class="p-1 bg-green-700" id="setujuIzin-{{ $mantri->id }}">Setujui</button>
                          <button type="button" class="p-1 bg-red-700" id="tolakIzin-{{ $mantri->id }}">Tolak</button>
                          <p id="informationIzin-{{ $mantri->id }}"></p>
                          <input type="hidden" name="is_accepted_izin" class="bg-transparent" id="is_accepted-izin-{{ $mantri->id }}">
                          <input type="hidden" name="id" value="{{ $mantri->id }}">
                        @endforeach
                        <button type="submit" class="bg-indigo-700 p-2">Kirim</button>
                    </form>
                </div>
              </div>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <script>
    const modals = document.querySelectorAll('.modal');
    const openModalButtons = document.querySelectorAll('.open-modal');
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
        });
    });

    closeModalButtons.forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const modal = event.currentTarget.closest('.modal');
            modal.classList.add('hidden');
        });
    });

    window.addEventListener('click', function(event) {
        modals.forEach(modal => {
            if (event.target == modal) {
                modal.classList.add('hidden');
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