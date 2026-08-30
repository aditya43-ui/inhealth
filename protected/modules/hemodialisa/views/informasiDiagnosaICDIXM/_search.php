<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadiagnosa-icdixm-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'diagnosaicdix_kode'),
)); ?>
<?php //echo $form->textFieldRow($model,'diagnosaicdix_id',array('class'=>'span5')); ?>
<table>
    <tr>
        <td>
            <div class="control-group ">
                <label for="SADiagnosaICDIXM_diagnosaicdix_kode" class="control-label">Kode Diagnosa </label>
                <div class="controls">
                    <?php echo $form->textField($model,'diagnosaicdix_kode',array('class'=>'span3','maxlength'=>10, 'placeholder'=>'Ketik Kode Diagnosa')); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <label for="SADiagnosaICDIXM_diagnosaicdix_nama" class="control-label">Nama Diagnosa </label>
                <div class="controls">
                    <?php echo $form->textField($model,'diagnosaicdix_nama',array('class'=>'span3','maxlength'=>50, 'placeholder'=>'Ketik Nama Diagnosa')); ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php //cho $form->textFieldRow($model,'diagnosaicdix_namalainnya',array('class'=>'span5','maxlength'=>500)); ?>

<?php //echo $form->textFieldRow($model,'diagnosatindakan_katakunci',array('class'=>'span5','maxlength'=>500)); ?>

<?php //echo $form->textFieldRow($model,'diagnosaicdix_nourut',array('class'=>'span5')); ?>

<?php //echo $form->checkBoxRow($model,'diagnosaicdix_aktif',array('checked'=>'diagnosaicdix_aktif')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit',
    'ajax' => array(
     'type' => 'GET', 
     'url' => array("/".$this->route), 
     'update' => '#sadiagnosa-icdixm-grid',
     'beforeSend' => 'function(){
                          $("#sadiagnosa-icdixm-grid").addClass("animation-loading");
                      }',
     'complete' => 'function(){
                          $("#sadiagnosa-icdixm-grid").removeClass("animation-loading");
                      }',
    )));
    echo '&nbsp;'; ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
        array('class'=>'btn btn-danger',
              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        echo '&nbsp;';?>
    <?php 
        $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    echo '&nbsp;';
    ?>
</div>
<?php $this->endWidget(); ?>
