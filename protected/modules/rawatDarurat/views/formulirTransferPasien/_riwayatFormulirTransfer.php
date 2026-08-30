<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Riwayat <strong>Transfer Pasien</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: auto; max-width: 100%;">
        <div class="block-tabel">
            <div style="overflow-x: auto;">
                <?php
                $modList = new FormtransferpasienT();
                $modList->unsetAttributes();
                $modList->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $prov = $modList->search();
                $prov->sort->defaultOrder = "tanggal_transfer ASC";

                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'formtransferpasien-grid',
                    'dataProvider' => $prov,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header'=>'No',
                            'type'=>'raw',
                            'value'=>'$row+1',
                        ),
                          array(
                            'header'=>'Tanggal Transfer',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_transfer)',
                        ),
                          array(
                            'header'=>'Waktu Transfer',
                            'type'=>'raw',
                            'value'=>'$data->waktu_transfer',
                        ),
                        array(
                            'header'=>'Ruangan Asal',
                            'type'=>'raw',
                            'value'=>'$data->ruanganasal->instalasi->instalasi_nama ."/ <br />".$data->ruanganasal->ruangan_nama',
                        ),
                        array(
                            'header'=>'Ruangan yang Dituju',
                            'type'=>'raw',
                            'value'=>'$data->instalasitujuan->instalasi_nama ."/ <br />".$data->ruangantujuan->ruangan_nama',
                        ),
                         array(
                            'header'=>'Status Penerimaan Pasien Transfer',
                            'type'=>'raw',
                            'value'=>function($data) {
                                    $modProsesTransfer = RDProsestransferpasienT::model()->findByAttributes(array('formtransferpasien_id'=>$data->formtransferpasien_id));
                                if($data->ispasienditerima){
                                    return "Sudah <br /> Waktu Tiba : ".(isset($modProsesTransfer->setelahtransfer_waktutiba)?$modProsesTransfer->setelahtransfer_waktutiba:"");
                                }else{
                                    return "Belum";
                                }
                            }
                        ),
                         array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'value'=>function($data) {
                                $link = CHtml::link('<i class="fa fa-file" style="font-size:14pt"></i>', Yii::app()->createUrl("/rawatDarurat/FormulirTransferPasien/DetailFormulir",array("pendaftaran_id"=>$data->pendaftaran_id, "formtransferpasien_id"=>$data->formtransferpasien_id,'type'=>$_GET['type'],'frame'=>$_GET['frame'])),array("id"=>"$data->formtransferpasien_id","rel"=>"tooltip","title"=>"Klik untuk Detail Formulir Transfer Pasien"));
                                return $link;
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;',
                            )
                        ),
                        array(
                            'header'=>'Cetak',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link('<i class="entypo-print" style="font-size:14pt"></i>', 'javascript:void(0)',array('onclick'=>'printRiwayat('.$data->formtransferpasien_id.','.$data->pendaftaran_id.',"PRINT")'));
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;',
                            )
                        ),


                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                    . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>