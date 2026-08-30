<script>

var row = '<?php echo CJSON::encode(array('row'=>$this->renderPartial($this->path_view.'_rowKelKomponen', array('kel'=>null, 'persen'=>0), true))); ?>';

function tambahKelompok()
{
    $("#detail-kelompok tbody").append(row);
    $("#detail-kelompok tbody tr:last-child .integer").maskMoney(
        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
    );
}

</script>
