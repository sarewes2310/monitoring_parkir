menu_bar_active = '#menu_pegawai';

var socket = io('http://localhost:6147');

socket.on('callback_rfid_uuid',function(data){
    console.log(data);
    $('#i_cid').val(data);
});

function getRFID(){
    socket.emit('get_rfid_uuid');
}

function getID(id, nama){
    $('#idHapusData').val(id);
    $('#nameHapusData').val(nama);
    $('#namaMaha').html(nama);
    //console.log($('#idHapusData').val());
    //console.log($('#nameHapusData').val());
}

$("#foto").on('change', function(){
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
});