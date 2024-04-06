@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[85vw] flex flex-col items-center h-full ml-[15vw]">
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
    <input id="search-kecamatan" type="text" class="p-2 mt-10 relative right-96 rounded-full text-center" placeholder="Search Kecamatan">
    <button id="trigger" class="p-2 mt-5 bg-black text-white w-[200px] font-semibold relative right-96 rounded-full text-center">Input Stok</button>
    <table class="w-[80%] mt-5 cursor-pointer">
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
  <div class="modal hidden z-1 w-[500px] h-80 fixed left-[35%] top-48 bg-slate-200 rounded-3xl">
      <span class="close-button cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
      <div class="container-modal flex flex-col justify-center items-center font-bold">
        <form action="" method="POST">
          @csrf
          <p class="text-xl">Tambah Stok</p>
          <div class="total-container flex flex-col text-center mt-5">
            <label for="total_stok">Total Stok</label>
            <input type="text" name="total_stok" id="total_stok" class="w-[400px] h-10 rounded-full text-center">
          </div>
          <div class="jenis-container mt-5 flex flex-row gap-3">
            <div class="Simental text-center flex flex-col">
              <label for="Simental">Simental</label>
              <input type="text" name="Simental" id="Simental" class="w-[100px] h-10 rounded-full text-center">
            </div>
            <div class="PO text-center flex flex-col">
              <label for="PO">PO</label>
              <input type="text" name="PO" id="PO" class="w-[100px] h-10 rounded-full text-center">
            </div>
            <div class="Brahma text-center flex flex-col">
              <label for="Brahma">Brahma</label>
              <input type="text" name="Brahma" id="Brahma" class="w-[100px] h-10 rounded-full text-center">
            </div>
            <div class="Limosin text-center flex flex-col">
              <label for="Limosin">Limosin</label>
              <input type="text" name="Limosin" id="Limosin" class="w-[100px] h-10 rounded-full text-center">
            </div>
          </div>
          <div class="button-container mt-5 flex justify-center">
            <button type="submit" class="bg-black text-white px-5 py-2 rounded-full w-[300px] mt-3">Submit</button>
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
