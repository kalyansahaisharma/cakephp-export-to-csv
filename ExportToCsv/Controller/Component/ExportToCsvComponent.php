<?php
App::uses('Component', 'Controller');
/**
 * Default Component
 *
 * PHP version 5
  This component consists the website default functions
 */
class ExportToCsvComponent extends Component {

    /*
    * This function use when you want to creat simple csv file
    */
    public function exportToCsvFile($fileFields = null, $datas = null){

       $this->download_send_headers("data_export_" . date("Y-m-d H:i:s") . ".csv");

       echo $this->convertSimpleCsv($fileFields,$datas);

        die();       

    }
    
    /*
    * conver data to csv file
    */
    function convertSimpleCsv($fileFields,$datas){
       
       if (count($datas) == 0) {
         return null;
       }

       ob_start();

       // create a file pointer connected to the output stream
       $output = fopen('php://output', 'w');

       // output the column headings
       fputcsv($output, $fileFields);

       foreach ($datas as $row) {
          fputcsv($output, $row);
       }
       fclose($output);
       return ob_get_clean();
    }
    /*
    * set the headers for download csv file
    */
    function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }
}