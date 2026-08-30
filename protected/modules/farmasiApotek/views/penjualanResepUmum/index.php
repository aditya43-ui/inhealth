<style>
    .qty_jual,
    .qty_stok {
        text-align: right;
    }

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
            <i class="glyphicon glyphicon-briefcase"></i> Penjualan <strong>Resep Umum</strong>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Penjualan Resep Umum',
        );
        ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penjualanresep-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#FAPendaftaranT_instalasi_id',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            if ($_GET['sukses'] == 1) {
                Yii::app()->user->setFlash("success", "Tansaksi Penjualan Resep Umum berhasil disimpan!");
            }
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="control-group" id="form-antrian" hidden>
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
        <!--<legend class="rim">Data Pasien<span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setInfoDokterReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></legend>-->
        <div class="row" id="form-infodokter">
            <div class="col-sm-12">
                <?php echo $form->hiddenField($modPenjualan, 'is_pasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pasien',
                    'content' => array(
                        'content-pasien' => array(
                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengisi data pasien')) . '<b> Data Pasien</b>',
                            'isi' => $this->renderPartial($this->path_view_umum . '_formDataPasien', array(
                                'form' => $form,
                                'modPenjualan' => $modPenjualan,
                                'modPasien' => $modPasien,
                            ), true),
                            'active' => $modPenjualan->is_pasien,
                        ),
                    ),
                )); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div id="form-dataresep">
                    <?php $this->renderPartial($this->path_view_umum . '_formDataResep', array('form' => $form, 'modPenjualan' => $modPenjualan, 'modReseptur' => $modReseptur)); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <?php
                if (!isset($_GET['sukses'])) { //RND-5894
                    $this->renderPartial($this->path_view . '_formInputObat', array('form' => $form, 'racikan' => $racikan, 'racikanDetail' => $racikanDetail, 'nonRacikan' => $nonRacikan));
                }
                ?>
            </div>
        </div>
        <div class="panel panel-success panel-shadow" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <strong>Obat Alkes</strong>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
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
                                <th>Sub Total</th>
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
                                    $dataObatApi = $ObatAPI->searchStokByDepo($modDetail->obatalkes->sumberdana_id, $modDetail->obatalkes->kodeobat_inventory);
                    				$modDetail->jmlstok = isset($dataObatApi['jmlStok']) ? $dataObatApi['jmlStok'] : 0 ;    
                                    $modDetail->hargasatuan_oa = MyFormatter::formatNumberForPrint($modDetail->hargasatuan_oa, 2);
                                    $modDetail->hargajual_oa = MyFormatter::formatNumberForPrint($modDetail->hargajual_oa, 2);
                                    $modDetail->qty_oa = MyFormatter::formatNumberForPrint($modDetail->qty_oa, 2);
                                    echo $this->renderPartial($this->path_view_umum . '_rowDetail', array('modObatAlkesPasien' => $modDetail, 'modReseptur' =>$modReseptur));
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
								<td style="text-align: right;" colspan="10"><strong>Jumlah Biaya R</strong></td>
								<td>
									<?php echo $form->textField($konfigFarmasi, 'admracikan', array('class' => 'span2 integer-decimal', 'readonly' => 'true')); ?>
									<?php echo CHtml::hiddenField('admracikan', $konfigFarmasi->admracikan, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
								</td>
								<td colspan="4">
								</td>
							</tr>
                            <tr>
                                <td colspan="10" style="text-align: right;"><b>Jasa Pelayanan Farmasi</b></td>
                                <td><?php echo $form->textField($modPenjualan, 'jasapelayanan_farmasi', array('class' => 'span2 integer-decimal', 'readonly' => false, 'onkeyup' => 'hitungTotal(this);')); ?></td>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                </td>
                                <td>
                                    <strong>Takaran Resep : </strong>
                                    <?php echo $form->dropDownList($modPenjualan, 'takaranresep', LookupM::getItems('takaranresep'), array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'ubahTakaranResep(this);')); ?>
                                </td>
                                <td colspan="6">
                                </td>
                                <td style="text-align: right;"><strong>Total</strong></td>
                                <td>
                                    <?php echo $form->textField($modPenjualan, 'totalhargajual', array('class' => 'span2 integer-decimal', 'readonly' => 'true')); ?>
                                </td>
                                <td colspan="4">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row-fluid">
                    <div class="col-sm-12">
                        <?php echo $form->hiddenField($modPenjualan, 'totharganetto', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'totaltarifservice', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'biayaadministrasi', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'biayakonseling', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'pembulatanharga', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'jasadokterresep', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'discount', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidiasuransi', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidipemerintah', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'subsidirs', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modPenjualan, 'iurbiaya', array('class' => 'integer2', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modReseptur, 'admracikan', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        <?php echo $form->hiddenField($modReseptur, 'administrasi', array('class' => 'integer-decimal', 'readonly' => 'true')); ?>
                        
                    </div>

                    <!-- </fieldset> -->
                    <!-- <fieldset id="form-infodokter"> -->
                    <!--<legend class="rim"><span class='judul'>Data Pasien </span><span class='tombol' style='display:none;'><?php //echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setInfoDokterReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); 
                                                                                                                                ?></span></legend>-->
                    <!-- <div class="row-fluid">
					<div class = "col-sm-12"> -->
                    <?php //echo $form->hiddenField($modPenjualan,'is_pasien', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                    <?php //$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    // 'id'=>'form-pasien',
                    // 'content'=>array(
                    // 	'content-pasien'=>array(
                    // 		'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengisi data pasien')).'<b> Data Pasien</b>',
                    // 		'isi'=>$this->renderPartial($this->path_view_umum.'_formDataPasien',array(
                    // 				'form'=>$form,
                    // 				'modPenjualan'=>$modPenjualan,
                    // 				'modPasien'=>$modPasien,
                    // 				),true),
                    // 		'active'=>$modPenjualan->is_pasien,
                    // 	),
                    // ),
                    //)); 
                    ?>
                    <!-- </div>
				</div>
			</fieldset>
			<div class="row-fluid"> -->
                    <!-- <div class="col-sm-6">
					<div id="form-dataresep">
						<?php //$this->renderPartial($this->path_view_umum.'_formDataResep', array('form'=>$form,'modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur)); 
                        ?>
					</div>
				</div> -->
                    <!-- <div class="col-sm-6"> -->

                    <?php
                    // if(!isset($_GET['sukses'])){ //RND-5894
                    // 	$this->renderPartial($this->path_view.'_formInputObat', array('form'=>$form,'racikan'=>$racikan, 'racikanDetail'=>$racikanDetail,'nonRacikan'=>$nonRacikan));
                    // }
                    ?>

                    <!-- </div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Tabel <strong>Obat Alkes</strong></div>
				</div>
				<div class="panel-body table-responsive">
					<div class="block-tabel">
						<table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
							<thead>
								<tr>
									<th>Resep</th>
									<th>R ke</th>
									<th>Kode / Nama Obat</th>
                                    <th>Jumlah Stok</th>
									<th>Jumlah</th>
									<th>Harga Satuan (Rp)</th>
                                    <th>Biaya Administrasi (Rp)</th>
                                    <th>Total Biaya Administrasi (Rp)</th>
                                    <th>Diskon (%)</th>
                                    <th>Diskon (Rp)</th>
                                    <th>PPN (%)</th>
                                    <th>PPN (Rp)</th>
									<th>Sub Total</th>
									<th>Signa</th>
									<th>Etiket</th>
									<th>Batal</th>
								</tr>
							</thead>
							<tbody> -->
                    <?php
                    // if(count((array)$modObatAlkesPasien) > 0){
                    // 	foreach($modObatAlkesPasien AS $i=> $modDetail){
                    //         $modDetail->ppnpersen = $modDetail->persenppnjual;
                    // 		$modDetail->jmlstok = StokobatalkesT::getJumlahStokOaTersimpan($modDetail->obatalkespasien_id);
                    //         $modDetail->hargasatuan_oa = MyFormatter::formatNumberForPrint($modDetail->hargasatuan_oa, 2);
                    //         $modDetail->hargajual_oa = MyFormatter::formatNumberForPrint($modDetail->hargajual_oa, 2);
                    //         $modDetail->qty_oa = MyFormatter::formatNumberForPrint($modDetail->qty_oa, 2);
                    // 		echo $this->renderPartial($this->path_view_umum.'_rowDetail',array('modObatAlkesPasien'=> $modDetail));
                    // 	}
                    // }
                    ?>
                    <!-- </tbody>
              <tfoot>
                <tr>
                  <td colspan="2">
                  </td>
                  <td> -->
                    <!-- <strong>Takaran Resep : </strong> -->
                    <?php //echo $form->dropDownList($modPenjualan, 'takaranresep', LookupM::getItems('takaranresep') ,array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'ubahTakaranResep(this);')); 
                    ?>
                    <!-- </td>
                  <td colspan="8">
                  </td>
                  <td style="text-align: right;"><strong>Total</strong></td>
                  <td> -->
                    <?php //echo $form->textField($modPenjualan, 'totalhargajual',array('class'=>'span2 integer-decimal', 'readonly'=>'true')); 
                    ?>
                    <!-- </td>
                  <td colspan="3">
                  </td>
                </tr>
              </tfoot>
						</table>
					</div>
					<div class="row-fluid">
						<div class="col-sm-12"> -->
                    <?php //echo $form->hiddenField($modPenjualan, 'totharganetto',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'totaltarifservice',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'biayaadministrasi',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'biayakonseling',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'pembulatanharga',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'jasadokterresep',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'discount',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'subsidiasuransi',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'subsidipemerintah',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'subsidirs',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                    <?php //echo $form->hiddenField($modPenjualan, 'iurbiaya',array('class'=>'integer2', 'readonly'=>'true')); 
                    ?>
                </div>
                <!-- <div class="col-sm-6"><?php //echo $form->dropDownListRow($modPenjualan, 'takaranresep',LookupM::getItems('takaranresep'),array('class'=>'span1','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'ubahTakaranResep(this);')); 
                                            ?></div> -->
                <!-- <div class="col-sm-6"><?php //echo $form->textFieldRow($modPenjualan, 'totalhargajual',array('class'=>'span2 integer2', 'readonly'=>'true')); 
                                            ?></div> -->
                <!-- </div>
				</div>
			</div>
                <div class="form-actions"> -->
                <?php
                // $disableSave = false;
                // $disableSave = ((!empty($_GET['penjualanresep_id'])) ? true : (($sukses > 0) ? true : false));
                ?>
                <?php //$disablePrint = ($disableSave) ? false : true; 
                ?>
                <?php
                //echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();','disabled'=>$disableSave)); //formSubmit(this,event)
                //  jika tanpa cek obat
                /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                 *
                 */
                ?>
                <?php //if(!isset($_GET['frame'])){
                //     echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                //         $this->createUrl($this->id.'/index'),
                //         array('class'=>'btn btn-danger',
                //               'onclick'=>'return refreshForm(this);'));
                // } 
                ?>
                <?php
                //echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));
                ?>
                <?php
                //$content = $this->renderPartial('tips/tipsPenjualanResepUmum',array(),true);
                //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                ?>

                <!-- <div class="col-sm-6"><?php //echo $form->dropDownListRow($modPenjualan, 'takaranresep',LookupM::getItems('takaranresep'),array('class'=>'span1','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'ubahTakaranResep(this);')); 
                                            ?></div> -->
                <!-- <div class="col-sm-6"><?php //echo $form->textFieldRow($modPenjualan, 'totalhargajual',array('class'=>'span2 integer2', 'readonly'=>'true')); 
                                            ?></div> -->

                <!-- </div>
            </div>
        </div> -->
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


                    if(isset($_GET['penjualanresep_id']) && isset($_GET['sukses'])) {
                        echo CHtml::Link('<i class="icon-print icon-white"></i> Print E-Tiket Rawat Inap', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printetiketRanap(\'PRINT\')', 'disabled' => isset($_GET['sukses']) ? false : true));
                    }else{
                        echo CHtml::Link('<i class="icon-print icon-white"></i> Print E-Tiket Rawat Inap', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printetiketRanap(\'PRINT\')', 'disabled' =>true));
                    }
                    ?>
                    <?php
                    $content = $this->renderPartial('tips/tipsPenjualanResepUmum', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/pembayaranPenjualanApotek/index", array("penjualanresep_id" => $modPenjualan->penjualanresep_id, "pasien_id" => $modPenjualan->pasien_id, "frame" => true, 'pelayanan' => "RO")), array("target" => "iframePembayaran", 'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => isset($_GET['sukses']) ? false : true));
                    ?>
                    <br>
                    <?php
                        echo '&nbsp;';
                        if(isset($_GET['sukses'])) {
                            echo CHtml::Link('<i class="icon-print icon-white"></i> Print Nota Penjualan', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printNotaPenjualan(\'PRINT\')'));
                        }else{
                            echo CHtml::Link('<i class="icon-print icon-white"></i> Print Nota Penjualan', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printNotaPenjualan(\'PRINT\')', 'disabled' =>true));
                        }

                        echo '&nbsp;';
                        
                        echo CHtml::Link('<i class="icon-print icon-white"></i> Print Nota Tindakan', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printTindakan(\'PRINT\')', 'disabled' =>!isset($_GET['sukses'])));


                        echo '&nbsp;';
                        if(isset($_GET['penjualanresep_id']) && isset($_GET['sukses'])) {
                            echo CHtml::Link('<i class="icon-print icon-white"></i> Lembar Telaah', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printTelaah(\'PRINT\')', 'disabled' => false));
                        }else{
                            echo CHtml::Link('<i class="icon-print icon-white"></i> Lembar Telaah', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printTelaah(\'PRINT\')', 'disabled' =>true));
                        }
                    ?>
                </div>
            </div>
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
                            'filter' => $modKarcisTerakhir->getListRacikans(),
                        ),
                        'noantrian',
                        array(
                            'name' => 'panggilantrian',
                            'filter' => array(1 => 'Sudah', 0 => 'Belum'),
                            'type' => 'raw',
                            'value' => '($data->panggilantrian) ? "Sudah" : "Belum"',
                        ),
                        array(
                            'name' => 'antrianlewat',
                            'filter' => array(1 => 'Ya', 0 => 'Tidak'),
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
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPenjualan' => $modPenjualan, 'modReseptur' => $modReseptur)); ?>
        <?php $this->renderPartial($this->path_view_umum . '_jsFunctions', array('modPenjualan' => $modPenjualan, 'modReseptur' => $modReseptur, 'modPasien' => $modPasien)); ?>
        <!--/div-->