<?php
if (isset($_GET['sukses']))
    Yii::app()->user->setFlash('success', "Data tindakan berhasil disimpan!");
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tindakanpelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    //        'focus'=>'#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modTindakan); ?>
<?php
$kelaspelayanan_id = (!empty($modPasienAdmisi->kelaspelayanan_id) ? $modPasienAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id);
$carabayar_id = (!empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id);
$penjamin_id = (!empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
$instalasi_id = (!empty($modPasienAdmisi->ruangan->instalasi_id) ? $modPasienAdmisi->ruangan->instalasi_id : $modPendaftaran->ruangan->instalasi_id);
$instalasi_id = (isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : $instalasi_id); //ditimpa
//            $ruangan_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan_id : $modPendaftaran->ruangan_id);
?>
<div style="display:none;">
    <?php echo Chtml::textField('pendaftaran_id', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('pasienadmisi_id', $modPasienAdmisi->pasienadmisi_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('kelaspelayanan_id', $kelaspelayanan_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('carabayar_id', $carabayar_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('penjamin_id', $penjamin_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('instalasi_id', $instalasi_id, array('readonly' => true)); ?>
    <?php // echo Chtml::textField('ruangan_id',$ruangan_id,array('readonly'=>true)); 
    ?>
</div>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'table-riwayattindakan',
    'content' => array(
        'content-riwayattindakan' => array(
            'header' => '<b>Riwayat Tindakan</b>',
            'isi' => $this->renderPartial('billingKasir.views.tindakanRawatJalan._tableRiwayatTindakan', array(
                'format' => $format,
                'modRiwayatTindakans' => $modRiwayatTindakans,
            ), true),
            'active' => true,
        ),
    ),
)); ?>
<div class="control-group">
    <?php echo CHtml::label('Tipe Paket', 'tipepaket_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo Chtml::dropDownList('tipepaket_id', Params::TIPEPAKET_ID_NONPAKET, (CHtml::listData($modTindakan->getTipePakets(), 'tipepaket_id', 'tipepaket_nama')), array('class' => 'span3', 'onchange' => 'setTabelTindakanReset();')); ?>
    </div>
</div>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Tabel Tindakan
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <table id="table_tindakanpelayanan" class="table table-condensed table-striped">
                <thead>
                    <th>No.</th>
                    <th>Poliklinik / Ruangan<br>Tanggal Tindakan</th>
                    <th>Kategori Tindakan</th>
                    <th width="40%">Uraian Tindakan</th>
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
                    //                if (count((array)$dataTindakans) > 0){
                    //                    foreach($dataTindakans AS $ii => $tindakan){
                    //                         echo $this->renderPartial("_rowTindakan",array('form'=>$form,'modTindakan'=>$tindakan), true); 
                    //                    }
                    //                }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:center;"><?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);')); ?></td>
                        <td colspan="7" style="text-align:right;"><b>Total Nominal Tarif :</b></td>
                        <td><?php echo CHtml::textField('totaltariftindakan', 0, array('readonly' => true, 'class' => 'integer', 'style' => 'width:100px;')); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

        </div>

        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('form' => $form, 'modTindakan' => $modTindakan)); ?>
        <?php $this->endWidget(); ?>

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
                    'height' => 380,
                    'resizable' => false,
                ),
            )
        );
        echo CHtml::hiddenField('tindakan_untuk', 0, array('readonly' => true));
        $modDaftarTindakan = new BKTariftindakanperdaruanganV('search');
        $modDaftarTindakan->unsetAttributes();
        $modDaftarTindakan->ruangan_id = $modPendaftaran->ruangan_id; //default
        $modDaftarTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id; //default
        $modDaftarTindakan->penjamin_id = $modPendaftaran->penjamin_id; //default
        $modDaftarTindakan->daftartindakan_akomodasi = true;
        if (isset($_GET['BKTariftindakanperdaruanganV'])) {
            $modDaftarTindakan->attributes = $_GET['BKTariftindakanperdaruanganV'];
            $modDaftarTindakan->tipepaket_id = $_GET['BKTariftindakanperdaruanganV']['tipepaket_id'];
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
                        'filter' => false,
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'name' => 'persencyto_tind',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->persencyto_tind)',
                        'filter' => false,
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
                    'title' => 'Dokter / Paramedis',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 860,
                    'height' => 380,
                    'resizable' => false,
                ),
            )
        );
        echo CHtml::hiddenField('dokter_untuk', "", array('readonly' => true));
        $modDokter = new BKDokterV('search');
        $modDokter->unsetAttributes();
        $modDokter->ruangan_id = $modPendaftaran->ruangan_id; //default
        if (isset($_GET['BKDokterV'])) {
            $modDokter->attributes = $_GET['BKDokterV'];
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
    </div>
</div>