<style>
    .yellow td {
        background-color: yellow !important;
    }

    .integer-decimal {
        text-align: right;
    }
    /* Style untuk container dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
        width: 60px;
    }

    /* Style untuk tombol dropdown */
    .dropbtn {
        background-color: #3498db;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
    }

    /* Style untuk konten dropdown */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        top: -8px;
        right: -160px; /* Menggeser dropdown ke arah kiri */
    }

    /* Style untuk pilihan dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Style untuk pilihan dropdown saat dihover */
    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Menampilkan konten dropdown saat tombol di-hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <strong>Verifikasi Obat</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $sukses = isset($_GET['sukses']) ? true : false;
        $this->breadcrumbs = array(
            'Penjualan Resep Dari Reseptur' => array('index', 'reseptur_id' => $_GET['reseptur_id']),
            // 'Tambah',
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
                Yii::app()->user->setFlash("success", "Tansaksi berhasil disimpan!");
            }
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->hiddenField($modPenjualan, 'antrianfarmasi_id', array('class' => 'antrianfarmasiId')); ?>
        <?php /*
        <fieldset id="form-antrian">
            <div class="control-group">
                <?php echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));?>
                <div class="controls">
                    <?php echo CHtml::textField('racikan_singkatan',((empty($modAntrian->racikan_id) ? "" : $modAntrian->racikan->racikan_singkatan)),array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;float: left;', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="span3" style="float: left;">
                    <?php
                        $this->widget('MyJuiAutoComplete',array(
                            'model'=>$modAntrian,
                            'attribute'=>'noantrian',
                            'tombolDialog'=>array('idDialog'=>'dialog-pilihantrian'),
                            'htmlOptions'=>array('value'=>$modAntrian->noantrian,
                                'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2','style'=>'float:left;',
                                'onblur'=>'if($(this).val() === "") {$('.CHtml::activeId($modPenjualan, 'antrianfarmasi_id').').val(""); $("#racikan_singkatan").val("");}',
                                'placeholder'=>'Klik icon =>'
                            )
                        ));
                    ?>
                    </div>
                </div>
            </div>
        </fieldset>
 *
 */ ?>

        <div class="panel panel-primary panel-success hide">
            <div class="panel-heading">
                <div class="panel-title" id="form-infopasien"><span class="judul">Data Pasien</span></div>
            </div>
            <div class="panel-body">

                <?php $this->renderPartial('_formInfoPasien', array('form' => $form, 'modInfoRI' => $modInfoRI)); ?>
            </div>
        </div>

  

        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Obat Alkes</div>
            </div>
            <div class="panel-body overflow-x">
                <table class="items table table-striped table-condensed table-bordered dataTable" id="table-obatalkespasien">
                    <thead>
                        <tr>
                            <th width="65" colspan="2">Tambah / Hapus</th>
                            <th>Status</th>
                            <th>Option</th>
                            <th>Resep</th>
                            <th width="10">R ke</th>
                            <th>Tipe Racikan</th>
                            <th>Kode / Nama Obat Pada Resep</th>
                            <th>Jenis Obat</th>
                            <th width='180'>Kode / Nama Obat Dilayani</th>
                            <th>Jumlah Permintaan</th>
                            <th>Sediaan Racikan</th>
                            <th>Permintaan Dosis</th>
                            <th>Jumlah Stok</th>
                            <th>Jumlah Pada Resep</th>
                            <th>Jumlah Dilayani</th>
                            <th hidden>Sumber Dana</th>
                            <th>Biaya Adm Racikan (Rp)</th>
                            <th width='200'>Harga Satuan (Rp)</th>
                            <th hidden>Total Embalase (Rp)</th>
                            <th hidden>Biaya Administrasi (Rp)</th>
                            <th hidden>Total Biaya Administrasi (Rp)</th>
                            <th hidden>Keringanan (%)</th>
                            <th hidden>Keringanan (Rp)</th>
                            <th hidden>PPN (%)</th>
                            <th hidden>PPN (Rp)</th>
                            <th width='180'>Sub Total</th>
                            <th>Frekuensi</th>
                            <th>Etiket/Penggunaan</th>
                            <th>Kelas Terapi</th>
                            <th>Keterangan </th>
                            <th>Kadaluarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modPendaftaran = $modReseptur->pendaftaran;

                        //$isP = $modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && empty($modPendaftaran->pasienpulang_id) && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ;
                        //$isP = empty($modPendaftaran->pasienpulang_id);
                        $ObatAPI = new ObatAPI;
                        if (count((array)$modDetailReseptur) > 0) {
                            foreach ($modDetailReseptur as $ii => $modDetail) {
                                $dataObatApi = $ObatAPI->searchStokByStStock($modDetail->obatalkes->sumberdana_id, $modDetail->obatalkes->kodeobat_inventory);
                                $modDetail->jmlstok = isset($dataObatApi['jmlStok']) ? $dataObatApi['jmlStok'] : 0 ;
                                $modDetail->tglkadaluarsa = StokobatalkesT::getTanggalKadaluarsaStok($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                                $modDetail->tglkadalprev = StokobatalkesT::getTanggalKadaluarsaPrev($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                                $modDetail->hargasatuan_reseptur = is_numeric($modDetail->hargasatuan_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargasatuan_reseptur, 2) : $modDetail->hargasatuan_reseptur;
                                $modDetail->hargajual_reseptur = is_numeric($modDetail->hargajual_reseptur) ? MyFormatter::formatNumberForPrint($modDetail->hargajual_reseptur, 2) : $modDetail->hargajual_reseptur;
                                // $modDetail->qty_reseptur = is_numeric($modDetail->qty_reseptur) ? number_format($modDetail->qty_reseptur, 2, ",", "") : $modDetail->qty_reseptur;
                                $modDetail->qty_dilayani = is_numeric($modDetail->qty_dilayani) ? number_format($modDetail->qty_dilayani, 2, ",", "") : $modDetail->qty_dilayani;
                                $modDetail->is_obatkronis = !empty($modDetail->formulaobatkronis_id) ? true : false;
                                $modDetail->is_tanggungan = 0;
                                $modDetail->st_fornas = ($modDetail->st_fornas == true ? 1 : 0);

                                $modKronis = FormulaobatkronisM::model()->findByPk($modDetail->formulaobatkronis_id);
                                if (!empty($modKronis)) {
                                    $modDetail->jml_min = $modKronis->jumlahobat_minimal;
                                    $modDetail->jml_max = $modKronis->jumlahobat_maksimal;
                                }
                                if (!empty($modDetail->permintaandosis_penyebut) && !empty($modDetail->permintaandosis_pembilang)) {
                                    $modDetail->is_permitaandosispecahan = 1;
                                }

                                // $modDetail->hargajual_reseptur = round($modDetail->hargajual_reseptur);
                                echo $this->renderPartial('_rowDetail', array('modResepturDetail' => $modDetail, 'modObatAlkesPasien' => $modObatAlkesPasien, 'i' => $ii, 'modPendaftaran' => $modPendaftaran, 'modReseptur' => $modReseptur));
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <?php echo CHtml::link('<i class="entypo-plus"></i>NON RACIKAN', 'javascript:void(0);', array('style' => 'margin-bottom: 5px;', 'class' => 'btn btn-green span3', 'onclick' => 'tambahObatalkes(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah Obat Alkes NON RACIKAN dengan R Baru'));  ?>
                                <br>
                                <?php echo CHtml::link('<i class="entypo-plus"></i>RACIKAN', 'javascript:void(0);', array('class' => 'btn btn-blue span3', 'onclick' => 'tambahObatalkesRacikan(this,1);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah Obat Alkes RACIKAN dengan R Baru')); ?><br />
                            </td>
                            <td colspan="20">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left;"><strong>Jumlah Biaya R(Rp) : </strong></td>
                            <td><strong>
                                    <?php // echo CHtml::textField('grandtotal','',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                                    ?>
                                    <?php echo $form->textField($konfigFarmasi, 'admracikan', array('class' => 'span4 integer-decimal', 'readonly' => 'true')); ?>
                                <?php echo CHtml::hiddenField('admracikan', $konfigFarmasi->admracikan, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </strong></td>
                            <td colspan="20"> </td>
                        </tr>
                        <tr hidden>
                            <td colspan="5" style="text-align: left;"><strong>Jasa Pelayanan Farmasi</strong></td>
                            <td colspan="6"><strong><?php echo $form->textField($modPenjualan, 'jasapelayanan_farmasi', array('class' => 'integer-decimal span4', 'style' => 'width:120px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?></strong>
                                <?php //echo CJSON::encode($modPenjualan); 
                                ?>
                            </td>
                            <td colspan="20"> </td>
                        </tr>
                        <tr>
                            <!-- <td colspan="5" align="left" style="text-align: left;"> <strong align="left"> Jasa Embalase (Rp) : </strong> </td> -->
                            <td>
                                <?php if (!empty($_GET['reseptur_id'])) {
                                    echo CHtml::hiddenField('jml_racikan', $modReseptur->jml, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                    // echo CHtml::hiddenField('admracikan', $modReseptur->admracikan, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                } ?>
                                <?php 
                                    echo CHtml::hiddenField('admracikan', $modReseptur->admracikan, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                                    <?php 
                                    echo CHtml::hiddenField('administrasi', $modReseptur->administrasi, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                                <?php //echo $form->textField($modPenjualan, 'jasaembalase', array('class' => 'integer2 span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onBlur' => 'hitungTotal()')); ?>
                            </td>
                            <td colspan="20">
                            </td>
                        </tr>
                        <?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {?>
                        <tr class="total-ina">
                            <td colspan="5" align="left" style="text-align: left;">
                                <strong align="left">
                                    Total INACBG (Rp) :
                                </strong>
                            </td>
                            <td>
                                <?php echo $form->textField($modPenjualan, 'totalinacbg', array('readonly' => true, 'class' => 'integer-decimal span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td colspan="20">
                            </td>
                        </tr>
                        <tr class="total-ina">
                            <td colspan="5" style="text-align: left;">
                                <strong align="left"> Total Obat Kronis (Rp) : </strong>
                            </td>
                            <td>
                                <?php echo $form->textField($modPenjualan, 'totalkronis', array('readonly' => true,  'class' => 'integer-decimal span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td colspan="20">
                            </td>
                        </tr>
                        <?php }?>
                        <!-- <tr class="total-ina">
                            <td colspan="5" style="text-align: left;"><strong>Total Penjualan (Rp) : </strong></td>
                            <td><strong>
                                    <?php // echo CHtml::textField('grandtotal','',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                                    ?>
                                    <?php //echo $form->textField($modPenjualan, 'grandtotal', array('class' => 'integer-decimal span4', 'readonly' => 'true', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                                    ?>
                                </strong></td>
                            <td colspan="20"> </td>
                        </tr> -->
                        <tr>
                            <td colspan="5" style="text-align: left;"><strong>Sub Total (Rp) : </strong></td>
                            <td><strong>
                                    <?php // echo CHtml::textField('grandtotal','',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                                    ?>
                                    <?php echo $form->textField($modPenjualan, 'totalhargajual', array('class' => 'integer-decimal span4', 'readonly' => 'true', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </strong></td>
                            <td colspan="20"> </td>
                        </tr>
                        <!-- <tr class="total-ina" hidden>
                            <td colspan="5" style="text-align: right;"><strong>Total Tanggungan BPJS (Rp) : </strong></td>
                            <td><strong>
                                    <?php // echo CHtml::textField('grandtotal','',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                                    ?>
                                    <?php //echo $form->textField($modPenjualan, 'totaltanggunganbpjs', array('class' => 'integer-decimal span4', 'readonly' => 'true', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </strong></td>
                            <td colspan="19"> </td>
                        </tr> -->
                        <tr hidden>
                            <td colspan="5" style="text-align: left;"><strong>Takaran Resep : </strong></td>
                            <td><?php echo $form->dropDownList($modPenjualan, 'takaranresep', LookupM::getItems('takaranresep'), array('class' => 'form-control', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'ubahTakaranResep(this);')); ?></td>
                            <!-- <td colspan="3"></td> -->
                            <!-- <td style="text-align: right;"><strong>Total</strong></td>
                            <td><strong>
                                    <?php // echo CHtml::textField('grandtotal','',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                                    ?>
                                    <?php //echo $form->textField($modPenjualan, 'totalhargajual', array('class' => 'integer-decimal', 'style' => 'width:120px;', 'readonly' => 'true', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                                    ?>
                                </strong></td> -->
                            <td colspan="20"> </td>

                        </tr>
                        <!-- <tr>
                            <td colspan="2"></td>
                            <td colspan="1"></td>
                            <td colspan="3">
                                <?php //echo CHtml::link('<i class="entypo-plus"></i>NON RACIKAN', 'javascript:void(0);', array('style' => 'margin-bottom: 5px;', 'class' => 'btn btn-green span2', 'onclick' => 'tambahObatalkes(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah Obat Alkes NON RACIKAN dengan R Baru'));  
                                ?>
                                <?php //echo CHtml::link('<i class="entypo-plus"></i>RACIKAN', 'javascript:void(0);', array('class' => 'btn btn-blue span2', 'onclick' => 'tambahObatalkesRacikan(this,1);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah Obat Alkes RACIKAN dengan R Baru')); 
                                ?><br />

                            </td>
                            <td colspan="6"></td>
                        </tr> -->
                    </tfoot>
                </table>
                <div class="row-fluid">
                    <div class="span4"></div>
                    <div class="span4">
                        <?php echo $form->hiddenField($modPenjualan, 'totharganetto', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'totaltarifservice', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'biayaadministrasi', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'biayakonseling', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'pembulatanharga', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'jasadokterresep', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'discount', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'totalppn', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidiasuransi', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidipemerintah', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidirs', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'iurbiaya', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                    </div>
                </div>
            </div>
        </div>



        <div class="panel panel-primary panel-success hide">
            <div class="panel-heading">
                <div class="panel-title" id=""><span class="judul">Telaah Resep</span></div>
            </div>
            <div class="panel-body">
                <?php
                    echo CHtml::checkBox('checkall', false, array(
                        'class'=>'pilih-tr', 'onchange' => 'setTelaahResep(this);',
                     )) . CHtml::label('&emsp;Pilih Semua', '');
                ?>
                <div class="row">
                    <div class="col-sm-3" style="margin-left: 30px;">
                        <?php echo CHtml::checkBox('telaah_resep[identitas_dokter]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Identitas Dokter', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[identitas_pasien]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Identitas Pasien', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[tulisan_jelas]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tulisan Jelas', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[tepat_obat]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tepat Obat', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[tepat_dosis]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tepat Dosis', ''); ?><br>
                    </div>
                    <div class="col-sm-3" style="margin-left: 30px;">
                        <?php echo CHtml::checkBox('telaah_resep[tepat_rute]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tepat Rute', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[tepat_waktu]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tepat Waktu', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[tidak_ada_duplikasi]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tidak Ada Duplikasi', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[tidak_ada_interaksi]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tidak Ada Interaksi', ''); ?><br>
                        <?php echo CHtml::checkBox('telaah_resep[tidak_ada_kontraindikasi]', false, array('class'=> 'telaahresep', 'onkeypress'=>"return $(this).focusNextInputField(event);")) . CHtml::label('&emsp;Tidak Ada Kontraindikasi', ''); ?><br>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id'=>'btn_submit','class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'cekValiditas(); ', 'onkeypress' => 'cekValiditas();', 'disabled' => $sukses)); //formSubmit(this,event)
            ?>
            
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
                $this->createUrl($this->id . '/index&reseptur_id=' . $_GET['reseptur_id']),
                array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>

            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')),
                $this->createUrl('/rawatInap/pasienRawatInap/pilihResep', ['pendaftaran_id' => $modPendaftaran->pendaftaran_id]),
                array(
                    'class' => 'btn btn-secondary'
                )
            );
            ?>
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
        <?php
        $this->endWidget();
        ?>
        <?php
        $urlPrintRecordTerakhir =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printResepDokter&id=' . $modReseptur->reseptur_id);
        $js = <<< JSCRIPT
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>

        <?php
        if (!isset($_GET['sukses'])) {

            //========= Dialog buat daftar tindakan  =========================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogOa',
                'options' => array(
                    'title' => 'Stok Obat & Alkes ' . Yii::app()->user->getState('ruangan_nama'),
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 800,
                    'height' => 600,
                    'resizable' => false,
                ),
            ));

            echo CHtml::hiddenField('tindakan_untuk', 0, array('readonly' => true));
            echo CHtml::hiddenField('is_rowbaru', '', array('readonly' => true));
            $modObatDialog = new FAObatalkesM('searchObatFarmasi');
            $modObatDialog->unsetAttributes();
            $format = new MyFormatter();
            if (isset($_GET['FAObatalkesM'])) {
                $modObatDialog->attributes = $_GET['FAObatalkesM'];
            }
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'obatAlkesDialog-m-grid',
                'dataProvider' => $modObatDialog->searchObatFarmasi(),
                'filter' => $modObatDialog,
                'template' => "{items}\n{pager}",
                //    'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns' => array(
                    array(
                        'header' => 'Pilih',
                        'type' => 'raw',
                        'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
							pilihObatalkes($data->obatalkes_id,
										\"$data->obatalkes_nama\",
										$data->StokObatRuangan,
										".round($data->hargajual).",
										".round($data->harganetto).",
										\"$data->obatalkes_kode\",
										$data->sumberdana_id,
										\"$data->SumberDanaNama\",
										$data->satuankecil_id,
										\"$data->SatuanKecilNama\",
										$(\"#is_rowbaru\").val()
										);
                            $(\"#dialogOa\").dialog(\"close\");
                            return false;
                ",
               ))',
                    ),

                    'obatalkes_kode',
                    'obatalkes_nama',
                    array(
                        'header' => 'Tanggal Kadaluarsa',
                        'name' => 'tglkadaluarsa',
                        'filter' => '',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
                        'htmlOptions' => array(
                            'style' => 'text-align: right;',
                        )
                    ),
                    array(
                        'header' => 'Stok',
                        'type' => 'raw',
                        'value' => '$data->StokObatRuangan." ".$data->satuankecil->satuankecil_nama',
                        'htmlOptions' => array(
                            'style' => 'text-align: right',
                        )
                    ),

                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));

            $this->endWidget('zii.widgets.jui.CJuiDialog');
            //========= end daftar tindakan =============================

        }

        ?>

        <?php
        // Dialog buat Copy Resep =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogCopyResep',
            'options' => array(
                'title' => 'Salinan Resep',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 1100,
                'minHeight' => 500,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe src="" name="iframeCopyResep" width="100%" height="500">
        </iframe>
        <?php
        $this->endWidget();
        //========= end Copy Resep dialog =============================
        ?>

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
                            'filter' =>  CHtml::dropDownList('FAAntrianFarmasiT[antrianlewat]', $modKarcisTerakhir->antrianlewat, array(0 => 'Tidak', 1 => 'Ya'), array('empty' => '--Pilih--')),
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
            }
            ?>
        </div>
        <?php $this->renderPartial('_jsFunctions', array('modReseptur' => $modReseptur, 'modDetailReseptur' => $modDetailReseptur, 'modPenjualan' => $modPenjualan, 'modPendaftaran' => $modPendaftaran)); ?>

        <?php $this->endWidget(); ?>


       </div>

    <script>
        function printetiket(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('printEtiket'); ?>&racikan=2&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint + '&pdf=true', 'printwin', 'left=100,top=100,width=1000,height=640');
        }

        function printetiketRacikan(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('printEtiket'); ?>&racikan=1&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint + '&pdf=true', 'printwin', 'left=100,top=100,width=1000,height=640');
        }

        function printetiketKronis(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('PrintKronis'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
        function printetiketRanap(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('printEtiketRanapNew'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
        function printNotaTindakan(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('printTindakan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
        
        function printNotaPenjualan(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('printNotaPenjualan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }

        function printTelaah(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('printTelaah'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }


    </script>


<?php 
    $this->renderPartial('_dialogObatApi', ['modReseptur' => $modReseptur]);
?>
<script>
        function setTelaahResep(obj) {

            var cek = $(obj).prop('checked');
            
            console.log(cek);

            if(cek) {
                $('.telaahresep').prop('checked', true);
            } else {
                $('.telaahresep').prop('checked', false);
            }

        }
    </script>
