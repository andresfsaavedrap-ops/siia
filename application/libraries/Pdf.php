<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
    //require_once APPPATH."/third_party/fpdf/makefont/makefont.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();
			//MakeFont(APPPATH.'third_party/fpdf/font/franklin.ttf','cp1252');
        }
    }
?>