<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Tgl Culture</th>
            <!--<th style="text-align: center">Analis</th>-->
            <th style="text-align: center">Status Verifikasi</th>
            <th style="text-align: center">Lihat</th>
            <th style="text-align: center">Ubah</th>
            <th style="text-align: center">Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($modRiwayatCulture)) {        
            $no = 1;
            foreach($modRiwayatCulture as $mod) :
                $culture = CultureT::model()->findByAttributes(array('spesimen_id' => $mod->spesimen_id));
                $analis = PegawaiM::model()->findByPk($culture->analis_id);
                $verifikator = PegawaiM::model()->findByPk($culture->verifikator_id);
        ?>
        <tr>
            <td> <?php echo $no++; ?></td>
            <td> <?php echo MyFormatter::formatDateTimeForUser($mod->tanggal_culture); ?></td>
            <!--<td> <?php // echo $analis->namaLengkap; ?></td>-->
            <td> <?php echo !empty($mod->status_verifikasi) ? $mod->status_verifikasi : ''; ?></td>
            <td style="text-align: center">
                <?php 
                    echo CHtml::link("<i class='glyphicon glyphicon-eye-open'> </i>", 
                        Yii::app()->createUrl('mikrobiologiKlinik/'.Yii::app()->controller->id.'/detail&culture_id='.$mod->culture_id),
                        array(
                            'class'=>'hover',
                            "rel"=>"tooltip",
                            "target"=>"iframeDetail", 
                            "onclick"=>"$('#dialogDetail').dialog('open');",
                            "title"=>"Klik untuk Melihat Detail Inoculating Process"));
                ?>
            </td>
            <td style="text-align: center">
                <?php 
                    if($mod->status_verifikasi != 'Terverifikasi DPJTM'){
                        echo CHtml::link("<i class='glyphicon glyphicon-pencil'> </i>", 
                            Yii::app()->createUrl('mikrobiologiKlinik/'.Yii::app()->controller->id.'/index&spesimen_id='.$mod->spesimen_id.'&culture_id='.$mod->culture_id),
                            array(
                                'class'=>'hover',
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk Mengubah Data"));
                    } else {
                        echo CHtml::link('<i style="font-size:10pt;" class="glyphicon glyphicon-pencil"></i>', '#', array(
                            'rel'=>'tooltip',
                            'data-placement'=>'left',
                            'title'=>'Klik untuk Mengubah Data',
                            'onclick'=>'toastr.error("Tidak dapat mengubah data karena data sudah diverifikasi"); return false;'
                        ));
                    }
                ?>
            </td>
            <td style="text-align: center">
                <?php 
                    if($mod->status_verifikasi == false) {
                        echo CHtml::link('<i style="font-size:10pt;" class="entypo entypo-trash"></i>', '#', array(
                            'rel'=>'tooltip',
                            'data-placement'=>'left',
                            'title'=>'Klik untuk menghapus culture',
                            'onclick'=>'hapusCulture(this, '.$mod->culture_id.'); return false;'
                        ));
                    } else {
                        echo CHtml::link('<i style="font-size:10pt;" class="entypo entypo-trash"></i>', '#', array(
                            'rel'=>'tooltip',
                            'data-placement'=>'left',
                            'title'=>'Klik untuk menghapus culture',
                            'onclick'=>'toastr.error("Tidak dapat menghapus data karena data sudah diverifikasi"); return false;'
                        ));
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; }?>
    </tbody>
</table>
<?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetail',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Inoculating Process',
    'autoOpen'=>false,
    'width'=>1070,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Rencana Umum Pengadaan================================
$urlCreate = $this->createUrl('index&spesimen_id='.$_GET['spesimen_id']);

?>

<script>
    function hapusCulture(obj, id) {
        myConfirm('Apakah anda yakin untuk menghapus pemeriksaan Culture ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusCulture'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        window.location.replace("<?php echo $urlCreate ?>");
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>