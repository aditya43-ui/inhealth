<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.treeview.js"></script>
<script type="text/javascript">
    var id_form = new Array();
</script>

<!--
    referensi tree jquery
    http://jquery.bassistance.de/treeview/demo/
-->
<div class="white-container">
    <legend class='rim2'>Master <b>Program Kerja</b></legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td width="45%">
                <ul id="browser" class="filetree treeview">
                    <li id="tree_program_kerja">
                        <?php
                            $criteria=new CDbCriteria;
                            $params = array('programkerja_aktif' => true);
                            $criteria->order = 'programkerja_id';
                            $result = $programKerja->findAllByAttributes($params, $criteria);
                            $parent_satu = '';
                            foreach($result as $val)
                            {
                                $params_dua = array(
                                    'subprogramkerja_aktif' => true,
                                    'programkerja_id' => $val->programkerja_id,
                                );
                                $criteria->order = 'subprogramkerja_id';
                                $result_dua = $subProgramKerja->findAllByAttributes($params_dua, $criteria);
                                $parent_dua = '';
                                foreach($result_dua as $val_dua)
                                {
                                    $params_tiga = array(
                                        'kegiatanprogram_aktif' => true,
                                        'subprogramkerja_id' => $val_dua->subprogramkerja_id,
                                    );
                                    $criteria->order = 'kegiatanprogram_id';
                                    $result_tiga = $kegiatanProgram->findAllByAttributes($params_tiga, $criteria);
                                    $parent_tiga = '';
                                    foreach($result_tiga as $val_tiga)
                                    {
                                        $params_empat = array(
                                            'subkegiatanprogram_aktif' => true,
                                            'kegiatanprogram_id' => $val_tiga->kegiatanprogram_id,
                                        );
                                        $criteria->order = 'subkegiatanprogram_id';
                                        $result_empat = $subKegiatanProgram->findAllByAttributes($params_empat, $criteria);
                                        $parent_empat = '';
                                        foreach($result_empat as $val_empat)
                                        {
                                                                                    $parent_empat .= "<li><span class='file'>". $val_empat->subkegiatanprogram_nama ."<span style='float:right'><a value='". $val_empat->subkegiatanprogram_id ."' href='#' onclick='editSubKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk edit sub kegiatan program'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                        }

                                                                            $kode_kelompok_empat = $val->programkerja_kode . '_' . $val_dua->subprogramkerja_kode . '_' . $val_tiga->kegiatanprogram_kode;
                                                                            $id_kelompok_empat = $val_tiga->programkerja_id . '_' . $val_tiga->subprogramkerja_id . '_' . $val_tiga->kegiatanprogram_id;
                                                                            if(count((array)$result_empat) > 0)
                                                                            {
                                                                                    $parent_tiga .= "<li><span class='folder'>". $val_tiga->kegiatanprogram_nama ."<span style='float:right'><a max_kode='". $val_empat->subkegiatanprogram_kode ."' id_pro='". $id_kelompok_empat ."' kode_pro='". $kode_kelompok_empat ."' href='#' onclick='tambahSubKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->kegiatanprogram_id ."' href='#' onclick='editKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk edit kegiatan program'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_empat ."</ul></li>";
                                                                            }else{
                                                                                    $parent_tiga .= "<li class='expandable'><span class='folder'>". $val_tiga->kegiatanprogram_nama ."<span style='float:right'><a max_kode='0' id_pro='". $id_kelompok_empat ."' kode_pro='". $kode_kelompok_empat ."' href='#' onclick='tambahSubKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->kegiatanprogram_id ."' href='#' onclick='editKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk edit kegiatan program'><i class='icon-pencil-brown'></i></a></span></span></li>";                                            
                                                                            }
                                    }

                                    $kode_kelompok = $val->programkerja_kode . '_' . $val_dua->subprogramkerja_kode;
                                    $id_kelompok = $val_dua->programkerja_id . '_' . $val_dua->subprogramkerja_id;
                                    if(count((array)$result_tiga) > 0)
                                    {
                                        $parent_dua .= "<li id='". $id_kelompok ."'><span class='folder'>". $val_dua->subprogramkerja_nama ."<span style='float:right'><a max_kode='". $val_tiga->kegiatanprogram_kode ."' id_pro='". $id_kelompok ."' kode_pro='". $kode_kelompok ."' href='#' onclick='tambahKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->subprogramkerja_id ."' href='#' onclick='editSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit sub program kerja'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_tiga ."</ul></li>";
                                    }else{
                                        $parent_dua .= "<li id='". $id_kelompok ."' class='expandable'><span class='folder'>". $val_dua->subprogramkerja_nama ."<span style='float:right'><a max_kode='0' id_pro='". $id_kelompok ."' kode_pro='". $kode_kelompok ."' href='#' onclick='tambahKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->subprogramkerja_id ."' href='#' onclick='editSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit sub program kerja'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                    }

                                }

                                $value_kode = $val->programkerja_kode;
                                $value_id = $val->programkerja_id;
                                if(count((array)$result_dua) > 0)
                                {
                                    $parent_satu .= "<li id='". $value_id ."'><span class='folder'>". $val->programkerja_nama ."<span style='float:right'><a max_kode='". $val_dua->subprogramkerja_kode ."' id_pro='". $value_id ."' kode_pro='". $value_kode ."' href='#' onclick='tambahSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub program kerja'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->programkerja_id ."' href='#' onclick='editProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit program kerja'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_dua ."</ul></li>";
                                }else{
                                    $parent_satu .= "<li id='". $value_id ."' class='expandable'><span class='folder'>". $val->programkerja_nama ."<span style='float:right'><a max_kode='0' id_pro='". $value_id ."' kode_pro='". $value_kode ."' href='#' onclick='tambahSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub program kerja'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->programkerja_id ."' href='#' onclick='editProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit program kerja'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                }
                            }
                        ?>
                        <span class="folder">
                            Program Kerja
                            <span style="float:right"><a max_kode = "<?php echo isset($val->programkerja_kode) ? $val->programkerja_kode : null; ?>" href="#" onclick="tambahProgramKerja(this);return false;" rel="tooltip" data-original-title="Klik untuk menambah program kerja"><i class="icon-plus-sign"></i></a></span>
                        </span>
                        <?php
                            if(count((array)$result) > 0)
                            {
                                echo '<ul>';
                                echo $parent_satu;
                                echo '</ul>';
                            }                    
                        ?>
                    </li>
                </ul>
            </td>
            <td>
                <div id="content_form">
                    <div style="text-align: center;">Klik Tombol Tambah untuk menampilkan<br>Form Inputan</div>
                </div>
            </td>
        </tr>
    </table>
    <hr>
    <?php
        echo $this->renderPartial($this->path_view.'_dataGridRekening', array('model'=> $rekeningAnggaran));	// menunggu konfirmasi menggunakan tabel view.
        echo $this->renderPartial($this->path_view."_dialogAkun", array(), true);
    ?>
</div>
<script type="text/javascript">
    var frmProgramKerja = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputProgramKerja',array('programKerja'=>$programKerja,'aktif'=>false), true));?>);
	var frmProgramKerjaEdit = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputProgramKerja',array('programKerja'=>$programKerja,'aktif'=>true), true));?>);
	
    var frmSubProgramKerja = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputSubProgramKerja',array('subProgramKerja'=>$subProgramKerja,'aktif'=>false), true));?>);
	var frmSubProgramKerjaEdit = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputSubProgramKerja',array('subProgramKerja'=>$subProgramKerja,'aktif'=>true), true));?>);
	
    var frmKegiatanProgram = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputKegiatanProgram',array('kegiatanProgram'=>$kegiatanProgram,'aktif'=>false), true));?>);
	var frmKegiatanProgramEdit = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputKegiatanProgram',array('kegiatanProgram'=>$kegiatanProgram,'aktif'=>true), true));?>);
	
    var frmSubKegiatanProgram = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputSubKegiatanProgram',array('subKegiatanProgram'=>$subKegiatanProgram,'aktif'=>false), true));?>);
	var frmSubKegiatanProgramEdit = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formInputSubKegiatanProgram',array('subKegiatanProgram'=>$subKegiatanProgram,'aktif'=>true), true));?>);
function setTreeMenu()
{
    $("#browser").treeview({
        animated: "fast",
        collapsed: false,
        unique: true,
        persist: "cookie"
    });
}
setTreeMenu();

function getTreeMenu()
{
    $.ajax({
        url:"<?php echo Yii::app()->createUrl('getTreeMenuAnggaran')?>",
        context:"#tree_program_kerja"
    }).done(
        function(data){
            data = jQuery.parseJSON(data);
            $("#tree_program_kerja").empty();
            
            setTimeout(function(){
                $("#tree_program_kerja").append(data);
                setTreeMenu();
                jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({'placement':'bottom'});
            }, 50);
        }
    );
}

function hapusIndexMenu()
{
    for(key in id_form)
    {
        delete id_form[key];
    }
    $('#content_form').empty();
}

function tambahProgramKerja(obj)
{
    hapusIndexMenu();
    if (id_form['satu'] == undefined){
        $('#content_form').append(frmProgramKerja.replace());
        id_form['satu'] = 'yes';
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;		
		if(!jQuery.isNumeric(max_kode)){
			max_kode = 1;
		}
		        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = "0" + max_kode;
        }
        $('#fieldsetProgramKerja').find("input[name$='[programkerja_kode]']").val(max_kode);
    }
}

function editProgramKerja(obj)
{
    hapusIndexMenu();
    if (id_form['satu'] == undefined){
        $('#content_form').append(frmProgramKerjaEdit.replace());
        id_form['satu'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetProgramKerja').find('legend[class="rim"]').text("Edit Program Kerja");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiProgramKerja');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-program-kerja").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-program-kerja").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-program-kerja").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'programkerja_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-program-kerja").find("input[type=radio][id='SAProgramkerjaM_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}

function tambahSubProgramKerja(obj)
{
    hapusIndexMenu();
    if (id_form['dua'] == undefined){
        $('#content_form').append(frmSubProgramKerja.replace());
        id_form['dua'] = 'yes';
        
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;
        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = "0" + max_kode;
        }
        var kode_pro = $(obj).attr('kode_pro');
        var id_pro = $(obj).attr('id_pro');
        
        $('#fieldsetSubProgramKerja').find("input[name$='[programkerja_id]']").val(id_pro);
        $('#fieldsetSubProgramKerja').find("input[name$='[programkerja_kode]']").val(kode_pro);
        $('#fieldsetSubProgramKerja').find("input[name$='[subprogramkerja_kode]']").val(max_kode);
    }
}

function editSubProgramKerja(obj)
{
    hapusIndexMenu();
    if (id_form['dua'] == undefined){
        $('#content_form').append(frmSubProgramKerjaEdit.replace());
        id_form['dua'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetSubProgramKerja').find('legend[class="rim"]').text("Edit Sub Program Kerja");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiSubProgramKerja');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-subprogram-kerja").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-subprogram-kerja").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-subprogram-kerja").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'rekening2_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-subprogram-kerja").find("input[type=radio][id='SASubprogramkerjaM_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}

function tambahKegiatanProgram(obj)
{
    hapusIndexMenu();
    if (id_form['tiga'] == undefined){
        $('#content_form').append(frmKegiatanProgram.replace());
        id_form['tiga'] = 'yes';
        
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;
        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = "0" + max_kode;
        }        
        
        var kode_pro = $(obj).attr('kode_pro').split("_");
        var id_pro = $(obj).attr('id_pro').split("_");
        
        $('#fieldsetKegiatanProgram').find("input[name$='[programkerja_id]']").val(id_pro[0]);
        $('#fieldsetKegiatanProgram').find("input[name$='[subprogramkerja_id]']").val(id_pro[1]);
        
        $('#fieldsetKegiatanProgram').find("input[name$='[programkerja_kode]']").val(kode_pro[0]);
        $('#fieldsetKegiatanProgram').find("input[name$='[subprogramkerja_kode]']").val(kode_pro[1]);
        $('#fieldsetKegiatanProgram').find("input[name$='[kegiatanprogram_kode]']").val(max_kode);
    }
}

function editKegiatanProgram(obj)
{
    hapusIndexMenu();
    if (id_form['tiga'] == undefined){
        $('#content_form').append(frmKegiatanProgramEdit.replace());
        id_form['tiga'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetKegiatanProgram').find('legend[class="rim"]').text("Edit Kegiatan Program");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiKegiatanProgram');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-kegiatan-program").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-kegiatan-program").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-kegiatan-program").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'kegiatanprogram_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-kegiatan-program").find("input[type=radio][id='SAKegiatanprogramM_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}

function tambahSubKegiatanProgram(obj)
{
    hapusIndexMenu();
    if (id_form['empat'] == undefined){
        $('#content_form').append(frmSubKegiatanProgram.replace());
        id_form['empat'] = 'yes';
        
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;
        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = "0" + max_kode;
        }
        
        var kode_pro = $(obj).attr('kode_pro').split("_");
        var id_pro = $(obj).attr('id_pro').split("_");
        
        $('#fieldsetSubKegiatanProgram').find("input[name$='[programkerja_id]']").val(id_pro[0]);
        $('#fieldsetSubKegiatanProgram').find("input[name$='[subprogramkerja_id]']").val(id_pro[1]);
        $('#fieldsetSubKegiatanProgram').find("input[name$='[kegiatanprogram_id]']").val(id_pro[2]);
        
        $('#fieldsetSubKegiatanProgram').find("input[name$='[programkerja_kode]']").val(kode_pro[0]);
        $('#fieldsetSubKegiatanProgram').find("input[name$='[subprogramkerja_kode]']").val(kode_pro[1]);
        $('#fieldsetSubKegiatanProgram').find("input[name$='[kegiatanprogram_kode]']").val(kode_pro[2]);
        $('#fieldsetSubKegiatanProgram').find("input[name$='[subkegiatanprogram_kode]']").val(max_kode);
    }
}

function editSubKegiatanProgram(obj)
{
    hapusIndexMenu();
    if (id_form['empat'] == undefined){
        $('#content_form').append(frmSubKegiatanProgramEdit.replace());
        id_form['empat'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetSubKegiatanProgram').find('legend[class="rim"]').text("Edit Sub Kegiatan Program");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiSubKegiatanProgram');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-subkegiatan-program").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-subkegiatan-program").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-subkegiatan-program").find("select[name$='["+ key +"]']").val(value);
                    $("#form-subkegiatan-program").find("textarea[name$='["+ key +"]']").val(value);
                    
                    if(key == 'subkegiatanprogram_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-subkegiatan-program").find("input[type=radio][id='SASubkegiatanprogramM_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}
</script>