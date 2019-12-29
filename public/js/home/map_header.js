// MAP
var mymap = L.map('mapid').setView([51.505, -0.09], 19);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FyZXdlcyIsImEiOiJjamx2bzRubWkweXpiM3FwZXZ2ZWxxYTZkIn0.acBKDYn4ACmB6R0Fr5Mvjw', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);

// NAVBAR ACTIVE VALUE
menu_bar_active = "#menu_bar_home"