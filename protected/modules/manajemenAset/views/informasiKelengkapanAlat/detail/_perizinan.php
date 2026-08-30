<style>
    .tutup-date{
        width:200px;
        height:35px;
        position:absolute;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Detail Perizinan</div>
    </div>
    <div class="panel-body">

        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'pemakaianbahp-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                //'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
                'focus'=>'#no_pendaftaran',
        )); ?>

        <div class="row-fluid">
            <div class="span6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'invperizinan_no', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'invperizinan_no', array('placeholder'=>'Ketik No. Perizinan','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group tanggal-diterima-form">
                    <?php echo $form->labelEx($model, 'invperizinan_tgl', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="timpa" ></div>
                        <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->invperizinan_tgl)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->invperizinan_sdtgl)) ?>">
                            <i class="entypo-calendar"></i>
                            <span ><?php echo date('F d, Y', strtotime($model->invperizinan_tgl)) ?> - <?php echo date('F d, Y', strtotime($model->invperizinan_sdtgl)) ?></span>
                            <?php echo $form->hiddenField($model,'invperizinan_tgl', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model,'invperizinan_sdtgl', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'pelaksana_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute' => 'pelaksana',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                setPelaksana(ui.item);
                                            return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 custom-only', 'placeholder'=>'Ketik Nama Pelaksana',
                                    'id'=>'nama_pegawai',
                                ),
                                'tombolDialog' => array(
                                    'idDialog' => 'dialogPegawai',
                                ),
                            ));
                        ?>
                        <?php echo $form->error($model,'pelaksana_id'); ?>                        
                        <?php echo $form->hiddenField($model,'pelaksana_id',array('id'=>'pelaksana_id')); ?>
                    </div>
                </div>
                <div class="control-group ">
                        <?php echo $form->labelEx($model, 'invperizinan_ket', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'invperizinan_ket', array('placeholder'=>'Keterangan Perizinan','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label("Dokumen&nbsp",'lampiranfile_1',['class'=>'control-label']);?>
                    <div class="controls">
                        <div class="<?= !empty($model->lampiranfile_1)?'':'hide' ?>">
                            <?= CHtml::link('<u>'.$model->lampiranfile_1.'</u>', $this->createUrl('Unduh', array('id' => $model->invperizinan_id,'lampiran'=>1)), array('title' => 'Unduh File', 'rel' => 'tooltip','class'=>'non-hide')); ?>
                        </div>
                        
                        <div class="<?= !empty($model->lampiranfile_2)?'':'hide' ?>">
                            <?= CHtml::link('<u>'.$model->lampiranfile_2.'</u>', $this->createUrl('Unduh', array('id' => $model->invperizinan_id,'lampiran'=>2)), array('title' => 'Unduh File', 'rel' => 'tooltip','class'=>'non-hide')); ?>
                        </div>
                        
                        <div class="<?= !empty($model->lampiranfile_3)?'':'hide' ?>">
                            <?= CHtml::link('<u>'.$model->lampiranfile_3.'</u>', $this->createUrl('Unduh', array('id' => $model->invperizinan_id,'lampiran'=>3)), array('title' => 'Unduh File', 'rel' => 'tooltip','class'=>'non-hide')); ?>
                        </div>
                    </div>                    
                </div>                
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>


<script>
    $(document).ready(function(){
        $("#pemakaianbahp-form").find('input,select,textarea').attr('disabled',true);
        $("#pemakaianbahp-form").find('.add-on,button,a:not(.non-hide)').hide();
        
        $(".tanggal-diterima-form").find('.timpa').addClass('tutup-date');
    })
</script>