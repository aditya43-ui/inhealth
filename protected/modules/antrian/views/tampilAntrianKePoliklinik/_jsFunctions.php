<?php
/**
 * view ini digunakan untuk menampung fungsi - fungsi javascript
 * 
 * @author Yusuf Putra Anugrah<yusufputra@.com>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://.com>
 * @link    <http://piindonesia.co.id>
 */
$jenissuara = KonfigsystemK::model()->find(); 
$jenissuara = !empty($jenissuara)?$jenissuara->jenissuaraantrian:'PEREMPUAN';
?>

<script type="text/javascript">
/************************************************************************************************************
(C) www.dhtmlgoodies.com, October 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/	
var fitTextInBox_maxWidth = false;
var fitTextInBox_maxHeight = false;
var fitTextInBox_currentWidth = false;
var fitTextInBox_currentBox = false;
var fitTextInBox_currentTextObj = false;

var cnt_fit = 0;
function fitTextInBox(boxID,maxHeight)
{
        if(maxHeight)fitTextInBox_maxHeight=maxHeight; else fitTextInBox_maxHeight = 10000;
        var obj = document.getElementById(boxID);
		
		// console.log(obj);
		obj.style.whiteSpace = "noWrap";
		
        fitTextInBox_maxWidth = obj.offsetWidth;	
        fitTextInBox_currentBox = obj;
        fitTextInBox_currentTextObj = obj.getElementsByTagName('SPAN')[0];
        fitTextInBox_currentTextObj.style.fontSize = '1px';
        fitTextInBox_currentWidth = fitTextInBox_currentTextObj.offsetWidth;
        fitTextInBoxAutoFit();

}	

function fitTextInBoxAutoFit()
{
        var tmpFontSize = fitTextInBox_currentTextObj.style.fontSize.replace('px','')/1;
        fitTextInBox_currentTextObj.style.fontSize = tmpFontSize + 1 + 'px';
        var tmpWidth = fitTextInBox_currentTextObj.offsetWidth;
        var tmpHeight = fitTextInBox_currentTextObj.offsetHeight;
        if(tmpWidth>=fitTextInBox_currentWidth && tmpWidth<fitTextInBox_maxWidth && tmpHeight<fitTextInBox_maxHeight && tmpFontSize<300){		
                fitTextInBox_currentWidth = fitTextInBox_currentTextObj.offsetWidth;	
                fitTextInBoxAutoFit();
        }else{
                fitTextInBox_currentTextObj.style.fontSize = fitTextInBox_currentTextObj.style.fontSize.replace('px','')/1 - 1 + 'px';
        }		
}

var antrian_arr = [];
var sound_arr = [];
var is_call = false;

function push_arr(obj) {
	antrian_arr.push(obj);
}

function preregister_sound(kodeantrian, antri_terbilang, ruangan) {
	var arr = [];
	var arr_kode = kodeantrian.trim().toLowerCase().split("");
	var arr_no = antri_terbilang.trim().split(" ");
	var i = 0;
	
	arr.push({'name':'noantrian'});
	for (i = 0; i < arr_kode.length; i++) {
		arr.push({'name': arr_kode[i]});
	}
	for (i = 0; i < arr_no.length; i++) {
		arr.push({'name': arr_no[i]});
	}
	
	arr.push({'name':'poliklinik'});
	arr.push({'name':ruangan});
	
	// console.log(arr);
	
	sound_arr.push(arr);
	
}

function call_antrian() {
	is_call = true;
	
	//$(".antrian_big").show();
	//$(".isi_antrian").hide();
	
	console.log(antrian_arr);
	
	if (antrian_arr.length != 0) {
		var data = antrian_arr[0];
		var snd = sound_arr[0];
		var gelarbelakang = "";

		if(data.gelarbelakang_nama !== null)
			gelarbelakang = ", "+data.gelarbelakang_nama;

		$("#ruangan_nama_big > span").html(data.ruangan_nama);
		$("#dokter_big > span").html(data.gelardepan+" "+data.nama_pegawai+gelarbelakang);
		$(".no-antrian_big").html(data.ruangan_singkatan+"-"+data.no_urutantri);
		$("#pasien-deskripsi_big > span").html(data.no_rekam_medik);
		
		registerSuaraAntrian(snd);
		// playAntrian();
	
		setTimeout(function() {
			antrian_arr.shift();
			sound_arr.shift();
			if (antrian_arr.length != 0) call_antrian();
			else {
			//	$(".antrian_big").hide();
			//	$(".isi_antrian").show();
				is_call = false;
			}
		}, 12000);
	}
	// $("#ruangan_nama_big").html(antrian_arr[0].);
}

/**
 * set semua antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setAntrians(pendaftaran_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetAntrians'); ?>',
        data: {layarantrian_id:<?php  echo $_GET['layarantrian_id']; ?>,pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
			var i = 0;
            <?php 
            if(count((array)$modRuangans) > 0){
                foreach($modRuangans AS $i=>$ruangan){
                    if(isset($ruangan->ruangan_id)){
            ?>
                    if(data.r_<?php echo $ruangan->ruangan_id;?>.pasien_id !== null){
						i++;
                        var pendaftaran_id = $("#ruangan_<?php echo $ruangan->ruangan_id;?>  #<?php echo CHtml::activeId($model, 'pendaftaran_id'); ?>").val();
                        // if(data.r_<?php echo $ruangan->ruangan_id;?>.pendaftaran_id != pendaftaran_id){
                            setFormAntrian($("#ruangan_<?php echo $ruangan->ruangan_id;?>"),data.r_<?php echo $ruangan->ruangan_id;?>);
                            var kodeantrian = data.r_<?php echo $ruangan->ruangan_id;?>.ruangan_singkatan;
                            var noantrian = data.r_<?php echo $ruangan->ruangan_id;?>.no_urutantri;
							var ruangan = data.r_<?php echo $ruangan->ruangan_id;?>.ruangan_filesuara;
                            var ruangan_id = data.r_<?php echo $ruangan->ruangan_id;?>.ruangan_id;
							var antri_terbilang = data.r_<?php echo $ruangan->ruangan_id;?>.antri_terbilang;
							var obj = data.r_<?php echo $ruangan->ruangan_id;?>;
							if (antrian_arr.length == 0) is_call = false;
							push_arr(obj);
							preregister_sound(kodeantrian, antri_terbilang, ruangan);                                                        
                             //setSuaraPanggilanSingle(kodeantrian,noantrian,ruangan_id);
                        //}
                    }
					//fitTextInBox('dokter_'+<?php echo $i; ?>,20);
				//	fitTextInBox('pasien-deskripsi_'+<?php echo $i; ?>,20);
            <?php
                }
                }
            }
            ?>
			if (!is_call) call_antrian();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set div antrian
 * @param {type} obj
 * @param {type} data
 * @returns {undefined} */
function setFormAntrian(obj, data){
    $(obj).find("#<?php echo CHtml::activeId($model, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val(data.ruangan_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'carabayar_id'); ?>").val(data.carabayar_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val(data.antrian_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'pegawai_id'); ?>").val(data.pegawai_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_nama'); ?>").val(data.ruangan_nama);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_singkatan'); ?>").val(data.ruangan_singkatan);
    $(obj).find("#<?php echo CHtml::activeId($model, 'tgl_pendaftaran'); ?>").val(data.tgl_pendaftaran);
    $(obj).find("#<?php echo CHtml::activeId($model, 'no_pendaftaran'); ?>").val(data.no_pendaftaran);
    $(obj).find("#<?php echo CHtml::activeId($model, 'no_urutantri'); ?>").val(data.no_urutantri);
    $(obj).find("#<?php echo CHtml::activeId($model, 'no_rekam_medik'); ?>").val(data.no_rekam_medik);
    $(obj).find("#<?php echo CHtml::activeId($model, 'namadepan'); ?>").val(data.namadepan);
    $(obj).find("#<?php echo CHtml::activeId($model, 'nama_pasien'); ?>").val(data.nama_pasien);
    $(obj).find("#<?php echo CHtml::activeId($model, 'gelardepan'); ?>").val(data.gelardepan);
    $(obj).find("#<?php echo CHtml::activeId($model, 'nama_pegawai'); ?>").val(data.nama_pegawai);
    $(obj).find("#<?php echo CHtml::activeId($model, 'gelarbelakang_nama'); ?>").val(data.gelarbelakang_nama);
    $(obj).find("#<?php echo CHtml::activeId($model, 'statuspasien'); ?>").val(data.statuspasien);
    $(obj).find("#<?php echo CHtml::activeId($model, 'panggilantrian'); ?>").val(data.panggilantrian);
    var gelarbelakang = "";
    if(data.gelarbelakang_nama !== null)
        gelarbelakang = ", "+data.gelarbelakang_nama;
    $(obj).find(".dokter").html("<span>"+data.gelardepan+" "+data.nama_pegawai+gelarbelakang+"</span>");
    $(obj).find(".no-antrian").html(data.ruangan_singkatan+"-"+data.no_urutantri);
    $(obj).find(".pasien-deskripsi").html("<span>"+data.no_rekam_medik+"<span>");
}

function setTableStatistik(obj, data){
    $(obj).find("#label_jmlpasien").html("JUMLAH PASIEN "+data.statuspasien);
    
    $(obj).find("#jmlpasien").html(data.jmlpasien);
    $(obj).find("#jmlmenunggu").html(data.jmlmenunggu);
    $(obj).find("#jmlterdaftar").html(data.jmlterdaftar);
}

/**
 * suara panggilan per ruangan
 * @param {type} param
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
    $("#ruangan_"+ruangan_id+" #suarapanggilan").attr("src","<?php echo $this->createUrl('suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
}

/**
 * fungsi .ready() harus tetap di bawah
 * @param {type} param */
$( document ).ready(function() {
    //setAntrians('');
    //setAntriansFarmasi('');
    
    <?php if($konfig->is_nodejsaktif){ ?>
    var chatServer='<?php echo $konfig->nodejs_host ?>';
    if (chatServer == ''){
     chatServer='http://localhost';
    }
    var chatPort='<?php echo $konfig->nodejs_port ?>';
    socket = io.connect(chatServer+':'+chatPort);
    socket.emit('subscribe', 'antrian');
    socket.on('antrian', function(data){
        if (data.panggil == 5) setAntrians(data.antrian_id);
        <?php if (strtolower($this->action->id) == 'indexfarmasi'): ?>
            else if (data.panggil == 5) setAntriansFarmasi(data.antrian_id);
        <?php endif; ?>
    });
    <?php }else{ ?>
    setInterval(function(){setAntrians('');},4000);
    <?php } ?>
    //DINONAKTIF KAN KARENA BERAT JIKA DI EKSEKUSI DI SMART TV BOX (TARAKAN) >> setInterval(function(){reloadHalaman();},1000);

	<?php 
	if(count((array)$modRuangans) > 0){
		foreach($modRuangans AS $i=>$ruangan){
	?>
			//fitTextInBox('ruangan_nama_'+<?php echo $i; ?>,20);
	<?php
		}
	}
	?>
	setJenisSuaraAntrian("<?php echo Yii::app()->request->baseUrl;?>/data/sounds/antrian/mp3/<?php echo $jenissuara ?>/");

    refreshAt(1, 0, 0);
});   

function refreshAt(hours, minutes, seconds) {
    var now = new Date();
    var then = new Date();

    if(now.getHours() > hours ||
       (now.getHours() == hours && now.getMinutes() > minutes) ||
        now.getHours() == hours && now.getMinutes() == minutes && now.getSeconds() >= seconds) {
        then.setDate(now.getDate() + 1);
    }
    then.setHours(hours);
    then.setMinutes(minutes);
    then.setSeconds(seconds);

    var timeout = (then.getTime() - now.getTime());
    setTimeout(function() { window.location.reload(true); }, timeout);
}
</script>