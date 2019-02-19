USE yeticave_db;
INSERT INTO categories(name) 
VALUES('Доски и лыжи'), 
		('Крепления'),
		('Ботинки'),
		('Одежда'),
		('Инструменты'),
		('Разное');
		
INSERT INTO users(name, email, password, avatar_path, contact ) 
VALUES('Иван', 'ivan@mail.ru', 'fgkjkdsk','img/ivan.jpg', 'г. Москва ул.Садовая д.5'), 
		('Петр', 'pit@mail.ru', 'klkjsdkkj','img/pit.jpg', 'г. Иркутск ул.Денина д.63');
		
INSERT INTO lots(date_end, title, category_id, start_price, step_rate, image_path, user_id, win_user_id) 
VALUES('2019-02-25', '2014 Rossignol District Snowboard', 13, 10999, 100, 'img/lot-1.jpg',1, null),
		('2019-03-01', 'DC Ply Mens 2016/2017 Snowboard', 13, 159999, 200, 'img/lot-2.jpg',1, null),
		('2019-02-28', 'Крепления Union Contact Pro 2015 года размер L/XL',14, 8000,   500, 'img/lot-3.jpg',2, null),
		('2019-02-27', 'Ботинки для сноуборда DC Mutiny Charocal', 16, 10999,100, 'img/lot-4.jpg',2, null),
		('2019-02-28', 'Куртка для сноуборда DC Mutiny Charocal', 17, 7500, 300, 'img/lot-5.jpg',2, null),
		('2019-02-28', 'Маска Oakley Canopy', 19, 5400, 100, 'img/lot-6.jpg', 2, null);
		
INSERT INTO rates(sum_price, id_user, id_lot) 
VALUES(10999, 2, 25),
      (5400, 1, 30),
	  (11999, 2, 25),
	  (12999, 2, 25);	
		
/*получить все категории;*/
SELECT * FROM categories;

/*получить самые новые, открытые лоты. 
Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;*/
SELECT title, start_price, image_path, categories.name, ifnull(max(rates.sum_price),lots.start_price) FROM lots
JOIN categories ON lots.category_id=categories.id
LEFT JOIN rates ON lots.id=rates.id_lot
WHERE lots.date_end >CURRENT_DATE()
group by lots.id
ORDER BY lots.date_create DESC
LIMIT 5;


/*показать лот по его id. Получите также название категории, к которой принадлежит лот*/
SELECT * FROM lots
JOIN categories ON lots.category_id=categories.id
WHERE lots.id=27;

/*обновить название лота по его идентификатору;*/
UPDATE lots SET title = 'Крепления UCP 2015 года размер L/XL'
WHERE id=27;

/*получить список самых свежих ставок для лота по его идентификатору;*/
SELECT rates.id, rates.date_registered, rates.sum_price,  lots.title  FROM rates
JOIN lots ON lots.id=rates.id_lot
WHERE lots.id=25
ORDER BY rates.date_registered DESC
LIMIT 2;
	