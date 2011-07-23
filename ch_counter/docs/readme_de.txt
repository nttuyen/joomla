Inhalt:
	1. Templates
	2. Seitentitel
	3. Download- und Linkcounter
	4. Verbesserung der Ausführungsgeschwindigkeit des chCounters




1. Templates
=========
Über die Templates ( = Layoutvorlagen) wird das Layout der counter.php
und sämtlicher Statistikseiten festgelegt. Die im Ordner "templates"
gespeicherten Dateien sind reine Textdateien mit HTML, welche vom
Counter eingelesen, mit den dynamischen Inhalten gefüllt und dann
ausgegeben werden.
Die Templates können beliebig abgeändert und der Counter somit dem
eigenen Homepagelayout angepasst werden. Die Platzhalter (von
geschweiften Klammern {} umschlossen) und im Template vorhandene
Kontrollstrukturen können so auch problemlos aus den Templates
entfernt werden.
Wichtig: Werden im Template Zeichen benutzt, welche keine echten ASCII-
Zeichen sind (siehe http://de.wikipedia.org/wiki/ASCII), muss die
jeweilige Datei im UTF-8-Zeichensatz gespeichert werden.



2. Seitentitel
===========
Der Counter versucht den Seitentitel der jeweiligen Seite, in welcher
er aufgerufen wird, zu ermitteln (vorausgesetzt, diese Eigenschaft
wurde nicht z.B. aus Geschwindigkeitsgründen deaktiviert). Der Titel
kann über PHP zugewiesen werden (siehe install_de.txt) oder aber dem
HTML-Quelltext entnommen werden. Dieser Titel wird dann in der
Statistik an Stelle des Dateipfades angezeigt.

ACHTUNG: es kann nur diejenige Datei nach einem Titel durchsucht werden,
welche gerade aufrufen wurde - ist der Seitentitel jedoch z.B. in einer
anderen Datei ausgelagert, kann kein Titel ermittelt werden.

Ist ein Titel über PHP vergeben (empfohlen!), wird nicht weiter
gesucht. Ist auf diese Weise kein Titel zugewiesen, wird zunächst nach
folgendem Konstrukt gesucht:

<!-- BEGIN CHCOUNTER_PAGE_TITLE -->Dies ist der Titel...<!-- END 
CHCOUNTER_PAGE_TITLE -->

Wird es nicht gefunden, wird versucht, den regulären Titel
(<title>...</title>) zu benutzen.





3. Download- und Linkcounter
====================
Seit Version 3.1.0 verfügt der chCounter auch über eine einfache
Download- und Linkzählfunktion. Standardmäßig ist diese jedoch
deaktiviert und ausgeblendet. Um sie freizuschalten, muss in der Datei
includes/common.inc.php folgende Zeile:

define( 'CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', FALSE );

geändert werden zu:

define( 'CHC_DOWNLOAD_AND_LINK_COUNTER_ACTIVATED', TRUE );

(Datei speichern und auf Server laden.)
Nun können in der Administration in den neuen Rubriken "Downloads"
und "Hyperlinks" Downloads und Links hinzugefügt werden, zudem erscheint
noch eine neue Rubrik in den Statistiken.
Achtung: Auch bei den Downloads ist eine vollständige, absolute URL zur
Datei anzugeben! Der Counter kann keine Dateien auf den Server laden.


Zählen der Downloads und Klicks
----------------------------------------
Damit ein Download gezählt werden kann, muss auf die Datei getfile.php
aus dem Counterverzeichnis statt auf die tatsächliche Download-Datei
verwiesen werden:

counter/getfile.php?id=x

Dabei muss bei »id« die ID angegeben werden, welche in der Administration
vor dem Eintrag angezeigt wird.

Bei Hyperlinks verhält es sich ähnlich, nur muss auf die Datei refer.php
verwiesen werden:

counter/refer.php?id=y

Gleich ob Download oder Link wird der Aufruf gezählt und danach mit einem
301-HTTP-Statuscode auf die Download-Datei oder das Linkziel weitergeleitet.



Anzeigen von Daten wie Anzahl bisheriger Downloads, Name, URL
bestimmter Downloads/Links außerhalb der Counterstatistik
 (PHP-Kenntnisse benötigt)
----------------------------------------------------------------------------------
Mit der Datei counter/get_dl_or_link_details.php und der Klasse aus
counter/includes/dl_or_link_details.class.php können solche Daten
gesondert ausgegeben werden. Allerdings liegt dazu keine Dokumentation
vor, mit grundlegenden PHP-Kenntnissen sollte man aber nach Betrachten
des Codes in der Lage sein, diese Klasse zu benutzen.





4. Verbesserung der Ausführungsgeschwindigkeit des chCounters
===========================================
Sollte es zu Geschwindigkeitsproblemen bei eingebundenem chCounter
kommen, können folgende Punkte helfen:

- Deaktivieren überflüssiger Statistiken
Durch das Deaktivieren einzelner, ungenutzer Statistiken kann die Anzahl
der nötigen Datenbank-Anfragen teils deutlich gesenkt werden.

- Seitentitel nicht automatisch auslesen lassen
Die automatische Suche nach dem Seitentitel (siehe docs/readme_de.txt,
Punkt 2) kann erhebliche Geschwindigkeitsprobleme verursachen.
In der Administration kann diese Feature deaktiviert werden, stattdessen
sollte die Variable $chCounter_page_title verwendet werden (siehe
docs/install_de.txt, 3.2.3).

- Seitenaufrufe der aktuellen Seite
Wenn der Wert {V_MAX_VISITORS_ONLINE_DATE} in der Template-Datei
templates/counter.tpl.html auskommentiert oder gelöscht wurde, also
nicht genutzt wird, kann dem Script über eine Variable mitgeteilt werden,
diesen Wert von vornerein nicht aus der Datenbank auszulesen. Damit wird
eine in dem Fall sonst überflüssige Datenbank-Abfrage nicht durchgeführt.

<?php
$chCounter_show_page_views_of_the_current_page = FALSE;
include( 'counter.php' );
?>


- vorhandene Datenbankverbindung übernehmen/ neue Verbindung erzwingen
Siehe docs/install_de.txt: 3.2.5: vorhandene Datenbankverbindung übernehmen /
neue Verbindung erzwingen