# Audioteka: zadanie rekrutacyjne

## Instalacja

Do uruchomienia wymagany jest `docker` i `docker-compose`

1. Zbuduj obrazy dockera `docker-compose build`
1. Zainstaluj zależności `docker-compose run --rm php composer install`.
1. Zainicjalizuj bazę danych `docker-compose run --rm php php bin/console doctrine:schema:create`.
1. Zainicjalizuj kolejkę Messengera `docker-compose run --rm php php bin/console messenger:setup-transports`.
1. Uruchom serwis za pomocą `docker-compose up -d`.

Jeśli wszystko poszło dobrze, serwis powinien być dostępny pod adresem 
[https://localhost](https://localhost).

Przykładowe zapytania (jak komunikować się z serwisem) znajdziesz w [requests.http](./requests.http).

Testy uruchamia polecenie `docker-compose run --rm php php bin/phpunit`

## Oryginalne wymagania dotyczące serwisu

Serwis realizuje obsługę katalogu produktów oraz koszyka. Klient serwisu powinien móc:

* dodać produkt do katalogu,
* usunąć produkt z katalogu,
* wyświetlić produkty z katalogu jako stronicowaną listę o co najwyżej 3 produktach na stronie,
* utworzyć koszyk,
* dodać produkt do koszyka, przy czym koszyk może zawierać maksymalnie 3 produkty,
* usunąć produkt z koszyka,
* wyświetlić produkty w koszyku, wraz z ich całkowitą wartością.

Kod, który masz przed sobą, stara się implementować te wymagania z pomocą `Symfony 6.0`.

## Zadanie

Użytkownicy i testerzy serwisu zgłosili następujące problemy i prośby:

* Chcemy móc dodawać do koszyka ten sam produkt kilka razy, o ile nie zostanie przekroczony sumaryczny limit sztuk produktów. Teraz to nie działa.
* Limit koszyka nie zawsze działa. Wprawdzie, gdy podczas naszych testów dodajemy czwarty produkt do koszyka to dostajemy komunikat `Cart is full.`, ale pomimo tego i tak niektóre koszyki w bazie danych mają po cztery produkty. 
* Najnowsze (ostatnio dodane) produkty powinny być dostępne na początkowych stronach listy produktów. 
* Musimy mieć możliwość edycji produktów. Czasami w nazwach są literówki, innym razem cena jest nieaktualna.

Prosimy o naprawienie / implementację.

PS. Prawdziwym celem zadania jest oczywiście kawałek kodu, który możemy ocenić, a potem porozmawiać o nim w czasie interview "twarzą w twarz". Przy czym pamiętaj, że liczy się nie tylko napisany kod PHP, ale także umiejętność przedstawienia czytelnego rozwiązania, użycia odpowiednich narzędzi (chociażby systemu wersjonowania), udowodnienia poprawności rozwiązania (testy) itd. 

To Twoja okazja na pokazanie umiejętności, więc jeśli uważasz, że w kodzie jest coś nie tak, widzisz więcej błędów, coś powinno być zaimplementowane inaczej, możesz do listy zadań dodać opcjonalny refactoring, albo krótko wynotować swoje spostrzeżenia (może przeprowadzić coś w rodzaju code review?).

Powodzenia!

## Uwagi i spostrzeżenia
* generalnie aplikacja ma strukturę mocno "frameworkową", można pójść w kierunku architektury warstwowej
* nie jestem zwolennikiem zwracania wartości przez commandy, przykład `CreateCart`, jeżeli chemy ID koszyka to możemy je najpierw wygenerować i przekazać do commanda
* logika zawarta w `Repository/*` tak na prawdę mogłaby być umieszczona w handlerach a faktyczne repozytorium implementować jedynie metody `get` oraz `save`
* `__invoke` w builderach, no można ale skoro i tak wywołujemy to jawnie to może lepiej `build`, jest krócej 😃
* w response builderach zamiast wrzucać całą encję, można utworzyć jakieś dedykowane view modele zawierające tylko niezbędne informacje i użyć serializera zamiast budować arrayke ręcznie
* przepisać adnotacje w kontrolerach na atrybuty
* przy tworzeniu obiektu `Response` używać named arguments
* private readonly gdzie się da
* dodałem phpstana ale można dorzucić więcej narzędzi do statycznej analizy, jakiś phpcs, deptrac
* odpalić statyczną analize na CI

## Słowo na koniec
* Jak jest `ShowCartController` to w response jedynie przemnożyłem cenę produktu przez ilość sztuk przez co wygląda to dziwnie. Nie chciałem zmieniać struktury response bo w takim prawdziwym przypadku potrzeba konsultacji z zespołem frontowym itp 😃
