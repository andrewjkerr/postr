CREATE TABLE users (
uid SERIAL,
username VARCHAR(30),
email VARCHAR(255),
password_hash VARCHAR(255),
PRIMARY KEY (uid),
UNIQUE (uid, username, email)
);

CREATE TABLE follows (
fid SERIAL,
follow_uid INT,
follower_uid INT,
PRIMARY KEY (fid),
FOREIGN KEY (follow_uid) REFERENCES users(uid),
FOREIGN KEY (follower_uid) REFERENCES users(uid),
UNIQUE (fid)
);

CREATE TABLE posts(
pid SERIAL,
uid INT,
DATE time,
content_type INT,
content VARCHAR(255),
PRIMARY KEY (pid),
FOREIGN KEY (uid) REFERENCES users (uid),
UNIQUE (pid, uid)
);

CREATE TABLE likes (
pid INT,
like_uid INT,
FOREIGN KEY (pid) REFERENCES posts (pid),
FOREIGN KEY (like_uid) REFERENCES users (uid)
);

CREATE TABLE comments (
cid SERIAL,
pid INT,
DATE time,
comment_uid INT,
comment VARCHAR(255),
PRIMARY KEY (cid),
FOREIGN KEY (pid) REFERENCES posts (pid),
FOREIGN KEY (comment_uid) REFERENCES users (uid),
UNIQUE (cid)
);