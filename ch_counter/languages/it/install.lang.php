<?php

/*
 **************************************
 *
 * languages/it/install.lang.php
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
*/


$_CHC_LANG = !isset( $_CHC_LANG ) ? array() : $_CHC_LANG;
$_CHC_LANG = array_merge( $_CHC_LANG, array(


	// install.php
	'installation' => 'Installazione',
	'installation_step' => 'Passo n° %s',
	'welcome_message' => 'Benvenuto nell\'installazione di chCounter!',
	'error:higher_php_version_needed' => '<span class="critical_error">Errore:</span> L\'operazione non è possibile perché la versione di PHP è troppo vecchia.<br />Versione minima richiesta: 4.2.0 (versione corrente: %s)!',
	'error:could_not_connect_to_the_database' => '<span class="critical_error">Errore:</span> Impossibile connettersi al database.<br />Controlla che le impostazioni necessarie siano impostate e corrette nel file includes/config.inc.php!',
	'please_choose_install_language' => 'Scegli una lingua:',
	'continue' => 'avanti',
	'higher_chcounter_version_available' => '<b>Suggerimento:</b> Una versione più aggiornata di chCounter è disponibile!&nbsp;&nbsp;-&gt; <a href="http://chcounter.org/">sito di chCounter</a>',
	'homepage_url' => 'URL sito',
	'description_homepage_url' => 'Inserisci la URL del sito nel quale il contatore sarà inserito più tardi.<br />In caso di un reindirizzamento, inserire l\'URL reale, non quella di reindirizzamento.',
	'admin_account' => 'Amministratore',
	'description_admin_account' => 'Inserisci i dati di login per il PdC amministratori.',
	'login_name:' => 'User:',
	'password:' => 'Password:',
	'confirm_password:' => 'Password (conferma):',
	'please_uninstall_first_the_old_installation' => 'Disinstalla prima la versione esistente di chCounter!',
	'back' => 'indietro',
	'the_following_error_occurred:' => 'Si è verificato l\'errore seguente:',
	'the_following_errors_occurred' => 'Si sono verificati gli errori seguenti:',
	'fill_out_all_fields' => 'Per favore completa tutti i campi.',
	'db_connection_available' => 'Connessione al database riuscita.',
	'error_could_not_create_tables' => 'Si è verificato un errore durante la creazione delle tabelle nel database!',
	'error_could_not_insert_data' => 'Si è verificato un errore durante la popolazione delle tabelle!',
	'db_error_messages:' => 'I messaggi di errore del database:',
	'tables_successfully_created' => 'Tabelle create.',
	'data_successfully_inserted' => 'Tabelle popolate.',
	'installation_finished' => '<span class="success">Il contatore è stato installato con successo!</span><br />Ora puoi loggarti nel <a href="../administration">PdC amministratori</a>.',
	'remove_install_directory' => '<b>Important:</b><br />Per favore cancella la cartella "install" <i>immediatamente</i> per evitare possibili problemi di sicurezza.',
	'the_passwords_do_not_match' => 'Le password non coincidono.',


	// uninstall.php
	'uninstallation' => 'Disinstallazione',
	'database_tables_successfully_deleted' => 'Le tabelle sono state eliminate con successo dal database.',
	'could_not_delete_database_tables' => 'Impossibile eliminare le tabelle dal database.',
	'uninstall_information' => 'Questo script cancella le tabelle del counter dal database in modo irrevocabile. I file del contatore devono essere rimossi manualmente (via FTP).',
	'uninstall_now' => 'disinstallare il contatore ora',


	// update.php
	// this file will be available in any higher version than 3.0.0
	'title_of_update_script' => 'chCounter: Aggiornamento dalla versione 3.x.x alla versione %s',
	'update_welcome_message' => 'Benvenuto all\'update di chCounter alla versione %s!<br />Questo script adatterà le tabelle del dabatase.',
	'message_update_from_versions_lower_than_3.0.0' => '<b>Attenzione</b>:<br />Devi aggiornare chCounter alla versione 3.0.0, prima di poter applicare l\'aggiornamento alla versione %s.',
	'backup_message' => '<b>Importante:</b><br />Fai prima un backup delle tabelle del database (ad es. con <a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a>) per poterle ripristinare in caso di errore.',
	'error(s)_occurred' => 'Si sono verificati uno o più errori!',
	'update_finished' => 'L\'aggiornamento alla versione %s si è completato con successo!',



	// update_230_to_300.php
	'upgrade_welcome_message' => 'Benvenuto all\'update di chCounter alla versione %s!<br />Questo script adatterà le tabelle del dabatase.',
	'upgrade_from_230_to_300' => 'chCounter: Aggiornamento dalla versione 2.3.0 alla versione 3.0.0',
	'error:could_not_find_db_tables' => '<span class="critical_error">Errore:</span> Impossibile trovare alcune (o tutte) le vecchie tabelle nel database. Controlla se il file old_config.inc.php è veramente il file di configurazione della versione 2.3.0 rinominato.',
	'error:old_config_file_not_available' => '<span class="critical_error">Errore:</span> Impossibile trovare il vecchio file di configurazione della versione 2.3.0 - assicurati di aver seguito tutte le istruzioni di installazione correttamente.',
	'error:update_first_to_230' => '<span class="critical_error">Errore:</span> You have to update first to version 2.3.0. Please check the file docs/update_en.txt for details.',
	'message_old_config_file_needed' => 'L\'aggiornamento richiede il vecchio file config.inc.php (della versione 2.3.0) opportunamento compilato. Rinomina questo file in "old_config.inc.php" e caricalo nella cartella "install" del counter.',
	'upgrade_finished' => 'L\'aggiornamento alla versione %s si è completato con successo!',
	'create_temporary_backup_tables' => 'Creazione tabelle temporanee.',
	'description_backup_tables' => 'In caso di errore le vecchie tabelle verranno recuperate; altrimenti saranno cancellate automaticamente dopo il completamento del processo.',
	'could_not_create_backup' => 'Impossibile creare il backup delle tabelle!'

) );
?>