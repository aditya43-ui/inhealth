<?php $linkHalaman = CustomFunction::getUrlByMenuID(1212); ?>
<style>
    .integerfloat, .integer-decimal {
        text-align: right;
    }
    
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Penerimaan Obat dan Alkes</strong></div>
            </div>
            <div class="panel-body">
            <?php     
                $this->breadcrumbs=array(
                        'Informasi Permintaan Pembelian Obat & Alkes'=>Yii::app()->request->getUrlReferrer(),
                        'Transaksi Penerimaan Obat dan Alkes',
                );
                    if(isset($_GET['sukses'])){
                            Yii::app()->user->setFlash('success',"Data Penerimaan Obat dan Alkes berhasil disimpan !");
                    }
            ?>
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

            <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'id'=>'penerimaanbarang-form',
                    'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            )); ?>

               <?php 
                    if(Yii::app()->user->getState('ispenerimaanlangsung') == false){
                        $this->renderPartial($this->path_view.'_formPermintaan', array('form'=>$form,'format'=>$format,'modPermintaanPembelian'=>$modPermintaanPembelian,'modPenerimaanBarang'=>$modPenerimaanBarang));
                    }
               ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Penerimaan Obat Alkes</div>
                    </div>
                    <div class="panel-body" id="form-rencanakebutuhan">
                        <?php $this->renderPartial($this->path_view.'_formPenerimaanBarang', array('form'=>$form,'format'=>$format,'modPenerimaanBarang'=>$modPenerimaanBarang,'modUangMuka'=>$modUangMuka)); ?>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Penerimaan Obat Alkes</div>
                    </div>
                    <div class="panel-body" id="form-tambahobatalkes">
                    <?php 
                        if(!isset($_GET['sukses']) && Yii::app()->user->getState('ispenerimaanlangsung') == true){ 
                             $this->renderPartial($this->path_view.'_formObatPenerimaanBarang',array('modPenerimaanBarang'=>$modPenerimaanBarang,'modPermintaanPembelian'=>$modPermintaanPembelian));
                         }
                    ?>
                        <div class="panel panel-primary panel-default">
                            <div class="panel-heading">
                                    <div class="panel-title">Tabel Penerimaan Obat <strong>dan Alat Kesehatan</strong></div>
                            </div>
                            <div class="panel-body" style="overflow-x: scroll">
                                <div class="block-tabel">
                                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kode</th>
                                                <th>No. Batch <font style='color:red;'>*</font> </th>
                                                <th>Tanggal Kadaluarsa <font style='color:red;'>*</font></th>
                                                <th>Nama Obat & Alkes</th>
                                                <th>Isi Kemasan Satuan Besar</th>
                                                <th>Jml Terima</th>
                                                <th>Harga Satuan (Rp)</th>
                                                <th>Keringanan (%)</th>
                                                <th>Keringanan (Rp)</th>
                                                <th width="50px;"><a href="javascript:;" class="nohover" rel="tooltip" title="PPN hanya bisa diinput 0 atau 10, jika lebih dari 0 maka nilai ppn default 10" data-html=">true"> PPN (%)<i class="<?php echo MyIcon::getIcons('info') ?>"></i></a></th>
                                                <th>PPN (Rp)</th>
                                                <th>PPh (%)</th>
                                                <th>PPh (Rp)</th>
                                                <th>HPP</th>
                                                <th>Sub Total</th>
                                                <th hidden>Batal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if(count((array)$modDetails) > 0){
                                                $i = 0;
                                                foreach($modDetails AS $i=>$modPenerimaanBarangDetail){
                                                        $modStokObatAlkes = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id'=>$modPenerimaanBarangDetail->penerimaandetail_id));
                                                        $modPenerimaanBarangDetail->nobatch = isset($modStokObatAlkes->nobatch) ? $modStokObatAlkes->nobatch : "";
                                                        $modPenerimaanBarangDetail->jmlpermintaan = number_format($modPenerimaanBarangDetail->jmlpermintaan, 2, ",",".");
                                                        $modPenerimaanBarangDetail->jmlterima = number_format($modPenerimaanBarangDetail->jmlterima, 2, ",",".");
                                                        $modPenerimaanBarangDetail->persendiscount = number_format($modPenerimaanBarangDetail->persendiscount, 2, ",",".");
                                                        $modPenerimaanBarangDetail->persenpph = number_format($modPenerimaanBarangDetail->persenpph, 2, ",",".");
                                                        $modPenerimaanBarangDetail->harganettoper = MyFormatter::formatNumberForPrint($modPenerimaanBarangDetail->harganettoper, 2);
                                                        $this->renderPartial($this->path_view.'_rowObatPenerimaanBarang',array('modPenerimaanBarangDetail'=>$modPenerimaanBarangDetail,'modPenerimaanBarang'=>$modPenerimaanBarang,'format'=>$format,'i'=>$i));
                                                        $i++;
                                                }
                                            }
                                            ?>
                                            <tfoot hidden>
                                                    <tr>
                                                            <td colspan="14" style="text-align:right;"><b>Grand Total</b></td>
                                                            <td>
                                                                    <?php echo CHtml::textField('total','',array('class'=>'span2 integerFloat','style'=>'width:90px;text-align:right;','readonly'=>true))?>
                                                            </td>
                                                            <td></td>
                                                    </tr>
                                            </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>		
                    </div>
                </div>
                <?php if(Yii::app()->user->getState('isfakturdigudang') == true){ ?>
                <?php echo $form->hiddenField($modPenerimaanBarang, 'is_langsungfaktur', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'form-fakturpembelian',
                    'content'=>array(
                        'content-fakturpembelian'=>array(
                            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form Faktur Pembelian')).'<b> Faktur Pembelian</b>',
                            'isi'=>$this->renderPartial($this->path_view.'_formFakturPembelian',array(
                                'form'=>$form,
                                'modFakturPembelian'=>$modFakturPembelian,
                            ),true),
                            'active'=>$modPenerimaanBarang->is_langsungfaktur,
                        ),   
                    ),
                )); ?>
                <?php } ?>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php 
                                if($modPenerimaanBarang->isNewRecord){								
                                        //echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id'=>'btn_submit', 'class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasi($("#penerimaanbarang-form"));', 'onkeypress'=>'formSubmit(this,event);')); 								
                                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id'=>'btn_submit', 'class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi($("#penerimaanbarang-form"));', 'onkeypress'=>'formSubmit(this,event);')); 
                                        echo "&nbsp;";
                                }else{
                                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
                                        echo "&nbsp;";
                                }


                                if(!isset($_GET['frame'])){
                                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                $this->createUrl($this->id.'/index'), 
                                                array('class'=>'btn btn-danger',
                                                          'onclick'=>'return refreshForm(this);'));
                                        echo "&nbsp;";
                                }
                                if($modPenerimaanBarang->isNewRecord){
                                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4046*/
                                        echo "&nbsp;";
                                }else{
                                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4046*/
                                        echo "&nbsp;";
                                }


                                $content = $this->renderPartial($this->path_view.'tips/tipsPenerimaanBarang',array(),true);
                                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                        ?> 
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>                 
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenerimaanBarang'=>$modPenerimaanBarang,'modFakturPembelian'=>$modFakturPembelian,'modUangMuka'=>$modUangMuka,'modPermintaanPembelian'=>$modPermintaanPembelian,'modUangMuka'=>$modUangMuka)); ?>

<?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-verifikasi',
        'options'=>array(
            'title'=>'Verifikasi Penerimaan Obat & Alkes',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>960,
            'minHeight'=>480,
            'resizable'=>false,
			'close'=>"js:function(){ formatNumberSemua(); }",
        ),
    ));

    echo '<div class="dialog-content"></div>';
    ?>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); checkVerifikasi();')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>


<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
if(Yii::app()->user->getState('ispenerimaanlangsung') == true){
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogSupplier',
        'options'=>array(
            'title'=>'Pencarian Supplier',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));

    $modSupplier = new GFSupplierM('searchSupplierDialog');
    $modSupplier->unsetAttributes();
    $modSupplier->supplier_jenis = Params::SUPPLIER_JENIS_FARMASI;

    if(isset($_GET['GFSupplierM'])) {
        $modSupplier->attributes = $_GET['GFSupplierM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'supplier-grid',
        'dataProvider'=>$modSupplier->searchSupplierDialog(),
        'filter'=>$modSupplier,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                        "href"=>"",
                                        "id" => "selectObat",
                                        "onClick" => "
                                                    $(\"#'.CHtml::activeId($modPenerimaanBarang,'supplier_id').'\").val(\"$data->supplier_id\");
                                                    $(\"#'.CHtml::activeId($modPenerimaanBarang,'supplier_nama').'\").val(\"$data->supplier_nama\");
                                                    refreshDialogOA();
                                                    $(\"#dialogSupplier\").dialog(\"close\");
                                                    return false;
                                            "))',
                    ),
                    array(
                        'header'=>'Nama',
                        'name'=>'supplier_nama',
                        'value'=>'$data->supplier_nama',
                        'filter'=>Chtml::activeTextField($modSupplier, 'supplier_nama', array('class' => 'numbers-only'))
                    ),
                    array(
                        'header'=>'Alamat',
                        'value'=>'$data->supplier_alamat',
                        'filter'=>Chtml::activeTextField($modSupplier, 'supplier_alamat'),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); }',
            ));
    $this->endWidget();
}
//========= end Pegawai Menyetujui dialog =============================
?>

