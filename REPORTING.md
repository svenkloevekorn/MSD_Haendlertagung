# BEQN Guest – Funktionsübersicht (Stand 25.03.2026)

## Login & Zugangskontrolle
- 6-stelliger PIN-Code pro Händler (Buchstaben + Zahlen)
- Groß-/Kleinschreibung egal
- Session läuft nach 72 Stunden automatisch ab
- Mehrere Geräte gleichzeitig möglich
- Alle Seiten ohne Login gesperrt

## Admin-Panel (`/admin`)
- **Händlerverwaltung** – Anlegen, Bearbeiten, Löschen von Händlern (Vorname, Nachname, E-Mail, PIN)
- **Excel Import/Export** – Händlerliste importieren (CSV/Excel) und exportieren. Bei bestehendem E-Mail-Eintrag wird aktualisiert statt doppelt angelegt
- **Download-Verwaltung** – Dateien hochladen (PDF, Excel, PowerPoint, ZIP, Bilder bis 50 MB), Name und Beschreibung vergeben, Status Entwurf/Live, Reihenfolge per Drag & Drop
- **Galerie-Verwaltung** – Bilder hochladen (JPG, PNG, WebP bis 10 MB), Titel und Beschreibung, Status Entwurf/Live, Reihenfolge per Drag & Drop
- **PIN Auto-Generierung** – Beim Anlegen neuer Händler wird automatisch ein einzigartiger PIN vorgeschlagen

## Frontend (7 Seiten)
- **Login** – PIN-Eingabe mit animiertem Hintergrund, Auto-Submit nach 6 Zeichen
- **Startseite** – Hero, Event-Überblick, Hotel, Dresscode, Quick-Links
- **Agenda** – Tages-Tabs (Mo–Do + Partnerprogramm), Timeline
- **Anmeldeformular** – Platzhalter (Felder noch zu finalisieren)
- **Galerie** – Responsive Bilder-Grid mit Lightbox (Pfeiltasten-Navigation)
- **Downloads** – Liste mit Datei-Icons nach Typ (PDF rot, Excel grün, PPT orange etc.), Dateigröße, Download-Button
- **Feedback** – Feedback-Formular (Platzhalter)
- **Kontakt** – Ansprechpartner + Kontaktformular (Platzhalter)
- **Logout** – Button in der Navigation auf jeder Seite

## Sicherheit
- Alle Dateien (Downloads + Galerie-Bilder) im privaten Speicher – kein direkter URL-Zugriff möglich
- Entwurf-Dateien auch für eingeloggte User unsichtbar
- Admin-Panel separater Login mit E-Mail/Passwort

## Deployment
- Automatisches Deployment bei Push auf `main` (GitHub Actions)
- Tests laufen vor jedem Deploy (25 Tests)
- Staging: `haendlertagung-staging.beqn.io`
