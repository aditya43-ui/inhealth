<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <?php
            $headerName = "Pegawai & Pendamping Pasien";
            $is_pendamping = false;
            if (isset($model->jenispesanmenu)) {
                $headerName = $model->jenispesanmenu;

                if ($model->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
                    $is_pendamping = true;
                }
            }
            ?>

            <i class="fas fa-utensils"></i> Transaksi <b>Pengiriman Menu <?php echo $headerName; ?></b>
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
            <!--<div class="alert alert-block alert-success">-->
            <!--<a class="close" data-dismiss="alert">×</a>-->
            <!--Data berhasil disimpan-->
            <!--</div>-->
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
        <?php $this->renderPartial('_detailPegawai', array('is_pendamping' => $is_pendamping, 'modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan, 'model' => $model, 'form' => $form, 'headerName' => $headerName)); ?>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>
            <?php
            if ($model->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {

                if ((!empty($_GET['id']))) {
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                        '#',
                        array('class' => 'btn btn-info', 'onclick' => "print('$model->kirimmenudiet_id');return false", 'disabled' => FALSE)
                    ) . " ";
            ?>
                    <div class="btn-group">
                        <?php
                        echo CHtml::htmlButton('<i class="entypo-print"></i> Print Label', array(
                            'class' => 'btn btn-info dropdown-toggle', 'data-toggle' => 'dropdown'
                        ));
                        ?>
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
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/indexPegawai&modul_id=' . Yii::app()->session['modul_id']),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial('_dialog', array('model' => $model, 'form' => $form)); ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPejadwalanPeg = new GZPenjadwalandetailT("searchDialog");

//$modPegawai = new GZPegawairuanganV('search');
$modPejadwalanPeg->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GZPenjadwalandetailT']))
    $modPejadwalanPeg->attributes = $_GET['GZPenjadwalandetailT'];
//        $modPejadwalanPeg->ruangan_id = isset($_GET['GZKirimmenudietT']['ruangan_id'])?$_GET['GZKirimmenudietT']['ruangan_id']:null;
//        $modPejadwalanPeg->shift_id = isset($_GET['shift_id'])?$_GET['shift_id']:null;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzpegawairuangan-v-grid',
    'dataProvider' => $modPejadwalanPeg->searchDialog(),
    'filter' => $modPejadwalanPeg,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        //		array(
        //            'header'=>'Pilih',
        //            'type'=>'raw',
        //            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
        //                "id" => "selectPegawai",
        //                "onClick" => "
        //                    $(\"#pegawai_id\").val($data->pegawai_id);
        //                    $(\"#namaPegawai\").val(\'$data->nama_pegawai\');
        //                    $(\"#ruangan_id\").val(\'$data->ruangan_id\');
        //                    $(\"#instalasi_id\").val(\'$data->instalasi_id\');
        //                    $(\"#dialogPegawai\").dialog(\"close\");
        ////                                dialogMenuPegawai($data->pegawai_id);
        //                "))',
        //		),
        array(
            'header' => CHtml::checkBox('check_all', false, array(
                'class' => 'check_all_produk', 'onchange' => 'set_check_all_pegawai();'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::checkBox('check', false, array(
                    'data-id' => $data->pegawai_id,
                    'onchange' => 'check_sr_pegawai(this);',
                    'class' => 'request_checks_pegawai',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('+ Tambah', array('class' => 'btn btn-primary', 'onclick' => 'add_pegawai_pilihan(); $("#dialogPegawai").dialog("close");'))
        ),
        array(
            'header' => 'Ruangan',
            'name' => 'ruangan_id',
            'value' => '$data->ruangan_nama',
            'filter' => false,
        ),
        'nama_pegawai',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});update_check_selected_produk();}',
));

$this->endWidget();

$urlPrintLabel = Yii::app()->createUrl('gizi/KirimmenudietT/PrintLabelNew', array('id' => ''));
$urlPrintKuponGizi = Yii::app()->createUrl('gizi/KirimmenudietT/PrintKirimMenuDiet', array('id' => ''));
?>
<script type="text/javascript">
    function printLabel(idKirimMenuDiet, jeniswaktu) {
        window.open('<?php echo $urlPrintLabel; ?>' + idKirimMenuDiet + '&jeniswaktu=' + jeniswaktu, 'printwin', 'left=100,top=100,width=940,height=400');

    }

    function print(idKirimMenuDiet) {
        window.open('<?php echo $urlPrintKuponGizi; ?>' + idKirimMenuDiet, 'printwin', 'left=100,top=100,width=940,height=400');

    }

    var is_checked = {};
    var is_checked_pegawai = {};

    function set_check_all_pegawai() {
        $(".request_checks_pegawai").prop("checked", $("#check_all").is(":checked")).change();
        if ($("#check_all").is(":checked") == true) {
            $(".request_checks_pegawai").each(function() {
                var id = $(this).data('id');
                var obj = $(this);
                if ((obj).prop("disabled") == false) {
                    is_checked_pegawai[id] = id;
                } else {
                    is_checked_pegawai[id] = 0;
                }
            });
        } else {
            $(".request_checks_pegawai").each(function() {
                var id = $(this).data('id');
                is_checked_pegawai[id] = 0;
            });
        }

    }

    function check_sr_pegawai(obj) {
        var id = $(obj).data('id');

        if ($(obj).is(":checked")) {
            is_checked_pegawai[id] = id;
        } else {
            is_checked_pegawai[id] = 0;
        }
    }

    function update_check_selected_produk() {
        $(".request_checks_pegawai").each(function() {
            var id = $(this).data('id');
            var obj = $(this);

            if (typeof is_checked_pegawai[id] != "undefined" && is_checked_pegawai[id] != 0)
                $(this).prop("checked", true);

            $("#tableMenuDiet > tbody > tr").each(function() {
                if ($(this).find('input[name$="[pegawai_id]"]').val() == id) {
                    $(obj).prop("checked", true).prop("disabled", true);
                }
            });
        });
    }

    function add_pegawai_pilihan() {
        var arr = new Array();
        var pemeriksaan = '';

        $.each(is_checked_pegawai, function(idx, val) {
            if (val > 0) {
                arr.push(val);
            }
        });
        console.log(arr);
        is_checked_pegawai = {};

        var menudiet_id = $('#menudiet_id').val();
        var jumlah = $('#jumlah').val();
        var urt = $('#URT').val();
        var jeniswaktu = new Array();
        var butuh = new Array();
        var total = new Array();
        var ruangan_id = $('#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>').val();
        var instalasi_id = $('#<?php echo CHtml::activeId($model, 'instalasi_id'); ?>').val();
        var jenisKelamin = $('#jeniskelamin').val();

        var i = 0;
        $('.menudiet').each(function() {
            var jml_kirim = parseFloat($(this).parents('tr').find('.jmlKirim').val());
            var values = $(this).val();
            if (jQuery.isNumeric(values)) {
                if (jQuery.inArray(values, butuh) == -1) {
                    butuh[i] = values;
                    total[i] = jml_kirim;
                    i++;
                } else {
                    total[jQuery.inArray(values, butuh)] = total[jQuery.inArray(values, butuh)] + jml_kirim;
                }
            }
        });

        var i = 0;
        $('.jeniswaktu').each(function() {
            value = $(this).val();
            if ($(this).is(':checked')) {
                jeniswaktu[i] = value;
                i++;
            }
        });

        $.post('<?php echo Yii::app()->createUrl('gizi/KirimmenudietT/GetMenuDietPegawaiDariKirim'); ?>', {
                pegawai_id: arr,
                jeniswaktu: jeniswaktu,
                menudiet_id: menudiet_id,
                jumlah: jumlah,
                urt: urt,
                total: total,
                butuh: butuh,
                ruangan_id: ruangan_id,
                instalasi_id: instalasi_id,
                jenisKelamin: jenisKelamin
            },
            //            {total:total,butuh:butuh,pegawaiId:arr, jeniswaktu:jeniswaktu, pegawai_id:pegawai_id, menudiet_id:menudiet_id, jumlah:jumlah, urt:urt, ruangan_id:ruangan_id, instalasi_id:instalasi_id, jenisKelamin:jenisKelamin}, 
            function(data) {
                if (data == null) {
                    myAlert('Stok Bahan Menu Diet habis');
                } else {
                    $('#tableMenuDiet tbody').append(data);
                    $("#tableMenuDiet tbody tr:last .numbersOnly").maskMoney({
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": "",
                        "precision": 0,
                        "symbol": null
                    });
                    hitungSemua();
                }
            }, 'json');
        $('#jenispesanmenu').attr('disabled', 'disabled');
        $('#jeniskelamin').attr('disabled', 'disabled');
        //        clearAll(1);

    }

    function setJenisPesan() {
        var value = $('#jenispesanmenu').val();

        if (value == 'Pegawai') {
            $("#pegawaiGroup").slideDown('slow');
            $("#tamuGroup").hide();
        } else if (value == 'Tamu') {
            $("#tamuGroup").slideDown('slow');
            $("#pegawaiGroup").hide();
        }
    }

    function cekJenisDiet(idJenisDiet, idJenisDietNama) {
        var idJenisBaru = idJenisDiet;
        var idJenisLama = $('#idJenisDiet').val();
        var namaJenisBaru = idJenisDietNama;
        var namaJenisLama = $('#jenisdiet').val();
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
        refreshDialogMenus();

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

    /**
     * untuk refresh dialog pegawai banyak
     * @returns {undefined}
     */
    function refreshDialogPegawai() {
        var ruanganid = $("#GZKirimmenudietT_ruangan_id").val();
        var shiftid = $("#shift_id").val();

        $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
            data: {
                "GZPenjadwalandetailT[ruangan_id]": ruanganid,
                "GZPenjadwalandetailT[shift_id]": shiftid
            }
        });
    }

    $('#tombolDialogPegawai').click(function() {
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
        var menudiet_id = $("#menudiet_id").val();
        var shift_id = $("#shift_id").val();

        //	var penjamin_id = $("#penjamin_id").val();
        //	var kelaspelayanan_id = $("#kelaspelayanan_id").val();
        //	var pendaftaran_id = $("#pendaftaran_id").val();	

        <?php // if (isset($modPasienMasukPenunjang)){   
        ?>
        //		 ruangan_id = $("#<?php // echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id')   
                                    ?>").val();
        //		 kelaspelayanan_id = $("#<?php // echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id')   
                                            ?>").val();
        <?php // }   
        ?>

        if (ruangan_id == '') {
            $("#dialogPegawai").dialog("close");
            myAlert("Maaf,  Ruangan Belum Dipilih");
            return false;
        }

        if (menudiet_id == '') {
            $("#dialogPegawai").dialog("close");
            myAlert("Maaf,  Menu Diet Belum Dipilih");
            return false;
        }

        if (shift_id == '') {
            $("#dialogPegawai").dialog("close");
            myAlert("Maaf,  Shift Belum Dipilih");
            return false;
        }

        if (ruangan_id != '' && menudiet_id != '' && shift_id != '') {
            $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
                data: {
                    "GZPenjadwalandetailT[ruangan_id]": ruangan_id,
                    "GZPenjadwalandetailT[shift_id]": shift_id
                }
            });
        }
    });

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
<?php
$totalPesan = CHtml::activeId($model, 'totalpesan_org');
$instalasi_id = CHtml::activeId($model, 'instalasi_id');
$ruangan_id = CHtml::activeId($model, 'ruangan_id');
$jenisPesan = CHtml::activeId($model, 'jenispesanmenu');
$bahandiet_id = CHtml::activeId($model, 'bahandiet_id');
$namaPemesan = CHtml::activeId($model, 'nama_pemesan');
$pesanPegawai = Params::JENISPESANMENU_PEGAWAI;
$url = Yii::app()->createUrl('gizi/KirimmenudietT/GetMenuDietPegawaiDariKirim');
$urlCekStok = Yii::app()->createUrl('actionAjax/getStokBahanMakanan');
$urlCekInput = Yii::app()->createUrl('actionAjax/getStokBahanMakananInput');
$jsx = <<< JS
    function inputMenuDiet(){
        var pegawai_id = $('#pegawai_id').val();
        var menudiet_id = $('#menudiet_id').val();
        var jumlah = $('#jumlah').val();
        var urt = $('#URT').val();
        var jeniswaktu = new Array();
        var ruangan_id = $('#${ruangan_id}').val();
        var instalasi_id = $('#${instalasi_id}').val();
        var instalasi = $('#instalasi_id').val();
        var ruangan = $('#ruangan_id').val();
        var jenisPesan = $('#jenispesanmenu').val();
        var jenisKelamin = $('#jeniskelamin').val();
        var pegawaiId = new Array();
        var butuh = new Array();
        var total = new Array();

//         myAlert($('#${jenisPesan}').val());

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
        
        if (jenisPesan == ''){
            myAlert('Isi Jenis Pesan Menu');
            return false;
        }
		if (pegawai_id == ''){
			if (jenisKelamin == ''){
				myAlert('Isi Jenis Kelamin');
				return false;
			}
		}
        
        i = 0;
        $('.jeniswaktu').each(function(){
            value = $(this).val();
            if ($(this).is(':checked')){
                jeniswaktu[i]=value;
                i++;
            }
        });
        i = 0;
        $('.pegawaiId').each(function(){
            value = $(this).val();
            if ($(this).is(':checked')){
                pegawaiId[i]=value;
                i++;
            }
        });
        
        if (!jQuery.isNumeric(instalasi_id)){
            instalasi_id = instalasi;
        }
        if (!jQuery.isNumeric(ruangan_id)){
            if (!jQuery.isNumeric(pegawai_id) && (jenisPesan != "${pesanPegawai}")){
                myAlert('Ruangan untuk Tamu harus diisi');
                return false;
            }
            ruangan_id = ruangan;
        }
        
        if ($('#jenisPesan').val() == '${pesanPegawai}'){
            if ((!jQuery.isNumeric(pegawai_id))&&(pegawaiId.length < 1)){
                myAlert('Nama Pegawai Harus Diisi!');
                return false;
            }
        }
        
        if (!jQuery.isNumeric(menudiet_id)){
            myAlert('Isi Makanan Diet yang dipilih!');
            return false;
        }
        else if (jeniswaktu.length < 1){
            myAlert('Isi Jenis Waktu!');
            return false;
        }
        else{
            $.post('${url}', {total:total,butuh:butuh,pegawaiId:pegawaiId, jeniswaktu:jeniswaktu, pegawai_id:pegawai_id, menudiet_id:menudiet_id, jumlah:jumlah, urt:urt, ruangan_id:ruangan_id, instalasi_id:instalasi_id, jenisKelamin:jenisKelamin}, function(data){
                if (data == null){
                    myAlert('Stok Bahan Menu Diet habis');
                }else{
                    $('#tableMenuDiet tbody').append(data);
                    $("#tableMenuDiet tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    hitungSemua();
                }
            }, 'json');
        }
        $('#jenispesanmenu').attr('disabled','disabled');
        $('#jeniskelamin').attr('disabled','disabled');
        clearAll(1);
    }
    
    function clearAll(code){
        var tempRuangan = $('#${ruangan_id}').val();
        var tempInstalasi = $('#${instalasi_id}').val();
        var tempJenisPesan = $('#jenispesanmenu').val();
        
        $('#fieldsetMenuDiet div').find('input,select').each(function(){
           if ($(this).attr('type') == 'checkbox'){
                
            }
            else{
                $(this).val('');
            }
        });
        if (!jQuery.isNumeric(code)){
            $('#fieldsetMenuDiet #tableMenuDiet tbody').find('tr').each(function(){
                $(this).remove();
            });
        }
        if (jQuery.isNumeric(tempRuangan)){
            if ($('#cekRuangan').is(':checked')){
                 $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
                    data: "GZPenjadwalandetailT[ruangan_id]="+tempRuangan
                });
            }
        }
        
        $('#jumlah').val(1);
        $('#${ruangan_id}').val(tempRuangan);
        $('#${instalasi_id}').val(tempInstalasi);
        $('#jenispesanmenu').val(tempJenisPesan);
        $('#jenisPesan').val(tempJenisPesan);
    }
        
    
    function hitungSemua(){
        var sekian = 1;
        noUrut = 1;
        jumlah = 0;         

        
        $('.cekList').each(function(){
            var value = $(this).parents('tr').find('.nama').val();
            $(this).parents('tr').find('[name*="KirimmenupegawaiT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('KirimmenupegawaiT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','KirimmenupegawaiT['+(noUrut-1)+']'+data[1]);
                }
            });
        
            if (value == ''){
                $(this).parents('tr').find('.nama').val('Tamu '+sekian);
                sekian++;
            }
            
            $(this).parents('tr').find('#checkList').attr('name','checkList['+(noUrut-1)+']');
            
            if($(this).is(':checked')){
                jumlah++;
            }
            noUrut++;
        });
        $('#${totalPesan}').val(jumlah);
    }
    
    function setRuangan(){
        if ($('#cekRuangan').is(':checked')){
            $('#groupRuangan').find('select').each(function(){
                $(this).removeAttr('disabled','disabled');
            });
        }
        else{
            $('#groupRuangan').find('select').each(function(){
                $(this).attr('disabled','disabled');
            });
        }
        clearAll();
    }
    
    function dialogMenuPegawai(){
        ruangan = $('#${ruangan_id}').val();
        if(!jQuery.isNumeric(ruangan)){
            $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
                    data: "GZPenjadwalandetailT[ruangan_id]=0"
            });
        }
        else{
            $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
                    data: "GZPenjadwalandetailT[ruangan_id]="+ruangan
            });
        }
        if(!jQuery.isNumeric(ruangan)){
            myAlert('Isi ruangan terlebih dahulu!');
            return false;
        }else{
            $('#dialogPegawai').dialog('open');
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
    
JS;
Yii::app()->clientScript->registerScript('head', $jsx, CClientScript::POS_HEAD);
?>

<?php Yii::app()->clientScript->registerScript('submit', '
    $.fn.yiiGridView.update(\'gzpegawairuangan-v-grid\', {
                    data: "GZPenjadwalandetailT[ruangan_id]=0"
            });
    $("form").submit(function(){
        var bahandiet_id =$("#' . $bahandiet_id . '").val();
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
//        else 
		if (!jQuery.isNumeric($("#' . CHtml::activeId($model, 'jenisdiet_id') . '").val())){
            myAlert("' . CHtml::encode($model->getAttributeLabel('jenisdiet_id')) . ' harus diisi!");
            return false;
        }
//        if ($("#' . $jenisPesan . '").val() == ""){
//            myAlert("' . CHtml::encode($model->getAttributeLabel('jenispesanmenu')) . ' harus diisi!");
//            return false;
//        }
        else if (jumlah < 1){
            myAlert("Pilih Menu Diet Pasien yang akan dipesan!");
            return false;
        }
        
    });
    hitungSemua();
    // setJenisPesan();
    clearAll();
', CClientScript::POS_READY); ?>