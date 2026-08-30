<table class="items table table-bordered table-striped table-condensed" id="tblListKonsul">
    <thead>
        <tr>
            <th>Tanggal Kie</th>
           
            <th>Dokter Pemeriksa</th>
            <th>Detail</th>
            <!-- <th>Ubah</th> -->
            <th>Hapus</th>
        </tr>
    </thead>
  <tbody>
    <?php foreach($modRiwayatKie as $r)  { ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($r->tgl_kie); ?></td>
            <td><?php echo $r->pegawai->namaLengkap; ?></td>
            <td>
            <?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetail('.$r->kiepasien_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail KIE')); ?>
            
            </td>
            <!-- <td> -->
            <?php //echo CHtml::Link("<i class=\"icon-pencil\"></i>",
                            //Yii::app()->controller->createUrl("kie/index",array("pendaftaran_id"=>$_GET['pendaftaran_id'],"kiepasien_id"=>$r->kiepasien_id)))?>

            <!-- </td> -->
            <td>
                <?php echo CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'batal('.$r->kiepasien_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan KIE')); ?>
            </td>
        </tr>
    <?php } ?>
  </tbody>
</table>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetail',
    'options'=>array(
        'title'=>'Detail KIE',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetail">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
function batal(kiepasien_id,pendaftaran_id)
{
    myConfirm("Apakah Anda akan menghapus Lembar Observasi ini?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatal') ?>', {kiepasien_id: kiepasien_id, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListKonsul').html(data.result);
            }, 'json');
        }
    });
}

function viewDetail(kiepasien_id)
{
    $.post('<?php echo $this->createUrl('ajaxDetail') ?>', {kiepasien_id: kiepasien_id}, function(data){
        $('#contentDetail').html(data.result);
    }, 'json');
    $('#dialogDetail').dialog('open');
}

function ubah(kiepasien_id){

}
</script>
