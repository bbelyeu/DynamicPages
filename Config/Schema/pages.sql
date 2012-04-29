create table pages (
    id int unsigned not null auto_increment primary key,
    image_id int unsigned not null,
    title varchar(100) not null default '',
    url varchar(50) not null default '',
    custom_view varchar(50) not null default '',
    copy text not null default '',
    created DATETIME,
    modified DATETIME,
    key title (title),
    uniuqe key url (url)
) engine=innodb default charset=utf8;
