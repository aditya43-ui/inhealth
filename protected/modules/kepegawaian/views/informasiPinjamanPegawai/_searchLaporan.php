<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'laporan-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'tglpinjampeg'),
)); ?>
<div class="row">	
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">
                <?php echo $form->checkBox($model,'ceklistglpinjam'); ?>
                Tanggal Pinjam Pegawai
          </label>
            <div class="controls">  
                <?php $model->tglpinjampeg=MyFormatter::formatDateTimeForUser($model->tglpinjampeg); ?>
                <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tglpinjampeg',
                    'mode'=>'date',
//                                          'maxDate'=>'d',
                    'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                   ),
                    'htmlOptions'=>array('readonly'=>true,
                    'class'=>'dtPicker2',
                    'onkeypress'=>"return $(this).focusNextInputField(event)"),
                  )); ?>
                <?php $model->tglpinjampeg=MyFormatter::formatDateTimeForDb($model->tglpinjampeg); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">
                <?php echo $form->checkBox($model,'ceklis'); ?>
                Tanggal Jatuh Tempo
          </label>
            <div class="controls">  
                <?php $model->tgljatuhtempo=MyFormatter::formatDateTimeForUser($model->tgljatuhtempo); ?>
                <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tgljatuhtempo',
                    'mode'=>'date',
        //                                          'maxDate'=>'d',
                    'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                   ),
                    'htmlOptions'=>array('readonly'=>true,
                    'class'=>'dtPicker2',
                    'onkeypress'=>"return $(this).focusNextInputField(event)"),
                  )); ?>
                <?php $model->tgljatuhtempo=MyFormatter::formatDateTimeForDb($model->tgljatuhtempo); ?>
            </div>
        </div>
    </div>
</div>
	
<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$model, 
                    'attribute'=>'nama_pegawai',
                    // 'value'=>$namapegawai,
                    'sourceUrl'=> $this->createUrl('AutocompletePegawai'),
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 3,
                       'focus'=> 'js:function( event, ui ) {
                            $("#namapegawai").val( ui.item.nama_pegawai );
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            $("#namapegawai").val( ui.item.nama_pegawai);
                            return false;
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 ','id'=>"namapegawai"),
                )); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('/kepegawaian/informasiPinjamanPegawai/laporan'), array('class'=>'btn btn-danger')); ?>
</div>

<?php $this->endWidget(); ?>
