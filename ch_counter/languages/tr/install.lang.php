<?php

/*
 **************************************
 *
 * languages/tr/install.lang.php
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
	'installation_step' => 'Installation step No. %s',
	'welcome_message' => 'Welcome to the chCounter installation!',
	'error:higher_php_version_needed' => '<span class="critical_error">Error:</span> Installation/update is not possible because as the PHP version is too outdated.<br />To use the counter PHP version 4.2.0 or higher must be installed (current version: %s)!',
	'error:could_not_connect_to_the_database' => '<span class="critical_error">Error:</span> Could not connect to the database.<br />Please make sure that all needed database settings in the file includes/config.inc.php are specified and correct!',	
	'please_choose_install_language' => 'Please choose a language:',
	'continue' => 'continue',
	'higher_chcounter_version_available' => '<b>Hint:</b> A higher chCounter version is available!&nbsp;&nbsp;-&gt; <a href="http://chcounter.org/">chCounter website</a>',	
	'homepage_url' => 'Website URL',
	'description_homepage_url' => 'Please enter here the URL of the website into which the counter will be included later.<br />In case that you use a rerouting URL, don\'t enter this rerouting URL, but the real one.',
	'admin_account' => 'Administrator',
	'description_admin_account' => 'Enter here the login data for administration area.',
	'login_name:' => 'Name:',
	'password:' => 'Password:',
	'confirm_password:' => 'Password (confirmation):',
	'please_uninstall_first_the_old_installation' => 'Please uninstall first the existent counter installation!',
	'back' => 'back',
	'the_following_error_occurred:' => 'The following error occurred:',
	'the_following_errors_occurred' => 'The following errors occurred:',
	'fill_out_all_fields' => 'Please fill out all fields.',
	'db_connection_available' => 'Database connection available.',
	'error_could_not_create_tables' => 'An error occurred while creating the database tables!',
	'error_could_not_insert_data' => 'An error occurred while inserting data!',
	'db_error_messages:' => 'The database error messages:',
	'tables_successfully_created' => 'Database tables created.',
	'data_successfully_inserted' => 'Data inserted.',
	'installation_finished' => '<span class="success">The counter was installed successfully!</span><br />Now you can login to the <a href="../administration">administration area</a>.',
	'remove_install_directory' => '<b>Important:</b><br />Please delete the "install" directory <i>immediately</i> to avoid possible security violations.',
	'the_passwords_do_not_match' => 'The passwords no not match.',


	// uninstall.php
	'uninstallation' => 'Deinstallation',
	'database_tables_successfully_deleted' => 'The database tables were successfully deleted.',
	'could_not_delete_database_tables' => 'The database tables could not be deleted.',
	'uninstall_information' => 'This script irrevocably deletes all database tables of the counter. The counter files must be removed manually (via FTP).',
	'uninstall_now' => 'uninstall the counter now',


	// update.php
	// this file will be available in any higher version than 3.0.0
	'title_of_update_script' => 'chCounter: Update from 3.x.x to version %s',
	'update_welcome_message' => 'Welcome to the chCounter update to version %s!<br />This script will adapt the database tables.',
	'message_update_from_versions_lower_than_3.0.0' => '<b>Attention</b>:<br />You have to update first your chCounter installation to version 3.0.0, before you can perform the update to %s.',
	'backup_message' => '<b>Important:</b><br />Please backup first the old database tables (e.g. with <a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a>) to be able to restore the tables in case of an error.',
	'error(s)_occurred' => 'One or more errors occurred!',
	'update_finished' => 'The update to version %s finished successfully!',



	// update_230_to_300.php
	'upgrade_welcome_message' => 'Welcome to the chCounter upgrade to version %s!<br />This script will adapt the database tables.',
	'upgrade_from_230_to_300' => 'chCounter: Upgrade from version 2.3.0 to 3.0.0',
	'error:could_not_find_db_tables' => '<span class="critical_error">Error:</span> Could not find any/all old database tables. Please check whether the file old_config.inc.php is really the renamed config file of the 2.3.0 installation.',
	'error:old_config_file_not_available' => '<span class="critical_error">Error:</span> Could not find the old configuration file of version 2.3.0 - please make sure that you followed all install instructions correctly.',
	'error:update_first_to_230' => '<span class="critical_error">Error:</span> You have to update first to version 2.3.0. Please check the file docs/update_en.txt for details.',
	'message_old_config_file_needed' => 'The upgrade requires the old, filled out file config.inc.php (of version 2.3.0). Please rename this file to "old_config.inc.php" and upload it to to "install" directory of the counter.',
	'upgrade_finished' => 'The upgrade to version %s finished successfully!',
	'create_temporary_backup_tables' => 'Create temporary backup tables.',
	'description_backup_tables' => 'In case of an error the old database tables will be recovered; otherwise they will be deleted automatically after finishing this upgrade.',
	'could_not_create_backup' => 'Could not create the backup of the database tables!'

) );
?>