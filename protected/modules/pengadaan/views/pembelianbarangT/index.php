
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-shopping-cart"></i> Transaksi <b>Permintaan Pembelian Barang</b>
                    <span class="pull-right">
                        <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                        </a>
                    </span>
                </div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
                                    'Informasi Rencana Kebutuhan Barang Umum'=>Yii::app()->request->getUrlReferrer(),
                                    'Transaksi Permintaan Pembelian Barang',
                                );
//				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'modDetails'=>$modDetails, 'modPesan'=>$modPesan,'modBeli'=>$modBeli, 'renc'=>$renc)); ?>
            </div>
        </div>
    </div>
</div>  
