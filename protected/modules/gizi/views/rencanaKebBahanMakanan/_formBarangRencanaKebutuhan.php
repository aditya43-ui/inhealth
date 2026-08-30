<?php
if (isset($modDetail)) {
    echo $form->errorSummary($modDetail);
}
?>
<?php if ($modRencanaKebBarang->isNewRecord) { ?>
    <div id="formDetailBarang">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class='control-label'>Bahan Makanan</label>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('idBarang'); ?>
                        <!--<div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'namaBarang',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutoCompleteBahanMakanan') . '",
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
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                'select' => 'js:function( event, ui ) {
                                                    $("#idBarang").val(ui.item.bahanmakanan_id); 
                                                    $("#namaBarang").val(ui.item.namabahanmakanan);
                                                    $("#satuan").val(ui.item.satuanbahan);
                                                    return false;
                                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span2 custom-only',
                                'placeholder' => 'nama Bahan Makanan',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogBarang'),
                        ));
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class='control-label'>Jumlah</label>
                    <div class="controls">
                        <?php echo Chtml::textField('jumlah', '1,00', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>
                        <?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        <?php
                        echo CHtml::htmlButton(
                            '<i class="icon-plus icon-white"></i>',
                            array(
                                'onclick' => 'tambahBarang();return false;',
                                'class' => 'btn btn-primary',
                                'onkeyup' => "tambahBarang();",
                                'rel' => "tooltip",
                                'title' => "Klik untuk menambahkan barang",
                            )
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modInformasistokbarang = new GZStokbahanmakananT();
$modInformasistokbarang->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GZStokbahanmakananT'])) {
    $modInformasistokbarang->attributes = $_GET['GZStokbahanmakananT'];
    $modInformasistokbarang->satuanbahan = $_GET['GZStokbahanmakananT']['satuanbahan'];
    $modInformasistokbarang->jenisbahanmakanan = $_GET['GZStokbahanmakananT']['jenisbahanmakanan'];
    $modInformasistokbarang->namabahanmakanan = $_GET['GZStokbahanmakananT']['namabahanmakanan'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modInformasistokbarang->searchInformasi(),
    'filter' => $modInformasistokbarang,
    'template' => "{summary}\n{items}\n{pager}",
    //        'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'barang_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#idBarang\').val(\'$data->bahanmakanan_id\');
                                        $(\'#namaBarang\').val(\'$data->namabahanmakanan\');
                                        $(\'#satuan\').val(\'$data->satuanbahan\');
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"))',
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisbahanmakanan',
            'value' => '$data->jenisbahanmakanan',
            'filter' => CHtml::dropDownList('GZStokbahanmakananT[jenisbahanmakanan]', $modInformasistokbarang->jenisbahanmakanan, LookupM::getItems('jenisbahanmakanan'), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Nama Bahan Makanan',
            'name'  => 'namabahanmakanan',
            'value' => '$data->namabahanmakanan',
        ),

        //        '',
        //        'barang_satuan',
        array(
            'name' => 'barang_satuan',
            'filter' => CHtml::dropDownList('GZStokbahanmakananT[satuanbahan]', $modInformasistokbarang->satuanbahan, LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --')),
            'value' => '$data->satuanbahan',
        ),
        array(
            'header' => 'Stok Minimal',
            'name'  => 'jmlminimal',
            'value' => 'empty($data->jmlminimal) ? 0 : $data->jmlminimal',
            'filter' => false,
        ),
        array(
            'header' => 'Stok Tersedia',
            'type'  => 'raw',
            'value' => 'empty($data->jumlah) ? 0 : $data->jumlah',
        ),
        //        '',
        //        '',
        //        'barang_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$urlAjax = $this->createUrl('AjaxGetPesanBarang');
$notif = Yii::t('mds', 'Do You want to cancel?');
$js = <<< JS
    function inputBarang(){
        idBarang = $('#idBarang').val();
        jumlah = $('#jumlah').val();
        satuan = $('#satuan').val();

        if (!jQuery.isNumeric(idBarang)){
            myAlert('Isi Barang yang akan ditambahkan');
            return false;
        }
        else if (!jQuery.isNumeric(jumlah)){
            myAlert('Isi jumlah barang yang akan dipesan');
            return false;
        }
        else{
            if (cekList(idBarang) == true){
                $.post('${urlAjax}', {idBarang:idBarang, jumlah:jumlah, satuan:satuan}, function(data){
                    $('#tableDetailBarang tbody').append(data);
                    $("#tableDetailBarang tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    clear();
                    renameInput();
                }, 'json');
            }
        }
        
    }
            
    function cekList(id){
        x = true;
        $('.barang').each(function(){
            if ($(this).val() == id){
                myAlert('Barang telah ada di daftar');
                clear();
                x = false;
            }
        });
        return x;
    }
    
    function clear(){
        $('#formDetailBarang').find('input, select').each(function(){
            $(this).val('');
        });
        $('#jumlah').val(1);
    }
    
    function batal(obj){
        myConfirm('Apakah Anda akan menghapus barang?', 'Perhatian!', function(r)
        {
            if(r){
                $(obj).parent().parent().remove();
            }
        });
        
        renameInput();
    }
    function renameInput(){
        urutan = 0;
        $('.barang').each(function(){
            $(this).parents('tr').find('[name*="PesanbarangdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('PesanbarangdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','PesanbarangdetailT['+urutan+']'+data[1]);
                }
            });
            urutan++;
        });        
    }
JS;
Yii::app()->clientScript->registerScript('onhead', $js,  CClientScript::POS_HEAD);
?>

<?php
Yii::app()->clientScript->registerScript('onready', '
    $("form").submit(function(){
        pesan = false;
        idRuangan = $("#' . CHtml::activeId($modRencanaKebBarang, 'ruangan_id') . '").val();
        idPemesan = $("#' . CHtml::activeId($modRencanaKebBarang, 'pegawai_id') . '").val();
		pemakaianBarang = $("#' . CHtml::activeId($modRencanaKebBarang, 'ro_bahanmakanan_bulan') . '").val();

        $(".pesan").each(function(){
            if ($(this).val() > 0){
                pesan = true
            }
        });
        
        if(!jQuery.isNumeric(pemakaianBarang)){
            myAlert("' . CHtml::encode($modRencanaKebBarang->getAttributeLabel('ro_bahanmakanan_bulan')) . ' harus diisi");
            myAlert("Silakan isi kolom yang bertanda * !");
            pemakaianBarang.focus();
            return false;
        }
        
    });
', CClientScript::POS_READY); ?>