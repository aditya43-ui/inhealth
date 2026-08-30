<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->search();
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data->pagination = false;
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(
        array(
            'header' => 'No',
            'value' => $row,
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        [
            'header' => 'Tanggal Pembuatan PRB',
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tglbuat_prb);
            }
        ],
        [
            'header' => 'No Pendaftaran/<br/>No Rekam Medik',
            'type' => 'raw',
            'value' => '$data->no_pendaftaran."/<br/>".$data->no_rekam_medik'
        ],
        'nokartuasuransi',
        'nosep',
        [
            'header' => 'No SRB/<br/>Tanggal SRB',
            'type' => 'raw',
            'value' => '$data->nosrb."/<br/>".(!empty($data->tglsrb)?MyFormatter::formatDateTimeForUser($data->tglsrb):"")'
        ],
        'nama_pasien',
        [
            'header' => 'Jenis Pelayanan/ Ruangan',
            'type' => 'raw',
            'value' => '(($data->jnspelayanan == 2)?"Rawat Jalan":"Rawat Inap")."/<br/>".$data->ruangan_nama'
        ],
        [
            'header' => 'Asal Faskes',
            'name' => 'namaperujuk'
        ],
        [
            'header' => '<center>Detail</center>',
            'type' => 'raw',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return CHtml::link('<i class="icon-form-mata"></i>',$this->createUrl('detail',['id'=>$data->programrujukbalikpasien_id]),['rel'=>'tooltip','title'=>'melihat detail prb']);
            }
        ],
        [
            'header' => '<center>Print</center>',
            'type' => 'raw',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return CHtml::link('<i class="icon-form-print"></i>','#',['rel'=>'tooltip','title'=>'cetak detail prb', 'onclick'=>'printPRB('.$data->programrujukbalikpasien_id.'); return false;']);
            }
        ],
        [
            'header' => '<center>Ubah</center>',
            'type' => 'raw',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return CHtml::link('<i class="icon-form-ubah"></i>',$this->createUrl('ubah',['id'=>$data->programrujukbalikpasien_id]),['rel'=>'tooltip','title'=>'ubah data prb']);
            }
        ],
        [
            'header' => '<center>Hapus</center>',
            'type' => 'raw',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return CHtml::link('<i class="icon-form-sampah"></i>','javascript:;',['rel'=>'tooltip','title'=>'menghapus data prb', 'onclick'=>'hapusPRB('.$data->programrujukbalikpasien_id.'); return false;']);
            }
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                    cekForm(this);
            });
             $("table").find("select").each(function(){
                    cekForm(this);
            });           
    }',
));
?>

<script>

function hapusPRB(id) {
    myConfirm("Anda yakin untuk menghapus data Program Rujuk Balik ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapus'); ?>', {id: id}, function(data) {
                if (data.ok == 1) {
                    myAlert(data.msg);
                    $.fn.yiiGridView.update('sajenis-kelas-m-grid');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

function printPRB(id) {
    window.open("<?php echo $this->createUrl('printPRBBPJS'); ?>" + "&id=" + id + "&caraPrint=PRINT","",'location=_new, width=900px');
}

</script>