<?php

namespace StolarzBundle\Helper;

use Symfony\Component\Filesystem\Filesystem;
use StolarzBundle\Entity\Order;

class CsvFile extends Filesystem
{
    const PREFIX_CATALOG = '/tmp/Stolarz/';

    protected $order;
    protected $allElements = [];

    public function __construct(Order $order, $allElements)
    {
        $this->order = $order;
        $this->allElements = $allElements;
    }

    public  function createNewFile(){
        $this->createTempFolder();
        $this->createCsvFile();
        $data = $this->getData();

        $this->dumpFile($this->getPathWithNameAndOrderNo(), $data);
    }

    public function getPathWithNameAndOrderNo(){
        return self::PREFIX_CATALOG . $this->order->getCustomer()->getName() . "_" . $this->order->getId() . ".csv";
    }

    public function deleteTempFolder(){
        $this->remove(self::PREFIX_CATALOG);
    }

    protected function createTempFolder() {
        if(!$this->isTempFolderExist()){
            $this->mkdir(self::PREFIX_CATALOG);
        }
        return true;
    }

    protected function isTempFolderExist(){
        return $this->exists(self::PREFIX_CATALOG);
    }

    protected function createCsvFile(){
        if(!$this->isTempCsvFileExist()){
            $this->touch($this->getPathWithNameAndOrderNo());
        }
    }

    protected function isTempCsvFileExist(){
        return $this->exists($this->getPathWithNameAndOrderNo());
    }

    protected function getData(){
        $result = $this->putColumnNamesToCsvFile();
        $result .= $this->putElementsToCsvFile();

        return $result;
    }

    protected function putColumnNamesToCsvFile(){
        return '﻿Nazwa zlecenia;Nazwa materiału;Element;Pozycja;Oznaczenie;Sztuki;Długość;Szerokość;Obrotowo;;;Obrzeże z przodu;;;;;;Obrzeże z tyłu;;;;;;Obrzeże z lewej;;;;;;Obrzeże z prawej' . "\n";
    }

    protected function putElementsToCsvFile(){
        $resultArray = [];
        foreach ($this->allElements as $element){
            if($element->getRotatable()){
                $rotatable = 1;
            }else{
                $rotatable = 0;
            }

            $variablesArray = [
                "Przykładowa nazwa zlecenia",
                $element->getMaterial()->getName(),
                "Element nazwa",
                "Pozycja nazwa",
                "Oznaczenie nazwa",
                $element->getQuantity(),
                $element->getLenght(),
                $element->getWidth(),
                $rotatable,
                "",
                "",
                $element->getEdgeLenght1()->getName(),
                "","","","","",
                $element->getEdgeLenght2()->getName(),
                "","","","","",
                $element->getEdgeWidth1()->getName(),
                "","","","","",
                $element->getEdgeWidth2()->getName()
            ];
            $variablesArray = implode(';', $variablesArray);
            $resultArray[] = $variablesArray;
        }
        $result = implode("\n", $resultArray);

        return $result;
    }
}
