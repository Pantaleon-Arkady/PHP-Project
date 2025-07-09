TRUNCATE app_user RESTART IDENTITY;

INSERT INTO app_user (email, username, password)
VALUES 
  ('first@email.com', 'first user', md5('password')),
  ('demo@demo.com', 'demo', md5('demo123')),
  ('test@test.com', 'test', md5('test123'));

INSERT INTO app_user_posts (author, title, content, created_at)
VALUES
  (1,
  'Title',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce non lorem purus. Suspendisse bibendum mauris nunc. Praesent euismod pharetra eleifend.',
  '2025-06-04 10:45:00'),
  (1,
  '2nd Post',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce non lorem purus. Suspendisse bibendum mauris nunc. Praesent euismod pharetra eleifend.',
  '2025-07-04 10:45:00'),
  (2,
  'Title',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce non lorem purus. Suspendisse bibendum mauris nunc. Praesent euismod pharetra eleifend.',
  '2025-06-05 10:45:00'),
  (3,
  'Trial Title',
  'Trial Post by Trial User',
  '2025-07-05 10:45:00');