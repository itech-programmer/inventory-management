# 📦 Inventory Management API

**API для управления товарами, партиями, клиентами и возвратами.**

## 📌 Описание

`Inventory Management API` предназначен для управления процессами закупки, хранения, продажи и возврата товаров.  
Система поддерживает **категории**, **товары**, **партии**, **склады**, **клиентов** и **возвраты**.

---

## 🏗 Архитектура данных

### 🔹 Основные сущности:

- **Products (Товары)** – Каждый товар принадлежит определенной категории.
- **Providers (Поставщики)** – Компании, у которых закупаются товары.
- **Batches (Партии)** – Группы товаров, закупленных у поставщиков.
- **Storages (Склады)** – Места, где хранятся товары перед продажей.
- **Clients (Клиенты)** – Компании, которым продаются товары.

---

## 🔄 Как работает система?

### 1️⃣ Закупка товаров
✅ Товары закупаются **партиями** у поставщиков и **хранятся на складе**.

### 2️⃣ Продажа товаров клиентам
✅ Товары продаются клиентам с **наценкой** для получения **прибыли**.

### 3️⃣ Обработка возвратов
✅ **Возвраты** возможны как от **клиентов** (на проданные товары), так и от **поставщиков** (на закупленные товары).

---

## 🚀 Установка и запуск проекта
### 📥 Требования:
- Docker
- Make
- Docker Compose
- 
### 📌 Установка

**1️⃣ Клонируем репозиторий:**

```bash
    git clone https://github.com/itech-programmer/inventory-management.git
    cd inventory-management
```

**2️⃣ Запускаем проект**

```bash
    make start
```

**✅ Этот шаг:**

- Копирует .env.example в .env (если его нет).
- Поднимает контейнеры с Laravel и базой данных.
- Устанавливает зависимости через Composer.
- Запускает миграции и заполняет базу тестовыми данными.

**3️⃣ Проверяем статус контейнеров**

```bash
    docker-compose ps
```

### 📌 Полезные команды
**🟢 Запустить контейнеры**
```bash
    make up
```

**🔴 Остановить контейнеры**
```bash
    make down
```

**♻️ Перезапустить контейнеры**
```bash
    make restart
```

**♻📜 Просмотреть логи**
```bash
    make logs
```

**🛠 Войти в контейнер Laravel**
```bash
    make bash
```

**📦 Запустить миграции**
```bash
    make migrate
```

**🌱 Заполнить базу тестовыми данными**
```bash
    make seed
```

**🧪 Запустить тесты**
```bash
    make test
```

**⚡ Запуск artisan команд**
```bash
    make artisan cmd=migrate
```

**🎵 Запуск composer команд**
```bash
    make composer cmd=update
```

**🚀 Оптимизация кеша**
```bash
    make optimize
```

**🗑 Очистка кеша**
```bash
    make clear
```

---

## 📚 API Эндпоинты

### 🛍 Товары (`/products`)

#### 📌 Получить список всех товаров
`GET /api/v1/products`

```json
{
    "type": "success",
    "message": "Products retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Ahmad Tea Earl Grey, 500g",
            "category_name": "Black Tea",
            "price": 10.99
        }
    ]
}
```

#### 📌 Получить доступные товары для заказа
`GET /api/v1/products/available`
```json
{
  "type": "success",
  "message": "Available products retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Ahmad Tea Earl Grey, 500g",
      "category_name": "Black Tea",
      "price": 10.99,
      "qty": 50
    }
  ]
}
```

#### 📌 Создать товар
`POST /api/v1/products`
```json
{
  "name": "Ahmad Tea Green, 500g",
  "category_id": 3,
  "price": 12.50
}
```
#### ✅ Ответ
```json
{
  "type": "success",
  "message": "Product created successfully",
  "data": {
    "name": "Ahmad Tea Green, 500g",
    "price": 12.5,
    "id": 2
  }
}

```

### 📦 Партии (/batches)
#### 📌 Расчет прибыли по партиям
`GET /api/v1/batches/profit`
```json
{
  "type": "success",
  "message": "Batch profit calculated successfully",
  "data": [
    {
      "batch_id": 1,
      "total_sales": 25.98,
      "total_cost": 799,
      "total_refunds": 0,
      "profit": -773.02
    }
  ]
}
```

### 📦 Склады (/storage)
#### 📌 Получить остатки товаров на складе
`GET /api/v1/storage/remaining?date=2025-03-06`
```json
{
  "type": "success",
  "message": "Remaining quantities retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Ahmad Tea Earl Grey, 500g",
      "remaining_qty": 50
    }
  ]
}
```

### 🛒 Заказы (/orders)
#### 📌 Создать заказ клиента
`POST /api/v1/orders`
```json
{
  "client_id": 1,
  "products": [
    {
      "id": 1,
      "qty": 2
    }
  ]
}
```
#### ✅ Ответ
```json
{
  "type": "success",
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "client_id": 1,
    "client_name": "Supermarket X",
    "products": [
      {
        "id": 1,
        "name": "Ahmad Tea Earl Grey, 500g",
        "quantity": 2,
        "price_at_sale": 10.99
      }
    ]
  }
}
```

### 🔄 Возвраты (/refunds)
#### 📌 Оформить возврат товара
`POST /api/v1/refunds`
```json
{
  "order_id": 1,
  "quantity": 1,
  "refund_amount": 5.50
}
```
#### ✅ Ответ
```json
{
  "type": "success",
  "message": "Refund processed",
  "data": {
    "batch_id": null,
    "order_id": 1,
    "quantity": 1,
    "refund_amount": 5.5,
    "id": 2
  }
}
```

### 📜 Список API-роутов
## 📜 Список API-роутов

| Метод   | URI                                       | Описание |
|---------|------------------------------------------|-----------------------------------------------------|
| **📁 Категории (Categories)** |
| `GET`   | `/api/v1/categories`                     | Получить все категории |
| `GET`   | `/api/v1/categories/{id}`                | Получить категорию по ID |
| `GET`   | `/api/v1/categories/{id}/subcategories`  | Получить подкатегории данной категории |
| `GET`   | `/api/v1/categories/provider/{providerId}` | Получить категории по поставщику |
| `POST`  | `/api/v1/categories`                     | Создать новую категорию |
| `PUT`   | `/api/v1/categories/{id}`                | Обновить категорию |
| `DELETE`| `/api/v1/categories/{id}`                | Удалить категорию |
| **🛍️ Товары (Products)** |
| `GET`   | `/api/v1/products`                       | Получить список всех товаров |
| `GET`   | `/api/v1/products/available`             | Получить доступные товары |
| `GET`   | `/api/v1/products/{id}`                  | Получить товар по ID |
| `POST`  | `/api/v1/products`                       | Создать новый товар |
| `PUT`   | `/api/v1/products/{id}`                  | Обновить товар |
| `DELETE`| `/api/v1/products/{id}`                  | Удалить товар |
| **🛒 Заказы (Orders)** |
| `GET`   | `/api/v1/orders`                         | Получить список всех заказов |
| `GET`   | `/api/v1/orders/client/{clientId}`       | Получить заказы клиента |
| `GET`   | `/api/v1/orders/{id}`                    | Получить заказ по ID |
| `POST`  | `/api/v1/orders`                         | Создать заказ |
| `DELETE`| `/api/v1/orders/{id}`                    | Удалить заказ |
| **🔄 Возвраты (Refunds)** |
| `GET`   | `/api/v1/refunds`                        | Получить список всех возвратов |
| `GET`   | `/api/v1/refunds/{id}`                   | Получить возврат по ID |
| `POST`  | `/api/v1/refunds`                        | Оформить возврат |
| **📦 Партии (Batches)** |
| `GET`   | `/api/v1/batches/profit`                 | Рассчитать прибыль по партиям |
| **🏪 Склады (Storage)** |
| `GET`   | `/api/v1/storage/remaining?date=YYYY-MM-DD` | Получить остатки товаров на складе |


### 🛠 Технические требования
- Язык: PHP 8.4
- Фреймворк: Laravel
- База данных: MySQL
- Тестирование: PHPUnit (Feature-тесты для всех API)

### 🔹 Архитектура:
- ✅ SOLID
- ✅ Dependency Injection
- ✅ DTO (Data Transfer Object)
- ✅ Сервисный слой (Service Layer)
- ✅ Репозитории (Repository Pattern)

## 📜 Postman-коллекция

Для удобного тестирования API можно использовать коллекцию Postman.  
Файл коллекции: `Inventory Management.postman_collection.json` (находится в корне проекта).

## 🔖 Версия API
Текущая версия API: **v1**  
Базовый URL:  http://localhost:8080/api/v1

```markdown
📌 **Внимание:** при обновлении API будет создано `/api/v2`.
```
