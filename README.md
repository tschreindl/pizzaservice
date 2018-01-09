# pizzaservice

### Allgemein:
Dieses Projekt wird ein Übungsprojekt mit Datenbanken und Propel in PHP. Ziel ist es ein Pizzalieferdienst zu realisieren.
Dazu müssen verschiedene Anforderungen erfüllt werden:

* Pizzen müssen gespeichert werden
* Pizzen bestehen aus mehreren Zutaten
* Zutaten müssen gespeichert werden können
* Bestellungen müssen gespeichert werden
* Eine Bestellung kann mehrere Pizzen enthalten
* Eine Bestellung ist einem Kunden zugeordnet
* Kunden müssen gespeichert werden können
 
Das Projekt wird kontinuierlich weiterentwickelt. (Aktuell Phase 4 - Web-Interface)

PS: Falls jemand darauf warten sollte, dass der Pizzabote gleich vor der Tür steht, muss ich ihn leider enttäuschen :)

### Verwendung:

Bei der Verwendung von Ubuntu muss ``composer dump-autoload -o`` ausgeführt werden.

##### Web-Interface:
Im Order web/ befindet sich die index.php für das Web-Interface.

Folgende Möglichkeiten bietet das Web-Interface:
* Alle Pizzen in der Datenbank einsehen
* Pizzen in die Bestellung eintragen
* Bestellungen bearbeiten
* Eingabe von Name & Adresse
* Bestellung abschließen

Nachdem die Bestellung abgeschickt wurde, wird diese in die Datenbank eingetragen.

##### Symfony Konsolen Befehle:
````
php cli/pizzatool.php [command]
````
Befehle:
````
create:ingredient                   --> Erstellt eine neue Zutat.
create:pizza                        --> Erstellt eine neue Pizza mit Zutaten.
create:customer                     --> Erstellt einen neuen Kunden.
create:order                        --> Erstellt eine neue Bestellung.
complete:order <Bestell Nr.>        --> Markiert die Bestellung als abgeschlossen. 
list:ingrediet                      --> Listet alle Zutaten auf.
list:pizza                          --> Listet alle Pizzen mit deren Zutaten auf.
list:orders [--include-completed]   --> Listet alle offenen Bestellungn auf. Optional können alle Bestellung aufgelistet werden.
````

### Authors
Azubi Projekt von Tim Schreindl