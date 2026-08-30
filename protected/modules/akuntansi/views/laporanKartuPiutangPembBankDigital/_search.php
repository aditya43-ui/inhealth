<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
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

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-search"></i> Pencarian
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="control-group">
                        <?php echo CHtml::label("Periode Laporan", "", array('class' => 'control-label')) ?>
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
                    <div class="control-group">
                        <?php echo CHtml::label("Jenis Pembayaran", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'jnspembayar_id',
                                CHtml::listData(JnspembayarM::model()->findAll('jnspembayar_aktif = true order by jnspembayar_nama asc'), 'jnspembayar_id', 'jnspembayar_nama'),
                                array(
                                    'class' => 'form-control', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'multiple' => 'multiple'
                                )
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Bank", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'bank_id',
                                CHtml::listData(BankM::model()->findAll('bank_aktif = true order by namabank asc'), 'bank_id', 'namabank'),
                                array(
                                    'class' => 'form-control', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'multiple' => 'multiple'
                                )
                            ); ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                ); ?>
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    array(
                        'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );

                echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinoutNonGrafik', true);
                ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<script>
    $(document).ready(function() {

        var jnspembayar_id = jQuery('#<?php echo CHtml::activeId($model, 'jnspembayar_id') ?>');
        var bank_id = jQuery('#<?php echo CHtml::activeId($model, 'bank_id') ?>');

        jQuery(jnspembayar_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(bank_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });
</script>