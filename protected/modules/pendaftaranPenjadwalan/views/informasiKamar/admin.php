<?php
$this->breadcrumbs = array(
    'Pptindakanruangan Ms' => array('index'),
    'Manage',
);
?>
<div class='search-form'>
    <legend>Data Ruangan</legend>

    <?php echo CHtml::label('Pilih Ruangan Inap', 'ruangan') ?>
    <?php
    echo CHtml::dropDownList('ruangan', 'ruangan_id', CHtml::listData(RuanganM::model()->findAllBySql('select * from ruangan_m order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array(
        'empty' => '-Pilih Ruangan-', 'style' => 'width:130px;',
        //                'ajax' => array(
        //                    'type' => 'POST',
        //                    'url' => CController::createUrl('informasikamar/ajaxKamarRuangan'),
        //                    'update' => '#kamar',
        //                    'data'=>array('ruangan_id'=>'js:$(\'#ruangan\').val()'),
        //                    ),                
        //                'ajax' => array(
        //                    'type' => 'POST',
        //                    'url' => CController::createUrl('informasikamar/ajaxKelasPelayanan'),
        //                    'update' => '#kelas',
        //                    'data'=>array('ruangan_id'=>'js:$(\'#ruangan\').val()'),
        //                        )

    ))
    ?>
    <?php echo CHtml::label('Pilih Kelas', 'kelas') ?>
    <?php echo CHtml::dropDownList('kelas', 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-Pilih Kelas-', 'style' => 'width:130px;')) ?>
    <?php echo CHtml::label('Pilih Kamar', 'kamar') ?>
    <?php echo CHtml::dropDownList('kamar', 'kamarruangan_nokamar', CHtml::listData(PPKamarruanganM::model()->findAll(), 'kamarruangan_nokamar', 'kamarruangan_nokamar'), array('empty' => '-Pilih Kamar-', 'style' => 'width:130px;')) ?>
    <br>
    <?php echo CHtml::submitButton('Tampilkan', array('class' => 'btn')); ?>
</div>

<?
$url1 = CController::createUrl('informasikamar/ajaxKamarRuangan');
$url2 = CController::createUrl('informasikamar/ajaxKelasPelayanan');
Yii::app()->clientScript->registerScript('search', "
$('#ruangan').change(function(){
        var sruangan = $(this).val();
	$.post('${url1}',{ruangan_id:sruangan},function(data){
            $('#kamar').html(data);
            
        });
	$.post('${url2}',{ruangan_id:sruangan},function(data){
            $('#kelas').html(data);
            
        });
});
");
?>