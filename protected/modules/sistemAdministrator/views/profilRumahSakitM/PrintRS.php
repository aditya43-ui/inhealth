
<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    ?>

    
<fieldset style="width: 1000px">
            <legend>Data Rumah Sakit</legend>
             <table style="width: 800px" class="table table-striped table-bordered table-condensed">
               <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nama_rumahsakit'),$model->getAttributeLabel('nama_rumahsakit'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->nama_rumahsakit, $model->nama_rumahsakit);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('jenisrs_profilrs'),$model->getAttributeLabel('jenisrs_profilrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->jenisrs_profilrs, $model->jenisrs_profilrs);?>                     
                      </td>
                </tr>
                 <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('npwp'),$model->getAttributeLabel('npwp'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->npwp, $model->npwp);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('tahun_diresmikan'),$model->getAttributeLabel('tahun_diresmikan'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->tahun_diresmikan, $model->tahun_diresmikan);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('kodejenisrs_profilrs'),$model->getAttributeLabel('kodejenisrs_profilrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->kodejenisrs_profilrs, $model->kodejenisrs_profilrs);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nokode_rumahsakit'),$model->getAttributeLabel('nokode_rumahsakit'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->nokode_rumahsakit, $model->nokode_rumahsakit);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('kelas_rumahsakit'),$model->getAttributeLabel('kelas_rumahsakit'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->kelas_rumahsakit, $model->kelas_rumahsakit);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('statusrsswasta'),$model->getAttributeLabel('statusrsswasta'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->statusrsswasta, $model->statusrsswasta);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('alamatlokasi_rumahsakit'),$model->getAttributeLabel('alamatlokasi_rumahsakit'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->alamatlokasi_rumahsakit, $model->alamatlokasi_rumahsakit);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('motto'),$model->getAttributeLabel('motto'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->motto, $model->motto);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('website'),$model->getAttributeLabel('website'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->website, $model->website);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('email'),$model->getAttributeLabel('email'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->email, $model->email);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('no_faksimili'),$model->getAttributeLabel('no_faksimili'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->no_faksimili, $model->no_faksimili);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('no_telp_profilrs'),$model->getAttributeLabel('no_telp_profilrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->no_telp_profilrs, $model->no_telp_profilrs);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('pentahapanakreditasrs'),$model->getAttributeLabel('pentahapanakreditasrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->pentahapanakreditasrs, $model->pentahapanakreditasrs);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('statusakreditasrs'),$model->getAttributeLabel('statusakreditasrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->statusakreditasrs, $model->statusakreditasrs);?>                     
                      </td>
                </tr>
             </table>  
        </fieldset> 
        
        <fieldset>
            <legend>Visi dan Misi</legend>
            <table  style="width: 800px" class="table table-striped table-bordered table-condensed">
                <tr>
                      <td width="50%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('visi'),$model->getAttributeLabel('visi'));?>
                          <br>
                             <?php echo CHtml::label( $model->visi, $model->visi);?>                  
                      </td>
                       <td width="50%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('misi'),$model->getAttributeLabel('misi'));?>
                     <br>
                             <ul>
                                        <?php foreach ($modMisiRS AS $data) :
                                            
                                            echo '<li>'.$data['misi'].'</li>';                                                       
                                           
                                         endforeach;
                                         ?>
                                   </ul>                    
                      </td>
                </tr>
             </table>
        </fieldset>

        <fieldset>
            <legend>Kepemilikan</legend>
            <table  style="width: 800px" class="table table-striped table-bordered table-condensed">
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('namakepemilikanrs'),$model->getAttributeLabel('namakepemilikanrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->namakepemilikanrs, $model->namakepemilikanrs);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('kodestatuskepemilikanrs'),$model->getAttributeLabel('kodestatuskepemilikanrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->kodestatuskepemilikanrs, $model->kodestatuskepemilikanrs);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('statuskepemilikanrs'),$model->getAttributeLabel('statuskepemilikanrs'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->statuskepemilikanrs, $model->statuskepemilikanrs);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('khususuntukswasta'),$model->getAttributeLabel('khususuntukswasta'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->khususuntukswasta, $model->khususuntukswasta);?>                     
                      </td>
                </tr>
                 <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('namadirektur_rumahsakit'),$model->getAttributeLabel('namadirektur_rumahsakit'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->namadirektur_rumahsakit, $model->namadirektur_rumahsakit);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('nomor_suratizin'),$model->getAttributeLabel('nomor_suratizin'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->nomor_suratizin, $model->nomor_suratizin);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('oleh_suratizin'),$model->getAttributeLabel('oleh_suratizin'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->oleh_suratizin, $model->oleh_suratizin);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('sifat_suratizin'),$model->getAttributeLabel('sifat_suratizin'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->sifat_suratizin, $model->sifat_suratizin);?>                     
                      </td>
                </tr>
                <tr>
                      <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('tgl_suratizin'),$model->getAttributeLabel('tgl_suratizin'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->tgl_suratizin, $model->tgl_suratizin);?>                  
                      </td>
                       <td width="20%"> 
                           <?php echo CHtml::label($model->getAttributeLabel('masaberlakutahun_suratizin'),$model->getAttributeLabel('masaberlakutahun_suratizin'));?>
                      </td>
                      <td width="30%">
                             <?php echo CHtml::label( $model->masaberlakutahun_suratizin, $model->masaberlakutahun_suratizin);?>                     
                      </td>
                </tr>
             </table>  
        </fieldset>     

