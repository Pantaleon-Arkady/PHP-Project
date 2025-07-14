TRUNCATE app_user RESTART IDENTITY;

INSERT INTO app_user (email, role, username, password)
VALUES 
  ('bobross@email.com', 'user', 'Bob Ross', md5('practice')),
  ('admin@shop.com', 'admin', 'admin', md5('admin123')),
  ('first@email.com', 'user', 'first user', md5('password')),
  ('demo@demo.com', 'user', 'demo', md5('demo123')),
  ('test@test.com', 'user', 'test', md5('test123'));

INSERT INTO app_user_posts (author, title, content, created_at)
VALUES
  (2,
  'Title',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce non lorem purus. Suspendisse bibendum mauris nunc. Praesent euismod pharetra eleifend.',
  '2025-06-04 10:45:00'),
  (2,
  '2nd Post',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce non lorem purus. Suspendisse bibendum mauris nunc. Praesent euismod pharetra eleifend.',
  '2025-07-04 10:45:00'),
  (3,
  'Title',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce non lorem purus. Suspendisse bibendum mauris nunc. Praesent euismod pharetra eleifend.',
  '2025-06-05 10:45:00'),
  (4,
  'Trial Title',
  'Trial Post by Trial User',
  '2025-07-05 10:45:00'),
  (1,
  'Talent',
  '"Talent is a pursued interest. Anything that you''re willing to practice, you can do."',
  '2025-04-28 23:06:00');

INSERT INTO app_user_products (name, description, price, stock, image_path, created_at)
VALUES
  ('HGUC - GunCannon', 'Lorem ipsum dolor sit amet', 15.00, 23, '["/files/001_boxart.png", "/files/001_left.jpg", "/files/001_right.jpg"]', '2025-07-11'),
  ('HGUC - Gyan', 'Lorem ipsum dolor sit amet', 15.00, 23, '["/files/002_boxart.png", "/files/002_left.jpg", "/files/002_right.jpg"]', '2025-07-11'),
  ('HGUC - Hyaku-Shiki', 'Lorem ipsum dolor sit amet', 15.00, 23, '["/files/005_boxart.png", "/files/005_left.jpg", "/files/005_right.jpg"]', '2025-07-11'),
  ('HGUC - Gundam GP01', 'Lorem ipsum dolor sit amet', 15.00, 23, '["/files/013_boxart.png"]', '2025-07-11'),
  ('HGUC - Z''Gok', 'Lorem ipsum dolor sit amet', 15.00, 23, '["/files/019_boxart.png"]', '2025-07-11'),
  ('HGUC - GM', 'Lorem ipsum dolor sit amet', 15.00, 23, '["/files/020_boxart.png"]', '2025-07-11');