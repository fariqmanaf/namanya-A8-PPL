<aside class="flex flex-col w-[20vw] shadow-lg fixed top-0 bg-white h-screen rounded-r-3xl gap-5 items-center">
  <div class="logo flex flex-row mt-5 shadow[2px_0_2px_0_rgba(0,0,0,0.1)]">
    <img class="h-16 w-16" src="{{ asset('assets/logo-simoris.png') }}" alt="Logo Simoris">
    <div class="text">
      <p class="text-[#164863] font-extrabold text-[40px]">SIMORIS</p>
      <p class="-mt-3 text-[10px]">Sistem Monitoring Distribusi Semen Beku</p>
    </div>
  </div>
  <div class="menu-container w-full flex flex-col items-center font-semibold mt-10 gap-5">
    <a href="/main" class="menu-1 w-[90%] flex menu rounded-xl px-12 py-3 2xl:py-5 text-[#164863] hover:bg-[#C6F2FF] {{ ($title === "Beranda") ? 'bg-[#C6F2FF]' : '' }}">
      <img class="-ml-8 mr-3 w-5 h-5 2xl:w-8 2xl:h-8" src="{{asset('/assets/outline/home-o.svg')}}">
      <span class="w-full text-[14px] 2xl:text-lg">Beranda</span>
    </a>
    <a href="/main/data-mantri" class="menu-2 w-[90%] flex menu rounded-xl px-12 py-3 2xl:py-5 text-[#164863] hover:bg-[#C6F2FF] {{ ($title === "Daftar Mantri") ? 'bg-[#C6F2FF]' : '' }}">
      <img class="-ml-8 mr-3 w-5 h-5 2xl:w-8 2xl:h-8" src="{{asset('/assets/outline/people-o.svg')}}">
      <span class="w-full text-[14px] 2xl:text-lg">Daftar Mantri</span>
    </a>
    <a href="/main/laporan-ib" class="menu-3 w-[90%] flex menu rounded-xl px-12 py-3 2xl:py-5 text-[#0d1e27] hover:bg-[#C6F2FF] {{ ($title === "Laporan IB") ? 'bg-[#C6F2FF]' : '' }}">
      <img class="-ml-8 mr-3 w-5 h-5 2xl:w-8 2xl:h-8" src="{{asset('/assets/outline/document-o.svg')}}">
      <span class="w-full text-[14px] 2xl:text-lg">Laporan Inseminasi</span>
    </a>
  </div>
  <div id="profile" class="profile flex absolute bottom-0 cursor-pointer mb-5 w-full">
    <img class="dinas h-10 w-10 rounded-full ml-3" src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="profile">
    <div class="text ml-2">
      <p class="font-bold text-[13px] 2xl:text-base">{{ Auth::user()->individual['name'] }}</p>
      <p class="text-xs 2xl:text-base">{{ Str::limit(Auth::user()->email, 22, '...') }}</p>
    </div>
    <img class="w-7 h-7 mt-1 relative ml-6 right-0  hover:scale-110 2xl:w-10 2xl:h-10 2xl:ml-10" src="https://img.icons8.com/windows/32/settings--v1.png" alt="settings--v1"/>
  </div>
  <div id="tooltip" class="tooltip invisible w-20 absolute bottom-16 left-[180px] p-2 bg rounded-xl shadow-[0_2px_2px_0_rgba(0,0,0,0.1)]">
    <div id="child" class="child">
      <a href="/main/profile" class="font-semibold hover:text-slate-600 2xl:text-xl">Profile</a>
      <form action="/logout" method="POST">
        @csrf
        <button class="" type="submit"><p class="font-semibold text-red-700 hover:text-red-400 2xl:text-xl">Logout</p></button>
      </form> 
    </div>
  </div>
</aside>
<script>
    document.getElementById('profile').onclick = function() {
      document.getElementById('tooltip').classList.toggle('invisible')};
</script> 