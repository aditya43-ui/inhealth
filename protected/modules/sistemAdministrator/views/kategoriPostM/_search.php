<?php
/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'penilaian-indikator-m-search',
        'type' => 'horizontal',
)); ?>

<br>
<table>
    <div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Kategori Berita", '', array('class' => 'control-label')); ?>
            <div class="controls">
                
              <?php echo $form->textField($model,'kategoripost_nama',array('placeholder' => 'Kategori Berita','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>
            </div>
        </div> 

        <div class="control-group">
            <?php echo CHtml::label("Nama Lainnya ", '', array('class' => 'control-label')); ?>
            <div class="controls">                            
               
                <?php echo $form->textField($model,'kategoripost_namalain',array('placeholder' => 'Nama Lainnya','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>
                
            </div>
        </div>

    </div>

    <div class="col-md-6">
        
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
            <div class="controls">                            
                <?php echo $form->checkBox($model, 'kategoripost_aktif',array('checked'=>'kategoripost_aktif')) . ' Aktif'; ?>
            </div>
        </div>
    </div>

</div>
</table>
	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>

        </div>
       
<br>



<?php $this->endWidget(); ?>
