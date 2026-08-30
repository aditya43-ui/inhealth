<style type="text/css">
    fieldset{
        padding: .35em .625em .75em;
        border: 1px solid #c0c0c0;
    }
    legend{
        font-size: 13px;
    }
    .classRed td{
        background-color: red !important;
    }
</style>


<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Transaksi </b> Daftar Rencana Pembayaran</div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#penerimaanpiutangprsh-t-search').submit(function(){
                    $.fn.yiiGridView.update('penerimaanpiutangprsh-t-grid', {
                            data: $(this).serialize(),
                            complete: function(jqXHR, status) {
                            if (status=='success'){
                                cekBoxRename();
                                cekBoxSemuaData();
                            }
                        }

                    });
                    return false;
            });
        ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><b>Pencarian Daftar Rencana Pembayaran</b></div>
            </div>
            <div class="panel-body">
                <div class="cari-lanjut2 search-form">
                    <?php
                    $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                        'format' => $format,
                    ));
                    ?>
                </div>
            </div>
        </div>
        <hr>

        <?php
//        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'confirmasi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>
        <?php echo $form->errorSummary($modVer); ?>

        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Daftar Rencana Pembayaran</div>
            </div>
            <div class="panel-body">
                <div class="block-tabel" style="overflow-y: auto;">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'penerimaanpiutangprsh-t-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'rowCssClassExpression' => function($row, $data){
                           
                            return $data->getClassDaftar($data->verpengeluaran_id);
                        },
                        'columns' => array(
                            array(
                                'id' => 'KUDaftarrencanapembayaranT',
//                                'name'=>'piutangperusahaandet_id',
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
//                                'value' => '$data->piutangperusahaandet_id',
//                                'checked'=>'piutangperusahaandet_id',
                                'checkBoxHtmlOptions' => array(
                                    'name' => 'KUDaftarrencanapembayaranT[$$][checked]',
                                    'id' => 'KUDaftarrencanapembayaranT_$$_checked',
                                    'class' => 'dataCheckBox',
                                    'onClick' => 'hitungBiayaTotal()',
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width: 20px;',
                                ),
                            ),
                            array(
                                'header' => 'NAMA',
                                'type' => 'raw',
                                'value' => '$data->supplier_nama',
                            ),
                            array(
                                'header' => 'NO BUKTI KAS',
                                'type' => 'raw',
//                                'value' => '$data->getVoucherBukti($data->verpengeluaran_id)',
                                'value' => '$data->no_voucher',
                            ),
                            array(
                                'header' => 'KODE',
                                'type' => 'raw',
                                'value' => 'CHtml::dropDownList("KUDaftarrencanapembayaranT[".$row."][kode_lbu]","",array("LBU"=>"LBU","IBU"=>"IBU"),array("empty"=>"Pilih","class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
                            ),
                            array(
                                'header' => 'KODE BANK',
                                'type' => 'raw',
                                'value' => 'CHtml::textField("KUDaftarrencanapembayaranT[".$row."][kode_kriling]","",array("class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
                            ),
                             array(
                                'header' => 'NAMA BANK',
                                'type' => 'raw',
                                'value' => 'CHtml::dropDownList("KUDaftarrencanapembayaranT[".$row."][bank_id]","",$data->getBank(),array("empty"=>"Pilih","index_eq"=>"$row","class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);","onchange"=>"changeBank(this);"))',
                            ),
                            array(
                                'header' => 'NO REK',
                                'type' => 'raw',
                                'value' => 'CHtml::textField("KUDaftarrencanapembayaranT[".$row."][no_rekening]","",array("class"=>"span2 no_rekening", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
                            ),
                            array(
                                'header' => 'MAK',
                                'type' => 'raw',
                                'value' => '$data->matananggaran_kode',
                            ),
                            array(
                                'header' => 'BRUTO',
                                'type' => 'raw',
                                'value' => 'number_format($data->nilai_kwitansi)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'PPN',
                                'type' => 'raw',
                                'value' => 'number_format($data->jmlpajak_ppn)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'PPH 22',
                                'type' => 'raw',
                                'value' => 'number_format($data->jmlpph_22)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'PPH 21',
                                'type' => 'raw',
                                'value' => 'number_format($data->jmlpph_21)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'PPH 23',
                                'type' => 'raw',
                                'value' => 'number_format($data->jmlpph_23)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'PPH Psl. 4 (2)',
                                'type' => 'raw',
                                'value' => 'number_format($data->jmlpph_psl4)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'DENDA',
                                'type' => 'raw',
                                'value' => 'number_format($data->dendabrg_kosong)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'T P DAN D',
                                'type' => 'raw',
                                'value' => 'number_format(($data->jmlpajak_ppn + ($data->jmlpph_21 + $data->jmlpph_22 + $data->jmlpph_23 + $data->jmlpph_psl4) + $data->dendabrg_kosong))',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                            array(
                                'header' => 'NETTO REKAP',
                                'type' => 'raw',
                                'value' => 'number_format(($data->nilai_kwitansi - ($data->jmlpajak_ppn + ($data->jmlpph_21 + $data->jmlpph_22 + $data->jmlpph_23 + $data->jmlpph_psl4) + $data->dendabrg_kosong)))'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][supplier_id]", $data->supplier_id)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][verpengeluaran_id]", $data->verpengeluaran_id)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][penerimaanberkas_id]", $data->penerimaanberkas_id)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][jenis_pph]", "")'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][tgl_voucher]", $data->tglvoucher)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][nama_perusahaan]", $data->supplier_nama)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][no_voucher]", $data->no_voucher)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][mak]", $data->matananggaran_kode)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][bruto]", $data->nilai_kwitansi)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][ppn]", $data->jmlpajak_ppn)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][pph]", $data->jmlpph_21)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][pph22]", $data->jmlpph_22)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][pph23]", $data->jmlpph_23)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][pphpsl4]", $data->jmlpph_psl4)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][denda]", $data->dendabrg_kosong)'
                                . ' . CHtml::hiddenField("KUDaftarrencanapembayaranT[".$row."][netto]", ($data->nilai_kwitansi - ($data->jmlpajak_ppn + ($data->jmlpph_21 + $data->jmlpph_22 + $data->jmlpph_23 + $data->jmlpph_psl4) + $data->dendabrg_kosong)))',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                </div>
            </div>
        </div>



        <div class="form-actions">
            <?php
            $sukses = (isset($_GET['sukses']) ? $_GET['sukses'] : null);
            $disableSave = false;
            $disableSave = ((!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false));
            
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'id'=>'btnSimpan','type' => 'button','onclick'=>"validasiSimpan();", 'onkeypress'=>"validasiSimpan();" ,'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)); //formSubmit(this,event) ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
            ?>
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => false)) . "&nbsp&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('CSV')", 'disabled' => false)) . "&nbsp&nbsp";
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true)) . "&nbsp&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true)) . "&nbsp&nbsp";
            }
            ?>
            <?php
            $content = $this->renderPartial('keuangan.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print'); //
        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        $id = "";
        if(isset($_GET['sukses'])){
            $id =  implode(",",$_GET['daftarrencanapembayaran_id']);
        }
        
            $js = <<< JSCRIPT
    function print(obj)
    {
    window.open("${urlPrint}"+"&id="+"${id}"+"&caraPrint="+obj,"",'location=_new, width=900px');
    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('printSurat', $js, CClientScript::POS_HEAD);
    ?>

<script type="text/javascript">
    function validasiSimpan(){
        var row = 0;
        $("#penerimaanpiutangprsh-t-grid").find('tbody > tr').each(function(){

            if(!$(this).find('.dataCheckBox').is(':checked')){
                $(this).find('input,select,textarea').each(function(){
                   $(this).attr('disabled',true);
                });
            }else{
                $(this).find('input,select,textarea').each(function(){
                   var old_name = $(this).attr("name").replace(/]/g,"");
                   var old_name_arr = old_name.split("[");

                   if(old_name_arr.length == 3){
                       $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                       $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                   }
                });
                row++;
            }

        });
        $('#confirmasi-t-form').submit();
    }

    function cekBoxRename() {
    for (var i = 0; i < $('.dataCheckBox').length; i++) {
    $('#penerimaanpiutangprsh-t-grid').find("tbody").find("tr").eq(i).find('input[name="KUDaftarrencanapembayaranT[$$][checked]"]').attr('name', 'KUDaftarrencanapembayaranT[' + i + '][checked]').attr('id', 'KUDaftarrencanapembayaranT_' + i + '_checked');
    }
    }
    cekBoxRename();

    function cekBoxSemuaData() {
    $(document).on('click', '#KUDaftarrencanapembayaranT_all', function () {
    if ($("#KUDaftarrencanapembayaranT_all").is(":checked"))
    {
    $('#penerimaanpiutangprsh-t-grid input[name*="checked"]').each(
    function () {
    $(this).attr('checked', true);
    }
    );
    } else {
    $('#penerimaanpiutangprsh-t-grid input[name*="checked"]').each(
    function () {
    $(this).removeAttr('checked');
    }
    );
    }
    hitungBiayaTotal();
    })
    }

    //    function jumlahPenerimaan(){
    //        unformatNumberSemua();
    //        var total_jml_penerimaan = 0;
    //        $("#tbl-penerimaan").find("tbody > tr").each(function () {
    //            var jml_uraian = parseInt($(this).find("input[name$='[jml_uraian]']").val());
    //            total_jml_penerimaan += jml_uraian;
    //        });
    //        $('#VRVerpenerimaanT_jml_penerimaan').val(total_jml_penerimaan);
    //        formatNumberSemua();
    //    }

    function hitungBiayaTotal(){
    unformatNumberSemua();
    var total_jml_pengembalian = 0;
    var total_jumlah_penerimaan = 0;
    var vver_pengembalianuangmuka_id = '';
    var vverpengembalianuangmukadet_id = '';


    $("#penerimaanpiutangprsh-t-grid").find("input[name$='[checked]'][type='checkbox']").each(function(){
    var jml_pengembalian = parseInt($(this).parents('tr').find("input[name$='[jml_pengembalian]']").val());
    var total_pengembalian = parseInt($(this).parents('tr').find("input[name$='[total_pengembalian]']").val());
    var pengembalianuangmukadet_id = $(this).parents('tr').find("input[name$='[pengembalianuangmukadet_id]']").val();
    var ver_pengembalianuangmuka_id = $(this).parents('tr').find("input[name$='[ver_pengembalianuangmuka_id]']").val();
    var verpengembalianuangmukadet_id = $(this).parents('tr').find("input[name$='[verpengembalianuangmukadet_id]']").val();
    if($(this).is(":checked")){
    total_jumlah_penerimaan += total_pengembalian;
    total_jml_pengembalian += jml_pengembalian;
    vver_pengembalianuangmuka_id += ver_pengembalianuangmuka_id;
    vverpengembalianuangmukadet_id += verpengembalianuangmukadet_id;
    getTindakan(pengembalianuangmukadet_id);
    }
    });
    $('#KUBkupengembalianuangmukaT_total_pengembalian').val(total_jml_pengembalian);
    $('#KUBkupengembalianuangmukaT_jml_pengembalian').val(total_jml_pengembalian);
    $('#KUBkupengembalianuangmukaT_ver_pengembalianuangmuka_id').val(vver_pengembalianuangmuka_id);
    $('#KUBkupengembalianuangmukaT_verpengembalianuangmukadet_id').val(vverpengembalianuangmukadet_id);
    formatNumberSemua();
    }

    function getTindakan(value){
    if(value != ''){
    $.ajax({
    type:'POST',
    url:'<?php echo $this->createUrl('GetRincianTindakan'); ?>',
    data: {value: value},
    dataType: "json",
    success:function(data){
    if(data != null){
    $("#tbl-rinciantindakan").find('#tbodyTindakan').html(data.html);
    $("#tbl-rinciantindakan").find('#tbodyTindakanTotal').html(data.htmlFoot);
    }
    $("#tbl_laporanpendapatanlayananri").removeClass("animation-loading");
    },
    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    }); 
    }else{
    $("#tbl-rinciantindakan").find('#tbodyTindakan').html("");
    $("#tbl-rinciantindakan").find('#tbodyTindakanTotal').html("");
    }

    }

//    function print(caraPrint)
//    {
//    var bkupengembalianuangmuka_id = $('#bkupengembalianuangmuka_id').val();
//    window.open('<?php // echo $this->createUrl('print'); ?>&bkupengembalianuangmuka_id=' + bkupengembalianuangmuka_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
//    }

function changeBank(data)
    {
        var $bank_id = $(data).val();
        var thisData = $(data);
        
            $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('getNoRekening'); ?>',
                    data: {bank_id: $bank_id},//
                    dataType: "json",
                    success:function(data){
                       if(data != null){
                           thisData.parents('tr').find("input[name$='[no_rekening]']").val(data.norekening);
                           thisData.parents('tr').find("input[name$='[kode_kriling]']").val(data.kode_bank);
                           
                       }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
    }
    
</script>
