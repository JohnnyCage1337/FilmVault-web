# FilmVault-web 🎬

Aplikacja webowa do zarządzania bazą filmów z funkcjonalnością watchlisty.

## 📋 Opis

FilmVault to serwis internetowy umożliwiający użytkownikom:

- Przeglądanie bazy filmów
- Wyszukiwanie filmów po tytule
- Zarządzanie osobistą watchlistą
- Dodawanie nowych filmów i osób z branży filmowej (dla administratorów)

## 🛠 Technologie

- **Backend**: PHP
- **Frontend**: HTML, CSS, JavaScript
- **Serwer**: Nginx
- **Baza danych**: PostgreSQL
- **Konteneryzacja**: Docker

## 🚀 Instalacja i uruchomienie

### Wymagania

- Docker
- Docker Compose

### Kroki instalacji

1. **Sklonuj repozytorium**

   ```bash
   git clone https://github.com/JohnnyCage1337/FilmVault-web.git
   cd FilmVault-web
   ```

2. **Uruchom aplikację z Docker Compose**

   ```bash
   docker-compose up -d
   ```

   To polecenie automatycznie:

   - Uruchomi kontener PostgreSQL z bazą danych
   - Zainicjalizuje bazę danych ze strukturą tabel
   - Załaduje przykładowe dane (filmy, aktorzy, użytkownicy)
   - Uruchomi serwer Nginx z aplikacją PHP

3. **Otwórz w przeglądarce**

   Aplikacja będzie dostępna pod adresem: `http://localhost:8080`

## 👤 Logowanie

### Konto administratora (przykładowe)

- **Email**: admin@admin.me
- **Hasło**: admin

### Konto przykładowego użytkownika

- **Email**: user@example.me
- **Hasło**: password

## 📁 Struktura projektu

```
├── src/                    # Kod źródłowy aplikacji
│   ├── controllers/        # Kontrolery MVC
│   ├── models/            # Modele danych
│   └── repository/        # Repozytoria dostępu do danych
├── public/                # Pliki publiczne
│   ├── css/              # Style CSS
│   ├── js/               # Skrypty JavaScript
│   ├── img/              # Obrazy
│   ├── uploads/          # Przesłane pliki
│   └── views/            # Widoki HTML/PHP
├── docker/               # Konfiguracja Docker
└── doc/                  # Dokumentacja
```

## ✨ Funkcjonalności

- ✅ Rejestracja i logowanie użytkowników
- ✅ Wyszukiwanie filmów
- ✅ Wyświetlanie szczegółów filmu z pełną obsadą
- ✅ Wyświetlanie nazw postaci granej przez aktorów
- ✅ Zdjęcia aktorów i ekipy filmowej
- ✅ Dodawanie filmów do watchlisty
- ✅ Przeglądanie osobistej watchlisty
- ✅ Zarządzanie bazą filmów (admin)
- ✅ Dodawanie osób z branży filmowej (admin)
- ✅ System ról (aktor, reżyser, scenarzysta)
- ✅ Automatyczna inicjalizacja bazy danych z przykładowymi danymi
- ⏳ Usuwanie filmów z watchlisty
- ⏳ Modyfikowanie i usuwanie filmów/osób
- ⏳ System oceniania filmów

## 📝 Uwagi

- Aplikacja używa Docker Compose do łatwej instalacji i uruchomienia
- Baza danych PostgreSQL jest automatycznie inicjalizowana z przykładowymi danymi
- Przed dodaniem nowego filmu należy najpierw dodać do bazy aktorów, scenarzystów i reżyserów
- Aplikacja używa sesji do zarządzania uwierzytelnianiem użytkowników
- Wszystkie hasła w przykładowych danych są zahashowane przy użyciu `password_hash()`

## 🤝 Kontrybuowanie

1. Fork projektu
2. Stwórz branch dla swojej funkcjonalności (`git checkout -b feature/AmazingFeature`)
3. Zatwierdź zmiany (`git commit -m 'Add some AmazingFeature'`)
4. Wypchnij do branch (`git push origin feature/AmazingFeature`)
5. Otwórz Pull Request

## 📄 Licencja

Ten projekt jest udostępniony na licencji MIT.
