<?php
echo CHtml::css('#isiScroll{max-height:300px;overflow-y:scroll;margin-bottom:10px;}');
?>
<!--search-form-->
<div id="form-carikata">
    <?php echo CHtml::textField('carikata', "", array('onkeyup' => 'return $(this).focusNextInputField(event);', 'onblur' => 'cariKata();', 'placeholder' => 'Kata yang Akan Dicari')) ?>
    <?php echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-primary', 'onclick' => 'cariKata();',)) ?>
    <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default', 'onclick' => 'resetCariKata();')) ?>
</div>

<!--<div id='isiScroll'>-->
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObat->searchObatFormulirStokOpname(), //RND-6228
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuaobat',false,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
            'type'=>'raw',
            'value'=>'
                CHtml::hiddenField("GFFormstokopnameR[".$data->obatalkes_id."][obatalkes_id]",$data->obatalkes_id, array("class" => "obatalkes_id")).
                CHtml::checkBox("GFFormstokopnameR[".$data->obatalkes_id."][cekList]", false, array("class"=>"cekList", "onclick"=>"set_row(this); getTotal();  setNol(this)", "onkeyup"=>"return $(this).focusNextInputField(event);"));
                ',
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'value' => 'isset($data->jenisobatalkes_nama)?$data->jenisobatalkes_nama:""',
        ),
        'obatalkes_kode',
        array(
            'header' => 'Nama Obat',
            'type' => 'raw',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header' => 'Golongan/<br>Kategori',
            'type' => 'raw',
            'value' => '$data->obatalkes_golongan.\'<br>\'."/ ".$data->obatalkes_kategori',
        ),
        array(
            'header' => 'Satuan Kecil',
            'type' => 'raw',
            'value' => '$data->satuankecil_nama',
        ),
        array(
            'header' => 'HPP',
            'type' => 'raw',
            'value' => 'CHtml::textField(\'harga\', number_format($data->hpp,0,"","."), array(\'class\'=>\'span2 integer-decimal\', \'readonly\'=>true))'
        ),
        array(
            'header' => 'Stok Sistem',
            'type' => 'raw',
            'value' => 'CHtml::textField(\'stok\', number_format($data->getStokObatRuangan(),0,"","."),array(\'class\'=>\'stok span1 integer2\', \'readonly\'=>true))',
        ),
        array(
            'header' => 'Tanggal Kadaluarsa',
            'type' => 'raw',
            'value' => function ($data){
                // return $data->getTglKadaluarsa($data->obatalkes_id);
                $obat = StokobatalkesT::model()->findByAttributes(['obatalkes_id' => $data->obatalkes_id], ['order'=>'tglkadaluarsa DESC']);
                return !empty($obat->tglkadaluarsa) ? $obat->tglkadaluarsa : "-" ;
            },
        ),
        array(
            'header'=>'Rak Obat',
            'type'=>'raw',
            'footerHtmlOptions'=>array(),
            'footer'=>'&nbsp;',
            'value' => function ($data) {
                $rakobat_id = !empty($data->rakobat_id) ? $data->rakobat_id : null; 

               echo CHtml::dropDownList("GFFormstokopnameR[".$data->obatalkes_id."][rakobat_id]", $rakobat_id, 
               CHtml::listData(RakobatM::model()->findAll("rakobat_aktif = true and ruangan_id = ".Yii::app()->user->getState('ruangan_id')." ORDER BY rakobat_nama ASC"), 'rakobat_id', 'rakobat_nama'), array("class"=>"span2 rakobat_id", "onchange"=>"set_value(this);", 'empty' => '-- Pilih --', "onkeyup"=>"return $(this).focusNextInputField(event);"));
               echo CHtml::hiddenField("GFFormstokopnameR[".$data->obatalkes_id."][penyimpananobat_id]", !empty($data->penyimpananobat_id) ? $data->penyimpananobat_id : "", array("class"=>"span2 penyimpananobat_id","onkeyup"=>"return $(this).focusNextInputField(event);"));
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    getTotal();
					setTanggalSistem();
                    set_checklist();
                    renameInputRowObatAlkes();


                }',
)); ?>
<!--</div>-->