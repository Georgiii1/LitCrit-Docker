# LitCrit — Литературна платформа с PHP и MySQL

Проектът ми се състои от 2 основни компонента: front-end, Apache webserver + php и MySQL база данни.
## Структура на проекта
```
litcrit-docker/
├── Dockerfile - PHP + Apache и MySQL образ с нужните разширения
├── docker-compose.yml - Описание на услугите: web и db
├── index.php - Начален файл на уеб приложението
├── src/
│ └── database/
│ ├── config.php  Конфигурация за свързване към базата данни
│ └── litCrit-dataexport.sql - SQL скрипт за инициализиране на базата данни
└── ... други файлове
```

## Описание на отделните компоненити
### PHP + Apache Web
- Базиран на `php:8.1-apache` с инсталирани разширения: `mysqli`, `pdo`, `pdo_mysql`.
- Копира всички файлове в директорията `/var/www/html` в контейнера.
- Активиран е `mod_rewrite`.
- Зависим от услугата `db`.

# MySQL - DB
- Базирана на последната версия на `mysql` Docker образ.
- Автоматично създава база данни `LitCrit2` при стартиране.
- Инициализира се с `litCrit-dataexport.sql`.
- Данните се съхраняват в Docker том `db_data`, за да се запазват между рестартиранията.

# Комуникация между услигите
- Двете услуги `web` и `db` са в обща Docker мрежа.
- Комуникацията се осъществява чрез името на услугата `db` като hostname.
- Във файла `config.php` се осъществява връзката с базата данни чрез PDO.

## Изграждане и стартиране на контейнерите
След създаването на Docker файла и compose.yml файла, трябва да изпълним следните команди:
### Чрез Docker
1. Трябва да се намираме в директорията на `Dockerfile`
2. Създаваме docker image/образ:
```bash
docker build -t litcrit-docker .
```
3. Създаваме и стартираме docker container
```bash
docker run -p 8080:80 litcrit-docker
```
* Уеб приложението ще бъде достъпно в браузара на: http://localhost:8080:80/src/
4. Допълнтелни команди - спиране на контейнер
```bash
docker ps -a # виждаме информация за работещи контейнери
docker stop <CONTAINER_ID_OR_NAME> # спираме даден контейнер
docker rm <CONTAINER_ID_OR_NAME> # премахваме даден контейнер
docker system prune           # Изчисти неизползвани контейнери, мрежи, кеш и обеми
```
4. Допълнтелни команди - премахване на контейнер
```bash
docker image ls # показва инсталирани изображения
docker rmi <IMAGE_NAME> # премахва дадено изображение
```
### За Docker Compose
1. Уверете се, че сте създали правилно compose.yml файла
2. Стартиране на проекта
```bash
docker compose up --build
```
* Уеб приложението ще бъде достъпно в браузара на: http://localhost:8080:80/src/
4. Спирането на приложението става чрез: Ctrl/Command + C
5. Изтриване на проекта:
```bash
docker compose down -v
```

## Теглене от Docker hub
```bash
docker pull georgi21207/litcrit-docker 
docker run -p 3000:3000 georgi21207/litcrit-docker 
```


