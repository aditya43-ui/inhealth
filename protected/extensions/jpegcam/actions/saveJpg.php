<?php
class saveJpg extends CAction{
    /**
     * Stores the full path of the file to save.
     * It is set by the client controller.
     */
    public $filepath;
    public $filepath2;
    
    public function run(){
        $filepath  = $this->filepath;
        $filepath2 = $this->filepath2;
        if ($filepath == null)
            throw new Exception ("Null filepath!");

        $contents = file_get_contents('php://input');
        $result = file_put_contents( $filepath, $contents);
        $result2 = file_put_contents( $filepath2, $contents);
        if (!$result) {
            print "ERROR: Gagal Menyimpan Data Ke Folder $filename, Cek Hak Akses Folder tersebut atau hubungi Admin\n";
            exit();
        }
        print "OK";
    }
}
?>
