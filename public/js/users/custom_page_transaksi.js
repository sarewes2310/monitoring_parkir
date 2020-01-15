menu_bar_active = '#menu_transaksi';

function getID(id, nama, url, tempat_parkir){
    $('#id').val(id);
    $('#namePengguna').html(nama);
    $('#nama_pengguna').val(nama);
    $('#tempatparkir_id').val(tempat_parkir);
    $('#tampilFoto').attr("src", url);
    //console.log($('#idHapusData').val());
    //console.log($('#nameHapusData').val());
}

$("#foto").on('change', function(){
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
});