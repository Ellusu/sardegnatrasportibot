<?php
/**
 *  titolo: SardegnaTrasportiBot
 *  autore: Matteo Enna (http://matteoenna.it)
 *  licenza GPL3
 **/

    class trasportiClass {
         
        private $telegram ='';
        public $dato;
        
        private $type_trasport = array(
            'a','e','p'
        );
        
        private $option = array (
            'r','s','t'
        );
        
        function __construct(){
            $this->telegram = new telegramClass();
            
        }
        function getProcessType() {
            if($this->telegram->getMode()=='text'){
                $this->telegram->message("Ricerca per parola");
                $this->telegram->message("Attendi qualche secondo");
                $this->getProcessText();
                $this->messageTypeLocation(FALSE);
                
            }elseif ($this->telegram->getMode()=='option'){
                $this->telegram->message($testo);
                $this->getProcessOption();
                
            }elseif ($this->telegram->getMode()=='location'){
                $this->telegram->message("Ricerca per Coordinate".acapo.acapo);
                $this->telegram->message("Attendi qualche secondo");
                $this->getProcessLocation();
                $this->messageTypeLocation(FALSE);
            }else{
                $this->dato = FALSE;
            }
                        
        }
        
        function getProcessOption(){
            $message = $this->telegram->getMessage();
            if($message[1]=='r') {
                $message = substr($message, 2);
                $explode = explode('travel',$message);
                $stop_id = $explode[0];
                $travel_id = $explode[1];
                $arst =  new arstClass();
                $times = $arst->getTimeByTravelAndstop($stop_id, $travel_id);
                $testo = $times['name']." Linea: ".$times['linea'].acapo.acapo;
                $testo .= implode(acapo.acapo,$times['time']);
                $this->telegram->message($testo);
                die;
            }
            if($message[1]=='v') {
                $message = substr($message, 2);
                
                $arst =  new arstClass();
                $stop = $arst->getTravelById($message);
                $route = $arst->getRouteByTripId($message);
                $testo = $route." (".$message.")".acapo;
                                
                $testo .= implode(acapo,$stop);
                $this->telegram->message($testo);
                die;
                
            }
            if($message[1]=='i') {
                $this->getProcessId();
                $this->messageTypeLocation();
            }
            
        }
        
        
        function getProcessLocation(){
            $location = $this->telegram->getLocation();
            
            $arst = new arstClass();
            $this->dato["Arst"] = $arst->getData($location["latitude"],$location["longitude"]);
            
            $trenitalia = new treniClass();            
            $this->dato["Trenitalia"] = $trenitalia->getData($location["latitude"],$location["longitude"]);
            
            $privati = new privatiClass();
            $this->dato["Private"] = $privati->getData($location["latitude"],$location["longitude"]);
            
        }
        
        
        function getProcessText(){
            $text = $this->telegram->getMessage();
            
            $arst = new arstClass();
            $this->dato["Arst"] = $arst->getDataName($text);
            $trenitalia = new treniClass();
            $this->dato["Trenitalia"] = $trenitalia->getDataName($text);
            $privati = new privatiClass();
            $this->dato["Privati"] = $privati->getDataName($text);
        }
        
        
        function getProcessId(){
            $text = $this->telegram->getMessage();
            $text = substr($text, 2);
            
            $arst = new arstClass();
            $this->dato["Arst"] = $arst->getDataId($text);
            
            $trenitalia = new treniClass();
            $this->dato["Trenitalii"] = $trenitalia->getDataId($text);
            
            $privati = new privatiClass();
            $this->dato["Privati"] = $privati->getDataId($text);
            
        }
        
        
        function ProcessMessage(){
                       
            $message = $this->telegram->getMessage();
                            
            if($message=="/start"){
                $this->telegram->message(welcome_message);
                die;
            }
            
            if($message=="/help"){
                $this->telegram->message(help_message);
                die;
            }
            
            $message_type = $this->getProcessType();
            
            if(!$message_type){
                $this->telegram->message(unknown_request);
                die;
            }
        }
        
        function messageTypeLocation($tratte = TRUE) {        
            if(!$this->dato){
                return FALSE;                
            }
            
            $testo = "";
            
            foreach ($this->dato as $servizio => $fermata) {
                $testo .= strtoupper($servizio).acapo.acapo;
                $testo .= "Fermate trovate: ".count($fermata).acapo.acapo;
                foreach ($fermata as $codice => $dati){
                    if($servizio =="Arst") $link = ' /i'.$dati['stop_id'];
                    else $link ="";
                    $testo .= $dati['stop_name'].$link.acapo.acapo;
                    if ($tratte) {
                        $rotte =array();
                        $stop_id = $dati['stop_id'];
                        foreach($dati['trip_id'] as $id => $viaggi) {
                            foreach ($viaggi as $travel) {
                                if($servizio =="Arst") $link = " /r".$stop_id.'travel'.$travel['route_id'];
                                else $link ="";
                                $rotte[$travel['route_long_name']] = $travel['route_long_name'].$link;

                            } 
                        }     
                        $rotte = array_unique($rotte);
                        $testo .= " -- Tratte: ".acapo.implode(acapo.acapo,$rotte).acapo;  
                    }
                    $testo .=acapo;
                }
            }
            
            $this->telegram->message($testo);
            die;
        }
        
          
    }
