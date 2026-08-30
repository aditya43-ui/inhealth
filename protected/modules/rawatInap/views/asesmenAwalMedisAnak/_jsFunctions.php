<?php
/**
 * menyimpan semua fungsi - fungsi javascipt yang digunakan oleh menu asesmne awal medis
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
$drop = LookupM::getItemsUrutan('pemeriksaan_lab');
?>

<script type="text/javascript">

    var salah_satu = (obj) => {
        var cek = $(obj).prop('checked');
        $(obj).parents('.kelompok-2').find('input:radio').prop('checked', false);
        
        $(obj).prop('checked', cek);
    }

    var gen_tgl_hasil_eks = () => {
        $('#tabel-hasil-eks').find('.tanggal').datetimepicker(jQuery.extend({
            showMonthAfterYear: false},
                jQuery.datepicker.regional['id'],
                {'dateFormat': '<?= Params::DATE_FORMAT ?>',
                    'changeMonth': true,
                    'changeYear': true,
                    'maxDate': 'd',
                    'timeText': 'Waktu',
                    'hourText': 'Jam',
                    'minuteText': 'Menit',
                    'secondText': 'Detik',
                    'showSecond': true,
                    'timeFormat': 'hh:mm:ss'
                }));
    }

    var set_diagnosis = () => {
        var row = new String(<?= json_encode($this->renderPartial($this->path_view . '_row_diagnosis', ['model' => $modPasienMorbiditas], true)) ?>);

        $("#form-diagnosis > tbody").html(row.replace());

        $('.tanggal-diagnosis').datetimepicker(jQuery.extend({
            showMonthAfterYear: false},
                jQuery.datepicker.regional['id'],
                {'dateFormat': '<?= Params::DATE_FORMAT ?>',
                    'changeMonth': true,
                    'changeYear': true,
                    'maxDate': 'd',
                    'timeText': 'Waktu',
                    'hourText': 'Jam',
                    'minuteText': 'Menit',
                    'secondText': 'Detik',
                    'showSecond': true,
                    'timeFormat': 'hh:mm:ss'
                }));
        return false;
    }

    function AddRowObat() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('addRowRiwayatObat'); ?>',
            dataType: "json",
            success: function (data) {
                if (data.pesan !== "") {
                    window.parent.myAlert(data.pesan);
                    return false;
                }
                $('#tbl-RiwayatObat > tbody').append(data.form);

                     
                renameInputRowRiwayatObat($("#tbl-RiwayatObat"));
                
                 $('.tanggal').datetimepicker(jQuery.extend({
                    showMonthAfterYear: false},
                        jQuery.datepicker.regional['id'],
                        {'dateFormat': '<?= Params::DATE_FORMAT ?>',
                            'changeMonth': true,
                            'changeYear': true,
                            'maxDate': 'd',
                            'timeText': 'Waktu',
                            'hourText': 'Jam',
                            'minuteText': 'Menit',
                            'secondText': 'Detik',
                            'showSecond': true,
                            'timeFormat': 'hh:mm:ss'
                        }));         

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function cekStatusGizi() {
        var kehilanganberatbadan = $('#statusgizi_kehilanganberatbadan:checked').val();
        var asupanmakan = $('#statusgizi_asupanmakankurang:checked').val();
        var penyakit = $('#statusgizi_menderitapenyakitberat:checked').val();
        if (kehilanganberatbadan == null) {
            var kehilanganberatbadan = 0;
        }
        if (asupanmakan == null) {
            var asupanmakan = 0;
        }
        if (penyakit == null) {
            var penyakit = 0;
        }

        var jumlah = parseInt(kehilanganberatbadan) + parseInt(asupanmakan) + parseInt(penyakit);
        console.log('jumlah : ' + jumlah);
        if (jumlah > 1) {
            console.log('>1');
            $('#statusPasien').show();
        } else {
            console.log('<1');
            $('#statusPasien').hide();

        }
    }

    function kebiasaanObat() {
        if ($('#RIAsesmenAwalMedisT_kebiasaan_obat').is(":checked")) {
            $('#RIAsesmenAwalMedisT_kebiasaan_obat_keterangan').attr('readonly', false);
        } else {
            $('#RIAsesmenAwalMedisT_kebiasaan_obat_keterangan').attr('readonly', true);
            $('#RIAsesmenAwalMedisT_kebiasaan_obat_keterangan').val('');
        }
    }
    function tempattinggalLain() {
        if ($('#RIAsesmenAwalMedisT_tempattinggal_lainnya').is(":checked")) {
            $('#RIAsesmenAwalMedisT_tempattinggal_lainnya_keterangan').attr('readonly', false);
        } else {
            $('#RIAsesmenAwalMedisT_tempattinggal_lainnya_keterangan').attr('readonly', true);
            $('#RIAsesmenAwalMedisT_tempattinggal_lainnya_keterangan').val('');
        }
    }
    function tinggalbersamaLain() {
        if ($('#RIAsesmenAwalMedisT_tinggalbersama_lainnya').is(":checked")) {
            $('#RIAsesmenAwalMedisT_tinggalbersama_lainnya_keterangan').attr('readonly', false);
        } else {
            $('#RIAsesmenAwalMedisT_tinggalbersama_lainnya_keterangan').attr('readonly', true);
            $('#RIAsesmenAwalMedisT_tinggalbersama_lainnya_keterangan').val('');
        }
    }
    function masalahkawinAda() {
        if ($('#RIAsesmenAwalMedisT_masalah_perkawinan_ada').is(":checked")) {
            $('#RIAsesmenAwalMedisT_masalah_perkawinan_keterangan').attr('readonly', false);
        } else {
            $('#RIAsesmenAwalMedisT_masalah_perkawinan_keterangan').attr('readonly', true);
            $('#RIAsesmenAwalMedisT_masalah_perkawinan_keterangan').val('');
        }
    }
    function traumahidupAda() {
        if ($('#RIAsesmenAwalMedisT_trauma_kehidupan_ada').is(":checked")) {
            $('#RIAsesmenAwalMedisT_trauma_kehidupan_ada_keterangan').attr('readonly', false);
        } else {
            $('#RIAsesmenAwalMedisT_trauma_kehidupan_ada_keterangan').attr('readonly', true);
            $('#RIAsesmenAwalMedisT_trauma_kehidupan_ada_keterangan').val('');
        }

    }

    function beratBadan(nama) {
        document.getElementById('RIAsesmenAwalMedisT_atropometri_beratbadan2').value = nama.value.toUpperCase();
    }
    function tinggiBadan(nama) {
        document.getElementById('RIAsesmenAwalMedisT_atropometri_tinggibadan2').value = nama.value.toUpperCase();
    }

    function inputRiwayatObat(obj) {
        var nama_obat = $('#nama_obat_clone').val();
        var dosis_obat = $('#dosis_obat_clone').val();
        var carapemberian = $('#carapemberian_clone').val();
        var tglpemberian = $('#tglpemberian_clone').val();

        if (nama_obat != '' && dosis_obat != '' && carapemberian != '' && tglpemberian != '')
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setFormRiwayatObat'); ?>',
                data: {nama_obat: nama_obat, dosis_obat: dosis_obat, carapemberian: carapemberian, tglpemberian: tglpemberian},
                dataType: "json",
                success: function (data) {
                    if (data.pesan !== "") {
                        window.parent.myAlert(data.pesan);
                        return false;
                    }
                    $('#tbl-RiwayatObat > tbody').append(data.form);
                    renameInputRowRiwayatObat($("#tbl-RiwayatObat"));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            window.parent.myAlert("Silakan isikan Form  Riwayat Obat Dahulu!");
        }
    }


    function renameInputRowRiwayatObat(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function () { //element <input>
                var old_name = $(this).attr("id").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }

    function removeObat(obj)
    {
        window.parent.myConfirm("Apakah anda akan menghapus obat?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parent().parent().remove();
                renameInputRowRiwayatObat($("#tbl-RiwayatObat"));
            }
        });
    }

    function hapusBagianTubuh(obj) {

        var bagiantubuh_id = $(obj).parents('tr').find('.bagiantubuh_id').val();
        var pemeriksaangambarawalmedis_id = $(obj).parents('tr').find('.pemeriksaangambarawalmedis_id').val();
        var gambartubuh_id = $(obj).parents('tr').find('.gambartubuh_id').val();
        var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
        var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
        var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();
        var pendaftaran_id = <?php echo!empty($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : "''"; ?>;


        var koor_tubuh_x = kordinat_tubuh_x.replace(/\./g, '_');
        var koor_tubuh_y = kordinat_tubuh_y.replace(/\./g, '_');

        var conf = confirm("Apakah Anda yakin akan menghapus pemeriksaan ini ?");

        //myConfirm("Apakah anda akan menghapus pemeriksaan ini ?","Perhatian!",
        //function(r){
        if (conf) {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('HapusBagianTubuh') ?>",
                data: "bagiantubuh_id=" + bagiantubuh_id + "&pemeriksaangambarawalmedis_id=" + pemeriksaangambarawalmedis_id + "&gambartubuh_id=" + gambartubuh_id + "&kordinat_tubuh_x=" + kordinat_tubuh_x + "&kordinat_tubuh_y=" + kordinat_tubuh_y + "&keterangan_periksa_gbr=" + keterangan_periksa_gbr + "&pendaftaran_id=" + pendaftaran_id,
                dataType: "json",
                success: function (data) {
                    if (data.ok == 0) {
                        window.parent.myAlert(data.pesan);
                    } else {


                        $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="' + bagiantubuh_id + '"]').each(function () {
                            if ($(this).data('delete') == gambartubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y) {
                                $(this).parents('tr').detach();
                            }
                        });
                        console.log('#titikbiru_' + bagiantubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y);
                        $("#imgtag" + gambartubuh_id).find('#titikbiru_' + bagiantubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y).detach();
                        renameInputRow($('#table-bagtubuh'), $("#imgtag" + gambartubuh_id));

                        alert(data.pesan);
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
        //}); 
    }





    function titikSebelumSimpan(ptitikX, ptitikY, bagiantubuh_id, img, counter) {
        var titikX = Math.round(ptitikX) - 10;
        var titikY = Math.round(ptitikY) - 10;
        var color = 'rgba(219, 50, 92, 0.9)';
        var size = '5px';

        var xtitik = ptitikX.replace(/\./g, '_');
        var ytitik = ptitikY.replace(/\./g, '_');


        $(img).append(
                $('<div class="urut-titik" id="titik_' + bagiantubuh_id + '_' + xtitik + '_' + ytitik + '"><strong id="dettag" style="position:absolute;top:0;left:7px;color:#fff;">' + counter + '</strong></div>')
                .css('position', 'absolute')
                .css('top', titikY + 'px')
                .css('left', titikX + 'px')
                .css('width', size)
                .css('height', size)
                .css('background-color', color)
                .css('cursor', 'pointer')
                .css('display', 'block')
                .css('padding', '10px')
                .css('-webkit-border-radius', '50%')
                .css('-moz-border-radius', '50%')
                .css('border-radius', '50%')
                .css('font-size', '10px')
                .css('color', 'black')
                );
    }

    function titikSesudahSimpan(titikX, titikY, urutan, bagiantubuh_id, img) {
        var x_titik = titikX.toFixed(7);
        var y_titik = titikY.toFixed(7);

        var titikX = titikX - 15;
        var titikY = titikY - 15;
        var nomor = urutan + 1;
        var color = 'rgba(0, 128, 255, 0.8)';
        var size = '5px';

        x_titik = x_titik.replace(/\./g, '_');
        y_titik = y_titik.replace(/\./g, '_');

        $(img).append(
                $('<div class="urut-titik" id="titikbiru_' + bagiantubuh_id + '_' + x_titik + '_' + y_titik + '"><strong id="dettag" style="position:absolute;top:0;left:7px;color:#fff;">' + nomor + '</strong></div>')
                .css('position', 'absolute')
                .css('top', titikY + 'px')
                .css('left', titikX + 'px')
                .css('width', size)
                .css('height', size)
                .css('background-color', color)
                .css('cursor', 'pointer')
                .css('display', 'block')
                .css('padding', '10px')
                .css('-webkit-border-radius', '50%')
                .css('-moz-border-radius', '50%')
                .css('border-radius', '50%')
                .css('vertical-align', 'middle')
                .css('font-size', '10px')
                .css('color', 'black')
                );
    }

    function loadTitikSesudahSimpan() {
<?php
if (!empty($modPemeriksaanGambar)) {
    $j = 1;
    foreach ($modPemeriksaanGambar as $i => $v) {
        ?>
                console.log(<?php echo $v->kordinat_tubuh_x; ?>);
                titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i . ',' . $v->bagiantubuh_id ?>, '#imgtag<?php echo $v->gambartubuh_id; ?>');

        <?php $j++;
    }
}
?>
    }

    function dokterdpjp() {
        $('#dokter_nama').val('<?php echo $dokter ?>');
        $('#dokterdpjp_nama').val('<?php echo $dpjp ?>');
        $('#ppds_nama').val('<?php echo $ppds ?>');

    }


    function renameInputRow(obj_table, obj_table2) {
        var i, j;
        var row_image = 0;
        i = row_image;
        j = row_image;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(j + 1);
            j++;
        });
        $('#gambar-container').find(".urut-titik").each(function () {

            $(this).find('#dettag').html(i + 1);
            $(this).find('#dettag').css('color', 'white').css('font-size', '12px').css('font-weight', 'bold').css('font-weight', 'bold')
                    .css('position', 'absolute')
                    .css('top', 0 + 'px')
                    .css('left', 7 + 'px');

            i++;
        });
        counter = i + 1;

    }

    function batalTambahBagianTubuh(obj) {
        var conf = confirm("Apakah Anda yakin akan membatalkan pemilihan pemeriksaan ini ?");

        //myConfirm("Apakah anda akan membatalkan pemilihan pemeriksaan ini ?","Perhatian!",
        // function(r){
        if (conf) {
            var bagiantubuh_id = $(obj).parents('tr').find('input[name$="[bagiantubuh_id]"]').val();
            var gambartubuh_id = $(obj).parents('tr').find('input[name$="[gambartubuh_id]"]').val();
            var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
            var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
            var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();

            kordinat_tubuh_x = kordinat_tubuh_x.replace(/\./g, '_');
            kordinat_tubuh_y = kordinat_tubuh_y.replace(/\./g, '_');

            $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="' + bagiantubuh_id + '"]').each(function () {
                //$(obj).parents('tbody').find('input[name$="[gambartubuh_id]"][value="'+gambartubuh_id+'"]').each(function(){
                //alert($(this).attr('delete'));
                if ($(this).data('delete') == gambartubuh_id + '_' + kordinat_tubuh_x + '_' + kordinat_tubuh_y) {
                    $(this).parents('tr').detach();
                }
                //})
                //$(this).parents('tr').detach();
            });
            $("#imgtag" + gambartubuh_id).find('#titik_' + bagiantubuh_id + '_' + kordinat_tubuh_x + '_' + kordinat_tubuh_y).detach();
            renameInputRow($('#table-bagtubuh'), $("#imgtag" + gambartubuh_id));

        }
        // }); 
    }
    var counter = 1;
    $(document).ready(function () {
        dokterdpjp();
        loadTitikSesudahSimpan();
        setValidasiCekDisabled($("#asesmen-awal-medis-form"), function () {
            if ($(".cek:checked").length == 0) {
                return false;
            }
            return true;
        });
        //untuk mengambil list row pada tabel terakhir
        var lastrow = $('#table-bagtubuh tr:last-child').find('#no_urut').val();
        if (lastrow != null) {
            counter = parseInt(lastrow) + 1;
        }

        var mouseX = 0;
        var mouseY = 0;

        $("[id^=imgtag] img").click(function (e) { // make sure the image is click
            var imgtag = $(this).parent(); // get the div to append the tagging list
            var no_img = $(this).attr('img-no');


            var gambartubuh_id = $(this).attr('alt');
            mouseX = (e.pageX - $(imgtag).offset().left); // x and y axis
            mouseY = (e.pageY - $(imgtag).offset().top);

            if (mouseX != 0 && mouseY != 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createUrl('getBagianTubuhId') ?>",
                    data: "kordinat_x=" + mouseX + "&kordinat_y=" + mouseY + "&gambartubuh_id=" + no_img,
                    dataType: "json",
                    success: function (data) {
                        $('#titikklik' + no_img).remove(); // menghapus titik lain selain titik current klik
                        $("#imgtag" + no_img).append(
                                $('<div id="titikklik' + no_img + '">' + counter + '</div>')
                                .css('position', 'absolute')
                                .css('top', Math.round(mouseY) - 10 + 'px')
                                .css('left', Math.round(mouseX) - 10 + 'px')
                                .css('width', '5px')
                                .css('height', '5px')
                                .css('background-color', 'rgba(219, 50, 92, 0.5)')
                                .css('cursor', 'pointer')
                                .css('display', 'block')
                                .css('padding', '5px')
                                .css('-webkit-border-radius', '50%')
                                .css('-moz-border-radius', '50%')
                                .css('border-radius', '50%')
                                .css('font-size', '10px')
                                .css('color', 'black')
                                );
                        var html = '<div id="tagit' + no_img + '">\n\
                                    <div class="name"><br>\n\
                                            <div class="text"><strong>Data Pemeriksaan</strong></div>\n\
                                            <table>\n\
                                                    <tr>\n\
                                                            <td>Bagian Tubuh : </td>\n\
                                                            <td>\n\<input type="hidden" id="gambartubuh_id' + no_img + '" value="' + gambartubuh_id + '">\n\
                                                            ';

                        if (data.pesan != "") {
                            html += '<select id="bagiantubuh_id' + no_img + '" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
                                                                <option value="">-- Pilih --</option>\n\
<?php foreach ($modBagianTubuh->BagianTubuh as $key => $value) { ?>\n\
                                                                            <option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
<?php } ?>\n\
                                                            </select>\n\
                                                            <br><i><small>Koordinat belum disetting.</small></i>\n\
                                                            ';
                        } else {
                            html += '<input type="hidden" name="bagiantubuh_id" id="bagiantubuh_id' + no_img + '" value="' + data.bagiantubuh_id + '" class="span2"/>\n\
                                                                    ';
                            html += '<input type="text" name="namabagtubuh" id="namabagtubuh' + no_img + '" value="' + data.namabagtubuh + '" class="span2"/>\n\
                                                                    ';
                        }

                        html += '		</td>\n\
                                                    </tr>\n\
                                                    <tr>\n\
                                                        <td>Keterangan : </td>\n\
                                                        <td><textarea id ="keterangan' + no_img + '" class="span2" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?><br>\n\</td>\n\
                                                </tr>\n\
                                            </table>\n\
                                                    <input img-no="' + no_img + '" type="button" name="btnsave" value="Tambah" id="btnsave' + no_img + '" />\n\
                                                    <input img-no="' + no_img + '" type="button" name="btncancel" value="Cancel" id="btncancel' + no_img + '" /><br><br>\n\
                                            </div>\n\
                                    </div>';

                        $('#tagit' + no_img).remove( ); // remove any tagit div first
                        $(imgtag).append(html);
                        $('#tagit' + no_img).css({top: mouseY, left: mouseX});

                        $('#tagname' + no_img).focus();

                        //					}

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

        });



        // Save button click - save tags
        //#btnsave
        //$("#tagit1 #btnsave1").click(function(){ 
        $(document).on('click', '[id^=tagit] [id^=btnsave]', function () {
            var no_img = $(this).attr('img-no');
            var bagiantubuh_id = $('#bagiantubuh_id' + no_img).val();
            var keterangan = $('#keterangan' + no_img).val();
            var gambartubuh_id = $('#gambartubuh_id' + no_img).val();
            var img = $('#imgtag' + no_img).find('img');
            var id = $(img).attr('id');
            //var koorX = $( img ).attr( 'mousex' );
            //var koorY = $( img ).attr( 'mousey' );

            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('tambahBagianTubuh') ?>",
                data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&keterangan=" + keterangan + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert" + "&gambartubuh_id=" + gambartubuh_id,
                dataType: "json",
                success: function (data) {
                    if (data.pesan != "") {
                        window.parent.myAlert(data.pesan);
                    } else {
                        $('#table-bagtubuh > tbody').append(data.form);
                        renameInputRowRiwayatObat($('#table-bagtubuh'));
                        titikSebelumSimpan(data.axis['x'], data.axis['y'], data.bagiantubuh_id, '#imgtag' + no_img, counter);
                        counter += 1;
                    }
//          viewtag( id );
                    $('#tagit' + no_img).fadeOut();
                    $('#titikklik' + no_img).remove();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        });


        // Cancel the tag box.
        $(document).on('click', '[id^=tagit] [id^=btncancel]', function () {
            var no_img = $(this).attr('img-no');
            $('#tagit' + no_img).fadeOut();
            $('#titikklik' + no_img).remove();
        });

        // mouseover the taglist 
        $('#taglist').on('mouseover', 'li', function ( ) {
            id = $(this).attr("id");
            $('#view_' + id).css({opacity: 1.0});
        }).on('mouseout', 'li', function ( ) {
            $('#view_' + id).css({opacity: 0.0});
        });

        // mouseover the tagboxes that is already there but opacity is 0.
        $('#tagbox').on('mouseover', '.tagview', function ( ) {
            var pos = $(this).position();
            $(this).css({opacity: 1.0}); // div appears when opacity is set to 1.
        }).on('mouseout', '.tagview', function ( ) {
            $(this).css({opacity: 0.0}); // hide the div by setting opacity to 0.
        });

        // Remove tags.
        $('#taglist').on('click', '.remove', function () {
            id = $(this).parent().attr("id");
            // Remove the tag
            $.ajax({
                type: "POST",
                url: "savetag.php",
                data: "tag_id=" + id + "&type=remove",
                success: function (data) {
                    var img = $('#imgtag').find('img');
                    var id = $(img).attr('id');
                    //get tags if present
                    viewtag(id);
                }
            });
        });

        // load the tags for the image when page loads.
        var img = $('#imgtag').find('img');
        var id = $(img).attr('id');



    });
</script> 

<script type="text/javascript">

    function cekRiwayatAlergi(obj) {
        $("#riwayatalergi").find("input:text").each(function () {
            $(this).attr("disabled", true);

            if ($(this).parents(".control-group").find('input:checkbox').prop("checked") == true) {
                $(this).removeAttr("disabled");
            } else {
                $(this).val('');
            }
        });

        if ($(obj).prop("checked") == true) {
            $(this).parents(".control-group").find('input:text').val('');
        } else if ($(obj).prop("checked") == false) {
            $(this).parents(".control-group").find('input:text').val('');
        }
    }

    function cekRiwayatImunisasi(obj) {
        $("#riwayatimunasi").find("input:text").each(function () {
            $(this).attr("disabled", true);

            if ($(this).parents(".control-group").find('input:checkbox').prop("checked") == true) {
                $(this).removeAttr("disabled");
            } else {
                $(this).val('');
            }
        });

        if ($(obj).prop("checked") == true) {
            $(this).parents(".control-group").find('input:text').val('');
        } else if ($(obj).prop("checked") == false) {
            $(this).parents(".control-group").find('input:text').val('');
        }
    }

    function cekRiwayatTumbuh(obj) {
        $("#riwayattumbuh").find("input:text").each(function () {
            $(this).attr("disabled", true);

            if ($(this).parents(".control-group").find('input:checkbox').prop("checked") == true) {
                $(this).removeAttr("disabled");
            } else {
                $(this).val('');
            }
        });

        if ($(obj).prop("checked") == true) {
            $(this).parents(".control-group").find('input:text').val('');
        } else if ($(obj).prop("checked") == false) {
            $(this).parents(".control-group").find('input:text').val('');
        }
    }


    /**      
     * @param {type} obj
     * @returns {semua checkbox yang memiliki label normal akan terceklis, yaitu dari label kepala sampai Genitalia,Anus dan rektum pada kelompok data pemeriksaan umum}      
     *  
     */
    function pilihNormal(obj) {
        $(".pemeriksaanumum-normal").find('input:checkbox').each(function () {

            if ($(obj).prop("checked") == true) {
                $(this).prop("checked", false);
                if ($(this).hasClass('pilih-normal')) {
                    $(this).prop("checked", true);
                }

            } else {
                $(this).prop("checked", false);
            }
        });

        $(".pemeriksaanumum-normal").find('input:checkbox.lainlain').each(function () {
            if ($(this).prop("checked") == true) {
                $(this).parents('.control-group').find('.laintext').removeAttr('readonly');
                $(this).parents('.control-group').find('.laintext').val('');
            } else {
                $(this).parents('.control-group').find('.laintext').attr('readonly', true);
                $(this).parents('.control-group').find('.laintext').val('');
            }

        });
    }

    function jumlah() {
        var beratBadan = parseFloat($("#RIAsesmenAwalMedisT_beratbadan").val());
        var tinggiBadan = parseFloat($("#RIAsesmenAwalMedisT_tinggibadan").val());
        if ($("#RIAsesmenAwalMedisT_tinggibadan").val() != "") {
            var tinggiBadanMeter = tinggiBadan / 100;
            var luasbadanfix = Math.round(beratBadan / (tinggiBadan * tinggiBadan));
            var hasil = Math.round(beratBadan / (tinggiBadanMeter * tinggiBadanMeter));
        } else {
            var tinggiBadanMeter = 0;
            var hasil = 0;
            var luasbadanfix = 0
        }
        $("#RIAsesmenAwalMedisT_luasbadan").val(luasbadanfix);
        $("#RIAsesmenAwalMedisT_nilai_bmi").val(hasil);
        if (jQuery.isNumeric(hasil)) {
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi: hasil}, function (data) {
                $('#RIAsesmenAwalMedisT_bodymassindex_nama').val(data.text);
                $('#RIAsesmenAwalMedisT_bodymassindex_id').val(data.id);
            }, 'json');
        }
    }

    function cekBeratTinggi() {
        var beratBadan = parseFloat($("#RIAsesmenAwalMedisT_beratbadan").val());
        var tinggiBadan = parseFloat($("#RIAsesmenAwalMedisT_tinggibadan").val());
        if ($("#RIAsesmenAwalMedisT_tinggibadan").val() != "") {
            var tinggiBadanMeter = tinggiBadan;
            var beratBadanKg = beratBadan;
        } else {
            var tinggiBadanMeter = 0;
            var beratBadanKg = 0
        }
        $("#AsesmenAwalMedisT_atropometri_tinggibadan").val(tinggiBadanMeter);
        $("#RIAsesmenAwalMedisT_atropometri_beratbadan").val(beratBadanKg);
        $("#AsesmenAwalMedisT_atropometri_tinggibadan2").val(tinggiBadanMeter);
        $("#AsesmenAwalMedisT_atropometri_beratbadan2").val(beratBadanKg);
    }

    $(document).ready(function () {

        cekRiwayatAlergi();
        cekRiwayatImunisasi();
        cekRiwayatTumbuh();

        $(".pemeriksaanumum-normal").find('input:checkbox').click(function () {
            var tidaknormal = 0;
            var cekHasClassNormal = $(this).hasClass('pilih-normal');

            $(".pemeriksaanumum-normal").find('input:checkbox').each(function () {
                if ($(this).hasClass('pilih-normal')) {
                    if ($(this).prop("checked") == false) {// normal di uncek
                        tidaknormal++;
                    } else {

                    }
                } else {
                    if ($(this).parents('.control-group').find('.pilih-normal').prop("checked") == true) { //tidak normal di cek
                        if (cekHasClassNormal) {
                            $(this).prop("checked", false);
                        } else {
                            if ($(this).prop("checked") == true) {
                                $(this).parents('.control-group').find('.pilih-normal').prop("checked", false);
                                tidaknormal++;
                            }
                        }
                    } else {
                        $(this).parents('.control-group').find('.pilih-normal').prop("checked", false);
                        tidaknormal++;
                    }
                }
            });

            if (tidaknormal > 0) {
                $("#pilihSemuaPeriksaUmum").prop("checked", false);
            } else {
                $("#pilihSemuaPeriksaUmum").prop("checked", true);
            }

            $(".pemeriksaanumum-normal").find('input:checkbox.lainlain').each(function () {
                if ($(this).prop("checked") == true) {
                    $(this).parents('.control-group').find('.laintext').removeAttr('readonly');
                    $(this).parents('.control-group').find('.laintext').val('');
                } else {
                    $(this).parents('.control-group').find('.laintext').attr('readonly', true);
                    $(this).parents('.control-group').find('.laintext').val('');
                }

            });
        });


        $(".cekbox-nyeri").find('input:checkbox').click(function () {
            $(".cekbox-nyeri").find('input:checkbox').each(function () {
                $(this).prop("checked", false);
            });
            $(this).prop("checked", true);
        });

        $(".riwayat-penyakit-dahulu").find('input:checkbox').click(function () {
            var cekHasClassTidakAda = $(this).hasClass('tidak-ada');
            var cek_lain = $(this).parents('.riwayat-penyakit-dahulu').find('.lainlain').prop('checked');
            var cek_lis = $(this).prop('checked');

            if (cekHasClassTidakAda == true) {
                $(".riwayat-penyakit-dahulu").find('input:checkbox').each(function () {
                    $(this).prop("checked", false);
                });
                var cek_lain = $(this).parents('.riwayat-penyakit-dahulu').find('.lainlain').prop('checked');
            } else {
                $(".riwayat-penyakit-dahulu").find('.tidak-ada').prop("checked", false);
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            }

            if (cek_lain == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_dulu_lainnya_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_dulu_lainnya_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_dulu_lainnya_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_dulu_lainnya_ket') ?>").val('');
            }
        });

        $(".riwayat-penyakit-keluarga").find('input:checkbox').click(function () {
            var cekHasClassTidakAdaKeluarga = $(this).hasClass('tidak-ada-keluarga');
            var cek_lain = $(this).parents('.riwayat-penyakit-keluarga').find('.lainlain').prop('checked');
            var cek_lis = $(this).prop('checked');

            if (cekHasClassTidakAdaKeluarga == true) {
                $(".riwayat-penyakit-keluarga").find('input:checkbox').each(function () {
                    $(this).prop("checked", false);
                });
                var cek_lain = $(this).parents('.riwayat-penyakit-keluarga').find('.lainlain').prop('checked');
            } else {
                $(".riwayat-penyakit-keluarga").find('.tidak-ada-keluarga').prop("checked", false);
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            }

            if (cek_lain == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_lainnya_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_lainnya_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_lainnya_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_lainnya_ket') ?>").val('');
            }
        });
        $("#cek-imunasi").find('input:checkbox').click(function () {
            var cek_polio = $(this).parents('#cek-imunasi').find('.polio').prop('checked');
//            var cek_hepatitisb = $(this).parents('#cek-imunasi').find('.hepatitisb').prop('checked');
//            var cek_dpt = $(this).parents('#cek-imunasi').find('.dpt').prop('checked');
//            var cek_campak = $(this).parents('#cek-imunasi').find('.campak').prop('checked');
//            var cek_lainlain = $(this).parents('#cek-imunasi').find('.lainlain').prop('checked');

            if (cek_polio == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_polio_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_polio_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_polio_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_polio_ket') ?>").val('');
            }
//            if(cek_hepatitisb == true) {
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb_ket') ?>").attr('readonly',false);                                  
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb_ket') ?>").val('');
//            }else{
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb_ket') ?>").attr('readonly',true);                                                   
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb_ket') ?>").val('');
//            }
//            if(cek_dpt == true) {
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt_ket') ?>").attr('readonly',false);                                  
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt_ket') ?>").val('');
//            }else{
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt_ket') ?>").attr('readonly',true);                                                   
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt_ket') ?>").val('');
//            }
//            if(cek_campak == true) {
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_campak_ket') ?>").attr('readonly',false);                                  
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_campak_ket') ?>").val('');
//            }else{
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_campak_ket') ?>").attr('readonly',true);                                                   
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_campak_ket') ?>").val('');
//            }
//            if(cek_lainlain == true) {
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya_ket') ?>").attr('readonly',false);                                  
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya_ket') ?>").val('');
//            }else{
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya_ket') ?>").attr('readonly',true);                                                   
//                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya_ket') ?>").val('');
//            }
        });
        $(".riwayat-tumbuh").find('input:checkbox').click(function () {
            var cekHasClassKepala = $(this).hasClass('bcg');
            var cek_bicara = $(this).parents('.riwayat-tumbuh').find('.bicara').prop('checked');
            var cek_berjalan = $(this).parents('.riwayat-tumbuh').find('.berjalan').prop('checked');
            var cek_berdiri = $(this).parents('.riwayat-tumbuh').find('.berdiri').prop('checked');
            var cek_merangkak = $(this).parents('.riwayat-tumbuh').find('.merangkak').prop('checked');
            var cek_duduk = $(this).parents('.riwayat-tumbuh').find('.duduk').prop('checked');
            var cek_badan = $(this).parents('.riwayat-tumbuh').find('.badan').prop('checked');
            var cek_kepala = $(this).parents('.riwayat-tumbuh').find('.kepala').prop('checked');
            var cek_lis = $(this).prop('checked');

            if (cekHasClassKepala == true) {
                $(".riwayat-tumbuh").find('input:checkbox').each(function () {
                    $(this).prop("checked", false);
                });
                var cek_bicara = $(this).parents('.riwayat-tumbuh').find('.bicara').prop('checked');
                var cek_berjalan = $(this).parents('.riwayat-tumbuh').find('.berjalan').prop('checked');
                var cek_berdiri = $(this).parents('.riwayat-tumbuh').find('.berdiri').prop('checked');
                var cek_merangkak = $(this).parents('.riwayat-tumbuh').find('.merangkak').prop('checked');
                var cek_duduk = $(this).parents('.riwayat-tumbuh').find('.duduk').prop('checked');
                var cek_badan = $(this).parents('.riwayat-tumbuh').find('.badan').prop('checked');
                var cek_kepala = $(this).parents('.riwayat-tumbuh').find('.kepala').prop('checked');
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            }

            if (cek_bicara == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_bicara_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_bicara_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_bicara_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_bicara_ket') ?>").val('');
            }
            if (cek_berjalan == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berjalan_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berjalan_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berjalan_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berjalan_ket') ?>").val('');
            }
            if (cek_berdiri == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berdiri_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berdiri_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berdiri_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berdiri_ket') ?>").val('');
            }
            if (cek_merangkak == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_merangkak_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_merangkak_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_merangkak_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_merangkak_ket') ?>").val('');
            }
            if (cek_duduk == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_duduk_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_duduk_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_duduk_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_duduk_ket') ?>").val('');
            }
            if (cek_badan == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_membalikbadan_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_membalikbadan_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_membalikbadan_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_membalikbadan_ket') ?>").val('');
            }
            if (cek_kepala == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_menegakkankepala_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_menegakkankepala_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_menegakkankepala_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_menegakkankepala_ket') ?>").val('');
            }
        });

        $(".riwayat-persalinan").find('input:checkbox').click(function () {
            var cekHasClassBidan = $(this).hasClass('bidan');
            var cek_lain = $(this).parents('.riwayat-persalinan').find('.lainlain').prop('checked');
            var cek_lis = $(this).prop('checked');

            if (cekHasClassBidan == true) {
                $(".riwayat-persalinan").find('input:checkbox').each(function () {
                    $(this).prop("checked", false);
                });
                var cek_lain = $(this).parents('.riwayat-persalinan').find('.lainlain').prop('checked');
            } else {
                $(".riwayat-persalinan").find('.bidan').prop("checked", false);
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            }

            if (cek_lain == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_persalinan_olehlainnya_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_persalinan_olehlainnya_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_persalinan_olehlainnya_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'riwayat_persalinan_olehlainnya_ket') ?>").val('');
            }
        });

        $(".cekbox-reflekfisiologis").find('input:checkbox').click(function () {
            $(".cekbox-reflekfisiologis").find('input:checkbox').each(function () {
                $(this).prop("checked", false);
            });
            $(this).prop("checked", true);
        });

        $('#cek-reflekpathologis').find('input:checkbox').click(function () {
            var cek_lain = $(this).hasClass('lainlainreflekpathologis');
            var cek_lis = $(this).prop('checked');

            $('#cek-reflekpathologis').find('input:checkbox').each(function () {
                $(this).prop('checked', false);
            });

            if (cek_lis == true) {
                $(this).prop('checked', true);

                if (cek_lain == true) {
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlainket') ?>").attr('readonly', false);
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlainket') ?>").val('');
                } else {
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlainket') ?>").attr('readonly', true);
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlainket') ?>").val('');
                }
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlainket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlainket') ?>").val('');
            }
        });

        $(".status-psikososial").find('input:checkbox').click(function () {
            var cekHasClassTidakBermasalah = $(this).hasClass('tidakBermasalah');
            var cek_lain = $(this).parents('.status-psikososial').find('.lainnya').prop('checked');
            var cek_lis = $(this).prop('checked');

            if (cekHasClassTidakBermasalah == true) {
                $(".status-psikososial").find('input:checkbox').each(function () {
                    $(this).prop("checked", false);
                });
                var cek_lain = $(this).parents('.status-psikososial').find('.lainnya').prop('checked');
            } else {
                $(".status-psikososial").find('.tidakBermasalah').prop("checked", false);
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            }

            if (cek_lain == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'status_psikososial_lainnya_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'status_psikososial_lainnya_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'status_psikososial_lainnya_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'status_psikososial_lainnya_ket') ?>").val('');
            }
        });

        $("#cek-kondisikhusus").find('input:checkbox').click(function () {
            var cek_lain = $(this).parents('#cek-kondisikhusus').find('.lainlain').prop('checked');
            var cek_lis = $(this).prop('checked');

            if (cek_lain == true) {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'kondisikhusus_lainnya_ket') ?>").attr('readonly', false);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'kondisikhusus_lainnya_ket') ?>").val('');
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'kondisikhusus_lainnya_ket') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'kondisikhusus_lainnya_ket') ?>").val('');
            }
        });

        $(".lab").find('input:checkbox').click(function () {
            var cek = $(this).hasClass('tidak-normal-lab');
            var cek_lis = $(this).prop('checked');

            if (cek == true) {
                $("#RIAsesmenAwalMedisT_laboratorium_tidaknormal_ket").attr('readonly', false);
                $("#RIAsesmenAwalMedisT_laboratorium_tidaknormal_ket").val('');
                $(".lab").find('input:checkbox').each(function () {
                    $(this).prop("checked", false);
                });
            } else {
                $(".lab").find('.tidak-normal-lab').prop("checked", false);
                $("#RIAsesmenAwalMedisT_laboratorium_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_laboratorium_tidaknormal_ket").val('');
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            } else {
                $("#RIAsesmenAwalMedisT_laboratorium_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_laboratorium_tidaknormal_ket").val('');
            }
        });

        $('.thorax').find('input:checkbox').click(function () {
            var cek_thorax = $(this).hasClass('tidak-normal-thorax');
            var cek_lis = $(this).prop('checked');

            if (cek_thorax == true) {
                $("#RIAsesmenAwalMedisT_radiologi_thorax_tidaknormal_ket").attr('readonly', false);
                $("#RIAsesmenAwalMedisT_radiologi_thorax_tidaknormal_ket").val('');
                $('.thorax').find('input:checkbox').each(function () {
                    $(this).prop('checked', false);
                });
            } else {
                $('.thorax').find('.tidak-normal-thorax').prop('checked', false);
                $("#RIAsesmenAwalMedisT_radiologi_thorax_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_thorax_tidaknormal_ket").val('');
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            } else {
                $("#RIAsesmenAwalMedisT_radiologi_thorax_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_thorax_tidaknormal_ket").val('');
            }
        });

        $('.ctscan').find('input:checkbox').click(function () {
            var cek_ctscan = $(this).hasClass('tidak-normal-ctscan');
            var cek_lis = $(this).prop('checked');

            if (cek_ctscan == true) {
                $("#RIAsesmenAwalMedisT_radiologi_ctscan_tidaknormal_ket").attr('readonly', false);
                $("#RIAsesmenAwalMedisT_radiologi_ctscan_tidaknormal_ket").val('');
                $('.ctscan').find('input:checkbox').each(function () {
                    $(this).prop('checked', false);
                });
            } else {
                $('.ctscan').find('.tidak-normal-ctscan').prop('checked', false);
                $("#RIAsesmenAwalMedisT_radiologi_ctscan_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_ctscan_tidaknormal_ket").val('');
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            } else {
                $("#RIAsesmenAwalMedisT_radiologi_ctscan_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_ctscan_tidaknormal_ket").val('');
            }
        });

        $('.mri').find('input:checkbox').click(function () {
            var cek_ctscan = $(this).hasClass('tidak-normal-mri');
            var cek_lis = $(this).prop('checked');

            if (cek_ctscan == true) {
                $("#RIAsesmenAwalMedisT_radiologi_mri_tidaknormal_ket").attr('readonly', false);
                $("#RIAsesmenAwalMedisT_radiologi_mri_tidaknormal_ket").val('');
                $('.mri').find('input:checkbox').each(function () {
                    $(this).prop('checked', false);
                });
            } else {
                $('.mri').find('.tidak-normal-mri').prop('checked', false);
                $("#RIAsesmenAwalMedisT_radiologi_mri_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_mri_tidaknormal_ket").val('');

            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            } else {
                $("#RIAsesmenAwalMedisT_radiologi_mri_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_mri_tidaknormal_ket").val('');
            }
        });

        $('.usg').find('input:checkbox').click(function () {
            var cek_ctscan = $(this).hasClass('tidak-normal-usg');
            var cek_lis = $(this).prop('checked');

            if (cek_ctscan == true) {
                $("#RIAsesmenAwalMedisT_radiologi_usg_tidaknormal_ket").attr('readonly', false);
                $("#RIAsesmenAwalMedisT_radiologi_usg_tidaknormal_ket").val('');
                $('.usg').find('input:checkbox').each(function () {
                    $(this).prop('checked', false);
                });
            } else {
                $('.usg').find('.tidak-normal-usg').prop('checked', false);
                $("#RIAsesmenAwalMedisT_radiologi_usg_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_usg_tidaknormal_ket").val('');
            }

            if (cek_lis == true) {
                $(this).prop("checked", true);
            } else {
                $("#RIAsesmenAwalMedisT_radiologi_usg_tidaknormal_ket").attr('readonly', true);
                $("#RIAsesmenAwalMedisT_radiologi_usg_tidaknormal_ket").val('');
            }
        });

        $('#cek-caramasuk').find('input:checkbox').click(function () {
            var cek_lain = $(this).hasClass('lainlain');
            var cek_lis = $(this).prop('checked');

            $('#cek-caramasuk').find('input:checkbox').each(function () {
                $(this).prop('checked', false);
            });

            if (cek_lis == true) {
                $(this).prop('checked', true);

                if (cek_lain == true) {
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan') ?>").attr('readonly', false);
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan') ?>").val('');
                } else {
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan') ?>").attr('readonly', true);
                    $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan') ?>").val('');
                }
            } else {
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan') ?>").attr('readonly', true);
                $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan') ?>").val('');
            }
        });


        //periksa lainnya jika sudah terceklis
        if ($('#cek-caramasuk').find('input:checkbox.lainlain').prop("checked") == true) {
            $("#<?php echo CHtml::activeId($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan') ?>").attr('readonly', false);
        }
    });
    $(document).ready(function () {

        var instalasi_id = '<?php echo $modPendaftaran->instalasi_id; ?>';
        var rujukan_id = '<?php echo $modPendaftaran->rujukan_id; ?>';
        var pasiendari_igd = '<?php echo $modAsesmenAwalMedis->pasiendari_igd; ?>';
        var pasiendari_rujukan = '<?php echo $modAsesmenAwalMedis->pasiendari_rujukan; ?>';
        var pasiendari_irj = '<?php echo $modAsesmenAwalMedis->pasiendari_irj; ?>';
        var pasiendari_lainnya = '<?php echo $modAsesmenAwalMedis->pasiendari_lainnya; ?>';
        console.log("daad" + rujukan_id);

        if (pasiendari_igd == false && pasiendari_rujukan == false && pasiendari_irj == false && pasiendari_lainnya == false) {
            if (rujukan_id != '') {

                $('#RIAsesmenAwalMedisT_pasiendari_rujukan').prop("checked", true);

            } else {
                console.log(pasiendari_irj);
                if (instalasi_id ==<?php echo Params::INSTALASI_ID_RD ?>) {

                    $('#RIAsesmenAwalMedisT_pasiendari_igd').prop("checked", true);

                } else if (instalasi_id ==<?php echo Params::INSTALASI_ID_RI ?> ) {

                    $('#RIAsesmenAwalMedisT_pasiendari_irj').prop("checked", true);

                } else {

                    $('#RIAsesmenAwalMedisT_pasiendari_lainnya').prop("checked", true);

                }
            }
        }
    });


    function setPerubahan(obj) {
        var persalinan = $('#RIAsesmenAwalMedisT_riwayat_persalinan_normal');
        var olehdokter = $('#RIAsesmenAwalMedisT_riwayat_persalinan_olehdokter');
        var menangis = $('#RIAsesmenAwalMedisT_riwayat_persalinan_segeramenangis');
        var terapi = $('#RIAsesmenAwalMedisT_alasandirawat_terapi');
        var sakitdulu = $('#RIAsesmenAwalMedisT_riwayat_sakit_dulu_tidakada');
        var sakitkeluarga = $('#RIAsesmenAwalMedisT_riwayat_sakit_keluarga_tidakada');
        var mandiri = $('#RIAsesmenAwalMedisT_statusfungsional_mandiri');
        var kesadaran = $('#RIAsesmenAwalMedisT_kesadarankualitatif_composmentis');
        var kondisi = $('#RIAsesmenAwalMedisT_kondisikhusus_normal');
        var nyeri = $('#RIAsesmenAwalMedisT_nyeri_tidakada');
        var umum = $('#pilihSemuaPeriksaUmum');
        var kepala = $('#RIAsesmenAwalMedisT_kepala_normal');
        var mata = $('#RIAsesmenAwalMedisT_mata_normal');
        var tht = $('#RIAsesmenAwalMedisT_tht_normal');
        var leher = $('#RIAsesmenAwalMedisT_leher_normal');
        var mulut = $('#RIAsesmenAwalMedisT_mulut_normal');
        var jantung = $('#RIAsesmenAwalMedisT_jantung_pb_normal');
        var thorax = $('#RIAsesmenAwalMedisT_thorax_paru_payudara_normal');
        var abdomen = $('#RIAsesmenAwalMedisT_abdomen_normal');
        var kulit = $('#RIAsesmenAwalMedisT_kulit_normal');
        var tulang = $('#RIAsesmenAwalMedisT_tulang_anggotatubuh_normal');
        var saraf = $('#RIAsesmenAwalMedisT_sistemsaraf_normal');
        var anus = $('#RIAsesmenAwalMedisT_genitalia_normal');
        var adatrauma = $('#RIAsesmenAwalMedisT_trauma_kehidupan_ada');
        var kebiasaanobat = $('#RIAsesmenAwalMedisT_kebiasaan_obat');
        var adamasalahkawin = $('#RIAsesmenAwalMedisT_masalah_perkawinan_ada');
        var tempattinggallain = $('#RIAsesmenAwalMedisT_tempattinggal_lainnya');
        var tinggalbersamalain = $('#RIAsesmenAwalMedisT_tinggalbersama_lainnya');

        if (adatrauma.is(":checked")) {
            $('#RIAsesmenAwalMedisT_trauma_kehidupan_ada_keterangan').attr('readonly', false);
        }
        if (kebiasaanobat.is(":checked")) {
            $('#RIAsesmenAwalMedisT_kebiasaan_obat_keterangan').attr('readonly', false);
        }
        if (adamasalahkawin.is(":checked")) {
            $('#RIAsesmenAwalMedisT_masalah_perkawinan_keterangan').attr('readonly', false);
        }
        if (tempattinggallain.is(":checked")) {
            $('#RIAsesmenAwalMedisT_tempattinggal_lainnya_keterangan').attr('readonly', false);
        }
        if (tinggalbersamalain.is(":checked")) {
            $('#RIAsesmenAwalMedisT_tinggalbersama_lainnya_keterangan').attr('readonly', false);
        }

        if (persalinan.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_riwayat_persalinan_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_riwayat_persalinan_normal").attr('checked', true);
        }
        if (olehdokter.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_riwayat_persalinan_olehdokter").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_riwayat_persalinan_olehdokter").attr('checked', true);
        }
        if (menangis.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_riwayat_persalinan_segeramenangis").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_riwayat_persalinan_segeramenangis").attr('checked', true);
        }
        if (terapi.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_alasandirawat_terapi").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_alasandirawat_terapi").attr('checked', true);
        }
        if (sakitdulu.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_riwayat_sakit_dulu_tidakada").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_riwayat_sakit_dulu_tidakada").attr('checked', true);
        }
        if (sakitkeluarga.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_riwayat_sakit_keluarga_tidakada").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_riwayat_sakit_keluarga_tidakada").attr('checked', true);
        }
        if (mandiri.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_statusfungsional_mandiri").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_statusfungsional_mandiri").attr('checked', true);
        }
        if (kesadaran.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_kesadarankualitatif_composmentis").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_kesadarankualitatif_composmentis").attr('checked', true);
        }
        if (kondisi.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_kondisikhusus_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_kondisikhusus_normal").attr('checked', true);
        }
        if (nyeri.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_nyeri_tidakada").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_nyeri_tidakada").attr('checked', true);
        }
        if (umum.is(" :checked")) {
            $("#pilihSemuaPeriksaUmum").attr('checked', true);
        } else {
            $("#pilihSemuaPeriksaUmum").attr('checked', true);
        }
        if (kepala.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_kepala_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_kepala_normal").attr('checked', true);
        }
        if (mata.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_mata_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_mata_normal").attr('checked', true);
        }
        if (tht.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_tht_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_tht_normal").attr('checked', true);
        }
        if (leher.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_leher_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_leher_normal").attr('checked', true);
        }
        if (mulut.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_mulut_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_mulut_normal").attr('checked', true);
        }
        if (jantung.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_jantung_pb_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_jantung_pb_normal").attr('checked', true);
        }
        if (thorax.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_thorax_paru_payudara_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_thorax_paru_payudara_normal").attr('checked', true);
        }
        if (abdomen.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_abdomen_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_abdomen_normal").attr('checked', true);
        }
        if (kulit.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_kulit_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_kulit_normal").attr('checked', true);
        }
        if (tulang.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_tulang_anggotatubuh_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_tulang_anggotatubuh_normal").attr('checked', true);
        }
        if (saraf.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_sistemsaraf_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_sistemsaraf_normal").attr('checked', true);
        }
        if (anus.is(" :checked")) {
            $("#RIAsesmenAwalMedisT_genitalia_normal").attr('checked', true);
        } else {
            $("#RIAsesmenAwalMedisT_genitalia_normal").attr('checked', true);
        }
    }

    function setGizi() {
        var kelebihanberatbadan = 0;
        var asupanmakan = 0;
        var penyakitberat = 0;
<?php if (!empty($modAsesmenAwalMedis->statusgizi_kehilanganberatbadan)) { ?>
            var kelebihanberatbadan = <?= $modAsesmenAwalMedis->statusgizi_kehilanganberatbadan; ?>;
<?php } ?>

<?php if (!empty($modAsesmenAwalMedis->statusgizi_asupanmakankurang)) { ?>
            var asupanmakan = <?= $modAsesmenAwalMedis->statusgizi_asupanmakankurang; ?>;
<?php } ?>

<?php if (!empty($modAsesmenAwalMedis->statusgizi_menderitapenyakitberat)) { ?>
            var penyakitberat = <?= $modAsesmenAwalMedis->statusgizi_menderitapenyakitberat; ?>;
<?php } ?>
        console.log(kelebihanberatbadan + '-' + asupanmakan + '-' + penyakitberat);
        $('#statusgizi_kehilanganberatbadan[value="' + kelebihanberatbadan + '"]').attr('checked', true);
        $('#statusgizi_asupanmakankurang[value="' + asupanmakan + '"]').attr('checked', true);
        $('#statusgizi_menderitapenyakitberat[value="' + penyakitberat + '"]').attr('checked', true);


    }

    function setPemeriksaan() {
<?php if (!empty($modAsesmenAwalMedis->pemeriksaanlab_hb) or ! empty($modAsesmenAwalMedis->pemeriksaanlab_k)) { ?>
            $('#labdariluar').attr('checked', true);
<?php } ?>

        if ($('#labdariluar').is(":checked")) {
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').attr('disabled', false);
        } else {
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').val('');
        }
    }

    $(document).ready(function () {
        setPerubahan();
        setGizi();
        setPemeriksaan();
        cekStatusGizi();
<?php if (!isset($_GET['id'])) { ?>
            $('#statusPasien').hide();
<?php } ?>

<?php if (isset($_GET['mode'])) { ?>
            $("#asesmen-awal-medis-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
<?php } ?>

<?php if (Yii::app()->controller->id == 'asesmenAwalMedisDewasaHD') : ?>
            console.log('kosong');
            $('#gambar-container').hide();
<?php endif; ?>
    });

    function hapusRiwayat(id) {
        console.log(id);
        myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    url: '<?= $this->createUrl('hapusRiwayat') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {id: id},
                    success: function (data) {
                        if (data.sukses == 1) {
                            toastr.success(data.pesan, "Perhatian!");
                            location.href = '<?= $this->createUrl('index&pendaftaran_id=') . $_GET['pendaftaran_id'] ?>';
                        } else {
                            toastr.error(data.pesan, "Perhatian!");
                        }
                    }
                })
            }
        })
    }

    function cekPerkawinan(obj) {
        console.log(obj.value);
        if (obj.value == 'Lainnya') {
            $('#RIAsesmenAwalMedisT_masalah_perkawinan_keterangan_1').attr('readonly', false);
        } else {
            $('#RIAsesmenAwalMedisT_masalah_perkawinan_keterangan_1').val('');
            $('#RIAsesmenAwalMedisT_masalah_perkawinan_keterangan_1').attr('readonly', true);
        }
    }

    function cekLokalis() {
        var lokalis = $('#status_lokalis:checked').val();
        console.log('lokasi=' + lokalis);
        if (lokalis == 0) {
            $('#gambar-container').show();
        } else {
            $('#gambar-container').hide();

        }
    }

    function setLabdariluar() {
        if ($('#labdariluar').is(":checked")) {
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').attr('disabled', false);
        } else {
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').val('');
        }
    }


    var addPeriksaLuar = (obj) => {
        var tr = new String(<?= CJSON::encode($this->renderPartial($this->path_view . 'form/row/_row_eks', ['model' => $modLabEks, 'drop' => $drop], true)); ?>)

        $("#tabel-hasil-eks > tbody").append(tr.replace());
        renameInputRowRiwayatObat($("#tabel-hasil-eks"));
        gen_tgl_hasil_eks();
    }

    $(".form-cek-lis").find('input:checkbox').each(function(){
        set_dis(this,'disabled');
    });
    
    $(".form-cek-lis").find('input:checkbox').click(function(){        
        var cek = $(this).prop('checked');
        set_dis(this);
                
        if (!cek && $(this).hasClass('parent')){
            var id = $(this).parents('.control-group').find('.det_id').val();            
            if (id != ''){
                $("#akses-vaskular-hapus > tbody").append('<tr><td><input type="hidden" name="akses_hapus[]" value="'+id+'"></td></tr>');
            }
        }
    });

    var hapus_akses = (obj) => {
        $(obj).parents('.kelompok').find('.det_id').each(function(){
            var id = $(this).val();
            
            if (id != ''){                
                $("#akses-vaskular-hapus > tbody").append('<tr><td><input type="hidden" name="akses_hapus[]" value="'+id+'"></td></tr>');
            }
        });
    }

</script>
