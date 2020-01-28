menu_bar_active = '#menu_dashboard';

function getID(data, nama, tipe) 
{
    if(tipe == 1)
    {
        $('#idVerifData').val(data);
        $('#nameVerifData').val(nama);
        $('#nameadmin').html(nama);
    }else
    {
        $('#idHapusData').val(data);
        $('#nameHapusData').val(nama);
        //console.log($('#idHapusData').val());
        //console.log($('#nameHapusData').val());
    }
}