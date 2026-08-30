<?php
 $model =new LaporanoperasipasienT();
 ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i>Riwayat Laporan <b>OPERASI</b>
        </div>
    </div>
    <?php 
    // $model->pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
    // $modLaporan = LaporanoperasipasienT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$_GET['pasienmasukpenunjang_id']));
    // var_dump($_GET);die;
    
    $pasienmasukpenunjang_id = isset($_GET['pasienmasukpenunjang_id']) ? $_GET['pasienmasukpenunjang_id'] : $_GET['id'];
    
    
    
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
      ));
    if (empty($penunjang)){
        $penunjang = LaporanoperasipasienT::model()->findByPk($pasienmasukpenunjang_id);
        
    }
    // var_dump($penunjang);die;
    $model->pendaftaran_id = !empty($penunjang->pendaftaran_id)?$penunjang->pendaftaran_id:'-';
    // var_dump($model->searchDataLaporan()->data);die;
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'satabular-list-m-grid',
                    'dataProvider' => $model->searchDataLaporan(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Laporan',
                            'type'=>'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggalpengisian_laporanop)',
                           ),
                        array(
                            'header' => 'Pembuatan Laporan',
                            'type'=>'raw',
                            'value' => function($data) {
                                $peg = PegawaiM::model()->findByAttributes( array('pegawai_id'=>$data->dokterbedah_pengisilaporan_id));
                                if(!empty($peg)){
                                    return $peg->namaLengkap;
                                }else{
                                    return "-"; 
                                }
                            },
                           ),
                           array(
                            'header' => 'Cetak',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-print\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                                        "id" => "selectLaporan",
                                                        "style"=>"width:10%",
                                                        "onClick" => "
                                                         print2(\"$data->laporanoperasipasien_id\");

                                                         "))',

                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    
                        array(
                            'header' => 'Detail',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Detail'),
                                ),
                            ),
                        ),
                        array(
                             'header' => 'Ubah',
                             'class' => 'bootstrap.widgets.BootButtonColumn',
                             'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                             'template' => '{update}',
                             'buttons' => array(
                                 'update' => array(
                                     'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                     'options' => array('rel' => 'tooltip', 'title' => 'Ubah'),
                                 ),
                             ),
                         ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus Data Riwayat Laporan Operasi'),
                                ),
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
						jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
						$("table").find("input[type=text]").each(function(){
							cekForm(this);
						})
					}',
                )); ?>
  <script>
        $(document).ready(function(){
            window.print();
        });
    </script>
