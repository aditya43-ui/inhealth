<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-utensils"></i> Transaksi <b>Pengiriman Menu Diet Pasien</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gzkirimmenudiet-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        ));
        ?>
        <?php
        if (!empty($_GET['id'])) {
        ?>
            <div class="alert alert-block alert-success">
                <a class="close" data-dismiss="alert">×</a>
                Data berhasil disimpan
            </div>
        <?php } ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <?php
        if (isset($modPesan)) {
            $this->renderPartial('_dataPesan', array('modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan, 'model' => $model, 'form' => $form));
        }
        ?>
        <?php $this->renderPartial('_dataForm', array('model' => $model, 'form' => $form, 'modPesan' => $modPesan)); ?>
        <?php echo Chtml::css('.table thead tr th{vertical-align:middle;}'); ?>

        <?php if (isset($modPesan)){
            $this->renderPartial('_detailPesan', array('modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan, 'model' => $model, 'modDetailKirim' => $modDetailKirim, 'form' => $form)); 
        }else{
            $this->renderPartial('_detailPesan', array('modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan, 'model' => $model, 'modDetailKirim' => $modDetailKirim, 'form' => $form)); 
        }
        ?>
        
        <div class="form-actions">
            <?php
            if (!empty($_GET['id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan',
                        'class' => 'btn btn-danger',
                        'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true
                    )
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan',
                        'class' => 'btn btn-danger',
                        'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'
                    )
                );
            }
            ?>
            <?php
            if ((!empty($_GET['id']))) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    '#',
                    array('class' => 'btn btn-info', 'onclick' => "print('$model->kirimmenudiet_id');return false", 'disabled' => FALSE)
                ) . " ";
            ?>
                <div class="btn-group">
                    <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Print Label', array(
                        'class' => 'btn btn-info dropdown-toggle', 'data-toggle' => 'dropdown'
                    )); ?>
                    <ul class="dropdown-menu dropdown-blue">
                        <?php
                        $jenis = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true order by jeniswaktu_jam');
                        foreach ($jenis as $item) {
                            echo "<li>";
                            echo CHtml::link('Print ' . $item->jeniswaktu_nama, '#', array(
                                'onclick' => 'printLabel(' . $model->kirimmenudiet_id . ', ' . $item->jeniswaktu_id . ')'
                            ));
                            echo "</li>";
                        }
                        ?>
                    </ul>
                </div>
            <?php
            } else {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    '#',
                    array('class' => 'btn btn-info', 'disabled' => TRUE)
                ) . " ";
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')),
                    '#',
                    array('class' => 'btn btn-info', 'disabled' => TRUE)
                );
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial('_dialog', array('model' => $model, 'form' => $form)); ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
$modKunjungan = new InfopasienmasukkamarV('search');
$modKunjungan->unsetAttributes();
if (isset($_GET['InfopasienmasukkamarV']))
    $modKunjungan->attributes = $_GET['InfopasienmasukkamarV'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzinfokunjunganri-v-grid',
    'dataProvider' => $modKunjungan->search(),
    'filter' => $modKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPasien",
                "onClick" => "
                    $(\"#pasien_id\").val($data->pasien_id);
                    $(\"#kelaspelayanan_id\").val($data->kelaspelayanan_id);
                    $(\"#pendaftaran_id\").val($data->pendaftaran_id);
                    $(\"#pasienadmisi_id\").val($data->pasienadmisi_id);
                    $(\"#kelaspelayanan_id\").val($data->kelaspelayanan_id);
                    $(\'#namaPasien\').val(\'$data->nama_pasien\');
                    $(\"#dialogPasien\").dialog(\"close\");
//                                dialogMenuPasien($data->pendaftaran_id, $data->carabayar_id);
                "))',
            //            array(
            //                'header'=>'Pilih',
            //                'type'=>'raw',
            //                'value'=>'CHtml::checkBox("data", "", array("value"=>$data->pendaftaran_id, "class"=>"pendaftaranId", "admisi"=>$data->pasienadmisi_id))',
        ),
        'no_pendaftaran',
        'no_rekam_medik',
        'nama_pasien',
        'umur',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'filter' =>  LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'name' => 'kelaspelayanan_nama',
            'value' => '$data->kelaspelayanan_nama'
        ),
        array(
            'header' => 'Jenis Penjamin',
            'name' => 'carabayar_id',
            'value' => '$data->carabayar_nama',
            'filter' =>  CHtml::activeDropDownList($modKunjungan, 'carabayar_id', CHtml::listData(
                CarabayarM::model()->findAllByAttributes(array(
                    'carabayar_aktif' => true
                )),
                'carabayar_id',
                'carabayar_nama'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'penjamin_id',
            'value' => '$data->penjamin_nama',
            'filter' => false,
        ),
        array(
            'header' => 'Ruangan',
            'name' => 'ruangan_id',
            'filter' =>  CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'),
            'value' => '$data->ruangan_nama'
        ),
        'kamarruangan_nokamar',
        'kamarruangan_nobed',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
$instalasi_id = CHtml::activeId($model, 'instalasi_id');
$ruangan_id = CHtml::activeId($model, 'ruangan_id');
$totalPesan = CHtml::activeId($model, 'totalpesan_org');
$bahandiet_id = CHtml::activeId($model, 'bahandiet_id');
$namaPemesan = CHtml::activeId($model, 'nama_pemesan');
//$url = Yii::app()->createUrl('actionAjax/getMenuDietDetailDariKirim');
$urlPrintKuponGizi = Yii::app()->createUrl('gizi/KirimmenudietT/PrintKirimMenuDiet', array('id' => ''));
$url = Yii::app()->createUrl('gizi/KirimmenudietT/GetMenuDietDetailKirim');
$urlPrintLabel = Yii::app()->createUrl('gizi/KirimmenudietT/PrintLabelNew', array('id' => ''));
$urlCekStok = Yii::app()->createUrl('actionAjax/getStokBahanMakanan');
$urlCekInput = Yii::app()->createUrl('actionAjax/getStokBahanMakananInput');
$js = <<< JS
function printLabel(idKirimMenuDiet,jeniswaktu)
{
     window.open('${urlPrintLabel}'+idKirimMenuDiet+'&jeniswaktu='+jeniswaktu,'printwin','left=100,top=100,width=940,height=400');
}        
function print(idKirimMenuDiet)
{
     window.open('${urlPrintKuponGizi}'+idKirimMenuDiet,'printwin','left=100,top=100,width=940,height=400');
}
function hitungSemua(){
        noUrut = 1;
        jumlah = 0;
        $('.cekList').each(function(){
            $(this).parents('tr').find('[name*="GZPesanmenudetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('GZPesanmenudetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','KirimmenupasienT['+(noUrut-1)+']'+data[1]);
                }
            });
            $(this).parents('tr').find('[name*="KirimmenupegawaiT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('KirimmenupegawaiT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','KirimmenupegawaiT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
            if($(this).is(':checked')){
                jumlah++;
            }
        });
    }
function inputMenuDiet(){
        var pasien_id = $('#pasien_id').val();
        var pendaftaran_id = $('#pendaftaran_id').val();
        var pasienadmisi_id = $('#pasienadmisi_id').val();
        var menudiet_id = $('#menudiet_id').val();
        var daftartindakan_id = parseFloat($('#daftartindakan_id').val());
        var kelaspelayanan_id = parseFloat($('#kelaspelayanan_id').val());
        var satuanTarif = $('#satuanTarif').val();
        var jumlah = $('#jumlah').val();
        var jeniswaktu = new Array();
        var pendaftaranId = new Array();
        var pasienAdmisi = new Array();
        var urt = $('#URT').val();
        var ruangan_id = $('#${ruangan_id}').val();
        var instalasi_id = $('#${instalasi_id}').val();
        var butuh = new Array();
        var total = new Array();
        i=0;
        $('.menudiet').each(function(){
            var jml_kirim = parseFloat($(this).parents('tr').find('.jmlKirim').val());
            var values = $(this).val();
            if(jQuery.isNumeric(values)){
                if (jQuery.inArray(values, butuh) == -1){
                    butuh[i] = values;
                    total[i] = jml_kirim;
                    i++;
                }
                else{
                    total[jQuery.inArray(values, butuh)] = total[jQuery.inArray(values, butuh)]+jml_kirim;
                }
            }
        });
        i = 0;
        $('.jeniswaktu').each(function(){
            value = $(this).val();
            if ($(this).is(':checked')){
                jeniswaktu[i]=value;
                i++;
            }
        });
        i = 0;
        $('.pendaftaranId').each(function(){
            value = $(this).val();
            valueAdmisi = $(this).attr('admisi');
            if ($(this).is(':checked')){
                pasienAdmisi[i]=valueAdmisi;
                pendaftaranId[i]=value;
                i++;
            }
        });
        if (!jQuery.isNumeric(ruangan_id)){
            myAlert('Silakan pilih ruangan!');
            return false;
        }
        else if ((!jQuery.isNumeric(pendaftaran_id))&&(pendaftaranId.length < 1)){
            myAlert('Silakan isi nama pasien!');
            return false;
        }
        else if (!jQuery.isNumeric(menudiet_id)){
            myAlert('Silakan isi makanan diet yang dipilih!');
            return false;
        }
        else if (jeniswaktu.length < 1){
            myAlert('Silakan isi Jenis Waktu yang dipilih!');
            return false;
        }
        else{
            $.post('${url}', {pasien_id:pasien_id, butuh:butuh, total:total, pasienAdmisi:pasienAdmisi, pasienadmisi_id:pasienadmisi_id, pendaftaranId:pendaftaranId, jeniswaktu:jeniswaktu, pendaftaran_id:pendaftaran_id, menudiet_id:menudiet_id, jumlah:jumlah, urt:urt, ruangan_id:ruangan_id, instalasi_id:instalasi_id, daftartindakan_id:daftartindakan_id, kelaspelayanan_id:kelaspelayanan_id}, function(data){
                if (data == null){
                    myAlert('Stok Bahan Menu Diet habis');
                }else{
                    $('#tableMenuDiet tbody').append(data);
                    $("#tableMenuDiet tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    hitungSemua();
					$('#pasien_id').val('');
					$('#kelaspelayanan_id').val('');
					$('#pendaftaran_id').val('');
					$('#pasienadmisi_id').val('');
					$('#daftartindakan_id').val('');
					$('#satuanTarif').val('');
                }
            }, 'json');
        }
        clearAll(1);
    }
function clearAll(code){
        var tempRuangan = $('#${ruangan_id}').val();
        var tempInstalasi = $('#${instalasi_id}').val();
//        $('#fieldsetMenuDiet div').find('input,select').each(function(){
//            if ($(this).attr('type') == 'checkbox'){
//                
//            }
//            else{
//                $(this).val('');
//            }
//        }); 
//        if (!jQuery.isNumeric(code)){
//            $('#fieldsetMenuDiet #tableMenuDiet tbody').find('tr').each(function(){
//                $(this).remove();
//            });
//        }
        if(jQuery.isNumeric(tempRuangan)){
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                    data: "InfopasienmasukkamarV[ruangan_id]="+tempRuangan
            });
        }
        $('#jumlah').val(1);
        $('#namaPasien').val('');
        $('#menuDiet').val('');
        $('#${ruangan_id}').val(tempRuangan);
        $('#${instalasi_id}').val(tempInstalasi);
    }
function dialogMenuPasien(){
        ruangan = $('#${ruangan_id}').val();
        if(!jQuery.isNumeric(ruangan)){
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                    data: "InfopasienmasukkamarV[ruangan_id]=0"
            });
        }
        else{
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                    data: "InfopasienmasukkamarV[ruangan_id]="+ruangan
            });
        }
        if(!jQuery.isNumeric(ruangan)){
            myAlert('Isi ruangan terlebih dahulu!');
            return false;
        }else{
            $('#dialogPasien').dialog('open');
        }
    }
    function cekStokMenu(obj){
        var value = $(obj).val();
        var total = parseFloat(0);
        $('.menudiet').each(function(){
            var jml_kirim = parseFloat($(this).parents('tr').find('.jmlKirim').val());
            if ($(this).val() == value){
                total = total+jml_kirim;
            }
        });
        $.post('${urlCekStok}', {total:total, value:value}, function(data){
            if (data == 1){
            }else{
                $(obj).val('');
                myAlert('Stok bahan makanan habis');
            }
        }, 'json');
    }
    function cekStokMenuInput(obj){
        var butuh = new Array();
        var total = new Array();
        i=0;
        $('.menudiet').each(function(){
            var jml_kirim = parseFloat($(this).parents('tr').find('.jmlKirim').val());
            var values = $(this).val();
            if(jQuery.isNumeric(values)){
                if (jQuery.inArray(values, butuh) == -1){
                    butuh[i] = values;
                    total[i] = jml_kirim;
                    i++;
                }
                else{
                    total[jQuery.inArray(values, butuh)] = parseFloat(total[jQuery.inArray(values, butuh)]+jml_kirim);
                }
            }
        });
        $.post('${urlCekInput}', {butuh:butuh, total:total}, function(data){
            if (data == 1){
            }else{
                $(obj).val(0);
                myAlert('Stok bahan makanan habis');
            }
        }, 'json');
    }
    function checkAll(kelas,obj)
    {
        if(obj.checked) {
            $('.'+kelas+'').each(function() {
                $(this).attr('checked', 'checked');
            });
        }
        else
        {
            obj.checked = false;
            $('.'+kelas+'').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
JS;
Yii::app()->clientScript->registerScript('onhead', $js,  CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('ready', '
    hitungSemua();
    $("form").submit(function(){
        var idBahanDiet =$("#' . $bahandiet_id . '").val();
        jumlah = 0;
        $(".cekList").each(function(){
            if ($(this).is(":checked")){
                jumlah++;
            }
        });
//        if (!jQuery.isNumeric($("#' . $bahandiet_id . '").val())){
//            myAlert("' . CHtml::encode($model->getAttributeLabel('bahandiet_id')) . ' harus diisi!");
//            return false;
//        }
        if (!jQuery.isNumeric($("#' . CHtml::activeId($model, 'jenisdiet_id') . '").val())){
            myAlert("' . CHtml::encode($model->getAttributeLabel('jenisdiet_id')) . ' harus diisi!");
            return false;
//        }
//        else if (!jQuery.isNumeric($("#' . $ruangan_id . '").val())){
//            myAlert("' . CHtml::encode($model->getAttributeLabel('ruangan_id')) . ' harus diisi!");
//            return false;
        }
        else if (jumlah < 1){
            myAlert("Pilih Menu Diet Pasien yang akan dipesan!");
            return false;
        }
    });
',  CClientScript::POS_READY);
?>
<script>
    function cekJenisDiet(idJenisDiet, idJenisDietNama) {
        var idJenisBaru = idJenisDiet;
        var idJenisLama = $('#idJenisDiet').val();
        var namaJenisBaru = idJenisDietNama;
        var idPesan = '<?php echo (isset($_GET['idPesan']) ? $_GET['idPesan'] : null); ?>';
        if (idJenisLama == '') {
            idJenisLama = $('#GZKirimmenudietT_jenisdiet_id').val();
        }
        //        if(idJenisBaru != idJenisLama){
        //            myAlert('Maaf, Jenis Diet tidak dapat dipilih lebih dari satu');
        //            $('#GZKirimmenudietT_jenisdiet_id').val(idJenisLama);
        //            $('#idJenisDiet').val(idJenisLama);
        //            $('#idJenisDiet2').val(idJenisLama);
        //            $('#jenisdiet').val(namaJenisLama);
        //            return false;
        //        }else{
        $('#idJenisDiet').val(idJenisBaru);
        $('#idJenisDiet2').val(idJenisBaru);
        $('#jenisdiet').val(namaJenisBaru);
        //        }
        refreshDialogMenu();
        // refreshDialogMenus();
    }

    function refreshDialogMenu() {
        var idJenisDiet = $("#GZKirimmenudietT_jenisdiet_id").val();
        $("#GZMenuDietM_jenisdiet_id").val(idJenisDiet);
        $.fn.yiiGridView.update('gzmenudiet-m-grid', {
            data: $("#gzmenudiet-m-grid :input").serialize()
        });
    }
    /**
     * untuk refresh dialog menu banyak
     * @returns {undefined}
     */
    function refreshDialogMenus() {
        var idJenisDiet = $("#GZKirimmenudietT_jenisdiet_id").val();
        $.fn.yiiGridView.update('gzmenudiet-m', {
            data: {
                "GZJenisdietM[jenisdiet_id]": idJenisDiet
            }
        });
    }

    function getIdJenisWaktu(jeniswaktu_id, noUrut) {
        location.hash = "jeniswaktu_id=" + jeniswaktu_id + "&noUrut=" + noUrut;
    }

    function getHashValue(key) {
        return location.hash.match(new RegExp(key + '=([^&]*)'))[1];
    }

    function ubahMenu(menudiet_id, menudiet_nama, daftartindakan_id) {
        var jeniswaktu_id = getHashValue('jeniswaktu_id');
        var noUrut = getHashValue('noUrut');
        var daftartindakan_id = daftartindakan_id;
        var kelaspelayanan_id = $('#KirimmenupasienT_' + noUrut + '_kelaspelayanan_id_' + jeniswaktu_id + '').val();
        $.post('<?php echo Yii::app()->createUrl('gizi/KirimmenudietT/setTarifTindakan'); ?>', {
            daftartindakan_id: daftartindakan_id,
            kelaspelayanan_id: kelaspelayanan_id
        }, function(data) {
            $('#KirimmenupasienT_' + noUrut + '_satuanTarif_' + jeniswaktu_id + '').val(data.satuan_tarif);
        }, 'json');
        $('#KirimmenupasienT_' + noUrut + '_menudiet_nama_' + jeniswaktu_id + '').val(menudiet_nama);
        $('#KirimmenupasienT_' + noUrut + '_menudiet_id_' + jeniswaktu_id + '').val(menudiet_id);
        $('#KirimmenupasienT_' + noUrut + '_daftartindakan_id_' + jeniswaktu_id + '').val(daftartindakan_id);
    }
    $(document).ready(function() {
        <?php
        if (isset($model->kirimmenudiet_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_GIZI ?>,
                judulnotifikasi: 'Pengiriman Menu Diet Pasien',
                isinotifikasi: 'Telah dikirimkan menu diet untuk pada <?php echo $model->tglkirimmenu ?>'
            };
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
</script>