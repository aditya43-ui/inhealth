<?php
/**
* - digunakan sebagai url utuk :
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>

<script type="text/javascript">
function hitungHarga() {
    var hargacuci = parseFloat(unformatNumber(($('#TerimapencucianlinenumumT_hargacuci').val())));
    var berat = parseFloat(unformatNumber(($('#TerimapencucianlinenumumT_berat').val())));

    $("#TerimapencucianlinenumumT_harga").val(formatFloat2(hargacuci * berat));
}
/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
});
</script>