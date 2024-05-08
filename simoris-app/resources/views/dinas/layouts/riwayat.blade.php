@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[85vw] flex flex-col items-center h-full ml-[15vw]">
    <div class="container-table w-[70vw] justify-center items-center flex flex-col ml-20 mt-16 bg-white rounded-2xl">
      <div class="text flex flex-row mt-5 w-full justify-start ml-10">
        <p class="font-bold text-slate-700 mt-1 2xl:text-xl">Riwayat</p>
        <input id="search-tanggal" type="text" class="p-1 rounded-full ml-40 text-sm w-96 bg-gray-200 border border-transparent 2xl:p-2" placeholder=" Cari Tanggal....">
      </div>
      <table class="mt-5 cursor-pointer rounded-xl w-full 2xl:text-lg">
        <thead>
          <tr class="text-gray-700 rounded-xl bg-gray-200">
            <th scope="col" class="px-2 py-2 font-medium"></th>
            <th scope="col" class="px-2 py-2 font-medium">Tanggal Riwayat</th>
            <th scope="col" class="px-2 py-2 font-medium">Total Stok</th>
            <th scope="col" class="px-2 py-2 font-medium">Sisa Stok</th>
            <th scope="col" class="px-2 py-2 font-medium"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($superdata as $superindex => $superitem)
            <tr class="text-center clickable-row border-b" data-index="{{ $superindex }}">
              <td class="px-4 py-4"></td>
              <td class="px-4 py-4">{{  Carbon\Carbon::parse($superitem->periode)->formatLocalized('%d %B %Y') }}</td>
              <td class="px-4 py-4">{{ $superitem->total_stok }}</td>
              <td class="px-4 py-4">{{ $superitem->sisa_stok }}</td>
              <td class="px-4 py-4"><button id="drop-{{ $superindex }}" class="bg-[#9BBEC8] rounded-xl text-white px-1">></button></td>
            </tr>
            @foreach ($data as $index => $item)
                  <tr id="sub-row-{{ $superindex }}-{{ $index }}" class="2xl:text-lg hidden text-center text-sm border-b border-gray-300 clickable-subrow bg-gray-200" data-index="{{ $index }}">
                    <td class="px-4 py-4"></td>
                    <td class="px-4 py-4">{{ $item->kecamatan['kecamatan'] }}</td>
                    <td class="px-4 py-4">{{ $item->total_stok }}</td>
                    <td class="px-4 py-4">{{ $item->sisa_stok }}</td>
                    <td class="px-4 py-4"><button id="subdrop-{{ $index }}" class="bg-[#9BBEC8] rounded-xl text-white px-1">></button></td>
                  </tr>
                  @foreach ($subdata as $subIndex => $subItem)
                    @if($subItem->kecamatan_id === $item->kecamatan_id)
                        <tr id="sub-table-{{ $index }}-{{ $subIndex }}" class="hidden text-center sub-table bg-gray-100 border-b">
                          <td class="px-2 py-2"></td>
                          <td class="px-2 py-2">{{ $subItem->jenis_sapi['jenis'] }}</td>
                          <td class="px-2 py-2">{{ $subItem->jumlah }}</td>
                          <td class="px-2 py-2">{{ $subItem->sisa_stok }}</td>
                          <td class="px-2 py-2"></td>
                        </tr>
                    @endif
                  @endforeach
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <script>
    // Add event listener to each clickable row
    document.querySelectorAll('.clickable-row').forEach(row => {
      row.addEventListener('click', function() {
          const index = parseInt(this.dataset.index);
          const subRow = document.querySelectorAll(`tr[id^="sub-row-${index}-"]`);
          subRow.forEach(subRow => {
              subRow.classList.toggle('hidden');
          });
          document.getElementById(`drop-${index}`).innerText = document.getElementById(`drop-${index}`).innerText === '>' ? 'v' : '>';
      });
    });

    document.querySelectorAll('.clickable-subrow').forEach(row => {
      row.addEventListener('click', function() {
          const index = parseInt(this.dataset.index);
          const subTable = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);
          subTable.forEach(subTable => {
              subTable.classList.toggle('hidden');
          });
          document.getElementById(`subdrop-${index}`).innerText = document.getElementById(`subdrop-${index}`).innerText === '>' ? 'v' : '>';
      });
    });

    // Add event listener to search input
    const searchInput = document.getElementById('search-tanggal');
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
                const subRow = document.querySelectorAll(`tr[id^="sub-row-${index}-"]`);
                const subTable = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);

                subRow.forEach(subRow => {
                  subRow.classList.add('hidden');
                });

                subTable.forEach(subTable => {
                  subTable.classList.add('hidden');
                });
              }
              else if(row.style.display === 'table-row'){
                const index = parseInt(row.dataset.index);
                const subRow = document.querySelectorAll(`tr[id^="sub-row-${index}-"]`);
                const subTable = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);

                subRow.forEach(subRow => {
                  subRow.classList.add('hidden');
                });

                subTable.forEach(subTable => {
                  subTable.classList.add('hidden');
                });
              }
        });
    });
  </script>
@endsection