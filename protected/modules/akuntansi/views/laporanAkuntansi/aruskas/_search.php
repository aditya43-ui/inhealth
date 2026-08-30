<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>

    <div class="row">
        <div class="col-sm-6">
            <!--<div class="control-group">
					<?php //echo CHtml::label("Periode Laporan", 'periodeposting_id', array('class' => 'control-label')); 
                    ?>
					<div class="controls">
						<?php
                        //echo $form->dropDownList($model, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll(),'periodeposting_id','deskripsiperiodeposting'), array('empty' => '-- Pilih --',
                        //	'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm'));
                        //echo $form->dropDownList($model, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll("periodeposting_aktif = TRUE ORDER BY deskripsiperiodeposting ASC"),'periodeposting_id','periodeposting_nama'), array('empty' => '-- Pilih --',
                        //'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm periodeposting_id'));
                        ?>
					</div>
				</div>-->
            <div class="control-group">

                <?php echo CHtml::label("Periode Laporan", 'periodeposting_id', array('class' => 'control-label')) ?>
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
            <?php /*
				<div class="control-group">
					<?php echo CHtml::label('Unit Kerja', 'Unit Kerja', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
							echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama asc')),
								'ruangan_id','ruangan_nama'),array('class'=>'span2','style'=>'width:140px','empty'=>'-- Pilih --')); 
						?>
					</div>
				</div>			
				 * 
				 */ ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/LaporanArusKas'),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
        echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinoutNonGrafik', true);
        ?>
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
    function cekPencarian() {
        var periode = $(".periodeposting_id").val();

        if (periode.trim() == "") $("#searchLaporan").submit();

        $.post('<?php echo Yii::app()->createUrl('/actionAjax/cekJurnalBelumPosting') ?>', {
            periode: periode
        }, function(data) {
            if (data.ok == 1) $("#searchLaporan").submit();
            else {
                myConfirm("Masih ada jurnal yang belum diposting. Apakah Anda akan melanjutkan?", "Perhatian", function(r) {
                    if (r) {
                        $("#searchLaporan").submit();
                    }
                });
            }
        }, 'json');
    }
</script>