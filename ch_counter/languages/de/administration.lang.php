﻿<?php

/*
 **************************************
 *
 * languages/de/administration.lang.php
 * -------------
 * last modified:	2007-01-13
 * -------------
 *
 * project:	chCounter
 * version:	3.1.3
 * copyright:	© 2005 Christoph Bachner
 *               ab 21.12.2006 Bert Koern
 * license:	GPL vs2.0 or higher [ see docs/license.txt ]
 * contact:	http://chCounter.org
 *
 **************************************
 */


$_CHC_LANG = !isset( $_CHC_LANG ) ? array() : $_CHC_LANG;
$_CHC_LANG = array_merge( $_CHC_LANG, array(



	/* main (./administration/index.php) */
	'administration' => 'Administration',
	'downloads' => 'Downloads', /* DOWNLOAD */
	'logs' => 'Logdaten',
	'news' => 'Aktuelles',
	'help' => 'Hilfe &amp; Kontakt',
	'logout' => 'Logout',
	'statistics' => 'Statistiken',
	'settings' => 'Einstellungen',
	'login' => 'Login',
	'logout_successful' => 'Erfolgreich ausgeloggt.',
	'logout_not_successful' => 'Beim Ausloggen trat ein Fehler auf.',
	'logout_affirmation' => 'Wenn du dich ausloggen möchtest, klicke auf den Button.<br />Wenn zuvor ein Cookie vergeben wurde, um dich automatisch wieder einzuloggen, wird dieses gelöscht.',
	'security_alert_install_directory' => '<span style="color: #FF0000">Wichtig:</span><br />Bitte lösche aus Sicherheitsgründen <i>unbedingt</i> das Verzeichnis »install«!',
	'welcome_message' => 'Willkommen in der chCounter-Administration!',


	/* News (./administration/new.inc.php) */
	'error_contacting_news_file' => 'Fehler: Konnte die News-Datei auf http://chcounter.org nicht finden/erreichen.',
	'no_news_available_at_present' => 'Momentan ist keine Nachricht vorhanden.',


	/* Logs (./administration/logs.inc.php) */
	'date_time' => 'Datum, Uhrzeit',
	'visitor_details' => 'Besucherdetails (Administration)',
	'no_visitors_logged_yet' => 'Noch keine Besucher gespeichert.',


	/* detailed user information (./administration/visitor_details.php) */
	'browser\'s_language_settings' => 'Browser-Spracheinstellung',
	'not_available' => 'nicht vorhanden',
	'preferred:' => 'bevorzugt:',	
	'javascript' => 'JavaScript',
	'js_available_and_activated' => 'vorhanden und aktiviert',
	'js_not_available_or_deactivated' => 'nicht aktiviert o. nicht vorhanden',
	'visited_pages' => 'Besuchte Seiten',
	'close_window' => 'Fenster schließen',

	/* Settings */
	'general_settings' => 'Allgemein',
	'global_settings' => 'Globale Einstellungen',
	'user_management' => 'Benutzerverwaltung',
	'counter' => 'Counter',
	'counter_settings' => 'Einstellungen',
	'edit_counter_records' => 'Counter-Werte verändern',
	'general' => 'Allgemein',
	'(de)activate_statistics' => 'Statistiken (de)aktivieren',
	'database_operations:' => 'Datenbankoperationen:',
	'reset_statistics' => 'Statistiken zurücksetzen',
	'data_cleanup' => 'Datenbereinigung',
	'lists:' => 'Listen:',
	'blacklists' => '»Schwarze Listen«',
	'exclusion_lists' => '»zu Ignorieren«',
	'hideout_lists' => '»zu Verbergen«',
	'statistics_display' => 'Statistikenanzeige:',
	'access_authorisations' => 'Zugriffsberechtigungen',
	'top/latest' => 'Die häufigsten/letzten &hellip;',
	'referrers,_search_engines_and_keywords' => 'Referrer, Suchmaschinen und Suchwörter',
	'visitors_details' => 'Besucherdetails',
	'all_lists' => '»Vollständige Auflistungen«',
	'pages_and_currently_online' => 'Seiten &amp; gerade online',
	'wrong_password' => 'Das angegebene Passwort ist falsch!',
	'configuration_updated' => 'Die Einstellung wurden aktualisiert.',
	'please_fill_out_each_required_field' => 'Bitte fülle jedes benötigte Feld aus!',
	'settings_description_guest_login' => 'Mit diesem Zugang können neben dem Administrator auch andere User die Statistiken einsehen, sollten diese für »normale« Besucher gesperrt sein. Bei Freilassen der Felder wird der Gast-Zugang deaktiviert.',
	'settings_description_admin_login' => 'Hier kannst du deinen Zugangsnamen und das Passwort ändern. Sollen die Passwörter nicht geändert werden, lasse sämtlich Passwort-Felder frei.',
	'save_settings' => 'Einstellungen speichern',
	'administrator' => 'Administrator',
	'guest_login' => 'Gast-Zugang',
	'name:' => 'Name:',
	'old_password:' => 'altes Passwort:',
	'new_password:' => 'neues Passwort:',
	'new_password_(repetition):' => 'neues Passwort:<br />(Wiederholung)',
	'general_counter_settings' => 'Allgemeine Counter-Einstellungen',
	'URLs' => 'URLs',
	'hp_url' => 'URL der Website:',
	'url_of_counter_directory' => 'URL des Counter-Verzeichnisses:',
	'charset' => 'Zeichensatz',
	'homepage_charset:' => 'Zeichensatz der Website',
	'default_counter_visibility:' => 'Sichtbarkeit des Counters (wenn nicht anders »vor Ort« angegeben):',
	'counter_status_statistic_pages:' => 'Counterstatus auf den Statistikseiten:',
	'counting_settings' => 'Zähleinstellungen',
	'description_blocking_mode' => 'Besucher nicht erneut zählen:',
	'for_x_seconds' => 'für %s Sekunden',
	'until_the_end_of_day' => 'bis Tagesende',
	'description_user_online_timespan' => 'Zeit ohne Aktion, innerhalb derer ein Besucher als »online« gilt:<br />(in Sek.)',
	'time_settings' => 'Zeiteinstellungen',
	'time_zone' => 'Zeitzone:',
	'enable_daylight_saving_time:' => 'Sommerzeit aktiv:',
	'use_admin_blocking_cookie' => 'Administrator mittels Cookie vom Zählen ausnehmen:',
	'do_not_count_robots' => 'Zähle keine Robots (z.B. Erfassungsprogramme der Suchmaschinen):',
	'language_settings' => 'Spracheinstellungen',
	'default_language' => 'Standardsprache von Counter und Statistiken:',
	'administration_language' => 'Sprache der Administration:',
	'yyyy-mm-dd' => 'JJJJ-MM-DD', // d=day, m=month, Y=Year  | please do not change the positions, only translate the abbreviations, if necessary
	'simultaneously_online' => 'Gleichzeitig online',
	'delete_log_entries_after:' => 'Lösche <a href="index.php?cat=logs">Log-Einträge</a> nach:',
	'delete_log_entries_after:unit:hours' => 'Stunden',
	'delete_log_entries_after:unit:days' => 'Tagen',
	'ignore_strings_with_a_length_less_than:' => 'Ignoriere Wörter mit weniger als:',
	'pages_statistic_page_titles' => 'Seitenstatistik: Seitentitel',
	'description_(de)activate_search_for_page_titles' => 'Der Counter durchsucht die Datei, in die er über PHP eingebunden ist, standardmäßig nach dem HTML-Seitentitel (siehe <i>install/readme_de.txt</i> für Details). Da dies jedoch eine nicht zu unterschätzende Rechenlast des Servers verursacht, kann die Suche nach dem Seitentitel auch deaktiviert werden.',
	'search_for_page_titles:' => 'Suche nach einem Seitentitel:',
	'pages_statistic_query_string_cleanup' => 'Seitenstatistik: Query-String-Bereinigung',
	'description_page_query_string_cleanup' => 'Der so genannte »Query-String« (z.B. »<i>?variablenname1=wert1&amp;<br />variablenname2=wert2&amp;&hellip;</i>«) kann vor dem Speichern vollständig oder teilweise entfernt werden, um überflüssige Einträge zu verhindern und die Statistik übersichtlich zu halten.<br /><br />Beispiel: aus der Seite »<i>index.php?kategorie=downloads&amp;sortiere=aufsteigend</i>« kann die Variable »<i>sortiere</i>« entfernt werden, Ergebnis: »<i>index.php?kategorie=downloads</i>«.<br />Die Installations-Konfiguration des Counters listet hier unwichtige Variablen der Statistik-Seiten auf.',
	'keep_the_complete_query_string' => 'Behalte den vollständigen Query-String',
	'remove_the_complete_query_string' => 'Entferne den vollständigen Query-String',
	'only_keep_the_following_variables:' => 'Behalte nur folgende Variablen:',
	'remove_the_following_variables:' => 'Entferne folgende Variablen:',
	'query_string_variables:' => 'Query-String-Variablen (untereinander trennen mit »; «):',
	'purge_page_entries_now' => 'Bereinige jetzt auch die in der Datenbank gespeicherten Seiten nach obigen Einstellungen.<br /><b>Achtung:</b> Dieser Schritt ist nicht umkehrbar!',
	'referrers_statistic_query_string_cleanup' => 'Referrerstatistik: Query-String-Bereinigung',
	'description_remove_referrer_query_string' => 'Auch bei den Referrern kann der Query-String vor dem Speichern entfernt werden. Es wird der <i>gesamte</i> Query-String entfernt, normalerweise ist dies jedoch nicht nötig oder empfohlen.',
	'remove_query_string:' => 'Query-String entfernen:',
	'description_blacklists' => 'Trifft ein Besucher auf eine der Listen zu, so wird der Counter auf inaktiv gesetzt, der Besucher nicht gezählt.<br />Jeder Eintrag muss in einer neuen Zeile stehen, ein % funktioniert als Platzhalter.',
	'IPs:' => 'IPs:',
	'hosts:' => 'Hosts:',
	'user_agents:' => 'User-Agents:',
	'referrers:' => 'Referrer:',
	'description_exclusion_lists' => 'Hier aufgeführte Informationen werden nicht in der Datenbank gespeichert.<br />Jeder Eintrag muss in einer neuen Zeile stehen, ein % funktioniert als Platzhalter.',
	'pages_(relative_from_hp_root):' => 'Seiten (Pfad von angegebener Website-URL ausgehend):',
	'search_engines:' => 'Suchmaschinen:',
	'search_keywords:' => 'Suchwörter:',
	'search_phrases:' => 'Suchphrasen:',
	'screen_resolutions:' => 'Bildschirm-Auflösungen:',
	'description_hideout_lists' => 'Hier aufgeführte, in der Datenbank gespeicherte Einträge werden nicht angezeigt. Sie bleiben jedoch gespeichert und können jederzeit wieder sichtbar gemacht werden.<br />Jeder Eintrag muss in einer neuen Zeile stehen, ein % funktioniert als Platzhalter.',
	'browsers:' => 'Browser:',
	'operating_systems:' => 'Betriebssysteme:',
	'robots:' => 'Robots:',
	'referring_domains:' => 'Verweisende Domains:',
	'description_(de)activate_statistics' => 'Einzelne Statistiken können deaktiviert werden, um z.B. den benötigten Speicherplatz in der Datenbank zu verringern (es werden keine neuen Werte mehr gespeichert).<br /><b>Wichtig:</b> Deaktivierte Statistiken werden immer noch dargestellt. Um diese auch sichtbar zu entfernen, muss du die entsprechenden Stellen in den Template-Dateien löschen.<br /><br />Folgende Statistiken sind <b>aktiv</b>:',
	'log_data' => 'Logdaten',
	'user_agents,browsers,os,robots' => 'User-Agents/Browser/Betriebssysteme/Robots',
	'pages_statistic' => 'Seitenstatistik',
	'countries_languages_hosts_statistic' => 'Länder/Sprachen/Host-TLDs',
	'search_engines_and_keywords' => 'Suchmaschinen &amp; Suchwörter',
	'reset_stats' => 'Statistiken zurücksetzen',
	'description_reset_stats' => 'Folgende Statistiken können zurückgesetzt werden:',
	'reset_statistics_now' => 'Statistiken jetzt zurücksetzen',
	'access_statistics' => 'Zugriffsstatistiken',
	'search_keywords_phrases' => 'Suchwörter/Suchphrasen',
	'visitors,page_views_per_day' => 'Besucher/Seitenaufrufe pro Tag',
	'page_views_per_visitor' => 'Seitenaufrufe pro Besucher',
	'reset_confirmation' => 'Sollen folgende Statistiken wirklich zurückgesetzt werden?',
	'statistics_were_reset' => 'Die ausgewählten Statistiken wurden zurückgesetzt.',
	'countries_statistic' => 'Länderstatistik',
	'languages_statistic' => 'Sprachenstatistik',
	'hosts_statistic' => 'Host-TLDs-Statistik',
	'check_all' => 'alle auswählen',
	'uncheck_all' => 'Auswahl entfernen',
	'general_cleanup' => 'Allgemeine Datenbereinigung',
	'description_general_cleanup' => 'Um die Anzahl der Datenbank-Abfragen gering zu halten, werden veraltete Daten (Log-Daten und temporäre Daten von ehemaligen Besuchern) nicht sofort, sondern in bestimmten Intervallen gelöscht.<br />Hier kann diese Löschung unabhängig vom Zeitintervall durchgeführt werden, im Normalfall ist dies jedoch <u>nicht</u> nötig.',
	'perform_cleanup' => 'Datenbereinigung durchführen',
	'user_agents,referrers_cleanup' => 'Löschen von User-Agents und Referrern',
	'description_user_agents,referrers_cleanup' => 'Mit der Zeit können sich in der Datenbank sehr viele Einträge mit nur einem einzigen oder wenigen Vorkommen ansammeln und wertvollen Speicherplatz belegen. Solche Einträge können gelöscht und zum Wert \'weitere\' zusammengefasst werden - die Gesamt-Statistik wird dabei nicht verzerrt.',
	'regular_cleanup' => 'Regelmäßiges Löschen verwaister Daten:',
	'immediate_cleanup' => 'Einmaliges und sofortiges Löschen:',
	'type:' => 'Typ:',
	'max_incidences:' => 'Maximale Vorkommen:',
	'days_passed_since_last_incidence:' => 'Vergangene Tage seit letztem Vorkommen:',
	'cleanup:type_and_number_of_entries' => "%1\$s (%2\$s Einträge insgesamt)",
	'cleanup_performed' => 'Die Datenbereinigung wurde durchgeführt.',
	'cleanup_performed_(x_rows_deleted)' => 'Die Datenbereinigung wurde durchgeführt (%s Einträge wurden gelöscht).',
	'description_access_authorisations' => 'Folgende Seiten sind nur für Administrator- oder Gastaccount einsehbar:',
	'referrers/referring_domains:common_settings' => 'Referrer/verweisende Websites: allgemein',
	'hyperlink_URLs:' => 'verlinke URLs:',
	'number_of_displayed_entries:' => 'Anzahl der anzuzeigenden Einträge:',
	'abbreviate_referrers_after:' => 'Kürze Referrer nach',
	'x_signs_(0_=_never)' => '%s Zeichen (0 = nie)',
	'(0_=_never)' => '(0 = nie)',
	'abbreviation_sign:' => 'Kürzungszeichen:',
	'force_wordwrap_after:' => 'Zeilenumbruch erzwingen nach',
	'settings_description_referrers,_search_engines_and_keywords' => '<i>Die hier aufgeführten Einstellungen betreffen die Rubrik »<a href="../stats/index.php?cat=referrers">Referrer</a>« der Statistiken.</i>',
	'settings_description_latest_top' => '<i>Die hier aufgeführten Einstellungen betreffen die »<a href="../stats/index.php">Hauptseite</a>« der Statistiken.</i>',
	'top_...' => 'Die häufigsten &hellip;',
	'latest_...' => 'Die neusten &hellip;',
	'settings_description_visitors_details' => '<i>Die hier aufgeführten Einstellungen betreffen die Rubrik »<a href="../stats/index.php?cat=visitors_details">Besucherdetails</a>« der Statistiken.</i>',
	'settings_description_pages' => '<i>Die hier aufgeführten Einstellungen betreffen die Rubrik »<a href="../stats/index.php?cat=pages">Seiten</a>« der Statistiken.</i>',
	'show_page_title:' => 'Zeige den Seitentitel an (sofern vorhanden):',
	'currently_online' => 'Gerade online',
	'online_users_ip_format:' => 'IP-Darstellung:',
	'do_not_show_IPs' => 'Zeige keine IPs',
	'force_wordwrap_of_page_name_after:' => 'Umbruch des angezeigten Seitennamens erzwingen nach',
	'settings_description_logs' => '<i>Die hier aufgeführten Einstellungen betreffen die »<a href="./index.php?cat=logs">Logdaten</a>« in der Administration.</i>',
	'entries_per_log_page:' => 'Einträge pro Logseite:',
	'display_the_entries_on_each_log_page:' => 'Zeige die Einträge auf jeder Logseite:',
	'settings_description_all_lists' => '<i>Die hier aufgeführten Einstellungen betreffen die »<a href="../stats/index.php?list_all">Vollständigen Auflistungen</a>« der Statistiken.</i>',
	'settings_description_access_statistics' => '<i>Die hier aufgeführten Einstellungen betreffen die »<a href="../stats/index.php?cat=access_statistics">Zugriffsstatistiken</a>«.</i>',
	'vertical-bar_diagramm_representation:' => 'Darstellungsweise der Balkendiagramme:',
	'description_vertical-bar_diagramm_representation:absolute' => 'nach Anteil an der Gesamtheit',
	'description_vertical-bar_diagramm_representation:relative' => 'relativ zum größten Einzelwert',
	'pages_statistic_data_source' => 'Seitenstatistik: Datenquelle',
	'description_pages_statistic_data_source' => 'Hier kann eingestellt werden, aus welchen Werten die jeweils aufgerufene Seite ermittelt werden soll (nur bei Einbindung über PHP). Erläuterungen zu den Möglichlichkeiten finden sich im <a href="http://www.php.net/manual/de/reserved.variables.php#reserved.variables.server" target="_blank">PHP-Manual</a>.',
	'use_PHP_SELF_or_REQUEST_URI:' => 'Benutze für die Seitenstatistik:',
	'exclude_robots_from_the_javascript_statistic' => 'Robots von der JavaScript-Statistik ausschließen:',
	'entry_and_exit_pages' => 'Einstiegs- und Ausgangsseiten',
	'the_requested_visitor_does_not_exist' => 'Der angeforderte Besucher existiert nicht in den Logdaten.',
	'settings_description_downloads_and_hyperlinks' => '<i>Die hier aufgeführten Einstellungen betreffen die Rubrik »<a href="../stats/index.php?cat=downloads_and_hyperlinks">Downloads &amp; Hyperlinks</a>« der Statistiken.</i>',


	// help
	'contact' => 'Kontakt',
	'obtain_inclusion_code:' => 'Einbindungshilfe:',
	'PHP' => 'PHP',
	'JavaScript' => 'JavaScript',
	'description_support' => 'Weitere Informationen und Hilfen findest Du auf: <a href="http://chcounter.org/" target="_blank"><b>http://chcounter.org</b></a><br /><br />Solltest du Hilfe benötigten oder Vorschläge/Kritik loswerden wollen, besuche am Besten das <a href="http://phorum.excelhost.de/index.php?42" target="_blank"><b>chCounter-Forum</b></a>.<br /><br />Alternativ bin ich auch per E-Mail an die <a href="http://chcounter.org/index.php?s=kontakt" target="_blank">auf dieser Internetseite ersichtlichen Emailadresse</a> zu erreichen.<br /><br /><font color="red">Wenn du ein Problem mit dem chCounter hast, suche bitte <b>zuerst</b> in der <b>Installationsanleitung</b>, der <b>ReadMe-Datei</b> und den <b>FAQs</b> (häufig gestellten Fragen) sowie im <a href="http://phorum.excelhost.de/index.php?42" target="_blank"><b>chCounter-Forum</b></a> nach einer Lösung.</font><br /><br />Info:<br />Dieser chCounter basiert auf dem chCounter3.1.1 von Christoph Bachner<br /><br />Gruß<br />Berti',
	'counter_inclusion_via_PHP' => 'Counter-Einbindung mit PHP',
	'description_php_include_code' => 'Hier kannst du dir den PHP-Code generieren lassen, welchen du zum Einbinden des Counters benötigst.',
	'important:' => 'Wichtig:',
	'notice_file_extension' => 'Bitte beachte, dass im Normalfall die Dateiendung .php lauten muss, damit der PHP-Code ausgeführt werden kann. In der Installationsanleitung ist eine Möglichkeit beschrieben, um dennoch PHP-Code in einer .html-Datei ausführen zu lassen.',
	'notice_individual_template_and_indentation' => 'Wenn ein individuelles Templates angegeben wird, darf der PHP-Code später niemals (!) eingerückt werden.',
	'visible' => 'sichtbar',
	'invisible' => 'unsichtbar',
	'active' => 'aktiv',
	'inactive' => 'inaktiv',
	'optional_page_title:' => 'Seitentitel (optional):',
	'optional_individual_template:' => 'individuelles Templates (optional):',
	'generate_php_code' => 'PHP-Code erstellen',
	'counter_inclusion_via_JavaScript' => 'Counter-Einbindung mit JavaScript',
	'description_js_include_code' => 'Hier kannst du dir den JS-Code generieren lassen, welchen du zum Einbinden des Counters benötigst.',
	'notice_advantages_of_including_with_php' => 'Wenn möglich, sollte der Counter <b>immer</b> mit PHP eingebunden werden. Wird JavaScript genutzt, können z.B. sämtliche Besucher mit deaktiviertem JavaScript und alle Robots/Suchmaschinen nicht gezählt werden.',
	'generate_JavaScript_code' => 'JavaScript-Code erstellen',
	'generated_code' => 'generierter Code:',
	
	
	// Downloads & Hyperlinks
	'download_feature_is_deactivated' => 'Die Downloadcounter-Funktion ist deaktiviert!',
	'new_download' => 'Neuen Download eintragen.',
	'upload_date' => 'Upload-Datum',
	'name' => 'Name',
	'ID' => 'ID',
	'URL' => 'URL',
	'upload' => 'Upload',
	'last_download' => 'letzter Download',
	'edit' => 'bearbeiten',
	'delete' => 'löschen',
	'to_the_overall_view' => '-&gt; Zur Übersicht.',
	'back_to_the_overall_view' => 'Zurück zur Übersicht.',
	'download_successfully_inserted' => 'Der Download wurde erfolgreich eingetragen.',
	'download_could_not_be_inserted' => 'Der Download konnte nicht eingetragen werden.',
	'insert_a_new_download' => 'Neuen Download eintragen:',
	'please_fill_out_every_field' => 'Bitte fülle jedes Feld aus!',
	'insert_download' => 'Download eintragen',
	'entry_successfully_updated' => 'Der Eintrag wurde erfolgreich aktualisiert.',
	'entry_could_not_be_updated' => 'Der Eintrag konnte nicht aktualisiert werden.',
	'could_not_find_the_requested_entry' => 'Der angeforderte Eintrag konnte nicht gefunden werden.',
	'edit_a_download_entry' => 'Downloadeintrag bearbeiten:',
	'number_of_downloads' => 'Anzahl der Downloads',
	'time_of_upload' => 'Zeitpunkt des Uploads',
	'save_entry' => 'Eintrag speichern',
	'entry_successfully_deleted' => 'Der Eintrag wurde erfolgreich gelöscht.',
	'entry_could_not_be_deleted' => 'Der Eintrag konnte nicht gelöscht werden.',
	'entries_successfully_deleted' => 'Die Einträge wurden erfolgreich gelöscht.',
	'entries_could_not_be_deleted' => 'Die Einträge konnten nicht gelöscht werden.',
	'delete_entry?' => 'Eintrag löschen?',
	'delete_entry_now' => 'Eintrag jetzt löschen',
	'delete_the_selected_entries' => 'Lösche die ausgewählten Einträge',
	'delete_entries' => 'Einträge löschen',
	'delete_many_entries_confirmation' => 'Sollen die folgenden Einträge entgültig gelöscht werden?',
	'delete_all_displayed_entries_now' => 'Ja, alle aufgeführten Einträge jetzt löschen.',
	'HTML_Code' => 'HTML-Code',
	'general_URL_for_download_counting:' => 'Allgemeine URL zum Verlinken eines Downloads:',
	'general_URL_for_hyperlink_counting:' => 'Allgemeine URL eines Hyperlink-Eintrages:',
	
	'hyperlink_feature_is_deactivated' => 'Die Linkzähler-Funktion ist deaktiviert!',
	'new_hyperlink' => 'Neuen Hyperlink eintragen.',
	'added' => 'hinzugefügt',
	'last_click' => 'Letzter Klick',
	'insert_a_new_hyperlink' => 'Neuen Hyperlink eintragen:',
	'insert_hyperlink' => 'Hyperlink eintragen',
	'hyperlink_successfully_inserted' => 'Der Hyperlink wourde erfolgreich eingetragen.',
	'hyperlink_could_not_be_inserted' => 'Der Hyperlink konnte nicht eingetragen werden.',
	'edit_a_hyperlink_entry' => 'Hyperlinkeintrag bearbeiten:',
	'number_of_clicks' => 'Anzahl der Klicks',
	'number_of_clicks' => 'Klicks gesamt'

) );

?>