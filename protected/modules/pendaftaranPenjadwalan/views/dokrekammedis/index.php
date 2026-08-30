<?php
$this->breadcrumbs = array(
    'Pengiriman Berkas Rekam Medis',
); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#search').submit(function(){
			$.fn.yiiGridView.update('ppdokumenpasienrmbaru-v-grid', {
				data: $(this).serialize()
			});
			return false;
		});
    ");

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pengiriman Dokumen Rekam Medis berhasil disimpan!");
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pengiriman Berkas Rekam Medis
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <!--to apply shadow add class "panel-shadow"-->
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="search-form">
                            <?php $this->renderPartial('_searchPasienBaru', array(
                                'model' => $model, 'format' => $format
                            )); ?>
                        </div>
                        <!--search-form-->
                    </div>
                </div>
                <br>
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'ppdokrekammedis-m-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                    'focus' => '#' . CHtml::activeId($modPengiriman, 'petugaspengirim'),
                )); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pengiriman Dokumen Rekam Medis</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php echo $this->renderPartial('_tabelPengiriman', array('model' => $model)); ?>
                    </div>
                </div>

                <?php echo $form->errorSummary($modDokRekamMedis); ?>
                <div class="panel panel-success">
                    <!--to apply shadow add class "panel-shadow"-->
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Pengiriman Dokumen Rekam Medis
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formPengiriman', array('form' => $form, 'modDokRekamMedis' => $modDokRekamMedis, 'modPengiriman' => $modPengiriman)); ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php
                    if (!isset($_GET['sukses'])) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'cekInputan();', 'onclick' => 'cekInputan();'));
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('disabled' => true, 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                    }
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                        )
                    ); ?>

                    <?php
                    $content = $this->renderPartial('tips/dokrekamedis', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>

            <!--======================== Begin Widget Dialog Petugas Pengirim =============================-->
            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogPetugasPengirim',
                'options' => array(
                    'title' => 'Petugas Pengirim',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 600,
                    'height' => 500,
                    'resizable' => false,
                ),
            ));
            ?>
            <?php
            $modPetugasPengirim = new PPPegawaiV('searchDialog');
            $modPetugasPengirim->unsetAttributes();
            if (isset($_GET['PPPegawaiV'])) {
                $modPetugasPengirim->attributes = $_GET['PPPegawaiV'];
            }
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'petugaspengirim-grid',
                'dataProvider' => $modPetugasPengirim->searchDialog(),
                'filter' => $modPetugasPengirim,
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns' => array(
                    array(
                        'header' => 'Pilih',
                        'type' => 'raw',
                        'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
					"href"=>"",
					"id" => "selectPetugasPengirim",
					"onClick" => "
								  $(\"#' . CHtml::activeId($modPengiriman, 'petugaspengirim') . '\").val(\"$data->nama_pegawai\");
								  $(\"#dialogPetugasPengirim\").dialog(\"close\"); 
								  return false;
						"))',
                    ),
                    array(
                        'header' => 'NIP',
                        'filter' =>  CHtml::activeTextField($modPetugasPengirim, 'nomorindukpegawai'),
                        'value' => '$data->nomorindukpegawai',
                    ),
                    array(
                        'header' => 'Nama Pegawai',
                        'filter' =>  CHtml::activeTextField($modPetugasPengirim, 'nama_pegawai'),
                        'value' => '$data->nama_pegawai',
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            $this->endWidget(); ?>
            <!--=============================== endWidget Dialog Petugas Pengirim ============================-->

            <?php $this->renderPartial('_jsFunctions', array('modDokRekamMedis' => $modDokRekamMedis)); ?>
        </div>
    </div>
</div>