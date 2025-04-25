# Spiel-Votes API

Eine REST-API zur Verwaltung von Votes für Spiele.

## Installation

1. Composer-Abhängigkeiten installieren:
   ```
   composer install
   ```

2. Datenbank erstellen (falls nicht vorhanden):
   ```
   mkdir -p var/database
   touch var/database/votes.sqlite
   ```

3. Datenbank-Schema erstellen:
   ```
   php bin/console doctrine:schema:create
   ```

## API-Endpunkte

### /api/vote/{gameId}
- **GET**: Aktuellen Vote-Stand für ein Spiel abrufen
- **POST**: Vote für ein Spiel erhöhen
- **DELETE**: Vote für ein Spiel auf Null zurücksetzen

### /api/votes
- **GET**: Liste aller Spiele mit aktuellem Vote-Stand abrufen

### /api/votes/reset
- **POST**: Alle Votes auf Null zurücksetzen
