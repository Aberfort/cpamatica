# Custom article importer

**Плагін custom-article-importer**

За допомогою WP Cron один раз в день заливає нові статті.

**Для роботи з плагіном потрібні npm та composer (node v14 )**
в папці плагіну запускаємо

```jsx
npm install
composer install
```

**Після установки зборщика можна зібрати стилі та скріпти плагіну**
для цього в папці з плагіном запускаємо

```jsx
npm run build
```
**При роботі із плагіном можна використовувати**

```
npm run watch

npm run build
```

**Також в плагіні підключений статичний аналізатор для PHP: PHP Code Sniffer.**
Для його запуску потрібно виконати таку команду

```
./vendor/bin/phpcbf ./includes/*
```
в команді указано маршрут в плагіні до бінарнику Code Sniffer, який автоматично буде виправляти код. Та безпосередньо маршрут до файлу (в нашому випадку - регулярний вираз, для виправлення всіх файлів у папці)

**Структура плагіна**

**custom-article-importer/dist** - директорія із скомпільованими файлами js та css, які потім підключаємо для плагіна;

**custom-article-importer/node_modules** - доректорія з npm пакетами;

**custom-article-importer/src** - доректорія для розробки скриптів та стилів;

**custom-article-importer/vendor** - доректорія з вендорними пакетами;

**custom-article-importer/views** - доректорія з файлами розмітки для фронт частини плагіну;

**custom-article-importer/includes** - доректорія з класами та основним функціоналом плагіну;
