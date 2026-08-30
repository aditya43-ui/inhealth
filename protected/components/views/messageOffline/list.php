<li class="dropdown" >
<a href="#" id="offMess" data-toggle="dropdown" class="dropdown-toggle" ><span id="countOffMess"><?php echo $count?></span></a>

<ul class="dropdown-menu" style="width:300px;padding:2px 0;"><li class="nav-header"><a href="#" onclick="return false;">Pesan</a></li>
    <div id="offlineMessages" style="height:400px;overflow-y:scroll;">
<?php
foreach ($messages as $message)
{
    echo '<div class="message-offline">';
    echo '<a href="javascript:message(\''.$message->chat_from.'\');" style="padding:2px;text-decoration:none;">';
    //echo '<img class="message-image" align="left">';
    echo '<b>'.$message->chat_from.'</b><br/>';
    echo $message->chat_message.'<br/>';  
    echo '<span class="message-time">'.$message->chat_sent.'</span>';
    echo '</a>';
    echo '</div>';
}
?>
    <li class="divider"></li>  
    </div>
</ul>
</li>

<script type="text/javascript">
$(document).ready(function(){
    countOfflineMessage();
});

function countOfflineMessage()
{
    $.ajax({
      url: "index.php?r=chat/ajax/countOfflineMessage",
      cache: false,
      dataType: "json",
      success: function(data) {
          $('#countOffMess').html(data.count);
          updateMessage(data);
          setTimeout('countOfflineMessage();',30000);
    }});
}

function updateMessage(data)
{
    var message ='';
    
    $.each(data, function(i,item){
       if(item.from){
           message += '<div class="message-offline"><a href="javascript:message(\''+item.from+'\');" style="padding:2px;text-decoration:none;">';
           message += '<b>'+ item.from +'</b><br/>';
           message += item.message + '<br/>';
           message += '<span class="message-time">'+ item.sent +'</span>';
           message += '</a></div>';
       } 
    });
    $('#offlineMessages').html(message);
}

function message(from)
{
    $('#chatdialog').dialog('open');
    //$('#framechat').attr('src', '<?php //echo Yii::app()->createAbsoluteUrl('chat'); ?>');
}

function clearFrameSrc()
{
    $('#framechat').attr('src', '');
}
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'chatdialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=> 'Pesan untuk: '.Yii::app()->user->name,
        'autoOpen'=>false,
        'width'=>290,
        'height'=>450,
        'close'=>'js:function(){ clearFrameSrc(); }',
        'modal'=>false,
    ),
));

    //echo '<iframe id="framechat" src="" height="100%" width="100%"></iframe> ';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php 
//$baseUrl = Yii::app()->baseUrl; 
//$cs = Yii::app()->getClientScript();
//$cs->registerCssFile($baseUrl.'/css/chat/chat.css');
//$cs->registerScriptFile($baseUrl.'/js/chat.js');
//$cs->registerScriptFile($baseUrl.'/js/footpanel.js');
//Yii::app()->clientScript->registerScript('cekStatusPasien',$js, CClientScript::POS_HEAD); 
?>