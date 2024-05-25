@extends('mantri.layouts.index')

@section('content')
<div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[20vw]">
  {{--  --}}

  @if ($errors->any())
    <div class="alert absolute top-8 z-10">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  @if (session('success'))
    <div class="alert absolute top-8 z-10">
        <p>{{ session('success') }}</p>
    </div>
  @endif

  {{--  --}}
  <a href="/home/laporanIB"><p class="relative right-[420px] top-10 2xl:text-xl 2xl:right-[600px]"><  Kembali</p></a>
  <div class="profil mt-12 bg-white w-[85%] rounded-xl shadow-md p-4 text-sm">
    <p>Nama Peternak:</p>
    <p class="mb-4 font-semibold">{{ $profil->name }}</p>
    <p>Alamat:</p>
    <p class="font-semibold">{{ $profil->alamat['detail'] }},
      {{ $profil->alamat->kelurahan['kelurahan'] }},
      {{ $profil->alamat->kecamatan['kecamatan'] }},
      {{ $profil->alamat->kabupaten['kabupaten'] }}
    </p>
  </div>
  <div class="justify-center items-center flex flex-col mt-8 bg-white rounded-2xl w-[85%] 2xl:text-lg">
    <div class="text flex flex-row mt-5 w-full justify-between ml-10">
      <div class="searchForm flex-row flex">
        <p class="font-bold text-slate-700 mt-1">Daftar Sapi</p>
        <input id="search-sapi" type="text" class="p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari Sapi....">
      </div>
      <button id="trigger"
        class="bg-[#427D9D] text-white w-[170px] mr-12 font-semibold rounded-xl text-center input-stok">
        + Tambah Sapi
      </button>
    </div>
    <table class="mt-5 cursor-pointer rounded-xl w-full">
      <thead class="rounded-xl">
        <tr class=" text-gray-700 rounded-xl bg-gray-200 text-sm">
          <th scope="col" class="px-2 py-2 font-medium">No</th>
          <th scope="col" class="px-2 py-2 font-medium">Jenis Sapi</th>
          <th scope="col" class="px-2 py-2 font-medium">Ciri-Ciri</th>
          <th scope="col" class="px-2 py-2 font-medium">Total IB</th>
          <th scope="col" class="px-2 py-2 font-medium"> </th>
        </tr>
      </thead>
      <tbody>
        @foreach($dataSapi as $sapi)
          <tr class="clickable-row border-b text-sm text-center">
            <td class="px-4 py-4">{{ $loop->iteration }}.</td>
            <td class="px-4 py-4">{{ $sapi->jenisSapi['jenis'] }}</td>
            <td id="nonex" data-index="{{ $loop->iteration }}" class="px-4 py-4">{{ Str::words($sapi->detail, 10, '...') }}</td>
            <td class="px-4 py-4">{{ $sapi->laporanIb->count() }}</td>
            <td class="px-4 py-4">
              <a href="/home/laporanIB/{{ $profil->id }}/sapi-{{ $sapi->id }}" class="open-modal">
                <img src="{{ asset('assets/icon/view.svg') }}" alt="View" class="h-5 w-5">
              </a>
            </td>
          </tr>
          <tr id="ex-{{ $loop->iteration }}" class="px-4 py-4 hidden p-4 bg-white w-[20%]">
            <td colspan="5" class="text-center text-sm px-4 py-4 border-b">
              {{ $sapi->detail }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
{{--  --}}
<div class="modal hidden z-1 w-[30%] h-80 fixed left-[40%] top-48 bg-white rounded-3xl shadow-xl">
  <span class="close-button cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
  <div class="container-modal flex flex-col justify-center items-center">
      <form action="" method="POST">
          @csrf
          <p class="text-xl font-bold text-center text-[#427D9D]">Tambah Data Sapi</p>
          <div class="total-container flex flex-col text-center mt-5 items-center 2xl:gap-3">
              <label for="jenisSapi" class="">Jenis Sapi</label>
              <select name="jenisSapi" id="jenisSapi" class="w-[60%] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
                <option value="" disabled selected>Tambah Sapi</option>
                @foreach ($jenisSapi as $item)
                  <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                @endforeach
              </select>
              <label for="ciri" class="">Ciri-Ciri</label>
              <input type="text" name="ciri" id="ciri"
                class="w-[20rem] h-10 rounded-xl bg-gray-200 border-transparent text-center 2xl:w-full 2xl:h-14">
              <input name="id" type="hidden" value="{{ $profil->id }}">
          </div>
          <div class="button-container mt-3 flex justify-center">
              <button type="submit"
                  class="bg-[#427D9D] text-white px-5 py-2 rounded-xl w-[20rem] mt-3 2xl:py-3">Simpan</button>
          </div>
      </form>
  </div>
</div>
<script>
  const searchInput = document.getElementById('search-sapi');

  searchInput.addEventListener('input', function() {
      const searchValue = this.value.toLowerCase();
      const tableRows = document.querySelectorAll('tbody tr.clickable-row');
      const subTable = document.querySelectorAll('tbody tr.sub-table');

      tableRows.forEach(row => {
          const kecamatanName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
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