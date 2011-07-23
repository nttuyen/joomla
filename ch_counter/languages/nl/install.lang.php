<?php

/*
 **************************************
 *
 * languages/en/install.lang.php
 * -------------
 * last modified:	2007-01-13
 * -------------
 *
 * project:	chCounter
 * version:	3.1.3
 * copyright:	© 2005 Christoph Bachner
 *               since 2006-21-12 Bert Koern
 * license:	GPL vs2.0 or higher [ see docs/license.txt ]
 * contact:	http://chCounter.org/
 *
 **************************************
 *
 * Translation by: Marcel Morees
 *
 **************************************
*/


$_CHC_LANG = !isset( $_CHC_LANG ) ? array() : $_CHC_LANG;
$_CHC_LANG = array_merge( $_CHC_LANG, array(


	// install.php
	'installation' => 'Installatie',
	'installation_step' => 'Installatie stap nr. %s',
	'welcome_message' => 'Welkom bij de chCounter installatie!',
	'error:higher_php_version_needed' => '<span class="critical_error">Fout:</span> Installatie/update is niet mogelijk op grond van een verouderde PHP versie.<br />Om de teller te kunnen gebruiken, moet PHP versie 4.2.0 of hoger geïnstalleerd zijn (momentele versie: %s)!',
	'error:could_not_connect_to_the_database' => '<span class="critical_error">Fout:</span> Kon geen verbinding krijgen met de database.<br />Zorg ervoor dat alle benodigde instellingen in het bestand includes/config.inc.php zijn gespecificeerd en correct!',	
	'please_choose_install_language' => 'Kies een taal:',
	'continue' => 'doorgaan',
	'higher_chcounter_version_available' => '<b>Hint:</b> Een hogere chCounter versie is beschikbaar!&nbsp;&nbsp;-&gt; <a href="http://chcounter.org/">chCounter website</a>',	
	'homepage_url' => 'Website URL',
	'description_homepage_url' => 'Vul hier de URL in van de website, waarin de teller later geïntegreerd wordt.<br />In het geval dat je een doorverwijs URL bezit, geef dan niet de doorverwijs URL op, maar de echte URL.',
	'admin_account' => 'Administrateur',
	'description_admin_account' => 'Vul hier de inlog gegevens in voor de administratie',
	'login_name:' => 'Naam:',
	'password:' => 'Wachtwoord:',
	'confirm_password:' => 'Wachtwoord (herhaling):',
	'please_uninstall_first_the_old_installation' => 'Deïnstalleer eerst de bestaande teller!',
	'back' => 'terug',
	'the_following_error_occurred:' => 'De volgende fout deed zich voor:',
	'the_following_errors_occurred' => 'De volgende fouten deden zich voor:',
	'fill_out_all_fields' => 'Vul in alle velden.',
	'db_connection_available' => 'Database verbinding beschikbaar.',
	'error_could_not_create_tables' => 'Een fout deed zich voor tijdens het maken van de database tabellen!',
	'error_could_not_insert_data' => 'Een fout deed zich voor tijdens het invoeren van gegevens!',
	'db_error_messages:' => 'De database foutmeldingen:',
	'tables_successfully_created' => 'Database tabellen aangemaakt.',
	'data_successfully_inserted' => 'Data ingevoerd.',
	'installation_finished' => '<span class="success">De teller is succesvol geïnstalleerd!</span><br />Nu kun je inloggen in de <a href="../administration">administratie</a>.',
	'remove_install_directory' => '<b>Belangrijk:</b><br />Verwijder de "install" map <i>onmiddellijk</i> na de installatie, dit in verband met veiligheidsredenen.',
	'the_passwords_do_not_match' => 'De wachtwoorden komen niet overeen.',


	// uninstall.php
	'uninstallation' => 'Deinstallatie',
	'database_tables_successfully_deleted' => 'De database tabellen zijn succesvol gewist.',
	'could_not_delete_database_tables' => 'De database tabellen konden niet worden gewist.',
	'uninstall_information' => 'Dit script wist onherroepelijk alle database tabellen van de teller. De tellerbestanden moeten handmatig worden verwijderd (via FTP).',
	'uninstall_now' => 'De teller nu deïnstalleren',


	// update.php
	// this file will be available in any higher version than 3.0.0
	'title_of_update_script' => 'chCounter: Update van 3.x.x naar versie %s',
	'update_welcome_message' => 'Welkom bij de chCounter update naar versie %s!<br />Dit script zal de database tabellen aanpassen.',
	'message_update_from_versions_lower_than_3.0.0' => '<b>Let op</b>:<br />Je moet eerst je chCounter installatie naar versie 3.0.0 updaten, alvorens je de update naar versie %s kunt uitvoeren.',
	'backup_message' => '<b>Belangrijk:</b><br />Backup eerst je oude database tabellen (bijv. met <a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a>) om in geval van een fout de tabellen te kunnen herstellen.',
	'error(s)_occurred' => 'Eén of meerdere fouten deden zich voor!',
	'update_finished' => 'De update naar versie %s is succesvol uitgevoerd!',



	// update_230_to_300.php
	'upgrade_welcome_message' => 'Welkom bij de chCounter upgrade naar versie %s!<br />Dit script zal de database tabellen aanpassen.',
	'upgrade_from_230_to_300' => 'chCounter: Upgrade van versie 2.3.0 naar 3.0.0',
	'error:could_not_find_db_tables' => '<span class="critical_error">Fout:</span> Kon niet de oude database tabellen vinden. Check of het bestand old_config.inc.php werkelijk het config bestand is van de 2.3.0 installatie.',
	'error:old_config_file_not_available' => '<span class="critical_error">Fout:</span> Kon niet het oude configuratie bestand van versie 2.3.0 vinden - check of je alle installeer instructies goed hebt opgevolgd.',
	'error:update_first_to_230' => '<span class="critical_error">Fout:</span> Je moet eerst naar versie 2.3.0 updaten. Check het bestand docs/update_en.txt voor de details.',
	'message_old_config_file_needed' => 'De upgrade vereist het oude, ingevulde bestand config.inc.php (van version 2.3.0). Wijzig de naam van dit bestand in "old_config.inc.php" en upload dit naar de "install" map van de teller.',
	'upgrade_finished' => 'De upgrade naar versie %s is succesvol uitgevoerd!',
	'create_temporary_backup_tables' => 'Maak tijdelijke backup tabellen.',
	'description_backup_tables' => 'In het geval van een fout worden de oude database tabellen hersteld; anders worden zij automatisch gewist na be&euml;indiging van deze upgrade.',
	'could_not_create_backup' => 'Kon geen backup maken van de database tabellen!'

) );
?>