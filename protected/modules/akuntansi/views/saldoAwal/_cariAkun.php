<div class="search-form">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarianobat-form',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($modAkun,'jenisstokopname'),
    'htmlOptions' => array(),
        ));
?>
    <div class="row-fluid">        
       <div class="col-sm-6">
			<div class="control-group">
				<?php echo CHtml::label("Periode Akuntansi","",array('class' => 'control-label')) ?>
				<div class="controls">			
					<?php echo $form->dropDownList($modAkun,'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAllByAttributes(array(),array('order'=>'tglperiodeposting_awal ASC')), "periodeposting_id", "periodeposting_nama"),array('empty'=>'-- Pilih --')); ?>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="control-group">
				<?php echo CHtml::label("Tipe Akun","",array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modAkun,'tiperekening_id', CHtml::listData(AKTiperekeningM::model()->findAll(" tiperekening_aktif = TRUE ORDER BY tiperekening ASC "), "tiperekening_id", "tiperekening"),array('empty'=>'-- Pilih --')); ?>
				</div>
			</div>
		</div>
        
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tampilkan', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit','onclick'=>'return cekData();')); ?>
        <?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
    </div>
<?php $this->endWidget(); ?>
</div> 

<script>
    function cekData()
    {
        var tipe = $("#<?php echo CHtml::activeid($modAkun, 'tiperekening_id')?> option:selected").val();
		var periode = $("#<?php echo CHtml::activeid($modAkun, 'periodeposting_id')?> option:selected").val();
        
        if (tipe == ''){
            myAlert("Maaf, <b>Tipe Rekening</b> belum dipilih ","Perhatian");     
            return false;
        }
		
		if (periode == ''){
            myAlert("Maaf, <b>Periode Akuntansi</b> belum dipilih","Perhatian");     
            return false;
        }
        
    }
</script>