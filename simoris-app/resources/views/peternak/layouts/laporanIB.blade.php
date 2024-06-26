@extends('peternak.layouts.index')

@section('content')
<div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[20vw]">
  <div class="justify-center items-center flex flex-col mt-20 bg-white rounded-2xl w-[85%] 2xl:text-lg">
    <div class="text flex flex-row mt-5 w-full justify-start ml-10">
      <p class="font-bold text-slate-700 mt-1">Daftar Sapi</p>
      <input id="search-nama" type="text" class="p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari ID Sapi">
    </div>
    <table class="mt-5 cursor-pointer rounded-xl w-full">
      <thead class="rounded-xl">
        <tr class=" text-gray-700 rounded-xl bg-gray-200">
          <th scope="col" class="px-2 py-2 font-medium">ID Sapi</th>
          <th scope="col" class="px-2 py-2 font-medium">Jenis Sapi</th>
          <th scope="col" class="px-2 py-2 font-medium">Ciri-Ciri</th>
          <th scope="col" class="px-2 py-2 font-medium">Total IB</th>
          <th scope="col" class="px-2 py-2 font-medium"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($dataSapi as $sapi)
              <tr class="clickable-row border-b text-sm text-center">
                <td class="px-4 py-4">{{ $sapi->id }}</td>
                <td class="px-4 py-4">{{ $sapi->jenisSapi['jenis'] }}</td>
                <td id="nonex" data-index="{{ $loop->iteration }}" class="px-4 py-4">{{ Str::words($sapi->detail, 10, '...') }}</td>
                <td class="px-4 py-4">{{ $sapi->laporanIb->count() }}</td>
                <td class="px-4 py-4">
                  <a href="/main/laporan-ib/sapi-{{ $sapi->id }}" class="open-modal">
                    <img src="{{ asset('assets/icon/view.svg') }}" alt="View" class="h-5 w-5">
                  </a>
                </td>
              </tr>
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

  const seeMore = document.querySelectorAll('#nonex');

  seeMore.forEach((item) => {
    item.addEventListener('click', () => {
      const index = item.dataset.index;
      const ex = document.getElementById(`ex-${index}`);
      ex.classList.toggle('hidden');
    });
  });

  const triggerButton = document.getElementById('trigger');
  const modal = document.querySelector('.modal');
  const closeButton = document.querySelector('.close-button');

  triggerButton.addEventListener('click', function() {
      modal.style.display = 'block';
      document.querySelectorAll('body > *:not(.modal)').forEach(element => {
          element.style.filter = 'blur(5px)';
      });
  });

  closeButton.addEventListener('click', function() {
      modal.style.display = 'none';
      document.querySelectorAll('body > *:not(.modal)').forEach(element => {
          element.style.filter = 'none';
      });
  });
</script>
@endsection