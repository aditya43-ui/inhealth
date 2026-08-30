<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Riwayat Kegawatan
        </div>
    </div>
    <div class="panel-body">
        <?php 
     
        
            $model = new AsesmentriagewpssT();
            if(isset($_GET['notriage_pasien_id'])) {
                $model->notriage_pasien_id = $_GET['notriage_pasien_id'];
                $prov = $model->searchTriage();
                $prov->pagination->pageSize = 5;
            } else{
                $pendaftaran_id = $_GET['pendaftaran_id'];
                $model->pendaftaran_id = $pendaftaran_id;
                $prov = $model->searchTriage();
                $prov->pagination->pageSize = 5;

                // echo '<pre>'; var_dump($modAsesTriase->attributes); die;
            
            }
         
       //    / $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
       //foreach($prov as $data) {
         
           //$prov->sort->defaultOrder = 'create_time desc';
           
   
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$prov,
            'template'=>"\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tanggal',
                    'name'=>'create_time',
                    'value'=> function ($data){
                        if(!empty($data->create_time)){
                            echo $data->create_time;
                        }else{
                            echo $data->create_time;
                        }
                    }
                ),
                array(
                    'header'=>'Ruangan',
                    'name'=>'ruangan_nama',
                    'value'=>function ($data){
                            echo $data->ruangan->ruangan_nama;
                    }
                ),
                array(
                    'header'=>'Petugas',
                    'name'=>'nama_pegawai',
                    'value'=> function ($data){
                        if(!empty($data->create_time)){
                     echo $data->petugastriage->namaLengkap ?? "";   
                    }else{
                        echo $data->petugastriage->namaLengkap ?? "";    
                    }
                }
                  ),
                array(
                    'header'=>'Jenis Kegawatan',
                    'name'=>'ruang',
                    'value'=> function ($data){
                        if(!empty($data->create_time)){
                     echo $data->ruang;   
                    }else{
                        echo $data->ruang;   
                    }
                }  
                  
                ),
           array(
                'header'=>'Warna Triage',
                'name'=>'warna',
                'value'=>  function ($data){
                    if($data->ruang == 'Ruang P-3'){
                        echo '<div style="background-color:green; color:green;">.</div>';
                    } else if($data->ruang == 'Ruang P-2'){
                        echo '<div style="background-color:yellow;color:yellow;">.</div>';
                    } else if($data->ruang == 'Ruang P-1'){
                        echo '<div style="background-color:red;color:red;">.</div>';
                    } else if($data->ruang == 'Death on Arrival'){
                        echo '<div style="background-color:black;color:black;">.</div>';
                    } else if($data->ruang == 'Screening') {
                        echo '<div style="background-color:#ff85ed;color:#ff85ed;">.</div>';
                    } else if($data->ruang == 'APS') {
                        echo '<div style="background-color:#78a7ff;color:#78a7ff;">.</div>';
                    }
                }
           )
               
          
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
  //  }
        ?>
    </div>
</div>