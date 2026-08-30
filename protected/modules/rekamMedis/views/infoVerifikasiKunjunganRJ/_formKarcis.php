<?php
$modKarcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis'=>true,'daftartindakan_aktif'=>true));

?>
    <?php echo CHtml::hiddenfield('TindakanpelayananT[idTindakan]');?>
    <?php echo CHtml::hiddenfield('TindakanpelayananT[tarifSatuan]');?>
    <?php echo CHtml::hiddenfield('TindakanpelayananT[idKarcis]');?>

    <div id="daftarKarcis" class="<?php echo ($modInfoVerifikasiKunjuganRJ->adaKarcis) ? '':'hide'; ?>">
          <table id="tblFormKarcis" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>Karcis</th>
                        <th>Harga</th>   
                        <th>Pilih</th>
                    </tr>
                </thead>
                <tbody></tbody>
      </table>
    </div>
    
<?php
$enableInputKarcis = ($modInfoVerifikasiKunjuganRJ->adaKarcis) ? 1 : 0;
$js = <<< JS
if(${enableInputKarcis}) {
    $('#daftarKarcis input').removeAttr('disabled');
    $('#daftarKarcis select').removeAttr('disabled');
}
else {
    $('#daftarKarcis input').attr('disabled','true');
    $('#daftarKarcis select').attr('disabled','true');
}

$('#karcisTindakan').attr('checked','checked');
$('#daftarKarcis').slideToggle(500);
$('#karcisTindakan').change(function(){
        if ($(this).is(':checked')){
                $('#daftarKarcis input').removeAttr('disabled');
                $('#daftarKarcis select').removeAttr('disabled');
        }else{
                $('#daftarKarcis input').attr('disabled','true');
                $('#daftarKarcis select').attr('disabled','true');
                $('#daftarKarcis input').attr('value','');
                $('#daftarKarcis select').attr('value','');
        }
        $('#daftarKarcis').slideToggle(500);
    });
JS;
Yii::app()->clientScript->registerScript('karcis',$js,CClientScript::POS_READY);
?>
