<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'remunerasikedisiplinan-t-search',
    'type'=>'horizontal',
)); 
?>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Reseptur", 'tgl_rekam', array('class' => 'control-label')) ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'noresep', array('placeholder' => 'No. Resep', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($model, 'obatalkes_nama', array('placeholder' => 'Nama Obat', 'class' => 'span4 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($model, 'satuankecil_nama', array('placeholder' => 'Satuan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->dropDownListRow($model, 'status', LookupM::getItems('statusinfopemberianobat'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('InformasiRemunerasiKedisiplinan/index'), array('class'=>'btn btn-danger'));?>
    <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 

$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#remunerasikedisiplinan-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);  
    ?>
</div>

<?php $this->endWidget(); ?>