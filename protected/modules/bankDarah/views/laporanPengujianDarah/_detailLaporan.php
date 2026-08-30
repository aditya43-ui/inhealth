<?php
/**
* - digunakan sebagai Laporan Pengujian Darah
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php
$i=1;
   foreach($model as $row){
   /*
    echo "<pre>";
    var_dump($row->tanggal);
   */
?>            
<tr>   
    <td><?php echo $i;  ?></td>
    <td><?php echo $row->no_kantongdarah ?></td>
    <td><?php 
    
         if(!empty($row->gol_darah_awal)){
            
             if(strtoupper($row->gol_darah_awal)=="A"){
                 echo $row->gol_darah_awal;
             }
         }
      
            
        ?>
  
    </td> <!--Golongan Awal A-->
    <td><?php 
    
         if(!empty($row->gol_darah_awal)){
             if(strtoupper($row->gol_darah_awal)=="B"){
                 echo $row->gol_darah_awal;
             }
         }
   
            
        ?>
  
    </td> <!--Golongan Awal B-->
    <td><?php 
    
         if(!empty($row->gol_darah_awal)){
             if(strtoupper($row->gol_darah_awal)=="O"){
                 echo $row->gol_darah_awal;
             }
         }
        
            
        ?>
  
    </td> <!--Golongan Awal O-->
    
    <td><?php 
    
         if(!empty($row->gol_darah_awal)){
             if(strtoupper($row->gol_darah_awal)=="AB"){
                 echo $row->gol_darah_awal;
             }
         }
    ?>
  
    </td> <!--Golongan Awal AB-->
    <td><?php 
    
         if(!empty($row->rhesus_awal)){
             if(strtoupper($row->rhesus_awal)=="POSITIF"){
                 echo "Pos";
             }
         }
   
        ?>
  
    </td> <!--Golongan rhesus awal pos-->
    <td><?php 
    
         if(!empty($row->rhesus_awal)){
             if(strtoupper($row->rhesus_awal)=="NEGATIF"){
                 echo "Neg";
             }
         }

        ?>
  
    </td> <!--rhesus Awal neg -->
    <td><?php 
    
         if(!empty($row->gol_darah)){
            
             if(strtoupper($row->gol_darah)=="A"){
                 echo $row->gol_darah;
             }
         }
      
            
        ?>
  
    </td> <!--Golongan akhir A-->
    <td><?php 
    
         if(!empty($row->gol_darah)){
             if(strtoupper($row->gol_darah)=="B"){
                 echo $row->gol_darah;
             }
         }
     
        ?>
  
    </td> <!--Golongan akhir B-->
    <td><?php 
    
         if(!empty($row->gol_darah)){
             if(strtoupper($row->gol_darah)=="O"){
                 echo $row->gol_darah;
             }
         }
        
        ?>
  
    </td> <!--Golongan akhir O-->
    
    <td><?php 
    
         if(!empty($row->gol_darah)){
             if(strtoupper($row->gol_darah)=="AB"){
                 echo $row->gol_darah;
             }
         }
      
        ?>
  
    </td> <!--Golongan akhir AB-->
    <td><?php 
    
         if(!empty($row->rhesus)){
             if(strtoupper($row->rhesus)=="POSITIF"){
                 echo "Pos";
             }
         }
   ?>
  
    </td> <!--Golongan rhesus akhir pos-->
    <td><?php 
    
         if(!empty($row->rhesus)){
             if(strtoupper($row->rhesus)=="NEGATIF"){
                 echo "Neg";
             }
         }
    ?>
  
    </td> <!--rhesus akhir neg -->
    <td>
        <?php
        if(!empty($row->hasil_uji)){
            echo $row->hasil_uji;
        }
        
        ?>
        
    </td>
</tr>  
<?php
$i++; 
}


?>