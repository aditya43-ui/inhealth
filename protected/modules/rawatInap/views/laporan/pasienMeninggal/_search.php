<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        label.checkbox {
            width: 250px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
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
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="searching">
                <div id="tindaklanjut">
                    <?php echo CHtml::hiddenField('filter', 'caramasuk_id', array('disabled' => 'disabled')) .
                        '<div class="control-group">
                            ' . CHtml::label('Tindak Lanjut', 'caramasuk_id', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'caramasuk_id', CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )) . '
                            </div>
                        </div>';
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div id="searching">
                <div id="kondisipulang">
                    <?php
                    echo CHtml::hiddenField('filter', 'kondisipulang', array('disabled' => 'disabled')) .
                        '<div class="control-group">
                                            ' . CHtml::label('Kondisi Pulang', 'kondisikeluar_id', array('class' => 'control-label')) . ' 
                                            <div class="controls">
                                                ' . $form->dropDownList($model, 'kondisikeluar_id', CHtml::listData(KondisiKeluarM::model()->findAll(" kondisikeluar_aktif = TRUE AND carakeluar_id = '" . Params::CARAKELUAR_ID_MENINGGAL . "' ORDER BY kondisikeluar_nama ASC"), 'kondisikeluar_id', 'kondisikeluar_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )) . '
                                            </div>
                                        </div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>
<script type="text/javascript">
    function cek_all_tindakan(obj) {
        if ($(obj).is(':checked')) {
            $("#tindak_lanjut_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#tindak_lanjut_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }

    function checkSemua() {
        if ($("#checkSemuaid").is(":checked")) {
            $('.kondisipulang input[name*="RILaporanpasienmeninggalriV"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('.kondisipulang input[name*="RILaporanpasienmeninggalriV"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
        //setAll();
    }

    cek_all_tindakan($("#cek_all"));
    checkSemua();
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>