<!--<legend class="rim2">Reseptur Pasien</legend>-->
<?php
$this->breadcrumbs=array(
	'Reseptur',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<style type="text/css">
	.integer-decimal{
		text-align: right;
	}
    .row{
        margin-bottom: 10px;
    }
</style>
<?php
$dokter = false;
$kelompokpegawai_id = PegawaiM::model()->findByPk(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->kelompokpegawai_id;
if ($kelompokpegawai_id === Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP || Yii::app()->user->id == Params::LOGINPEMAKAI_ID_ADMIN) {
    $dokter = true;

}

?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjreseptur-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#therapiobat_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
             'class'=>'form-iframe'
                             ),
)); ?>
<div class="row">
    <div class="col-sm-12">
    <?php
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'riwayat-pasien',
        'content' => array(
            'content-' => array(
                'header' => 'Riwayat Pasien',
                'isi' => '<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
                'active' => true,
            ),
        ),
    ));
    ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php 
        // if (!empty($this->modSMS)) {
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'riwayat-penjualanresep',
                'content' => array(
                    'content-riwayat-penjualanresep' => array(
                        'header' => '<b>Riwayat Penjualan Resep</b>',
                        'isi' => $this->renderPartial($this->path_view . "_riwayatPenjualanResep", array(
                            'modRiwayatPenjualanResep' => $modRiwayatPenjualanResep
                        ), true),
                        'active' => true,
                    ),
                ),
            ));
        // }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php 
        // if (!empty($this->modSMS)) {
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'list-rujukankeluar',
                'content' => array(
                    'content-list-rujukankeluar' => array(
                        'header' => '<b>Riwayat Resep Pasien</b>',
                        'isi' => $this->renderPartial($this->path_view . "_listResep", array(
                            "modRiwayatResep" => $modRiwayatResep,
                            'modRiwatReseptur' => $modRiwatReseptur,
                            'dokter'=>$dokter,
                        ), true),
                        'active' => true,
                    ),
                ),
            ));
        // }
        ?>
    </div>
</div> 
<div class="row kumpulanTombol">
    <div class="col-sm-12">
        <div style="float: right;">
        <input type="hidden" id="penjualanresep_id">
            <?php 

                // echo CHtml::Link('<i class="icon-print icon-white"></i> Print Nota Penjualan', 'javascript:;', array('class' => 'btn btn-info penjualan', 'type' => 'button', 'onclick' => 'printNotaPenjualan(\'PRINT\')', 'disabled' => true));

                // echo CHtml::Link('<i class="icon-print icon-white"></i> Print Nota Tindakan', 'javascript:;', array('class' => 'btn btn-info notatindakan', 'type' => 'button', 'onclick' => 'printetiketRanap(\'PRINT\')', 'disabled' => true));

                // echo CHtml::Link('<i class="icon-print icon-white"></i> Lembar Telaah', 'javascript:;', array('class' => 'btn btn-info telaah', 'type' => 'button', 'onclick' => 'printTelaah(\'PRINT\')', 'disabled' => true));

                echo CHtml::htmlButton(Yii::t('mds','{icon} Buat Penjualan',array('{icon}'=>'<i class="entypo-form"></i>')),array('class'=>'btn btn-danger', 'type'=>'button','id'=>'btn_reseptur', 'onclick' => 'buatReseptur()', 'disabled' => true)); 
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Resep</div>
            </div>
            <div class="panel-body" id="form-dataresep">
                <?php  $this->renderPartial($this->path_view.'_formDataResep', array('form'=>$form,
                            'modRiwatReseptur' => $modRiwatReseptur,'modReseptur'=>$modReseptur, 'modPendaftaran'=>$modPendaftaran, 'dokter' => $dokter)); ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?php
            if(!isset($_GET['sukses'])){
                //   $this->renderPartial($this->path_view.'_formInputObat',array('modPendaftaran'=>$modPendaftaran,'form'=>$form,'modReseptur'=>$modReseptur));
            }
        ?>
    </div>
</div>
   
<div class="row formInputTab">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Reseptur</strong></div>
            </div>
            <div class="panel-body table-responsive" style="overflow-x: auto;max-width: 100%">
                <div class="block-tabel">
                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                        <thead>
                                <th>Tanggal Resep</th>
                                <th>No Resep Triage</th>
                                <th>No Bed Triage</th>
                                <th>Nama Pasien</th>
                                <th>Petugas Farmasi</th>
                                <th>Petugas Pengambil Obat</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Batal</th>
                                
                        </thead>
                        <tbody>
                            <?php
                            // if(count((array)$modResepturDetail) > 0){
                            //     foreach($modResepturDetail AS $i=> $modDetail){
                            //         $modDetail->qty_reseptur = is_numeric($modDetail->qty_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->qty_reseptur, 2) : $modDetail->qty_reseptur;
                            //         $modDetail->permintaan_dosis = is_numeric($modDetail->permintaan_dosis) ? MyFormatter::formatNumberForPrint($modDetail->permintaan_dosis, 2) : $modDetail->permintaan_dosis;
                            //         $modDetail->hargasatuan_reseptur = is_numeric($modDetail->hargasatuan_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargasatuan_reseptur, 2) : $modDetail->hargasatuan_reseptur;
                            //         $modDetail->hargajual_reseptur = is_numeric($modDetail->hargajual_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargajual_reseptur, 2) : $modDetail->hargajual_reseptur;
                            //         if ($modDetail->is_permitaandosispecahan == true) {
                            //             $modDetail->permintaan_temp = $modDetail->permintaandosis_pembilang . " / " . $modDetail->permintaandosis_penyebut;
                            //         } else {
                            //             $modDetail->permintaan_temp = $modDetail->permintaan_reseptur;
                            //         }
                                    
                            //         echo $this->renderPartial($this->path_view.'_rowDetail',array('modResepturDetail'=> $modDetail));
                            //     }
                            // }
                            ?>
                        </tbody>
                      
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'button','id'=>'btn_submit', 'onclick' => 'cekVerifikasiPJA(this)')); //formSubmit(this,event)
    ?>
    <?php if(!isset($_GET['frame'])){
        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
        array('class'=>'btn btn-default',
            'onclick'=>'return refreshForm(this);'));
    } ?>

</div>
  

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogUbah',
    'options'=>array(
        'title'=>'Ubah Jumlah',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>500,
        'height' => 350,
        'resizable'=>false,
        'close'=>"js:function(){ 
            $.fn.yiiGridView.update('daftarriwayat-v-grid');
        }",
    ),
));

?>
<iframe src="" name="iframeUbah" style="width: 100%; height: 98%;"></iframe>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
    ),
));

    echo '<div id="contentDetailResep"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailPenjualan',
    'options'=>array(
        'title'=>'Detail Penjulan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'height' => 500,
        'resizable'=>false,
    ),
));

?>
<iframe src="" name="iframeDetail" style="width: 100%; height:98%"></iframe>
<?php

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasienLama&id=' . $modPendaftaran->pasien_id); ?>

<script type="text/javascript">
function cekVerifikasiPJA(obj) {
    $.get('<?= $this->createUrl('cekVerifikasiPJA') ?>', {
        pendaftaran_id:'<?= isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null ?>'
    }, function(data){
        if(data.status == 1) {
            myAlert('Tindak lanjut pasien sudah dilakukan validasi PJA');
            return false;
        } else {
            $('#rjreseptur-t-form').submit();
        }
    }, 'json');
}

function setRiwayatPasien() {
        var frameObj = document.getElementById("riwayatPasien");
        var jsframe = $("#riwayatPasien");

        jsframe.attr("src", "<?php echo $riwayatPasien; ?>");
        jsframe.parent().addClass("animation-loading");
        jsframe.on('load', function() {
            resizeIframeJs(jsframe);
            jsframe.parent().removeClass("animation-loading");
        });

        $('.accordion-inner').removeClass("animation-loading");

        //jsframe.parent().removeClass("animation-loading");        
        //$("#divRiwayatPasien").slideToggle(500);
        //});

        /*$(frameObj).attr("src","<?php //echo $riwayatPasien;
                                    ?>");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            resizeIframe(frameObj);
            $(frameObj).parent().removeClass("animation-loading");        
            $("#divRiwayatPasien").slideToggle(500);
        });*/
        return false;
    }

    $(document).ready(function () {
        setRiwayatPasien();
    });

	function viewDetailResep(idReseptur,pendaftaran_id)
	{

	$.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {idReseptur: idReseptur, pendaftaran_id: pendaftaran_id}, function(data){
			$('#contentDetailResep').html(data.result);
		}, 'json');
		$('#dialogDetailresep').dialog('open');
	}

    function cekPenjualan() {
        var notriage_pasien_id = '<?= $_GET['notriage_pasien_id'] ?>';
        var pendaftaran_id = '<?= isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null ?>'
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekPenjualan'); ?>',
            data: {
                notriage_pasien_id: notriage_pasien_id,
                pendaftaran_id:pendaftaran_id
            },
            dataType: "json",
            success: function(data) {
                console.log(data)
                if(data.sukses == 1) {
                    $('#penjualanresep_id').val(data.penjualanresep_id);
                    $('.penjualan').attr('disabled', false);
                    $('.notatindakan').attr('disabled', false);
                    $('.telaah').attr('disabled', false);
                } else {
                    $('#penjualanresep_id').attr('');
                    $('.penjualan').attr('disabled', true);
                    $('.notatindakan').attr('disabled', true);
                    $('.telaah').attr('disabled', true);
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function(){
        $('.number-char').on('keypress', function(event) {
            var karakter = String.fromCharCode(event.which);

            // Regular expression untuk memeriksa apakah karakter adalah titik, koma, atau slash
            var pattern =/^[0-9.,\/]+$/;

            if (!pattern.test(karakter)) {
                event.preventDefault();
            }
        });

        cekValidasi('load');
        // cekPenjualan();
        // Notifikasi Pasien
        <?php
            if(isset($_GET['smspasien'])){
                if($_GET['smspasien']==0){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16
            insert_notifikasi(params);
        <?php
                }
            }
        ?>

    <?php if ($dokter == false) { ?>
            $("#field-paketobat :input").attr("readonly", true);
            $("#field-paketobat .add-on").remove();
            $("#field-paketobat .icon-remove").remove();
        <?php } ?>
    });

    function viewDetailResep(idReseptur, pendaftaran_id) {

        $.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {
            idReseptur: idReseptur,
            pendaftaran_id: pendaftaran_id
        }, function(data) {
            $('#contentDetailResep').html(data.result);
        }, 'json');
        $('#dialogDetailresep').dialog('open');
    }

    function buatReseptur(){
        $('.kumpulanTombol').addClass('animation-loading');
        var notriage_pasien_id = '<?= $_GET['notriage_pasien_id'] ?>';
        var pendaftaran_id = '<?= isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('buatPenjualanResepRS'); ?>',
            data: {
                notriage_pasien_id: notriage_pasien_id,
                pendaftaran_id:pendaftaran_id
            },
            dataType: "json",
            success: function(data) {
                if(data.sukses == 1) {
                    myAlert('Data berhasil dilakukan penjualan');
                    $('#penjualanresep_id').val(data.penjualanresep_id);
                    $('.penjualan').attr('disabled', false);
                    $('.notatindakan').attr('disabled', false);
                    $('.telaah').attr('disabled', false);
                    $.fn.yiiGridView.update('daftarriwayat-v-grid');
                    $.fn.yiiGridView.update('penjualanresepriwayat-v-grid');
                    $('#btn_reseptur').attr('disabled', true);
                } else if(data.sukses == 2) {
                    myAlert('Data gagal dilakukan penjualan');
                    $('#penjualanresep_id').val('');
                }else {
                    myAlert('Data gagal dilakukan penjualan');
                    $('#penjualanresep_id').val('');
                }
                $('.kumpulanTombol').removeClass('animation-loading');
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function printNotaPenjualan(caraPrint) {
        var penjualanresep_id = $('#penjualanresep_id').val();
        window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printNotaPenjualan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printTelaah(caraPrint) {
        var penjualanresep_id = $('#penjualanresep_id').val();
        window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printTelaah'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printetiketRanap(caraPrint) {
        var penjualanresep_id =  $('#penjualanresep_id').val();
        window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printTindakan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printEtiketTriage(pengambilanobat_triage_id) {
        window.open('<?php echo $this->createUrl('printEtiketTriage'); ?>&pengambilanobat_triage_id=' + pengambilanobat_triage_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>
<?php // $this->renderPartial($this->path_view.'_jsFunctions', array('modReseptur'=>$modReseptur,'modReseptur'=>$modReseptur)); ?>
