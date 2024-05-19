@extends('dinas.layouts.dashboard')

@section('content')
<div class="content-container w-[70vw] bg-[#DDF2FD] flex flex-col h-full ml-[22vw] mt-10">
  <div class="buttonSwap ml-6 font-semibold mb-6">
    <a href="#"><button id="button1" class="p-1 py-2 w-40 text-white bg-[#427D9D] shadow-md rounded-2xl">Pending</button></a>
    <a href="/dashboard/pengajuan-stok/pengambilan"><button id="button2" class="p-1 -ml-6 py-2 hover:bg-gray-200 w-40 bg-white shadow-md rounded-2xl">Pengambilan</button></a>
    <a href="/dashboard/pengajuan-stok/confirmed"><button id="button3" class="p-1 -ml-5 py-2 hover:bg-gray-200 w-40 bg-white shadow-md rounded-2xl">Disetujui</button></a>
    <a href="/dashboard/pengajuan-stok/rejected"><button id="button4" class="p-1 -ml-6 py-2 hover:bg-gray-200 w-40 bg-white shadow-md rounded-2xl">Ditolak</button></a>
  </div>
  <div class="pendingContent">
    @foreach($pending as $p)
        <div class="flex flex-row justify-between items-center bg-white px-4 py-2 mb-4 ml-6 rounded-2xl" data-id="{{ $p->id }}">
          <div class="content flex flex-row items-center gap-4">
            <div class="pp">
              <img src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="Logo Dinas" class="h-10 w-10 rounded-full border border-gray-400">
            </div>
            <div class="flex flex-col">
              <div class="text text-md p-1 flex-row flex gap-5">
                <div class="nama">
                  <p class="font-semibold">{{ $p->individuals['name'] }}</p>
                  <p class="font-medium text-sm text-gray-500">{{ $p->individuals->wilayah_kerja[0]->kecamatan['kecamatan'] }}</p>
                </div>
                <p class="text-sm">Tanggal <span class="font-semibold">{{ $p->tanggal }}</span></p>
                <p class="px-1 w-20 h-6 text-sm rounded-full text-white font-semibold bg-[#FFAF38] text-center">Pending</p>
              </div>
              <div class="jenis text-md p-1 flex-row flex gap-3">
                <p class="mr-2">Total 
                  <span class="font-semibold mr-3">
                    {{ $p->total }}
                  </span>|
                </p>
                @foreach($p->detailPengajuan as $detail)
                  <p class="mr-2">{{ $detail->jenisSemen['jenis_semen'] }} 
                    <span class="font-semibold mr-3">
                      {{ $detail->jumlah }}
                    </span>|
                  </p>
                @endforeach
              </div>
            </div>
          </div>
          <div class="icon flex flex-row">
            <a class="cursor-pointer" id="reject" data-index="{{ $p->id }}">
              <img src="{{ asset('/assets/reject.svg') }}" class="h-12 w-12 p-2 rounded-xl" alt="pen">
            </a>
            <a class="cursor-pointer" id="accept" data-index="{{ $p->id }}">
              <img src="{{ asset('/assets/accept.svg') }}" class="h-12 w-12 p-2 rounded-xl" alt="pen">
            </a>
          </div>
        </div>

        <div id="modal-accept-{{ $p->id }}" class="modal-accept p-6 hidden z-1 fixed left-[50%] top-[40%] bg-white shadow-xl rounded-3xl">
          <h1 class="text-xl font-semibold text-center text-[#427D9D]">Konfirmasi Pengajuan</h1>
          <div class="flex flex-row justify-center gap-6 mt-4">
            <button id="tidak1" class="p-2 w-24 px-4 bg-red-400 text-white rounded-2xl">Tidak</button>
            <form action="" method="POST">
              @csrf
              <input type="hidden" name="action" value="accept">
              @foreach($p->detailPengajuan as $detail)
                <input type="hidden" name="jenis-acc-{{ $loop->iteration }}" value="{{ $detail->jumlah }}">
              @endforeach
              <input type="hidden" name="userAcc" value="{{ $p->individuals_id }}">
              <input type="hidden" name="idAcc" value="{{ $p->id }}">
              <button id="iya1" type="submit" class="p-2 w-24 px-4 bg-green-400 text-white rounded-2xl">Iya</button>
            </form>
          </div>
        </div>

        <div id="modal-reject-{{ $p->id }}"  class="modal-reject p-6 hidden z-1 fixed left-[50%] top-[40%] bg-white shadow-xl rounded-3xl">
            <h1 class="text-xl font-semibold text-center text-[#427D9D]">Tolak Pengajuan</h1>
            <div class="flex flex-row justify-center gap-6 mt-4">
              <button id="tidak2" class="p-2 w-24 px-4 bg-red-400 text-white rounded-2xl">Tidak</button>
              <form action="" method="POST">
                @csrf
                <input type="hidden" name="action" value="reject">
                <input type="hidden" name="userReject" value="{{ $p->individuals_id }}">
                <input type="hidden" name="idReject" value="{{ $p->id }}">
                <button id="iya2" type="submit" class="p-2 w-24 px-4 bg-green-400 text-white rounded-2xl">Iya</button>
              </form>
            </div>
        </div>
    @endforeach
  </div>
</div>
<script>
  const accept = document.querySelectorAll('#accept');
  const reject = document.querySelectorAll('#reject');
  const modalAccept = document.querySelectorAll('.modal-accept');
  const modalReject = document.querySelectorAll('.modal-reject');
  const iya1 = document.querySelectorAll('#iya1');
  const iya2 = document.querySelectorAll('#iya2');
  const tidak1 = document.querySelectorAll('#tidak1');
  const tidak2 = document.querySelectorAll('#tidak2');

  accept.forEach((btn) => {
    btn.addEventListener('click', () => {
      const index = btn.getAttribute('data-index');
      modalAccept.forEach((modal) => {
        if (modal.id === `modal-accept-${index}`) {
          modal.classList.remove('hidden');
        }
      });
    });
  });

  reject.forEach((btn) => {
    btn.addEventListener('click', () => {
      const index = btn.getAttribute('data-index');
      modalReject.forEach((modal) => {
        if (modal.id === `modal-reject-${index}`) {
          modal.classList.remove('hidden');
        }
      });
    });
  });

  tidak1.forEach((btn) => {
    btn.addEventListener('click', () => {
      modalAccept.forEach((modal) => {
        modal.classList.add('hidden');
      });
    });
  });

  tidak2.forEach((btn) => {
    btn.addEventListener('click', () => {
      modalReject.forEach((modal) => {
        modal.classList.add('hidden');
      });
    });
  });
</script>
@endsection