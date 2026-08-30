<?php
/**
* - digunakan sebagai Informasi Kalibrasi
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kalibrasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype'=>'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onclick'=>'cekDisabled(this);',),
    'focus' => '#',
        ));
?>

<div class="panel panel-gradient">	

    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Detail Kalibrasi</div>
    </div>
    <?php echo $form->errorSummary($model); ?>
    <div class="panel-body">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    <i class="entypo-credit-card"></i> Kalibrasi																	
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">  
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Peralatan','nmbarang',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'invperalatan_id', array('readonly' => true)); ?>
                                <?php echo $form->textField($model, 'invperalatan_nama', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nomor Aset','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'no_aset', array('readonly' => true)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Nomor Seri','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'peralatan_noseri', array('readonly' => true)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <?php echo CHtml::label('Lokasi Aset','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'lokasiaset_namalokasi', array('readonly' => true)); ?>
                            </div>
                        </div>
                        
                         <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Kalibrasi','', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tglkalibrasi', array('readonly' => true)); ?>
                            </div>
                        </div>
                         <div class="control-group ">
                            <?php echo CHtml::label('Berlaku Sampai','', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'berlaku_sdtgl', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Pelaksana', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <textarea class="span3" rows="6" readonly="true"><?php  
                                    $load_det = MAInvkalibrasidetT::model()->findAll(" invkalibrasi_id = ".$model->invkalibrasi_id." ");

                                    if (!empty($load_det)){
                                        $a = 1;
                                        foreach($load_det as $det){
                                            echo $a.'. '.trim($det->pegawai->namaLengkap).'&#13;';
                                            $a++;
                                        }
                                        
                                    }
                                
                                ?> </textarea>   
                                 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                                <?php echo CHtml::label('Nomor Kalibrasi','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nokalibrasi', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Data Vendor Pemeliharaan','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'vendor_nama', array('readonly' => true)); ?>                        
                            </div>
                        </div>
                        
                        <div class="control-group">
                                <?php echo CHtml::label('Keterangan','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'invkalibrasi_ket', array('rows' => 5, 'cols' => 50, 'class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>

                    <div class="control-group">
                                <?php echo CHtml::label("Dokumen",'',array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                    if($model->lampiran_berkas == NULL){
                                        echo 'Tidak Ada Dokumen';
                                    }else{
                                ?>
                                    <?php 
                                        $path = ParamsUrl::pathKalibrasiPdfDirectory() . $model->lampiran_berkas;
                                        
                                        if (file_exists($path)) {
                                            if (strpos($model->lampiran_berkas, '.pdf')){
                                                echo Chtml::link($model->lampiran_berkas, ParamsUrl::urlKalibrasiPdfDirectory() . $model->lampiran_berkas,['target'=>'_BLANK']); 
                                            }else{                                            
                                                echo Chtml::link($model->lampiran_berkas, $this->createUrl('unduh',['id'=>$model->invkalibrasi_id]),[]); 
                                            }
                                        }else{
                                            echo Chtml::link($model->lampiran_berkas, $this->createUrl('unduh',['id'=>$model->invkalibrasi_id]),[]); 
                                        }
                                        
                                    ?>
                                <?php
                                    }
                                ?>
                            </div>
                    </div>
                        <div class="control-group">
                                <?php echo CHtml::label("Laik Pakai",'',array('class' => 'control-label')); ?>

                            <div class="controls">
                                <?php echo $form->checkBox($model,'islaikpakai', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class'=>'btn btn-red','onclick'=>'window.history.back(); return false;', 'style'=>'color: white;')) ?>
    </div>
</div>
<?php $this->endWidget(); ?>