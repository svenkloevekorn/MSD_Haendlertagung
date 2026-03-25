# MSD Haendlertagung 2026 - Projektdokumentation

## Uebersicht

Event-Landingpage fuer die Muehlen Sohn Haendlertagung 2026. Laravel 12 mit Filament 3 Admin-Panel und PIN-basiertem Zugangschutz.

## Tech-Stack

- **Framework:** Laravel 12
- **PHP:** 8.4 (Laravel Herd)
- **Datenbank:** PostgreSQL (lokal), SQLite (Tests)
- **Admin-Panel:** Filament 3
- **Frontend:** Tailwind CSS (via CDN), Blade Templates
- **Deployment:** GitHub Actions via SCP zu Mittwald

## Lokale Entwicklung

```bash
# Datenbank einrichten (PostgreSQL muss laufen)
php artisan migrate:fresh --seed

# Seite aufrufen
http://msd_haendlertagung.test

# Admin-Panel
http://msd_haendlertagung.test/admin

# Tests ausfuehren
php artisan test
```

## Zugaenge (Entwicklung)

### Admin-Panel
- URL: `/admin`
- E-Mail: `admin@admin.de`
- Passwort: `password`

### Test-Haendler (nach Seeding)
- Max Mustermann: PIN `123456`
- Erika Musterfrau: PIN `654321`
- 5 weitere zufaellige Haendler (PINs in DB)

## Architektur

### PIN-Authentifizierung

1. Haendler oeffnet `/` -> Login-Seite mit 6-stelliger PIN-Eingabe
2. PIN wird gegen `dealers`-Tabelle geprueft (bcrypt-gehasht)
3. Korrekt -> Session wird gesetzt (`dealer_id`, `dealer_logged_in_at`)
4. Session laeuft nach **72 Stunden** automatisch ab
5. Mehrere Geraete gleichzeitig erlaubt

### Middleware `CheckPin`

- Registriert als `pin` Alias in `bootstrap/app.php`
- Prueft `dealer_id` in Session
- Prueft Session-Alter (max 72h)
- Schuetzt alle Seiten ausser `/`, `/login`, `/logout` und `/admin`

### Wichtige Dateien

| Datei | Beschreibung |
|-------|-------------|
| `app/Models/Dealer.php` | Haendler-Model (PIN Klartext, uppercase) |
| `app/Models/Download.php` | Download-Model mit Status (draft/live) |
| `app/Http/Controllers/DownloadController.php` | Download-Seite und geschuetzter Datei-Download |
| `app/Http/Controllers/PinLoginController.php` | Login/Logout Logik |
| `app/Http/Middleware/CheckPin.php` | Session-Pruefung |
| `routes/web.php` | Alle Routes |
| `resources/views/login.blade.php` | Login-Seite (Particle Animation) |
| `resources/views/*.blade.php` | Alle geschuetzten Seiten |
| `app/Filament/Resources/Dealers/` | Filament CRUD fuer Haendler |
| `app/Filament/Resources/Downloads/` | Filament CRUD fuer Downloads |
| `app/Filament/Exports/DealerExporter.php` | Haendler Excel-Export |
| `app/Filament/Imports/DealerImporter.php` | Haendler Excel-Import (Upsert via E-Mail) |
| `database/seeders/` | Test-Daten |
| `database/factories/DealerFactory.php` | Factory fuer Tests |
| `tests/Feature/PinLoginTest.php` | 13 PIN-Login-Tests |
| `tests/Feature/DownloadTest.php` | 6 Download-Tests |

### Datenbank-Schema

#### `dealers`
| Feld | Typ | Beschreibung |
|------|-----|-------------|
| id | bigint | Primary Key |
| first_name | string | Vorname |
| last_name | string | Nachname |
| email | string (unique) | E-Mail |
| pin | string (unique, Klartext, uppercase) | 6-stelliger alphanumerischer Zugangscode |
| last_login_at | timestamp (nullable) | Letzter Login |
| created_at | timestamp | Erstellt |
| updated_at | timestamp | Aktualisiert |

#### `downloads`
| Feld | Typ | Beschreibung |
|------|-----|-------------|
| id | bigint | Primary Key |
| name | string | Anzeigename |
| description | text (nullable) | Optionale Beschreibung |
| file_path | string | Pfad im private Storage |
| original_filename | string | Originaler Dateiname |
| file_size | bigint | Dateigroesse in Bytes |
| status | string | `draft` oder `live` |
| sort_order | integer | Reihenfolge |
| created_at | timestamp | Erstellt |
| updated_at | timestamp | Aktualisiert |

### Routes

| Route | Methode | Schutz | Beschreibung |
|-------|---------|--------|-------------|
| `/` | GET | Offen | Login-Seite |
| `/login` | POST | Offen | PIN pruefen |
| `/logout` | POST | Offen | Session loeschen |
| `/startseite` | GET | PIN | Startseite |
| `/agenda` | GET | PIN | Agenda |
| `/galerie` | GET | PIN | Galerie |
| `/downloads` | GET | PIN | Downloads |
| `/formular` | GET | PIN | Teilnehmerformular |
| `/feedback` | GET | PIN | Feedback |
| `/kontakt` | GET | PIN | Kontakt |
| `/downloads/{id}/file` | GET | PIN | Datei herunterladen (private Storage) |
| `/admin` | GET | Filament Auth | Admin-Panel |

## Deployment

### GitHub Actions (`/.github/workflows/deploy.yml`)

- Trigger: Push auf `main`
- Methode: SCP ueber SSH
- Ziel: Mittwald Server (p700904.webspaceconfig.de)

### Benoetigte GitHub Secrets

| Secret | Beschreibung |
|--------|-------------|
| `MITTWALD_HOST` | Server-Hostname |
| `MITTWALD_PORT` | SSH-Port (22) |
| `MITTWALD_USER` | SSH-Username |
| `MITTWALD_SSH_KEY` | Privater SSH-Key |
| `MITTWALD_DEPLOY_PATH` | Zielverzeichnis auf Server |

### Deployment-Hinweise

Das aktuelle Deploy-Script kopiert nur statische Dateien. Fuer Laravel-Deployment muss es noch angepasst werden:
- Composer install auf dem Server
- `.env` auf dem Server konfigurieren
- `php artisan migrate` nach Deploy
- `storage/` Verzeichnis mit Symlink
- `public/` als Document Root

## Tests

```
PASS  Tests\Feature\PinLoginTest
  - Login-Seite ist erreichbar
  - Gueltiger PIN leitet zu Startseite weiter
  - Ungueltiger PIN zeigt Fehler
  - Geschuetzte Routen leiten ohne Session um
  - Geschuetzte Routen sind mit Session erreichbar
  - Session laeuft nach 72h ab
  - last_login_at wird aktualisiert
  - Logout loescht Session
  - Eingeloggter User wird von Login-Seite weitergeleitet
```

## Naechste Schritte

- [ ] Deploy-Workflow fuer Laravel anpassen (composer install, migrate, etc.)
- [ ] Personalisierung auf geschuetzten Seiten ("Willkommen, [Vorname]")
- [ ] Formular-Handling (Backend/E-Mail)
- [ ] Galerie nach dem Event befuellen
- [ ] Downloads/Praesentationen bereitstellen
- [ ] Finale Inhalte einpflegen (Agenda, Speaker, Hotel-Infos)
