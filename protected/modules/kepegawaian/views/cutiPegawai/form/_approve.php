<?php
/**
* - digunakan untuk menampilkan form perubahan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>

<div class="panel panel-success">
    <?php
        //if (isset($_GET['sukses'])){            
            $this->widget('bootstrap.widgets.BootAlert');
        //}
    ?>
    <div class="panel-heading">
        <div class="panel-title">
            Proses Penerimaan Permohonan Cuti
        </div>
    </div>
        <div class="panel-body">
            <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'id'=>'sapegawai-m-form',
                    'enableAjaxValidation'=>false,
                        'type'=>'horizontal',
                        'htmlOptions'=>array(
                            'enctype'=>'multipart/form-data',
                            'onKeyPress'=>'return disableKeyPress(event)',
                            'onsubmit' => 'return cekdata(this);return false;'                            
                            ),
                        'focus'=>'#',
            )); ?>
            <div class="row">
            <?php echo $form->hiddenField($model,'pegawaicuti_id') ?>
            <div class="control-group">
                       <?php echo $form->labelEx($model,'tglditetapkanskcuti',array('class'=>'control-label')); ?>
                       <div class="controls">
                           <?php   
                           $this->widget('MyDateTimePicker',array(
                               'model'=>$model,
                               'attribute'=>'tglditetapkanskcuti',
                               'mode'=>'date',
                               'options'=> array(
                                   'showOn' => false,
                                   // 'maxDate' => 'd',
                                   'yearRange'=> "-150:+0",
                               ),
                               'htmlOptions'=>array('readonly'=>true,'placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                               ),
                       )); ?>    
                       </div>
                   </div>
            <?php echo $form->textFieldRow($model,'noskcuti',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')) ?>
            <?php echo $form->dropDownListRow($model,'pegpengganti_id',PegawairuanganV::model()->getDropPegawai(),array('empty' => '-- Pilih --')) ?>
            <?php echo $form->dropDownListRow($model,'status_cuti', Params::getStatusCuti(),array('class' => 'required','empty' => '-- Pilih --')) ?>
            </div>
            <?php
            
            if (!isset($_GET['sukses'])){
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')) : 
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),
                array('class' => 'btn btn-danger', 'type'=>'submit'));
            }else{
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')) : 
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),
                array('class' => 'btn btn-danger', 'type'=>'button','disabled'=>true));
            }
        ?>
            <?php
                $this->endWidget();
            ?>

        </div>
        
</div>


<script>
    function cekdata(obj){
        var status = $("#<?php echo CHtml::activeId($model, 'status_cuti') ?>");
        var pengganti = $("#<?php echo CHtml::activeId($model, 'pegpengganti_id') ?>");
        var pengganti = $("#<?php echo CHtml::activeId($model, 'pegpengganti_id') ?>");
        var tglsk = $("#<?php echo CHtml::activeId($model, 'tglditetapkanskcuti') ?>");
        var nosk = $("#<?php echo CHtml::activeId($model, 'noskcuti') ?>");
        var jabatan_id = '<?php echo Params::getKepalaUnitAppByArr(Yii::app()->user->getState('jabatan_id'))?>';
                
//        if (jabatan_id != ''){
////            if (tglsk.val() != '' && nosk.val() != ''){
//                tglsk.attr("style","");
//                nosk.attr("style","");
                if (status.val() == '<?php echo Params::STATUS_CUTI_DISETUJUI ?>'){
//                    status.attr("style","");
//                    if (pengganti.val() == ''){
//                        myAlert("Maaf, Pegawai Pengganti belum dipilih");
//                        pengganti.attr("style","border:1px solid red;");
//                        return false;
//                    }else{
                        $("#sapegawai-m-form").submit();
//                    }
                }else{
                    if (status.val() == ''){
                        myAlert("Maaf, Status tidak boleh kosong!");
                        status.attr("style","border:1px solid red;");
                        return false;
                    }else{
//                        pengganti.attr("style","");
                        status.attr("style","");
                        $("#sapegawai-m-form").submit();
                    }
                }
//            }else{
//                myAlert("Maaf, Tanggal dan No SK tidak boleh kosong!");
//                tglsk.attr("style","border:1px solid red;");
//                nosk.attr("style","border:1px solid red;");
//                return false;
//            }
//        }
//        else{
//            myAlert("Maaf, Anda tidak punya akses untuk melakukan fungsi ini");
//            return false;
//        }
        
        return false;
    }
</script>