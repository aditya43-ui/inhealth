<div class="white-container">
    <?php
    $this->breadcrumbs=array(
    	'Informasi Antrian Pasien'=>array('index'),
    	'Kelola',
    );
   
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('ppinformasiantrianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>

    <?php $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

<div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b> Antrian Pasien</b>
                </div>
            </div>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'ppinformasiantrianpasien-grid',
            'dataProvider' => $model->search(true),
            //	'filter'=>$model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tgl. Antrian',
                    'value' => function ($data) {
                     echo  MyFormatter::formatDateTimeForUser($data->tglantrian);
                },
                    'htmlOptions' => array(
                        'style' => 'text-align: center; width: 145px;',
                        'class' => 'inap'
                    )
                ),

                array(
                    'header' => 'Barcode',
                    'value' => function ($data) {
                        echo  $data->barcode;
                      
                       },
                    'htmlOptions' => array(
                        'style' => 'text-align: center; width: 100px;',
                        'class' => 'inap'
                    )
                ),
                array(
                    'header' => 'No. Antrian',
                    'type' => 'raw',
                    'value' => function ($data) {
                        echo  $data->modelantrisingkatan.'-'.$data->noantrian;
                       },
                   
                    'htmlOptions' => array(
                        'style' => 'text-align: center; width: 80px;',
                        'class' => 'inap'
                    )
                ),
                array(
                    'header' => 'No. Pendaftaran /<br> No. Rekam 5edik',
                    'type' => 'raw',
                    'value' => function ($data) {
                       
                        if($data->pendaftaran_id != null && $data->statuspasien == "TUNGGU POLIKLINIK"){
                       echo  $data->no_pendaftaran."<br>".$data->no_rekam_medik;
                        }else{
                         echo '';
                        }
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center; width: 120px;',
                        'class' => 'inap'
                    )
                    
                ),
                array(
                    'header' => 'No. Antrian Poliklinik',
                    'type' => 'raw',
                    'value' => function ($data) {

                        if($data->pendaftaran_id != null && $data->statuspasien == "TUNGGU POLIKLINIK"){
                        echo $data->ruangan_singkatan.'-'.$data->noantrian;
                        }else{
                            echo '';  
                        }
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center; width: 80px;',
                        'class' => 'inap'
                    )
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => function ($data){
                        if($data->pendaftaran_id != null && $data->statuspasien == "TUNGGU POLIKLINIK"){
                  echo $data->nama_pasien;
                    } else { 
                 
                        echo '';
                    }
                },
                    'htmlOptions' => array(
                        'style' => 'text-align: center; width: 80px;',
                        'class' => 'inap'
                    )
                    
                ),
                array(
                    'header' => 'Poliklinik',
                    'type' => 'raw',
                    'value' => function ($data){
                    if($data->pendaftaran_id != null && $data->statuspasien == "TUNGGU POLIKLINIK"){
                
                    echo $data->ruangan_nama;
                    }else{
                    echo '';    
                    }
                },
                ),
                array(
                    'header' => 'Status Pasien',
                    'type' => 'raw',
                    'value' => function ($data){

                        $lookupData = LookupM::getitemsUrutan('status_pasien');
                        
                        echo $lookupData[$data->statuspasien] ?? "-";
                        
                    
                      if ($data->statuspasien == 'ANJUNGAN'){
                        echo "ANJUNGAN";
                      } else if ($data->statuspasien == "PROSES BARCODE"){
                        echo "PROSES BARCODE"; 
                      } else if ($data->statuspasien == "TUNGGU DAFTAR"){
                        echo "TUNGGU DAFTAR"; 
                      }else{
                        echo "TUNGGU POLIKLINIK";  
                      }
                    },),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
<br>
    <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model, 'format' => $format)); ?>
                <!--</fieldset>-->
            </div>
        </div>
    </div>
   </div>