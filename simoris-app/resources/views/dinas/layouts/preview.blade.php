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
    <p class="font-bold mt-20 text-xl">PREVIEW</p>
    <div class="table-container container-table w-[70vw] justify-center items-center flex flex-col mt-6 ml-20 bg-white rounded-2xl">
      <div class="button flex mt-4 justify-center w-full">
        <p class="mr-96 mt-2 2xl:mr-[750px] 2xl:text-lg">Data Stok Semen Beku</p>
        <a href="/dashboard" class="p-1 mr-2 bg-red-500 text-white w-[150px] rounded-xl text-center">Batal</a>
        <form action="" method="POST">
          @csrf
          <input type="hidden" name="total_stok" value="{{ session('stok.total_stok') }}">
          <input type="hidden" name="Simental" value="{{ session('stok.Simental') }}">
          <input type="hidden" name="PO" value="{{ session('stok.PO') }}">
          <input type="hidden" name="Brahma" value="{{ session('stok.Brahma') }}">
          <input type="hidden" name="Limosin" value="{{ session('stok.Limosin') }}">
          <button class="p-1 rounded-xl text-center bg-[#427D9D] text-white w-[150px]" type="submit">Submit</button>
        </form>
      </div>
      <table class="mt-4 cursor-pointer rounded-xl w-full font-light 2xl:text-lg">
        <thead>
          <tr class="text-gray-700 rounded-xl bg-gray-200">
            <th scope="col" class="px-2 py-2 font-normal">No</th>
            <th scope="col" class="px-2 py-2 font-normal">Kecamatan</th>
            <th scope="col" class="px-2 py-2 font-normal">Total Stok</th>
            <th scope="col" class="px-2 py-2 font-normal">Sisa Stok</th>
            <th scope="col" class="px-2 py-2"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $index => $item)
            @foreach ($kecamatan as $kecIndex => $kecItem)
              @if ($index === $kecIndex)
                <tr class="text-center clickable-row border-b" data-index="{{ $index }}">
                  <td class="px-4 py-4">{{ $loop->iteration }}</td>
                  <td class="px-4 py-4">{{ $kecItem->kecamatan }}</td>
                  <td class="px-4 py-4">{{ $item->total_stok }}</td>
                  <td class="px-4 py-4">{{ $item->sisa_stok }}</td>
                  <td class="px-4 py-4"><button id="drop-{{ $index }}" class="bg-[#9BBEC8] rounded-xl text-white px-1">></button></td>
                </tr>
                @foreach ($subdata as $subIndex => $subItem)
                  @foreach ($kecamatan as $kecamatanIndex => $kecamatanItem)
                    @foreach ($jenis_semen as $jenisIndex => $jenisItem)
                      @if($item->kecamatan_id === $subItem->kecamatan_id && $kecamatanIndex === $kecIndex && $jenisItem->id === $subItem->jenis_semen_id)
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
  <script>
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
  </script>
@endsection