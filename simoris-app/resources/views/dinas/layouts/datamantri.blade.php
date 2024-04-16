@extends('dinas.layouts.dashboard')

@section('content')
  <div class="content-container w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[15vw]">
    <div class="c w-8/12">
      <table class="mt-5 cursor-pointer rounded-xl w-full table-size">
        <thead class="rounded-xl">
          <tr class="text-gray-700 rounded-xl bg-gray-200">
            <th scope="col" class="px-2 py-2 font-medium">Nama</th>
            <th scope="col" class="px-2 py-2 font-medium">Alamat</th>
            <th scope="col" class="px-2 py-2 font-medium">Wilayah Kerja</th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center clickable-row border-b"">
              <td class="px-4 py-4">
                  @foreach($data['dataMantri'] as $mantri)
                      {{ $mantri }} <!-- Atau properti lain yang ingin Anda tampilkan -->
                  @endforeach
              </td>
              {{-- <td class="px-4 py-4">
                  @foreach($data['alamatMantri'] as $alamat)
                      {{ $alamat->alamat_lengkap }} <!-- Atau properti lain yang ingin Anda tampilkan -->
                  @endforeach
              </td>
              <td class="px-4 py-4">
                  @foreach($data['wilayah_kerja'] as $wilayah)
                      {{ $wilayah->nama_kecamatan }} <!-- Atau properti lain yang ingin Anda tampilkan -->
                  @endforeach
              </td> --}}
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection