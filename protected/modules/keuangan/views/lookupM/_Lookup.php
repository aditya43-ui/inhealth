<?php
$typeLookup=LookupM::model()->findByPk($lookup_id)->lookup_type;
$modLookup = LookupM::model()->findAllByAttributes(array('lookup_type'=>$typeLookup));
if(count((array)$modLookup)>0)
    {
        echo "<ul>";
        foreach($modLookup as $i=>$lookup_type)
        {
            echo '<li>'.$lookup_type->lookup_name.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

