<?php

/**
 * Digunakan untuk generate printout dalam bentuk CSV
 *
 * @author   Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package  application.components
 * @category lain-lain
 * 
 */
class CSV {
    
    /**
     * 
     * Konversi hari data html yang mengamdung table menjadi dalam format CSV.
     * Jika data html tersebut terdapat lebih dari 2 tabel, maka akan diambil tabel pertama.
     * 
     * NOTE : 
     * * Format yang dihasilkan pada file CSV disesuaikan menggunkan standar IETF -> RFC4180
     * * Jika isi dari kolom tersebut mengandung koma (,), "line-break"(CRLF), atau kutip dua ("). Maka akan dibungkus 
     * didalam kutipdua (contoh : "[isi data]").
     * * Jika isi dari kolom tersebut mengandung kutip dua, maka ditambah satulagi kutip dua tersebut 
     * (contoh : "[isi ""data""]").
     * 
     * @param  string $html     Data HTML yang akan dikonversi
     * @param  string $filename Nama file CSV untuk di-download
     * @return string Data berformat CSV jika tidak diinput $filename-nya.
     * @link https://tools.ietf.org/html/rfc4180 Situs IETF
     */
    public static function konversiTabel($html = "", $filename = null) {
        
        $dom = new DOMDocument;
        
        // dikarenakan parsing engine-nya membandingkan dengan format HTML4, maka cek error-nya di-disable terlebih
        // dahulu, setelah load selesai, maka di enable lagi...
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors(false);
        
        $node = $dom->getElementsByTagName("table");
        
        $output = self::parseTableRow($node->item(0)->childNodes);
        
        if (!empty($filename)) {
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Content-Type: text/plain');
            header('Content-Length: ' . strlen($output));
            header('Connection: close');
            
            echo $output;
            
            Yii::app()->end();
        }
        
        return $output;
        
    }
    
    /**
     * Membuat data berformat CSV dari setiap Baris Tabel yang mengandung tr/td.
     * 
     * @param DOMNode $node_row 
     * @return string Hasil Input Parsing
     */
    private static function parseTableRow($node_row) {
        $sub_node = array('thead', 'tbody', 'tfoot');
        $sub_col = array("th", "td");
        $columnDelimiter = ",";
        $rowDelimiter = "\r\n";
        
        $output = "";
        $note_text = "";
        $is_special = false;
        
        foreach ($node_row as $data) {
            
            $arr_detail = array();
            
            if (in_array(strtolower($data->nodeName), $sub_node)) {
                $output .= self::parseTableRow($data->childNodes);
                continue;
            } else if (strtolower($data->nodeName) == "tr") {
                
                foreach ($data->childNodes as $col_node) {
                    if (!in_array(strtolower($col_node->nodeName), $sub_col)) {
                        continue;
                    }
                    
                    $is_special = false;
                    $node_text = $col_node->textContent;
                    
                    if (strpos($node_text, "\n") !== false ||
                        strpos($node_text, "\"") !== false ||
                        strpos($node_text, ",") !== false) {
                        $node_text = "\"".str_replace("\"", "\"\"", $node_text)."\"";
                    }
                    
                    
                    $arr_detail[] = $node_text;
                }
                
                $output .= implode($columnDelimiter, $arr_detail).$rowDelimiter;
            }
            
        }
        
        return $output;
    }
    
}
