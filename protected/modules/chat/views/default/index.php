<?php 
foreach ($modUserOnline as $i=>$userOnline) { 
    if($userOnline->nama_pemakai != Yii::app()->user->name)
        if($userOnline->statuslogin)
            echo '<a class="useronline" onclick="javascript:chatWith(\''.$userOnline->nama_pemakai.'\')" href="javascript:void(0)"><i class="icon-user"></i>'.$userOnline->nama_pemakai.'</a>';
        else
            echo '<a class="useroffline" onclick="javascript:chatWith(\''.$userOnline->nama_pemakai.'\')" href="javascript:void(0)"><i class="icon-user icon-white"></i>'.$userOnline->nama_pemakai.'</a>';
}           
    
?>
