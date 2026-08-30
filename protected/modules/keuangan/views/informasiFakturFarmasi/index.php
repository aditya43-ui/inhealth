<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi Faktur <strong>Pembelian Farmasi</strong></div>
            </div>
            <div class="panel-body">
                <?php
                    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'id' => 'rencana-t-search',
                        'type' => 'horizontal',
                        'focus' => '#BKFakturPembelianT_nofaktur'
                    ));
                ?>
				<?php
				$this->breadcrumbs = array(
					'Daftar Faktur Pembelian',
				);

				Yii::app()->clientScript->registerScript('search', "

				$('#rencana-t-search').submit(function(){
					$('#fakturpembelian-m-grid').addClass('animation-loading');
					$.fn.yiiGridView.update('fakturpembelian-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row" id="divSearch-form">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd'), 'medium', null); 
                                $model->tgl_awal = date('d M Y', strtotime($model->tgl_awal));
                            ?>
                            <?php echo CHtml::label('Tgl. Faktur', 'BKFakturPembelianT_tgl_awal', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd'), 'medium', null); 
                                $model->tgl_akhir = date('d M Y', strtotime($model->tgl_akhir));
                            ?>
                            <?php echo CHtml::label('Sampai Dengan', 'BKFakturPembelianT_tgl_akhir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $model->tgl_awalJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awalJatuhTempo, 'yyyy-MM-dd'), 'medium', null); ?>
                            <label class="control-label">
                                <?php echo CHtml::checkBox('berdasarkanJatuhTempo', '', array('uncheckValue' => 0, 'onClick' => 'cekTanggal()')); ?>
                                Tgl. Jatuh Tempo
                            </label>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awalJatuhTempo',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $model->tgl_akhirJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirJatuhTempo, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', 'BKFakturPembelianT_tgl_akhirJatuhTempo', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhirJatuhTempo',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'span4 numberOnly')); ?>
                        <?php echo $form->textFieldRow($model, 'noterima', array('placeholder' => 'No. Terima', 'class' => 'span4 numberOnly')); ?>
                        <?php
                        echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData($model->supplierItems, 'supplier_id', 'supplier_nama'), array(
                            'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --',
                        ));
                        ?>
                        <?php
                        echo $form->dropDownListRow($model, 'syaratbayar_id', CHtml::listData($model->syaratBayarItems, 'syaratbayar_id', 'syaratbayar_nama'), array(
                            'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --',
                        ));
                        ?>
                        <div class="control-group">
                            <?php echo Chtml::label('Status Bayar', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'statusBayar', array(1 => 'Sudah Lunas', 2 => 'Belum Lunas'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array(
                            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) ?>
                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian Farmasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $totalharganetto = 0;
                $prov = $model->searchInformasi();
                $cloneProv = clone $prov;
                foreach ($cloneProv->data as $dataClone) {
                    $totalharganetto += $dataClone->totalhutangusaha;
                }
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'fakturpembelian-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ?
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)'
									),
									array(
										'header' => 'Tgl Faktur/<br/>No Faktur',
										'type' => 'raw',
										//'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
										'value'=>function($data) {
                                                            return MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglfaktur))).'/<br/>'.$data->nofaktur;
//                                            return CHtml::Link('<u>'. MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglfaktur))).'/<br/>'.$data->nofaktur.'</u>',Yii::app()->controller->createUrl("FakturPembelianKU/print",array("fakturpembelian_id"=>$data->fakturpembelian_id,"frame"=>true)),
//                                                array("class"=>"",
//                                                      "target"=>"iframe",
//                                                      "onclick"=>'$("#dialogDetailsFaktur").dialog("open");',
//                                                      "rel"=>"tooltip",
//                                                      "title"=>"Klik untuk melihat details faktur pembelian",
//                                                ));
                                        },
                                                'footer'=>'Total :',
										'footerHtmlOptions'=>array('colspan'=>16,'style'=>'text-align:right;'),
									),
									array(
										'header'=>'Tanggal Terima',
										'type'=>'raw',
										'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
									),
									array(
										'header' => 'No Penerimaan',
										'type' => 'raw',
										'value' => '$data->noterima',
									),
									array(
										'header' => 'No Permintaan',
										'type' => 'raw',
										'value' => '$data->nopermintaan',
									),
									array(
										'header' => 'Tgl Jatuh Tempo',
										'type' => 'raw',
										'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
									),
									array(
										'header' => 'Umur Hutang',
										'type' => 'raw',
										'value' => '$data->umurHutang',
									),
                                                                        array(
										'header' => 'Syarat Bayar',
										'type' => 'raw',
										'value' => '$data->syaratbayar_nama',
									),
									'keteranganfaktur',
									array(
										'name' => 'supplier_id',
										'type' => 'raw',
										'value' => '$data->supplier_nama',
									),
									array(
                                                                            'header' => 'Total Harga',
										'name' => 'totharganetto',
										'type' => 'raw',
										'value' => 'number_format($data->totharganetto,2,",",".")',
										'htmlOptions'=>array('style'=>'text-align: right'),
									),
									array(
										'header' => 'Total Keringanan',
										'type' => 'raw',
										'value' => 'number_format($data->jmldiscount,2,",",".")',
										'htmlOptions'=>array('style'=>'text-align: right'),
									),
									array(
										'header' => 'Total PPN',
										'type' => 'raw',
										'value' => 'number_format($data->totalpajakppn,2,",",".")',
										'htmlOptions'=>array('style'=>'text-align: right'),
									),
									array(
										'header' => 'Total PPh',
										'type' => 'raw',
										'value' => 'number_format($data->totalpajakpph,2,",",".")',
										'htmlOptions'=>array('style'=>'text-align: right'),
									),
									array(
										'header' => 'Total Keseluruhan',
										'type' => 'raw',
										'value' => 'number_format($data->totalhargabruto,2,",",".")',
										'htmlOptions'=>array('style'=>'text-align: right'),
									),
                                                                        array(
										'header' => 'Jumlah Uang Muka',
										'type' => 'raw',
										'value' => 'number_format($data->jmluangmukabeli,2,",",".")',
										'htmlOptions'=>array('style'=>'text-align: right'),
									),
                                                                        array(
										'header' => 'Total Harga Netto',
										'type' => 'raw',
										'value' => 'number_format($data->totalhutangusaha,2,",",".")',
										'htmlOptions'=>array('style'=>'text-align: right'),
                                                                            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                                                            'footer'=>number_format($totalharganetto,2,",","."),
									),
                                                                        array(
									   'header'=>'Rincian',
									   'type'=>'raw',
									   'htmlOptions'=>array('style'=>'text-align:left;'),
									   'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->controller->createUrl("FakturPembelianKU/print",array("fakturpembelian_id"=>$data->fakturpembelian_id,"frame"=>true)) ,array("title"=>"Klik Untuk Melihat Rincian Faktur","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsFaktur\").dialog(\"open\");", "rel"=>"tooltip"))',
									   'footer'=>'-',
									   'footerHtmlOptions'=>array('style'=>'text-align:left;color:white;'),
									),
									/*array(//Details ini langsung terhubung ke details Faktur d peneriaam Items supaya mudah memaintenance karena 1 view dan action
										'header' => 'Details',
										'type' => 'raw',
										'htmlOptions' => array('style' => 'text-align:left;'),
										'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("keuangan/InformasiFakturFarmasi/detailsFaktur",array("idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik Untuk Melihat Detail Faktur","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsFaktur\").dialog(\"open\");", "rel"=>"tooltip"))',
									),*/
                        array(
                            'header' => 'Manager Keuangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modAppr = ApprovalotorisasiM::model()->find();
                                $pegawainame = "";
                                $pegawainameid = "";
                                $peg = PegawaiM::model()->findByPk($data->pegawaimenyetujuikeuangan_id);
                                if (isset($peg)) {
                                    $pegawainameid = $peg->pegawai_id;
                                    $pegawainame = $peg->namaLengkap;
                                }
                                if (isset($modAppr)) {
                                    if ($data->sumberdana_id == Params::SUMBERDANA_ID_PT) {
                                        if (!empty($modAppr->managerkeuanganpt_id)) {
                                            $pegawainameid = $modAppr->managerkeuanganpt_id;
                                            $pegawainame = $modAppr->managerkeuanganpt->namaLengkap;
                                        }
                                    } else {
                                        if (!empty($modAppr->managerkeuangan_id)) {
                                            $pegawainameid = $modAppr->managerkeuangan_id;
                                            $pegawainame = $modAppr->managerkeuangan->namaLengkap;
                                        }
                                    }
                                }
                                //                                                                                $dataDialog = 'myAlert("Hanya '.$pegawainame.' yang bisa mengakses");';
                                //                                                                                if($pegawainameid==Yii::app()->user->getState('pegawai_id')){
                                $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                //                                                                                }
                                $html = $pegawainame . (!empty($data->pegawaimenyetujuikeuangan_id) ? (!empty($data->tgl_menyetujuikeuangan) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_menyetujuikeuangan) : "") : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Menyetujui', array("fakturpembelian_id" => $data->fakturpembelian_id, "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik untuk Approve Manager Keuangan", "onclick" => $dataDialog)));
                                return $html;
                            },
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                        ),
                        array(
                            'header' => 'Ubah Faktur',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $modelByr = BayarkesupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $data->fakturpembelian_id));
                                return ((count((array)$modelByr) == 0) ? CHtml::link("<i class='icon-form-fakturbeli'></i> ",  Yii::app()->createUrl("keuangan/InformasiFakturFarmasi/ubahFaktur", array("fakturpembelian_id" => $data->fakturpembelian_id)), array("rel" => "tooltip", "title" => "Klik untuk Ubah Faktur Pembelian Farmasi")) : "");
                            },
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                            //                                                                        'value'=>'(empty($data->bayarkesupplier_id)?CHtml::link("<i class=\'icon-form-fakturbeli\'></i> ",  Yii::app()->createUrl("keuangan/InformasiFakturFarmasi/ubahFaktur",array("fakturpembelian_id"=>$data->fakturpembelian_id)),array("rel"=>"tooltip","title"=>"Klik untuk Ubah Faktur Pembelian Farmasi")):"")',
                        ),
                        array(
                            'header' => 'Status Pembayaran',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'value' => function ($data) {
                                $bayarSupplier = BayarkesupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $data->fakturpembelian_id));
                                $totalSisaTagihan = 0;
                                $htmlStatus = '<button id="red" class="btn btn-default" name="yt1">BELUM LUNAS</button>';
                                if (isset($bayarSupplier) && count((array)$bayarSupplier) > 0) {
                                    foreach ($bayarSupplier as $byr) {
                                        $totalSisaTagihan += $byr->totalsisatagihan;
                                    }
                                    if ($totalSisaTagihan == 0) {
                                        $htmlStatus = '<button id="red" class="btn btn-primary" name="yt1">LUNAS</button>';
                                    }
                                }
                                return $htmlStatus;
                            }
                        ),
                        // array(
                        // 	'header' => 'Bayar ke Supplier',
                        // 	'type' => 'raw',
                        // 	'htmlOptions' => array('style' => 'text-align:left;'),
                        // 	//'value' => '((empty($data->bayarkesupplier_id)) ? CHtml::link("<i class=\'icon-form-bayar\'></i> ",Yii::app()->createUrl("keuangan/pembayaranSupplierKU/index",array("frame"=>1,"idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik untuk Membayar ke Supplier","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip")) : "Lunas")',
                        // 	'value' => function($data){
                        // 		if (empty($data->bayarkesupplier_id)){
                        // 			return (!empty($data->pegawaimenyetujuikeuangan_id)?CHtml::link("<i class='icon-form-bayar'></i> ",Yii::app()->createUrl("keuangan/pembayaranSupplierKU/index",array("idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik untuk Membayar ke Supplier", "rel"=>"tooltip")):"");
                        // 		}else{
                        // 			$kaskeluar = BayarkesupplierT::model()->findByPk($data->bayarkesupplier_id);
                        //
                        //
                        // 			return CHtml::Link('<u>'. MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($kaskeluar->tandabuktikeluar->tglkaskeluar))).'/<br>'.$kaskeluar->tandabuktikeluar->nokaskeluar.'</u>',Yii::app()->controller->createUrl("pembayaranSupplierKU/print",array("id"=>$data->bayarkesupplier_id,"frame"=>true)),
                        // 				array("class"=>"",
                        // 					  "target"=>"iframebayar",
                        // 					  "onclick"=>'$("#dialogDetailsBayar").dialog("open");',
                        // 					  "rel"=>"tooltip",
                        // 					  "title"=>"Klik untuk melihat details faktur pembelian",
                        // 				));
                        // 		}
                        // 	},
                        //                                                                       'footer'=>'-',
                        //    'footerHtmlOptions'=>array('style'=>'text-align:left;color:white;'),
                        // ),
                        array(
                            'header' => 'Retur',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if (empty($data->returpembelian_id)) {
                                    if (Params::cekUnitReturTerimaOa(Yii::app()->user->getState('unitkerja_id'), 'keuangan')) {
                                        if (empty($data->bayarkesupplier_id)) {
                                            return CHtml::Link("<i class='icon-form-retur'></i>", "javascript:;", array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk membuat retur pembelian",
                                                "data-placement" => "left",
                                                "onclick" => "myAlert('Faktur Belum Lunas')"
                                            ));
                                        } else {
                                            return CHtml::Link("<i class='icon-form-retur'></i>", $this->createUrl("/gudangFarmasi/PenerimaanBarang/returPembelianOA") . '&penerimaanbarang_id=' . $data->penerimaanbarang_id, array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk membuat retur pembelian",
                                                "data-placement" => "left"
                                            ));
                                        }
                                    } else {
                                        return CHtml::Link("<i class='icon-form-retur'></i>", "javascript:;", array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk membuat retur pembelian",
                                            "data-placement" => "left",
                                            "onclick" => "myAlert('Hanya Keuangan yang bisa mengakses ini')"
                                        ));
                                    }
                                } else {
                                    return "Sudah Diretur";
                                }
                            },
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modelByr = BayarkesupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $data->fakturpembelian_id));
                                return ((count((array)$modelByr) == 0) ? CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalFaktur(' . $data->fakturpembelian_id . ')', array("id" => $data->fakturpembelian_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan Faktur Pembelian Farmasi", "data-placement" => "left")) : "");
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'footer' => '-',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'form_hiddenFaktur',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('target' => '_new'),
	'action' => Yii::app()->createUrl($module . '/fakturPembelian/index'),
		));
?>

<?php

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rencana-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1100px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);
?>

<?php echo CHtml::hiddenField('idPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('noPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('tglPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('currentUrl', $currentUrl, array('readonly' => true)); ?>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogDetailsFaktur',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Rincian Faktur Pembelian',
		'autoOpen' => false,
		'minWidth' => 1100,
		'minHeight' => 500,
		'resizable' => false,
		'position'=>array('my'=>'bottom','at'=>'bottom')
	),
));
?>
<iframe src="" name="iframe" width="100%" height="550">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================


// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogDetailsBayar',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Details Bayar Ke Supplier',
		'autoOpen' => false,
		'minWidth' => 1100,
		'minHeight' => 50,
		'resizable' => false,
		'close'=>"js:function(){ $.fn.yiiGridView.update('fakturpembelian-m-grid', {
			data: $('#rencana-t-search').serialize()
		}); }",
	),
));
?>
<iframe src="" name="iframebayar" width="100%" height="350">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogRetur',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Pembayaran Supplier',
		'autoOpen' => false,
		'width' => 1100,
		'resizable' => false,
		"beforeClose" => 'js:function(){$("#divSearch-form form").submit();}',
		'close'=>"js:function(){ $.fn.yiiGridView.update('fakturpembelian-m-grid', {
			data: $('#rencana-t-search').serialize()
		}); }",
	),
));
?>
<iframe src="" name="iframeRetur" width="100%" height="500">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!-- Dialog untuk menyetujui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Pegawai Menyetujui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1100,
            'minHeight' => 500,
            'resizable' => false,
			'position'=>array('my'=>'bottom','at'=>'bottom'),
            'close'=>"js:function(){ $.fn.yiiGridView.update('fakturpembelian-m-grid', {
                            data: $(this).serialize()
                    }); }",
),
));
?>
<iframe name='frameMenyetujui' width="100%" height="550" style="border: none;"></iframe>
<?php $this->endWidget(); ?>

<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalFaktur',
    'options' => array(
        'title' => 'Pembatalan Faktur Pembelian Farmasi',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formPembatalanFaktur');

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$js = <<< JSCRIPT
function formFaktur(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    $('#idPenerimaanForm').val(idPenerimaan);
    $('#noPenerimaanForm').val(noPenerimaan);
    $('#tglPenerimaanForm').val(tglPenerimaan);
    $('#form_hiddenFaktur').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD);
?>
<script>
	document.getElementById('KUInformasifakturpembelianV_tgl_awalJatuhTempo_date').setAttribute("style", "display:none;");
	document.getElementById('KUInformasifakturpembelianV_tgl_akhirJatuhTempo_date').setAttribute("style", "display:none;");
	function cekTanggal() {
		var checklist = $('#berdasarkanJatuhTempo');
		var pilih = checklist.attr('checked');
		if (pilih) {
			document.getElementById('KUInformasifakturpembelianV_tgl_awalJatuhTempo_date').setAttribute("style", "display:block;");
			document.getElementById('KUInformasifakturpembelianV_tgl_akhirJatuhTempo_date').setAttribute("style", "display:block;");
		} else {
			document.getElementById('KUInformasifakturpembelianV_tgl_awalJatuhTempo_date').setAttribute("style", "display:none;");
			document.getElementById('KUInformasifakturpembelianV_tgl_akhirJatuhTempo_date').setAttribute("style", "display:none;");
		}
	}

         function dialogBatalFaktur(fakturpembelian_id)
    {
        myConfirm("Apakah anda yakin akan membatalkan data faktur ini ?","Perhatian!",function(r) {
            if(r){
                $('#DialogBatalFaktur #fakturpembelian_id').val(fakturpembelian_id);
                $('#DialogBatalFaktur #keterangan_batal').val('');
                $('#DialogBatalFaktur').dialog('open');
            }
	 });

    }

    function ubahFakturKarenaBatal() {
        var fakturpembelian_id = $('#DialogBatalFaktur #fakturpembelian_id').val();
        var tglbatal = $('#DialogBatalFaktur #tglbatal').val();
        var pegawaibatal = $('#DialogBatalFaktur #tglbatal').val();
        var keterangan_batal = $('#DialogBatalFaktur #keterangan_batal').val();

        $('#DialogBatalFaktur #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Faktur Ini, wajib diisi");
            $('#DialogBatalFaktur #keterangan_batal').attr('class', 'error');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('BatalFaktur'); ?>',
            data: {fakturpembelian_id: fakturpembelian_id, tglbatal: tglbatal, pegawaibatal: pegawaibatal, keterangan_batal: keterangan_batal}, //
            dataType: "json",
            success: function (data) {
                if (data.status == 'ok') {
                    myAlert(data.keterangan);
                    $('#DialogBatalFaktur').dialog('close');
                        $.fn.yiiGridView.update('fakturpembelian-m-grid', {
                            data: $(this).serialize()
                        });
                }else{
                    myAlert(data.keterangan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
</script>
