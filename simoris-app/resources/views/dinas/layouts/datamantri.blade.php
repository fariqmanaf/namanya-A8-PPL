@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[70vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[22vw] mt-10">
    <div class="table-container w-[65vw] justify-center items-center flex flex-col ml-20 bg-white rounded-2xl">
      <div class="text flex flex-row mt-5 w-full justify-start ml-10">
        <p class="font-bold text-slate-700 mt-1 2xl:text-xl">Data Mantri</p>
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
              <tr class="text-left clickable-row border-b" data-target="#modal-{{ $mantri->id }}">
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
                  <a href="#" class="open-modal">
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

            <div class="persuratan flex flex-row gap-10 mt-8">
            @foreach($mantri->sertifikasi as $sertif)
              <div class="sertif flex flex-col gap-3">
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
                <div id="bukti-sertifikasi-{{ $mantri->id }}" class="preview-gambar w-72 h-14 flex items-center justify-center bg-gray-200 text-xs rounded-xl cursor-pointer">{{ ($sertif->bukti) }}</div>
                <p class="text-xs mt-5 2xl:text-md">* klik teks untuk memunculkan & klik gambar menghilangkan</p>
              </div>
            @endforeach
            @foreach($mantri->surat_izin as $izin)
              <div class="suratizin flex flex-col gap-3">
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
                <div id="bukti-izin-{{ $mantri->id }}" class="preview-gambar w-72 h-14 flex items-center justify-center bg-gray-200 text-xs rounded-xl cursor-pointer">{{ ($izin->bukti) }}</div>
              </div>
            @endforeach
        </div>
      </div>
    </div>
    @endforeach
</div>

  <script>
    const modals = document.querySelectorAll('.modal');
    const openModalButtons = document.querySelectorAll('.clickable-row');
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
          const id = this.id.split('-')[1];
          const bukti = this.getAttribute('data-name');
          const gambarPath = "{{ asset('storage') . '/'}}" + bukti;
          window.open(gambarPath, '_blank')
        });
    });

    const searchInput = document.getElementById('search-nama');

    searchInput.addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr.clickable-row');
        const subTable = document.querySelectorAll('tbody tr.sub-table');

        tableRows.forEach(row => {
              const kecamatanName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
              if (kecamatanName.includes(searchValue)) {
                row.style.display = 'table-row';
              }
              else {
                row.style.display = 'none';
              }

              if(row.style.display === 'none') {
                const index = parseInt(row.dataset.index);
                const subTables = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);
                subTables.forEach(subTable => {
                    subTable.classList.add('hidden');
                });
              }
              else if(row.style.display === 'table-row'){
                const index = parseInt(row.dataset.index);
                const subTables = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);
                subTables.forEach(subTable => {
                    subTable.classList.add('hidden');
                });
              }
        });
    });
</script>
@endsection