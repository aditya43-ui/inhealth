<style>
    #ui-datepicker-div{
        z-index: 1000 !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="fas fa-shopping-cart"></i> Pembelian Langsung</div>
    </div>
    <div class="panel-body">

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembelianlangsung-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>

        <div class="panel panel-success" id="form-rencanakebutuhan">
            <div class="panel-heading">
                <div class="panel-title judul"><i class="far fa-file-alt"></i> Data Pembelian</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPenerimaanBarang', array('form' => $form, 'format' => $format, 'modPenerimaanBarang' => $modPenerimaanBarang)); ?>
            </div>
        </div>



        <div class="panel panel-success" id="form-tambahobatalkes">
            <div class="panel-heading">
                <div class="panel-title judul"><i class="far fa-file-alt"></i> Obat dan Alat Kesehatan</div>
            </div>
            <div class="panel-body">
                <?php if (!isset($_GET['sukses'])) { ?>
                <?php $this->renderPartial('_formObatPenerimaanBarang', array('modPenerimaanBarang' => $modPenerimaanBarang, 'modPermintaanPembelian' => $modPermintaanPembelian)); ?>
                <?php } ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="far fa-file-alt"></i> Tabel Pembelian Langsung</div>
                    </div>
                    <div class="panel-body overflow-x">        
                        <table class="items table table-striped table-bordered table-condensed" id="table-obatalkespasien">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Asal Barang</th>
                                    <th>Kategori / Nama Obat</th>
                                    <th>No. Batch</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Satuan</th>
                                    <th>Jumlah Pesan</th>
                                    <th>Jumlah Terima</th>
                                    <th>Harga Satuan</th>
                                    <th>Keringanan (%)</th>
                                    <th>Keringanan Total (Rp.)</th>
                                    <th>Sub Total</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($modDetails) > 0) {
                                    foreach ($modDetails AS $i => $modPenerimaanBarangDetail) {
                                        $modStokObatAlkes = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id' => $modPenerimaanBarangDetail->penerimaandetail_id));
                                        $modPenerimaanBarangDetail->nobatch = $modStokObatAlkes->nobatch;
                                        echo $this->renderPartial('_rowObatPenerimaanBarang', array('modPenerimaanBarangDetail' => $modPenerimaanBarangDetail, 'modPenerimaanBarang' => $modPenerimaanBarang, 'format' => $format));
                                    }
                                }
                                ?>
                            <tfoot>
                                <tr>
                                    <td colspan="9">Total</td>
                                    <td><?php echo CHtml::textField('total', '', array('class' => 'span2 integer', 'style' => 'width:90px;', 'readonly' => true)) ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                        <?php echo CHtml::hiddenField('ppn', '0', array()); ?>
                <?php echo CHtml::hiddenField('pph', '0', array()); ?>  
                    </div>
                </div>
            </div>
        </div>         


        
    
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if ($modPenerimaanBarang->isNewRecord) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                }


                if (!isset($_GET['frame'])) {
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'));
                    echo "&nbsp;";
                }
                if ($modPenerimaanBarang->isNewRecord) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4046*/
                    echo "&nbsp;";
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4046*/
                    echo "&nbsp;";
                }


                $content = $this->renderPartial('tips/tipsPenerimaanBarang', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?> 
            </div>
        </div>
        <?php $this->endWidget(); ?>

        <?php $this->renderPartial('_jsFunctions', array('modPenerimaanBarang' => $modPenerimaanBarang, 'modFakturPembelian' => $modFakturPembelian, 'modPermintaanPembelian' => $modPermintaanPembelian)); ?>
    </div>
</div>