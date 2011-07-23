<?php

/*
 **************************************
 *
 * includes/config.inc.php
 * -------------
 * last modified:	2007-01-13
 * -------------
 *
 * project:	chCounter
 * version:	3.1.3
 * copyright:	� 2005 Christoph Bachner
 *               since 2006-21-12 Bert Koern
 * license:	GPL vs2.0 or higher [ see docs/license.txt ]
 * contact:	http://chCounter.org/
 *
 **************************************

*/


//
// Datenbank-Zugangsdaten
// Your database data
// Donn�es d'acc�s pour la base de donn�es
//
$_CHC_DBCONFIG = array(

	'server' => 'localhost',		// database server | Server | Server
	'user' => 'thongti3_hpu',			// database account | Benutzername | mot d'utilisateur
	'password' => '123,654',			// database password | Passwort | mot de passe
	'database' => 'thongti3_hpcounter',			// database name | Datenbankname | nom de la base de donn�es

	// Prefix of the chCounter database tables:
	// Pr�fix der chCounter Datenbanktabellen:
	// Pr�fixe des tableaux de la base de donn�es du chCounter:
	'tables_prefix' => 'chc_'

);

?>
