

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">            
            <?php
            $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'id'=>'caripengeluaranaset-form',
                    'type'=>'horizontal',
                    'focus'=>'#'.CHtml::activeId($model,'MAInfopengeluaranasetV_no_suratperintah'),
                    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

            )); ?>
            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group">
                         <label class="control-label">
                           Tanggal Pengeluaran
                        </label>           
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                           
                    <!-- isi -->
                    <div class="control-group">
                                	<?php echo CHtml::label('Jenis/Peruntukan','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->dropDownList($model, 'jenisperuntukan', LookupM::getItems('jenisperuntukan'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                                </div>
                            </div> 
                     
                </div>
                <div class="col-sm-6">
                   
                     <div class="control-group">
                        <?php echo Chtml::label("Nomor Surat Perintah",'', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php 
                                echo $form->textField($model, 'no_suratperintah',array('placeholder'=>'Nomer Surat Perintah'));
                            ?>
                        </div>
                    </div>     
                    
                    <!-- isi -->
                     <div class="control-group">
                        <?php echo Chtml::label("Pegawai Yang Mengeluarkan",'', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php 
                                echo $form->textField($model, 'pengeluaran_nama',array('placeholder'=>'Pegawai Yang Mengeluarkan'));
                            ?>
                        </div>
                    </div>   
                                        
                </div>
            </div>
            <!--fieldset class="box"-->
            <div class="form-action">
            <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>          
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
                echo CHtml::hiddenField('pendaftaran_id');
                echo CHtml::hiddenField('pasien_id');
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                array('class'=>'btn btn-default spasi',
                    'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
            ?>													
            <?php 
                $content = $this->renderPartial('../tips/transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw "></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'class' => 'btn btn-danger spasi',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>