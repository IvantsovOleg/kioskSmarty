<?php
error_reporting(0);

class xml_output
{
	public $xw=null;
 
    public function __construct(){
		$this->xw = new XMLWriter();
		$this->xw->openMemory();
		$this->xw->setIndent(false);
	}
 
    function startXML(){
        $this->xw->startDocument('1.0', 'utf-8');
    }
 
    function endXML(){
        $result = $this->xw->outputMemory(true);
        $this->xw->endDocument();
        return $result;
    }
 
    function element($tag, $attrs=null, $content=null){
        $this->elementStart($tag, $attrs);
        if (!is_null($content)){
            $this->xw->text($content);
        }
        $this->elementEnd($tag);
    }
 
    function elementStart($tag, $attrs=null){
        $this->xw->startElement($tag);
        if (is_array($attrs)){
            foreach ($attrs as $name=>$value){
                $this->xw->writeAttribute($name, $value);
            }
        } elseif(is_string($attrs)){
            $this->xw->writeAttribute('class', $attrs);
        }
    }
 
    function elementEnd($tag){
        static $empty_tag = array('base', 'meta', 'link', 'hr', 'br', 'param', 'img', 'area', 'input', 'col');
        if (in_array($tag, $empty_tag)) {
            $this->xw->endElement();
        } else {
            $this->xw->fullEndElement();
        }
    }
 
    function text($txt){
        $this->xw->text($txt);
    }
 
    function raw($xml){
        $this->xw->writeRaw($xml);
    }
 
    function comment($txt){
        $this->xw->writeComment($txt);
    }
 
}

class xml_input
{
	public $xr=null;
        public $command = "";
        public $userid = "";
        public $isTable = FALSE;
        public $tableData;
        public $valueData;
        public $errorText = "";
        public $errorCode = "";
        
    public function __construct($data){
		$this->xr = new XMLReader();
                $this->xr->XML($data, 'utf-8');
	}

    public function __destruct(){
		$this->xr->close();
	}
        
    public function parseXML() 
    {
        $name = "";
        while ($this->xr->read()) 
        {
            if (strtoupper($this->xr->name) == "ERROR" && 
                    $this->xr->nodeType == XMLReader::ELEMENT) // ошибка обработки
            {
                $this->errorCode = $this->xr->getAttribute("code");
                $this->xr->read();
                $this->errorText = $this->xr->value; 
                return FALSE;
            }
            
            if (strtoupper($this->xr->name) == "RESULT" && 
                    $this->xr->nodeType == XMLReader::ELEMENT) // определим что за команда
            {
                $this->command = $this->xr->getAttribute("name");
                $this->userid =  $this->xr->getAttribute("userid");

            }

            if (strtoupper($this->xr->name) == "ROW" && 
                    $this->xr->nodeType == XMLReader::ELEMENT) // таблица
            {
                $this->isTable = TRUE;
                $rownum = $this->xr->getAttribute("num");
                while (!(($this->xr->nodeType == XMLReader::END_ELEMENT) && ($this->xr->name == "ROW")))
                {
                    $this->xr->read();
                    if ($this->xr->nodeType == XMLReader::ELEMENT)
                         $name = $this->xr->name;

                    if ($this->xr->nodeType == XMLReader::TEXT)
                    {
                         $value = $this->xr->value;
                         $params[$name] = $value;
                    }

                }
                $tableResult[$rownum] = $params;
            }
            else
            {
                if ($this->xr->nodeType == XMLReader::ELEMENT)
                     $name = $this->xr->name;

                if ($this->xr->nodeType == XMLReader::TEXT)
                {
                     $value = $this->xr->value;
                     $dataResult[$name] = $value;
                }
            }
        }
        $this->tableData = $tableResult;
        $this->valueData = $dataResult;
        return TRUE;
    }
}
?>