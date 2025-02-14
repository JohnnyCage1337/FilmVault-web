# Temat Projektu : Strona internetowa z bazą filmów
## Spis treści
- [Temat Projektu : Strona internetowa z bazą filmów](#temat-projektu--strona-internetowa-z-bazą-filmów)
  - [Spis treści](#spis-treści)
  - [Informacje ogólne](#informacje-ogólne)
  - [Użyte technologie:](#użyte-technologie)
  - [Wymagania funkcjonalne:](#wymagania-funkcjonalne)
  - [Wymagania opcjonalne:](#wymagania-opcjonalne)
  - [Przykłady użycia](#przykłady-użycia)
  - [Status projektu](#status-projektu)
  
## Informacje ogólne
Serwis zawierający informacje o filmach. Pozwala użytkownikom na wyszukiwanie interesujacych filmów oraz dodanie ich do watchlisty
## Użyte technologie: 
1. HTML/CSS
2. PHP/nginx
3. JS
4. postgresql
## Wymagania funkcjonalne:

1. utworzenie konta osobistego : System pozwala na podanie przez użytkownika danych, jak nickname, email, haslo
2. logowanie/wylogowywanie: System pozwala na logowanie za pomocą emailu i hasła(zwykly uzytkownik lub admin)
3. wyszukiwanie filmów  : System pozwala na wyszukiwanie filmów po tytułach
4. zarządzanie watchlistą: dodawnie, wyswietlanie
5. wyswietlanie szczegółów danego filmu
6. zarzadzanie baza branży filmowej: dodawanie osób działających w branży filmowej
7. zarządzanie bazą filmów: dodawanie filmów, obsady
8. Utrzymywanie sesji uzytkownika/walidacja roli

## Proces Uruchamiania:
1. Umiescic w katalogu glownym projektu plik config.php z danymi potrzebnymi do polaczenia ze zdalna baza danych
2. Uruchomić docker-compose.yaml
3. Utworzyc konto lub zalogowac sie na konto admina: mail: admin@admin.me haslo: admin

## Niedokonczone:
1. Usuwanie filmów z watchlisty
2. modyfikowanie osób/filmów oraz usuwanie
3. dodawanie ocen