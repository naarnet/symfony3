create database  if not exists blog;

use blog ;

create table users(id int(255)auto_increment not null, rol varchar(20), name varchar(255),surname varchar(255),email  varchar(255),password   varchar(255),image varchar(255),constraint pk_users primary key(id))engine=InnoDb;

create table categories(id int(255) auto_increment not null,name varchar(255),description text,constraint pk_categories primary key(id))engine=InnoDb;

create table entries(id int(255) auto_increment not null,user_id int(255) not null,category_id int(255) not null,tittle  varchar(255),content  text,status varchar(20),image varchar(255),constraint pk_entries primary key(id),constraint fk_entries_users foreign key(user_id) reference users(id),constraint fk_entries_categories foreign key(category_id) reference categories(id))engine=InnoDb;

create table tags(id  int(255) auto_increment not null,name varchar(255),description text,constraint pk_tags primary key(id))engine=InnoDb;


create table entry_tag(id int(255) auto_increment not null,entry_id  int(255) not null,tag_id  int(255) not null,constraint pk_entry_tag primary key(id),constraint fk_entry_tag_entries foreign key(entry_id) references entries(id),constraint fk_entries_tag_tags foreign key(tag_id) references tags(id))engine=InnoDb;


