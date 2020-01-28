menu_bar_active = '#menu_alatparkir';

function getID(id, nama){
    $('#idHapusData').val(id);
    $('#nameHapusData').val(nama);
    $('#namaTempatParkir').html(nama);
    //console.log($('#idHapusData').val());
    //console.log($('#nameHapusData').val());
}

$("#foto").on('change', function(){
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
});