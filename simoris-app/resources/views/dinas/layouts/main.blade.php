@extends('dinas.layouts.dashboard')
@vite('resources/js/map.js')

@section('content')
    <div class="content-container relative w-[85vw] bg-[#DDF2FD] flex flex-col items-center h-full ml-[20vw]">

        <div id="map" class="absolute top-14 right-14 2xl:right-20 w-[88%] h-[300px]"></div>

        <button id="trigger"
            class="p-1 mt-5 bg-[#427D9D] text-white w-[150px] font-semibold absolute right-20 top-96 2xl:top-[20vw] rounded-xl text-center input-stok">+
            Tambah Stok
        </button>
        <div class="justify-center items-center flex flex-col mt-96 bg-white rounded-2xl w-[70vw] ml-6 2xl:text-lg">
            <div class="text flex flex-row mt-5 w-full justify-start ml-10">
                <p class="font-bold text-slate-700 mt-1 2xl:text-xl">Data Stok Semen Beku</p>
                <input id="search-kecamatan" type="text"
                    class="search-kecamatan p-1 rounded-full ml-14 w-96 bg-gray-200 border border-transparent"
                    placeholder=" Cari Kecamatan....">
            </div>
            <table class="mt-5 cursor-pointer rounded-xl w-full table-size">
                <thead class="rounded-xl">
                    <tr class=" text-gray-700 rounded-xl bg-gray-200">
                        <th scope="col" class="px-2 py-2 font-medium">No</th>
                        <th scope="col" class="px-2 py-2 font-medium">Kecamatan</th>
                        <th scope="col" class="px-2 py-2 font-medium">Total Stok</th>
                        <th scope="col" class="px-2 py-2 font-medium">Sisa Stok</th>
                        <th scope="col" class="px-2 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        @if ($item->kecamatan_id == $item->kecamatan['id'])
                            <tr class="text-center clickable-row border-b" data-index="{{ $index }}">
                                <td class="px-4 py-4">{{ $loop->iteration }}.</td>
                                <td class="px-4 py-4">{{ $item->kecamatan['kecamatan'] }}</td>
                                <td class="px-4 py-4" id="mapTotal-{{ $item->kecamatan['kecamatan'] }}" data-total="{{ $item->total_stok }}">{{ $item->total_stok }}</td>
                                <td class="px-4 py-4" id="mapSisa-{{ $item->kecamatan['kecamatan'] }}" data-sisa="{{ $item->sisa_stok }}">{{ $item->sisa_stok }}</td>
                                <td class="px-4 py-4"><button id="drop-{{ $index }}"
                                        class="bg-[#9BBEC8] rounded-xl text-white px-1">></button>
                                </td>
                            </tr>
                            @foreach ($subdata as $subIndex => $subItem)
                                @if ($subItem->kecamatan_id == $item->kecamatan_id)
                                    <tr id="sub-table-{{ $index }}-{{ $subIndex }}"
                                        class="hidden text-center sub-table bg-gray-200 border-b border-gray-300"
                                        data-index={{ $subIndex }}>
                                        <td id="child-{{ $index }}" class="px-2 py-2"></td>
                                        <td id="child-{{ $index }}" class="px-2 py-2">
                                            {{ $subItem->jenis_sapi['jenis_semen'] }}</td>
                                        <td id="child-{{ $index }}" class="px-2 py-2">{{ $subItem->jumlah }}</td>
                                        <td id="child-{{ $index }}" class="px-2 py-2">{{ $subItem->sisa_stok }}
                                        </td>
                                        <td class="px-4 py-4"></td>
                                    </tr>
                                    @foreach($batch as $batchIndex => $batchItem)
                                        @if($batchIndex == $subIndex && $batchItem->kecamatan_id == $item->kecamatan_id)
                                            <tr id="batch-{{ $subIndex }}" class="hidden text-center batch-row bg-gray-100 border-b">
                                                <td class="px-2 py-2" colspan="2">IB-{{ \Carbon\Carbon::parse($previousPeriod)->format('dmY') }} : {{ $batchItem->sisa_stok }}</td>
                                                <td class="px-2 py-2" colspan="3">IB-{{ \Carbon\Carbon::parse($latestPeriod)->format('dmY') }} : {{ $subItem->jumlah - $batchItem->sisa_stok }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal hidden z-1 w-[500px] h-96 fixed left-[35%] top-40 bg-white rounded-3xl shadow-xl">
        <span class="close-button cursor-pointer font-bold text-2xl rounded-full ml-3">&times;</span>
        <div class="container-modal flex flex-col justify-center items-center">
            <form action="" method="POST">
                @csrf
                <p class="text-xl font-bold text-center text-[#427D9D]">Tambah Stok</p>
                <div class="total-container flex flex-col text-center mt-5">
                    <label for="total_stok" class="">Total Stok</label>
                    <input type="text" name="total_stok" id="total_stok"
                        class="w-[450px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
                </div>
                <div class="jenis-container mt-5 flex flex-row gap-3">
                    <div class="Simental text-center flex flex-col">
                        <label for="Simental">Simental</label>
                        <input type="text" name="Simental" id="Simental"
                            class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
                    </div>
                    <div class="PO text-center flex flex-col">
                        <label for="PO">PO</label>
                        <input type="text" name="PO" id="PO"
                            class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
                    </div>
                    <div class="Brahma text-center flex flex-col">
                        <label for="Brahma">Brahma</label>
                        <input type="text" name="Brahma" id="Brahma"
                            class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
                    </div>
                    <div class="Limosin text-center flex flex-col">
                        <label for="Limosin">Limosin</label>
                        <input type="text" name="Limosin" id="Limosin"
                            class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
                    </div>
                </div>

                <div class="sisa-stok mt-5 flex flex-row gap-3">
                    @foreach ($latestSisa as $sisa)
                        <div class="text-center flex flex-row">
                            <input value="{{ $sisa->sisa_stok }}" readonly type="text"
                                name="sisa-{{ $sisa->jenis_semen_id }}"
                                class="w-[100px] h-10 rounded-xl bg-gray-200 border-transparent text-center">
                        </div>
                    @endforeach
                </div>

                <div class="button-container mt-3 flex justify-center">
                    <button type="submit"
                        class="bg-[#427D9D] text-white px-5 py-2 rounded-xl w-[300px] mt-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        var toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(function(toastElement) {
            toastElement.classList.add('toaster-error');
        });

        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                const subTables = document.querySelectorAll(`tr[id^="sub-table-${index}-"]`);
                subTables.forEach(subTable => {
                    subTable.classList.toggle('hidden');
                });
                
                document.getElementById(`drop-${index}`).innerText = document.getElementById(
                    `drop-${index}`).innerText === '>' ? 'v' : '>';
            });
        });

        document.querySelectorAll('.sub-table').forEach(row => {
            row.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                const batchs = document.querySelectorAll(`#batch-${index}`);
                batchs.forEach(batch => {
                    batch.classList.toggle('hidden');
                });
            });
        });

        const searchInput = document.getElementById('search-kecamatan');

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
