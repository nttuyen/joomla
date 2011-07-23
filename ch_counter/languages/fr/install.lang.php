<?php

/*
 **************************************
 *
 * languages/fr/install.lang.php
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
 * Translation by: Thomas Erhard <erhard@ilo.de>
 *
 **************************************
*/


$_CHC_LANG = !isset( $_CHC_LANG ) ? array() : $_CHC_LANG;
$_CHC_LANG = array_merge( $_CHC_LANG, array(


	// install.php
	'installation' => 'installation',
	'installation_step' => 'démarche d\'installation No. %s',
	'welcome_message' => 'Bienvenue à l\'installation du chCounter!',
	'error:higher_php_version_needed' => '<span class="critical_error">Faute:</span> installation/Update impossbile à cause d\'une version PHP trop vieille.<br />Pour qu\'on puisse utiliser le compteur, PHP dans la Version 4.2.0 ou plus haut doit être installé (Version PHP actuelle: %s)!',
	'error:could_not_connect_to_the_database' => '<span class="critical_error">Faute:</span> Il était impossible d\'établir une connexion à la base des données.<br />S\'il te plait, vérifié, si toutes les nécessaires indications sur la base de données dans la fiche includes/config.inc.php sont correctes!',
	'please_choose_install_language' => 'Choisis une langue, s\'il te plait:',
	'continue' => 'continuer',
	'higher_chcounter_version_available' => '<b>Renseignement:</b> Il y a une version plus nouvelle du compteur!&nbsp;&nbsp;-&gt; <a href="http://chcounter.org/">Site Internet du chCounter</a>',
	'homepage_url' => 'URL du site web',
	'description_homepage_url' => 'S\'il te plait donne ici l\URL du site web dans les pages duquel le compteur va être intégré.<br />Si tu possède un détournement (comme p. ex. *.fr.vu), indique le vrai URL de tes fiches du site web, pas l\'adresse détournée.',
	'admin_account' => 'Administrateur',
	'description_admin_account' => 'Avec les données à indiquer ici, tu peux t\'enlogger après l\'installation dans l\'administration.',
	'login_name:' => 'Nom:',
	'password:' => 'Mot de passe:',
	'confirm_password:' => 'Mot de passe (répétition):',
	'please_uninstall_first_the_old_installation' => 'S\'il te plait, désinstalle d\'abord l\'installation du compteur déjà existante!',
	'back' => 'En arrière',
	'the_following_error_occurred:' => 'Il y avait la faute suivante:',
	'the_following_errors_occurred' => 'Il y avaient les fautes suivantes:',
	'fill_out_all_fields' => 'Tous les champs n\'ont pas été remplis.',
	'db_connection_available' => 'Connexion à la base des données établie.',
	'error_could_not_create_tables' => 'Les tableaux ne pouvaient pas être établis sans faute!',
	'error_could_not_insert_data' => 'Les tableaux ne pouvaient pas être remplis de données sans faute!',
	'db_error_messages:' => 'Die Datenbank-Fehlermeldungen:',
	'tables_successfully_created' => 'Les tableaux de la base des données ont été établis avec succès.',
	'data_successfully_inserted' => 'Les tableaux ont été remplis de données avec succès.',
	'installation_finished' => '<span class="success">Le compteur a été installé avec du succès!</span><br /> Maintenant, tu peux t\'enlogger dans l\'<a href="../administration">administration</a>.',
	'remove_install_directory' => '<b>Important:</b><br />Efface <i>absolument</i> le fichier »install« pour empêcher le désabus!',
	'the_passwords_do_not_match' => 'Les mots de passe ne correspondent pas.',


	// uninstall.php
	'uninstallation' => 'Désinstallation',
	'database_tables_successfully_deleted' => 'Les tableaux de la base de données du compteur ont été effacé avec succès.',
	'could_not_delete_database_tables' => 'Les tableaux de la base de données du compteur ne pouvaient pas être effacés.',
	'uninstall_information' => 'Ce script efface irréversiblement tous les tableaux de la base de données du compteur. Les fiches du compteur doivent être enlevées manuellement (àl\'aide de FTP).',
	'uninstall_now' => 'desinstaller le compteur maintenant',


	// update.php
	// this file will be available in any higher version than 3.0.0
	'title_of_update_script' => 'chCounter: Mise à jour de 3.x.x vers la Version %s',
	'update_welcome_message' => 'Bienvenue à la mise à jour du chCounter vers la Version %s!<br />Ce Script va adapter les tableaux de la base de données du compteur.',
	'message_update_from_versions_lower_than_3.0.0' => '<b>Attention</b>:<br />D\'abord, il faut actualiser ton installation du compteur vers la version 3.0.0 avant d\'effectuer la mise à jour vers %s.',
	'backup_message' => '<b>Important:</b><br />S\'il te plait, sauvegarde les vieux tableaux de la base de données du compteur avant la mise à jour (p. ex. avec <a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a>), pour pouvoir les récupérer au cas d\'une faute et de données détruites.',
	'error(s)_occurred' => 'Il y avait une ou plusieurs fautes!',
	'update_finished' => 'La mise à jour à la version %s a été effectuée avec succès!',



	// upgrade_230_to_300.php
	'upgrade_welcome_message' => 'Bienvenue à la mise à jour du chCounter vers la Version %s!<br />Ce Script va adapter les tableaux de la base de données du compteur.',
	'upgrade_from_230_to_300' => 'chCounter: Mise à jour de 2.3.0 vers 3.0.0',
	'error:could_not_find_db_tables' => '<span class="critical_error">Faute:</span> Aucuns des vieux tableaux de la base des données ou bien tous ne pouvaient pas être trouvés. Vérifie s\'il te plait, si la fiche old_config.inc.php provient vraiment de la vieille installation du compteur et qu\'elle soit remplie (!).',
	'error:old_config_file_not_available' => '<span class="critical_error">Faute:</span> La vieille fiche de configuration de la version 2.3.0 ne pouvait pas être retrouvée - Vérifie s\'il te plait, si tu as effectué toutes les consignes correctement.',
	'error:update_first_to_230' => '<span class="critical_error">Faute:</span> D\'abord, le compteur doit être actualisé vers la version 2.3.0 - voir dans la fiche docs/update_de.txt.',
	'message_old_config_file_needed' => 'Pour la mise á jour la vieille fiche config.inc.php (de la Version 2.3.0) bien remplie est indispensable. S\'il te plait, rebaptis cette fiche »old_config.inc.php« et uploade-la dans le fichier »install« du compteur.',
	'upgrade_finished' => 'La mise à jour vers la Version %s á été effectuée avec succès!',
	'create_temporary_backup_tables' => 'Elabore des tableaux de sauvegarde de secours temporaires.',
	'description_backup_tables' => 'Au cas d\'une faute, les vieux tableaux sont rétablis, sinon les tableaux de sauvegarde des secours sont effacés automatiquement après la mise á jour couronnée de succès.',
	'could_not_create_backup' => 'Une sauvegarde des tableaux de la base des données ne pouvait pas être effectuée.',

) );
?>