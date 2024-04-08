<aside class="flex flex-col w-[20vw] shadow-lg fixed top-0 bg-white h-screen rounded-r-3xl gap-5 items-center">
  <div class="logo flex flex-row mt-5 shadow[2px_0_2px_0_rgba(0,0,0,0.1)]">
    <img class="h-16 w-16" src="{{ asset('assets/logo-simoris.png') }}" alt="Logo Simoris">
    <div class="text">
      <p class="text-[#164863] font-extrabold text-[40px]">SIMORIS</p>
      <p class="-mt-3 text-[10px]">Sistem Monitoring Distribusi Semen Beku</p>
    </div>
  </div>
  <div class="menu-container flex flex-col text-[15px] font-semibold mt-10 gap-5">
    <a href="/dashboard/" class="rounded-xl px-12 py-3 text-[#164863] hover:bg-[#C6F2FF] {{ ($title === "Dashboard") ? 'bg-[#C6F2FF]' : '' }}"><button>Monitoring Distribusi</button></a>
    <a href="/dashboard/riwayat" class="rounded-xl px-12 py-3 text-[#164863] hover:bg-[#C6F2FF] {{ ($title === "Riwayat Stok") ? 'bg-[#C6F2FF]' : '' }}"><button>Riwayat Distribusi</button></a>
    <a class="rounded-xl px-12 py-3 text-[#164863] hover:bg-[#C6F2FF] {{ ($title === "Ubah Password") ? 'bg-[#C6F2FF]' : '' }}" href=""><button>Riwayat Pengajuan</button></a>
    <a class="rounded-xl px-12 py-3 text-[#164863] hover:bg-[#C6F2FF] {{ ($title === "Ubah Password") ? 'bg-[#C6F2FF]' : '' }}" href=""><button>Verifikasi Pengajuan</button></a>
    <a class="rounded-xl px-12 py-3 text-[#164863] hover:bg-[#C6F2FF] {{ ($title === "Ubah Password") ? 'bg-[#C6F2FF]' : '' }}" href=""><button>Data Mantri</button></a>
  </div>
  <div id="profile" class="profile flex mt-[150px] cursor-pointer h-24 w-full">
    <img class="h-10 w-10 rounded-full ml-3" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT51WzyjFs7ajVLdsDpsea3951e-iN4zWqyOWskJ7Woyw&s" alt="profile" class="w-20 h-20 rounded-full">
    <div class="text ml-2">
      <p class="font-bold text-[13px]">Dinas Peternakan Jember</p>
      <p class="text-xs">{{ Auth::user()->email }}</p>
    </div>
    <img class="w-7 h-7 mt-1 ml-1 hover:scale-110" src="https://img.icons8.com/windows/32/settings--v1.png" alt="settings--v1"/>
  </div>
  <div id="tooltip" class="invisible w-20 absolute bottom-16 left-[180px] p-2 bg rounded-xl shadow-[0_2px_2px_0_rgba(0,0,0,0.1)]">
    <div id="child" class="child">
      <a href="/dashboard/changepass" class="font-semibold hover:text-slate-600">Profile</a>
      <form action="/logout" method="POST">
        @csrf
        <button class="" type="submit"><p class="font-semibold text-red-700 hover:text-red-400">Logout</p></button>
      </form> 
    </div>
  </div>
</aside>
<script>
    document.getElementById('profile').onclick = function() {
      document.getElementById('tooltip').classList.toggle('invisible')};
</script> 