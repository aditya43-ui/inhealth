<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'dokumenpengadaan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>


	<?php echo $form->errorSummary($model); ?>
        <?php 
            if (!empty($_GET['update'])) {
                 $disabled = true;
             } else {
                 $disabled = false;
             }
         ?>
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model,'dokumenpengadaan_jenistransaksi', LookupM::getItems("jenistransaksipengadaan"),
                    array('disabled' => $disabled, 'onchange' => 'setDokumen()', 'class' => 'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model,'jenispengadaan_id', Chtml::listData(JenispengadaanM::model()->findAllByAttributes(array('jenispengadaan_aktif'=>true)),'jenispengadaan_id','jenispengadaan_nama'),
                    array('disabled' => $disabled, 'onchange' => 'setDokumen()', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model,'metodepengadaan_id', Chtml::listData(MetodepengadaanM::model()->findAllByAttributes(array('metodepengadaan_aktif'=>true), array('order' => 'metodepengadaan_nama asc')),'metodepengadaan_id','metodepengadaan_nama'),
                    array('disabled' => $disabled, 'onchange' => 'setDokumen()', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div style="max-width:100%;overflow-x: scroll;">
                <table id="tblDokumen" class="table table-responsive table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align: center;"> Nama Dokumen <span class="required"> * </span> </th>
                            <th style="text-align: center;"> Nama Lain </th>
                            <th style="text-align: center;"> Deskripsi </th>
                            <th style="text-align: center;"> Urutan </th>
                            <th style="text-align: center;" class="span2"> Status </th>
                            <th style="text-align: center;" class="span2"> Wajib </th>
                            <th style="text-align: center;"> ZIP </th>
                            <th style="text-align: center;"> RAR </th>
                            <th style="text-align: center;"> Word </th>
                            <th style="text-align: center;"> PDF </th>
                            <th style="text-align: center;"> Excel </th>
                            <th style="text-align: center;"> Image </th>
                            <th style="text-align: center;" class="span3"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
	
	<div class="row-fluid">
	<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        $this->createUrl('create'), 
                        array('class'=>'btn btn-default',
                                  'onclick'=>'return refreshForm(this);')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Dokumen Pengadaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php 
            $content = $this->renderPartial('pengadaan.views.tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->renderPartial($this->path_view.'_jsFunction', array('model' => $model, 'modDetail' => $modDetail, 'form' => $form)); ?>
<?php $this->endWidget(); ?>

        