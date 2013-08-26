<?php
return array(
    'factories' => array(
        'Mail\Transport' => 'Indrig\Mail\Transport\TransportServiceFactory'
    ),
    'mail' => array(
        'transport' => array(
            'type'      => 'sendmail',  //sendmail, snmp, file
            'options'   => array(

            )
        )
    )
);