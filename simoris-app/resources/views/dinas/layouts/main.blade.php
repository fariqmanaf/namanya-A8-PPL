@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[85vw] flex flex-col items-center h-full ml-[15vw]">
    <input id="search-kecamatan" type="text" class="p-2 mt-10 relative right-96 rounded-full text-center" placeholder="Search Kecamatan">
    <table class="w-[80%] mt-10 cursor-pointer">
      <thead>
        <tr class="bg-black text-white">
          <th scope="col" class="px-2 py-2">No</th>
          <th scope="col" class="px-2 py-2">Kecamatan</th>
          <th scope="col" class="px-2 py-2">Total Stok</th>
          <th scope="col" class="px-2 py-2">Sisa Stok</th>
          <th scope="col" class="px-2 py-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $index => $item)
          @foreach ($kecamatan as $kecIndex => $kecItem)
            @if ($index === $kecIndex)
              <tr class="text-center clickable-row" data-index="{{ $index }}">
                <td class="px-4 py-4">{{ $loop->iteration }}</td>
                <td class="px-4 py-4">{{ $kecItem->kecamatan }}</td>
                <td class="px-4 py-4">{{ $item->total_stok }}</td>
                <td class="px-4 py-4">{{ $item->sisa_stok }}</td>
                <td class="px-4 py-4"><button id="drop-{{ $index }}" class="bg-black text-white px-1">></button></td>
              </tr>
              @foreach ($subdata as $subIndex => $subItem)
                @foreach ($kecamatan as $kecamatanIndex => $kecamatanItem)
                  @foreach ($jenis_semen as $jenisIndex => $jenisItem)
                    @if($kecamatanItem->id === $subItem->kecamatan_id && $kecamatanIndex === $kecIndex && $jenisItem->id === $subItem->jenis_semen_id)
                        <tr id="sub-table-{{ $index }}-{{ $subIndex }}" class="hidden text-center sub-table bg-slate-400">
                          <td class="px-2 py-2"></td>
                          <td class="px-2 py-2">{{ $jenisItem->jenis_semen }}</td>
                          <td class="px-2 py-2">{{ $subItem->jumlah }}</td>
                          <td class="px-2 py-2">{{ $subItem->sisa_stok }}</td>
                          <td class="px-2 py-2"></td>
                        </tr>
                    @endif
                  @endforeach
                @endforeach
              @endforeach
            @endif
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
  <script>
    // Add event listener to each clickable row
    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            const subTables = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);
            subTables.forEach(subTable => {
                subTable.classList.toggle('hidden');
            });
            document.getElementById(`drop-${index}`).innerText = document.getElementById(`drop-${index}`).innerText === '>' ? 'v' : '>';
        });
    });

    // Add event listener to search input
    const searchInput = document.getElementById('search-kecamatan');

    searchInput.addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr.clickable-row');
        tableRows.forEach(row => {
            const kecamatanName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (kecamatanName.includes(searchValue)) {
                row.style.display = 'table-row';}
            else {row.style.display = 'none';}
        });
    });
  </script>
@endsection
