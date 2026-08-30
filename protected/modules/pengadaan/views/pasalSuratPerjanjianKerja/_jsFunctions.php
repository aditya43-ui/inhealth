<script>
    
var row = <?php echo CJSON::encode(array('html' => $this->renderPartial($this->path_view.'_rowPasal', array(), true))); ?> ;
 
function setFormPasal() {
    var id = $("#nama_pasal").val();
    var uraian = $("#nama_pasal :selected").data('uraian');
    var isi = $("#nama_pasal :selected").data('isi');
    
    $("#uraian").val(uraian);
    $("#isi_pasal").setCode(isi);
    
}

function hapusPasal(obj) {
    $(obj).parents('tr').remove();
    renameInput();
}

function tambahPasal() {
    var id = $("#nama_pasal").val();
    var nama = $("#nama_pasal :selected").html();
    var uraian = $("#uraian").val();
    var isi = $("#isi_pasal").val();
    var last = null;
    
    // cek jika memilih pasal yang sama.
    var ada = false;
    $(".html_no").each(function() {
         if ($(this).data("id") == id) {
             ada = true;
         }
    });
    if (ada) {
        myAlert("Pasa " + nama + " sudah ditambahkan.");
        return false;
    }
    
    
    $("#nama_pasal").val(null);
    $("#uraian").val(null);
    $("#isi_pasal").setCode("");
    
    $("#tab_pasal").append(row.html);
    
    
    last = $("#tab_pasal tr:last-child");
    console.log(last);
    
    last.find(".html_no").data("id", id);
    last.find(".html_nama").html(nama);
    last.find(".html_uraian").html(uraian);
    last.find(".html_isi").html(isi);
    
    last.find(".pasalperjanjian_isi").val(isi);
    last.find(".pasalperjanjian_uraian").val(uraian);
    
    renameInput();
}

function renameInput() {
    var cnt = 1;
    $(".html_no").each(function() {
        var id = $(this).data("id");
        
        $(this).html(cnt++);
        
        $(this).parents("tr").find(".pasalperjanjian_isi").prop("name", "detail[" + id + "][isi]");
        $(this).parents("tr").find(".pasalperjanjian_uraian").prop("name", "detail[" + id + "][uraian]");
    });
    
}
</script>