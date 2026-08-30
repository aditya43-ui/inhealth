<?php

Yii::app()->clientScript->registerScript('search', "
    $('#formCari').submit(function(){
        $.fn.yiiGridView.update('riwayat-askep-kesehatan-jiwa', {
            data: $(this).serialize()
        });
        return false;
    });
");



$mod = new AskepkesehatanjiwaT('search');
$mod->unsetAttributes();
$mod->pasien_id = $model->pendaftaran->pasien_id;

$mod->tgl_awal = date('Y-m-d', strtotime('- 1 month'));
$mod->tgl_akhir = date('Y-m-d');

if (isset($_GET['AskepkesehatanjiwaT'])) {
    $mod->attributes = $_GET['AskepkesehatanjiwaT'];
    $mod->tgl_awal = MyFormatter::formatDateTimeForDB($mod->tgl_awal);
    $mod->tgl_akhir = MyFormatter::formatDateTimeForDB($mod->tgl_akhir);
}



?>


<?php
$form_cari = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'type' => 'horizontal',
        'id' => 'formCari',
        'focus' => '#' . CHtml::activeId($mod, 'no_pendaftaran'),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)'
        ),
    )
);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pencarian</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tanggal Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($mod->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($mod->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span ><?php echo date('d M Y', strtotime($mod->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($mod->tgl_akhir)) ?></span>
                            <?php echo $form_cari->hiddenField($mod, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form_cari->hiddenField($mod, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <?php echo $form_cari->textFieldRow($mod, 'no_pendaftaran', array('class'=>'span3')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form_cari->dropDownListRow($mod, 'instalasi_id', 
                    CHtml::listData(InstalasiM::model()->findAllByAttributes(array(
                        'instalasi_aktif'=>true,
                        'revenuecenter'=>true,
                    ), array(
                        'order'=>'instalasi_nama',
                    )), 'instalasi_id', 'instalasi_nama'),
                    array('empty'=>'-- Pilih --', 'class'=>'span3', 'onchange'=>'getListRuanganInstalasi(this);')); 
                ?>
                <?php echo $form_cari->dropDownListRow($mod, 'ruangan_id', array(), array('class'=>'span3 riwayat_ruangan_id', 'multiple'=>'multiple'));  ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        </div>
    </div>
</div>

<?php

$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'riwayat-askep-kesehatan-jiwa',
        'dataProvider' => $mod->searchRiwayat(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed table-bordered',
        'dropdownItemKelipatan'=>5,
        'columns' => array(
            array(
                'header' => 'No',
                'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
            ),
            array(
                'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                'type'=>'raw',
                'value'=>function($data) {
                    return MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)."<br/>".$data->pendaftaran->no_pendaftaran;
                }
            ),
            array(
                'header'=>'Tanggal & Jam<br/>Asesmen',
                'type'=>'raw',
                'value'=>function($data) {
                    return MyFormatter::formatDateTimeForUser($data->tgl_pengkajian)."<br/>".$data->jam_pengkajian;
                }
            ),
            array(
                'header'=>'Ruangan',
                'type'=>'raw',
                'value'=>'$data->pendaftaran->ruangan->ruangan_nama',
            ),
            array(
                'header'=>'Petugas Pemeriksa',
                'type'=>'raw',
                'value'=>'$data->perawatpengkaji->namaLengkap',
            ),
            array(
                'header' => 'Detail',
                'type' => 'raw',
                'value'=>function($data) {
                    return CHtml::link('<i class="entypo-eye" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('detail', array(
                        'pendaftaran_id'=>$data->pendaftaran_id,
                        'id'=>$data->askepkesehatanjiwa_id,
                    )), array(
                        'target'=>'framePengkajian',
                        'onclick'=>"window.parent.$('#detailPengkajian').dialog('open');",
                    ));

                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Cetak',
                'type' => 'raw',
                'value'=>function($data) {
                    return CHtml::link('<i class="entypo-print" style="font-size:14pt"></i>', '#', array(
                        'onclick'=>"printPengkajian(".$data->askepkesehatanjiwa_id."); return false;",
                    ));

                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'value'=>function($data) {
                    //if($data->ruangan_id==Yii::app()->user->getState('ruangan_id')){
                        return CHtml::link('<i class="entypo-pencil" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('index', array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                            'id'=>$data->askepkesehatanjiwa_id,
                        )));
                    //}else{
                    //    return "";
                    //}

                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Hapus',
                'type' => 'raw',
                'value'=>function($data) {
                    //if($data->ruangan_id==Yii::app()->user->getState('ruangan_id')){
                         return CHtml::link('<i class="entypo-trash" style="font-size:14pt"></i>', '#', array(
                            'onclick'=>'hapusRiwayatPengkajianJiwa('.$data->askepkesehatanjiwa_id.'); return false'
                        ));
                    //}else{
                    //    return "";
                    //}
                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
        ),
));

$this->endWidget();


?>

<script>
    
    function getListRuanganInstalasi(obj) {
        $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {instalasi_id: $(obj).val()}, function(data) {
            $(".riwayat_ruangan_id").html(data.dropDown);
            jQuery(".riwayat_ruangan_id").multiselect('rebuild');
        }, 'json');
    }
    
    function hapusRiwayatPengkajianJiwa(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusRiwayat'); ?>', {id: id}, function(data) {
                    if (data.sukses === 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayat-askep-kesehatan-jiwa', {
                            data: $('#formCari').serialize()
                        });
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    function printPengkajian(id)
    {
        window.open('<?php echo $this->createUrl('print'); ?>&id='+id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
    
    $(document).ready(function() {
        jQuery(".riwayat_ruangan_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });

    
</script>