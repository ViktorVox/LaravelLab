# LaravelLab: Монолитный Backend Портал

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-DC382D?style=for-the-badge&logo=redis&logoColor=white)

Привет! Это мой единый полигон для демонстрации архитектурных навыков и знаний экосистемы Laravel. 
Вместо десятка мелких разрозненных репозиториев, я собрал различные сервисы в единую модульную систему (Монолит). 

Проект спроектирован с учетом современных стандартов: строгая типизация, FormRequests, фоновые очереди (Queues) и WebSockets.

## Реализованные модули (Фичи)

- [x] **Task Manager (API + CRUD):** Управление задачами с продвинутой фильтрацией. Демонстрация работы с базовым CRUD, валидацией и Eloquent.
- [x] **Auth (Sanctum):** Реализация регистрации, входа и выхода, с использованием **Bearer Token**.
- [x] **API Parser:** Модуль для парсинга данных. Демонстрация работы с внешними HTTP-клиентами, **Redis** и фоновыми задачами (**Jobs**).
- [x] **Real-time Уведомления:** Интеграция **Laravel Reverb** (WebSockets) для отправки уведомлений на фронтенд без перезагрузки страницы (например, об окончании парсинга).
- [x] **CRM / Прием заявок:** Система ролей. Форма для клиентов и защищенная панель администратора для просмотра заявок (демонстрация Middleware и авторизации).
- [x] **Умная библиотека:** Модуль работы со сложными связями в базе данных (One-to-Many, Many-to-Many).

## Планы
- [ ] **Frontend:** Сделать внешний вид для всех реализаций.
- [ ] **Docker:** Пересобрать проект на Docker, для упрощения установки.
- [ ] **Auto Test`s:** Написать авто-тесты для проверки API скриптов.
- [ ] **Documentation:** Написать документацию для проекта, чтобы можно было проще с ним ознакомиться.

## Технический стек и решения
- **База данных:** PostgreSQL
- **Аутентификация:** Laravel Sanctum (API Tokens)
- **Кэш и Очереди:** Redis + Laravel Horizon/Worker
- **Документация API:** Scribe
- **Реалтайм:** Laravel Reverb + Laravel Echo
- **Архитектура:** Controller -> FormRequest -> Model -> Resource

---
*Проект находится в стадии активной разработки и миграции старых решений на новую архитектуру.*