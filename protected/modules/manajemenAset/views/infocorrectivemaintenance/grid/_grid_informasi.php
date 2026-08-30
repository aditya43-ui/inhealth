<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'corectivemaintenance-r-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'replaceUrl'=>true,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),   
                                array(
                                    'header'=>'Tanggal dan Nomor Permintaan',
                                    'type' => 'raw',
                                    'value'=>'MyFormatter::formatDateTimeForUser($data->korektifmainten_tgl)."<br/>".$data->korektifmainten_no'
                                ),
                                array(
                                    'header'=>'Jenis Peralatan',
                                    'value'=>'$data->invperalatan_namabrg'
                                ),
                                array(
                                    'header'=>'Kode Aset/<br/>Nomor Seri',
                                    'type' => 'raw',
                                    'value'=>'$data->invperalatan_kode."/<br/>".$data->peralatan_noseri'
                                ),                                 
                                array(
                                    'header'=>'Lokasi Aset',
                                    'type' => 'raw',
                                    'value'=>function($data){
    
                                        $tool = !empty($data->kode_internal)?'<b>'.$data->kode_internal.'</b>':'';
                                        $tool .= !empty($data->gedung_nama)?(empty($tool)?'':'<br/>').'Gedung '.$data->gedung_nama:'';
                                        $tool .= !empty($data->area_nama)?(empty($tool)?'':'<br/>').'Area '.$data->area_nama:'';
                                        $tool .= !empty($data->ruangan_lokasi)?(empty($tool)?'':'<br/>').$data->ruangan_lokasi:'';
                                        $tool .= !empty($data->ruangpemohon_nama)?(empty($tool)?'':'<br/>').$data->ruangpemohon_nama:'';
                                        $tool .= !empty($data->lokasiaset_namalokasi)?(empty($tool)?'':'<br/>').$data->lokasiaset_namalokasi:'';
    
                                        return CHtml::link('<u>'.$data->ruangpemohon_nama." - ".$data->lokasiaset_namalokasi.'</u>','javascript:;',[
                                            'title' => $tool,
                                            'data-html' => true,
                                            'rel' => 'tooltip'
                                        ]);
                                    }
                                ),
                                                                                               
                                array(
                                    'header'=>'Nama Pemohon',
                                    'value'=>'$data->pemohon_nama'
                                ),
                                array(
                                    'header'=>'Keterangan',
                                    'value'=>'$data->korektifmainten_ket'
                                ),
                                [
                                    'header' => 'Tanggal Selesai',
                                    'value' => '!empty($data->korektifmainten_tglpakhir)?MyFormatter::formatDateTimeForUser($data->korektifmainten_tglpakhir,"long"):""'
                                ],
                                array(
                                    'header'=>'Detail',
                                     'type' => 'raw',
                                    'value'=>function($data) {
                                        return CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->korektifmainten_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika anda ingin menampilkan <b>detail data Corrective Maintenance</b>'));
    
                                    }
                                ),
                                [
                                    'header' => 'Teknisi',
                                    'type' => 'raw',
                                    'htmlOptions' => [
                                        'style' => 'text-align:center;'
                                    ],
                                    'value' => function($data){
                                        $click = 'setTeknisiForm(this);';
                                        if ($data->pegpemohon_id == Yii::app()->user->getState('pegawai_id'))
                                            $click = "myAlert('Anda tidak berhak mengakses fitur');";
                                    
                                        return CHtml::link("<span style='font-size:20px;'><i class='fa fa-user'></i></span>","javascript:;",[
                                            'data-url'=>$this->createUrl('setTeknisi',['id'=>$data->korektifmainten_id]),
                                            'data-id'=>$data->korektifmainten_id,
                                            'onclick'=>$click
                                        ]);
                                    }
                                ],
                                array(
                                    'header'=>'Status',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                            if ($this->module->id == 'manajemenAset'){
                                                if (ucwords($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENOPEN ) {
                                                    return '<button style="width:120px;" id="red" class="btn btn-danger" name="yt1" onclick="setStatus('.$data->korektifmainten_id.',\''.ParamsConst::STATUSDOKUMENINPROGRESS.'\'); ">'.ucwords($data->korektifmainten_status).'</button>';   
                                                }else if (($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENPENDING ) {
                                                    return '<button style="width:120px;" id="red" class="btn btn-gold" name="yt1" onclick="setStatus('.$data->korektifmainten_id.',\''.ParamsConst::STATUSDOKUMENINPROGRESS.'\'); ">'.ucwords($data->korektifmainten_status).'</button>';   
                                                }else if($data->korektifmainten_status ==  ParamsConst::STATUSDOKUMENINPROGRESS) {                                                    
                                                    $btn = '<div class="btn-group">                                                                                                                                                        
                                                                <button  style="width:120px;"  type="button" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">In Progress&nbsp;&nbsp;&nbsp;<span class="fa fa-angle-down"></span></button>                                                                
                                                                <ul class="dropdown-menu dropdown-blue" role="menu">
                                                                    <li><a id="red" class="" name="yt1" onclick="pending('.$data->korektifmainten_id.');">Pending</a></li>
                                                                    <li><a id="red" class="" name="yt1" onclick="konfirmasi('.$data->korektifmainten_id.');">Finish</a></li>
                                                                </ul>
                                                             </div>';
                                                    return $btn;                                                    
                                                }else if (($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENFINISH ) {
                                                        if ($data->pemohon_id == Yii::app()->user->getState('pegawai_id')){
                                                            $click = 'setStatus('.$data->korektifmainten_id.',\''.ParamsConst::STATUSDOKUMENCLOSE.'\');';
                                                        }else{
                                                            $click = "toastr.warning('Hanya pegawai ".$data->pemohon_gelardepan.' '.$data->pemohon_nama.', '.$data->gelarpemohon_nama." yang bisa close','Perhatian!')";
                                                        }
                                                        return '<button style="width:120px;" id="red" class="btn btn-info" name="yt1" onclick="'.$click.'">'.$data->korektifmainten_status.'</button>';   
                                                }else if(($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENCLOSE ){
                                                    return '<button style="width:120px;" id="red" class="btn btn-success" name="yt1">'.$data->korektifmainten_status.'</button>';   
                                                }else{
                                                    return '<button style="width:120px;" id="red" class="btn btn-purple" name="yt1">'.$data->korektifmainten_status.'</button>';   
                                                }
                                            }else{
                                                $click = '';
                                                if (($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENFINISH ) {
                                                    if ($data->pemohon_id == Yii::app()->user->getState('pegawai_id')){
                                                        $click = 'setStatus('.$data->korektifmainten_id.',\''.ParamsConst::STATUSDOKUMENCLOSE.'\');';
                                                    }else{
                                                        $click = "toastr.warning('Hanya pegawai ".$data->pemohon_gelardepan.' '.$data->pemohon_nama.', '.$data->gelarpemohon_nama." yang bisa close','Perhatian!')";
                                                    }
                                                }
                                                
                                                return ParamsConst::getWrStatusCorrective($data->korektifmainten_status, [ParamsConst::STATUSDOKUMENFINISH=>$click]);
                                            }
                                    }
                                ),                                                                                           
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                                        
                                        ?>