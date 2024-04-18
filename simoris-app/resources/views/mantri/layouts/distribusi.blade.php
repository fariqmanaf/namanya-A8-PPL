<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset('assets/logo-simoris.png') }}">
  <title>{{ $title }}</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="bg-[#DDF2FD]">
  <div class="content-container w-screen bg-[#DDF2FD] flex flex-col items-center h-screen">
    <a href="/home"><p class="relative left-[400px] top-20 mb-5 2xl:text-xl 2xl:left-[550px]"><  Kembali</p></a>
    <div class="justify-center items-center flex flex-col mt-20 bg-white rounded-2xl w-[70%] 2xl:text-lg">
      <div class="text flex flex-row mt-5 w-full justify-start ml-10">
        <p class="font-bold text-slate-700 mt-1">Data Stok Semen Beku</p>
        <input id="search-kecamatan" type="text" class="p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari Kecamatan....">
      </div>
      <table class="mt-5 cursor-pointer rounded-xl w-full">
        <thead class="rounded-xl">
          <tr class=" text-gray-700 rounded-xl bg-gray-200">
            <th scope="col" class="px-2 py-2 font-medium">No</th>
            <th scope="col" class="px-2 py-2 font-medium">Kecamatan</th>
            <th scope="col" class="px-2 py-2 font-medium">Total Stok</th>
            <th scope="col" class="px-2 py-2 font-medium">Sisa Stok</th>
            <th scope="col" class="px-2 py-2"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $index => $item)
            @if($item->kecamatan_id == $item->kecamatan['id'])
                <tr class="text-center clickable-row border-b" data-index="{{ $index }}">
                  <td class="px-4 py-4">{{ $loop->iteration }}.</td>
                  <td class="px-4 py-4">{{ $item->kecamatan['kecamatan'] }}</td>
                  <td class="px-4 py-4">{{ $item->total_stok }}</td>
                  <td class="px-4 py-4">{{ $item->sisa_stok }}</td>
                  <td class="px-4 py-4"><button id="drop-{{ $index }}" class="bg-[#9BBEC8] rounded-xl text-white px-1">></button></td>
                </tr>
                @foreach ($subdata as $subIndex => $subItem)
                  @if($subItem->kecamatan_id == $item->kecamatan_id)
                          <tr id="sub-table-{{ $index }}-{{ $subIndex }}" class="hidden text-center sub-table bg-gray-200 border-b border-gray-300">
                            <td id="child-{{ $index }}" class="px-2 py-2"></td>
                            <td id="child-{{ $index }}" class="px-2 py-2">{{ $subItem->jenis_sapi['jenis'] }}</td>
                            <td id="child-{{ $index }}" class="px-2 py-2">{{ $subItem->jumlah }}</td>
                            <td id="child-{{ $index }}" class="px-2 py-2">{{ $subItem->sisa_stok }}</td>
                            <td id="child-{{ $index }}" class="px-2 py-2"></td>
                          </tr>
                  @endif
                @endforeach
            @endif
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

    // Add event listener to trigger button
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
</body>
