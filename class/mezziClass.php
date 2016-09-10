<?php
/**
 *  titolo: SardegnaTrasportiBot
 *  autore: Matteo Enna (http://matteoenna.it)
 *  licenza GPL3
 **/

    class mezziClass {
        
        public $code = '';
        public $precision = 0.01;
        public $lat_position = '';
        public $long_position = '';
        public $data_position_stops = array();
        public $data_position_stop_time = array();
        public $data_position_trips = array();
        public $data_position_routes = array();
        public $data = array();        
        public $file_stops ="";        
        public $file_stop_time ="";        
        public $file_trips ="";        
        public $file_routes ="";
        public $stop_id_pos = "";
        public $trip_id_pos = "";
        public $rounte_id = "";
        
        public function getData($lat, $long){
            
            $simple = file_get_contents($this->file_stops);
	    $righe=explode(chr(10),$simple);
            
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                
                if($this->presente($col,$lat,$long)) {
                    $this->data[$col[$this->data_position_stops['stop_id']]] = $this->composeData($col);
                    $this->data[$col[$this->data_position_stops['stop_id']]]['trip_id'] = $this->getTripIdByStopId($col[$this->data_position_stops['stop_id']]);                    
                    
                }
            } 
            return $this->data;
        }
        
        
        public function getDataName($name){
            
            $simple = file_get_contents($this->file_stops);
	    $righe=explode(chr(10),$simple);
            
            $pos_name = $this->data_position_stops['stop_name'];
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if(strpos(strtolower($col[$pos_name]),strtolower($name))!==FALSE) {
                    $this->data[$col[$this->data_position_stops['stop_id']]] = $this->composeData($col);
                    $this->data[$col[$this->data_position_stops['stop_id']]]['trip_id'] = $this->getTripIdByStopId($col[$this->data_position_stops['stop_id']]);                    
                    
                }
            } 
            return $this->data;
        }
        
        public function getNameStopArray(){
            
            $simple = file_get_contents($this->file_stops);
			$righe=explode(chr(10),$simple);
            
            $pos_id = $this->data_position_stops['stop_id'];
            $pos_name = $this->data_position_stops['stop_name'];
            
            $array = array();
            
            foreach($righe as $riga) {
                $col = explode(',',$riga);
                $array[$col[$pos_id]] = $col[$pos_name];
            }
            
            return $array;
            
        }
        
        public function getDataId($id){
            
            $simple = file_get_contents($this->file_stops);
	    $righe=explode(chr(10),$simple);
            
            $pos_name = $this->data_position_stops['stop_id'];
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if($col[$pos_name] == $id) {
                    $this->data[$col[$this->data_position_stops['stop_id']]] = $this->composeData($col);
                    $this->data[$col[$this->data_position_stops['stop_id']]]['trip_id'] = $this->getTripIdByStopId($col[$this->data_position_stops['stop_id']]);                    
                    
                }
            } 
            return $this->data;
        }
        
        public function presente ($col, $lat, $long) {
            $r = $this->precision;
            
            $llat = $col[$this->lat_position];
            $llong = $col[$this->long_position];
            
            if(($llat<$lat+$r && $llat>$lat - $r) && ($llong<$long+$r && $llong>$long - $r)) {
                return True;
            }
            
            return false;
        }
        
        public function composeData ($col) {
            $dato = array();
            foreach ($this->data_position_stops as $k => $pos) {
                $dato[$k] = $col[$pos];
            }
            return $dato;
            
        }
        
        public function getTripIdByStopId($id){   
            $simple = file_get_contents($this->file_stop_time);
	    $righe=explode(chr(10),$simple);
                                
            $dato = array();
            
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if($col[$this->data_position_stop_time['stop_id']]==$id) {
                    $dato[$col[$this->data_position_stop_time['trip_id']]] = $this->getRouteIdByTripId($col[$this->data_position_stop_time['trip_id']]);
                }
            }
            
            return $dato;
        }
        
        public function getRouteIdByTripId($id){   
            $simple = file_get_contents($this->file_trips);
			$righe=explode(chr(10),$simple);
                                
            $dato = array();
            
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if($col[$this->data_position_trips['trip_id']]==$id) {
                    $dato[$col[$this->data_position_trips['route_id']]]=  $this->getRouteById(
                            $col[$this->data_position_trips['route_id']]);
                }
            }
            
            return $dato;
        }
        
        public function getFirstRouteIdByTripId($id){   
            $simple = file_get_contents($this->file_trips);
			$righe=explode(chr(10),$simple);
                                
            $dato = array();
            
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if($col[$this->data_position_trips['trip_id']]==$id) {
                    return $col[$this->data_position_trips['route_id']];
                }
            }
        }
        
        
        public function getRouteById($id){   
            $simple = file_get_contents($this->file_routes);
			$righe=explode(chr(10),$simple);
                                
            $dato = array();
            
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if($col[$this->data_position_routes['route_id']]==$id) {
                    foreach ($this->data_position_routes as $k => $val){
                        $dato[$k]=$col[$val];
                    }
                    return $dato;
                }
            }
            
            return $dato;
        }
        
        public function getTripArrayByRouteId($id){   
            $simple = file_get_contents($this->file_trips);
			$righe=explode(chr(10),$simple);
                                
            $dato = array();
            $name ='';
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if($col[$this->data_position_trips['route_id']]==$id) {
                    $dato[] = $col[$this->data_position_trips['trip_id']];
                    $name = $col[$this->data_position_trips['trip_headsign']];
                }
            }
            
            return array(
                'id'=>$dato,
                'name'=>$name
            );
        }
        
        public function getTravelById($id){
            $simple = file_get_contents($this->file_stop_time);
			$righe=explode(chr(10),$simple);
            $array = $this->getNameStopArray();
            
            $rotta = array();
            
            $pos_id = $this->data_position_stop_time['trip_id'];
            $time_pos = $this->data_position_stop_time['arrival_time'];
            $name_pos = $this->data_position_stop_time['stop_id'];
            
            foreach($righe as $riga) {
                $col = explode(',',$riga);
                if($col[$pos_id]==$id) {
                    $rotta[] = $array[$col[$name_pos]]." ".$col[$time_pos]." "."/i".$col[$name_pos];
                    
                }
                
            }
            return $rotta;
            
        }

        function getRouteByTripId($id) {
            $id = $this->getFirstRouteIdByTripId($id);
            
            $simple = file_get_contents($this->file_routes);
			$righe=explode(chr(10),$simple);
                                
            $dato = array();
            
            foreach($righe as $riga) {
                
                $col = explode(',',$riga);
                if($col[$this->data_position_routes['route_id']]==$id) {
                    return $col[$this->data_position_routes['route_long_name']];
                }
            }
        }

        public function getTimeByTravelAndstop($stop_id, $route_id){
            $simple = file_get_contents($this->file_stop_time);
			$righe=explode(chr(10),$simple);
            $stop_pos = $this->data_position_stop_time['stop_id'];
            $trip_pos = $this->data_position_stop_time['trip_id'];
            $trip_array = $this->getTripArrayByRouteId($route_id);
            
            $time = array(
                'location' =>$trip_array['name'],
                'linea' => $route_id,
                'time'=>array()
                
            );
            
            foreach($righe as $riga) {
                $col = explode(',',$riga);
                if($col[$stop_pos]==$stop_id && in_array($col[$trip_pos],$trip_array['id'])){
                    $time['time'][] = "Orario previsto: ".$col[$this->data_position_stop_time['arrival_time']].acapo."informazioni di viaggio: /v".$col[$trip_pos];
                }
            }
            
            
            return $time;
        }
    }