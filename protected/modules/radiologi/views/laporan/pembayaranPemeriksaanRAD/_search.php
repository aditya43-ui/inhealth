<div class="search-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'searchLaporan',
        'type' => 'horizontal',
    )); ?>
    <div class="row">
        <div class="col-sm-12">
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
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>
                <div class="control-group">
                    ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                    <div class="controls">												 
                        ' . $form->dropDownList(
                    $model,
                    'penjamin_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                    </div>
                </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'carabayar',
            //     'slide' => true,
            //     'content' => array(
            //         'content1' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Jenis Penjamin',
            //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            // 						' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
            // 						<div class="controls">
            // 							' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            // 						</div>
            // 					</div>
            // 					<div class="control-group">
            // 						' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
            // 						<div class="controls">												 
            // 							' . $form->dropDownList(
            //                     $model,
            //                     'penjamin_id',
            //                     array(),
            //                     array('class' => 'form-control', 'multiple' => 'multiple')
            //                 ) . '
            // 						</div>
            // 					</div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));

            echo CHtml::hiddenField('filter', 'tindakansudahbayar_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Status Bayar', 'tindakansudahbayar_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>';
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Dokter Pemeriksa', 'carabayar_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'pegawai_id', Chtml::listData(DokterV::model()->findAll("ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' "), 'pegawai_id', 'namaLengkap'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>';
            ?>

            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <?php
                    echo '<table>
                <tr>
                    <td style="width: 120px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                               
                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'dokter', 'id' => 'rdokter',)) . ' <label for="rdokter">Dokter</label></td>                                               
                </tr>
                <tr>
                    <td>' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'status', 'id' => 'rstatus',)) . ' <label for="rstatus">Status Bayar</label></td>                                                                                            
                </tr>
            </table>';
                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'dokter',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content2' => array(
                    //             'multi' => 'multi',
                    //             'header' => 'Berdasarkan Dokter Pemeriksa',
                    //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                    //                 '<div class="control-group">
                    // 						' . CHtml::label('Dokter Pemeriksa', 'carabayar_id', array('class' => 'control-label')) . ' 
                    // 						<div class="controls">
                    // 							' . $form->dropDownList($model, 'pegawai_id', Chtml::listData(DokterV::model()->findAll("ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' "), 'pegawai_id', 'namaLengkap'), array(
                    //                     'class' => 'form-control', 'multiple' => 'multiple'
                    //                 )) . '
                    // 						</div>
                    // 					</div>',
                    //             'active' => true,
                    //         ),
                    //     ),
                    // ));
                    ?>
                </div>
            </div>
        </div>
        <!--<div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'status',
                'slide' => true,
                'content' => array(
                    'content3' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Status Bayar',
                        'isi' => CHtml::hiddenField('filter', 'tindakansudahbayar_id', array('disabled' => 'disabled')) .
                            '<div class="control-group">
									' . CHtml::label('Status Bayar', 'tindakansudahbayar_id', array('class' => 'control-label')) . ' 
									<div class="controls">
										' . $form->dropDownList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
									</div>
								</div>',
                        'active' => true,
                    ),
                ),
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'grafik',
                'slide' => true,
                'content' => array(
                    'content4' => array(
                        'header' => 'Opsi Grafik',
                        'isi' =>
                        '<table>
									<tr>
										<td style="width: 120px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                               
										<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'dokter', 'id' => 'rdokter',)) . ' <label for="rdokter">Dokter</label></td>                                               
									</tr>
									<tr>
										<td>' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'status', 'id' => 'rstatus',)) . ' <label for="rstatus">Status Bayar</label></td>                                                                                            
									</tr>
								</table>',
                        'active' => TRUE,
                    ),
                ),
            ));
            ?>
        </div>-->
    </div>
    <?php
    //				$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    //					'id'=>'dokter',
    //					'slide'=>true,
    //					'content'=>array(
    //						'content3'=>array(
    //							'header'=>'Berdasarkan Dokter Pemeriksa',
    //							'isi'=> /*'<table >
    //										<tr>
    //										<td >'.CHtml::hiddenField('namadokter')
    //										.'<div class="input-append"><span class="add-on">'.$form->textField($model, 'nama_pegawai', array('id'=>'dokternama','data-offset-top'=>200,'data-spy'=>'affix','style'=>'margin-top:-3px; margin-left:-3px','inline'=>false, 
    //										'onkeypress' => "return $(this).focusNextInputField(event)",'sourceUrl'=> $this->createUrl('/ActionDynamic/DaftarDokter/'),'placeholder'=>'Nama Dokter')).'<a href="javascript:void(0);" id="tombolDokterDialog" onclick="$(&quot;#dialogDokter&quot;).dialog(&quot;open&quot;);return false;">
    //									<i class="icon-list"></i>
    //									<i class="entypo-search">
    //									</i>
    //									</a>
    //									</span>
    //									</div></td></tr></table>',*/
    //									'<table>'.$form->dropDownList($model,'pegawai_id', Chtml::listData(DokterV::model()->findAll("ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' "), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --')).'</table>',
    //
    //							'active'=>true,
    //							),
    //					),
    //					'htmlOptions'=>array('class'=>'aw',)
    //			));
    //
    //
    //		echo CHtml::hiddenField('idSupplier');  
    ?>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
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

$modDokter = new RODokterV;
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['RODokterV'])) {
    $modDokter->attributes = $_GET['RODokterV'];
    $modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modDokter->searchDialogPegawai(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
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
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>

<script>
    $(document).ready(function() {
        jQuery('#dokternama').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#dokternama").val(ui.item.nama_pegawai);
                $("#ROLaporanrekaptransaksi_nama_pegawai").val(ui.item.nama_pegawai);
                return false;
            },
            'select': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#namadokter").val(ui.item.pegawai_id);
                return false;
            },
            'source': '<?php echo $this->createUrl('/ActionAutoComplete/DaftarDokter/'); ?>'
        });
    });
</script>