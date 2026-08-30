<?php
$this->breadcrumbs = array(
    'Informasi Pegawai' => Yii::app()->request->getUrlReferrer(),
    'Create',
);
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-history"></i> Informasi <b>Riwayat Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('readonly' => true, 'id' => 'NIP')); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                                <?php echo $form->textField($model, 'nama_pegawai', array('readonly' => true, 'id' => 'pegawai_id')); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('readonly' => true, 'id' => 'tempatlahir_pegawai')); ?>
                        <?php echo $form->textFieldRow($model, 'tgl_lahirpegawai', array('readonly' => true, 'id' => 'tgl_lahirpegawai')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'jeniskelamin', array('readonly' => true, 'id' => 'jeniskelamin')); ?>
                        <?php echo $form->textFieldRow($model, 'statusperkawinan', array('readonly' => true, 'id' => 'statusperkawinan')); ?>
                        <?php echo $form->textFieldRow($model, 'jabatan_id', array('readonly' => true, 'id' => 'jabatan')); ?>
                        <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('readonly' => true, 'id' => 'alamat_pegawai')); ?>
                        <?php
                        if (!empty($model->photopegawai)) {
                            echo CHtml::image(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                        } else {
                            echo CHtml::image(Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php
                $pegawai = $model->pegawai_id;
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'data-riwayat-pegawai',
                    'content' => array(
                        'content-datariwayatpegawai' => array(
                            'header' => '<b>Riwayat Pribadi</b>',
                            //  RND-8331    'isi'=>$this->renderPartial('_riwayatPegawai',array(),true),
                            'isi' => $this->renderPartial($this->path_view . '_tabMenuRiwayatPribadi', array('pegawai' => $pegawai), true),
                            'active' => false,
                        ),
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-12">
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'data-riwayat-pekerjaan',
                    'content' => array(
                        'content-datariwayatpekerjaan' => array(
                            'header' => '<b>Riwayat Pekerjaan</b>',
                            //  RND-8362	'isi'=>$this->renderPartial('_riwayatPekerjaanPegawai',array(),true),
                            'isi' => $this->renderPartial($this->path_view . '_tabMenuRiwayatPekerjaan', array('pegawai' => $pegawai), true),
                            'active' => false,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <?php echo $this->renderPartial($this->path_view . '_riwayatPenggajian', array(), true); ?>
        <div class="form-actions">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    $this->widget('bootstrap.widgets.BootButtonGroup', array(
                        'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                        'buttons' => array(
                            array('label' => 'Print', 'icon' => 'entypo-print', 'url' => '#', 'htmlOptions' => array('onclick' => 'print(\'PRINT\')')),
                            array('label' => '', 'items' => array(
                                array('label' => 'PDF', 'icon' => 'icon-book', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'PDF\')')),
                                array('label' => 'EXCEL', 'icon' => 'icon-pdf', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'EXCEL\')')),
                                array('label' => 'PRINT', 'icon' => 'entypo-print', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'PRINT\')')),
                            )),
                        ),
                    ));
                    ?>
                    <?php
                    $content = $this->renderPartial('kepegawaian.views.tips/master', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintRiwayat&id=' . $model->pegawai_id);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    ViewRiwayatPenggajian();
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new PegawaiM;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "$(\"#NIP\").val(\"$data->nomorindukpegawai\");
                                                      $(\"#pegawai_id\").val(\"$data->pegawai_id\");
                                                      $(\"#namapegawai\").val(\"$data->nama_pegawai\");
                                                      $(\"#tempatlahir_pegawai\").val(\"$data->tempatlahir_pegawai\");
                                                      $(\"#tgl_lahirpegawai\").val(\"$data->tgl_lahirpegawai\");
                                                      $(\"#jeniskelamin\").val(\"$data->jeniskelamin\");
                                                      $(\"#statusperkawinan\").val(\"$data->statusperkawinan\");
                                                      $(\"#jabatan\").val(\"$data->jabatan_id\");
                                                      $(\"#alamat_pegawai\").val(\"$data->alamat_pegawai\");
                                                      $(\"#dialogPegawai\").dialog(\"close\");    
                                            "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'jeniskelamin',
        'statusperkawinan',
        array(
            'header' => 'Jabatan',
            'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "")',
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
$urlGetPangkat = $this->createUrl('PegawaiM/GetPangkat');
$urlGetTahun = $this->createUrl('GetTahun');
$urlGetPenggajian = $this->createUrl('PegawaiM/GetPenggajian');
$js = <<< JS
    $(document).ready(function() {
          $(".btn-primary").click(function(){
            if (!$("#pegawai_id").val()) {
                myAlert("Anda belum memilih pegawai");
                return false;
            } else {
                return true;
            }
          });
          $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
          });
    });
// ========================== Script pendidikan pegawai ===================================   
    function tambahPendidikanpegawai(obj) {
        $("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
        renameInputpendidikanpegawai();
    }
    function tambahPendidikanpegawaidrinput(obj) {
        $("#hapus").show();
        $("#tambah").hide();
        $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
        renameInputpendidikanpegawai();
    }
    function hapusPendidikanpegawai(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
    }
    function renameInputpendidikanpegawai(){
        nourut = 1;
        $(".keterangan").each(function(){
            $(this).parents('tr').find('[name*="KPPendidikanpegawaiR"]').each(function(){
                var input = $(this).attr('name');
                var data = input.split('KPPendidikanpegawaiR[]');
                var id = input.split('KPPendidikanpegawaiR[][');
                if (typeof data[1] === 'undefined'){} else{
                    $(this).attr('name','KPPendidikanpegawaiR['+nourut+']'+data[1]);
//                    $(this).attr('id','date_'+nourut);
                };
            });
            $(this).parents('tr').find('[id*="date"]').each(function() {
                var input = $(this).attr('id');
                var data = input.split('date-');
                    $(this).attr('id','date-'+data[1]+nourut);
                $(function() {
                    $( "#date-"+data[1]+nourut).datepicker({
                        firstDay: 7,
                        dateFormat:'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                    });
                });
                $.datepicker.setDefaults($.datepicker.regional['id']);
            });
            nourut++;
        });
    }
        function Penggajiandata()
        {
            pegawai_id = $('#pegawai_id').val();
           {
                $.post("${urlGetPenggajian}", {pegawai_id:pegawai_id,},
                function(data){
                    $("#tableRiwayatPenggajian").children("tbody").append(data.tr);
                }, "json");
            }   
        }
		function ViewRiwayatPenggajian() {
				Penggajiandata();
                $("#tableRiwayatPenggajian").slideDown(60);
		}
// ========================== Akhir script pendidikan pegawai ===================================
// ======================================== Script Kenaikan Pangkat =============================
/*
    function Pangkatdata()
        {
            pegawai_id = $('#pegawai_id').val();
            if(pegawai_id==''){
                myAlert('Anda belum memilih pegawai');
                return false;
            }else{
                $.post("${urlGetPangkat}", {pegawai_id:pegawai_id,},
                function(data){
                    $("#tableRiwayatPangkat").children("tbody").append(data.tr);
                }, "json");
            }   
        }
        function kurangiTanggal(tahun)
        {
            $.post("${urlGetTahun}", {tahun:tahun}, function(hasil){
                $("#UskenpangkatR_uskenpangkat_masakerjatahun").val(hasil.tahun);
                $("#UskenpangkatR_uskenpangkat_masakerjabulan").val(hasil.bulan);
                $("#RealisasikenpangkatR_realisasikenpangkat_masakerjath").val(hasil.tahun);
                $("#RealisasikenpangkatR_realisasiken_masakerjabln").val(hasil.bulan);
            },"json");
        }
    $('#cekRiwayatpegawai').change(function(){
            $('#divRiwayatpendidikanpegawai').slideToggle(500);
    });
*/
// ================================== Akhir Script ========================================
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>
<ul class="nav nav-tabs" id="tabmenu">
    <li class=""></li>
</ul>
<?php if (isset($_GET['tab'])) {
    Yii::app()->clientScript->registerScript('onreadyfunction', '
        $("#tabmenu").find("li[index=\'' . $_GET['tab'] . '\']").find("a").click();
        tab(' . $_GET['tab'] . ');
        ', CClientScript::POS_READY);
} ?>
<?php
$js = <<< JS
//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
JS;
Yii::app()->clientScript->registerScript('tableDiklatpegawai', $js, CClientScript::POS_READY);
?>
<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 34 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"
function palidasiForm(obj)
   {
        var berubah = $('#berubah').val();
        if(berubah=='Ya') 
        {
           if(confirm('Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?'))
               {
                    $('#url').val(obj);
                    $('#btn_simpan').click();
               }
        }      
   }
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);
?>