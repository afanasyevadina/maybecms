## Может быть, CMS

Разрабатываемая система предназначена для создания сайтов (с ограниченным функционалом). Создаваемые сайты отображают информацию, заполненную в админ-панели, есть возможность редактировать данные в блочном редакторе, настраивать метатеги, управлять медиафайлами, использовать пользовательские типы данных, управлять темами.

Исходя из вышеописанного, система должна выполнять следующие функции:
1) настройка параметров системы;
2) авторизация пользователя;
3) редактирование моделей-типов данных:
- описание атрибутов сущностей;
- описание связей с другими сущностями;
- создание, редактирование, удаление моделей
4) управление стилями и темами;
5) управление медиафайлами различных типов: загрузка, удаление, подключение к страницам и блокам;
6) работа со страницами:
- добавление страницы;
- удаление страницы;
- изменение настроек страницы;
- наполнение страницы контентом в блочном редакторе;
- настройка стилей и тем для блоков;
- отображение страниц на публичной (клиентской) части сайта;
- сохранение (компиляция) страниц как статичный HTML;
- настройка SEO-тегов.
7) создание связей между страницами или разделами страниц с моделями-сущностями;
8) создание API для выдачи контента страниц и блоков сайта;
9) создание навигации по сайту;
10) управление preset-ами (создание, редактирование, удаление, подключение к страницам и блокам).

## Запуск

Распакуйте проект. В консоли запустите:
```shell
cp .env.example .env
```

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```

И затем:

```shell
./vendor/bin/sail up -d
```
Это соберет и запустит докер-контейнеры

```shell
./vendor/bin/sail artisan maybecms:install
```
Это выполнит нужные настройки для запуска админ-панели

Приложение будет работать по адресу http://localhost:80 (если не переопределено в hosts файле).
