<table id="tblListPemeriksaanLab" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Patologi Anatomi</th>
            <th><center>Detail Order Pemeriksaan</center></th>

        </tr>
    </thead>
    <tbody>
        <?php

foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RIPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tgl_kirimpasien); ?></td>
            <td>
                <center><?php echo CHtml::link("<i class='icon-form-detail'></i>", '#', array('onclick'=>'viewOrder("'.$riwayat->pasienkirimkeunitlain_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail order pemeriksaan'));  ?></center>
            </td>
        </tr>
        <?php
}
?>
    </tbody>

</table>


<script>
function viewOrder(pasienkirimkeunitlain_id) {

    $.post('<?php echo $this->createUrl('ajaxDetailOrder') ?>', {
        pasienkirimkeunitlain_id: pasienkirimkeunitlain_id
    }, function(data) {
        $('#contentDetailOrder').html(data.result);
    }, 'json');
    $('#dialogDetailOrder').dialog('open');
}
</script>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailOrder',
    'options'=>array(
        'title'=>'Detail Order Pemeriksaan Patologi Anatomi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>850,
        'resizable'=>false,
        'position'=>'top',
    ),
));

echo '<div id="contentDetailOrder">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>