<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">10 Mutasi Terakhir</div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
            <a data-rel="reload" href="#" onclick="refreshTable();"><i class="entypo-arrows-ccw"></i></a>
        </div>
    </div>
    <div class="panel-body with-table">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'table-grid',
            'dataProvider' => $dataTable->searchMutasiTerakhir(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'Ruangan',
                    'type' => 'raw',
                    'value' => '$data->ruangantujuan_nama',
                ),                
                array(
                    'header' => 'Jumlah Aset',
                    'type' => 'raw',
                    'htmlOptions' => [
                        'style' => 'text-align:right;'
                    ],
                    'value' => '$data->jumlah_aset',
                ),  
                array(
                    'header' => 'Detail',
                    'type' => 'raw',
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ],
                    'value' => function($data){            
                        echo CHtml::link('<span style="font-size:15px;"><i class="glyphicon glyphicon-file "></i></span>','javascript:',['data-url'=>$this->createUrl('mutasiAset/lihatDetail&mutasiaset_id',['mutasiaset_id'=>$data->mutasiaset_id,'detail'=>'detail']),'onclick'=>'print(this)']);
                    },
                ),  
            ),
        ));
        ?>

    </div>
</div>

<script type="text/javascript">
    function refreshTable() {
        $.fn.yiiGridView.update('table-grid');
    }
    
    function print(obj){
        window.open($(obj).data('url'),'printwin','left=100,top=100,width=1000,height=640');
    }
</script>