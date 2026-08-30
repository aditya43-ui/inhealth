<div class="search-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'searchLaporan',
        'type' => 'horizontal',
    )); ?>
    <style>
        #penjamin label.checkbox {
            width: 200px;
            display: inline-block;
        }

        label.checkbox,
        label.radio {
            width: 260px;
            display: inline-block;
        }
    </style>
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
            //                     ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
            //                     <div class="controls">
            //                         ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            //                     </div>
            //                 </div>
            //                 <div class="control-group">
            //                     ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
            //                     <div class="controls">												 
            //                         ' . $form->dropDownList(
            //                     $model,
            //                     'penjamin_id',
            //                     array(),
            //                     array('class' => 'form-control', 'multiple' => 'multiple')
            //                 ) . '
            //                     </div>
            //                 </div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            //				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //					'id' => 'institusi',
            //					'slide' => true,
            //					'content' => array(
            //						'content2' => array(
            //							'multi' => 'multi',
            //							'header' => 'Berdasarkan Tindakan',
            //							'isi' => CHtml::hiddenField('filter', 'daftartindakan_id', array('disabled' => 'disabled')) . 
            //								'<div class="control-group">
            //									'.CHtml::label('Tindakan','daftartindakan_id', array('class' => 'control-label')).' 
            //									<div class="controls">
            //										'.$form->dropDownList($model, 'daftartindakan_id', CHtml::listData($model->getDaftarTindakanItems(),'daftartindakan_id', 'daftartindakan_nama'),array(
            //										'class'=>'form-control', 'multiple'=>'multiple')).'											
            //									</div>
            //								</div>',
            //							'active' => true,
            //						),
            //					),
            //				));
            ?>

            <div class="control-group">
                <label class="control-label">Uraian Tindakan</label>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'daftartindakan_id')
                        . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'daftartindakan_nama', array(
                            'id' => 'daftartindakan', 'data-offset-top' => 200, 'data-spy' => 'affix', 'inline' => false,
                            'onblur' => 'IdKosong(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'sourceUrl' => $this->createUrl('/ActionDynamic/DaftarDokter/'), 'placeholder' => 'Uraian Tindakan'
                        )) . '<a href="javascript:void(0);" id="tombolDokterDialog" onclick="$(&quot;#dialogDokter&quot;).dialog(&quot;open&quot;);return false;">
                            <i class="icon-list"></i>
                            <i class="entypo-search"></i>
                            </a>
                        </span>
                    </div>';
                    ?>

                    <?php
                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'dokter',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content2' => array(
                    //             'header' => 'Berdasarkan Tindakan',
                    //             'isi' =>
                    //             '<table >
                    // 					<tr>
                    // 						<td >' . $form->hiddenField($model, 'daftartindakan_id')
                    //                 . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'daftartindakan_nama', array(
                    //                     'id' => 'daftartindakan', 'data-offset-top' => 200, 'data-spy' => 'affix', 'inline' => false,
                    //                     'onblur' => 'IdKosong(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'sourceUrl' => $this->createUrl('/ActionDynamic/DaftarDokter/'), 'placeholder' => 'Uraian Tindakan'
                    //                 )) . '<a href="javascript:void(0);" id="tombolDokterDialog" onclick="$(&quot;#dialogDokter&quot;).dialog(&quot;open&quot;);return false;">
                    // 									<i class="icon-list"></i>
                    // 									<i class="entypo-search"></i>
                    // 									</a>
                    // 								</span>
                    // 							</div>
                    // 						</td>
                    // 					</tr>
                    // 				</table>',
                    //             'active' => true,
                    //         ),
                    //     ),
                    //     'htmlOptions' => array('class' => 'aw',)
                    // ));
                    echo CHtml::hiddenField('idSupplier');
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <?php
                    echo '<table>
                    <tr>
                        <td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                               
                         <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'tindakan', 'id' => 'rtindakan',)) . ' <label for="rtindakan">Tindakan</label></td>
                    </tr>									
                </table>';

                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'grafik',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content3' => array(
                    //             'header' => 'Opsi Grafik',
                    //             'isi' =>  '<table>
                    // 				<tr>
                    // 					<td style="width: 100px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                               
                    // 					 <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'tindakan', 'id' => 'rtindakan',)) . ' <label for="rtindakan">Tindakan</label></td>
                    // 				</tr>									
                    // 			</table>',
                    //             'active' => TRUE,
                    //         ),
                    //     ),
                    // ));
                    ?>
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
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTindakan = new ROTindakanRuanganM;
if (isset($_GET['ROTindakanRuanganM'])) {
    $modTindakan->attributes = $_GET['ROTindakanRuanganM'];
    $modTindakan->daftartindakan_kode = $_GET['ROTindakanRuanganM']['daftartindakan_kode'];
    $modTindakan->daftartindakan_nama = $_GET['ROTindakanRuanganM']['daftartindakan_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modTindakan->searchTindakanRuangan(),
    'filter' => $modTindakan,
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
                                                      $(\"#ROLaporanrekaptransaksi_daftartindakan_id\").val(\"$data->daftartindakan_id\");
                                                      $(\"#daftartindakan\").val(\"$data->NamaTindakan\");
                                                      $(\"#dialogDokter\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'Kode Tindakan',
            'name' => 'daftartindakan_kode',
            'value' => '$data->daftartindakan->daftartindakan_kode',
            'filter' => Chtml::activeTextField($modTindakan, 'daftartindakan_kode', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Daftar Tindakan',
            'name' => 'daftartindakan_nama',
            'value' => '$data->daftartindakan->daftartindakan_nama',
            'filter' => Chtml::activeTextField($modTindakan, 'daftartindakan_nama', array('class' => 'custom-only'))
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
    //$(document).ready(function(){
    /*jQuery('#dokternama').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
        $("#idSupplier").val( ui.item.pegawai_id);
        $("#dokternama").val( ui.item.nama_pegawai );
        $("#ROLaporanrekaptransaksi_nama_pegawai").val( ui.item.nama_pegawai );
        return false;
        },'select':function( event, ui ) {
        $("#idSupplier").val( ui.item.pegawai_id);
        $("#namadokter").val( ui.item.pegawai_id);
        return false;
        },'source':'<?php //echo $this->createUrl('/ActionAutoComplete/DaftarDokter/'); 
                    ?>'}); */

    //});

    function IdKosong(obj) {
        //alert(obj.value);
        //$("#ROLaporanrekaptransaksi_daftartindakan_id").val('');
        if (obj.value == '') {
            $("#ROLaporanrekaptransaksi_daftartindakan_id").val('');
        }
    }
</script>
<?php //$this->renderPartial('_jsFunctions', array('model'=>$model));
?>