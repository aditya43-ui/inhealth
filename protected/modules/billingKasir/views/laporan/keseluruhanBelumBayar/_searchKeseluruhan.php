<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'focus' => '#BKLaporanKeseluruhan_instalasi_id',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="row">
    <div class="col-sm-12">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <div class="control-group">
            <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
            <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
        echo CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
            '<div class="control-group">
                ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                'class' => 'form-control', 'multiple' => 'multiple'
            )) . '
                </div>
            </div>';
        ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo '<div class="control-group">
        ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
        <div class="controls">												 
            ' . $form->dropDownList(
            $model,
            'ruangan_id',
            array(),
            array('class' => 'form-control', 'multiple' => 'multiple')
        ) . '
        </div>
    </div>';
        ?>
    </div>
</div>
<!--<div class="row">
    <div class="col-sm-6">
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'instalasi',
            'slide' => true,
            'content' => array(
                'content2' => array(
                    'multi' => 'multi',
                    'header' => 'Berdasarkan Instalasi dan Ruangan',
                    'isi' => CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
                        '<div class="control-group">
                                ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                                <div class="controls">
                                    ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )) . '
                                </div>
                            </div>
                            <div class="control-group">
                                ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
                                <div class="controls">												 
                                    ' . $form->dropDownList(
                            $model,
                            'ruangan_id',
                            array(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ) . '
                                </div>
                            </div>',
                    'active' => true,
                ),
            ),
            //                                    'htmlOptions'=>array('class'=>'aw',)
        ));
        ?>
    </div>
</div>-->

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
function konfirmasi(){
myConfirm("Apakah Anda ingin me-refresh halaman?","Perhatian!",
function(r){
    if(r){
        window.location.href="' . Yii::app()->createUrl($module . '/' . $controller . '/LaporanKeseluruhan', array('modul_id' => Yii::app()->session['modul_id'])) . '";
    }
}); 
}', CClientScript::POS_HEAD); ?>

<script type="text/javascript">
    function cek_all_ruangan(obj) {
        if ($(obj).is(':checked')) {
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }

    function cek_all_penjamin(obj) {
        if ($(obj).is(':checked')) {
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>