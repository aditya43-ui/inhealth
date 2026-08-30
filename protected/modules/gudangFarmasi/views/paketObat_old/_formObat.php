<div class="panel-body">
    <div class="control-group ">
        <?php echo CHtml::label('Obat Alkes', 'obatalkes', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php 
                echo Chtml::activeHiddenField($modDetail,'obatalkes_id',array());
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modDetail,
                                'attribute'=>'obatalkes_nama',
                                'source'=>'js: function(request, response) {
                                        $.ajax({
                                                url: "'.$this->createUrl('AutocompleteObatalkes').'",
                                                dataType: "json",
                                                data: {
                                                        term: request.term,
                                                },
                                                success: function (data) {
                                                        response(data);
                                                }
                                        })
                                }',
                                'options'=>array(
                                        'minLength' => 2,
                                        'focus'=> 'js:function( event, ui ) {
                                                $(this).val( "");
                                                return false;
                                        }',
                                        'select'=>'js:function( event, ui ) {
                                                $(this).val( ui.item.label);
                                                $("#obatalkes_id").val(ui.item.value);
                                                return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogObatAlkes'),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Obat Alkes','class'=>'span3 all-caps pegawaishift_nama','rel'=>'tooltip','title'=>'Ketik Nama Obat',
                                        'onkeyup'=>"return $(this).focusNextInputField(event)",       
                                    'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                                ),
                        )); 
                ?>
        </div>
        <div class="controls">
                <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                        array('onclick'=>'tambahObat();return false;',
                        'class'=>'btn btn-primary',
                        'onkeypress'=>"tambahObat();return false;",
                        'rel'=>"tooltip",
                        'title'=>"Klik untuk menambahkan daftar obat alkes",)); ?>
        </div>
    </div>
    <table class="items table table-bordered table-striped table-condensed" id="table-obat">
        <thead>
            <th>No</th>
            <th>Obat Alkes</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php                
                if((!empty($model->paketobat_id))){
                    $modDetail = GFPaketobatdetailM::model()->findAll(" paketobat_id = ".$model->paketobat_id." ");
                    if(!empty($modDetail)){
                        $i=1;
                        foreach($modDetail as $detail){
                            $obatalkes = ObatalkesM::model()->findByPk($detail->obatalkes_id);
                            $detail->obatalkes_nama = $obatalkes->obatalkes_nama;
                            $detail->satuankecil_nama = !empty($detail->satuankecil_id)?$detail->satuankecil->satuankecil_nama:null;
                            $detail->jumlah = number_format((float)$detail->jumlah,2,",","");
                            echo $this->renderPartial($this->path_view.'_rowDetailObat',array('modDetail'=>$detail,'i'=>$i), true);
                            $i++;
                        }
                    }
                }
            ?>
        </tbody>
    </table>
    <table class="hide" id="table-obat-hapus">
        <tbody>
        </tbody>
    </table>
</div>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogObatAlkes',
        'options'=>array(
            'title'=>'Pencarian Obat Alkes',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modObatalkes = new ObatalkesM;
    $modObatalkes->unsetAttributes();
    if (isset($_GET['ObatalkesM'])) {
        $modObatalkes->attributes = $_GET['ObatalkesM'];      
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'obatalkes-grid',
        'dataProvider'=>$modObatalkes->searchObatFarmasi(),
        'filter'=>$modObatalkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data){
                    echo CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => ''
                        . '$("#obatalkes_id").val("'.$data->obatalkes_id.'");'
                        . '$("#obatalkes_nama").val("'.$data->obatalkes_nama.'");'
                        . '$("#dialogObatAlkes").dialog("close");',
                     ));
                },
            ),
            array(
                'header'=>'Kode Obat',
                'name' => 'obatalkes_kode',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Nama Obat',
                'name' => 'obatalkes_nama',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Jenis',
                'name' => 'jenisobatalkes_id',
                'value'=>'(isset($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
                'filter' => CHtml::dropDownList('ObatalkesM[jenisobatalkes_id]', $modObatalkes->jenisobatalkes_id, CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --'))
            ),
            array(
                'header'=>'Kategori',
                'name' => 'obatalkes_kategori',
                'value'=>'$data->obatalkes_kategori',
                'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_kategori]', $modObatalkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
            ),
            array(
                'header'=>'Golongan',
                'name' => 'obatalkes_golongan',
                'value'=>'$data->obatalkes_golongan',
                'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_golongan]', $modObatalkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>