<?php

/*
 **************************************
 *
 * languages/de/install.lang.php
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
	'installation' => 'Installation',
	'installation_step' => 'Installationsschritt Nr. %s',
	'welcome_message' => 'Willkommen zur Installation vom chCounter!',
	'error:higher_php_version_needed' => '<span class="critical_error">Fehler:</span> Installation/Update aufgrund zu alter PHP-Version nicht möglich.<br />Um den Counter benutzen zu können, muss PHP in Version 4.2.0 oder höher installiert sein (aktuelle PHP-Version: %s)!',
	'error:could_not_connect_to_the_database' => '<span class="critical_error">Fehler:</span> Es konnte keine Verbindung zur Datenbank aufgebaut werden.<br />Bitte überprüfe, ob alle benötigten Angaben zur Datenbank in der Datei includes/config.inc.php korrekt sind!',
	'please_choose_install_language' => 'Bitte wähle eine Sprache aus:',
	'continue' => 'fortfahren',
	'higher_chcounter_version_available' => '<b>Hinweis:</b> Eine aktuellere chCounter-Version ist vorhanden!&nbsp;&nbsp;-&gt; <a href="http://chcounter.org">chCounter Website</a>',
	'homepage_url' => 'Website-URL',
	'description_homepage_url' => 'Bitte gib hier die URL der Website an, in deren Seiten der Counter später eingebunden wird.<br />Solltest du eine Umleitung (wie z.B. *.de.vu) besitzen, so gib die tatsächliche URL deiner Website-Dateien an, und nicht die Umleitung.',
	'admin_account' => 'Administrator',
	'description_admin_account' => 'Mit den hier anzugebenden Daten kannst du dich nach der Installation in der Administration einloggen.',
	'login_name:' => 'Name:',
	'password:' => 'Passwort:',
	'confirm_password:' => 'Passwort (Wiederholung):',
	'please_uninstall_first_the_old_installation' => 'Bitte deinstalliere zuerst die vorhandene Counter-Installation!',
	'back' => 'zurück',
	'the_following_error_occurred:' => 'Es trat der folgende Fehler auf:',
	'the_following_errors_occurred' => 'Es traten folgenden Fehler auf:',
	'fill_out_all_fields' => 'Es wurden nicht alle Felder ausgefüllt.',
	'db_connection_available' => 'Datenbank-Verbindung vorhanden.',
	'error_could_not_create_tables' => 'Die Tabellen konnte nicht fehlerfrei erstellt werden!',
	'error_could_not_insert_data' => 'Die Tabellen konnte nicht fehlerfrei mit Daten gefüllt werden!',
	'db_error_messages:' => 'Die Datenbank-Fehlermeldungen:',
	'tables_successfully_created' => 'Die Datenbank-Tabellen wurden erfolgreich erstellt.',
	'data_successfully_inserted' => 'Die Tabellen wurden erfolgreich mit Daten gefüllt.',
	'installation_finished' => '<span class="success">Der Counter wurde erfolgreich installiert!</span><br /> Du kannst dich jetzt in der <a href="../administration">Administration</a> einloggen.',
	'remove_install_directory' => '<b>Wichtig:</b><br />Lösche <i>unbedingt</i> das »install«-Verzeichnis, um Missbrauch zu verhindern!',
	'the_passwords_do_not_match' => 'Die Passwörter stimmen nicht überein.',


	// uninstall.php
	'uninstallation' => 'Deinstallation',
	'database_tables_successfully_deleted' => 'Die Datenbank-Tabellen des Counters wurden erfolgreich gelöscht.',
	'could_not_delete_database_tables' => 'Die Datenbank-Tabellen des Counters konnten nicht gelöscht werden.',
	'uninstall_information' => 'Dieses Script löscht alle Datenbank-Tabellen des Counters unwiderruflich. Die Counter-Dateien selbst müssen manuell (per FTP) entfernt werden.',
	'uninstall_now' => 'den Counter jetzt deinstallieren',


	// update.php
	// this file will be available in any higher version than 3.0.0
	'title_of_update_script' => 'chCounter: Update von 3.x.x auf Version %s',
	'update_welcome_message' => 'Willkommen zum Update des chCounter auf Version %s!<br />Dieses Script wird die Datenbank-Tabellen anpassen.',
	'message_update_from_versions_lower_than_3.0.0' => '<b>Achtung</b>:<br />Du musst zunächst deine chCounter-Installation auf Version 3.0.0 aktualisieren, bevor du das Update auf %s durchführen kannst.',
	'backup_message' => '<b>Wichtig:</b><br />Bitte sichere vor dem Update die alten Datenbank-Tabellen (z.B. mit <a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a>), um diese im Falle eines Fehlers und zerstörter Daten wiederherstellen zu können.',
	'error(s)_occurred' => 'Es trat ein oder mehrere Fehler auf!',
	'update_finished' => 'Das Update auf Version %s wurde erfolgreich durchgeführt!',



	// upgrade_230_to_300.php
	'upgrade_welcome_message' => 'Willkommen zum Upgrade des chCounter auf Version %s!<br />Dieses Script wird die Datenbank-Tabellen anpassen.',
	'upgrade_from_230_to_300' => 'chCounter: Upgrade von Version 2.3.0 auf 3.0.0',
	'error:could_not_find_db_tables' => '<span class="critical_error">Fehler:</span> Es konnten keine bzw. nicht alle alten Datenbank-Tabellen gefunden werden. Bitte überprüfe, ob die Datei old_config.inc.php tatsächlich von der alten Counter-Installation stammt und ausgefüllt(!) ist.',
	'error:old_config_file_not_available' => '<span class="critical_error">Fehler:</span> Die alte Konfigurations-Datei der Version 2.3.0 konnte nicht gefunden werden - bitte prüfe, ob du alle Anweisungen korrekt durchgeführt hast.',
	'error:update_first_to_230' => '<span class="critical_error">Fehler:</span> Der Counter muss zunächst auf Version 2.3.0 aktualisiert werden - siehe in der Datei docs/update_de.txt.',
	'message_old_config_file_needed' => 'Zum Upgrade wird die alte, ausgefüllte Datei config.inc.php (von Version 2.3.0) noch benötigt. Bitte benenne diese Datei um zu »old_config.inc.php« und lade diese in das Verzeichnis »install« des Counters hoch.',
	'upgrade_finished' => 'Das Upgrade auf Version %s wurde erfolgreich durchgeführt!',
	'create_temporary_backup_tables' => 'Erstelle temporäre Backuptabellen.',
	'description_backup_tables' => 'Im Falle eines Fehlers werden die alten Tabellen wiederhergestellt, andernfalls werden die Backuptabellen nach Abschluss des Upgrades automatisch wieder gelöscht.',
	'could_not_create_backup' => 'Konnte kein Backup der Datenbanktabellen erstellen!'

) );
?>