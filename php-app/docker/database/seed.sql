TRUNCATE app_user RESTART IDENTITY;

INSERT INTO app_user (email, username, password)
VALUES 
  ('first@email.com', 'first user', md5('password')),
  ('demo@demo.com', 'demo', md5('demo123')),
  ('test@test.com', 'test', md5('test123'));