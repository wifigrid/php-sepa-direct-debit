<?php
include('src/sepa.php');

// Uw gegevens
$array['begunstigde'] => array (
    'bedrijfsnaam'          => 'Bedrijfsnaam',          // Bedrijfsnaam
    'adres1'                => 'Straatnaam 1',          // Straatnaam + huisnummer
    'adres2'                => '9700 AA GRONINGEN',     // Postcode + plaatsnaam
    'land'                  => 'NL',                    // Landcode
    'iban'                  => 'NL04RABO01234567890',   // IBAN
    'bic'                   => 'RABOU2NL',              // BIC
    'incassantid'           => '1234567890',            // Incassant ID
    'soort'                 => 'CORE',                  // CORE of B2B
    'batch'                 => 'FRST'                   // FRST of RCUR
);

// Opdrachtgegevens, herhalen per opdracht.
$array['opdrachten'][] = array (
    'mandaatkenmerk'        => '000010',                // Kenmerk van de machtiging
    'mandaatdatum'          => '2016-01-01',            // Datum van ondertekening van de machtiging
    'bedrijfsnaam'          => 'Bedrijfsnaam klant',    // Bedrijfsnaam van debiteur
    'adres1'                => 'Straatnaam 2',          // Straatnaam + huisnummer van debiteur
    'adres2'                => '9700 AA GRONINGEN',     // Postcode + plaatsnaam van debiteur
    'land'                  => 'NL',                    // Landcode van debiteur
    'iban'                  => 'NL04RABO01234567890',   // IBAN van debiteur
    'bic'                   => 'RABOU2NL',              // BIC van debiteur
    'bedrag'                => '342.23',                // Bedrag van de afschrijving
    'omschrijving'          => 'Factuur Maart 2016',    // Omschrijving van de afschrijving
    'transactieid'          => '000121',                // Transactiekenmerk
);

create_sepa($array);