<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dropCheck.css');
?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
   <style>
    #penjamin label.checkbox{
        width: 100px;
        display:inline-block;
    }
    label.checkbox{
        width:100px;
        display:inline-block;
    }
    </style>
    <div class="row">
         <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
                <?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>                         
        </div>         
    </div>  
    <div class="row">
        <div class="col-sm-6">
            <fieldset>
                <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'pelayanan',
                        'slide' => true,
                        'content' => array(
                            'content1' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Kelas Pelayanan',
                                'isi' => CHtml::hiddenField('filter', 'kelaspelayanan_id', array('disabled' => 'disabled')) . 
                                    '<div class="control-group">
                                        '.CHtml::label('Kelas Pelayanan','kelaspelayanan_id', array('class' => 'control-label')).' 
                                        <div class="controls">
                                            '.$form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array(
                                            'class'=>'form-control', 'multiple'=>'multiple')).'											
                                        </div>
                                    </div>',
                                'active' => true,
                            ),
                        ),
            //                                    'htmlOptions'=>array('class'=>'aw',)
                    ));
                ?>
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset>
                <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'kunjungan',
                        'slide' => true,
                        'content' => array(
                            'content2' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Jenis Penjamin',
                                'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
                                    '<div class="control-group">
                                        '.CHtml::label('Jenis Penjamin','carabayar_id', array('class' => 'control-label')).' 
                                        <div class="controls">
                                            '.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),array(
                                            'class'=>'form-control', 'multiple'=>'multiple')).'											
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        '.CHtml::label('Penjamin','penjamin_id', array('class' => 'control-label')).' 
                                        <div class="controls">												 
                                            '.$form->dropDownList($model,'penjamin_id',
                                                array(),
                                                array('class'=>'form-control', 'multiple'=>'multiple')).' 													
                                        </div>
                                    </div>',
                                'active' => true,
                            ),
                        ),
            //                                    'htmlOptions'=>array('class'=>'aw',)
                    ));
                ?>
            </fieldset>
        </div>
    </div>    
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
            array('class' => 'btn btn-default',
            'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;')); ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script type="text/javascript">
function checkSemua() {
            if ($("#checkSemuaid").is(":checked")) {
                $('.penjamin input[name*="PSLaporanbiayapelayanan"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('.penjamin input[name*="PSLaporanbiayapelayanan"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
}

	function showCheckboxes2() {
        $("#multiselect2").find("#checkboxes2").slideToggle('fast');
               
    }
    
        
   $(document).bind('click', function(e) {
    var $clicked = $(e.target);
    if (!$clicked.parents().hasClass("multiselect")){ $("#checkboxes2").hide();}
  });
</script>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>