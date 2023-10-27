# Estatik bookings

**Для роботи google maps в основний файл плагіну (estatik-bookings.php) додайте фаш АПИ ключ для карти!!!**

**Для роботи з плагіном потрібен composer (node v14 )**
в папці плагіну запускаємо

```jsx
composer install
```

**Також в плагіні підключений статичний аналізатор для PHP: PHP Code Sniffer.**
Для його запуску потрібно виконати таку команду

```
./vendor/bin/phpcbf ./includes/*
```