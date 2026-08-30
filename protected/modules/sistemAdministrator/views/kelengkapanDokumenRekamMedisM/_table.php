<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kelengkapandokumen-m-grid',
    'overflowx' => true,
    'dataProvider' => $model->search(),
    //'filter'=>$model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped datatable',
    'columns' => array(
        'jenisdokumen',
        'nama_dokumen',
        'urutan_dokumen',
        'level_dokumen',
        'kelompok_dokumen',
        'tipe',
        [
            'header' => 'Status',
            'type' => 'raw',
            'value' => function ($data) {
                if($data->kelengkapandokumen_aktif) {
                    echo 'Aktif';
                } else {
                    echo 'Tidak Aktif';
                }
            }
        ],
        array(
            'header' => 'Lihat',
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'template' => '{view}',
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link("<i class='icon-form-ubah'></i> ", $this->createUrl('create', ['id' => $data->kelengkapandokumen_rm_id]),array("id"=>"$data->kelengkapandokumen_rm_id"));
            }
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                if($data->kelengkapandokumen_aktif) {
                    return CHtml::link("<i class='icon-form-silang'></i> ","javascript:ubahStatus($data->kelengkapandokumen_rm_id, 'menonaktifkan')",array("id"=>"$data->kelengkapandokumen_rm_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->kelengkapandokumen_rm_id)",array("id"=>"$data->kelengkapandokumen_rm_id","rel"=>"tooltip","title"=>"Hapus"));
                } else {
                    return CHtml::link("<i class='icon-form-check'></i> ","javascript:ubahStatus($data->kelengkapandokumen_rm_id, 'aktifkan')",array("id"=>"$data->kelengkapandokumen_rm_id","rel"=>"tooltip","title"=>"Mengaktifkan"))." ".CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->kelengkapandokumen_rm_id)",array("id"=>"$data->kelengkapandokumen_rm_id","rel"=>"tooltip","title"=>"Hapus"));
                }
                
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
        ),        
    ),
    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                            $("table").find("input[type=text]").each(function(){
                                cekForm(this);
                            })
                            $("table").find("select").each(function(){
                                cekForm(this);
                            })
                        }',
    )
); 
?>