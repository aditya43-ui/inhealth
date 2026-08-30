<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemakaian Alat dan Bahan
        </div>
    </div>
    <div class="panel-body">
        <table style="border-collapse: separate; border-spacing: 5px;">
            <tr>
                <td colspan="2">
                    <?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '', array(), array('empty' => 'Uraian Tindakan')) ?>

                    <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); 
                    ?>
                </td>
            </tr>
            <tr>
                <td width="230px">
                    
                    <?php echo CHtml::radioButton('pilihAlkes', true, array('value' => 'bahan', 'onclick' => 'pilihAlkesMedis(this);')); ?>
                    Pemakaian BMHP&emsp;&emsp;&emsp;
                    <?php echo CHtml::radioButton('pilihAlkes', false, array('value' => 'medis', 'onclick' => 'pilihAlkesMedis(this);')); ?>
                    Alat Medis
                </td>
                <td>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'pakaiBahan',
                        'value' => '',
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/PemakaianBahan') . '",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                       idTipePaket: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                                       idKelasPelayanan: $("#RJPendaftaranT_kelaspelayanan_id").val(),
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
                                        inputPemakaianBahan(ui.item.obatalkes_id);
                                        return false;
                                    }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'placeholder' => 'Pemakaian BMHP'),
                        'tombolDialog' => array('idDialog' => 'dialogAlkes'),
                    ));
                    ?>
                    <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlatmedis").dialog("open");return false;')); 
                    ?>

                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'alatMedis',
                        'value' => '',
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/PemakaianAlatMedis') . '",
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
                                        inputAlatmedis(ui.item.alatmedis_id);
                                        return false;
                                    }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'placeholder' => 'Alat Medis'),
                        'tombolDialog' => array('idDialog' => 'dialogAlatmedis'),
                    ));
                    ?>
                </td>
            </tr>
        </table>
        <table class="items table table-striped table-condensed" id="tblInputPemakaianBahan" style="border-collapse: separate; border-spacing: 5px;">
            <thead>
                <tr>
                    <th width="300">Uraian Tindakan</th>
                    <th>Nama Alkes/Alat Medis</th>
                    <th width="50">Jumlah</th>
                    <th width="30">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = '';
                if (count((array) $modViewBahan) > 0) {
                    for ($i = 0; $i < count((array) $modViewBahan); $i++) {
                        $modDaftartindakan = DaftartindakanM::model()->findByPk(
                                $modViewBahan[$i]['daftartindakan_id']
                        );
                        ?>
                        <tr>
                            <td>
                                <?php echo isset($modDaftartindakan->daftartindakan_nama) ? $modDaftartindakan->daftartindakan_nama : " - "; ?>
                            </td>
                            <td>
                                <?php echo $modViewBahan[$i]['obatalkes']['obatalkes_nama']; ?>
                            </td>
                            <td><?php echo $modViewBahan[$i]['qty_oa']; ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                echo $data;
                ?>
            </tbody>
        </table>
    </div>
    <hr>
    <?php
    $this->renderPartial($this->path_view . '_formPemakaianBahanNew', array());
    // $this->renderPartial($this->path_view.'_formAlatBahan', array());
    // $this->renderPartial(
    //         '_formPaketBmhp', array(
    //     'modViewBmhp' => $modViewBmhp
    //         )
    // );
    ?>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAlkes',
    'options' => array(
        'title' => 'Obat dan Alkes Stok ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 600,
        'resizable' => false,
    ),
));

/* $moObatAlkes = new BSObatalkesM('search');
  $moObatAlkes->unsetAttributes();
  if(isset($_GET['BSObatalkesM']))
  $moObatAlkes->attributes = $_GET['BSObatalkesM'];

  $this->widget('ext.bootstrap.widgets.BootGridView',array(
  'id'=>'rjobat-alkes-m-grid',
  'dataProvider'=>$moObatAlkes->searchObatFarmasi(),
  'filter'=>$moObatAlkes,
  'template'=>"{summary}\n{items}\n{pager}",
  'itemsCssClass'=>'table table-striped table-bordered table-condensed',
  'columns'=>array(
  array(
  'header'=>'Pilih',
  'type'=>'raw',
  'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
  "id" => "selectObat",
  "onClick" => "inputPemakaianBahan($data->obatalkes_id);return false;"))',
  ),
  'obatalkes_kategori',
  'obatalkes_nama',
  'obatalkes_golongan',
  array(
  'name'=>'satuankecilNama',
  'value'=>'$data->satuankecil->satuankecil_nama',
  ),
  array(
  'name'=>'sumberdanaNama',
  'value'=>'$data->sumberdana->sumberdana_nama',
  ),
  'minimalstok',
  //'hargajual',
  array(
  'name'=>'hargajual',
  'value'=>'number_format($data->hargajual)',
  ),
  ),
  'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
  )); */

$modObatAlkes = new InfostokobatalkesruanganV('searchObat');
$modObatAlkes->unsetAttributes();
if (isset($_GET['InfostokobatalkesruanganV'])) {
    $modObatAlkes->attributes = $_GET['InfostokobatalkesruanganV'];
    //$modObatAlkes->jenisobatalkes_nama = $_GET['InfostokobatalkesruanganV']['jenisobatalkes_nama'];
    // $modObatAlkes->satuankecil_nama = $_GET['InfostokobatalkesruanganV']['satuankecil_nama'];
    //    $modObatAlkes->sumberdana_nama = $_GET['LBObatalkesM']['sumberdana_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkesa-m-grid',
    'dataProvider' => $modObatAlkes->searchObat(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) use (&$stok){
                $stok = StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"));
    
                return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                    "id" => "selectObat",
                    "data-stok" => $stok,
                    "onClick" => "inputPemakaianBahan(".$data->obatalkes_id.");return false;"
                ));
            },
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => function ($data) {
                return (!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "");
            },
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(
                            JenisobatalkesM::model()->findAll(array(
                                'condition' => 'jenisobatalkes_aktif = true',
                                'order' => 'jenisobatalkes_nama',
                            )), 'jenisobatalkes_id', 'jenisobatalkes_nama'
                    ), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_nama',
            'filter' => CHtml::activeTextField($modObatAlkes, 'obatalkes_nama', array('class' => 'custom-only'))
        ),
        //  'obatalkes_kategori',
        // 'obatalkes_golongan',
        // array(
        //    'name'=>'satuankecil_id',
        //    'type'=>'raw',
        //     'value'=>'$data->satuankecil->satuankecil_nama',
        //    'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
        // ),
        //                array(
        //                    'name'=>'sumberdana_id',
        //                    'type'=>'raw',
        //                    'value'=>'$data->sumberdana->sumberdana_nama',
        //                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => function($data) use (&$stok){
                
                return $stok.' '.$data->satuankecil_nama;
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
    $('#alatMedis').parent().addClass('hide');

    function tambahPemakaianBahan2(isdialog = undefined) {
        if (isdialog != undefined) {
            var isnonpaket = $("#tipepaket_id :selected").data('isnonpaket');
            $('#dialogPemakaianBahan').dialog('close');
            if (isnonpaket == true) {
                return false;
            }
        }

        $("#tblpemakaianbahan").addClass("animation-loading");
        var isbukanbebanpasien = 0;
        if ($('#isbukanbebanpasien').prop('checked') == true) {
            isbukanbebanpasien = 1;
        }
        // var tipepaket_id = $('#tipepaket_id').val();
        var tipepaket_id = 1;
        var obatalkes_id = $('#obatalkes_id').val();
        var qtypakaibahan = $('#qtypakaibahan').val();
        var isadaoa = false;
        console.log('atas ', tipepaket_id, isadaoa);
        if ($('#obatalkes_id').prop('disabled') == false && obatalkes_id != '') {
            isadaoa = true;
            console.log('if 1 ', tipepaket_id, isadaoa, obatalkes_id);
        } else if ($('#obatalkes_id').prop('disabled') == true) {
            isadaoa = true;
            var isadatipe = false;

            $("#tblpemakaianbahan").find('.trparent').each(function () {
                var idxParent = $(this).attr('idxparent');
                if (tipepaket_id == $(this).find($(this).find('input[name$="[' + idxParent + '][tipepaket_id]"]')).val()) {
                    isadatipe = true;
                    console.log('dalam if 1 ', tipepaket_id, isadaoa);
                }
            });

            if (isadatipe == true) {
                isadaoa = false;
                console.log('dalam if 2 ', tipepaket_id, isadaoa);
            }
            console.log('else if 1 ', tipepaket_id, isadaoa);
        }

        // myAlert(tipepaket_id + " - " + isadaoa + " " + (tipepaket_id != '' && isadaoa == true));
            console.log('bawah ', tipepaket_id, isadaoa, isbukanbebanpasien, obatalkes_id, qtypakaibahan);
        if (tipepaket_id != '' && isadaoa == true) {
            console.log('get 1 ', tipepaket_id, isadaoa, isbukanbebanpasien, obatalkes_id, qtypakaibahan);
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('setLoadBahanMedis'); ?>',
                data: {tipepaket_id: tipepaket_id, isbukanbebanpasien: isbukanbebanpasien, obatalkes_id: obatalkes_id, qtypakaibahan: qtypakaibahan,
                    pasienmasukpenunjang_id:'<?= isset($_GET['id'])?$_GET['id']:'' ?>'
                },
                dataType: "json",
                success: function (data) {
                    $("#tblpemakaianbahan").append(data.html);
                    generateRowBmhp($("#tblpemakaianbahan"));
                    hitungTotalBmhp();                    
                    $('#obatalkes_id').val('');
                    $('#obatalkes_nama').val('');
                    $('#qtypakaibahan').val('1');
                    $("#tblpemakaianbahan").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('eror ',jqXHR, textStatus, errorThrown);
                    myAlert("Data Pemakaian Bahan Pasien tidak ditemukan !");
                    $('#obatalkes_id').val('');
                    $('#obatalkes_nama').val('');
                    $('#qtypakaibahan').val('1');
                    $("#tblpemakaianbahan").removeClass("animation-loading");
                }
            });
        } else {
            console.log('get 2 ', tipepaket_id, isadaoa);
            myAlert("Data Pemakaian Bahan Pasien tidak ditemukan atau sudah ditambahkan!");
            $('#obatalkes_id').val('');
            $('#obatalkes_nama').val('');
            $('#qtypakaibahan').val('1');
            $("#tblpemakaianbahan").removeClass("animation-loading");
        }
    }

    function tambahPemakaianBahan(isdialog = undefined, data){
        if(isdialog != undefined){
            var isnonpaket = $("#tipepaket_id :selected").data('isnonpaket');
            $('#dialogPemakaianBahan').dialog('close');
            if(isnonpaket == true){
                return false;
            }
        }

        $("#tblpemakaianbahan").addClass("animation-loading");
        var isbukanbebanpasien = 0;
        if($('#isbukanbebanpasien').prop('checked')==true){
            isbukanbebanpasien = 1;
        }
        var tipepaket_id = $('#tipepaket_id').val();
        var obatalkes_id = $('#obatalkes_id').val();
        var qtypakaibahan = $('#qtypakaibahan').val();
        var isadaoa = false;
        
        if($('#obatalkes_id').prop('disabled')==false && obatalkes_id != ''){
            isadaoa = true;
        }else if($('#obatalkes_id').prop('disabled') == true){
            isadaoa = true;
            var isadatipe = false;

            $("#tblpemakaianbahan").find('.trparent').each(function(){
                var idxParent = $(this).attr('idxparent');
                if(tipepaket_id == $(this).find($(this).find('input[name$="['+idxParent+'][tipepaket_id]"]')).val()){
                    isadatipe = true;
                }
            });

            if(isadatipe == true){
                isadaoa = false;
            }
        }
       

        if(tipepaket_id != ''){
            $.ajax({
                type:'GET',
                url:'<?php echo $this->createUrl('setLoadBahanMedis'); ?>',
                data: {tipepaket_id:tipepaket_id, isbukanbebanpasien:isbukanbebanpasien, obatalkes_id:obatalkes_id, qtypakaibahan:qtypakaibahan,
                        pasienmasukpenunjang_id:'<?= isset($_GET['id'])?$_GET['id']:'' ?>'},
                dataType: "json",
                success:function(data){
                    const jenis = $("#jenis").val();
                    
                    $("#tblpemakaianbahan").append(data.html);
                    generateRowBmhp($("#tblpemakaianbahan"));
                    hitungTotalBmhp();
                    if(data.pesan != ''){
                        myAlert(data.pesan);
                    }
                    $('#obatalkes_id').val('');
                    $('#obatalkes_nama').val('');
                    $('#qtypakaibahan').val('1');
                    $("#tblpemakaianbahan").removeClass("animation-loading");

                    cekForm();
                    
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    myAlert("Data Pemakaian Bahan Pasien tidak ditemukan !"); 
                    $('#obatalkes_id').val('');
                    $('#obatalkes_nama').val('');
                    $('#qtypakaibahan').val('1');
                    $("#tblpemakaianbahan").removeClass("animation-loading");
                    
                    cekForm();
                }
            });
        }else{
            const jenis = $("#jenis").val();
            
            if (jenis == 'paket-bmhp'){                  
                setObatAlkes(data.oa,'',jenis);
                return false;
            }
        
            myAlert("Data Pemakaian Bahan Pasien tidak ditemukan atau sudah ditambahkan!"); 
            $('#obatalkes_id').val('');
            $('#obatalkes_nama').val('');
            $('#qtypakaibahan').val('1');
            $("#tblpemakaianbahan").removeClass("animation-loading");
        }
    }

    const cekForm =  () => {        
    
        var tr = $("#tblpemakaianbahan > tr").length;
        
//        if (tr.length == 0){
//            $("#BSTindakanPelayananT_tombolsimpan").remove("disabled", true);
//        }else{
            $("#BSTindakanPelayananT_tombolsimpan").removeAttr("disabled");
//        }
        
        let obatallow = '';
        $(".set-stok-habis").find(".obatalkes_nama").each(function(){
            obatallow += 'Stok Bahan Medis '+$(this).val()+' Kosong !<br />';
        });
        
        if (obatallow != ''){
            toastr.error(obatallow,"Perhatian!");
            $("#BSTindakanPelayananT_tombolsimpan").attr("disabled", true);
            return false;
        }
    }

    function hapusBmhp(obj){
        $(obj).parents('.trparent').detach();
        generateRowBmhp($('#tblpemakaianbahan'));
        hitungTotalBmhp();
        cekForm();
    }

    function changeTipePaketBahanMedis(){
        var isnonpaket = $("#tipepaket_id :selected").data('isnonpaket');

        if($('#tipepaket_id').val() != ''){
            if(isnonpaket != true){
                console.log('paket 1');
                $('#obatalkes_id').attr('disabled',true);
                $('#qtypakaibahan').attr('disabled',true);
                $('#obatalkes_nama').attr('disabled',true);
                $('#obatalkes_nama').each(function() {
                    $(this).parent().find(".add-on").hide();
                });
                $('#btntmbbahanmedis').attr('disabled',true);

                $('#obatalkes_id').val('');
                $('#obatalkes_nama').val('');
                $('#qtypakaibahan').val('1');
                tambahPemakaianBahan();   
            }else{
                console.log('non paket 1');
                $('#obatalkes_id').attr('disabled',false);
                $('#qtypakaibahan').attr('disabled',false);
                $('#obatalkes_nama').attr('disabled',false);
                $('#obatalkes_nama').each(function() {
                    $(this).parent().find(".add-on").show();
                });
                $('#btntmbbahanmedis').attr('disabled',false);
            }
        }
    }
    function generateRowBmhp(obj) {
        var nourut = 0;
        for (var i = 0; i < $(obj).find('.nourut').length; i++) {
            var tr = $(obj).find('.nourut').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_nourut');
            tr.attr('name', 'Bmhp[' + i + '][nourut]');
            nourut++;
            tr.val(nourut);
        }

        for (var i = 0; i < $(obj).find('.tgl_pelayanan').length; i++) {
            var tr = $(obj).find('.tgl_pelayanan').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_tgl_pelayanan');
            tr.attr('name', 'Bmhp[' + i + '][tgl_pelayanan]');
            tr.datetimepicker(
                    jQuery.extend(
                            {
                                showMonthAfterYear: false
                            },
                            jQuery.datepicker.regional['id'],
                            {
                                'dateFormat': 'dd M yy',
                                'minDate': 'd',
                                'timeText': 'Waktu',
                                'hourText': 'Jam',
                                'minuteText': 'Menit',
                                'secondText': 'Detik',
                                'showSecond': true,
                                'timeOnlyTitle': 'Pilih Waktu',
                                'timeFormat': 'hh:mm:ss',
                                'changeYear': true,
                                'changeMonth': true,
                                'showAnim': 'fold',
                                'yearRange': '-80y:+20y'
                            }
                    )
                    );

            tr.each(function () {
                var obj = $(this);
                $(this).parent().find(".add-on").click(function () {
                    $(obj).focus();
                });
            });
        }

        for (var i = 0; i < $(obj).find('.tipepaket_id').length; i++) {
            var tr = $(obj).find('.tipepaket_id').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_tipepaket_id');
            tr.attr('name', 'Bmhp[' + i + '][tipepaket_id]');
        }

        for (var i = 0; i < $(obj).find('.tipepaket_nama').length; i++) {
            var tr = $(obj).find('.tipepaket_nama').eq(i);
            tr.attr('id', 'Bmhp_' + i + '_tipepaket_nama');
            tr.attr('name', 'Bmhp[' + i + '][tipepaket_nama]');
        }

        for (var i = 0; i < $(obj).find('.trparent').length; i++) {
            var tr = $(obj).find('.trparent').eq(i);
            tr.attr('id', 'trparent' + i);
            tr.attr('idxparent', i);

            for (var j = 0; j < tr.find('.tblchild_jnsoa').find('.trcld_jnsoa').length; j++) {
                var trc = tr.find('.tblchild_jnsoa').find('.trcld_jnsoa').eq(j);
                trc.attr('id', 'trcld_jnsoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.attr('idxchild', j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_jnsoa').find('.jenisobatalkes_nama').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_jenisobatalkes_nama');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][jenisobatalkes_nama]');
            }

            for (var j = 0; j < tr.find('.tblchild_namaoa').find('.trcld_namaoa').length; j++) {
                var trc = tr.find('.tblchild_namaoa').find('.trcld_namaoa').eq(j);
                trc.attr('id', 'trcld_namaoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_namaoa').find('.obatalkes_id').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_obatalkes_id');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][obatalkes_id]');

                var trc_chldoa = tr.find('.tblchild_namaoa').find('.obatalkes_nama').eq(j);
                trc_chldoa.attr('id', 'Bmhpchild_' + i + '_' + j + '_obatalkes_nama');
                trc_chldoa.attr('name', 'Bmhpchild[' + i + '][' + j + '][obatalkes_nama]');
                
                var trc_chldisbukanpasien = tr.find('.tblchild_namaoa').find('.isbukanbebanpasien').eq(j);
                trc_chldisbukanpasien.attr('id', 'Bmhpchild_' + i + '_' + j + '_isbukanbebanpasien');
                trc_chldisbukanpasien.attr('name', 'Bmhpchild[' + i + '][' + j + '][isbukanbebanpasien]');
            }

            for (var j = 0; j < tr.find('.tblchild_tglkadaluarsaoa').find('.trcld_tglkadaluarsaoa').length; j++) {
                var trc = tr.find('.tblchild_tglkadaluarsaoa').find('.trcld_tglkadaluarsaoa').eq(j);
                trc.attr('id', 'trcld_tglkadaluarsaoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_tglkadaluarsaoa').find('.tglkadaluarsa').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_tglkadaluarsa');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][tglkadaluarsa]');
            }

            for (var j = 0; j < tr.find('.tblchild_hargajualoa').find('.trcld_hargajualoa').length; j++) {
                var trc = tr.find('.tblchild_hargajualoa').find('.trcld_hargajualoa').eq(j);
                trc.attr('id', 'trcld_hargajualoa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_hargajualoa').find('.hargajual').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_hargajual');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][hargajual]');
            }

            for (var j = 0; j < tr.find('.tblchild_jmloa').find('.trcld_jmloa').length; j++) {
                var trc = tr.find('.tblchild_jmloa').find('.trcld_jmloa').eq(j);
                trc.attr('id', 'trcld_jmloa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_jmloa').find('.qty').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_qty');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][qty]');
            }

            for (var j = 0; j < tr.find('.tblchild_subtotaloa').find('.trcld_subtotaloa').length; j++) {
                var trc = tr.find('.tblchild_subtotaloa').find('.trcld_subtotaloa').eq(j);
                trc.attr('id', 'trcld_subtotaloa' + i + '_' + j);
                trc.attr('idx', i + '_' + j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if (j % 2 == 0) {
                    trc.find('td').addClass('trcoltdwhite');
                } else {
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_subtotaloa').find('.subtotal').eq(j);
                trc_chld.attr('id', 'Bmhpchild_' + i + '_' + j + '_subtotal');
                trc_chld.attr('name', 'Bmhpchild[' + i + '][' + j + '][subtotal]');
            }
            
            for(var j=0; j<tr.find('.tblchild_persenppn').find('.trcld_persenppn').length; j++){
                var trc = tr.find('.tblchild_persenppn').find('.trcld_persenppn').eq(j);
                trc.attr('id','trcld_persenppn'+i+'_'+j);
                trc.attr('idx',i+'_'+j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if(j % 2 == 0){
                    trc.find('td').addClass('trcoltdwhite');
                }else{
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_persenppn').find('.ppnpersen').eq(j);
                trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_ppnpersen');
                trc_chld.attr('name','Bmhpchild['+i+']['+j+'][ppnpersen]');

                var trc_chld_jumlah = tr.find('.tblchild_persenppn').find('.jumlahppn').eq(j);
                trc_chld_jumlah.attr('id','Bmhpchild_'+i+'_'+j+'_jumlahppn');
                trc_chld_jumlah.attr('name','Bmhpchild['+i+']['+j+'][jumlahppn]');
            }

            for(var j=0; j<tr.find('.tblchild_persen_margin').find('.trcld_persen_margin').length; j++){
                var trc = tr.find('.tblchild_persen_margin').find('.trcld_persen_margin').eq(j);
                trc.attr('id','trcld_persen_margin'+i+'_'+j);
                trc.attr('idx',i+'_'+j);
                trc.find('td').removeClass('trcoltd');
                trc.find('td').removeClass('trcoltdwhite');

                if(j % 2 == 0){
                    trc.find('td').addClass('trcoltdwhite');
                }else{
                    trc.find('td').addClass('trcoltd');
                }

                var trc_chld = tr.find('.tblchild_persen_margin').find('.persen_margin').eq(j);
                trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_persen_margin');
                trc_chld.attr('name','Bmhpchild['+i+']['+j+'][persen_margin]');

                var trc_chld_jumlah = tr.find('.tblchild_persen_margin').find('.harga_margin').eq(j);
                trc_chld_jumlah.attr('id','Bmhpchild_'+i+'_'+j+'_harga_margin');
                trc_chld_jumlah.attr('name','Bmhpchild['+i+']['+j+'][harga_margin]');
            }

        }

    }

    function hitungTotalBmhp() {
        unformatNumberSemua();
        var totalAll = 0;

        $('#tblpemakaianbahan').find('.trparent').each(function () {
            var idxParent = $(this).attr('idxparent');

            $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('.tblchild_jnsoa').find('.trcld_jnsoa').each(function () {
                var idxchild = $(this).attr('idxchild');
                var harga = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="[' + idxParent + '][' + idxchild + '][hargajual]"]').val());
                var qty = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="[' + idxParent + '][' + idxchild + '][qty]"]').val());
                var persenppn = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][ppnpersen]"]').val());
                var persenmargin = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][persen_margin]"]').val());

                var jmlqty = (harga * qty);
                if (jmlqty > 0){
                   jmlqty = parseFloat(jmlqty.toFixed(2));
                }

                var jmlppn = ((jmlqty * persenppn)/100);
                if (jmlppn > 0){
                   jmlppn = parseFloat(jmlppn.toFixed(2));
                }

                var subtotal = jmlqty + jmlppn;

                var jmlmargin = parseFloat(((subtotal * persenmargin)/100).toFixed(2));
                if (jmlmargin > 0){
                    subtotal += jmlmargin;                                   
                } 

                if (subtotal > 0){
                    subtotal = parseFloat(subtotal.toFixed(2));
                }

                $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][subtotal]"]').val(subtotal);
                $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][jumlahppn]"]').val(jmlppn);
                $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][harga_margin]"]').val(jmlmargin);
                totalAll += subtotal;

            });
        });

        $('#totalbahanmedis').val(totalAll);
        formatNumberSemua();
    }

    function pilihAlkesMedis(obj) {
        //$('#tblInputPemakaianBahan > tbody').html('');
        //    $('#totPemakaianBahan').val('0');
        if (obj.value == 'bahan') {
            $('#alatMedis').parent().addClass('hide');
            $('#pakaiBahan').parent().removeClass('hide');
        } else if (obj.value == 'medis') {
            $('#pakaiBahan').parent().addClass('hide');
            $('#alatMedis').parent().removeClass('hide');
        }
    }

    function inputPemakaianBahan(idObatAlkes) {
        
        
        var idDaftartindakan = $('#daftartindakanPemakaianBahan option:selected').val();
        if (idDaftartindakan == '') {
            myAlert('Belum ada Tindakan');
            return false;
        }

        jQuery.ajax({
            'url': '<?php echo $this->createUrl('addFormPemakaianBahan') ?>',
            'data': {
                idObatAlkes: idObatAlkes,
                idDaftartindakan: idDaftartindakan
            },
            'type': 'post',
            'dataType': 'json',
            'success': function (data) {
                $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                $('#tblInputPemakaianBahan > tbody').append(data.form);
                renameInput('pemakaianBahan', 'obatalkes_id');
                renameInput('pemakaianBahan', 'hargajual');
                renameInput('pemakaianBahan', 'hargasatuan');
                renameInput('pemakaianBahan', 'harganetto');
                renameInput('pemakaianBahan', 'qty');
                renameInput('pemakaianBahan', 'subtotal');
                renameInput('pemakaianBahan', 'daftartindakan_id');
                renameInput('pemakaianBahan', 'sumberdana_id');
                renameInput('pemakaianBahan', 'satuankecil_id');

                $("#tblInputPemakaianBahan > tbody tr:last .integer2").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0
                });
                //                        $('.currency').each(function(){this.value = formatNumber(this.value)});
                $("#tblInputPemakaianBahan > tbody tr:last .number").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": "",
                    "precision": 0,
                    "symbol": null,
                    "allowDecimal": true
                });

                hitungTotal();                                
                
                //                        $('.number').each(function(){this.value = formatNumber(this.value)});
                $("#dialogAlkes").dialog('close');
            },
            'cache': false
        });

        function renameInput(modelName, attributeName) {
            var i = -1;
            $('#tblInputPemakaianBahan tr.pemakaian_bahan').each(function () {
                if ($(this).has('input[name$="[obatalkes_id]"]').length) {
                    i++;
                }
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
            });
        }
    }

    function removeObat(obj) {
        myConfirm("Apakah Anda akan menghapus obat?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parent().parent().remove();

                renameInputAfterRemove('pemakaianBahan', 'obatalkes_id');
                renameInputAfterRemove('pemakaianBahan', 'hargajual');
                renameInputAfterRemove('pemakaianBahan', 'qty');
                renameInputAfterRemove('pemakaianBahan', 'subtotal');
                renameInputAfterRemove('pemakaianBahan', 'daftartindakan_id');

                renameInputAfterRemove('pemakaianBahan', 'hargasatuan');
                renameInputAfterRemove('pemakaianBahan', 'harganetto');
                renameInputAfterRemove('pemakaianBahan', 'sumberdana_id');
                renameInputAfterRemove('pemakaianBahan', 'satuankecil_id');
            }
        });
        hitungTotal();
    }

    function removeAlatMedis(obj) {
        myConfirm("Apakah Anda akan menghapus pemakaian alat medis?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parent().parent().remove();

                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'daftartindakan_id');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'alatmedis_id');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'hargajual');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'hargasatuan');
                renameInputAfterRemoveAlatMedis('pemakaianAlat', 'harganetto');

                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'sumberdana_id');
                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'qty');
                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'satuankecil_id');
                renameInputAfterRemoveAlatMedis('pemakaianBahan', 'subtotal');
            }
        });
        hitungTotal();
    }

    function renameInputAfterRemove(modelName, attributeName) {
        var i = -1;
        $('#tblInputPemakaianBahan tr.pemakaian_bahan').each(function () {
            if ($(this).has('input[name$="[obatalkes_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function renameInputAfterRemoveAlatMedis(modelName, attributeName) {
        var i = -1;
        $('#tblInputPemakaianBahan tr.pemakaian_alat').each(function () {
            if ($(this).has('input[name$="[alatmedis_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function hitungSubTotal(obj) {
        var qty = unformatNumber(obj.value);
        var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual]"]').val());
        var subtotal = qty * harga;
        $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
        hitungTotal();
        //    $('.currency').each(function(){this.value = formatNumber(this.value)});
        //    $('.number').each(function(){this.value = formatNumber(this.value)});
    }

    function hitungTotal() {
        var total = 0;
        $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function () {
            total = total + unformatNumber(this.value);
        });
        //    $('#totPemakaianBahan').val(formatNumber(total));
    }

    function inputAlatmedis(idAlat) {
        var idDaftartindakan = $('#daftartindakanPemakaianBahan option:selected').val();
        if (idDaftartindakan == '') {
            myAlert('Belum ada Tindakan');
            return false;
        }

        var is_ada = false;
        $('#tblInputPemakaianBahan tbody tr.pemakaian_alat').each(function () {
            if ($(this).find(".daftartindakan_id").val() == idDaftartindakan) {
                $(this).remove();
            }
        });

        jQuery.ajax({
            'url': '<?php echo $this->createUrl('addFormPemakaianAlat') ?>',
            'data': {
                idAlat: idAlat,
                idDaftartindakan: idDaftartindakan
            },
            'type': 'post',
            'dataType': 'json',
            'success': function (data) {
                if (!sudahAdaAlat(idAlat)) {
                    $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
                    $('#tblInputPemakaianBahan > tbody').append(data.form);
                    renameInput('pemakaianAlat', 'alatmedis_id');
                    renameInput('pemakaianAlat', 'hargajual');
                    renameInput('pemakaianAlat', 'hargasatuan');
                    renameInput('pemakaianAlat', 'harganetto');
                    renameInput('pemakaianAlat', 'qty');
                    renameInput('pemakaianAlat', 'subtotal');
                    renameInput('pemakaianAlat', 'daftartindakan_id');
                    renameInput('pemakaianAlat', 'sumberdana_id');
                    hitungTotal();
                }

                $("#tblInputPemakaianBahan > tbody tr:last .currency").maskMoney({
                    "symbol": "Rp ",
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0
                });
                $('.currency').each(function () {
                    this.value = formatNumber(this.value)
                });
                $("#tblInputPemakaianBahan > tbody tr:last .number").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0,
                    "symbol": null
                });
                $('.number').each(function () {
                    this.value = formatNumber(this.value)
                });
            },
            'cache': false
        });

        function sudahAdaAlat(idAlat) {
            var ada;
            $('#tblInputPemakaianBahan').find('input[name$="[alatmedis_id]"]').each(function () {
                var cek = true;
                if (this.value != idAlat) {
                    ada = cek && ada;
                } else {
                    myAlert('Sudah ada!');
                    ada = cek && true;
                }
            });

            return ada;
        }

        function renameInput(modelName, attributeName) {
            var i = -1;
            $('#tblInputPemakaianBahan tr.pemakaian_alat').each(function () {
                if ($(this).has('input[name$="[alatmedis_id]"]').length) {
                    i++;
                }
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('input[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('name', modelName + '[' + i + '][' + attributeName + ']');
                $(this).find('select[id=' + modelName + '_0_' + attributeName + ']').attr('id', modelName + '_' + i + '_' + attributeName + '');
            });
        }
    }
</script>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAlatmedis',
    'options' => array(
        'title' => 'Alat Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));

$modAlat = new AlatmedisM('search');
$modAlat->unsetAttributes();
if (isset($_GET['AlatmedisM']))
    $modAlat->attributes = $_GET['AlatmedisM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'almes-m-grid',
    'dataProvider' => $modAlat->search(),
    'filter' => $modAlat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        'jenisalatmedis.jenisalatmedis_nama',
        'alatmedis_nama',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputAlatmedis($data->alatmedis_id);return false;"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>