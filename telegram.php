<?php
/**
 *  titolo: SardegnaTrasportiBot
 *  autore: Matteo Enna (http://matteoenna.it)
 *  licenza GPL3
 **/

    require_once('config/config.php');
    require_once('class/telegramClass.php');
    require_once('class/trasportiClass.php');
    require_once('class/mezziClass.php');
    require_once('class/mezzi/arstClass.php');
    require_once('class/mezzi/treniClass.php');
    require_once('class/mezzi/privatiClass.php');
    
    
    $trasporti = new trasportiClass();       
    $trasporti->ProcessMessage();

