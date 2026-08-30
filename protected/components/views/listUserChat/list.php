<li class="dropdown" >
<a href="#" id="listUser" data-toggle="dropdown" data-user="<?php echo Yii::app()->user->name ?>" class="dropdown-toggle" ><i class="icon-comment icon-white"></i> Chat <span class="caret"></span></a>

<ul class="dropdown-menu" style="width:200px;padding:2px 0;">
    <div id="chatUsers" style="height:400px;overflow-y:scroll;">
<?php
foreach ($userOnline as $i=>$user)
{
    if($user->nama_pemakai != Yii::app()->user->name){
        echo '<li>';
        if($user->statuslogin){
            echo '<a id="'.$user->nama_pemakai.'" class="useronline" href="javascript:void(0);" onclick="chat(this);">';
            echo '<i class="icon-user"></i> '.$user->nama_pemakai;
        } else {
            echo '<a class="useroffline" href="javascript:chat(\''.$user->nama_pemakai.'\');">';
            echo '<i class="icon-user icon-white"></i> '.$user->nama_pemakai;
        }
        echo '</a>';
        echo '</li>';
    }
}
?>
    <li class="divider"></li>  
    </div>
</ul>
</li>

<script type="text/javascript">
$(document).ready(function(){
    originalTitle = document.title;
    startChatSession();
    chatHeartbeat();
    $([window, document]).blur(function(){
            windowFocus = false;
    }).focus(function(){
            windowFocus = true;
            document.title = originalTitle;
    });
});

function chat(chatboxtitle)
{
        chatWith(chatboxtitle);
}
</script>

<?php 
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/chat/chat.css');
$cs->registerScriptFile($baseUrl.'/js/chat.js');
$cs->registerScriptFile($baseUrl.'/js/footpanel.js');
//Yii::app()->clientScript->registerScript('cekStatusPasien',$js, CClientScript::POS_HEAD); 
?>