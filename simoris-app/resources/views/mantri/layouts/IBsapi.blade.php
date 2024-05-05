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
  <a href="/home/laporanIB/{{ $peternak->id }}"><p class="relative right-[420px] top-10 2xl:text-xl 2xl:right-[600px]"><  Kembali</p></a>
  <div class="justify-center items-center flex flex-col mt-12 bg-white rounded-2xl w-[85%] 2xl:text-lg">
    <div class="text flex flex-row mt-5 w-full justify-between ml-10">
      <div class="searchForm flex-row flex">
        <p class="font-bold text-slate-700 mt-1">Daftar Laporan IB</p>
        <input id="search-sapi" type="text" class="p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent" placeholder=" Cari Laporan....">
      </div>
      <button id="trigger"
        class="bg-[#427D9D] text-white w-[170px] mr-12 font-semibold rounded-xl text-center input-stok">
        + Tambah Laporan
      </button>
    </div>
    <table class="mt-5 cursor-pointer rounded-xl w-full">
      <thead class="rounded-xl">
        <tr class=" text-gray-700 rounded-xl bg-gray-200 text-sm">
          <th scope="col" class="px-2 py-2 font-medium">No.</th>
          <th scope="col" class="px-2 py-2 font-medium">Tanggal IB</th> 
          <th scope="col" class="px-2 py-2 font-medium">Jenis Semen</th>
          <th scope="col" class="px-2 py-2 font-medium">Inseminator</th>
          <th scope="col" class="px-2 py-2 font-medium">Tanggal Cek</th>
          <th scope="col" class="px-2 py-2 font-medium">Status</th>
          <th scope="col" class="px-2 py-2 font-medium"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($laporanIB as $index => $ib)
          @foreach($inseminator as $ins)
            <tr class="clickable-row border-b text-sm text-center">
              <td class="px-4 py-4">{{ $index + 1 }}.</td>
              <td class="px-4 py-4">{{ $ib->tgl_ib }}</td>
              <td class="px-4 py-4">{{ $ib->jenisSemen->jenis_semen }}</td>
              <td class="px-4 py-4">{{ $ins->name }}</td>
              @if($ib->tgl_cek == null)
                <td class="px-4 py-4">-</td>
              @else
                <td class="px-4 py-4">{{ $ib->tgl_cek }}</td>
              @endif
              @if($ib->status == 0)
                <td class="px-4 py-4">
                  @if($ib->status_bunting == 0)
                    Belum Bunting
                  @else
                    Bunting
                  @endif
                </td>
              @else
                <td class="px-4 py-4">{{ $ib->status_bunting }}</td>
              @endif
              <td class="px-4 py-4">
                <a id="trigger2" class="" data-index="{{ $index + 1 }}" data-laporan="{{ $ib->id }}">
                  <img src="{{ asset('assets/icon/view.svg') }}" alt="View" class="h-5 w-5">
                </a>
              </td>
            </tr>
            <div class="modal2 hidden  2xl:top-60 z-1 w-[30%] h-80 fixed left-[40%] top-48 bg-white rounded-3xl shadow-xl 2xl:h-96">
              <span class="close-button2 cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
              <div class="container-modal2 flex flex-col justify-center items-center">
                  <form id="form-modal" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <p class="text-xl font-bold text-center text-[#427D9D]">Tambah Laporan Inseminasi</p>
                    <div class="total-container flex flex-col text-center mt-5 items-center 2xl:gap-2">
                        <label for="tanggalCek">Tanggal Cek</label>
                        <input type="date" name="tanggalCek" class="w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-sm">
                        <label for="jenisSemen" class="mt-4">Status Bunting</label>
                        <select name="statusBunting" id="statusBunting" class="w-[60%] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
                            <option value="0">Belum Bunting</option>
                            <option value="1">Bunting</option>
                        </select>
                        <input type="hidden" name="laporanId" id="" value="{{ $ib->id }}">
                    </div>
                    <div class="button-container2 mt-3 flex justify-center">
                        <button type="submit"
                            class="bg-[#427D9D] text-white px-5 py-2 rounded-xl w-[20rem] mt-3 2xl:py-3">Submit</button>
                    </div>
                  </form>
              </div>
            </div>
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
</div>
 {{-- --}}
<div class="modal hidden z-1 w-[30%] h-80 fixed left-[40%] top-48 bg-white rounded-3xl shadow-xl">
  <span class="close-button cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
  <div class="container-modal flex flex-col justify-center items-center">
      <form action="" method="POST">
          @csrf
          <p class="text-xl font-bold text-center text-[#427D9D]">Tambah Laporan Inseminasi</p>
          <div class="total-container flex flex-col text-center mt-5 items-center 2xl:gap-3">
              <label for="tanggalIB">Tanggal IB</label>
              <input type="date" name="tanggalIB" class="w-[334px] bg-[#F1F1F1] border-transparent rounded-xl text-sm">
              <label for="jenisSemen" class="mt-4">Jenis Semen</label>
              <select name="jenisSemen" id="jenisSemen" class="input-regist2 w-[40%] bg-[#F1F1F1] border-transparent rounded-xl text-[#888888]">
                @foreach ($jenisSemen as $item)
                  <option value="{{ $item->id }}">{{ $item->jenis_semen }}</option>
                @endforeach
              </select>
          </div>
          <div class="button-container mt-3 flex justify-center">
              <button type="submit"
                  class="bg-[#427D9D] text-white px-5 py-2 rounded-xl w-[20rem] mt-3 2xl:py-3">Submit</button>
          </div>
      </form>
  </div>
</div>
<script>
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

  const triggerButton2 = document.querySelectorAll('#trigger2');
  const modal2 = document.querySelectorAll('.modal2');
  const closeButton2 = document.querySelectorAll('.close-button2');

  triggerButton2.forEach((element, index) => {
    element.addEventListener('click', function() {
      modal2[index].style.display = 'block';
      // document.querySelectorAll('body > *:not(.modal2)').forEach(element => {
      //     element.style.filter = 'blur(5px)';
      // });
    });
  });

  closeButton2.forEach((element, index) => {
    element.addEventListener('click', function() {
      modal2[index].style.display = 'none';
      // document.querySelectorAll('body > *:not(.modal2)').forEach(element => {
      //     element.style.filter = 'none';
      // });
    });
  });
</script>
@endsection