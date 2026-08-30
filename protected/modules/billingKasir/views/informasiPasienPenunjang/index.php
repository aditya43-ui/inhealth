<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php
	Yii::app()->clientScript->registerScript('search', "
	$('.currency').each(
		function()
		{
			var result = formatInteger($(this).text());
			$(this).text(result);
		}
	);
	$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
	});
	$('#search').submit(function(){
			$('#rinciantagihanpasienpenunjang-v-grid').addClass('animation-loading');
			$.fn.yiiGridView.update('rinciantagihanpasienpenunjang-v-grid', {
					data: $(this).serialize()
			});
			return false;
	});
	");
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
	$module  = $this->module->name;
	$controller = $this->id;
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Informasi <b>Rincian Tagihan Pasien Penunjang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                ));
                ?>
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                    'id' => 'dialogKwitansi',
                    'options' => array(
                        'title' => 'Kuitansi Pasien ',
                        'autoOpen' => false,
                        'modal' => true,
                        'width' => 900,
                        'height' => 550,
                        'resizable' => false,
                    ),
                ));
                ?>
                <iframe name='iframeKwitansi' style="width: 100%; height: 98%;"></iframe>
                <?php $this->endWidget(); ?>
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                    'id' => 'dialogPembayaran',
                    'options' => array(
                        'title' => 'Pembayaran Tagihan Pasien Penunjang',
                        'autoOpen' => false,
                        'modal' => true,
                        'width' => 900,
                        'height' => 500,
                        'resizable' => false,
                        'close' => 'js:function(){$.fn.yiiGridView.update(\'rinciantagihanpasienpenunjang-v-grid\', {data: $(\'#search\').serialize()});}'
                    ),
                ));
                ?>
                <iframe name='iframePembayaran' style="width:100%; height: 98%;"></iframe>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rincian Tagihan Pasien Penunjang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'rinciantagihanpasienpenunjang-v-grid',
                    'dataProvider' => $model->searchRincianTagihanNonAmbulans(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'mergeColumns' => array('rincian', 'tagihan', 'cetak'),
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Pendaftaran<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->tgl_pendaftaran."<br>".$data->no_pendaftaran'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->namadepan.$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Jenis Penjamin<br>Penjamin',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama."<br>".$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'Dokter',
                            //'name'=>'nama_pegawai',
                            'value' => function ($data) use (&$p) {
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                if (empty($p->pegawai_id)) return "-";
                                return $p->pegawai->namaLengkap;
                                //'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                            }
                        ),
                        'ruangan_nama',
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => function ($data) use (&$p) {
                                return CHtml::htmlButton($p->statusperiksa, array(
                                    'class' => 'btn ' . Params::statusPeriksaCol()[$p->statusperiksa],
                                    'style' => 'min-width: 200px;'
                                ));
                                //												return $p->statusperiksa;
                            }
                        ),
                        array(
                            'header' => 'Total Tagihan (Rp)',
                            'type' => 'raw',
                            'value' => '(empty($data->totaltagihan)) ? "0" : MyFormatter::formatNumberForPrint($data->totaltagihan,2)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'header' => 'Rincian <br> Tagihan',
                            'name' => 'rincian',
                            'type' => 'raw',
                            //										'value'=>'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("rinciantagihanpasienLab/rincian",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "id"=>$data->pendaftaran_id,"frame"=>true)),
                            //													array("class"=>"",
                            //														  "target"=>"iframePembayaran",
                            //														  "onclick"=>"$(\"#dialogPembayaran\").dialog(\"open\");",
                            //														  "rel"=>"tooltip",
                            //														  "title"=>"Klik untuk melihat rincian tagihan pasien",
                            //													))',
                            //										'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                            //										),
                            'value' => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>"","frame"=>true)),
														array("class"=>"",
															  "target"=>"iframePembayaran",
															  "onclick"=>"$(\"#dialogPembayaran\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk melihat Rincian Tagihan",
														))',          'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Bayar Tagihan Pasien',
                            'name' => 'tagihan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::Link(
                                    "<i class=\"icon-form-bayar\"></i>",
                                    'javascript:void(0)',
                                    //Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RJ,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                    array(
                                        "class" => "",
                                        //"target"=>"iframePembayaran",
                                        "onclick" => "cekStatusPasien(" . $data->pendaftaran_id . ", " . $data->instalasipenunjang_id . ");", //"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk membayar ke kasir",
                                    )
                                );
                            }, /*'($data->totaltagihan != 0 ?
													CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->createUrl("billingKasir/pembayaranTagihanPasienPenunjang/index",array("instalasi_id"=>$data->instalasipenunjang_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
														array("class"=>"",
															  "target"=>"iframePembayaran",
															  "onclick"=>"$(\"#dialogPembayaran\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk membayar tagihan pasien",
														)) : "<div id=\"$data->pendaftaran_id\">SUDAH LUNAS</div>"
											)',
                                             *
                                             */
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Status Pembayaran',
                            'name' => 'cetak',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $total = (empty($data->totaltagihan)) ? "0" : $data->totaltagihan;
                                return ($total != 0 ? "<div id=\"$data->pendaftaran_id\">Belum Lunas</div>" : "Sudah Lunas" . "<br>"); /*.CHtml::Link("<i class=\"icon-form-print\"></i>",Yii::app()->controller->createUrl("kwitansiLab/view",array("pendaftaran_id"=>$data->pendaftaran_id,"idPembayaranPelayanan"=>$data->pembayaranpelayanan_id,"frame"=>true)),
												array("class"=>"",
													  "target"=>"iframeKwitansi",
													  "onclick"=>"$(\"#dialogKwitansi\").dialog(\"open\");",
													  "rel"=>"tooltip",
													  "title"=>"Klik untuk cetak Kwitansi",
												))); */
											},
											'htmlOptions'=>array('style'=>'text-align: left; width:40px')
										),
									),
									'afterAjaxUpdate'=>'function(id, data){
										jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
										$(".currency").each(
											function()
											{
												var result = formatInteger($(this).text());
												$(this).text(result);
											}
										);
									}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script>
    var url_bayar = '<?php echo Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasienPenunjang/index"); ?>';
    var url_verifikasi = '<?php echo Yii::app()->controller->createUrl("verifikasiTagihan/index"); ?>';

    function cekStatusPasien(id, instalasi_id) {
        $.post('<?php echo $this->createUrl('cekStatusPasienPenunjang'); ?>', {id: id}, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
            } else {
                 window.location.href = url_bayar + '&instalasi_id=' + instalasi_id + '&pendaftaran_id=' + id;
//                $("#dialogPembayaran iframe").prop('src',url_bayar + '&instalasi_id=' + instalasi_id + '&pendaftaran_id=' + id);
//                $("#dialogPembayaran").dialog("open");
            }
        }, 'json');
    }

    function gotoVerifikasi(id) {
            window.location.href = url_verifikasi + '&pendaftaran_id=' + id;
    }

</script>
