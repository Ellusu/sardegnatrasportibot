<?php
/**
 *  titolo: SardegnaTrasportiBot
 *  autore: Matteo Enna (http://matteoenna.it)
 *  licenza: GPL3
 **/

    define('BOT_TOKEN', '277656031:AAGHLFUoxxn2jvSlTuETgGRoN1qYk7MW8RU');
    define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
    
    define('dir_doku', '../../www/wiki/');
    define('doku_data', dir_doku.'data/pages/');

    define('type_error_message', "Formato sbagliato, digita un semplice messaggio");
    define('welcome_message', "Benvenuto su Sardegna Trasporti Pubblici, \ndigitando il nome di un comune o inviando la tua posizione visualizzerai l'elenco di fermate dei mezzi pubblici più vicine a te. \n \nIl bot è stato realizzato utilizzando gli OpenData messi a disposizione da SardegnaMobilita sotto licenza CC BY 4.0 http://www.sardegnamobilita.it/opengovernment/opendata/. \n \nRealizzato da Matteo Enna, \nRilasciato sotto licenza GPL3, potete trovare il progetto su: http://matteoenna.it/");
    define('help_message', "Digita il nome del comune e invia il messaggio oppure invia la tua posizione. \n\nPer qualsiasi dubbio, informazione o chiarimento puoi scrivermi su telegram @matteoenna oppure mandarmi una mail: matteo.enna89@gmail.com");
    
    define('acapo', "\n");
