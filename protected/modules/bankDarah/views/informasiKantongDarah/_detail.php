<?php 
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'detailKantongDarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onclick'=>'cekDisabled(this);',),
    'focus' => '#',
        ));
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
           <div class="panel-heading">
                <div class="panel-title">Pelulusan <strong> Komponen Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Data <strong>Kantong Darah</strong></div>
                    </div>
                    <div class="panel-body" > 
                        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
                        
                        <div class="col-md-6">
                            <div class="control-group">
                                <?php  echo CHtml::label("Nomor Barcode",'no_kantongdarah', array('class' => 'control-label')) ?>
                                <div class = "controls">
                                    <?php // echo $form->textField($modKantongDarahs,'nomorbarcode',array('readonly' => true, 'class'=>'span3','placeholder'=>'Ketik Nomor Kantong Darah')) ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Jenis Kantong Darah",'nama_jenis', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php // echo $form->textField($modKantongDarahs,'nama_jenis',array('readonly' => true, 'class'=>'span3','placeholder'=>'Ketik Nomor Kantong Darah')) ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Tanggal Penerimaan Kantong",'tglpencatatan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
//                                    $this->widget('MyDateTimePicker', array(
//                                        'model' => $modKantongDarahs,
//                                        'attribute' => 'tglpencatatan',
//                                        'mode' => 'date',
//                                        'options' => array(
//                                            'dateFormat' => Params::DATE_FORMAT,
//                                            // 'maxDate' => 'd',
//                                        //
//                                        ),
//                                        'htmlOptions' => array('readonly' => true,'disabled' =>true ,'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",
//                                        ),
//                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="control-group">
                                 <?php echo CHtml::label("Golongan Darah",'gol_darah', array('class' => 'control-label')) ?>
                                <div class = "controls">
                                    <?php // echo $form->textField($modKantongDarahs,'gol_darah',array('readonly' => true, 'class'=>'span3','placeholder'=>'Ketik Nomor Kantong Darah')) ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Rhesus",'rhesus', array('class' => 'control-label')) ?>
                                <div class = "controls">
                                    <?php // echo $form->textField($modKantongDarahs,'rhesus',array('readonly' => true, 'class'=>'span3','placeholder'=>'Ketik Nomor Kantong Darah')) ?>
                                </div>
                            </div>
                            <div class="control-group">
                                 <?php echo CHtml::label("Ruangan Asal",'ruangandaftar_nama', array('class' => 'control-label')) ?>
                                <div class = "controls">
                                    <?php //  echo $form->textField($modKantongDarahs,'ruangandaftar_nama',array('readonly' => true, 'class'=>'span3','placeholder'=>'Ruangan Asal')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Hasil / Kesimpulan <strong>Pengujian Sebelumnya</strong></div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                             <?php echo CHtml::label("Skrining IMLTD",'nomorbarcode', array('class' => 'control-label')) ?>
                            <div class = "controls">
                                <?php // if ($modKantongDarahs->hbsag == "FALSE" && $modKantongDarahs->antihiv == "FALSE" && $modKantongDarahs->antihvc == "FALSE" && $modKantongDarahs->sifilis == "FALSE") { ?> 
                                    <?php // echo $form->textField($modKantongDarahs,'skriningimltd_id',array('readonly' => true, 'class'=>'span3', 'value' => 'Non Reaktif')) ?>
                                <?php // } else { ?>
                                    <?php // echo $form->textField($modKantongDarahs,'skriningimltd_id',array('readonly' => true, 'class'=>'span3', 'value' => 'Reaktif')) ?>
                                <?php // } ?>
                            </div>
                        </div>
                        <div class="control-group">
                             <?php echo CHtml::label("Konfirmasi Gol. Darah",'hasil_uji', array('class' => 'control-label')) ?>
                            <div class = "controls">
                                <?php // echo $form->textField($modKantongDarahs,'hasil_uji',array('readonly' => true, 'class'=>'span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                             <?php echo CHtml::label("Komponen Darah",'singkatan_komp', array('class' => 'control-label')) ?>
                            <div class = "controls">
                                <?php // echo $form->textField($modKantongDarahs,'singkatan_komp',array('readonly' => true, 'class'=>'span3','placeholder'=>'Ketik Nomor Kantong Darah')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Pelulusan <strong>Pengujian Komponen </strong></div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label("Keterangan",'keteranganpelulusan', array('class' => 'control-label')) ?>
                            <div class = "controls">
                                <?php echo $form->textArea($model,'keteranganpelulusan',array('class'=>'span3','placeholder'=>'Ketik Nomor Kantong Darah')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                             <?php echo CHtml::label("Mutu",'statuspelulusan', array('class' => 'control-label')) ?>
                            <div class = "controls">
                                <?php echo $form->radioButtonList($model,'statuspelulusan', LookupM::getItems('statuspelulusan') , array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <br> <br> <br>
                        <div class="col-md-6">
                            <div class="control-group">
                                <?php echo CHtml::label("Tanggal Pelulusan",'tglpelulusan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tglpelulusan',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Koordinator Mutu",'koordinatormutu_id', array('class' => 'control-label')) ?>
                                <div class = "controls">
                                    <?php 
                                    $criteria=new CDbCriteria();
                                    $criteria->addCondition("ruangan_id=".Yii::app()->user->getState('ruangan_id'));
                                    echo $form->dropDownList($model,'koordinatormutu_id', CHtml::listData(PegawairuanganV::model()->findAll($criteria), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="control-group">
                                <?php echo CHtml::label("Kepala Instansi Transfusi Darah",'kepalainstalasi_id', array('class' => 'control-label')) ?>
                                    <div class = "controls">
                                        <?php 
                                        $criteria=new CDbCriteria();
                                        $criteria->addCondition("ruangan_id=".Yii::app()->user->getState('ruangan_id'));
                                        echo $form->dropDownList($model,'kepalainstalasi_id', CHtml::listData(PegawairuanganV::model()->findAll($criteria), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --')) ?>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="form-actions">
                    <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
                        'class'=>'btn btn-primary submit',
                        'type'=>'submit',
                    ))." "; 

                    echo CHtml::link('<i class="entypo-arrows-ccw"></i> Ulang', $this->createUrl('index'), array(
                        'class'=>'btn btn-danger'
                    ));

                    ?>
                    <?php if (!isset($_GET['sukses'])) { ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button')); ?>
                        <?php echo CHtml::submitButton('Accept', array('name' => 'create')); ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index'), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);')); ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => true, 'type' => 'button')); ?>
                        <?php $content = $this->renderPartial($this->path_tips.'/tipsInformasiKunjunganRS', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                    <?php } else { ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onkeypress' => 'verifikasi();', 'disabled' => true)); ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index'), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);')); ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')); ?>
                        <?php $content = $this->renderPartial($this->path_tips.'/tipsInformasiKunjunganRS', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>       
<?php $this->endWidget(); ?>
    <script type="text/javascript"> 
        function tombolSimpan(){
	if(requiredCheck($("form"))){
        // return false;
        $(".animation-loading").removeClass("animation-loading");
		//$(".currency").each(function(){this.value = unformatNumber(this.value)});
		//$(".integer2").each(function(){this.value = unformatNumber(this.value)});
		//$(".float2").each(function(){this.value = unformatNumber(this.value)});
		$('#detailKantongDarah-t-form').submit();
    }
    return false;
}
    </script>