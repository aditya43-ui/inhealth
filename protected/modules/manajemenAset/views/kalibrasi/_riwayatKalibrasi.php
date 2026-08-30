<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            <i class="glyphicon glyphicon-file"></i> Riwayat Kalibrasi																	
        </div>
    </div>
    <div class="panel-body">
             <table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
                    <thead>
                        <tr>
                            <th>No<br>
                            <th>Tgl. Kalibrasi</th>
                            <th>Berlaku Sampai</th>
                            <th>Data Vendor Pemeliharaan</th>
                            <th>Pelaksana</th>
                            <th>Keterangan</th>
                            <th style="text-align: center">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['sukses'])) {
                        $no = 0;
                        if(!empty($modRiwayatKalibarasi)) {
                         
                           foreach($modRiwayatKalibarasi as $data) { 
                        ?>   
                        <tr>
                            <td><?php echo $data->nokalibrasi; ?></td> 
                            <td><?php echo $format->formatDateTimeForUser($data->tglkalibrasi); ?></td>
                            <td><?php echo $format->formatDateTimeForUser($data->berlaku_sdtgl); ?></td>
                            <td><?php echo isset($data->supplier_id) ? $data->supplier->supplier_nama : " "; ?></td>
                            <td><?php 
                                    $load_det = MAInvkalibrasidetT::model()->findAll(" invkalibrasi_id = ".$data->invkalibrasi_id." ");

                                    if (!empty($load_det)){
                                        echo "<ol>";
                                        foreach($load_det as $det){
                                            echo "<li>".$det->nama_pegawai."</li>";
                                        }
                                        echo "</ol>";
                                    }
                            
                            ?></td>
                            <td><?php echo isset($data->invkalibrasi_ket) ? $data->invkalibrasi_ket : " "; ?></td>
                            <td style="text-align: center"> 
                                <?php                             
                                    if (!empty($data->lampiran_berkas)){
                                        $path = ParamsUrl::pathKalibrasiPdfDirectory() . $data->lampiran_berkas;
                                        
                                        if (file_exists($path)) {
                                            if (strpos($data->lampiran_berkas,'.pdf') !== false){
                                                echo CHtml::link($data->lampiran_berkas, ParamsUrl::urlKalibrasiPdfDirectory().$data->lampiran_berkas,array('title'=>'Download document','rel'=>'tooltip','target'=>'_BLANK'));
                                            }else{
                                                echo CHtml::link($data->lampiran_berkas,$this->createUrl('Unduh',array('id'=>$data->invkalibrasi_id)),array('title'=>'Download document','rel'=>'tooltip'));
                                            }                                            
                                        }else{
                                            echo CHtml::link($data->lampiran_berkas,$this->createUrl('Unduh',array('id'=>$data->invkalibrasi_id)),array('title'=>'Download document','rel'=>'tooltip'));
                                        }                                        
                                    }else{
                                        
                                    }
                                         
                                ?>
                            </td>
                                    

                        </tr>
                         <?php 
                           }
                        } 
                        }
                        ?>
                    </tbody>
                               
            </table>
    </div>
      
</div>






