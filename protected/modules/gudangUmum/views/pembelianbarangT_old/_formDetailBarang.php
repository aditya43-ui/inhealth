<?php if ($model->isNewRecord) { ?>
    <div id="formDetailBarang">
        <table>
            <tr>
                <td>
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
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/barang') . '",
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
                                    'class' => 'span2',
                                    'placeholder' => 'Nama Barang',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogBarang'),
                            ));
                            ?>

                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <label class='control-label'>Jumlah</label>
                        <div class="controls">
                            <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                            <?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                            <?php
                            echo CHtml::htmlButton(
                                '<i class="icon-plus icon-white"></i>',
                                array(
                                    'onclick' => 'inputBarang();return false;',
                                    'class' => 'btn btn-danger',
                                    'onkeypress' => "inputBarang();return $(this).focusNextInputField(event)",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan Barang",
                                )
                            );
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
<?php } ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modBarang = new GUBarangM('searchDialog');
$modBarang->unsetAttributes();
if (isset($_GET['GUBarangM']))
    $modBarang->attributes = $_GET['GUBarangM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modBarang->searchDialog(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
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
            'name' => 'barang_id',
            'value' => '$data->barang_id',
            'filter' => false,
        ),
        'bidang.subkelompok.kelompok.golongan.golongan_nama',
        'bidang.subkelompok.kelompok.kelompok_nama',
        'bidang.subkelompok.subkelompok_nama',
        'bidang.bidang_nama',
        //        'bidang_id',
        //        'barang_type',
        //        'barang_kode',
        'barang_nama',
        //        'barang_satuan',
        array(
            'name' => 'barang_satuan',
            'filter' => LookupM::getItems('satuanbarang'),
            'value' => '$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_bahan',
        //        'barang_namalainnya',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$urlAjax = $this->createUrl('getPembelianBarang');
$notif = Yii::t('mds', 'Do You want to cancel?');
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
                    rename();
                    $("#tableDetailBarang tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    clear();
                }, 'json');
            }
        }
        
    }
            
    function cekList(id){
        x = true;
        $('.barang').each(function(){
            if ($(this).val() == id){
                myAlert('Barang telah ada d List');
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
        myConfirm("${notif}",'Perhatian!',function(r){
            if(!r) {
                return false;
            }else{
                $(obj).parents('tr').remove();
                rename();
            }
        });
    }
    function rename(){
        noUrut = 1;
        $('.cancel').each(function(){
            $(this).parents('tr').find('[name*="BelibrgdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('BelibrgdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','BelibrgdetailT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
        });        
    }
    
    
    function openDialog(obj){
        $('#dialogPegawai').attr('parentClick',obj);
        $('#dialogPegawai').dialog('open');   
    }
JS;
Yii::app()->clientScript->registerScript('onhead', $js,  CClientScript::POS_HEAD);
?>

<?php
Yii::app()->clientScript->registerScript('onready', '
    $("form").submit(function(){
        qty = false;
        idPemesan = $("#' . CHtml::activeId($model, 'peg_pemesanan_id') . '").val();
        sumberdana = $("#' . CHtml::activeId($model, 'sumberdana_id') . '").val();
        supplier = $("#' . CHtml::activeId($model, 'supplier_id') . '").val();
        
        $(".qty").each(function(){
            if ($(this).val() > 0){
                qty = true
            }
        });
        
        if(!jQuery.isNumeric(sumberdana)){
            myAlert("' . CHtml::encode($model->getAttributeLabel('sumberdana_id')) . ' harus diisi");
            return false;
        }
        else if (!jQuery.isNumeric(supplier)){
            myAlert("' . CHtml::encode($model->getAttributeLabel('supplier_id')) . ' harus diisi");
            return false;
        }
        else if (!jQuery.isNumeric(idPemesan)){
            myAlert("' . CHtml::encode($model->getAttributeLabel('peg_pemesanan_id')) . ' harus diisi");
            return false;
        }

        
        if ($(".cancel").length < 1){
            myAlert("Detail Barang Harus Diisi");
            return false;
        }
        else if (qty == false){
            myAlert("' . CHtml::encode($model->getAttributeLabel('jml_beli')) . ' harus memiliki value yang lebih dari 0");
            return false;
        }
    });
', CClientScript::POS_READY); ?>