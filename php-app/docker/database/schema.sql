CREATE TABLE IF NOT EXISTS app_user (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255),
    username VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS app_user_posts (
    id SERIAL PRIMARY KEY,
    author INT NOT NULL,
    title TEXT,
    content TEXT NOT NULL,
    created_at TIMESTAMP,
    modified_at TIMESTAMP
);

CREATE TABLE IF NOT EXISTS app_user_products {
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price NUMERIC(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image_path VARCHAR(255),
    created_at DATE,
    modified_at DATE
}