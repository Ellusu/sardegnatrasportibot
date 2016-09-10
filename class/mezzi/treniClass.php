<?php
/**
 *  titolo: SardegnaTrasportiBot
 *  autore: Matteo Enna (http://matteoenna.it)
 *  licenza GPL3
 **/

    class treniClass extends mezziClass {
        
        public $lat_position = 4;
        public $long_position = 5;
        public $data_position_stops = array(
            'stop_id' => 0,
            //'stop_code' => 1,
            'stop_name' => 2,
            //'stop_desc' => 3,
            'stop_lat' => 4,
            'stop_lon' => 5,
            //'zone_id' => 6
        );
        public $data_position_stop_time = array(
            'trip_id'=>0,
            'arrival_time'=>1,
            'departure_time'=>2,
            'stop_id'=>3,
            'stop_sequence'=>4,
            'pickup_type'=>5,
            'drop_off_type'=>6
        );
        public $data_position_trips = array(
            'route_id' => 0,
            'service_id' => 1,
            'trip_id' => 2,
            'trip_headsign' => 3,
            'direction_id' => 4,
            'block_id,shape_id' => 5
        );
        public $data_position_routes = array(
            'route_id' => 0,
            'agency_id' => 1,
            'route_short_name' => 2,
            'route_long_name' => 3,
            'route_desc' => 4,
            'route_type' => 5,
            'route_url' => 6,
            'route_color' => 7,
            'route_text_color' => 8
        );
        
        public $file_stops ="data/trenitalia/stops.txt";        
        public $file_stop_time ="data/trenitalia/stop_times.txt";        
        public $file_trips ="data/trenitalia/trips.txt";        
        public $file_routes ="data/trenitalia/routes.txt";
        public $trip_id_pos = 0;
        public $rounte_id = 0;
        
    }