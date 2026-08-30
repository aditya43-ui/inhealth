<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<style>
    .table thead tr th {
        vertical-align: middle;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi Pemesanan <strong>Menu Diet Pasien</strong>
                    <?php if (!isset($_GET['sukses']) && !empty($model->pesanmenudiet_id)) { ?>
                        <span style="float:right">
                            <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('PesanmenudietT/Informasi'), array('class' => 'btn btn-green')); ?>
                        </span>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'gzpesanmenudiet-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',), //'onsubmit'=>'return requiredCheck(this);'
                    'focus' => '#' . CHtml::activeId($model, 'nama_pemesan'),
                ));

                echo CHtml::hiddenField("cek_tambah_menu", '', array('readonly' => true));
                echo CHtml::hiddenField("hapusdetaildiet_id", '');
                ?>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-body" id="form-cari-pasien">
                        <?php $this->renderPartial($this->path_view . '._dataForm', array('form' => $form, 'model' => $model)); ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Data Pasien Baru</div>
                    </div>
                    <div class="panel-body" style="overflow-x:scroll">
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view . '._dataPasienBaru', array('modPasienPulang' => $modPasienPulang, 'form' => $form, 'model' => $model)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Detail Pemesanan Menu Diet Pasien</div>
                    </div>
                    <div class="panel-body" id="detail_form_pesan_diet">
                        <?php $this->renderPartial($this->path_view . '._detailPemesananPasien', array('form' => $form, 'model' => $model, 'modPasienPulang' => $modPasienPulang, 'modBahan' => $modBahan)); ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Pemesanan <strong>Menu Diet Pasien</strong></div>
                    </div>
                    <div class="panel-body table-responsive">
                        <!--div class="block-tabel"-->
                        <table class="table table-bordered table-striped table-condensed" id="tableMenuDiet">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></th>
                                    <th>Instalasi/<br />Ruangan</th>
                                    <th>No. Pendaftaran</th>
                                    <th>No. Rekam Medik</th>
                                    <th>Nama Pasien</th>
                                    <th>Jenis Kelamin/ <br />Umur</th>
                                    <!-- <th>Bentuk Diet</th> -->
                                    <th>Jenis Diet</th>
                                    <th>Menu Diet</th>
                                    <th>Jenis Waktu</th>
                                    <th hidden>Alat Makanan</th>
                                    <th>Jumlah</th>
                                    <!--<th>Satuan</th>-->
                                    <th hidden>Detail</th>
                                    <th colspan="2" style="text-align:center;">Aksi</th>
                                </tr>
                                <tr>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!--/div-->
                        <table class="hide" id='tabelpesandiet-hapus'>
                            <tbody>
                            </tbody>
                        </table>

                        <table class="hide" id='tabelpesandiet-det-hapus'>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    if (isset($_GET['sukses'])) {
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger disabled', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)'));
                    } else {
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'button', 'onclick' => 'cekForm();', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'id' => 'btn_data_submit'));
                    }
                    ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl('index'),
                        array(
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        )
                    );
                    ?>
                    <?php $content = $this->renderPartial('gizi.views.tips.transaksi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));  ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->renderPartial($this->path_view . '_dialog', array('model' => $model)); ?>
<?php $this->renderPartial($this->path_view . '_dialogUbahMenu', array('model' => $model)); ?>
<?php
//ruangan daftar pasien
if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
    $nama = "<span id='namaRuangan'></span>";
} else {
    $nama = '-' . Yii::app()->user->getState('ruangan_nama') . '-';
}
?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Daftar Pasien ' . $nama,
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 700,
        'resizable' => false,
    ),
));


$modKunjungan = new GZInfopasienmasukkamarV('searchRI');

if (isset($_GET['GZInfopasienmasukkamarV'])) {
    $modKunjungan->attributes = $_GET['GZInfopasienmasukkamarV'];
    $modKunjungan->default = isset($_GET['GZInfopasienmasukkamarV']['default']) ? $_GET['GZInfopasienmasukkamarV']['default'] : null;
}

$cri = new CDbCriteria;
$empty = array('empty' => '-- Pilih --');
if (!empty($modKunjungan->carabayar_id)) {
    $cri->addCondition("carabayar_id = '" . $modKunjungan->carabayar_id . "' ");
    $empty = array();
} else {
    $modKunjungan->penjamin_id = null;
}
$cri->addCondition("penjamin_aktif = TRUE ");
$cri->order = 'penjamin_nama ASC';
$penjamin = PenjaminpasienM::model()->findAll($cri);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzinfokunjunganri-v-grid',
    'dataProvider' => $modKunjungan->searchRI(),
    'filter' => $modKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
				"id" => "selectPasien",
				"onClick" => "
					$(\"#pasien_id\").val($data->pasien_id);
					$(\"#pendaftaran_id\").val($data->pendaftaran_id);
					$(\"#pasienadmisi_id\").val($data->pasienadmisi_id);
					$(\"#kelaspelayanan_id\").val($data->kelaspelayanan_id);
					$(\"#penjamin_id\").val($data->penjamin_id);
					$(\'#namaPasien\').val(\'$data->nama_pasien\');
					$(\"#dialogPasien\").dialog(\"close\");
//                                dialogMenuPasien($data->pendaftaran_id);
					refreshDialogMenuDiet();
				"))',
            'filter' => CHtml::activeHiddenField($modKunjungan, 'kelaspelayanan_id'),
        ),
        array(
            'header' => 'No Pendaftaran',
            'name' => 'no_pendaftaran',
            'filter' => Chtml::activeTextField($modKunjungan, 'no_pendaftaran', array('class' => 'angkahuruf-only'))
        ),
        array(
            'header' => 'No Rekam Medik',
            'name' => 'no_rekam_medik',
            'filter' => Chtml::activeTextField($modKunjungan, 'no_rekam_medik', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'filter' => Chtml::activeTextField($modKunjungan, 'nama_pasien', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Umur',
            'name' => 'umur',
            'filter' => Chtml::activeTextField($modKunjungan, 'umur', array('class' => 'angkahuruf-only'))
        ),
        array(
            'name' => 'jeniskelamin',
            'filter' => CHtml::dropDownList('GZInfopasienmasukkamarV[jeniskelamin]', $modKunjungan->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),
        array(
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
            'filter' => Chtml::activeDropDownList($modKunjungan, 'penjamin_id', Chtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), $empty),
        ),
        /* array(
            'name'=>'ruangan_id',
            'filter'=> CHtml::activeHiddenField($modKunjungan, 'ruangan_id', array('class'=>'namaRuangan')).CHtml::dropDownList('GZInfopasienmasukkamarV[ruangan_id]',$modKunjungan->ruangan_id,CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'--Pilih--','disabled'=>TRUE)),            
            'value'=>'$data->ruangan_nama'
        ),*/
        array(
            'header' => 'No Kamar',
            'name' => 'kamarruangan_nokamar',
            'filter' => Chtml::activeTextField($modKunjungan, 'kamarruangan_nokamar', array('class' => 'angkahuruf-only'))
        ),
        array(
            'header' => 'No Bed',
            'name' => 'kamarruangan_nobed',
            'filter' => Chtml::activeTextField($modKunjungan, 'kamarruangan_nobed', array('class' => 'angkahuruf-only'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".angkahuruf-only").keyup(function() {
            setAngkaHurufsOnly(this);
        });
        $(".numbers-only").keyup(function() {
            setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>
<?php
$instalasi_id = CHtml::activeId($model, 'instalasi_id');
$ruangan_id = CHtml::activeId($model, 'ruangan_id');
$totalPesan = CHtml::activeId($model, 'totalpesan_org');
$bahandiet_id = CHtml::activeId($model, 'bahandiet_id');
$jenisdiet_id = CHtml::activeId($model, 'jenisdiet_id');
$namaPemesan = CHtml::activeId($model, 'nama_pemesan');
$url = Yii::app()->createUrl('gizi/pesanmenudietpasienT/getMenuDietDetail');
$jsx = <<< JS
    
JS;
Yii::app()->clientScript->registerScript('head', $jsx, CClientScript::POS_HEAD);
?>

<?php Yii::app()->clientScript->registerScript('submit', '
    $.fn.yiiGridView.update("gzinfokunjunganri-v-grid", {
		//data: "GZInfokunjunganriV[ruangan_id]=0"
                data: "GZInfopasienmasukkamarV[ruangan_id]=0"                
	});
    
    
', CClientScript::POS_READY); ?>

<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modBahan' => $modBahan)) ?>
<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien '.Yii::app()->user->getState('ruangan_nama'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new InfokunjunganrdV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if(isset($_GET['InfokunjunganrdV'])) {
        $modDialogKunjungan->attributes = $_GET['InfokunjunganrdV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchDialogKunjungan(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            $(\"#pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#GZPendaftaranT_nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    'no_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=> false,
                    ),
                    'no_rekam_medik',
                    array(
                        'name'=>'nama_pasien',
                        'value'=>'$data->namadepan.$data->nama_pasien',
                    ), 
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> CHtml::dropDownList('InfokunjunganrdV[jeniskelamin]',$modDialogKunjungan->jeniskelamin,LookupM::model()->getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                    ),
                    // 'instalasi_nama',
                    // 'ruangan_nama',
                    array(
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=> CHtml::dropDownList('InfokunjunganrdV[carabayar_id]',$modDialogKunjungan->carabayar_id,CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --')),
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>