<div class="row">
    <?php 
//     $tempModulId = '';
//     foreach ($modModulPemakai as $i=>$modul){
//         if($modModulPemakai != $modul['modul_id']){
//             if($i>1)echo '</div></fieldset>';
//         } 
//         echo "<div class='boxrepeat span2'>";
//         echo Chtml::checkBox('modul['.$modul["modul_nama"].']', true  ,array('value'=>$modul["modul_id"],'uncheckValue'=>0,'disabled'=>true));
//         echo $modul['modul_nama']; echo "<br/>";
//         echo "</div>";
//         $tempModulId = $modul['modul_id'];
//     } echo '</div></fieldset>';
     if(COUNT($modModulPemakai)>0)
    {   
        echo "<ul>"; 
        foreach($modModulPemakai as $i=>$modul)
        {
            echo "<li>".$modul["modul_nama"].'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum Di Set";
    }   
    ?>
    
</div>
