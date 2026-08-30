<div id="chat" class="fixed" data-current-user="<?php echo Yii::app()->user->name; ?>" data-order-by-status="1" data-max-chat-history="25">
    <div class="chat-inner">
        
        <h2 class="chat-header">
            <a href="#" class="chat-close" data-animate="1"><i class="entypo-cancel"></i></a>
            
            <i class="entypo-users"></i>
            Chat
            <span class="badge badge-success is-hidden">0</span>
        </h2>

    <!--<div class="chat-group" id="group-1">-->
        <?php
       /* foreach ($userOnline as $i=>$user)
        {
            if($user->nama_pemakai != Yii::app()->user->name){
                if($user->statuslogin){
                    echo '<a href="#" id="'.$user->nama_pemakai.'" onclick="readChat(this)"><span class="user-status is-online"></span> <em>'.$user->nama_pemakai.'</em></a>';
                    // echo '<a href="javascript:void(0);" onclick="javascript:chat(\''.$user->nama_pemakai.'\');" data-conversation-history="#history">';
                    //echo '<a href="#" data-conversation-history="#history"><span class="user-status is-online"></span><em>'.$user->nama_pemakai.'</em>';
                    //echo '<span class="user-status is-online"></span><em>'.$user->nama_pemakai.'</em>';
                } else {
                    //echo '<a class="user-status is-offline" href="javascript:void(0);" onclick="javascript:chat(\''.$user->nama_pemakai.'\');" data-conversation-history="#history">';
                    //echo '<a href="#"><span class="user-status is-offline"></span><em>'.$user->nama_pemakai.'</em>';
                    echo '<span class="user-status is-offline"></span><em>'.$user->nama_pemakai.'</em>';
                }
                echo '</a>';
            }
        }*/
		$a = 1;
        foreach ($userOnline as $i=>$job)
        {	//$jabatan = isset($user->pegawai->jabatan_id)?$user->pegawai->jabatan->jabatan_nama:'No Job';
			echo "<div class='chat-group' id='group-".$a."'>";
			if ($job['ruangan_nama'] == Yii::app()->user->getState('ruangan_nama')){
				
				if (count($job['login']) > 1){					
					echo "<strong>".$job['ruangan_nama']."</strong>";
				}
			}else{
				echo "<strong>".$job['ruangan_nama']."</strong>";
			}
			
			foreach($job['login'] as $j => $peg){				
				if($peg["nama_pemakai"] != Yii::app()->user->name){
					if($peg["statuslogin"]){						
						echo '<a href="#" id="'.$peg["nama_pemakai"].'" onclick="readChat(this)"><span class="user-status is-online"></span> <em>'.$peg["nama_pegawai"].'</em></a>';//('.$peg["nama_pemakai"].')
						// echo '<a href="javascript:void(0);" onclick="javascript:chat(\''.$user->nama_pemakai.'\');" data-conversation-history="#history">';
						//echo '<a href="#" data-conversation-history="#history"><span class="user-status is-online"></span><em>'.$user->nama_pemakai.'</em>';
						//echo '<span class="user-status is-online"></span><em>'.$user->nama_pemakai.'</em>';
					} else {
						
						//echo '<a class="user-status is-offline" href="javascript:void(0);" onclick="javascript:chat(\''.$user->nama_pemakai.'\');" data-conversation-history="#history">';
						//echo '<a href="#"><span class="user-status is-offline"></span><em>'.$user->nama_pemakai.'</em>';
						//echo '<a href="#" id="'.$peg["nama_pemakai"].'" onclick="readChat(this)"><span class="user-status is-offline"></span><em>'.$peg["nama_pegawai"].'</em></a>';
					}
					echo "</a>";
				}
			}
			echo "</div>";
			$a++;
        }
        ?>

        
    </div>  
    <!--</div>  -->

    <!-- conversation template -->
    <div class="chat-conversation">
        
        <div class="conversation-header">
            <a href="#" class="conversation-close"><i class="entypo-cancel"></i></a>
            <span class="display-name"></span> 
            <span class="user-status"></span>
            <small></small>
        </div>
        
        <ul class="conversation-body">  
        </ul>
        
        <div class="chat-textarea">
            <textarea class="form-control autogrow" placeholder="Type your message"></textarea>
        </div>
        
    </div>  
</div>
    <!-- Chat Histories -->
<ul class="chat-history" id="history">
    <li>
        <span class="user"><?php echo Yii::app()->user->name; ?></span>
        <p>Are you here?</p>
        <span class="time">09:00</span>
    </li>
</ul>  



<?php 
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
// $cs->registerCssFile($baseUrl.'/css/chat/chat.css');
// $cs->registerScriptFile($baseUrl.'/js/chat.js');
$cs->registerScriptFile($baseUrl.'/themes/neon/assets/js/neon-chat.js');
// $cs->registerScriptFile($baseUrl.'/js/footpanel.js');
?>