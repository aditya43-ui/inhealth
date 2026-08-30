<?php

$mod = new KesejahteraanibuT;
$mod->unsetAttributes();
$mod->partografpasien_id = $model->partografpasien_id;

$col = array(
    'pemeriksaanke',
    array(
        'name'=>'tgl_pemeriksaan',
        'type'=>'raw',
        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan)',
    ),
    'jam_pemeriksaan',
    array(
        'name'=>'petugaspemeriksa_id',
        'type'=>'raw',
        'value'=>function($data) {
            return empty($data->petugaspemeriksa) ? "-" : $data->petugaspemeriksa->namaLengkap;
        }
    ),
    array(
        'header'=>'Tekanan Darah (mmHg)',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {
            $tekanan = KesejahteraanibunaditdT::model()->findByAttributes(array(
                'kesejahteraanibu_id'=>$data->kesejahteraanibu_id,
            ));

            if (empty($tekanan)) {
                return "-";
            }

            return $tekanan->td_systolic."/".$tekanan->td_diastolic;
        }
    ),    
    array(
        'header'=>'Nadi (x/Menit)',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {

            if (empty($tekanan)) {
                return "-";
            }

            return $tekanan->nadi;
        }
    ),    
    array(
        'header'=>'Suhu (&deg;C)',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {
            $tekanan = KesejahteraanibusuhuT::model()->findByAttributes(array(
                'kesejahteraanibu_id'=>$data->kesejahteraanibu_id,
            ));

            if (empty($tekanan)) {
                return "-";
            }

            return number_format($tekanan->suhutubuh, 2, ",", "");
        }
    ),    

    array(
        'header'=>'Oksitosin U/L',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {
            $tekanan = KesejahteraanibuoksitosinT::model()->findByAttributes(array(
                'kesejahteraanibu_id'=>$data->kesejahteraanibu_id,
            ));

            if (empty($tekanan)) {
                return "-";
            }

            return $tekanan->oksitosin_ul." miliunit";
        }
    ),    
    array(
        'header'=>'Lolol/Menit',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {

            if (empty($tekanan)) {
                return "-";
            }

            return $tekanan->oksitosin_lolos;
        }
    ),    
    array(
        'header'=>'Obat/Cairan IV',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {

            $tekanan = ObatpartografT::model()->findAllByAttributes(array(
                'kesejahteraanibu_id'=>$data->kesejahteraanibu_id,
            ));

            if (empty($tekanan) || !is_array($tekanan) || count($tekanan) == 0) {
                return "-";
            }

            $str = "<ul>";
            foreach ($tekanan as $item) {
                echo "<li>".$item->obatalkes->obatalkes_nama.", ".$item->qty_obat."</li>";
            }
            $str = "</ul>";

            return $str;
        }
    ),    

    array(
        'header'=>'Protein',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {
            $tekanan = KesejahteraanibuurineT::model()->findByAttributes(array(
                'kesejahteraanibu_id'=>$data->kesejahteraanibu_id,
            ));

            if (empty($tekanan)) {
                return "-";
            }

            return $tekanan->urine_protein;
        }
    ),  
    array(
        'header'=>'Aseton',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {

            if (empty($tekanan)) {
                return "-";
            }

            return $tekanan->urine_aseton;
        }
    ),  
    array(
        'header'=>'Volume',
        'type'=>'raw',
        'value'=>function($data) use (&$tekanan) {

            if (empty($tekanan)) {
                return "-";
            }

            return number_format($tekanan->urine_volume, 2, ",", "")." ml";
        }
    ),
);

    
if (empty($is_detail) || $is_detail != 1) {
    array_push($col, array(
        'header'=>'Ubah',
        'type'=>'raw',
        'value'=>function($data) use ($pendaftaran_id) {
            return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', Yii::app()->controller->createUrl('create', array('pendaftaran_id'=>$pendaftaran_id, 'id'=>$data->kesejahteraanibu_id)));
        },
        'htmlOptions'=>array(
            'style'=>'text-align: center; width: 80px;',
        ),
    ),
    array(
        'header'=>'Hapus',
        'type'=>'raw',
        'value'=>function($data) {
            return CHtml::link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
                'onclick'=>'hapusData('.$data->kesejahteraanibu_id.'); return false;',
            ));
        },
        'htmlOptions'=>array(
            'style'=>'text-align: center; width: 80px;',
        ),
    ));
}


$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'kesejahteraan-ibu-grid',
    'dataProvider' => $model->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'mergeHeaders'=>array(
        array(
            'name'=>'<center>Urine</center>',
            'start'=>10, //indeks kolom 3
            'end'=>12, //indeks kolom 4
        ),
    ),
    'columns' => $col,
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));



?>


<script>
    
    function hapusData(id) {
        
        myConfirm('Anda yakin untuk menghapus data ini ?', 'Peringatan', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('kesejahteraan-ibu-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
</script>
