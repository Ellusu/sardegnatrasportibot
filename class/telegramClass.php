<?php
/**
 *  titolo: SardegnaTrasportiBot
 *  autore: Matteo Enna (http://matteoenna.it)
 *  licenza GPL3
 **/

    class telegramClass {
        
        public $chatID = 0;
        public $message_text = "";
        public $message_option = "";
        public $message_location = array();
        public $mode = '';
        
        function __construct(){
            $content = file_get_contents("php://input");
            $update = json_decode($content, true);
                        
            $this->chatID = $update["message"]["chat"]["id"];
            if (array_key_exists('text', $update["message"]) && $update["message"]['text'][0]=='/') {
                $this->message_text = $update["message"]["text"];
                $this->mode = 'option';
            } elseif (array_key_exists('text', $update["message"])) {
                $this->message_text = $update["message"]["text"];
                $this->mode = 'text';
            } elseif(array_key_exists('location', $update["message"])) {                
                $this->message_location = array(
                    "latitude"	=> $update["message"]["location"]["latitude"],
                    "longitude"	=> $update["message"]["location"]["longitude"]
                );
                $this->mode = 'location';
            } else {
                $this->message(type_error_message);
                die;
            }
            
        }
        
        function message($message){
            $sendto =API_URL."sendmessage?chat_id=".$this->chatID."&text=".urlencode($message);
            file_get_contents($sendto);
        }
        
        function getMessage(){
            return $this->message_text;
        }
     
        function getLocation(){
            return $this->message_location;
        }
     
        function getMode(){
            return $this->mode;
        }
        
    }
