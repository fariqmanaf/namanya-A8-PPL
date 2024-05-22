@extends('mantri.layouts.index')

@section('content')
<div class="container w-[85vw] bg-[#DDF2FD] flex flex-col h-full ml-[20vw] mt-[8vh]">
  <div class="content-container flex flex-col ml-28 w-[80%] h-auto">
    <p class="font-bold text-xl text-[#164863] mb-8 2xl:text-2xl">Pending</p>

    @foreach($pending as $p)
      <div class="flex flex-row justify-between items-center bg-white px-4 py-2 mb-4 rounded-2xl">
        <div class="flex flex-col">
          <div class="text text-md p-1 flex-row flex gap-5">
            <p>Tanggal 
              <span class="font-semibold">
                {{ $p->tanggal}}
              </span>
            </p>
            <p class="px-1 -mt-1 w-20 text-sm py-1 rounded-full text-white font-semibold bg-[#FFAF38] text-center">Pending</p>
          </div>
          <div class="jenis text-md p-1 flex-row flex gap-3">
            <p class="mr-2">Total <span class="font-semibold mr-3">{{ $p->total }}</span>|</p>
            @foreach($p->detailPengajuan as $detail)
              <p class="mr-2">{{ $detail->jenisSemen['jenis_semen'] }} <span class="font-semibold mr-3">{{ $detail->jumlah }}</span>|</p>
            @endforeach
          </div>
        </div>
        <div class="icon">
          <a class="cursor-pointer" id="trigger">
            <img src="{{ asset('/assets/outline/pen.svg') }}" class="h-8 w-8 p-2 bg-[#427D9D] rounded-xl" alt="pen">
          </a>
        </div>
      </div>
      <div class="modal hidden z-1 w-[40%] h-[24rem] fixed left-[35%] 2xl:left-[40%] top-40 bg-white rounded-3xl shadow-xl">
        <span class="close-button cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
        <div class="container-modal flex flex-col justify-center items-center">
          <form action="" method="POST">
            @csrf
            <input type="hidden" name="pengajuan_id" value="{{ $p->id }}">
            <p class="text-xl font-bold text-center text-[#427D9D]">Edit Ajukan Stok</p>
            <div class="total-container flex flex-col text-center mt-5">
                <label for="total_stok" class="">Total Stok</label>
                <input type="text" name="total_stok" id="total_stok"
                    class="w-[450px] h-10 rounded-xl bg-gray-200 border-transparent text-center"
                    value="{{ $p->total }}">
            </div>
            <div class="jenis-container mt-5 2xl:mt-6 flex flex-row gap-3">
                <div class="Simental text-center flex flex-col">
                    <label for="Simental">Simental</label>
                    <input type="text" name="Simental" id="Simental"
                        class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center" value="{{ $p->detailPengajuan[0]['jumlah'] }}">
                </div>
                <div class="PO text-center flex flex-col">
                    <label for="PO">PO</label>
                    <input type="text" name="PO" id="PO"
                        class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center" value="{{ $p->detailPengajuan[1]['jumlah'] }}">
                </div>
                <div class="Brahma text-center flex flex-col">
                    <label for="Brahma">Brahma</label>
                    <input type="text" name="Brahma" id="Brahma"
                        class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center" value="{{ $p->detailPengajuan[2]['jumlah'] }}">
                </div>
                <div class="Limosin text-center flex flex-col">
                    <label for="Limosin">Limosin</label>
                    <input type="text" name="Limosin" id="Limosin"
                        class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center" value="{{ $p->detailPengajuan[3]['jumlah'] }}">
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
    @endforeach
    
    <p class="font-bold text-xl text-[#164863] mb-8 mt-4 2xl:text-2xl">Riwayat</p>

    @foreach($notPending as $riwayat)
      <div class="flex flex-row justify-between items-center bg-white px-4 py-2 mb-4 rounded-2xl">
        <div class="flex flex-col">
          <div class="text text-md p-1 flex-row flex gap-5">
            <p>Tanggal <span class="font-semibold">{{ $riwayat->tanggal }}</span></p>
            @if($riwayat->is_confirmed == 1)
              <p class="px-1 -mt-1 w-20 text-sm py-1 rounded-full text-white font-semibold bg-[#4CAF50] text-center">Diterima</p>
            @elseif($riwayat->is_confirmed == 2)
              <p class="px-1 -mt-1 w-20 text-sm py-1 rounded-full text-white font-semibold bg-[#F44336] text-center">Ditolak</p>
            @endif
          </div>
          <div class="jenis text-md p-1 flex-row flex gap-3">
            <p class="">Total <span class="font-semibold mr-3">{{ $riwayat->total }}</span>|</p>
            @foreach($riwayat->detailPengajuan as $detailNotPending)
              <p class="">{{ $detailNotPending->jenisSemen['jenis_semen'] }}<span class="font-semibold mr-3 ml-2">{{ $detailNotPending->jumlah }}</span>|</p>
            @endforeach
          </div>
        </div>
      </div>
    @endforeach

  </div>
</div>
<script>
  const trigger = document.querySelectorAll('#trigger');
  const modal = document.querySelectorAll('.modal');
  const closeButton = document.querySelectorAll('.close-button');

  trigger.forEach((t, index) => {
    t.addEventListener('click', () => {
      modal[index].classList.remove('hidden');
    });
  });

  closeButton.forEach((c, index) => {
    c.addEventListener('click', () => {
      modal[index].classList.add('hidden');
    });
  });
</script>
@endsection