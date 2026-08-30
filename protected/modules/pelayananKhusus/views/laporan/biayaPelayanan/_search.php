<?php
/**
 * view yang digunakan untuk menampilkan form pencarian
 *
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Laporan Biaya Pelayanan
        </div>
    </div>
    <div class="panel-body">
<div class="search-form" style="">
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

    </style>
    
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <div class="control-group">            
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
    
    <div class="clear"></div>
    <hr>
    
    <div class="col-sm-6">
        <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'pelayanan',
                'slide' => true,
                'content' => array(
                    'content2' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Kelas Pelayanan',
                        'isi' => CHtml::hiddenField('filter', 'kelaspelayanan_id', array('disabled' => 'disabled')) . 
                            '<div class="control-group">
                                '.CHtml::label('Kelas Pelayanan','kelaspelayanan_id', array('class' => 'control-label')).' 
                                <div class="controls">
                                    '.$form->dropDownList($model,'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array(
                                    'class'=>'form-control', 'multiple'=>'multiple')).'											
                                </div>
                            </div>',
                        'active' => true,
                    ),
                ),
            ));
        ?>		
    </div>
    
    <div class="col-sm-6">
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'carabayar',
            'slide' => true,
            'content' => array(
                'content3' => array(
                    'multi' => 'multi',
                    'header' => 'Berdasarkan Jenis Penjamin',
                    'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                    '<div class="control-group">
											' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
											<div class="controls">
												' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple')) . '											
											</div>
										</div>
										<div class="control-group">
											' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
											<div class="controls">												 
												' . $form->dropDownList($model, 'penjamin_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . ' 													
											</div>
										</div>',
                    'active' => true,
                ),
            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
        ));
        ?>
    </div>
                          
    <div class="clear"></div>
    
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
		<?php
 echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
?> 
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
    </div>
</div>

<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>