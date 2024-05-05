@extends('peternak.layouts.index')

@section('content')
<div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[20vw]">
  <a href="/main/laporan-ib"><p class="relative right-[420px] top-10 2xl:text-xl 2xl:right-[600px]"><  Kembali</p></a>
  <div class="justify-center items-center flex flex-col mt-16 bg-white rounded-2xl w-[85%] 2xl:text-lg">
    <div class="text flex flex-row mt-5 w-full justify-start ml-10">
      <p class="font-bold text-slate-700 mt-1">Riwayat Inseminasi</p>
      <input id="search-nama" type="text" class="p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari Tanggal...">
    </div>
    <table class="mt-5 cursor-pointer rounded-xl w-full">
      <thead class="rounded-xl">
        <tr class=" text-gray-700 rounded-xl bg-gray-200">
          <th scope="col" class="px-2 py-2 font-medium">Tanggal IB</th>
          <th scope="col" class="px-2 py-2 font-medium">Jenis Semen</th>
          <th scope="col" class="px-2 py-2 font-medium">Nama Mantri</th>
          <th scope="col" class="px-2 py-2 font-medium">Tanggal Cek</th>
          <th scope="col" class="px-2 py-2 font-medium">Status Bunting</th>
        </tr>
      </thead>
      <tbody>
        @foreach($laporanIB as $data)
          @foreach($inseminator as $mantri)
            @if($data->id_mantri = $mantri->id)
              <tr class="clickable-row border-b text-sm text-center">
                <td class="px-4 py-4">{{ $data->tgl_ib }}</td>
                <td class="px-4 py-4">{{ $data->jenisSemen['jenis_semen'] }}</td>
                <td class="px-4 py-4">{{ $mantri->name }}</td>
                <td class="px-4 py-4">{{ $data->tgl_cek }}</td>
                <td class="px-4 py-4">
                  @if($data->status_bunting == 1)
                    Bunting
                  @else
                    Belum Bunting
                  @endif
                </td>
              </tr>
            @endif
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script>
  const searchInput = document.getElementById('search-nama');

  searchInput.addEventListener('input', function() {
      const searchValue = this.value.toLowerCase();
      const tableRows = document.querySelectorAll('tbody tr.clickable-row');
      const subTable = document.querySelectorAll('tbody tr.sub-table');

      tableRows.forEach(row => {
          const kecamatanName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
          if (kecamatanName.includes(searchValue)) {
              row.style.display = 'table-row';
          } else {
              row.style.display = 'none';
          }

          if (row.style.display === 'none') {
              const index = parseInt(row.dataset.index);
              const subTables = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);
              subTables.forEach(subTable => {
                  subTable.classList.add('hidden');
              });
          } else if (row.style.display === 'table-row') {
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