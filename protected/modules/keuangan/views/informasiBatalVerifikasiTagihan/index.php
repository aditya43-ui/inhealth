<?php
$this->breadcrumbs = array(
    'Informasi Batal Verifikasi Tagihan',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Batal Verifikasi Tagihan</b>
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
                <?php echo $this->renderPartial('_search', array(
                    'model'=>$model,
                ), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Batal Verifikasi Tagihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasi_grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-responsive table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header'=>'Tgl. Pendaftaran\<br/>No. Pendaftaran',
                            'name'=>'tgl_pendaftaran',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/</br>"
                                .$data->no_pendaftaran;
                            }
                        ),
                        array(
                            'header'=>'Nama Pasien / No. Rekam Medik / Umur /<br/>Alamat',
                            'name'=>'nama_pasien',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return $data->namadepan.$data->nama_pasien." / "
                                .$data->no_rekam_medik." / "
                                .$data->umur." /<br/>"
                                .$data->alamat_pasien;
                            }
                        ),
                        array(
                            'header'=>'Dokter/<br/>Ruangan',
                            'name'=>'nama_pegawai',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return $data->gelardepan.$data->nama_pegawai.(empty($data->gelarbelakang_id) ? "" : (", ".$data->gelarbelakang_nama))."/<br/>"
                                .$data->ruangan_nama;
                            }
                        ),
                        array(
                            'header'=>'Jenis Penjamin/<br/>Penjamin',
                            'name'=>'carabayar_nama',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return $data->carabayar_nama."/<br/>"
                                .$data->penjamin_nama;
                            }
                        ),
                        array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link('<i class="icon-form-rincianbayar"></i>', Yii::app()->controller->createUrl('detail', array(
                                    'pendaftaran_id'=>$data->pendaftaran_id,
                                    'petugasbatal_id'=>$data->petugasbatal_id
                                )), array(
                                    'target'=>'frameDetailBatal',
                                    'onclick'=>"$('#dialogDetailBatal').dialog('open');"
                                ));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;'
                            ),
                        ),
                        array(
                            'header'=>'Petugas Batal',
                            'name'=>'petugasbatal_nama',
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
    'id' => 'dialogDetailBatal',
    'options' => array(
        'title' => 'Detail Batal Verifikasi Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 460,
    ),
));
?>
<iframe src="" name="frameDetailBatal" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>