<?php

/*
 **************************************
 *
 * languages/hu/install.lang.php
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
 * Translation by: Georg Gottschling
 *
 **************************************
*/


$_CHC_LANG = !isset( $_CHC_LANG ) ? array() : $_CHC_LANG;
$_CHC_LANG = array_merge( $_CHC_LANG, array(


	// install.php
	'installation' => 'Telepítés',
	'installation_step' => 'Telepítési lépés Nr. %s',
	'welcome_message' => 'Üdvözöllek a chCounter telepítésénél!',
	'error:higher_php_version_needed' => '<span class="critical_error">Hiba:</span> Telepítés/Update a PHP-Verzió öregsége miatt nem lehetséges.<br />A Counter(Számláló) használatához a PHP Verzió 4.2.0-re (vagy újabb) van szükséged (az aktuális PHP-Verzió: %s)!',
	'error:could_not_connect_to_the_database' => '<span class="critical_error">Hiba:</span> Az Adatbankkal nem sikerült az összeköttetést létrehozni.<br />Kérlek vizsgáld meg, hogy az Adatbankra és Felhasználóra vonatkozó Adatok a includes/config.inc.php fájlban helyesk-e!',
	'please_choose_install_language' => 'Kérlek válassz ki egy nyelvet:',
	'continue' => 'folytatni',
	'higher_chcounter_version_available' => '<b>Figyelem:</b> Egy újabb chCounter-Version áll rendelkezésre!&nbsp;&nbsp;-&gt; <a href="http://chcounter.org/">chCounter Weboldal</a>',
	'homepage_url' => 'Weboldal-URL',
	'description_homepage_url' => 'Add meg kérlek a Weboldal URL-ét aminek az Oldalán késöbb a Counter(Számláló) telepítére kerül.<br />Amennyiben pl. egy Subdomain-röl vagy továbbirányításrol van szó (pl. *.hu.vu) akkor a Weboldal ténylegesso URL-jét add meg (nem a Subdomain-t vagy továbbirányítást).',
	'admin_account' => 'Adminisztrátor',
	'description_admin_account' => 'Az itt megadott Adatokkel tudsz a Telepítés után az Adminisztrációba belépni.',
	'login_name:' => 'Név:',
	'password:' => 'Jelszó:',
	'confirm_password:' => 'Jelszó (ismétlés):',
	'please_uninstall_first_the_old_installation' => 'Kérlek elöször távolítsd el a rendelkezésre álló Counter(Számláló) Telepítését!',
	'back' => 'vissza',
	'the_following_error_occurred:' => 'A következö Hiba lépett fel:',
	'the_following_errors_occurred' => 'A következö Hibák léptek fel:',
	'fill_out_all_fields' => 'Nem lett az összes Mezö kitöltve.',
	'db_connection_available' => 'Az Adatbank összeköttetés létrejött/rendelkezésre áll.',
	'error_could_not_create_tables' => 'A Táblázatokat nem sikerült hibátlanul létrehozni!',
	'error_could_not_insert_data' => 'A Táblázatokat nem sikerült hibátlanul Adatokkal feltölteni!',
	'db_error_messages:' => 'Az Adatbank Hibaüzenetei:',
	'tables_successfully_created' => 'Az Adatbank-Táblázatokat sikerült hibátlanul létrehozni!',
	'data_successfully_inserted' => 'A Táblázatokat sikerült hibátlanul Adatokkal feltölteni.',
	'installation_finished' => '<span class="success">A Counter(Számláló) sikeresen telepítve lett!</span><br /> Ezek után be tudsz lépni az <a href="../administration">Adminisztrációba</a>.',
	'remove_install_directory' => '<b>Fontos:</b><br />A visszaéléseket megakadályozni távolítsd el <i>feltétlenül</i> az »install«-Könyvtárat!',
	'the_passwords_do_not_match' => 'A Jelszavak nem egyeznek meg.',


	// uninstall.php
	'uninstallation' => 'A Telepítés eltávolítása',
	'database_tables_successfully_deleted' => 'A Counter(Számláló) Adatbank-Táblázatai eredményesen el lettek távolítva.',
	'could_not_delete_database_tables' => 'A Counter(Számláló) Adatbank-Táblázatai eltávolítása nem sikerült.',
	'uninstall_information' => 'Ez a Script eltávolítja végérvényesen a Counter(Számláló) összes Adatbank-Táblázatát. A Counter(Számláló) Fájljait manuálisan (FTP segitségével) kell eltávolítani.',
	'uninstall_now' => 'a Counter(Számláló) el lett távolítva',


	// update.php
	// this file will be available in any higher version than 3.0.0
	'title_of_update_script' => 'chCounter: Update 3.x.x-rol %s Verzióra',
	'update_welcome_message' => 'Üdvözöllek a chCounter %s Verzió Update-nél!<br />Ez a Script az Adatbank-Táblázatait módosítja.',
	'message_update_from_versions_lower_than_3.0.0' => '<b>Figyelem</b>:<br />Az Update elvégzéséhez elöször egy 3.0.0 Verzióju chCounter-t kell Telepítened vagy aktualizálnod, csak ezután tudod a %s Update-t elvégezni.',
	'backup_message' => '<b>Wichtig:</b><br />Kérlek az Update elött biztosítsd az Adatbank-Táblázatokat (pl. a <a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a>)-nal, hogy egy esetleges zavar esetén az eredeti állapotot helyre tudd állítani.',
	'error(s)_occurred' => 'Egy vagy több Hiba lépett fel!',
	'update_finished' => 'A %s Verzió Update-ja sikeresen végre lett hajtva!',



	// upgrade_230_to_300.php
	'upgrade_welcome_message' => 'Üdvözöllek a chCounter %s Verzió Updgrad-jénél!<br />Ez a Script az Adatbank-Táblázatait módosítja.',
	'upgrade_from_230_to_300' => 'chCounter: Upgrade 2.3.0 Verziórol 3.0.0-ra',
	'error:could_not_find_db_tables' => '<span class="critical_error">Hiba:</span> Nem találtam több (vagy egyetlen) öreg Adatbank-Táblázatot sem. Kérlek ellenörizd, hogy az old_config.inc.php Fájl az öreg Counter(Számláló) Telepítéséböl származik-e és Adatokkal ki van-e töltve!',
	'error:old_config_file_not_available' => '<span class="critical_error">Hiba:</span> A 2.3.0 Verzió öreg Konfigurációs-Adatai nem találhatók - kérlek vizsgáld meg, hogy az összes utasítást korrektül végrehajtottál-e.',
	'error:update_first_to_230' => '<span class="critical_error">Hiba:</span> Elöször a Counter(Számláló) 2.3.0 Verzióját kell aktualizálni - lásd docs/update_de.txt.',
	'message_old_config_file_needed' => 'Az Upgrade-hoz szükség van az öreg, kitöltött config.inc.php (Verzió 2.3.0) fájlra. Kérlek nevezd ezt a fájlt »old_config.inc.php«-ra és töltsd fel a Conter(Számláló) »install« Könyvtárába.',
	'upgrade_finished' => 'Az Upgrade a %s Verzióra eredményesen megtörtént!',
	'create_temporary_backup_tables' => 'Elöállítok temporér Backup-Táblázatokat.',
	'description_backup_tables' => 'Hiba esetén az öreg Táblázatok helyreállításra kerülnek, ellenkezö esetben az Upgrad után a Backup-Táblázatok automatikusan törlésre kerülnek.',
	'could_not_create_backup' => 'nem sikerült az Adatbank-Táblázatokrol Backup-ot elöállítani!'

) );
?>