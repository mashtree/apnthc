<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Upload {

    private $dirTo;
    private $dirFrom;
    private $fileExt;
    private $fileName;
    private $fileTo;
    private $ubahNama = array();
    private $fileEkst;

    const PDF = 'application/pdf';
    const JPG = 'application/jpeg';
    const DOC = 'application/msword';
    const DOCX = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    const DOCX2 = 'application/octet-stream';

    public function __construct($fupload) {
        $this->init($fupload);
    }

    public function init($fupload) {
        $this->setDirFrom($_FILES[$fupload]['tmp_name']);
        $this->setFileExt($_FILES[$fupload]['type']);
        $this->setFileName($_FILES[$fupload]['name']);       
    }

    public function cekFileExist() {
        if (file_exists($this->getDirFrom())) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * cek eksetensi file sesuai dengan halaman/jenis upload. misal foto harus jpg, surat tugas harus pdf
     * param ekstensi file dan tipe dokumen [img,pdf]
     */

    public function cekEkstensi($fileExt, $doctype = NULL) {
        //$this->setFileExt($fileExt);
        switch ($doctype) {
            case '':
                break;
        }
        if ($fileExt == __EXT_FILE__ OR $fileExt == 'application/msword' OR $fileExt == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' OR $fileExt == 'application/octet-stream') {
            return true;
        } else {
            return false;
        }
    }

    /*
     * @param ubahNama=>array, jenis surat-nomor surat-satker-tgl surat
     * mungkin bisa dihapus, dengan set get langsung aja untuk menggantikannya
     */

    public function changeFileName($filename, $ubahNama) {
        $nama = '';
        $length = count($ubahNama);
        for ($i = 0; $i < $length; $i++) {
            $t = trim($ubahNama[$i]);
            $nama .= $t . "_";
        }
        $tmp = explode(".", $filename);
        $len = count($tmp);
        $ekst = $tmp[$len-1];
        $nama = rtrim($nama, "_");
        $nama .= "." . $ekst;
        $nama = str_replace('/', '_', $nama);
        $nama = str_replace(" ", "", $nama);
        $nama = trim($nama);
        $this->fileTo = $nama;
        return $this->fileTo;
    }

    /*
     * param tipe dokumen, misal foto harus jpg, surat tugas harus pdf
     * 
     */

    public function uploadFile($dir_to, $nama=array()) {
        $this->setDirTo($dir_to);
        $this->changeFileName($this->getFileName(),$nama);
        if ($this->cekFileExist()) {
            move_uploaded_file($this->getDirFrom(), $this->getDirTo() . $this->getFileTo());
            return true;
        } else {
            return false;
        }
    }

    /*
     * melakukan upload file, parameter : array untuk penamaan file
     * 
     */

    public function uploadFile2($doctype = NULL, $nama = array()) {
        for ($i = 0; $i < 10; $i++) {  //membuat angka random
            $rand = $rand . rand(0, 9);
        }
        array_push($nama, $rand);
        $this->changeFileName($this->getFileName(), $nama);
        if ($this->cekFileExist()) {
            if (move_uploaded_file($this->getDirFrom(), $this->getDirTo() . $this->getFileTo())) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function renameFile($old, $new) {
        rename($old, $new);
    }

    public function setDirTo($dirTo) {
        $this->dirTo = $dirTo;
    }

    public function setDirFrom($dirFrom) {
        $this->dirFrom = $dirFrom;
    }

    public function setFileExt($fileExt) {
        $this->fileExt = $fileExt;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function setUbahNama($ubahNama) {
        $this->ubahNama = $ubahNama;
    }

    public function setFileTo($filename) {
        $this->fileTo = $filename;
    }

    public function getDirTo() {
        return $this->dirTo;
    }

    public function getDirFrom() {
        return $this->dirFrom;
    }

    public function getFileExt() {
        return $this->fileExt;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function getFileTo() {
        return $this->fileTo;
    }

}

?>
