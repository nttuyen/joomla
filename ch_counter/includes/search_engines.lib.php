<?php

/*
 **************************************
 *
 * includes/search_engines.lib.php
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


$chC_search_engines = array(
	'Abacho' => array(
		'name'		=> 'Abacho',
		'needle'	=> 'abacho.com',
		'query_var'	=> 'q',
		'icon'		=> 'abacho.png'
	),
	'Alexa' => array(
		'name'		=> 'Alexa',
		'needle'	=> 'alexa',
		'query_var'	=> 'q',
		'icon'		=> 'alexa.png'
	),
	'AllTheWeb' => array(
		'name'		=> 'AllTheWeb',
		'needle'	=> 'alltheweb.com',
		'query_var'	=> 'q',
		'icon'		=> 'alltheweb.png'
	),
	'Altavista' => array(
		'name'		=> 'Altavista',
		'needle'	=> 'altavista',
		'query_var'	=> 'q',
		'icon'		=> 'altavista.png'
	),
	'AOL (DE)' => array(
		'name'		=> 'AOL',
		'needle'	=> 'suche.aol',
		'query_var'	=> 'q',
		'icon'		=> 'aol.png'
	),
	'AOL (DE Nr2)' => array(
		'name'		=> 'AOL',
		'needle'	=> 'sucheaol.aol',
		'query_var'	=> 'q',
		'icon'		=> 'aol.png'
	),
	'AOL' => array(
		'name'		=> 'AOL',
		'needle'	=> 'search.aol',
		'query_var'	=> 'query',
		'icon'		=> 'aol.png'
	),
	'Ask Jeeves' => array(
		'name'		=> 'Ask Jeeves',
		'needle'	=> 'ask.com',
		'query_var'	=> 'q',
		'icon'		=> 'askjeeves.png'
	),
	'AT:Search' => array(
		'name'		=> 'AT:Search',
		'needle'	=> 'atsearch.at',
		'query_var'	=> 'qs',
		'icon'		=> 'search_engine.png'
	),
	'Baidu' => array(
		'name'		=> 'Baidu',
		'needle'	=> 'baidu.com',
		'query_var'	=> 'word',
		'icon'		=> 'baidu.png'
	),
	'Bluewin' => array(
		'name'		=> 'Bluewin',
		'needle'	=> 'search.bluewin.ch',
		'query_var'	=> 'qry',
		'icon'		=> 'search_engine.png'
	),
	'dir.com' => array(
		'name'		=> 'dir.com',
		'needle'	=> 'dir.com',
		'query_var'	=> 'req',
		'icon'		=> 'search_engine.png'
	),
	'DMOZ' => array(
		'name'		=> 'DMOZ',
		'needle'	=> 'dmoz.org',
		'query_var'	=> 'search',
		'icon'		=> 'dmoz.png'
	),
	'Exalead' => array(
		'name'		=> 'Exalead',
		'needle'	=> 'exalead',
		'query_var'	=> 'q',
		'icon'		=> 'exalead.png'
	),
	'Fireball' => array(
		'name'		=> 'Fireball',
		'needle'	=> 'fireball.de',
		'query_var'	=> 'query',
		'icon'		=> 'fireball.png'
	),
	'Freenet' => array(
		'name'		=> 'suche.freenet.de',
		'needle'	=> 'freenet',
		'query_var'	=> 'query',
		'icon'		=> 'freenet.png'
	),
	'Gigablast' => array(
		'name'		=> 'Gigablast',
		'needle'	=> 'gigablast.com',
		'query_var'	=> 'q',
		'icon'		=> 'gigablast.png'
	),
	'Google Images' => array(
		'name'		=> 'Google Images',
		'needle'	=> 'images.google',
		'query_var'	=> 'q',
		'icon'		=> 'google.png'
	),
	'Google Cache' => array(
		'name'		=> 'Google Cache',
		'needle'	=> '216.239.',
		'query_var'	=> 'q',
		'icon'		=> 'google.png'
	),
	'Google Cache' => array(
		'name'		=> 'Google Cache',
		'needle'	=> '209.85.',
		'query_var'	=> 'q',
		'icon'		=> 'google.png'
	),
	'Google Cache' => array(
		'name'		=> 'Google Cache',
		'needle'	=> '72.14.',
		'query_var'	=> 'q',
		'icon'		=> 'google.png'
	),
	'Google Cache' => array(
		'name'		=> 'Google Cache',
		'needle'	=> '66.102.',
		'query_var'	=> 'q',
		'icon'		=> 'google.png'
	),
	'Google Cache' => array(
		'name'		=> 'Google Cache',
		'needle'	=> '64.233.',
		'query_var'	=> 'q',
		'icon'		=> 'google.png'
	),
	'Google' => array(
		'name'		=> 'Google',
		'needle'	=> 'google',
		'query_var'	=> 'q',
		'icon'		=> 'google.png'
	),
	'HotBot' => array(
		'name'		=> 'HotBot',
		'needle'	=> 'hotbot.com',
		'query_var'	=> 'query',
		'icon'		=> 'hotbot.png'
	),
	'IlTrovatore' => array(
		'name'		=> 'IlTrovatore',
		'needle'	=> 'iltrovatore.it',
		'query_var'	=> 'q',
		'icon'		=> 'search_engine.png'
	),
	'Kvasir' => array(
		'name'		=> 'Kvasir',
		'needle'	=> 'kvasir.no',
		'query_var'	=> 'q',
		'icon'		=> 'search_engine.png'
	),
	'Live Search' => array(
		'name'		=> 'Live Search',
		'needle'	=> 'search.live.com',
		'query_var'	=> 'q',
		'icon'		=> 'livesearch.png'
	),
	'LookSmart' => array(
		'name'		=> 'LookSmart',
		'needle'	=> 'search.looksmart.com',
		'query_var'	=> 'qt',
		'icon'		=> 'looksmart.png'
	),
	'Lycos' => array(
		'name'		=> 'Lycos',
		'needle'	=> 'lycos',
		'query_var'	=> 'query',
		'icon'		=> 'lycos.png'
	),
	'Mirago' => array(
		'name'		=> 'Mirago',
		'needle'	=> 'mirago',
		'query_var'	=> 'qry',
		'icon'		=> 'mirago.png'
	),
	'MSN' => array(
		'name'		=> 'MSN',
		'needle'	=> 'msn',
		'query_var'	=> 'q',
		'icon'		=> 'msn.png'
	),
	'My Web Search' => array(
		'name'		=> 'My Web Search',
		'needle'	=> 'mywebsearch.com',
		'query_var'	=> 'searchfor',
		'icon'		=> 'search_engine.png'
	),
	'Naver' => array(
		'name'		=> 'Naver',
		'needle'	=> 'search.naver.com',
		'query_var'	=> 'query',
		'icon'		=> 'naver.png'
	),
	'Neomo' => array(
		'name'		=> 'Neomo',
		'needle'	=> 'search.neomo',
		'query_var'	=> 'q',
		'icon'		=> 'neomo.png'
	),
	'Netscape (DE)' => array(
		'name'		=> 'Netscape',
		'needle'	=> 'search.netscape.de',
		'query_var'	=> 'q',
		'icon'		=> 'netscape.png'
	),
	'Netscape' => array(
		'name'		=> 'Netscape',
		'needle'	=> 'search.netscape.com',
		'query_var'	=> 'query',
		'icon'		=> 'netscape.png'
	),
	'Overture' => array(
		'name'		=> 'Overture',
		'needle'	=> 'overture.com',
		'query_var'	=> 'Keywords',
		'icon'		=> 'overture.png'
	),
	'Quepasa' => array(
		'name'		=> 'Quepasa',
		'needle'	=> 'quepasa.com',
		'query_var'	=> 'q',
		'icon'		=> 'quepasa.png'
	),
	'search.ch' => array(
		'name'		=> 'search.ch',
		'needle'	=> 'search.ch',
		'query_var'	=> 'q',
		'icon'		=> 'search.ch.png'
	),
	'Search.com' => array(
		'name'		=> 'Search.com',
		'needle'	=> 'search.com',
		'query_var'	=> 'q',
		'icon'		=> 'search.com.png'
	),
	'Seekport' => array(
		'name'		=> 'Seekport',
		'needle'	=> 'seekport',
		'query_var'	=> 'query',
		'icon'		=> 'seekport.png'
	),
	'T-Online' => array(
		'name'		=> 'T-Online',
		'needle'	=> 'brisbane.t-online.de',
		'query_var'	=> 'q',
		'icon'		=> 't-online.png'
	),
	'T-Online' => array(
		'name'		=> 'T-Online',
		'needle'	=> 'suche.t-online.de',
		'query_var'	=> 'q',
		'icon'		=> 't-online.png'
	),
	'Teoma' => array(
		'name'		=> 'Teoma',
		'needle'	=> 'teoma.com',
		'query_var'	=> 'q',
		'icon'		=> 'teoma.png'
	),
	'Yahoo!' => array(
		'name'		=> 'Yahoo!',
		'needle'	=> 'yahoo',
		'query_var'	=> 'p',
		'icon'		=> 'yahoo.png'
	),
	'Vienna Online: Finder' => array(
		'name'		=> 'Vienna Online: Finder',
		'needle'	=> 'finder.vienna.at',
		'query_var'	=> 'query',
		'icon'		=> 'search_engine.png'
	),
	'Walhello' => array(
		'name'		=> 'Walhello',
		'needle'	=> 'walhello',
		'query_var'	=> 'key',
		'icon'		=> 'search_engine.png'
	),
	'Web.de' => array(
		'name'		=> 'Web.de',
		'needle'	=> 'suche.web.de',
		'query_var'	=> 'su',
		'icon'		=> 'web.de.png'
	),
	'Wikipedia' => array(
		'name'		=> 'Wikipedia',
		'needle'	=> 'wikipedia.org',
		'query_var'	=> 'search',
		'icon'		=> 'wikipedia.png'
	),
	'WiseNut' => array(
		'name'		=> 'WiseNut',
		'needle'	=> 'wisenut',
		'query_var'	=> 'q',
		'icon'		=> 'wisenut.png'
	)
);

?>