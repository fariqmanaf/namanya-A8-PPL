var map = L.map('map', {
  center: [-8.25, 113.65],
  zoom: 10
}).setView([-8.25, 113.65], 10);

  var jemberData = {
    "type": "Polygon",
    "coordinates": [
        [   [113.26240529, -8.56299345159],
            [114.043418669, -8.56299345159],
            [114.043418669, -7.96827270342],
            [113.26240529, -7.96827270342],
            [113.26240529, -8.56299345159]  ]
    ]};

  L.geoJSON(jemberData).addTo(map);
  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiZnJxbW5mIiwiYSI6ImNsdmVjMnFmMzA3YmYyaW85a3piM3BjbzYifQ.4x3Q-Ik61nDwm6RreXphXQ'
  }).addTo(map);

  const total = [];
  const sisa = [];

  const rowTotal = document.querySelectorAll('tbody tr td[data-total]');
  rowTotal.forEach(rowTotal => {
    const dataTotal = rowTotal.getAttribute('data-total');
    total.push(dataTotal);
  });

  const rowSisa = document.querySelectorAll('tbody tr td[data-sisa]');
  rowSisa.forEach(rowSisa => {
    const dataSisa = rowSisa.getAttribute('data-sisa');
    sisa.push(dataSisa);
  });

  var locations = [
    {coords: [-8.199097423930386, 113.65832360874207], name: 'Ajung', totalStok: total[0], sisaStok: sisa[0]},
    {coords: [-8.327991726815316, 113.60599698775748], name: 'Ambulu', totalStok: total[1], sisaStok: sisa[1]},
    {coords: [-8.092847680226315, 113.74607266997226], name: 'Arjasa', totalStok: total[2], sisaStok: sisa[2]},
    {coords: [-8.081970615789212, 113.75568570698702], name: 'Balung', totalStok: total[3], sisaStok: sisa[3]},
    {coords: [-8.166260166215212, 113.53458585564799], name: 'Bangsalsari', totalStok: total[4], sisaStok: sisa[4]},
    {coords: [-8.298415097160905, 113.38214494897144], name: 'Gumukmas', totalStok: total[5], sisaStok: sisa[5]},
    {coords: [-8.0219781229824, 113.76919615004104], name: 'Jelbuk', totalStok: total[6], sisaStok: sisa[6]},
    {coords: [-8.259628508246594, 113.6238478087111], name: 'Jenggawah', totalStok: total[7], sisaStok: sisa[7]},
    {coords: [-8.228919754410787, 113.33641738091261], name: 'Jombang', totalStok: total[8], sisaStok: sisa[8]},
    {coords: [-8.086658828523639, 113.81165746323855], name: 'Kalisat', totalStok: total[9], sisaStok: sisa[9]},
    {coords: [-8.152945785863071, 113.64507846530987], name: 'Kaliwates', totalStok: total[10], sisaStok: sisa[10]},
    {coords: [-8.245082553707435, 113.36744680209539], name: 'Kencong', totalStok: total[11], sisaStok: sisa[11]},
    {coords: [-8.101210560627424, 113.87371630560413], name: 'Ledokombo', totalStok: total[12], sisaStok: sisa[12]},
    {coords: [-8.18874195089426, 113.78380795467214], name: 'Mayang', totalStok: total[13], sisaStok: sisa[13]},
    {coords: [-8.206290727885495, 113.70713730767544], name: 'Mumbulsari', totalStok: total[14], sisaStok: sisa[14]},
    {coords: [-8.13031244576908, 113.79532618893182], name: 'Pakusari', totalStok: total[15], sisaStok: sisa[15]},
    {coords: [-8.085041936968791, 113.63691282815651], name: 'Panti', totalStok: total[16], sisaStok: sisa[16]},
    {coords: [-8.122228800277833, 113.70877043510613], name: 'Patrang', totalStok: total[17], sisaStok: sisa[17]},
    {coords: [-8.337197856753393, 113.47196695765847], name: 'Puger', totalStok: total[18], sisaStok: sisa[18]},
    {coords: [-8.165878548220709, 113.60751653440438], name: 'Rambipuji', totalStok: total[19], sisaStok: sisa[19]},
    {coords: [-8.182043912054231, 113.4523694284904], name: 'Semboro', totalStok: total[20], sisaStok: sisa[20]},
    {coords: [-8.245082553707435, 113.85248564900537], name: 'Silo', totalStok: total[21], sisaStok: sisa[21]},
    {coords: [-8.123845542402778, 113.67284163163131], name: 'Sukorambi', totalStok: total[22], sisaStok: sisa[22]},
    {coords: [-8.023595266392867, 113.84105375699069], name: 'Sukowono', totalStok: total[23], sisaStok: sisa[23]},
    {coords: [-8.086658828523639, 113.39357684098616], name: 'Sumberbaru', totalStok: total[24], sisaStok: sisa[24]},
    {coords: [-8.037099629736469, 113.90416443419127], name: 'Sumberjambe', totalStok: total[25], sisaStok: sisa[25]},
    {coords: [-8.14994744257269, 113.70641052988803], name: 'Sumbersari', totalStok: total[26], sisaStok: sisa[26]},
    {coords: [-8.15257735679913, 113.46349079008296], name: 'Tanggul', totalStok: total[27], sisaStok: sisa[27]},
    {coords: [-8.386631077113858, 113.72934608541338], name: 'Tempurejo', totalStok: total[28], sisaStok: sisa[28]},
    {coords: [-8.257065307963613, 113.44886710960186], name: 'Umbulsari', totalStok: total[29], sisaStok: sisa[29]},
    {coords: [-8.312151420940431, 113.54858961795017], name: 'Wuluhan', totalStok: total[30], sisaStok: sisa[30]}
  ];
  
  locations.forEach(function(location) {
    var marker = L.marker(location.coords).addTo(map);
    marker.bindPopup("<b>" + location.name + "</b><br>Total Stok : " + location.totalStok + "</b><br>Sisa Stok : " + location.sisaStok).openPopup();
  });