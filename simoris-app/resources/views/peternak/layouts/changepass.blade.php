<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Ubah Password</title>
  @vite('resources/css/app.css')
  <style>*{margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif}html{height: 100%};@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');</style>
</head>
<body class="flex flex-col h-screen bg-[#DDF2FD] items-center justify-center">
  @if($errors->any())
    <div class="alert absolute top-10 left-10 w-60 text-sm bg-red-500 text-white rounded-xl">
      <ul>
        @foreach($errors->all() as $error)
        <li class="mb-2 ml-2">{{ "- ".$error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if(session()->has('success'))
    <div class="p-1 alert absolute top-10 left-10 w-60 text-sm bg-green-500 text-white rounded-xl">
      {{ session('success') }}
    </div>
  @endif
  <a href="/main/profile" class="-ml-[400px] mb-3 font-semibold text-slate-600 2xl:-ml-[500px]">< Kembali</a>
  <div class="form-container flex flex-col bg-white h-[550px] w-[500px] justify-start items-center rounded-2xl shadow-xl">
    <p class="text-center font-bold text-xl my-8">PROFIL</p>
    <img src="https://www.freeiconspng.com/thumbs/profile-icon-png/profile-icon-9.png" alt="Logo Profil" class="h-36 w-36 rounded-full mb-5">
    <p class="font-semibold mb-5 text-sm 2xl:text-lg">{{ $name->name }}</p>
    <p class="-ml-[300px] text-sm mb-2 2xl:text-lg 2xl:-ml-[350px]">Password</p>
    <p id="button" class="button-pw w-96 shadow-[2px_2px_2px_2px_rgba(0,0,0,0.2)] p-2 rounded-full text-sm flex justify-between cursor-pointer">Ubah Password <span>></span></p>
    <form action="" method="post" class="flex justify-center flex-col items-center">
      @method('PUT')
      @csrf
      <input id="input1" name="old_password" class="invisible w-96 -mt-[38px] rounded-full text-sm my-3 2xl:w-[450px] 2xl:text-lg" type="password" placeholder="Masukkan Password lama">
      <input id="input2" type="password" class="invisible w-96 -mt-[50px] rounded-full text-sm 2xl:w-[450px] 2xl:text-lg" name="new_password" placeholder="Masukkan Password Baru">
      <button id="input3" type="submit" class="invisible p-1 w-40 mt-8 bg-[#DDF2FD] rounded-full text-slate-600 text-sm 2xl:p-2">Simpan</button>
    </form>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script>
  const trigger = document.getElementById('button');
  const input1 = document.getElementById('input1');
  const input2 = document.getElementById('input2');
  const input3 = document.getElementById('input3');

  let isVisible = false;

  trigger.onclick = () => {
    if (isVisible === false) {
      gsap.to(input1, { duration: 0.5, y: 50, ease: 'power2.inOut', visibility: 'visible' });
      gsap.to(input2, { duration: 0.5, y: 100, ease: 'power2.inOut', visibility: 'visible'});
      gsap.to(input3, { duration: 0.5, y: 85, ease: 'power2.inOut', visibility: 'visible'});
      isVisible = true;
    } else {
      gsap.to(input1, { duration: 0.5, y: 0, ease: 'power2.inOut', visibility: 'hidden' });
      gsap.to(input2, { duration: 0.5, y: 0, ease: 'power2.inOut', visibility: 'hidden'});
      gsap.to(input3, { duration: 0.5, y: 0, ease: 'power2.inOut', visibility: 'hidden'});
      isVisible = false;
    }
  }
</script>
</html>