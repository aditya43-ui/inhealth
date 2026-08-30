<?php 
if (isset($modDetail)){
echo $form->errorSummary($modDetail); 
}
?>
<?php if ($model->isNewRecord) { ?>
<div id="formDetailBarang">
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <label class='control-label'>Barang</label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('idBarang'); ?>
                    <!--<div class="input-append" style='display:inline'>-->
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
                            'placeholder'=>'Barang',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogBarang', 'idTombol'=>'tombolDialogBarang'),
                        ));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class='control-label'>Jumlah</label>
                <div class="controls">
                    <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)",'style' => 'text-align:right;')); ?>                
                    <?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                        array('onclick' => 'inputBarang();return false;',
                            'class' => 'btn btn-primary',
                            'onkeypress' => "inputBarang();return $(this).focusNextInputField(event)",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan Barang",));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500, 
        'resizable' => true,
    ),
));

$modBarang = new GUBarangV('searchBarangRuangan');//GUBarangM('search')
$modBarang->unsetAttributes();
$modBarang->barang_aktif = true;
//$modPegawai->ruangan_id = 0;
$ruangan_id = null;
if (isset($_GET['GUInformasistokbarangV']['ruangan_id'])) {
    $modBarang->ruangan_id = $_GET['GUInformasistokbarangV']['ruangan_id'];
}
if (isset($_GET['GUBarangV'])){
    $modBarang->attributes = $_GET['GUBarangV'];
    $ruangan_id = $modBarang->ruangan_id;
}   

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->search(),
    'filter'=>$modBarang,
       // 'template'=>"{items}\n{pager}",
        'template'=>"{summary}\n{items}\n{pager}",
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
            'name' => 'barang_type',
            //'filter' => CHtml::activeHiddenField($modBarang, 'ruangan_id', array('class'=>'dialog_ruangan_id')).
            'filter'=>CHtml::activeHiddenField($modBarang, 'ruangan_id', array('class'=>'dialog_ruangan_id')).CHtml::dropDownList('GUBarangV[barang_type]',$modBarang->barang_type,LookupM::getItems('barangumumtype'),array('empty'=>'-- Pilih --')),    
            'value' => '$data->barang_type',
        ),
        'barang_kode',
        'barang_nama',
        'barang_merk',        
        array(
            'name'=>'barang_satuan',
            'filter'=> CHtml::dropDownList('GUBarangV[barang_satuan]',$modBarang->barang_satuan,LookupM::getItems('satuanbarang'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_ekonomis_thn',
        array(
            'header'=>'Stok Barang',
            'type'=>'raw',
            'value'=>function($data) use ($ruangan_id) {
                return $data->getStokRuangan($ruangan_id)." ".$data->barang_satuan;
            }
        ),
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
            myAlert('Silakan isi barang yang akan dipesan!');
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
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_HEAD);
?>

<?php 
Yii::app()->clientScript->registerScript('onready','
    $("form").submit(function(){
        pesan = false;
        idRuangan = $("#'.CHtml::activeId($model, 'ruanganpemesan_id').'").val();
        idPemesan = $("#'.CHtml::activeId($model, 'pegpemesan_id').'").val();
			
		//hilangkan required		
		$("#GUPesanbarangT_pegpemesan_nama").attr("style","");
            
        $(".pesan").each(function(){
            if ($(this).val() > 0){
                pesan = true
            }
        });
        
        if(!jQuery.isNumeric(idRuangan)){
            //myAlert("'.CHtml::encode($model->getAttributeLabel('ruanganpemesan_id')).' harus diisi");
            myAlert("Silakan isi kolom yang bertanda <span class=\"required\">*</span>");
            idRuangan.focus();			
            return false;
        }
        else if (!jQuery.isNumeric(idPemesan)){
            //myAlert("'.CHtml::encode($model->getAttributeLabel('pegpemesan_id')).' harus diisi");
            myAlert("Silakan isi kolom yang bertanda <span class=\"required\">*</span>");
            // idPemesan.focus();
			$("#GUPesanbarangT_pegpemesan_nama").attr("style","border:1px solid red");
            return false;
        }
        
        if ($(".cancel").length < 1){
            myAlert("Barang yang dipesan belum ditambahkan");
            namaBarang.focus();
            return false;
        }
        else if (pesan == false){
            myAlert("'.CHtml::encode($model->getAttributeLabel('qty_pesan')).' harus memiliki nilai yang lebih dari 0");
            return false;
        }else{
            return requiredCheck(this);
        }
    });
',CClientScript::POS_READY);?>