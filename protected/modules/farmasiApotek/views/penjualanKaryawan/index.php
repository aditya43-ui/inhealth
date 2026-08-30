<?php $linkHalaman = CustomFunction::getUrlByMenuID(966); ?>
<style>
    .yellow td {
        background-color: yellow !important;
    }

    .integer-decimal {
        text-align: right;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <strong>Penjualan Obat Karyawan</strong>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Penjualan Obat Karyawan',
        );
        ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penjualanresep-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#FAPendaftaranT_instalasi_id',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            if ($_GET['sukses'] == 1) {
                Yii::app()->user->setFlash("success", "Transaksi Penjualan Obat Karyawan berhasil disimpan!");
            }
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <fieldset id="form-antrian" hidden>
            <div class="control-group">
                <?php echo CHtml::label('No. Antrian', 'noantrian', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modPenjualan, 'antrianfarmasi_id', array('class' => 'antrianfarmasiId')); ?>
                    <?php echo CHtml::textField('racikan_singkatan', ((empty($modAntrian->racikan_id) ? "" : $modAntrian->racikan->racikan_singkatan)), array('readonly' => true, 'class' => 'span1', 'style' => 'text-align:right;float: left;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="span3" style="float: left;">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modAntrian,
                            'attribute' => 'noantrian',
                            'tombolDialog' => array('idDialog' => 'dialog-pilihantrian'),
                            'htmlOptions' => array(
                                'value' => $modAntrian->noantrian,
                                'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'style' => 'float:left;',
                                'onblur' => 'if($(this).val() === "") {$(' . CHtml::activeId($modPenjualan, 'antrianfarmasi_id') . ').val(""); $("#racikan_singkatan").val("");}',
                                'placeholder' => 'Klik icon =>'
                            )
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset id="form-info">
            <?php $this->renderPartial($this->path_view_karyawan . '_formInfoPegawai', array('form' => $form, 'modInfoPegawai' => $modInfoPegawai, 'modInfoDokter' => $modInfoDokter, 'modPenjualan' => $modPenjualan)); ?>
        </fieldset>
        <div class="row" style="margin: 17px -15px;">
            <div class="col-sm-6">
                <fieldset id="form-dataresep">
                    <?php $this->renderPartial($this->path_view_karyawan . '_formDataResep', array('form' => $form, 'modPenjualan' => $modPenjualan, 'modReseptur' => $modReseptur)); ?>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <?php
                if (!isset($_GET['sukses'])) { //RND-5894
                    $this->renderPartial($this->path_view . '_formInputObat', array('form' => $form, 'racikan' => $racikan, 'racikanDetail' => $racikanDetail, 'nonRacikan' => $nonRacikan));
                }
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Penjualan Obat Karyawan</strong></div>
            </div>
            <div class="panel-body">
                <div class="block-tabel" style="overflow: auto;">
                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                        <thead>
                            <tr>
                                <th>Resep</th>
                                <th>R ke</th>
                                <th>Kode / Nama Obat</th>
                                <th>Jumlah Stok</th>
                                <th>Jumlah Permintaan</th>
								<th>Sediaan</th>
                                <th>Jumlah</th>
                                <th>Biaya Adm Racikan (Rp)</th>
                                <th>Harga Satuan (Rp)</th>
                                <th>Total Embalase (Rp)</th>
                                <th>Biaya Administrasi (Rp)</th>
                                <th>Total Biaya Administrasi (Rp)</th>
                                <th hidden>Keringanan (%)</th>
                                <th hidden>Keringanan (Rp)</th>
                                <th hidden>PPN (%)</th>
                                <th hidden>PPN (Rp)</th>
                                <th>Sub Total (Rp)</th>
                                <th>Frekuensi</th>
                                <th>Etiket</th>
                                <th>Keterangan</th>
                                <th>Batal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count((array)$modObatAlkesPasien) > 0) {
                                $ObatAPI = new ObatAPI;
                                foreach ($modObatAlkesPasien as $i => $modDetail) {
                                    $modDetail->ppnpersen = $modDetail->persenppnjual;
                                    $modDetail->qty_oa = number_format($modDetail->qty_oa, "2", ",", "");
                                    $dataObatApi = $ObatAPI->searchStokByDepo($modDetail->obatalkes->sumberdana_id, $modDetail->obatalkes->kodeobat_inventory);
                    				$modDetail->jmlstok = isset($dataObatApi['jmlStok']) ? $dataObatApi['jmlStok'] : 0 ;
                                    $modDetail->hargasatuan_oa = MyFormatter::formatNumberForPrint($modDetail->hargasatuan_oa, 2);
                                    $modDetail->hargajual_oa = MyFormatter::formatNumberForPrint($modDetail->hargajual_oa, 2);
                                    echo $this->renderPartial($this->path_view_karyawan . '_rowDetail', array('modObatAlkesPasien' => $modDetail, 'modReseptur' =>$modReseptur));
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12" style="text-align: right;"><strong>Total</strong></td>
                                <td>
                                    <?php echo Chtml::textField('totaljual', 0, array('class' => 'span2 integer-decimal', 'readonly' => 'true')); ?>
                                </td>
                                <td colspan="4">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-12">
                        <?php //echo $form->hiddenField($modPenjualan, 'totharganetto',array('class'=>'integer2', 'readonly'=>'true')); 
                        ?>
                        <?php echo $form->hiddenField($modPenjualan, 'totaltarifservice', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'biayaadministrasi', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'biayakonseling', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'pembulatanharga', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'jasadokterresep', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php //echo $form->hiddenField($modPenjualan, 'discount',array('class'=>'integer2', 'readonly'=>'true')); 
                        ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidiasuransi', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidipemerintah', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidirs', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'iurbiaya', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modReseptur, 'admracikan', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modReseptur, 'administrasi', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        
                    </div>
                    <div class="clear"></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8"><?php //echo $form->textFieldRow($modPenjualan, 'totalhargajual',array('class'=>'span2 integer2', 'readonly'=>'true'));
                                            ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Harga Jual', 'total_harga_netto', array('class' => 'control-label')); ?>
                            <div class="controls" style="padding-right: 10px">
                                <?php echo $form->textField($modPenjualan, 'totharganetto', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                            </div>
                            <?php echo CHtml::label('Keringanan Penjualan Karyawan', 'diskonkaryawan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPenjualan, 'discount', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total PPN Jual', 'totalppn', array('class' => 'control-label')); ?>
                            <div class="controls" style="padding-right: 10px">
                                <?php echo $form->textField($modPenjualan, 'totalppn', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                            </div>
                            <?php echo CHtml::label('Jasa Pelayanan Farmasi', 'jasapelayanan_farmasi', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPenjualan, 'jasapelayanan_farmasi', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Biaya R', 'admracikan', array('class' => 'control-label')); ?>
                            <div class="controls" style="padding-right: 10px">
                                <?php echo $form->textField($konfigFarmasi, 'admracikan', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                            </div>
                            <?php echo CHtml::label('Keterangan Jenis Penjamin', 'keterangancarabayar', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPenjualan, 'keterangancarabayar', array('class' => 'span3', 'readonly' => false)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keseluruhan', 'totalkeseluruhan', array('class' => 'control-label')); ?>
                            <div class="controls" style="padding-right: 10px">
                                <?php echo $form->textField($modPenjualan, 'totalhargajual', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disableSave = false;
            $disableSave = ((!empty($_GET['penjualanresep_id'])) ? true : (($sukses > 0) ? true : false));
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekObat();', 'onkeypress' => 'cekObat();', 'disabled' => $disableSave)); //formSubmit(this,event)
            //  jika tanpa cek obat
            /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
								array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
             *
             */
            ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo '&nbsp;';
            echo CHtml::Link('<i class="entypo-print"></i> Print E-Tiket Non Racikan', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printetiket(\'PRINT\')', 'disabled' => isset($_GET['sukses']) ? false : true));
            echo '&nbsp;';
            echo CHtml::Link('<i class="entypo-print"></i> Print E-Tiket Racikan', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printetiketRacikan(\'PRINT\')', 'disabled' => isset($_GET['sukses']) ? false : true));
            ?>
            <?php
            $content = $this->renderPartial('tips/tipsPenjualanKaryawan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/pembayaranPenjualanApotek/index", array("penjualanresep_id" => $modPenjualan->penjualanresep_id, "pasien_id" => $modPenjualan->pasien_id, "frame" => true, 'pelayanan' => "RO")), array("target" => "iframePembayaran", 'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => isset($_GET['sukses']) ? false : true));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-pilihantrian',
            'options' => array(
                'title' => 'Daftar Antrian',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 900,
                'minHeight' => 400,
                'resizable' => false,
            ),
        ));
        ?>
        <div class="dialog-content">
            <?php
            if (!isset($_GET['sukses'])) { //RND-5894
                $modKarcisTerakhir = new FAAntrianFarmasiT('search');
                $modKarcisTerakhir->unsetAttributes();
                if (isset($_GET['FAAntrianFarmasiT'])) {
                    $modKarcisTerakhir->attributes = $_GET['FAAntrianFarmasiT'];
                }
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'anantrianfarmasi-t-grid',
                    'dataProvider' => $modKarcisTerakhir->searchDialogKarcis(),
                    'filter' => $modKarcisTerakhir,
                    'template' => "{summary}\n{pager}\n{items}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Pilih',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Karcis","class"=>"btn_small",
											"id"=>"pilihkarcis",
											"onClick"=>"$(\"#' . CHtml::activeId($modPenjualan, 'antrianfarmasi_id') . '\").val(\"$data->antrianfarmasi_id\");
														$(\"#' . CHtml::activeId($modAntrian, 'noantrian') . '\").val(\"$data->noantrian\");
														$(\"#racikan_singkatan\").val(\"$data->RacikanSingkatan\");
														$(\"#dialog-pilihantrian\").dialog(\"close\");
														return false;"
											))'
                        ),
                        array(
                            'name' => 'tglambilantrian',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglambilantrian)',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'racikan_id',
                            'type' => 'raw',
                            'value' => '$data->racikan->racikan_nama." (".$data->racikan->racikan_singkatan.")"',
                            'filter' => CHtml::dropDownList('FAAntrianFarmasiT[racikan_id]', $modKarcisTerakhir->racikan_id, $modKarcisTerakhir->getListRacikans(), array('empty' => '--Pilih--')),
                        ),
                        'noantrian',
                        array(
                            'name' => 'panggilantrian',
                            'filter' => CHtml::dropDownList('FAAntrianFarmasiT[panggilantrian]', $modKarcisTerakhir->panggilantrian, array(0 => 'Belum', 1 => 'Sudah'), array('empty' => '--Pilih--')),
                            'type' => 'raw',
                            'value' => '($data->panggilantrian) ? "Sudah" : "Belum"',
                        ),
                        array(
                            'name' => 'antrianlewat',
                            'filter' => CHtml::dropDownList('FAAntrianFarmasiT[panggilantrian]', $modKarcisTerakhir->panggilantrian, array(0 => 'Tidak', 1 => 'Ya'), array('empty' => '--Pilih--')),
                            'type' => 'raw',
                            'value' => '($data->antrianlewat) ? "Ya" : "Tidak"',
                        ),
                        array(
                            'header' => 'Print Karcis',
                            'filter' => false,
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"entypo-print\"></i>","javascript:void(0);",
												array(
													  "onclick"=>"printKarcisFarmasi($data->antrianfarmasi_id,\"PRINT\")",
													  "rel"=>"tooltip",
													  "title"=>"Klik untuk Membatalkan Pembayaran",
												))',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;'
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
            } ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogBayarKarcis',
            'options' => array(
                'title' => 'Pembayaran Tagihan Pasien',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 1000,
                'zIndex' => 1001,
                'height' => 500,
                'resizable' => true,
            ),
        ));
        ?>
        <iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPenjualan' => $modPenjualan, 'modReseptur' => $modReseptur, 'konfigFarmasi' => $konfigFarmasi)); ?>
        <?php $this->renderPartial($this->path_view_karyawan . '_jsFunctions', array('modPenjualan' => $modPenjualan, 'modReseptur' => $modReseptur, 'konfigFarmasi' => $konfigFarmasi)); ?>
    </div>
</div>