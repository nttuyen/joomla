Inhalt:
	1. Templates
	2. Seitentitel
	3. Download- und Linkcounter
	4. Verbesserung der Ausf�hrungsgeschwindigkeit des chCounters




1. Templates
=========
�ber die Templates ( = Layoutvorlagen) wird das Layout der counter.php
und s�mtlicher Statistikseiten festgelegt. Die im Ordner "templates"
gespeicherten Dateien sind reine Textdateien mit HTML, welche vom
Counter eingelesen, mit den dynamischen Inhalten gef�llt und dann
ausgegeben werden.
Die Templates k�nnen beliebig abge�ndert und der Counter somit dem
eigenen Homepagelayout angepasst werden. Die Platzhalter (von
geschweiften Klammern {} umschlossen) und im Template vorhandene
Kontrollstrukturen k�nnen so auch problemlos aus den Templates
entfernt werden.
Wichtig: Werden im Template Zeichen benutzt, welche keine echten ASCII-
Zeichen sind (siehe http://de.wikipedia.org/wiki/ASCII), muss die
jeweilige Datei im UTF-8-Zeichensatz gespeichert werden.



2. Seitentitel
===========
Der Counter versucht den Seitentitel der jeweiligen Seite, in welcher
er aufgerufen wird, zu ermitteln (vorausgesetzt, diese Eigenschaft
wurde nicht z.B. aus Geschwindigkeitsgr�nden deaktiviert). Der Titel
kann �ber PHP zugewiesen werden (siehe install_de.txt) oder aber dem
HTML-Quelltext entnommen werden. Dieser Titel wird dann in der
Statistik an Stelle des Dateipfades angezeigt.

ACHTUNG: es kann nur diejenige Datei nach einem Titel durchsucht werden,
welche gerade aufrufen wurde - ist der Seitentitel jedoch z.B. in einer
anderen Datei ausgelagert, kann kein Titel ermittelt werden.

Ist ein Titel �ber PHP vergeben (empfohlen!), wird nicht weiter
gesucht. Ist auf diese Weise kein Titel zugewiesen, wird zun�chst nach
folgendem Konstrukt gesucht:

<!-- BEGIN CHCOUNTER_PAGE_TITLE -->Dies ist der Titel...<!-- END 
CHCOUNTER_PAGE_TITLE -->

Wird es nicht gefunden, wird versucht, den regul�ren Titel
(<title>...</title>) zu benutzen.





3. Download- und Linkcounter
====================
Seit Version 3.1.0 verf�gt der chCounter auch �ber eine einfache
Download- und Linkz�hlfunktion. Standardm��ig ist diese jedoch
deaktiviert und ausgeblendet. Um sie freizuschalten, muss in der Datei
includes/common.inc.php folgende Zeile:

define( 'CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', FALSE );

ge�ndert werden zu:

define( 'CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', TRUE );

(Datei speichern und auf Server laden.)
Nun k�nnen in der Administration in den neuen Rubriken "Downloads"
und "Hyperlinks" Downloads und Links hinzugef�gt werden, zudem erscheint
noch eine neue Rubrik in den Statistiken.
Achtung: Auch bei den Downloads ist eine vollst�ndige, absolute URL zur
Datei anzugeben! Der Counter kann keine Dateien auf den Server laden.


Z�hlen der Downloads und Klicks
----------------------------------------
Damit ein Download gez�hlt werden kann, muss auf die Datei getfile.php
aus dem Counterverzeichnis statt auf die tats�chliche Download-Datei
verwiesen werden:

counter/getfile.php?id=x

Dabei muss bei �id� die ID angegeben werden, welche in der Administration
vor dem Eintrag angezeigt wird.

Bei Hyperlinks verh�lt es sich �hnlich, nur muss auf die Datei refer.php
verwiesen werden:

counter/refer.php?id=y

Gleich ob Download oder Link wird der Aufruf gez�hlt und danach mit einem
301-HTTP-Statuscode auf die Download-Datei oder das Linkziel weitergeleitet.



Anzeigen von Daten wie Anzahl bisheriger Downloads, Name, URL
bestimmter Downloads/Links au�erhalb der Counterstatistik
 (PHP-Kenntnisse ben�tigt)
----------------------------------------------------------------------------------
Mit der Datei counter/get_dl_or_link_details.php und der Klasse aus
counter/includes/dl_or_link_details.class.php k�nnen solche Daten
gesondert ausgegeben werden. Allerdings liegt dazu keine Dokumentation
vor, mit grundlegenden PHP-Kenntnissen sollte man aber nach Betrachten
des Codes in der Lage sein, diese Klasse zu benutzen.





4. Verbesserung der Ausf�hrungsgeschwindigkeit des chCounters
===========================================
Sollte es zu Geschwindigkeitsproblemen bei eingebundenem chCounter
kommen, k�nnen folgende Punkte helfen:

- Deaktivieren �berfl�ssiger Statistiken
Durch das Deaktivieren einzelner, ungenutzer Statistiken kann die Anzahl
der n�tigen Datenbank-Anfragen teils deutlich gesenkt werden.

- Seitentitel nicht automatisch auslesen lassen
Die automatische Suche nach dem Seitentitel (siehe docs/readme_de.txt,
Punkt 2) kann erhebliche Geschwindigkeitsprobleme verursachen.
In der Administration kann diese Feature deaktiviert werden, stattdessen
sollte die Variable $chCounter_page_title verwendet werden (siehe
docs/install_de.txt, 3.2.3).

- Seitenaufrufe der aktuellen Seite
Wenn der Wert {V_MAX_VISITORS_ONLINE_DATE} in der Template-Datei
templates/counter.tpl.html auskommentiert oder gel�scht wurde, also
nicht genutzt wird, kann dem Script �ber eine Variable mitgeteilt werden,
diesen Wert von vornerein nicht aus der Datenbank auszulesen. Damit wird
eine in dem Fall sonst �berfl�ssige Datenbank-Abfrage nicht durchgef�hrt.

<?php
$chCounter_show_page_views_of_the_current_page = FALSE;
include( 'counter.php' );
?>


- vorhandene Datenbankverbindung �bernehmen/ neue Verbindung erzwingen
Siehe docs/install_de.txt: 3.2.5: vorhandene Datenbankverbindung �bernehmen /
neue Verbindung erzwingen