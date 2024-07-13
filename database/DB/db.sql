drop table if exists users;
drop table if exists product_ratings;
drop table if exists product_attributes;
drop table if exists products;

create table products(
    id int not null auto_increment primary key,
    `name` varchar(255),
    price decimal(15,3),
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL
);


create table product_attributes(
    id int not null auto_increment primary key,
    product_id int,
    attribute varchar(255),
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,

    KEY `product_id_indx` (`product_id`),
    CONSTRAINT productattribute_product_fk FOREIGN KEY (product_id) REFERENCES products(id)
);


create table product_ratings(
    id int not null auto_increment primary key,
    product_id int,
    product_attribute_id int,
    user_id int,
    rate float default 0,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,

    KEY `productrating_productattribute_indx` (`product_attribute_id`),
    KEY `productrating_product_indx` (`product_id`),
    KEY `user_id_indx` (`user_id`),

    CONSTRAINT productrating_products_fk FOREIGN KEY (product_id) REFERENCES products(id),
    CONSTRAINT productrating_productsattributes_fk FOREIGN KEY (product_attribute_id) REFERENCES product_attributes(id),
    CONSTRAINT productrating_users_fk FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


