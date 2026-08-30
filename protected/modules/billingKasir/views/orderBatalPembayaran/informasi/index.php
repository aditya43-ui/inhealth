<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <strong>Order Batal Pembayaran Tagihan</strong></div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . "informasi/_search", array(
            'model'=>$model,
        ), true); ?>
        <br/>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-credit-card"></i> Tabel Order Batal Pembayaran Tagihan</div>
            </div>
            <div class="panel-body">
            <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasiorderbaralalokasi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header'=>'Tgl. Order',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return MyFormatter::formatDateTimeForUser($data->create_time);
                            }
                        ),
                        array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link('<i class="icon-form-rincianbayar"></i>', Yii::app()->controller->createUrl('/billingKasir/batalAlokasiDana/detailAlokasi', array(
                                    'id'=>$data->alokasidana_id
                                )), array(
                                    'target'=>'frameDetailAlokasi',
                                    'onclick'=>"$('#dialogDetailAlokasi').dialog('open');"
                                ));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;'
                            ),
                        ),
                        array(
                            'header'=>'Tgl. Pendaftaran/</br>No. Pendaftaran',
                            'name'=>'tgl_pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran',
                        ),
                        
                        array(
                            'header'=>'Nama Pasien',
                            'name'=>'nama_pasien',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return $data->nama_pasien;
                            }
                        ),
                        array(
                            'header'=>'Jenis Penjamin/</br>Penjamin',
                            'name'=>'penjamin_nama',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return $data->carabayar_nama."/<br/>".$data->penjamin_nama;
                            }
                        ),
                        array(
                            'header'=>'Verifikator',
                            'name'=>'nama_petugas',
                        ),
                        array(
                            'header'=>'Aksi',
                            'type'=>'raw',
                            'value'=>function($data) {

                                if ($data->is_verifikasi == true) {
                                    return CHtml::htmlButton('SUDAH DIBATALKAN<br/>PEMBAYARAN', array(
                                        'class'=>'btn btn-warning',
                                    ));
                                }

                                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                                    'onclick'=>"verifikasiBatalPembayaran(this, ".$data->orderbatalpembayaranpelayanan_id."); return false;",
                                ));

                                /*
                                $alo = AlokasidanaT::model()->findByPk($data->alokasidana_id);

                                $tindakan = AlokasidanadetailtindakanT::model()->countByAttributes(array(
                                    'alokasidana_id'=>$alo->alokasidana_id
                                ), array(
                                    'condition'=>'orderbatalalokasi_id is not null'
                                ));
                                $oa = AlokasidanadetailoaT::model()->countByAttributes(array(
                                    'alokasidana_id'=>$alo->alokasidana_id
                                ), array(
                                    'condition'=>'orderbatalalokasi_id is not null'
                                ));

                                if (($tindakan + $oa) > 0) {
                                    return CHtml::htmlButton('SUDAH DILAKUKAN<br/>PEMBATALAN', array(
                                        'class'=>'btn btn-warning',
                                    ));
                                }


                                if (!empty($alo->orderbatalpembayaranpelayanan_id)) {
                                    return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                                        'onclick'=>"myAlert('Data Alokasi sudah dilakukan Pembayaran'); return false;",
                                    ));
                                } else {
                                    return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                                        'onclick'=>"verifikasiBatalAlokasi(this, ".$data->alokasidana_id.", ".$data->orderbatalalokasi_id."); return false;",
                                    ));
                                }
                                */
                                return "-";
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center',
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
            ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailAlokasi',
    'options' => array(
        'title' => 'Detail Order Batal Alokasi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 460,
    ),
));
?>
<iframe src="" name="frameDetailAlokasi" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<script>
    function verifikasiBatalPembayaran(obj, orderbatalpembayaranpelayanan_id) {
        var td_icon = $(obj).parents("td");

        td_icon.addClass("animation-loading");
        $.post('<?php echo $this->createUrl("verifikasi"); ?>', {
            orderbatalpembayaranpelayanan_id: orderbatalpembayaranpelayanan_id
        }, function(data) {
            td_icon.removeClass("animation-loading");
            if (data.ok == 1) {
                myAlert(data.msg);
                $.fn.yiiGridView.update('informasiorderbaralalokasi-grid');
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }
</script>