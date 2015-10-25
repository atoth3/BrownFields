<?php

namespace Bfvt\AreaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPExcel;
use PHPExcel_IOFactory;
use Symfony\Component\HttpFoundation\Response;

class ExcelController
{
    /**
     * @throws \PHPExcel_Reader_Exception
     * @Route("/export", name="xml_export")
     */
    public function excelWriter(){
        $response = new Response();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Me")
            ->setLastModifiedBy("Someone")
            ->setTitle("My first demo")
            ->setSubject("Demo Document");
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
        // Set active sheet index to the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel5)
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="demo.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        //$response->prepare();
        $response->sendHeaders();

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(__DIR__."/test1.xls"); //write in the server
        $objWriter->save('php://output'); //pop-up appears

        //return $objPHPExcel;
        //exit;
    }

    /**
     * @throws \PHPExcel_Reader_Exception
     * @Route("/import", name="xml_import")
     */
    public function excelReader(){

    }
}