<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php  
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'beritaacara-m-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
    'focus'=>'#',
)); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <strong>Berita Acara</strong></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data Perjanjian Kerja </span></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Nomor SPK <span class="required">*</span>', 'nosuratperjanjiankerja', array('class' => 'control-label requred')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyJuiAutoComplete',array(
                                    'attribute'=>'nosuratperjanjiankerja',
                                    'model'=>$model,
                                    'sourceUrl'=> $this->createUrl('AutocompleSPK'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 3,
                                       'focus'=> 'js:function( event, ui ) {
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDataSPK(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('placeholder' => 'Cari No SPK', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 requred','id'=>'nosuratperjanjiankerja'),
                                    'tombolDialog'=>array('idDialog'=>'dialogSPK','idTombol'=>'tombolSPK'),
                                ));
                                ?>
                                <?php echo $form->hiddenField($model,'suratperjanjiankerja_id',array('class'=>'requred','readonly'=>true,'id'=>'suratperjanjiankerja_id')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tanggal SPK', 'tglsuratperjanjian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model,'tglsuratperjanjian',array('class' => 'span3', 'readonly'=>true, 'id'=>'tglsuratperjanjian')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Pekerjaan', 'namapekerjaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($model,'namapekerjaan',array('class' => 'span3', 'readonly'=>true, 'id'=>'namapekerjaan')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nilai Kontrak', 'nilaikontrak', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model,'nilaikontrak',array('class' => 'span3 integer-decimal', 'readonly'=>true, 'id'=>'nilaikontrak')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Penyedia', 'supplier_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model,'supplier_id',array('class' => 'span3', 'readonly'=>true, 'id'=>'supplier_id')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Direktur', 'namapembuatkomitmen', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model,'namapembuatkomitmen',array('class' => 'span3', 'readonly'=>true, 'id'=>'namapembuatkomitmen')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Alamat', 'alamat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($model,'alamat',array('class' => 'span3', 'readonly'=>true, 'id'=>'alamat')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Termin', 'termin', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model,'termin',array('class' => 'span3', 'readonly'=>true, 'id'=>'termin')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <?php $this->renderPartial('_tabMenu',array()); ?>
            <?php $this->renderPartial('_jsFunctions',array()); ?>
            <div>
                <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll"  width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);" ></iframe>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSPK',
    'options'=>array(
        'title'=>'Daftar Perjanjian Kerja',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1300,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modSPK = new SuratperjanjiankerjaT;
if (isset($_GET['SuratperjanjiankerjaT']))
    $modSPK->attributes = $_GET['SuratperjanjiankerjaT'];
    
$provider = $modSPK->search();
//$provider->criteria->addCondition('isbatal is false');
$provider->criteria->order = 'tglsuratperjanjian asc';
$modPPK = PejabatpengadaanM::model()->findByAttributes(array('jabatan_pengadaan' => Params::JABATAN_PENGADAAN_PPK, 'pejabatpengadaan_aktif' => true, 'pegawai_id' => Yii::app()->user->getState('pegawai_id')));
$modKPA = PejabatpengadaanM::model()->findByAttributes(array('jabatan_pengadaan' => Params::JABATAN_PENGADAAN_KPA, 'pejabatpengadaan_aktif' => true, 'pegawai_id' => Yii::app()->user->getState('pegawai_id')));

if (!empty($modPPK)) {
    $provider->criteria->addCondition('pejabatpembuatkomitmen_id = '.Yii::app()->user->getState('pegawai_id'));
} else if (!empty($modKPA)) {
    $provider->criteria->addCondition('kuasapenggunaanggaran_id = '.Yii::app()->user->getState('pegawai_id'));
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $provider,
    'filter' => $modSPK,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attributes = $data->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal["$attribute"] = $data->$attribute;
                }
                if(!empty($data->supplier_id)){
                    $modSupplier = SupplierM::model()->findByPk($data->supplier_id);
                    $attribute2 = $modSupplier->attributeNames();
                    foreach ($attribute2 as $j => $attribute2) {
                        $returnVal["$attribute2"] = $modSupplier->$attribute2;
                    }
                }
                if($data->istermin == true){
                    $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$data->suratperjanjiankerja_id));
                    if(!empty($cekTermin)){
                        $termin = array();
                        foreach ($cekTermin as $value){
                            $termin[] = $value->jumlah_persen;
                        }
                        $returnVal["termin"] = implode( ' - ', $termin );
                    }else{
                        $returnVal['termin'] = 'Non Termin';
                    }
                }else{
                    $returnVal['termin'] = 'Non Termin';
                }    
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "spk",
                    "onClick" => "setDataSPK(" . CJSON::encode($returnVal) . "); $('#dialogSPK').dialog('close');return false;"
                ));
            }
        ),
        'nosuratperjanjiankerja',
        array(
            'name' => 'tglsuratperjanjian',
            'value' => '$data->tglsuratperjanjian',
            'filter' => false,
        ),
        'namapekerjaan',
        'namapembuatkomitmen',
        'alamat',
        'nomor_dokumen'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
