<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'penutupan-info-search',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
?>
<style>

label.checkbox{
        width:150px;
        display:inline-block;
}
</style>
<div class="row-fluid">
        <div class="col-sm-6">
                <?php $format = new MyFormatter(); ?>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo $form->hiddenField($model, 'filter', array('readonly'=>'TRUE')); ?>
                <div class="control-group">
                        <?php echo CHtml::label("Tanggal Penutupan",'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                        <i class="entypo-calendar"></i>
                                        <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                        </div>
                </div>  
            <?php echo $form->textFieldRow($model,'nopenutupan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </div>

        <div class="col-sm-6">
                <div class="control-group">
                        <?php echo CHtml::label('Periode Akuntansi', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <?php
                                        echo $form->dropDownList($model,'rekperiod_id',CHtml::listData(RekperiodM::model()->findAll(),
                                                        'rekperiod_id','deskripsi'),array('class'=>'span3','empty'=>'-- Pilih --')); 
                                ?>
                        </div>
                </div>
        </div>
</div>
<div class="form-actions">
    <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                            array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'))."&nbsp&nbsp";?>
<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.MyIcon::getIcons('ulang').'"></i>')), 
        Yii::app()->createUrl($this->module->id.'/PenutupanPeriodeAkuntansiT/informasi'), 
        array('class'=>'btn btn-danger',
           	  'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
?>
    <?php 
     $tips = array(
                    '0' => 'cari',
                    '1' => 'ulang2'
                );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>
<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printInformasi');
    $jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penutupan-info-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);    
?>
