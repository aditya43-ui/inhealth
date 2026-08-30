<?php
/**
*  
*
* - digunakan untuk menampung semua script javascript 
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
*/
?>

<script>
	function cekTipeKirim(obj){
		var tipe_kirim =  $(obj).val();
		
		if (tipe_kirim== '<?php echo Params::KONFIG_EMAIL_TIPE_KIRIM_SMTP ?>'){
			callSMTP();
		}else{
			callGmailApi();
		}

	}
	
	function resetGmailApi(){
		var oauth_email = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_email') ?>';
		var oauth_id = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_id') ?>';
		var oauth_pass = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_pass') ?>';
		var oauth_tipe = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_type') ?>';	
		
		$("#"+oauth_email).val('');
		$("#"+oauth_id).val('');
		$("#"+oauth_pass).val('');
		$("#"+oauth_tipe).val('');				
	}
	
	function resetSMTP(){
		var username = '<?php echo CHtml::activeId($model, 'konfigemail_username') ?>';
		var password = '<?php echo CHtml::activeId($model, 'konfigemail_password') ?>';		
		
		$("#"+username).val('');
		$("#"+password).val('');	
		
	
		var oauth_tipe = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_type') ?>';	
		
		$("#"+oauth_tipe).val('<?php echo Params::KONFIG_EMAIL_OAUTH  ?>');			
	}
	
	function callSMTP(){
		var oauth_email = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_email') ?>';
		var oauth_id = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_id') ?>';
		var oauth_pass = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_pass') ?>';
		var oauth_tipe = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_type') ?>';		
		var username = '<?php echo CHtml::activeId($model, 'konfigemail_username') ?>';
		var password = '<?php echo CHtml::activeId($model, 'konfigemail_password') ?>';
		
		$("#"+oauth_email).hide();
		$("#"+oauth_id).hide();
		$("#"+oauth_pass).hide();
		$("#"+oauth_tipe).hide();
		$("label[for="+oauth_email+"]").hide();
		$("label[for="+oauth_id+"]").hide();
		$("label[for="+oauth_pass+"]").hide();
		$("label[for="+oauth_tipe+"]").hide();
		
		$("#"+username).show();
		$("#"+password).show();
		$("label[for="+username+"]").show();
		$("label[for="+password+"]").show();
		
		$("#"+username).addClass('required');
		$("#"+password).addClass('required');
		
		$("#"+oauth_email).removeClass('required');
		$("#"+oauth_id).removeClass('required');
		$("#"+oauth_pass).removeClass('required');
		$("#"+oauth_tipe).removeClass('required');								
		
			
		$("label[for="+username+"]").append("<span class=required> *</span>")
		$("label[for="+password+"]").append("<span class=required> *</span>");
		
		$("label[for="+oauth_email+"]").find($("span[class=required]")).remove();
		$("label[for="+oauth_id+"]").find($("span[class=required]")).remove();
		$("label[for="+oauth_pass+"]").find($("span[class=required]")).remove();
		$("label[for="+oauth_tipe+"]").find($("span[class=required]")).remove();
		
		resetGmailApi();
	}
	
	function callGmailApi(){
		var oauth_email = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_email') ?>';
		var oauth_id = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_id') ?>';
		var oauth_pass = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_pass') ?>';
		var oauth_tipe = '<?php echo CHtml::activeId($model, 'konfigemail_oauth_type') ?>';		
		var username = '<?php echo CHtml::activeId($model, 'konfigemail_username') ?>';
		var password = '<?php echo CHtml::activeId($model, 'konfigemail_password') ?>';
		
		$("#"+oauth_email).show();
		$("#"+oauth_id).show();
		$("#"+oauth_pass).show();
		$("#"+oauth_tipe).show();
		$("label[for="+oauth_email+"]").show();
		$("label[for="+oauth_id+"]").show();
		$("label[for="+oauth_pass+"]").show();
		$("label[for="+oauth_tipe+"]").show();
		
		$("#"+username).hide();
		$("#"+password).hide();
		$("label[for="+username+"]").hide();
		$("label[for="+password+"]").hide();
		
		$("#"+username).removeClass('error required');
		$("#"+password).removeClass('error required');
		
		
		$("#"+oauth_email).addClass('required');
		$("#"+oauth_id).addClass('required');
		$("#"+oauth_pass).addClass('required');
		$("#"+oauth_tipe).addClass('required');								
		
			
		$("label[for="+oauth_email+"]").append("<span class=required> *</span>")
		$("label[for="+oauth_id+"]").append("<span class=required> *</span>");
		$("label[for="+oauth_pass+"]").append("<span class=required> *</span>")
		$("label[for="+oauth_tipe+"]").append("<span class=required> *</span>");
		
		$("label[for="+username+"]").find($("span[class=required]")).remove();
		$("label[for="+password+"]").find($("span[class=required]")).remove();		
		
		resetSMTP();
	}
	
	
	
	$(document).ready(function(){
		cekTipeKirim($("#<?php echo CHtml::activeId($model, 'konfigemail_send_type') ?>"));
	});
</script>

