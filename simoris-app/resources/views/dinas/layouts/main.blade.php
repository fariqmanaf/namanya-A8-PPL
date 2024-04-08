@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[15vw]">
    @if($errors->any())
      <div class="alert absolute top-20">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(session('success'))
      <div class="alert absolute top-20">
        <p>{{ session('success') }}</p>
      </div>
    @endif
    <button id="trigger" class="p-1 mt-5 bg-[#427D9D] text-white w-[150px] font-semibold absolute right-20 top-44 rounded-xl text-center">+ Tambah Stok</button>
    <div class="w-[70vw] justify-center items-center flex flex-col ml-20 mt-60 bg-white rounded-2xl">
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
            @foreach ($kecamatan as $kecIndex => $kecItem)
              @if ($index === $kecIndex)
                <tr class="text-center clickable-row border-b" data-index="{{ $index }}">
                  <td class="px-4 py-4">{{ $loop->iteration }}.</td>
                  <td class="px-4 py-4">{{ $kecItem->kecamatan }}</td>
                  <td class="px-4 py-4">{{ $item->total_stok }}</td>
                  <td class="px-4 py-4">{{ $item->sisa_stok }}</td>
                  <td class="px-4 py-4"><button id="drop-{{ $index }}" class="bg-[#9BBEC8] rounded-xl text-white px-1">></button></td>
                </tr>
                @foreach ($subdata as $subIndex => $subItem)
                  @foreach ($kecamatan as $kecamatanIndex => $kecamatanItem)
                    @foreach ($jenis_semen as $jenisIndex => $jenisItem)
                      @if($kecamatanItem->id === $subItem->kecamatan_id && $kecamatanIndex === $kecIndex && $jenisItem->id === $subItem->jenis_semen_id)
                          <tr id="sub-table-{{ $index }}-{{ $subIndex }}" class="hidden text-center sub-table bg-gray-200 border-b border-gray-300">
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
  </div>
  <div class="modal hidden z-1 w-[500px] h-80 fixed left-[35%] top-48 bg-white rounded-3xl">
      <span class="close-button cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
      <div class="container-modal flex flex-col justify-center items-center">
        <form action="" method="POST">
          @csrf
          <p class="text-xl font-bold text-center text-[#427D9D]">Tambah Stok</p>
          <div class="total-container flex flex-col text-center mt-5">
            <label for="total_stok" class="">Total Stok</label>
            <input type="text" name="total_stok" id="total_stok" class="w-[450px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
          </div>
          <div class="jenis-container mt-5 flex flex-row gap-3">
            <div class="Simental text-center flex flex-col">
              <label for="Simental">Simental</label>
              <input type="text" name="Simental" id="Simental" class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
            <div class="PO text-center flex flex-col">
              <label for="PO">PO</label>
              <input type="text" name="PO" id="PO" class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
            <div class="Brahma text-center flex flex-col">
              <label for="Brahma">Brahma</label>
              <input type="text" name="Brahma" id="Brahma" class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
            <div class="Limosin text-center flex flex-col">
              <label for="Limosin">Limosin</label>
              <input type="text" name="Limosin" id="Limosin" class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
            </div>
          </div>
          <div class="button-container mt-5 flex justify-center">
            <button type="submit" class="bg-[#427D9D] text-white px-5 py-2 rounded-xl w-[300px] mt-3">Submit</button>
          </div>
        </form>
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
@endsection
