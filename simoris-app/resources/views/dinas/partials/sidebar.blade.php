<aside class="flex flex-col w-[15vw] shadow-lg fixed top-0 bg-white h-screen rounded-r-3xl gap-5 items-center">
  <div class="menu-container flex flex-col mt-20 text-center gap-5">
    <a href="/dashboard/" class="p-1 bg-black text-white {{ ($title === "Dashboard") ? 'bg-slate-200 text-slate-900' : '' }}"><button>Monitoring Distribusi</button></a>
    <a href="/dashboard/riwayat" class="p-1 bg-black text-white {{ ($title === "Riwayat Stok") ? 'bg-slate-200 text-slate-900' : '' }}"><button>Riwayat Distribusi</button></a>
    <a class="p-1 bg-black text-white {{ ($title === "Ubah Password") ? 'bg-slate-200 text-slate-900' : '' }}" href="/dashboard/changepass"><button>Ubah Password</button></a>
    <form action="/logout" method="POST">
      @csrf
      <button class="p-1 bg-black text-white" type="submit">Logout</button>
    </form> 
  </div>
</aside>  