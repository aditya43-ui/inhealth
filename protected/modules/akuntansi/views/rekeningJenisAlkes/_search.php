<?php
/**
* - digunakan sebagai Admin jenis obat alkes
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'search',
    'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
			<?php echo CHtml::label("Rekening",'',array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'rekening5_id', CHtml::listData(Rekening5M::model()->findAll(),
                'rekening5_id', 'nmrekening5'),array('empty' => '-- Pilih --', 'class'=>'required')); ?>
			</div>
		</div>
        <div class="control-group">
			<?php echo CHtml::label("Saldo Normal",'',array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'debitkredit', array('D' => 'Debit', 'K' => 'Kredit'),array('empty' => '-- Pilih --', 'class'=>'required')); ?>
			</div>
		</div>
        <div class="control-group">
			<?php echo CHtml::label("Ruangan",'',array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'),
                'ruangan_id', 'ruangan_nama'),array('empty' => '-- Pilih --', 'class'=>'required')); ?>
			</div>
		</div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
        <div class="col-sm-12">
            <div class="control-group">
                <?php echo CHtml::label("Jenis Obat Alkes",'',array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jenisobatalkes_id', CHtml::listData(AKJenisObatAlkesM::model()->findAll('jenisobatalkes_aktif = true'),
                    'jenisobatalkes_id', 'jenisobatalkes_nama'),array('empty' => '-- Pilih --', 'class'=>'required')); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="control-group">
                <?php echo CHtml::label("Jenis Transaksi",'',array('class' => 'control-label')); ?>
                <div class="controls">
                  <?php
                  $listJenisTransaksi = array('ispenerimaanoa' => 'Penerimaan Faktur',
                      'isreturpembelian' => 'Retur Penerimaan Faktur',
                      'ispenjualanresep' => 'Penjualan Resep',
                      'isreturoa'=>'Retur Penjualan Resep',
                      'isstokberkurangoa' => 'Pengurangan Stok Ruangan',
                      'isstokopnameoa'=>'Stok Opname Awal',
                      'isstokopnameoaberkurang'=>'Stok Opname Penyesuaian Berkurang',
                      'isstokopnameoabertambah'=>'Stok Opname Penyesuaian Bertambah',
                      'ismutasi'=>'Mutasi Ruangan',
                      'ispesmunahan'=>'Pemusnahan',
                      'isbahanproduksi'=>'Bahan Produksi',
                      'ishasilproduksi'=>'Hasil Produksi');
                   ?>
                    <?php echo $form->dropDownList($model,'jenistransaksi', $listJenisTransaksi,array('empty' => '-- Pilih --', 'class'=>'required')); ?>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit'));
    ?>
</div>
<?php $this->endWidget(); ?>
