<div class="row" id="formDetailBarang">
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Bahan Makanan</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('bahanmakanan_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namabahanmakanan',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteBahanMakanan') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#bahanmakanan_id").val(ui.item.value);
                                $("#namabahanmakanan").val(ui.item.label);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Bahan Makanan',
                        'class' => 'span3 custom-only',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#bahanmakanan_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Jumlah</label>
            <div class="controls">
                <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 float', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <?php echo Chtml::hiddenField('stokbahan', '', array('class' => 'span1 float', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <?php
                echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'inputBahanMakanan();return false;',
                        'class' => 'btn btn-primary',
                        'onkeypress' => "inputBahanMakanan();return $(this).focusNextInputField(event)",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Bahan Makanan",
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBahanMakanan',
    'options' => array(
        'title' => 'Daftar Stok Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modStockbahanmkn = new GZStokbahanmakananT('searchDialogBahanMakanan');
$modStockbahanmkn->unsetAttributes();
//$modBarang->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['GZStokbahanmakananT'])) {
    $modStockbahanmkn->attributes = $_GET['GZStokbahanmakananT'];
    $modStockbahanmkn->golbahanmakanan_id = isset($_GET['GZStokbahanmakananT']['golbahanmakanan_id']) ? $_GET['GZStokbahanmakananT']['golbahanmakanan_id'] : null;
    $modStockbahanmkn->jenisbahanmakanan = isset($_GET['GZStokbahanmakananT']['jenisbahanmakanan']) ? $_GET['GZStokbahanmakananT']['jenisbahanmakanan'] : null;
    $modStockbahanmkn->kelbahanmakanan = isset($_GET['GZStokbahanmakananT']['kelbahanmakanan']) ? $_GET['GZStokbahanmakananT']['kelbahanmakanan'] : null;
    $modStockbahanmkn->namabahanmakanan = isset($_GET['GZStokbahanmakananT']['namabahanmakanan']) ? $_GET['GZStokbahanmakananT']['namabahanmakanan'] : null;
    $modStockbahanmkn->satuanbahan = isset($_GET['GZStokbahanmakananT']['satuanbahan']) ? $_GET['GZStokbahanmakananT']['satuanbahan'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'bhnmakanstok-m-grid',
    'dataProvider' => $modStockbahanmkn->searchDialogBahanMakanan(),
    'filter' => $modStockbahanmkn,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "
					$(\'#bahanmakanan_id\').val(\'$data->bahanmakanan_id\');
					$(\'#namabahanmakanan\').val(\'$data->namabahanmakanan\');
					$(\'#satuan\').val(\'$data->satuanbahan\');
                                        $(\'#stokbahan\').val(\'$data->jumlah\');
					$(\'#dialogBahanMakanan\').dialog(\'close\');
					return false;"))',
        ),
        array(
            'header' => 'Golongan',
            'name' => 'golbahanmakanan_id',
            'filter' => CHtml::dropDownList('GZStokbahanmakananT[golbahanmakanan_id]', $modStockbahanmkn->golbahanmakanan_id,  CHtml::listData(BahanmakananM::model()->GolBahanMakananItems, 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty' => '-- Pilih --')),    //AND lookup_name != 'Aset' 
            'value' => '$data->golbahanmakanan_nama',
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisbahanmakanan',
            'filter' => CHtml::dropDownList('GZStokbahanmakananT[jenisbahanmakanan]', $modStockbahanmkn->jenisbahanmakanan,  CHtml::listData(BahanmakananM::model()->JenisBahanMakananItems, 'lookup_name', 'lookup_value'), array('empty' => '-- Pilih --')),    //AND lookup_name != 'Aset' 
            'value' => '$data->jenisbahanmakanan',
        ),
        array(
            'header' => 'Kelompok',
            'name' => 'kelbahanmakanan',
            'filter' => CHtml::dropDownList('GZStokbahanmakananT[kelbahanmakanan]', $modStockbahanmkn->kelbahanmakanan,  CHtml::listData(BahanmakananM::model()->KelBahanMakananItems, 'lookup_name', 'lookup_value'), array('empty' => '-- Pilih --')),    //AND lookup_name != 'Aset' 
            'value' => '$data->kelbahanmakanan',
        ),
        'namabahanmakanan',
        array(
            'header' => 'Satuan',
            'name' => 'satuanbahan',
            'filter' => CHtml::dropDownList('GZStokbahanmakananT[satuanbahan]', $modStockbahanmkn->satuanbahan, CHtml::listData(BahanmakananM::model()->SatuanBahanMakananItems, 'lookup_name', 'lookup_value'), array('empty' => '-- Pilih --')),    //AND lookup_name != 'Aset' 
            'value' => '$data->satuanbahan',
        ),
        //        'barang_nama',
        //        'barang_merk',        
        /*
        array(
            'name'=>'barang_satuan',
            'filter'=> CHtml::dropDownList('GUBarangM[barang_satuan]',$modBarang->barang_satuan,LookupM::getItems('satuanbarang'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->barang_satuan',
        ),
         * 
         */
        //        'barang_ukuran',
        //        'barang_ekonomis_thn',
        array(
            'header' => 'Stok',
            'type' => 'raw',
            'value' => function ($data) {
                //                $b = new GUInformasistokbarangV;
                //                $b->barang_id = $data->barang_id;
                //                $b->ruangan_id = Yii::app()->user->getState('ruangan_id');
                //                $prov = $b->search();
                //                
                //                $tot = 0;
                //                foreach ($prov->data as $item) {
                //                    $tot += $item->inventarisasi_stok;
                //                }
                //                
                return $data->jumlah . " " . $data->satuanbahan;
            },
            'htmlOptions' => array(
                'style' => 'text-align: right;',
                'nowrap' => true,
            ),
        )

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>