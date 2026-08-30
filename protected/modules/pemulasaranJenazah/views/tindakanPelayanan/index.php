<style>
    .integer,
    .integer2,
    .currency {
        text-align: right;
    }

    tr td .add-on,
    tr td label,
    tr td input {
        margin: 0 !important;
    }
</style>

<?php
$this->breadcrumbs = array(
    'Informasi Pemulasaran Jenazah' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Tindakan Pelayanan',
);

$arrMenu = array();
$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Tindakan Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'tindakan-pelayanan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>
        <?php
        $sukses = null;
        if (isset($_GET['sukses'])) {
            $sukses = $_GET['sukses'];
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo Chtml::hiddenField('kelaspelayanan_idNew', $modPasienMasukPenunjang->kelaspelayanan_id, array('readonly' => true)); ?>
        <?php
        $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        ?>

        <div class="isContent">
            <style>
                .table thead tr th {
                    vertical-align: middle;
                }
            </style>

            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-riwayat',
                'content' => array(
                    'content-detailpasien' => array(
                        'header' => '<b>Riwayat Pasien</b>',
                        'isi' => '<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
                        'active' => false,
                    ),
                ),
            )); ?>
        </div>

        <?php
        if (!empty($modViewTindakans)) {
            $this->renderPartial('_listTindakanPasien', array(
                'modTindakans' => $modViewTindakans, 'modPendaftaran' => $modPendaftaran,
                'modViewBmhp' => $modViewBmhp,
                'removeButton' => true
            ));
        }
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tindakan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div style="display:none;">
                    <?php echo Chtml::activeTextField($modPendaftaran, 'pendaftaran_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'penjamin_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'ppds_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'kelompokumur_id', array('readonly' => true)); ?>
                    <?php echo Chtml::textField('pasienmasukpenunjang_id', '', array('readonly' => true)); ?>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tipe Paket', 'tipepaket_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo Chtml::dropDownList('tipepaket_id', Params::TIPEPAKET_ID_NONPAKET, (CHtml::listData($modTindakan->getTipePakets(), 'tipepaket_id', 'tipepaket_nama')), array('class' => 'span3', 'onchange' => 'setTabelTindakanReset();')); ?>
                    </div>
                </div>
                <table id="table_tindakanpelayanan" class="table table-condensed table-bordered table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Poliklinik / Ruangan<br>Tanggal Tindakan</th>
                        <th>Kategori Tindakan</th>
                        <th width="40%">Uraian Tindakan <span class="required">*</span></th>
                        <th>Tarif Satuan</th>
                        <th>Jumlah</th>
                        <th>Satuan Tindakan</th>
                        <th>Cyto</th>
                        <th>Tarif Cyto</th>
                        <th>Jumlah Tarif</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        //                BENTROK DENGAN tr hasil javascript
                        if (count((array)$dataTindakans) > 0) {
                            foreach ($dataTindakans as $ii => $tindakan) {
                                echo $this->renderPartial("_rowTindakan", array('form' => $form, 'modTindakan' => $tindakan), true);
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align:center;"></td>
                            <td colspan="7" style="text-align:right;"><b>Total Nominal Tarif :</b></td>
                            <td><?php echo CHtml::textField('totaltariftindakan', 0, array('readonly' => true, 'class' => 'integer', 'style' => 'width:100px;')); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="clear"></div>
        <div class="row" style="margin-top: 17px;">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Pemakaian BMHP
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formPemakaianBahan', array()); ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Paket BMHP
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formPaketBmhp', array('modViewBmhp' => $modViewBmhp, 'modTindakan' => $modTindakan)); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('Index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('Index') . '";}); return false;'
                )
            ); ?>
            <?php $content = $this->renderPartial('../tips/transaksi_tindakan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('form' => $form, 'modTindakan' => $modTindakan, 'modPendaftaran' => $modPendaftaran)); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div style="display: none;">
    <?php
    //hanya untuk memanggil asset dari jquery date
    $this->widget('MyDateTimePicker', array(
        'name' => 'untukmemanggilassetjs',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeyup' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_tindakan',
        'options' => array(
            'title' => 'Daftar Tindakan ' . (InstalasiM::model()->findByPk($instalasi_id)->instalasi_nama),
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 500,
            'resizable' => false,
        ),
    )
);
echo CHtml::hiddenField('tindakan_untuk', 0, array('readonly' => true));
$modDaftarTindakan = new PJTarifTindakanPerdaRuanganV('searchDialog');
$modDaftarTindakan->penjamin_id = 0;
$modDaftarTindakan->unsetAttributes();
if (isset($_GET['PJTarifTindakanPerdaRuanganV'])) {
    $modDaftarTindakan->attributes = $_GET['PJTarifTindakanPerdaRuanganV'];
    $modDaftarTindakan->tipepaket_id = $_GET['PJTarifTindakanPerdaRuanganV']['tipepaket_id'];
    $modDaftarTindakan->ruangan_id =  $_GET['PJTarifTindakanPerdaRuanganV']['ruangan_id'];
    $modDaftarTindakan->kelaspelayanan_id =  $_GET['PJTarifTindakanPerdaRuanganV']['kelaspelayanan_id'];
    $modDaftarTindakan->penjamin_id =  $_GET['PJTarifTindakanPerdaRuanganV']['penjamin_id'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'daftartindakan-grid',
        'dataProvider' => $modDaftarTindakan->searchDialog(),
        'filter' => $modDaftarTindakan,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihTindakan(\"$data->daftartindakan_id\",\"$data->daftartindakan_nama\",\"$data->kategoritindakan_nama\",\"$data->harga_tariftindakan\",\"$data->jenistarif_id\",\"$data->persencyto_tind\");
                    $(\"#dialog_tindakan\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modDaftarTindakan, 'ruangan_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'kelaspelayanan_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'penjamin_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'tipepaket_id', array('readonly' => true)),
            ),
            'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',
            array(
                'header' => 'Harga Nominal Tarif (Rp)',
                'name' => 'harga_tariftindakan',
                'type' => 'raw',
                'value' => 'MyFormatter::formatNumberForPrint($data->harga_tariftindakan)',
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'persencyto_tind',
                'type' => 'raw',
                'value' => 'MyFormatter::formatNumberForPrint($data->persencyto_tind)',
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_dokter',
        'options' => array(
            'title' => 'Dokter',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
echo CHtml::hiddenField('dokter_untuk', "", array('readonly' => true));
$modDokter = new PJDokterV('searchDialog');
$modDokter->unsetAttributes();
//$modDokter->ruangan_id = $modPendaftaran->ruangan_id; //default
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PJDokterV'])) {
    $modDokter->attributes = $_GET['PJDokterV'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'dokter-grid',
        'dataProvider' => $modDokter->searchDialog(),
        'filter' => $modDokter,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihDokter(\"$data->pegawai_id\",\"$data->NamaLengkap\");
                    $(\"#dialog_dokter\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modDokter, 'ruangan_id', array('readonly' => true)),
            ),
            'gelardepan',
            'nama_pegawai',
            'gelarbelakang_nama',
            'jeniskelamin',
            'agama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_ppds',
        'options' => array(
            'title' => 'PPDS',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
echo CHtml::hiddenField('ppds_untuk', "", array('readonly' => true));
$modPPDS= new PpdsM('searchDialog');
$modPPDS->unsetAttributes();
//$modDokter->ruangan_id = $modPendaftaran->ruangan_id; //default
$modPPDS->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PpdsM'])) {
    $modDokter->attributes = $_GET['PpdsM'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'ppds-grid',
        'dataProvider' => $modPPDS->searchDialog(),
        'filter' => $modPPDS,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihPPDS(\"$data->ppds_id\",\"$data->ppds_nama\");
                    $(\"#dialog_ppds\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modDokter, 'ruangan_id', array('readonly' => true)),
            ),
            'ppds_nama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>



<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_perawat',
        'options' => array(
            'title' => 'Paramedis',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
echo CHtml::hiddenField('perawat_untuk', "", array('readonly' => true));
$modPerawat = new PJParamedisV('searchDialogPerawat');
$modPerawat->unsetAttributes();
//$modPerawat->ruangan_id = $modPendaftaran->ruangan_id; //default
$modPerawat->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PJParamedisV'])) {
    $modPerawat->attributes = $_GET['PJParamedisV'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'perawat-grid',
        'dataProvider' => $modPerawat->searchDialogPerawat(),
        'filter' => $modPerawat,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihPerawat(\"$data->pegawai_id\",\"$data->NamaLengkap\");
                    $(\"#dialog_perawat\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modPerawat, 'ruangan_id', array('readonly' => true)),
            ),
            'gelardepan',
            'nama_pegawai',
            'gelarbelakang_nama',
            'jeniskelamin',
            'agama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Riwayat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='detailDialog' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function deleteTindakan(obj, idTindakanpelayanan) {
        window.parent.myConfirm("Apakah Anda yakin akan menghapus tindakan?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {
                    idTindakanpelayanan: idTindakanpelayanan
                }, function(data) {
                    if (data.success) {
                        $(obj).parent().parent().detach();
                        window.parent.myAlert('Data berhasil dihapus.');
                    } else {
                        window.parent.myAlert('Data Gagal dihapus');
                    }
                }, 'json');
            }
        });
    }
</script>