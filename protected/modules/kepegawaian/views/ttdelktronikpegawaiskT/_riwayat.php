<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Riwayat SK Direktur Tanda Tangan Elektronik</div>
        </div>
        <div class="panel-body">
            <?php 
            $prov = $riwayat->search();
            $prov->sort->defaultOrder = 'ttdelktronikpegawaisk_id';
            $prov->pagination->pageSize = 5;
            
            $this->widget('ext.bootstrap.widgets.BootGridView',array( 
                'id'=>'riwayat-sk-grid', 
                'dataProvider'=>$prov,
                'template'=>"{summary}\n{items}\n{pager}", 
                'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
                'columns'=>array( 
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    'nomor_sk',
                    array(
                        'header'=>'Masa Berlaku',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return MyFormatter::formatDateTimeForUser($data->tglberlaku_awal)
                                            ." s/d ".MyFormatter::formatDateTimeForUser($data->tglberlaku_akhir);
                        }
                    ),
                    array(
                        'header'=>'Status Masa Berlaku',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return $data->statusAktif ? "AKTIF" : "NON AKTIF";
                        }
                    ),
                    array(
                        'header'=>'Ubah',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('create', array('id'=>$data->pegawai_id, 'ttd_id'=>$data->ttdelktronikpegawaisk_id)));
                        }
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>"hapusData(this, ".$data->ttdelktronikpegawaisk_id."); return false;"));
                        }
                    ),
                ), 
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
            )); ?> 
            
        </div>
    </div>
</div>

<script>
    
    function hapusData(obj, id) {
        myConfirm("Anda yakin untuk menghapus SK ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayat-sk-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
</script>
