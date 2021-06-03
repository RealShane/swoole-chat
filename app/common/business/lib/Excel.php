<?php
/**
 *
 * @description: 人生五十年，与天地长久相较，如梦又似幻
 *
 * @author: Shane
 *
 * @time: 2020/9/29 21:40
 */


namespace app\common\business\lib;


use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Excel
{

    private $excel = NULL;

    public function __construct(){
        $this -> excel = new Spreadsheet();
    }

    public function read($file){
        $io = IOFactory::load($file);
        $io -> setActiveSheetIndex(0);
        $rowCount = $io -> getActiveSheet() -> getHighestRow();
        $columnCount = $io -> getActiveSheet() -> getHighestColumn();
        $array = [];
        for ($row = 1; $row <= $rowCount; $row++) {
            $question = [];
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $temp = $io -> getActiveSheet() -> getCell($column . $row) -> getValue();
                $key = NULL;
                if ($column == 'A'){
                    $key = 'subject';
                }
                if ($column == 'B'){
                    $temp = explode(PHP_EOL, $temp);
                    $key = 'option';
                }
                if ($column == 'C'){
                    $key = 'answer';
                }
                if ($column == 'D'){
                    $key = 'analysis';
                }
                $question[$key] = $temp;
            }
            $array[] = $question;
        }
        return $array;
    }

    public function push($title, $indexes, $data){
        $this -> excel -> getProperties() -> setCreator('Shane')
            ->setLastModifiedBy('Shane')
            ->setTitle($title)
            ->setSubject($title)
            ->setDescription($title)
            ->setKeywords("excel")
            ->setCategory("result file");
        $alpha = 'A';
        foreach ($indexes as $index){
            $this -> excel -> setActiveSheetIndex(0) -> setCellValue($alpha . '1', $index);
            $alpha++;
        }
        foreach($data as $key => $value){
            $counter = $key + 2;$alpha = 'A';
            foreach ($value as $item){
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ]
                ];
                if($item > 1000000000){
                    $this -> excel -> setActiveSheetIndex(0) -> setCellValueExplicit($alpha . $counter, $item, DataType::TYPE_STRING);
                    $this -> excel -> getActiveSheet() -> getStyle($alpha . $counter) -> getNumberFormat() -> setFormatCode(NumberFormat::FORMAT_TEXT);
                    $this -> excel -> getActiveSheet()  -> getStyle($alpha . $counter) -> applyFromArray($styleArray);
                    $alpha++;
                    continue;
                }
                $this -> excel -> setActiveSheetIndex(0) ->setCellValue($alpha . $counter, $item);
                $this -> excel -> getActiveSheet()  -> getStyle($alpha . $counter) -> applyFromArray($styleArray);
                $alpha++;
            }
        }
        $this -> excel  -> getActiveSheet() -> setTitle('Sheet1');
        $this -> excel  -> setActiveSheetIndex(0);

        header('Content-Type: application.ms-excel');
        header('Content-Disposition: attachment;filename="' . $title . '.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $objWriter = IOFactory::createWriter($this -> excel, 'Xls');
        $objWriter -> save('php://output');
        exit;
    }

}