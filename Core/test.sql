ALTER TABLE Comment_Author
ADD FOREIGN KEY (id_author) REFERENCES Users(id) on delete cascade;
ALTER TABLE Articles_author
ADD FOREIGN KEY (id_author) REFERENCES Users(id) on delete cascade;

SELECT Users.id AS "user_id", Articles.title AS "titre", Articles.content AS "contenue", Articles.date AS "date_post", Comments.content AS "commentaire", Comments.date AS "date_comment", Articles.id AS "Article_id"
FROM Users
INNER JOIN Articles_author ON Articles_author.id_author = Users.id
INNER JOIN Articles ON Articles.id = Articles_author.id_article
INNER JOIN Comments_Author ON Comments_Author.id_author = Users.id
INNER JOIN Comments ON Comments_Author.id_comment = Comments.id

/**
 * Selectionner les articles des utilisateur
 */

SELECT Users.id AS "user_id", Articles.title AS "titre", Articles.content AS "contenue", Articles.date AS "date_post", Articles.id AS "Article_id"
FROM Users
INNER JOIN Articles_author ON Articles_author.id_author = Users.id
INNER JOIN Articles ON Articles.id = Articles_author.id_article

/**
 * Selectionner les commentaires des utilisateur
 */

SELECT Comments.content AS "commentaire", Comments.date AS "date_comment"
FROM Users
INNER JOIN Comments_Author ON Comments_Author.id_author = Users.id
INNER JOIN Comments ON Comments_Author.id_comment = Comments.id


SELECT Articles.title AS "titre", Articles.content AS "contenue", Articles.date AS "date_post", Comments.content AS "commentaire", Comments.date AS "date_comment", Articles.id AS "Article_id"
FROM Articles
INNER JOIN Comments ON Comments.id_article = Articles.id