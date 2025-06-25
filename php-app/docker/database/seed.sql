TRUNCATE app_user RESTART IDENTITY;

INSERT INTO app_user (email, username, password)
VALUES 
  ('first@email.com', 'first user', 'password'),
  ('demo@demo.com', 'demo', 'demo123'),
  ('test@test.com', 'test', 'test123');