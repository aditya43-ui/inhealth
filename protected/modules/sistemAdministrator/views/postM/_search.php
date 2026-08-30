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
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'penilaian-indikator-m-search',
        ));
?>

<br>
<table>
    <div class="row-fluid">
        <div class="col-md-6">
            <div class="control-group">
                    <?php echo CHtml::label("Nama Post", '', array('class' => 'control-label')); ?>
                <div class="controls">
<?php echo $form->textArea($model, 'post_judul', array('placeholder' => 'Nama Post', 'rows' => 5, 'cols' => 30, 'class' => 'required span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                </div>
            </div> 
            <div class="control-group">
                    <?php echo CHtml::label("Deskripsi", '', array('class' => 'control-label')); ?>
                <div class="controls">                            
<?php echo $form->textArea($model, 'post_desc', array('placeholder' => 'nama Lainnya', 'rows' => 5, 'cols' => 30, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="control-group">
                    <?php echo CHtml::label("Kategori", '', array('class' => 'control-label')); ?>
                <div class="controls"> 
<?php echo $form->textField($model, 'kategoripost_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>


                </div>
            </div>

            <div class="control-group">
                    <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
                <div class="controls">                            
<?php echo $form->checkBox($model, 'post_aktif', array('checked' => 'post_aktif')) . ' Aktif'; ?>

                </div>
            </div>
        </div>

    </div>
</table>
<div class="form-actions">
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>

</div>

<br>



<?php $this->endWidget(); ?>
