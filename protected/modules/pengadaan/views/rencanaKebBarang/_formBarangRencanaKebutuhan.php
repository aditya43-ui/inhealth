<?php 
if (isset($modDetail)){
echo $form->errorSummary($modDetail); 
}
?>
<?php // if ($modRencanaKebBarang->isNewRecord) { ?>
<div id="formDetailBarang">
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group ">
                <label class='control-label'>Barang</label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('idBarang'); ?>
                    <!--                <div class="input-append" style='display:inline'>-->
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'namaBarang',
                        'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutoCompleteBarang') . '",
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
                                                $("#idBarang").val(ui.item.barang_id); 
                                                return false;
                                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 custom-only',
                            'placeholder'=>'Ketikan nama barang',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogBarang'),
                    ));
                    ?>

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <label class='control-label'>Jumlah</label>
                <div class="controls">
                    <?php echo Chtml::textField('jumlah', MyFormatter::formatNumberForPrint(1,2), array('class' => 'span1 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>                
                    <?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                            array('onclick'=>'tambahBarang();return false;',
                                'class'=>'btn btn-primary',
                                'onkeyup'=>"tambahBarang();",
                                'rel'=>"tooltip",
                                'title'=>"Klik untuk menambahkan barang",)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php // } ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modInformasistokbarang = new GUInformasistokbarangV('searchDialogBarangStok');
$modInformasistokbarang->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GUInformasistokbarangV']))
    $modInformasistokbarang->attributes = $_GET['GUInformasistokbarangV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modInformasistokbarang->searchDialogBarangStok(),
    'filter'=>$modInformasistokbarang,
        'template'=>"{summary}\n{items}\n{pager}",
//        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        ////'barang_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#idBarang\').val(\'$data->barang_id\');
                                        $(\'#namaBarang\').val(\'$data->barang_nama\');
                                        $(\'#satuan\').val(\'$data->barang_satuan\');
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"))',
        ),
        array(
                        'header' => 'Tipe Barang',
			'name'=>'barang_type',
			'value'=>'$data->barang_type',
			'filter'=> CHtml::dropDownList('GUInformasistokbarangV[barang_type]',$modInformasistokbarang->barang_type,LookupM::getItems('barangumumtype'),array('empty'=>'-- Pilih --')),
        ),
        array(
            'header' => 'Nama Barang',
            'name'  =>'barang_nama',
            'value' => '$data->barang_nama',
        ),

//        '',
//        'barang_satuan',
        array(
            'name'=>'barang_satuan',
            'filter'=> CHtml::dropDownList('GUInformasistokbarangV[barang_satuan]',$modInformasistokbarang->barang_satuan,LookupM::getItems('satuanbarang'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->barang_satuan',
        ),
         array(
            'header' => 'Ukuran Barang',
            'name'  =>'barang_ukuran',
            'value' => '$data->barang_ukuran',
        ),
         array(
            'header' => 'Bahan Barang',
            'name'  =>'barang_bahan',
            'value' => '$data->barang_bahan',
        ),
        array(
            'header' => 'Stok Minimal',
            'name'  =>'minimalstok',
            'value' => '$data->minimalstok',
        ),
        array(
            'header' => 'Stok Tersedia',
            'type'  =>'raw',
            'value' => '$data->inventarisasi_stok',
        ),
//        '',
//        '',
//        'barang_namalainnya',
        
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php 
$urlAjax = $this->createUrl('AjaxGetPesanBarang');
$notif = Yii::t('mds','Do You want to cancel?');
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
        myConfirm('Apakah anda akan menghapus barang?', 'Perhatian!', function(r)
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
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_HEAD);
?>

<?php 
Yii::app()->clientScript->registerScript('onready','
    $("form").submit(function(){
        pesan = false;
        idRuangan = $("#'.CHtml::activeId($modRencanaKebBarang, 'ruangan_id').'").val();
        idPemesan = $("#'.CHtml::activeId($modRencanaKebBarang, 'pegawai_id').'").val();
		pemakaianBarang = $("#'.CHtml::activeId($modRencanaKebBarang, 'ro_barang_bulan').'").val();

        $(".pesan").each(function(){
            if ($(this).val() > 0){
                pesan = true
            }
        });
        
        if(!jQuery.isNumeric(pemakaianBarang)){
            myAlert("'.CHtml::encode($modRencanaKebBarang->getAttributeLabel('ro_barang_bulan')).' harus diisi");
            myAlert("Silakan isi kolom yang bertanda *!");
            pemakaianBarang.focus();
            return false;
        }
        
    });
',CClientScript::POS_READY);?>