@extends('mantri.layouts.index')
@vite('resources/js/map.js')
@section('content')
  <div class="content-container relative w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[20vw]">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div id="map" class="absolute top-14 right-14 2xl:right-20 w-[88%] h-[300px]"></div>
    <div class="justify-center items-center flex flex-col mt-96 bg-white rounded-2xl w-[70vw] ml-6 2xl:text-lg">
      <div class="text flex flex-row mt-5 w-full justify-between ml-10">
        <div class="searchForm flex-row flex">
          <p class="font-bold text-slate-700 mt-1">Data Stok Semen Beku</p>
          <input id="search-kecamatan" type="text" class="p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari Kecamatan....">  
        </div>
        <button id="trigger"
          class="bg-[#427D9D] hover:bg-[#14475A] text-white w-[170px] mr-12 font-semibold rounded-xl text-center input-stok"
          {{ $dataAccept = $percentage >= 50 ? 1 : 0; }}
          data-accept="{{ $dataAccept }}">
          + Ajukan Stok
        </button>
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
                  <td class="px-4 py-4" id="mapTotal-{{ $item->kecamatan['kecamatan'] }}" data-total="{{ $item->total_stok }}">{{ $item->total_stok }}</td>
                  <td class="px-4 py-4" id="mapSisa-{{ $item->kecamatan['kecamatan'] }}" data-sisa="{{ $item->sisa_stok }}">{{ $item->sisa_stok }}</td>
                  <td class="px-4 py-4"><button id="drop-{{ $index }}" class="bg-[#9BBEC8] rounded-xl text-white px-1">></button></td>
                </tr>
                @foreach ($subdata as $subIndex => $subItem)
                  @if($subItem->kecamatan_id == $item->kecamatan_id)
                          <tr id="sub-table-{{ $index }}-{{ $subIndex }}" class="hidden text-center sub-table bg-gray-200 border-b border-gray-300">
                            <td id="child-{{ $index }}" class="px-2 py-2"></td>
                            <td id="child-{{ $index }}" class="px-2 py-2">{{ $subItem->jenis_sapi['jenis_semen'] }}</td>
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
  <div class="modal hidden z-1 w-[40%] h-[24rem] fixed left-[35%] 2xl:left-[40%] top-48 bg-white rounded-3xl shadow-xl">
    <span class="close-button cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
    <div class="container-modal flex flex-col justify-center items-center">
      <form action="" method="POST">
        @csrf
        <p class="text-xl font-bold text-center text-[#427D9D]">Ajukan Stok</p>
        <div class="total-container flex flex-col text-center mt-5">
            <label for="total_stok" class="">Total Stok</label>
            <input type="text" name="total_stok" id="total_stok"
                class="w-[450px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
        </div>
        <div class="jenis-container mt-5 2xl:mt-6 flex flex-row gap-3">
            <div class="Simental text-center flex flex-col">
                <label for="Simental">Simental</label>
                <input type="text" name="Simental" id="Simental"
                    class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
            <div class="PO text-center flex flex-col">
                <label for="PO">PO</label>
                <input type="text" name="PO" id="PO"
                    class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
            <div class="Brahma text-center flex flex-col">
                <label for="Brahma">Brahma</label>
                <input type="text" name="Brahma" id="Brahma"
                    class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
            <div class="Limosin text-center flex flex-col">
                <label for="Limosin">Limosin</label>
                <input type="text" name="Limosin" id="Limosin"
                    class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
        </div>
        <p class="italic text-sm">*note : <br>- total semen jenis PO harus sedikitnya 10% dari total stok<br>- Stok ditentukan dari wilayah kerja anda</p>
        <div class="button-container mt-3 2xl:mt-3 flex justify-center">
            <button type="submit"
                class="bg-[#427D9D] text-white px-5 py-2 rounded-xl w-[300px] mt-3">Tambah</button>
        </div>
    </form>
    </div>
  </div>
  <div class="modal2 hidden z-1 w-[30%] h-40 fixed left-[40%] top-60 2xl:top-96 bg-white rounded-3xl shadow-xl">
    <span class="close-button2 absolute cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
    <div class="container-modal2 h-full flex flex-col justify-center items-center text-center">
      <p class="w-[80%] text-center text-red-600">Laporan Inseminasi Buatan belum mencapai 50%</p>
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

    const triggerButton = document.getElementById('trigger');
    const modal = document.querySelector('.modal');
    const modal2 = document.querySelector('.modal2');
    const closeButton = document.querySelector('.close-button');
    const closeButton2 = document.querySelector('.close-button2');
    const dataAccept = parseInt(triggerButton.dataset.accept);

    triggerButton.addEventListener('click', function() {
        if (dataAccept === 1) {
            modal.style.display = 'block';
            document.querySelectorAll('body > *:not(.modal)').forEach(element => {
                element.style.filter = 'blur(5px)';
            });
        } else {
            modal2.style.display = 'block';
            document.querySelectorAll('body > *:not(.modal2)').forEach(element => {
                element.style.filter = 'blur(5px)';
            });
        }
    });

    closeButton.addEventListener('click', function() {
        modal.style.display = 'none';
        document.querySelectorAll('body > *:not(.modal)').forEach(element => {
            element.style.filter = 'none';
        });
    });

    closeButton2.addEventListener('click', function() {
        modal2.style.display = 'none';
        document.querySelectorAll('body > *:not(.modal2)').forEach(element => {
            element.style.filter = 'none';
        });
    });
  </script>
@endsection