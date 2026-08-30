<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchInfoKunjungan',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
$format = new MyFormatter();
?>

<style>
    table {
        margin-bottom: 0;
    }

    .form-actions {
        padding: 4px;
        margin-top: 5px;
    }

    #ruangan label {
        width: 120px;
        display: inline-block;
    }

    .nav-tabs>li>a {
        display: block;
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <div class="control-group">
            <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
            <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>

        <?php
        echo $form->dropDownListRow(
            $model,
            'dokter_id',
            CHtml::listData(DokterV::model()->findAll('pegawai_aktif = true  order by nama_pegawai asc'), 'pegawai_id', 'namaLengkap'),
            array('empty' => '-- Pilih --')
        );

        echo CHtml::hiddenField('idSupplier');
        ?>

        <?php
        echo CHtml::hiddenField('filter', 'penjamin', array('disabled' => 'disabled')) .
            $form->dropDownListRow(
                $model,
                'penjamin_id',
                CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_nama'),
                array('empty' => '-- Pilih --')
            )
        ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
            $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true and revenuecenter = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array(
                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganForCheckBox', array('encode' => false, 'namaModel' => '' . get_class($model) . '')),
                    'update' => '#ruangan', //selector to update
                ),
            )) . '
                    <div class="control-group">
                        <label class="control-label">Ruangan</label>
                        <div id="ruangan" class="controls">
                            <label>Data tidak ditemukan.</label>
                        </div>
                    </dir>';
        ?>
    </div>

    <!--<div class="col-sm-6">-->
    <?php
    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    //     'id' => 'dokter',
    //     'slide' => true,
    //     //                                    'parent'=>false,
    //     //                                    'disabled'=>true,
    //     //                                    'accordion'=>false, //default
    //     'content' => array(
    //         'content3' => array(
    //             'header' => 'Berdasarkan Dokter Pemeriksa',
    //             'isi' => $form->dropDownListRow(
    //                 $model,
    //                 'dokter_id',
    //                 CHtml::listData(DokterV::model()->findAll('pegawai_aktif = true  order by nama_pegawai asc'), 'pegawai_id', 'namaLengkap'),
    //                 array('empty' => '-- Pilih --')
    //             ),
    //             'active' => true,
    //         ),
    //     ),
    //     'htmlOptions' => array('class' => 'aw',)
    // ));

    // echo CHtml::hiddenField('idSupplier');
    ?>

    <?php
    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    //     'id' => 'big',
    //     'slide' => true,
    //     'content' => array(
    //         'content2' => array(
    //             'header' => 'Berdasarkan Penjamin',
    //             'isi' => CHtml::hiddenField('filter', 'penjamin', array('disabled' => 'disabled')) .
    //                 $form->dropDownListRow(
    //                     $model,
    //                     'penjamin_id',
    //                     CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_nama'),
    //                     array('empty' => '-- Pilih --')
    //                 ),
    //             'active' => true
    //         ),
    //     ),
    //     //                                    'htmlOptions'=>array('class'=>'aw',)
    // ));
    ?>
    <!--</div>-->
    <!--<div class="col-sm-6">-->
    <?php
    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    //     'id' => 'big',
    //     'slide' => true,
    //     'content' => array(
    //         'content2' => array(
    //             'header' => 'Berdasarkan Instalasi dan Ruangan',
    //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
    //                 $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true and revenuecenter = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array(
    //                     'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
    //                     'ajax' => array(
    //                         'type' => 'POST',
    //                         'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganForCheckBox', array('encode' => false, 'namaModel' => '' . get_class($model) . '')),
    //                         'update' => '#ruangan', //selector to update
    //                     ),
    //                 )) . '
    //                                 <div class="control-group">
    //                                     <label class="control-label">Ruangan</label>
    //                                     <div id="ruangan" class="controls">
    //                                         <label>Data tidak ditemukan.</label>
    //                                     </div>
    //                                 </dir>',
    //             'active' => true
    //         ),
    //     ),
    //     //                                    'htmlOptions'=>array('class'=>'aw',)
    // ));
    ?>
    <!--</div>-->
</div>

<div class="clear"></div>

<div class="col-sm-12">
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        )
            . " " . CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
            );
        ?>
    </div>
</div>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('idPendaftaran' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>

<?php
//Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>

<?php
/**
 * Dialog untuk nama Supplier
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokter = new PPDokterpegawaiV;
if (isset($_GET['PPDokterpegawaiV'])) {
    $modDokter->attributes = $_GET['PPDokterpegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modDokter->search(),
    'filter' => $modDokter,
    'template' => "{pager}{summary}\n{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idDokter\").val(\"$data->pegawai_id\");
                                                      $(\"#dokternama\").val(\"$data->nama_pegawai\");
                                                      $(\"#dialogDokter\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'filter' => false,
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
        ),
        array(
            'header' => 'Alamat',
            'name' => 'alamat_pegawai',
            'value' => '$data->alamat_pegawai',
        ),
        array(
            'header' => 'Tempat,' . "<br>" . 'Tanggal Lahir',
            'type' => 'raw',
            'name' => 'tempatlahir_pegawai',
            'value' => '$data->tempatlahir_pegawai.","."<br>".$data->tgl_lahirpegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#PPLaporanJumlahPemeriksaanDokterV_tglAwal').val(data.periodeawal_b);
            $('#PPLaporanJumlahPemeriksaanDokterV_tglAkhir').val(data.periodeakhir_b);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode', $js, CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event) {
        var namaPeriode = $('#PeriodeName').val();

        if (namaPeriode == '') {
            alert('Pilih Kategori Pencarian');
            event.preventDefault();
            $('#dtPicker3').datepicker("hide");
            return true;;
        }
    }
    $(document).ready(function() {
        jQuery('#dokternama').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#dokternama").val(ui.item.nama_pegawai);
                $("#PPLaporankunjunganbydokterV_dokter_nama").val(ui.item.nama_pegawai);
                return false;
            },
            'select': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#namadokter").val(ui.item.pegawai_id);
                return false;
            },
            'source': '/simrs/index.php?r=ActionAutoComplete/getDokter'
        });
    });
</script>
<script>
    function checkAll() {
        if ($("#checkAllRuangan").is(":checked")) {
            $('#ruangan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            })
            //        alert('Checked');
        } else {
            $('#ruangan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
    }
</script>