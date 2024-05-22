@extends('dinas.layouts.dashboard')

@section('content')
<div class="content-container w-[70vw] bg-[#DDF2FD] flex flex-col items-center h-100vh ml-[25vw] mt-16">
  <p class="w-full mb-14 text-center text-2xl font-bold text-[#427D9D]">Grafik Keberhasilan Inseminasi Buatan</p>
  <div class="graphContainer w-[80%] bg-white shadow-xl p-4 rounded-2xl">
    <canvas id="myChart"></canvas>
  </div>
  @foreach($akumulasi as $x => $data)
    <p id="triwulan-{{ $x }}" data-triwulan="{{ json_encode($data) }}" class="hidden"></p>
  @endforeach
  <div class="year mt-10 ">
    <form id="yearForm" action="{{ route('akumulasi') }}" method="GET">
      <select name="tahun" id="tahun" class="input-regist2 text-sm w-[334px] bg-white border-gray-700 rounded-xl" onchange="submitForm()">
        @foreach ($years as $year)
          <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
        @endforeach
      </select>
    </form>
  </div>
</div>
<script>
  function submitForm() {
      const selectElement = document.getElementById('tahun');
      const form = document.getElementById('yearForm');
      const selectedYear = selectElement.value;
      const baseUrl = "{{ url('dashboard/akumulasi') }}";
      form.action = `${baseUrl}/${selectedYear}`;
      form.submit();
  }

  const ctx = document.getElementById('myChart').getContext('2d');
  const dataElements = document.querySelectorAll('[data-triwulan]');
  const dataTriwulan = [];
  dataElements.forEach((item) => {
    dataTriwulan.push(JSON.parse(item.dataset.triwulan));
  });

  const limosinData = dataTriwulan.map(item => item[0]);
  const poData = dataTriwulan.map(item => item[1]);
  const brahmanData = dataTriwulan.map(item => item[2]);
  const simentalData = dataTriwulan.map(item => item[3]);

  new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['1', '2', '3', '4'],
          datasets: [
            {
              label: 'Limosin',
              data: limosinData,
              borderColor: 'blue',
              backgroundColor: 'blue',
              fill: false
            },
            {
              label: 'Simental',
              data: poData,
              borderColor: 'red',
              backgroundColor: 'red',
              fill: false
            },
            {
              label: 'Brahman',
              data: brahmanData,
              borderColor: 'yellow',
              backgroundColor: 'yellow',
              fill: false
            },
            {
              label: 'PO',
              data: simentalData,
              borderColor: 'green',
              backgroundColor: 'green',
              fill: false
            }
          ]
      },
      options: {
          scales: {
              x: {
                  title: {
                      display: true,
                      text: 'Triwulan'
                  }
              },
              y: {
                  title: {
                      display: true,
                      text: 'Inseminasi Berhasil'
                  }
              }
          }
      }
  });
</script>
@endsection
