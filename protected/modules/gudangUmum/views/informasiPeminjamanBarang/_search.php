<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'informasipeminjamanbrg-r-search',
        'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Peminjaman", 'peminjamanbrg_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Peminjam <span class='required'>*</span>",'pegpeminjam_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'pegpeminjam_nama',array('class'=>'span3','placeholder'=>'Ketik Nama Peminjam')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Nomor Peminjaman <span class='required'>*</span>",'pegpeminjam_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'peminjamanbrg_nomor',array('class'=>'span3','placeholder'=>'Ketik Nomor Peminjaman Barang')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span3','placeholder'=>'Ketik Nama Ruangan')); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            $this->createUrl('index'), 
                            array('class'=>'btn btn-default',
                                'onclick'=>'return refreshForm(this);'));  ?>
            <?php  
                            $content = $this->renderPartial('gudangUmum.views.informasiStokBarang.tips.informasi',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?> 
    </div>
</div>
<?php $this->endWidget(); ?>