<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan untukmenampilkan form pengeluaran aset
* RSST-1640
*/
?>

<?php 
$i = 0;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'penghapusanaset-t-grid',
    'dataProvider'=>$view->searchPengeluaranAset(),
    //'filter'=>$model,
    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'template'=>"{items}",
    'columns'=>array(
        array(
            'header'=> CHtml::checkBox('pilihSemua',false,array('onclick'=>'cekSemua(this);')).' Pilih Semua',
            'value'=>function($data) use ($model,&$i){
                $model->invperalatan_id = $data->invperalatan_id;
                $model->pengeluaranaset_id = $data->pengeluaranaset_id;
    
                echo CHtml::activeCheckBox($model, '['.$i.']ispilih',array('class'=>'ceklis','invperalatan_id'=>$data->invperalatan_id,'pengeluaranaset_id'=>$data->pengeluaranaset_id,'onclick'=>'pilihData(this);'));                
                echo CHtml::activeHiddenField($model, '['.$i.']invperalatan_id',array('class'=>'readonly'));
                echo CHtml::activeHiddenField($model, '['.$i.']pengeluaranaset_id',array('class'=>'readonly'));
                $i++;
            }
        ),
        array(
            'header'=>'Nama Aset',                                
            'value'=>'$data->invperalatan_namabrg',
        ),
        array(
            'header' => 'No Aset',
            'value'=>'$data->invperalatan_kode',
        ),
        array(
           'header' => 'Merk',
            'value'=>'$data->invperalatan_merk',
        ),
        array(
           'header' => 'Bahan',
            'value'=>'$data->invperalatan_bahan',
        ),
        array(
           'header' => 'Ukuran',
            'value'=>'$data->invperalatan_ukuran',
        ),
        array(
           'header' => 'Tgl Pembelian',
            'value'=> '!empty($data->tglterima)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterima))):""'
        ),
    ),
  'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});        
    }',
)); ?>