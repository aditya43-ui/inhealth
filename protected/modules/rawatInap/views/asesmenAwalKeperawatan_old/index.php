<style>
    .group-title{
        position: relative;
        top:-10px;       
        left:15px;               
        color:#001F3E;
        background: #fff;
        padding:10px;
    }
    
    .panel-darkk {

        border-color: #001F3E;
        -webkit-border-radius: 3px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 3px;
        -moz-background-clip: padding;
        border-radius: 3px;
        background-clip: padding-box;

    }
    
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">    
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'asesmenedukasi-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        ));
        
        echo $this->renderPartial($this->path_view.'_dataPasien', array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model' => $model
        ), true);
        
        echo $this->renderPartial($this->path_view.'form/_formAwal', array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model,
            'form'=>$form
        ), true);
                          
        ?>
        <p>&nbsp;</p>
        <div class="col-sm-6">
            <?php echo $this->renderPartial($this->path_view.'form/_formB1',array('model'=>$model,'form'=>$form)); ?>
        </div>
        
        <div class="col-sm-6">
            <?php echo $this->renderPartial($this->path_view.'form/_formB2',array('model'=>$model,'form'=>$form)); ?>
        </div>
        
        <div class="clear"></div>
        <p>&nbsp;</p>
         <div class="col-sm-6">
            <?php echo $this->renderPartial($this->path_view.'form/_formB3',array('model'=>$model,'form'=>$form)); ?>
        </div>
        
        <div class="col-sm-6">
            <?php echo $this->renderPartial($this->path_view.'form/_formB4',array('model'=>$model,'form'=>$form)); ?>
        </div>
        <div class="clear"></div>
        <p>&nbsp;</p>
         <div class="col-sm-6">
            <?php echo $this->renderPartial($this->path_view.'form/_formB5',array('model'=>$model,'form'=>$form)); ?>
        </div>
        
        <div class="col-sm-6">
            <?php echo $this->renderPartial($this->path_view.'form/_formB6',array('model'=>$model,'form'=>$form)); ?>
        </div>
        <div class="clear"></div>
        <p>&nbsp;</p>
         <div class="col-sm-12">
            <?php echo $this->renderPartial($this->path_view.'form/_formPemeriksaanMental',array('model'=>$model,'form'=>$form)); ?>
        </div>
        <div class="clear"></div>
        <p>&nbsp;</p>
         <div class="col-sm-12">
            <?php echo $this->renderPartial($this->path_view.'form/_formSosialEkonomi',array('model'=>$model,'form'=>$form)); ?>
        </div>
        
        <p>&nbsp;</p>
         <div class="col-sm-12">
            <?php echo $this->renderPartial($this->path_view.'form/_formKetergantungan',array('model'=>$model,'form'=>$form)); ?>
        </div>
        
        <p>&nbsp;</p>
         <div class="col-sm-12">
            <?php echo $this->renderPartial($this->path_view.'form/_formLanjutan',array('model'=>$model,'form'=>$form,'modPendaftaran'=>$modPendaftaran)); ?>
        </div>
              
        <div class="clear"></div>
        
        <div class="form-actions">
                <?php
                        if($model->isNewRecord){
                                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>'btn btn-primary submit', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','enabled'=>true));
                                echo "&nbsp;";
                                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false;",'disabled'=>'true', 'style'=>'cursor:not-allowed;'));
                        }else{
                                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','onclick'=>"",'disabled'=>false));
//                                echo "&nbsp;";
//                                echo CHtml::link(Yii::t('mds', 'Input Asesmen Lainnya'), $this->createUrl('/rawatInap/AsesmenAwalKeperawatan/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
                                echo "&nbsp;";
                                echo CHtml::link(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),'#', array('class'=>'btn btn-succes','onclick'=>'print();'));
                        }
                ?>
                
                <?php 
                        $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                        $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                ?>
        </div>
        
        <?php
        $this->endWidget(); 
        
        echo $this->renderPartial($this->path_view.'_dialog', array('model'=>$model,), true);
        
        echo $this->renderPartial($this->path_view.'_jsFunction', array('model'=>$model,'modAsesmenNyeri' => $modAsesmenNyeri,'modResikoJatuh' => $modResikoJatuh), true);
        
        ?>
        
        
    </div>
</div>

<?php

echo CHtml::hiddenField("tampungDiagnosa",'',array('class'=>'readonly'));

//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosaMasuk',
    'options' => array(
        'title' => 'Daftar Diagnosis 10',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 720,
        'resizable' => false,
    ),
));
?>
<?php
    $modDiagnosa = new PPDiagnosaM('searchDialog');
    $modDiagnosa->unsetAttributes();
    if(isset($_GET['PPDiagnosaM'])) {
        $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'giagnosautama-m-grid',
            'dataProvider'=>$modDiagnosa->searchDialog(),
            'filter'=>$modDiagnosa,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-condensed',
            'columns'=>array(
				array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                        
                        $attr = CJSON::encode($data->attributes);
                        
                        return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class'=>'btn-small',
                            'id'=>'selectPasien',
                            'onclick'=>"
                                $('#RIAsesmenAwalKeperawatanT_diagnosa_masuk').val('".$data->diagnosa_nama."');
                                $('#dialogDiagnosaMasuk').dialog('close'); return false;"
                        ));
                    },
                ),
                'diagnosa_kode',
                array( 
                    'header'=>'Diagnosis',
                    'name'=>'diagnosa_nama',
                    'value'=>'$data->diagnosa_nama',
                ), 
                array(
                    'header'=>'Catatan',
                    'name'=>'diagnosa_namalainnya',
                    'value'=>'$data->diagnosa_namalainnya', 
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
);
$this->endWidget();
?>

<script>
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
</script>