<?php
/** 
 * view ini digunakan untuk menampilkan data dialog
 * 
 * @author      M Iqbal Laksana <iqballaksana@.com>
 * @version     2.0.0 
 * @link      <http://172.9.1.15/simpp/docs/>
 */
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDaftarTanda',
            'options'=>array(
                'title'=>'Pencarian Daftar Tanda Gejala' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	            
    $modHasilDaftar = new TandagejalaDaftarM('searchDialogDPA');
    $modHasilDaftar->unsetAttributes();
    if (isset($_GET['TandagejalaDaftarM'])) {
        $modHasilDaftar->attributes = $_GET['TandagejalaDaftarM'];        
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'kreiteriahasildaftar-m-grid',
        'dataProvider' => $modHasilDaftar->searchDialog(),
        'filter' => $modHasilDaftar,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',                
                'value'=>function($data) {
                        $load = $data->attributes;                            
                        $res = json_encode($load);

                        return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                "onclick" => 'setDaftar('.$res.');'));
                    },
            ),
            array(
                'header' => 'No. ',
                'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:center; width:5px;'),
            ),
            array(
                'header' => 'Nama Tanda Gejala',
                'type' => 'raw',
                'name' => 'tandagejala_daftar_nama',                                
            ),
            array(
                'header' => 'Nama Lain Tanda Gejala',
                'type' => 'raw',
                'name' => 'tandagejala_daftar_namalain',                                
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
    ));
    $this->endWidget();  
?>