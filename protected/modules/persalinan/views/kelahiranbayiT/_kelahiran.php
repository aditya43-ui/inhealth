<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modKelahiran)){
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Kelahiran</div>
    </div>
    <div class="panel-body">
        <div id="divRiwayatPasien" class="control-group">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align: center;">Lahir Tunggal</th>
                        <th rowspan="2" style="text-align: center;">Tanggal Lahir</th>
                        <th rowspan="2" style="text-align: center;">Nama Bayi</th>
                        <th rowspan="2" style="text-align: center;">Jenis Kelamin</th>
                        <th rowspan="2" style="text-align: center;">Berat Badan / Tinggi Badan</th>
                        <th rowspan="2" style="text-align: center;">Interpretasi</th>
                        <th rowspan="2" style="text-align: center;">Masa Gestasi / Paritas Ke</th>
                        <th rowspan="2" style="text-align: center;">Denyut Jantung</th>
                        <th rowspan="2" style="text-align: center;">Aktivitas Otot</th>
                        <th rowspan="2" style="text-align: center;">Respon Refleks</th>
                        <th rowspan="2" style="text-align: center;">Pernapasan</th>
                        <th colspan="2" style="text-align: center;">Apgar</th>
                    </tr>
                    <tr>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($modKelahiran as $row){ ?>
                        <tr>
                            <td><?php if($row->islahirtunggal)  echo 'Ya'; else echo 'Tidak' ;?></td>
                            <td><?php echo $row->tgllahirbayi ;?></td>
                            <td><?php echo CHtml::link($row->namabayi.' <i class="entypo-pencil"></i>', Yii::app()->createUrl($this->module->id.'/kelahiranbayiT/index&id='.$_GET['id'].'&bayi='.$row->kelahiranbayi_id));?></td>
                            <td><?php echo $row->jeniskelamin ;?></td>
                            <td><?php echo $row->bb_gram; ?> Gram <br><?php echo $row->tb_cm ;?> CM</td>
                            <td><?php echo $row->interpretasi; ?></td>
                            <td><?php echo $row->warnakulit; ?></td>
                            <td><?php echo $row->denyutjantung; ?></td>
                            <td><?php echo $row->aktivitasotot; ?></td>
                            <td><?php echo $row->responrefleks; ?></td>
                            <td><?php echo $row->pernapasan; ?></td>
                            <td><?php echo CHtml::link("<i class=icon-list-alt></i>","#",array("rel"=>"tooltip",'class'=>'kelahiran','data'=>$row->kelahiranbayi_id, "title"=>"Klik untuk melihat detail apgar",'onclick'=>"$('#getDataApgar').dialog('open'); return false;")); ?></td>
                            <td nowrap>
                                <table class="aksi_apgar">
                                    
                                <?php
                                $menit = CHtml::listData(ApgarscoreT::model()->findAllByAttributes(array(
                                    'kelahiranbayi_id'=>$row->kelahiranbayi_id,
                                )), 'menitke', 'menitke');
                                
                                foreach ($menit as $item) {
                                ?>
                                    <tr>
                                        <td width="100"><?php echo "Menit ke-".$item; ?></td>
                                        <td width="10"><?php echo CHtml::link('<i class="entypo-pencil"></i>', '#', array(
                                            'onclick'=>'updateApgar('.$row->kelahiranbayi_id.', '.$item.'); return false;',
                                            'rel'=>'tooltip',
                                            'title'=>'Klik untuk mengubah data Apgar Bayi'
                                        )); ?></td>
                                        <td width="10"><?php echo CHtml::link('<i class="entypo-cancel"></i>', '#', array(
                                            'onclick'=>'hapusApgar(this, '.$row->kelahiranbayi_id.', '.$item.'); return false;',
                                            'rel'=>'tooltip',
                                            'title'=>'Klik untuk menghapus data Apgar Bayi'
                                        )); ?></td>
                                    </tr>
                                <?php } ?>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    
<?php
} else { //validasi dihilangkan RSN-294
//    Yii::app()->user->setFlash('error',"Tidak ada data Riwayat Kelahiran pasien");
    echo "";
    $this->widget('bootstrap.widgets.BootAlert');
}

?>

     <?php 
// Dialog untuk pasienpulang_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'getDataApgar',
    'options'=>array(
        'title'=>'Metode Apgar',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
    ),
));

echo '<div class="divForForm"></div>';

$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>

<?php 
// Dialog untuk pasienpulang_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'updateDataApgar',
    'options'=>array(
        'title'=>'<span id="judul_update_apgar"></span>',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
    ),
));

echo '<div class="divForForm"></div>';

$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>

<?php $urlDataApgar = Yii::app()->createUrl('persalinan/kelahiranbayiT/dataApgar'); ?>

<?php Yii::app()->clientScript->registerScript('appgard2', "
    $(document).ready(function(){
        function getDataApgar(input){
                
                var kelahiranbayi_id = $(input).attr('data');
                $.post('${urlDataApgar}', { kelahiranbayi_id:kelahiranbayi_id },
                function(data){
                    $('#getDataApgar div.divForForm').html(data.div);
                }, 'json');
           
        }
        $('.kelahiran').click(function(){
              getDataApgar($(this));
        });
        
        $('.apgar').change(function(){
            $(this).parent().parent().css('background','#B5C1D7');
        });
    });

", CClientScript::POS_READY); ?>
<script>

var menitke_data = "";
var kelahiran_id = "";
function updateApgar(id, menitke) {
    kelahiran_id = "";
    menitke_data = "";
    
    $.post('<?php echo $this->createUrl('updateApgar'); ?>', { id:id, menitke: menitke },
    function(data){
        kelahiran_id = id;
        menitke_data = menitke;
        $('#updateDataApgar div.divForForm').html(data.html);
        $('#judul_update_apgar').html(data.judul);
        $("#updateDataApgar").dialog("open");
    }, 'json');
}

function submitUpdateApgar() {
    $("#btn_update_apgar").prop("disabled", true);
    $.post('<?php echo $this->createUrl('submitUpdateApgar'); ?>', $("#update_apgar").serialize(), function(data) {
        if (data.ok == 1) {
            $("#updateDataApgar").dialog("close");
            $('#updateDataApgar div.divForForm').html("");
            myAlert(data.msg);
        } else {
            myAlert(data.msg);
            $("#btn_update_apgar").prop("disabled", false);
        }
    }, 'json');
}

</script>