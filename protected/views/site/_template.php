<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$judul.'-'.date("Y/m/d").'.xls"');
header('Cache-Control: max-age=0');  
?>
<table>
    <thead>
        <tr bgcolor="green">
            <?php 
            $kolom = $table->columns;
            foreach ($kolom as $counter => $column) {
                 echo "<th>$column->name</th>";
            } ?>
         </tr>
     </thead>
     <tbody>
         <?php 
         foreach ($model as $key => $value) {
             echo '<tr>';
             foreach ($kolom as $counter => $column) {
                 echo "<td>".$value[$column->name]."</td>";
             }
             echo '</tr>';
             
         }
         ?>
     </tbody>
</table>