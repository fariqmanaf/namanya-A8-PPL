@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[85vw] flex flex-col items-center h-full ml-[15vw]">
    <input id="search-tanggal" type="text" class="p-2 mt-10 relative right-96 rounded-full text-center" placeholder="Search Tanggal Stok">
    <table class="w-[80%] mt-10 cursor-pointer">
      <thead>
        <tr class="bg-black text-white text-center">
          <th scope="col" class="px-2 py-2"></th>
          <th scope="col" class="px-2 py-2">Tanggal Riwayat</th>
          <th scope="col" class="px-2 py-2">Total Stok</th>
          <th scope="col" class="px-2 py-2">Sisa Stok</th>
          <th scope="col" class="px-2 py-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($superdata as $superindex => $superitem)
          <tr class="text-center clickable-row" data-index="{{ $superindex }}">
            <td class="px-4 py-4"></td>
            <td class="px-4 py-4">{{  Carbon\Carbon::parse($superitem->periode)->formatLocalized('%d %B %Y') }}</td>
            <td class="px-4 py-4">{{ $superitem->total_stok }}</td>
            <td class="px-4 py-4">{{ $superitem->sisa_stok }}</td>
            <td class="px-4 py-4"><button id="drop-{{ $superindex }}" class="bg-black text-white px-1">></button></td>
          </tr>
          @foreach ($data as $index => $item)
            @foreach ($kecamatan as $kecIndex => $kecItem)
              @if ($superitem->periode === $item->periode && $kecItem->id === $item->kecamatan_id)
                <tr id="sub-row-{{ $superindex }}-{{ $index }}" class="hidden text-center clickable-subrow bg-slate-800 text-white" data-index="{{ $index }}">
                  <td class="px-4 py-4" colspan="2">{{ $kecItem->kecamatan }}</td>
                  <td class="px-4 py-4">{{ $item->total_stok }}</td>
                  <td class="px-4 py-4">{{ $item->sisa_stok }}</td>
                  <td class="px-4 py-4"><button id="subdrop-{{ $index }}" class="bg-black text-white px-1">></button></td>
                </tr>
                @foreach ($subdata as $subIndex => $subItem)
                  @foreach ($kecamatan as $kecamatanIndex => $kecamatanItem)
                    @foreach ($jenis_semen as $jenisIndex => $jenisItem)
                      @if($item->periode === $subItem->periode && $kecamatanItem->id === $subItem->kecamatan_id && $kecamatanIndex === $kecIndex && $jenisItem->id === $subItem->jenis_semen_id)
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
        @endforeach
      </tbody>
    </table>
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
        tableRows.forEach(row => {
            const kecamatanName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (kecamatanName.includes(searchValue)) {
                row.style.display = 'table-row';}
            else {row.style.display = 'none'}
        });
    });
  </script>
@endsection