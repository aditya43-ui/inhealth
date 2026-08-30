<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Batal Bayar Supplier</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Batal Bayar Supplier',
        ); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'batalbayarsupplier-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                // 'onsubmit'=>'return cekOtorisasi();'
                'onsubmit' => 'return cekValidasi(this);'
            ),
            'focus' => '#' . CHtml::activeId($modBuktiKeluar, 'nokaskeluar'),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran Supplier</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_infoBayarSupplier', array(
                    'form' => $form,
                    'modBuktiKeluar' => $modBuktiKeluar,
                    'modBatalBayar' => $modBatalBayar,
                    'modBayarSupplier' => $modBayarSupplier
                )) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembatalan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $modBatalBayar->tglbatalbayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBatalBayar->tglbatalbayar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php echo $form->labelEx($modBatalBayar, 'tglbatalbayar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modBatalBayar,
                                    'attribute' => 'tglbatalbayar',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'dtPicker2-5 span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'readonly' => true
                                    ),
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textAreaRow($modBatalBayar, 'alasanbatalbayar', array('placeholder' => 'Alasan Batal Bayar', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'user_id_otorisasi', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'user_name_otoritasi', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'tandabuktikeluar_id', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'bayarkesupplier_id', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->renderPartial($this->path_view . '_formPenerimaanKas', array('form' => $form, 'modBayarSupplier' => $modBayarSupplier, 'modTandabukti' => $modTandabukti, 'modPenUmum' => $modPenUmum), true); ?>
        <div class="form-actions">
            <?php
            // echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
            //                     array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
            //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 

            if ($modBatalBayar->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );

                //  echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','disabled'=>true));
            } else {
                // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false));
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                );
            }

            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default'
                )
            );
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view . "_jsFunction", array('modBatalBayar' => $modBatalBayar, 'modTandabukti' => $modTandabukti, 'modBayarSupplier' => $modBayarSupplier), true); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'loginDialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => false,
    ),
)); ?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formLogin')); ?>
<div class="control-group">
    <?php echo CHtml::label('Login Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array()); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array()); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekLogin();return false;')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#loginDialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPenerimaan',
    'options' => array(
        'title' => 'Daftar Jenis Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));

$modJenisPenerimaan = new JenispenerimaanM();
$modJenisPenerimaan->unsetAttributes();
if (isset($_GET['JenispenerimaanM'])) {
    $modJenisPenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'jenispenerimaan-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisPenerimaan->searchJenisPenerimaanRek(),
    'filter' => $modJenisPenerimaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
        ),
        array(
            'header' => 'Jenis Penerimaan',
            'name' => 'jenispenerimaan_nama',
            'value' => '$data->jenispenerimaan_nama',
        ),
        array(
            'header' => 'Nama Lain',
            'name' => 'jenispenerimaan_namalain',
            'value' => '$data->jenispenerimaan_namalain',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					getDataRekening($data->jenispenerimaan_id);
					$(\"#KUPenerimaanUmumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
					$(\"#KUPenerimaanUmumT_jenisKodeNama\").val(\"$data->jenispenerimaan_nama\");
					$(\"#dialogJenisPenerimaan\").dialog(\"close\");    
					return false;
			"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>