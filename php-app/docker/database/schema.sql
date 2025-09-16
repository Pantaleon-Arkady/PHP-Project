CREATE TABLE IF NOT EXISTS app_user (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255),
    role VARCHAR(255) DEFAULT 'user',
    username VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS app_user_posts (
    id SERIAL PRIMARY KEY,
    author INT NOT NULL REFERENCES app_user(id),
    title TEXT,
    content TEXT NOT NULL,
    created_at TIMESTAMP,
    modified_at TIMESTAMP
);

CREATE TABLE IF NOT EXISTS app_user_products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price NUMERIC(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image_path VARCHAR(255),
    created_at DATE,
    modified_at DATE
);

CREATE TABLE IF NOT EXISTS app_user_main_comments (
    id SERIAL PRIMARY KEY,
    post_id INT NOT NULL REFERENCES app_user_posts(id),
    author INT NOT NULL REFERENCES app_user(id),
    content TEXT NOT NULL,
    created_at TIMESTAMP,
    modified_at TIMESTAMP
);

CREATE TABLE IF NOT EXISTS app_user_cart (
    id SERIAL PRIMARY KEY,
    type VARCHAR(255) DEFAULT 'regular',
    user_id INTEGER REFERENCES app_user(id),
    created_at DATE,
    modified_at DATE
);

CREATE TABLE IF NOT EXISTS app_user_cart_products (
    id SERIAL PRIMARY KEY,
    cart_id INTEGER REFERENCES app_user_cart(id),
    product_id INTEGER REFERENCES app_user_products(id),
    quantity INTEGER NOT NULL DEFAULT 1,
    created_at DATE,
    modified_at DATE
);

CREATE TABLE IF NOT EXISTS app_user_order (
    id SERIAL PRIMARY KEY,
    cart_id INT NOT NULL REFERENCES app_user_cart(id),
    user_id INT NOT NULL REFERENCES app_user(id),
    status VARCHAR(255) DEFAULT 'pending',
    created_at DATE,
    modified_at DATE
);

CREATE TABLE IF NOT EXISTS app_user_order_item (
    id SERIAL PRIMARY KEY,
    order_id INT NOT NULL REFERENCES app_user_order(id),
    product_id INT NOT NULL REFERENCES app_user_products(id),
    price NUMERIC(10, 2) NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1,
    total_price NUMERIC(10, 2) NOT NULL,
    created_at DATE,
    modified_at DATE
);

CREATE TABLE IF NOT EXISTS react_php_mixed (
    id SERIAL PRIMARY KEY,
    task TEXT NOT NULL
);