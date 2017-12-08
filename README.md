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
 
Das Projekt wird kontinuierlich weiterentwickelt. (Aktuell Phase 3 - Command Line Interface)

### Verwendung:

Symfony Konsolen Befehle:
````
php cli/pizzatool.php [command]
````
Befehle:
````
create:ingredient       --> Erstellt eine neue Zutat.
create:pizza            --> Erstellt eine neue Pizza mit Zutaten.
create:customer         --> Erstellt einen neuen Kunden.
create:order            --> Erstellt eine neue Bestellung.
list:ingrediet          --> Listet alle Zutaten auf.
list:pizza              --> Listet alle Pizzen mit deren Zutaten auf.
````

### Authors
Azubi Projekt von Tim Schreindl