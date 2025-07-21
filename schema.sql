-- Создание таблицы ресторанов
CREATE TABLE restaurants (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    image_path TEXT,
    description TEXT
);

-- Создание таблицы отзывов
CREATE TABLE reviews (
    id SERIAL PRIMARY KEY,
    restaurant_id INTEGER REFERENCES restaurants(id) ON DELETE CASCADE,
    email TEXT NOT NULL,
    name TEXT NOT NULL,
    comment TEXT NOT NULL,
    rating INTEGER CHECK (rating BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Создание таблицы пользователей
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    name TEXT NOT NULL
);

-- Примеры данных для ресторанов
INSERT INTO restaurants (name, image_path, description) VALUES
('HITE', 'assets/images/hite.jpg', 'Описание HITE...'),
('CHICKO', 'assets/images/chicko.jpg', 'Описание CHICKO...'),
('KOOK', 'assets/images/kook.jpg', 'Описание KOOK...'),
('БЕЛЫЙ ЖУРАВЛЬ', 'assets/images/журавль.jpg', 'Описание Белого Журавля...'),
('КИМЧИ', 'assets/images/кимчи.jpg', 'Описание КИМЧИ...');
