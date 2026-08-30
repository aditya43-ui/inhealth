<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search-laporan',
    'type' => 'horizontal',
        ));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="icon-white icon-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">
        <div class="search-form">

            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Supplier', 'supplier_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'supplier_id', CHtml::listData(SupplierM::getSupplierFarmasiItems(), 'supplier_id', 'supplier_nama'), array(//
                                'class' => 'form-control', 'multiple' => 'multiple'));
                            ?>
                        </div>
                    </div>
                </div>
	</div>
	<div class="panel-body">
			<div class="search-form">
			
			<div class="row">
				<div class="col-sm-6">
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
				<div class="clear"></div>
				<div class="col-sm-6">
					 <div class="control-group">
						<?php echo CHtml::label('Supplier','supplier_id', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'supplier_id',CHtml::listData(SupplierM::getSupplierFarmasiItems(), 'supplier_id', 'supplier_nama'),array(//
							'class'=>'form-control', 'multiple'=>'multiple')); ?>
						</div>
					</div>
				</div>
			</div>                          
				<?php //echo $form->dropDownListRow($model,'supplier_id',CHtml::listData($model->SupplierItems, 'supplier_id', 'supplier_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>


        </div>
    </div>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<?php $this->endWidget(); ?>
</div>