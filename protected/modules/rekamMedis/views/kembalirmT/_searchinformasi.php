<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'id'=>'rmpengirimanrm-t-search',
                'type'=>'horizontal',
)); ?>

<table>
    <tr>
        <td><legend class="rim">Pencarian</legend>
            <?php //echo $form->textFieldRow($model, 'tglrekammedis', array('class' => 'span3')); ?>
            <div class="control-group">
                                <?php echo CHtml::label('Tgl. Penerimaan','tglpengirimanrm',array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tgl_awal',
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                                'maxDate' => 'd',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                    )); 
                                            ?>
                                </div>
                                <?php echo CHtml::label('Sampai dengan','tgl_akhir',array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tgl_akhir',
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                                'maxDate' => 'd',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                    )); ?>
                                </div>
            <?php echo $form->textFieldRow($model,'pasienNama',array('class'=>'span3')); ?>
        </td>
    </tr>
</table>

	<div class="form-actions">
                    <?php
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit'));
                        echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                                Yii::app()->createUrl($this->module->id.'/'.pengirimanrmT.'/informasi'), 
                                                array('class' => 'btn btn-default',
                                                      'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
 
                        $content = $this->renderPartial('rekamMedis.views.tips.informasi',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                    ?>
	</div>

<?php $this->endWidget(); ?>

<!--======================== Begin Widget Dialog Login Pemakai =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php 
$modPasien = new PasienM(); 
$modPasien->unsetAttributes();
if (isset($_GET['LoginpemakaiK'])){
    $modPasien->attributes = $_GET['PasienM'];
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pasien-grid',
    'dataProvider'=>$modPasien->search(),
    'filter'=>$modPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectPasien",
                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
                                                                          \$(\"#dialogPasien\").dialog(\"close\");"
                                             )
                             )',
                        ),
                        'nama_pasien',
                        'no_rekam_medik',
                        'jeniskelamin',
                        'tanggal_lahir',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php $this->endWidget(); ?>
<!--=============================== endWidget Dialog Login Pemakai ============================-->

<!--=============================== BeginWidget Dialog Rekam Medik ============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogNoRekamMedik',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php 
$modPasien = new PasienM(); 
$modPasien->unsetAttributes();
if (isset($_GET['LoginpemakaiK'])){
    $modPasien->attributes = $_GET['PasienM'];
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'norekammedik-grid',
    'dataProvider'=>$modPasien->search(),
    'filter'=>$modPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectPasien",
                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
                                                                          \$(\"#dialogNoRekamMedik").dialog(\"close\");"
                                             )
                             )',
                        ),
                        'nama_pasien',
                        'no_rekam_medik',
                        'jeniskelamin',
                        'tanggal_lahir',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php $this->endWidget(); ?>
<!--=============================== endWidget Dialog Rekam Medik ============================-->
