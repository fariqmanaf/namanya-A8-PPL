@extends('mantri.layouts.index')

@section('content')
<div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[20vw]">
  <div class="justify-center items-center flex flex-col mt-20 bg-white rounded-2xl w-[85%] 2xl:text-lg">
    <div class="text flex flex-row mt-5 w-full justify-start ml-10">
      <p class="font-bold text-slate-700 mt-1">Riwayat Laporan</p>
      <input id="search-nama" type="text" class="p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari Nama Atau Tanggal....">
    </div>
    <table class="mt-5 cursor-pointer rounded-xl w-full">
      <thead class="rounded-xl">
        <tr class=" text-gray-700 rounded-xl bg-gray-200">
          <th scope="col" class="px-2 py-2 font-medium">No.</th>
          <th scope="col" class="px-2 py-2 font-medium">Nama Peternak</th>
          <th scope="col" class="px-2 py-2 font-medium">Tanggal IB</th>
          <th scope="col" class="px-2 py-2 font-medium">Jenis Sapi</th>
          <th scope="col" class="px-2 py-2 font-medium">Jenis Semen</th>
        </tr>
      </thead>
      <tbody>
        @foreach($laporanIB as $index => $riwayat)
          @foreach($peternak as $pt)
            @if($riwayat->id_peternak == $pt->id)
              <tr class="clickable-row border-b text-sm text-center">
                <td class="px-4 py-4">{{ $index + 1 }}.</td>
                <td class="px-4 py-4">{{ $pt->name }}</td>
                <td class="px-4 py-4">{{ Carbon\Carbon::parse($riwayat->tgl_ib)->formatLocalized('%d %B %Y') }}</td>
                <td class="px-4 py-4">{{ $riwayat->dataSapi->jenisSapi['jenis'] }}</td>
                <td class="px-4 py-4">{{ $riwayat->jenisSemen['jenis_semen'] }}</td>
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
          const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
          const date = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
          if (name.includes(searchValue) || date.includes(searchValue)) {
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