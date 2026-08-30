<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Perencanaan Sisa Makanan Rumah Sakit (Comstok/ Recal)</div>
    </div>
    <div class="panel-body" id="tab_riwayat">
        <?php

        $riwayat = new SisamakananpasienT;
        $riwayat->unsetAttributes();
        if (!$kunjungan->isNewRecord) {
            $riwayat->pasienadmisi_id = $kunjungan->pasienadmisi_id;
        } else {
            $riwayat->pasienadmisi_id = 0;
        }

        if (isset($_GET['SisamakananpasienT'])) {
            $riwayat->attributes = $_GET['SisamakananpasienT'];
//            var_dump($_GET); die;
        }

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'riwayatsisamakanan-grid',
            //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
            'dataProvider' => $riwayat->search(),
        //    'filter' => $riwayat,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header'=>'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                            : ($row+1)',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tanggal & Jam Audit',
                    'name'=>'tgl_audit',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return MyFormatter::formatDateTimeForUser($data->tgl_audit)." ".$data->jam_audit;
                    }
                ),
                'hariperawatke',
                array(
                    'name'=>'ruangan_id',
                    'header'=>'Ruangan, Kamar/ No.Bed',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $str = $data->ruangan->ruangan_nama;
                        $masuk = MasukkamarT::model()->findByAttributes(array(
                            'pasienadmisi_id'=>$data->pasienadmisi_id,
                            'ruangan_id'=>$data->ruangan_id
                        ));
                        
                        if (empty($masuk) || empty($masuk->kamarruangan)) {
                            $str .= "";
                        } else {
                            $str .= ", ".($masuk->kamarruangan->kamarruangan_nokamar." Bed-".$masuk->kamarruangan->kamarruangan_nobed);
                        }
                        
                        return $str;
                    }
                ),
                array(
                    'header'=>'Nama Auditor',
                    'name'=>'auditor_id',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return empty($data->auditor) ? "-" : $data->auditor->namaLengkap;
                    }
                ),
                array(
                    'header'=>'Audit Score/ Kesimpulan',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return number_format($data->auditscore_persen, 2, ",", "")."%, ".$data->kesimpulan;
                    }
                ),
                array(
                    'header'=>'Detail',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="icon-form-lihat"></i>', Yii::app()->controller->createUrl('view', array('id'=>$data->sisamakananpasien_id)), array(
                            'target'=>'frameDetail', 'onclick'=>"$('#dialogDetail').dialog('open');"
                        ));
                    }
                ),
                array(
                    'header'=>'Ubah',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('create', array('pasienadmisi_id'=>$data->pasienadmisi_id, 'id'=>$data->sisamakananpasien_id)));
                    }
                ),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'hapusData('.$data->sisamakananpasien_id.'); return false;'));
                    }
                ),
                array(
                    'header'=>'Cetak',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'print('.$data->sisamakananpasien_id.'); return false;'));
                    }
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));


        ?>

    </div>
</div>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe name="frameDetail" width="100%" height="100%"></iframe>';

$this->endWidget();

?>


<script>
    
    function print(id)
    {
        window.open("<?php echo $this->createUrl('print'); ?>&id=" + id + "&caraPrint=PRINT","",'location=_new, width=900px');
    }
    
    function hapusData(id) {
        myConfirm("Anda yakin untuk menghapus catatan ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update("riwayatsisamakanan-grid");
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
</script>