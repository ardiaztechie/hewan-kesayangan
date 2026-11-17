-- Skema database Website E-Commerce Hewan Kesayangan (MySQL 8 / MariaDB 10.6+)
-- Dihasilkan dari sumber yang sama dengan migration Laravel.
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NULL DEFAULT NULL,
  `role` enum('customer','owner','staff') NOT NULL DEFAULT 'customer' COMMENT 'customer = pelanggan, owner = pemilik toko, staff = staf',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Semua pengguna: pelanggan, owner, dan staf';

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NULL DEFAULT NULL,
  `ip_address` varchar(45) NULL DEFAULT NULL,
  `user_agent` text NULL DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned NULL DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext NULL DEFAULT NULL,
  `cancelled_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Notifikasi di website (ikon lonceng)';

DROP TABLE IF EXISTS `store_settings`;
CREATE TABLE `store_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `logo_path` varchar(255) NULL DEFAULT NULL,
  `description` text NULL DEFAULT NULL,
  `whatsapp_number` varchar(20) NOT NULL,
  `shopee_url` varchar(255) NULL DEFAULT NULL,
  `tiktok_url` varchar(255) NULL DEFAULT NULL,
  `origin_city_id` varchar(20) NULL DEFAULT NULL COMMENT 'Kota asal untuk API Ongkir',
  `origin_district_id` varchar(20) NULL DEFAULT NULL,
  `origin_address` text NULL DEFAULT NULL,
  `active_couriers` longtext NULL DEFAULT NULL COMMENT 'Kode kurir aktif, mis. ["jne","jnt","sicepat"]' CHECK (json_valid(`active_couriers`)),
  `store_bank_name` varchar(50) NULL DEFAULT NULL,
  `store_account_number` varchar(50) NULL DEFAULT NULL,
  `store_account_name` varchar(100) NULL DEFAULT NULL,
  `payment_timeout_hours` int(10) unsigned NOT NULL DEFAULT '24',
  `ship_deadline_days` int(10) unsigned NOT NULL DEFAULT '2',
  `auto_complete_days` int(10) unsigned NOT NULL DEFAULT '7',
  `cancel_respond_hours` int(10) unsigned NOT NULL DEFAULT '24',
  `return_window_days` int(10) unsigned NOT NULL DEFAULT '3' COMMENT 'Batas ajukan pengembalian setelah Selesai',
  `return_respond_hours` int(10) unsigned NOT NULL DEFAULT '48',
  `return_ship_days` int(10) unsigned NOT NULL DEFAULT '5' COMMENT 'Batas pelanggan mengirim barang retur',
  `inspection_hours` int(10) unsigned NOT NULL DEFAULT '48',
  `refund_transfer_hours` int(10) unsigned NOT NULL DEFAULT '48',
  `is_holiday_mode` tinyint(1) NOT NULL DEFAULT '0',
  `holiday_until` date NULL DEFAULT NULL,
  `holiday_message` varchar(255) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pengaturan toko (satu baris)';

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `label` varchar(50) NULL DEFAULT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `province_id` varchar(20) NOT NULL,
  `province_name` varchar(100) NOT NULL,
  `city_id` varchar(20) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `district_id` varchar(20) NULL DEFAULT NULL,
  `district_name` varchar(100) NULL DEFAULT NULL,
  `postal_code` varchar(10) NOT NULL,
  `detail` text NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Buku alamat pelanggan';

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NULL DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Kategori bertingkat';

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `brand` varchar(100) NULL DEFAULT NULL,
  `description` longtext NULL DEFAULT NULL,
  `specifications` longtext NULL DEFAULT NULL CHECK (json_valid(`specifications`)),
  `animal_type` varchar(50) NULL DEFAULT NULL COMMENT 'Jenis hewan untuk filter',
  `weight_gram` int(10) unsigned NOT NULL COMMENT 'Berat aktual per pcs',
  `length_cm` int(10) unsigned NOT NULL DEFAULT '0',
  `width_cm` int(10) unsigned NOT NULL DEFAULT '0',
  `height_cm` int(10) unsigned NOT NULL DEFAULT '0',
  `video_url` varchar(255) NULL DEFAULT NULL,
  `status` enum('active','hidden','archived') NOT NULL DEFAULT 'active',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `rating_avg` decimal(3,2) NOT NULL DEFAULT '0',
  `rating_count` int(10) unsigned NOT NULL DEFAULT '0',
  `sold_count` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT,
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Produk; produk yang pernah dipesan hanya bisa diarsipkan';

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maksimal 9 foto per produk (divalidasi aplikasi)';

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `sku` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT 'Default',
  `price` decimal(12,2) NOT NULL,
  `discount_price` decimal(12,2) NULL DEFAULT NULL COMMENT 'Harga coret',
  `discount_start_at` datetime NULL DEFAULT NULL,
  `discount_end_at` datetime NULL DEFAULT NULL,
  `cost_price` decimal(12,2) NULL DEFAULT NULL COMMENT 'Harga pokok',
  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Stok fisik',
  `reserved_stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Stok tertahan pesanan belum dikirim',
  `min_stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Batas peringatan stok menipis',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `product_variants_sku_unique` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `wholesale_prices`;
CREATE TABLE `wholesale_prices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `min_qty` int(10) unsigned NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wholesale_prices_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `wholesale_prices_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `wholesale_prices_product_variant_id_min_qty_unique` (`product_variant_id`,`min_qty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Harga grosir bertingkat, maks. 5 tingkat per varian';

DROP TABLE IF EXISTS `related_products`;
CREATE TABLE `related_products` (
  `product_id` bigint(20) unsigned NOT NULL,
  `related_product_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`related_product_id`),
  KEY `related_products_product_id_foreign` (`product_id`),
  CONSTRAINT `related_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  KEY `related_products_related_product_id_foreign` (`related_product_id`),
  CONSTRAINT `related_products_related_product_id_foreign` FOREIGN KEY (`related_product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Produk terkait untuk cross selling';

DROP TABLE IF EXISTS `bundles`;
CREATE TABLE `bundles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NULL DEFAULT NULL,
  `bundle_price` decimal(12,2) NOT NULL,
  `start_at` datetime NULL DEFAULT NULL,
  `end_at` datetime NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Paket bundling';

DROP TABLE IF EXISTS `bundle_items`;
CREATE TABLE `bundle_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bundle_id` bigint(20) unsigned NOT NULL,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bundle_items_bundle_id_foreign` (`bundle_id`),
  CONSTRAINT `bundle_items_bundle_id_foreign` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`) ON DELETE CASCADE,
  KEY `bundle_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `bundle_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `bundle_items_bundle_id_product_variant_id_unique` (`bundle_id`,`product_variant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_unique` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `is_selected` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  KEY `cart_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `cart_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `cart_items_cart_id_product_variant_id_unique` (`cart_id`,`product_variant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NULL DEFAULT NULL,
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `max_discount` decimal(12,2) NULL DEFAULT NULL,
  `min_purchase` decimal(12,2) NOT NULL DEFAULT '0',
  `quota` int(10) unsigned NULL DEFAULT NULL,
  `used_count` int(10) unsigned NOT NULL DEFAULT '0',
  `per_user_limit` int(10) unsigned NOT NULL DEFAULT '1',
  `new_customer_only` tinyint(1) NOT NULL DEFAULT '0',
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vouchers_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `link_url` varchar(255) NULL DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Halaman profil brand dan informasi (cara belanja, kebijakan)';

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(30) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `address_id` bigint(20) unsigned NULL DEFAULT NULL,
  `voucher_id` bigint(20) unsigned NULL DEFAULT NULL,
  `status` enum('belum_bayar','dikemas','menunggu_pembatalan','dikirim','selesai','dibatalkan','pengembalian','pengembalian_selesai') NOT NULL DEFAULT 'belum_bayar',
  `sub_status` enum('perlu_diproses','telah_diproses') NULL DEFAULT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL COMMENT 'Snapshot alamat saat checkout',
  `shipping_city_id` varchar(20) NOT NULL,
  `shipping_district_id` varchar(20) NULL DEFAULT NULL,
  `shipping_postal_code` varchar(10) NOT NULL,
  `courier_code` varchar(30) NOT NULL,
  `courier_service` varchar(50) NOT NULL,
  `shipping_etd` varchar(30) NULL DEFAULT NULL,
  `shipping_weight_gram` int(10) unsigned NOT NULL COMMENT 'Maks(berat aktual, volumetrik)',
  `subtotal` decimal(12,2) NOT NULL,
  `wholesale_saving` decimal(12,2) NOT NULL DEFAULT '0',
  `voucher_discount` decimal(12,2) NOT NULL DEFAULT '0',
  `shipping_cost` decimal(12,2) NOT NULL,
  `grand_total` decimal(12,2) NOT NULL,
  `customer_note` text NULL DEFAULT NULL,
  `admin_note` text NULL DEFAULT NULL,
  `payment_deadline_at` datetime NOT NULL,
  `paid_at` datetime NULL DEFAULT NULL,
  `ship_deadline_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `shipped_at` datetime NULL DEFAULT NULL,
  `auto_complete_at` datetime NULL DEFAULT NULL,
  `completed_at` datetime NULL DEFAULT NULL,
  `cancelled_at` datetime NULL DEFAULT NULL,
  `cancelled_by` enum('customer','store','system') NULL DEFAULT NULL,
  `cancel_reason` varchar(255) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  KEY `orders_address_id_foreign` (`address_id`),
  CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  KEY `orders_voucher_id_foreign` (`voucher_id`),
  CONSTRAINT `orders_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL,
  KEY `orders_ship_deadline_at_index` (`ship_deadline_at`),
  KEY `orders_status_sub_status_index` (`status`,`sub_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pesanan dengan status ala Shopee';

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `variant_name` varchar(100) NOT NULL,
  `sku` varchar(64) NOT NULL,
  `normal_price` decimal(12,2) NOT NULL,
  `applied_price` decimal(12,2) NOT NULL COMMENT 'Harga satuan yang dipakai',
  `price_type` enum('normal','wholesale','discount') NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `weight_gram` int(10) unsigned NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `voucher_share` decimal(12,2) NOT NULL DEFAULT '0' COMMENT 'Porsi diskon voucher untuk baris ini (proporsional)',
  `returned_qty` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Jumlah yang sudah direfund',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT,
  KEY `order_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Snapshot item pesanan';

DROP TABLE IF EXISTS `order_status_histories`;
CREATE TABLE `order_status_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `from_status` varchar(30) NULL DEFAULT NULL,
  `to_status` varchar(30) NOT NULL,
  `actor_type` enum('customer','owner','staff','system','xendit') NOT NULL,
  `actor_id` bigint(20) unsigned NULL DEFAULT NULL,
  `note` text NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_status_histories_order_id_foreign` (`order_id`),
  CONSTRAINT `order_status_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  KEY `order_status_histories_actor_id_foreign` (`actor_id`),
  CONSTRAINT `order_status_histories_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Timeline status pesanan';

DROP TABLE IF EXISTS `voucher_usages`;
CREATE TABLE `voucher_usages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `voucher_usages_voucher_id_foreign` (`voucher_id`),
  CONSTRAINT `voucher_usages_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE CASCADE,
  KEY `voucher_usages_user_id_foreign` (`user_id`),
  CONSTRAINT `voucher_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `voucher_usages_order_id_unique` (`order_id`),
  CONSTRAINT `voucher_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `external_id` varchar(100) NOT NULL COMMENT 'ID unik yang dikirim ke Xendit',
  `xendit_invoice_id` varchar(100) NULL DEFAULT NULL,
  `invoice_url` text NULL DEFAULT NULL,
  `payment_method` varchar(30) NULL DEFAULT NULL COMMENT 'QRIS / BANK_TRANSFER',
  `payment_channel` varchar(30) NULL DEFAULT NULL COMMENT 'mis. BCA, BRI',
  `amount` decimal(12,2) NOT NULL,
  `gateway_fee` decimal(12,2) NOT NULL DEFAULT '0',
  `status` enum('pending','paid','expired','failed') NOT NULL DEFAULT 'pending',
  `expires_at` datetime NOT NULL,
  `paid_at` datetime NULL DEFAULT NULL,
  `callback_payload` longtext NULL DEFAULT NULL CHECK (json_valid(`callback_payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_order_id_unique` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `payments_external_id_unique` (`external_id`),
  UNIQUE KEY `payments_xendit_invoice_id_unique` (`xendit_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pembayaran via invoice Xendit';

DROP TABLE IF EXISTS `shipments`;
CREATE TABLE `shipments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `courier_code` varchar(30) NOT NULL,
  `courier_name` varchar(50) NOT NULL,
  `service` varchar(50) NOT NULL,
  `tracking_number` varchar(50) NULL DEFAULT NULL,
  `shipping_cost` decimal(12,2) NOT NULL,
  `label_printed_at` datetime NULL DEFAULT NULL,
  `shipped_at` datetime NULL DEFAULT NULL,
  `processed_by` bigint(20) unsigned NULL DEFAULT NULL,
  `shipped_by` bigint(20) unsigned NULL DEFAULT NULL,
  `is_failed_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `failed_at` datetime NULL DEFAULT NULL,
  `failed_note` text NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipments_order_id_unique` (`order_id`),
  CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  KEY `shipments_tracking_number_index` (`tracking_number`),
  KEY `shipments_processed_by_foreign` (`processed_by`),
  CONSTRAINT `shipments_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  KEY `shipments_shipped_by_foreign` (`shipped_by`),
  CONSTRAINT `shipments_shipped_by_foreign` FOREIGN KEY (`shipped_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `order_cancellations`;
CREATE TABLE `order_cancellations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `requested_by` enum('customer','store','system') NOT NULL,
  `requester_id` bigint(20) unsigned NULL DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('menunggu_respons','disetujui','ditolak','ditarik') NOT NULL DEFAULT 'menunggu_respons',
  `respond_deadline_at` datetime NULL DEFAULT NULL,
  `responded_by` bigint(20) unsigned NULL DEFAULT NULL,
  `responded_at` datetime NULL DEFAULT NULL,
  `reject_note` text NULL DEFAULT NULL,
  `refund_bank_name` varchar(50) NULL DEFAULT NULL,
  `refund_account_number` varchar(50) NULL DEFAULT NULL,
  `refund_account_name` varchar(100) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_cancellations_order_id_foreign` (`order_id`),
  CONSTRAINT `order_cancellations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  KEY `order_cancellations_requester_id_foreign` (`requester_id`),
  CONSTRAINT `order_cancellations_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  KEY `order_cancellations_responded_by_foreign` (`responded_by`),
  CONSTRAINT `order_cancellations_responded_by_foreign` FOREIGN KEY (`responded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Permintaan/riwayat pembatalan';

DROP TABLE IF EXISTS `return_requests`;
CREATE TABLE `return_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `request_number` varchar(30) NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` enum('refund_only','return_refund') NOT NULL COMMENT 'Dana saja / barang & dana',
  `reason` enum('rusak','tidak_sesuai','kurang','tidak_diterima','lainnya') NOT NULL,
  `description` text NOT NULL,
  `status` enum('menunggu_respons','menunggu_barang_retur','pemeriksaan_barang','menunggu_transfer','dana_dikembalikan','ditolak','dibatalkan') NOT NULL DEFAULT 'menunggu_respons',
  `refund_bank_name` varchar(50) NOT NULL,
  `refund_account_number` varchar(50) NOT NULL,
  `refund_account_name` varchar(100) NOT NULL,
  `respond_deadline_at` datetime NOT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `return_ship_deadline_at` datetime NULL DEFAULT NULL COMMENT 'Batas kirim barang retur (5 hari)',
  `return_courier` varchar(50) NULL DEFAULT NULL,
  `return_tracking_number` varchar(50) NULL DEFAULT NULL,
  `return_shipping_cost` decimal(12,2) NOT NULL DEFAULT '0' COMMENT 'Ongkir retur pelanggan -> toko, DITANGGUNG TOKO',
  `return_shipping_proof_path` varchar(255) NULL DEFAULT NULL,
  `return_shipped_at` datetime NULL DEFAULT NULL,
  `item_received_at` datetime NULL DEFAULT NULL,
  `inspection_deadline_at` datetime NULL DEFAULT NULL,
  `inspection_result` enum('sesuai','sesuai_sebagian','tidak_sesuai') NULL DEFAULT NULL,
  `inspection_note` text NULL DEFAULT NULL,
  `inspected_at` datetime NULL DEFAULT NULL,
  `refund_type` enum('penuh','sebagian') NULL DEFAULT NULL,
  `recommended_amount` decimal(12,2) NOT NULL DEFAULT '0' COMMENT 'Nominal rekomendasi sistem',
  `approved_amount` decimal(12,2) NULL DEFAULT NULL COMMENT 'Nominal final (<= rekomendasi)',
  `partial_reason` text NULL DEFAULT NULL,
  `reject_reason` text NULL DEFAULT NULL,
  `ship_back_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Barang dikirim balik ke pelanggan bila tidak sesuai',
  `ship_back_cost` decimal(12,2) NOT NULL DEFAULT '0' COMMENT 'Ongkir kirim balik ke pelanggan, DITANGGUNG PEMBELI',
  `ship_back_tracking_number` varchar(50) NULL DEFAULT NULL,
  `ship_back_at` datetime NULL DEFAULT NULL,
  `handled_by` bigint(20) unsigned NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `return_requests_request_number_unique` (`request_number`),
  KEY `return_requests_order_id_foreign` (`order_id`),
  CONSTRAINT `return_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  KEY `return_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `return_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  KEY `return_requests_status_index` (`status`),
  KEY `return_requests_handled_by_foreign` (`handled_by`),
  CONSTRAINT `return_requests_handled_by_foreign` FOREIGN KEY (`handled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pengajuan pengembalian (alur final)';

DROP TABLE IF EXISTS `return_request_items`;
CREATE TABLE `return_request_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `return_request_id` bigint(20) unsigned NOT NULL,
  `order_item_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL COMMENT 'Jumlah diajukan',
  `accepted_qty` int(10) unsigned NULL DEFAULT NULL COMMENT 'Jumlah diterima saat pemeriksaan',
  `unit_refund` decimal(12,2) NOT NULL COMMENT 'Harga dipakai - porsi voucher per unit',
  `line_amount` decimal(12,2) NOT NULL,
  `is_resellable` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_request_items_return_request_id_foreign` (`return_request_id`),
  CONSTRAINT `return_request_items_return_request_id_foreign` FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`) ON DELETE CASCADE,
  KEY `return_request_items_order_item_id_foreign` (`order_item_id`),
  CONSTRAINT `return_request_items_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE RESTRICT,
  UNIQUE KEY `return_request_items_return_request_id_order_item_id_unique` (`return_request_id`,`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `return_evidences`;
CREATE TABLE `return_evidences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `return_request_id` bigint(20) unsigned NOT NULL,
  `stage` enum('pengajuan','pemeriksaan') NOT NULL,
  `uploaded_by` bigint(20) unsigned NULL DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('image','video') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_evidences_return_request_id_foreign` (`return_request_id`),
  CONSTRAINT `return_evidences_return_request_id_foreign` FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`) ON DELETE CASCADE,
  KEY `return_evidences_uploaded_by_foreign` (`uploaded_by`),
  CONSTRAINT `return_evidences_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bukti foto/video pelanggan dan hasil pemeriksaan toko';

DROP TABLE IF EXISTS `return_status_histories`;
CREATE TABLE `return_status_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `return_request_id` bigint(20) unsigned NOT NULL,
  `from_status` varchar(30) NULL DEFAULT NULL,
  `to_status` varchar(30) NOT NULL,
  `actor_type` enum('customer','owner','staff','system','xendit') NOT NULL,
  `actor_id` bigint(20) unsigned NULL DEFAULT NULL,
  `note` text NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `return_status_histories_return_request_id_foreign` (`return_request_id`),
  CONSTRAINT `return_status_histories_return_request_id_foreign` FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`) ON DELETE CASCADE,
  KEY `return_status_histories_actor_id_foreign` (`actor_id`),
  CONSTRAINT `return_status_histories_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Timeline pengembalian yang dilihat pelanggan';

DROP TABLE IF EXISTS `refunds`;
CREATE TABLE `refunds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `refund_number` varchar(30) NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `source_type` enum('cancellation','return','failed_delivery') NOT NULL,
  `source_key` varchar(60) NOT NULL COMMENT 'cancellation:{id} / return:{id} / failed_delivery:{order_id}; mencegah refund ganda',
  `order_cancellation_id` bigint(20) unsigned NULL DEFAULT NULL,
  `return_request_id` bigint(20) unsigned NULL DEFAULT NULL,
  `product_amount` decimal(12,2) NOT NULL DEFAULT '0',
  `shipping_amount` decimal(12,2) NOT NULL DEFAULT '0' COMMENT 'Ongkir awal yang dikembalikan',
  `return_shipping_amount` decimal(12,2) NOT NULL DEFAULT '0' COMMENT 'Penggantian ongkir retur (ditanggung toko)',
  `total_amount` decimal(12,2) NOT NULL,
  `status` enum('menunggu_transfer','dana_dikembalikan') NOT NULL DEFAULT 'menunggu_transfer',
  `dest_bank_name` varchar(50) NOT NULL,
  `dest_account_number` varchar(50) NOT NULL,
  `dest_account_name` varchar(100) NOT NULL,
  `transfer_deadline_at` datetime NOT NULL COMMENT '2x24 jam sejak status Menunggu Transfer',
  `store_bank_account` varchar(150) NULL DEFAULT NULL,
  `transfer_date` date NULL DEFAULT NULL,
  `proof_path` varchar(255) NULL DEFAULT NULL,
  `recorded_by` bigint(20) unsigned NULL DEFAULT NULL,
  `recorded_at` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `refunds_refund_number_unique` (`refund_number`),
  KEY `refunds_order_id_foreign` (`order_id`),
  CONSTRAINT `refunds_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT,
  UNIQUE KEY `refunds_source_key_unique` (`source_key`),
  KEY `refunds_order_cancellation_id_foreign` (`order_cancellation_id`),
  CONSTRAINT `refunds_order_cancellation_id_foreign` FOREIGN KEY (`order_cancellation_id`) REFERENCES `order_cancellations` (`id`) ON DELETE RESTRICT,
  KEY `refunds_return_request_id_foreign` (`return_request_id`),
  CONSTRAINT `refunds_return_request_id_foreign` FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`) ON DELETE RESTRICT,
  KEY `refunds_status_index` (`status`),
  KEY `refunds_recorded_by_foreign` (`recorded_by`),
  CONSTRAINT `refunds_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Refund manual; satu sumber hanya boleh satu refund';

DROP TABLE IF EXISTS `refund_corrections`;
CREATE TABLE `refund_corrections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` bigint(20) unsigned NOT NULL,
  `old_total` decimal(12,2) NOT NULL,
  `new_total` decimal(12,2) NOT NULL,
  `difference` decimal(12,2) NOT NULL,
  `reason` text NOT NULL,
  `proof_path` varchar(255) NULL DEFAULT NULL,
  `corrected_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `refund_corrections_refund_id_foreign` (`refund_id`),
  CONSTRAINT `refund_corrections_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `refunds` (`id`) ON DELETE CASCADE,
  KEY `refund_corrections_corrected_by_foreign` (`corrected_by`),
  CONSTRAINT `refund_corrections_corrected_by_foreign` FOREIGN KEY (`corrected_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Koreksi refund dengan jejak audit (tanpa menghapus data lama)';

DROP TABLE IF EXISTS `financial_entries`;
CREATE TABLE `financial_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `entry_date` date NOT NULL,
  `type` enum('penjualan','ongkir','biaya_gateway','refund_produk','refund_ongkir','ongkir_retur','koreksi_refund') NOT NULL,
  `amount` decimal(14,2) NOT NULL COMMENT 'Positif = masuk, negatif = keluar',
  `order_id` bigint(20) unsigned NULL DEFAULT NULL,
  `refund_id` bigint(20) unsigned NULL DEFAULT NULL,
  `source_key` varchar(80) NOT NULL COMMENT 'mis. order:12:penjualan; mencegah pencatatan ganda',
  `description` varchar(255) NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `financial_entries_entry_date_index` (`entry_date`),
  KEY `financial_entries_order_id_foreign` (`order_id`),
  CONSTRAINT `financial_entries_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT,
  KEY `financial_entries_refund_id_foreign` (`refund_id`),
  CONSTRAINT `financial_entries_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `refunds` (`id`) ON DELETE RESTRICT,
  UNIQUE KEY `financial_entries_source_key_unique` (`source_key`),
  KEY `financial_entries_created_by_foreign` (`created_by`),
  CONSTRAINT `financial_entries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Buku kas sederhana untuk ringkasan omzet';

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `comment` text NULL DEFAULT NULL,
  `seller_reply` text NULL DEFAULT NULL,
  `replied_at` datetime NULL DEFAULT NULL,
  `replied_by` bigint(20) unsigned NULL DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_order_item_id_unique` (`order_item_id`),
  CONSTRAINT `reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  KEY `reviews_replied_by_foreign` (`replied_by`),
  CONSTRAINT `reviews_replied_by_foreign` FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `review_images`;
CREATE TABLE `review_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `review_id` bigint(20) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_images_review_id_foreign` (`review_id`),
  CONSTRAINT `review_images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `stock_movements`;
CREATE TABLE `stock_movements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `type` enum('reserve','release','sale_out','return_in','restock','adjustment') NOT NULL,
  `qty_change` int(11) NOT NULL DEFAULT '0' COMMENT 'Perubahan stok fisik (+/-)',
  `reserved_change` int(11) NOT NULL DEFAULT '0',
  `stock_after` int(10) unsigned NOT NULL,
  `reserved_after` int(10) unsigned NOT NULL,
  `reference_type` varchar(50) NULL DEFAULT NULL,
  `reference_id` bigint(20) unsigned NULL DEFAULT NULL,
  `note` varchar(255) NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `stock_movements_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `stock_movements_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  KEY `stock_movements_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  KEY `stock_movements_product_variant_id_created_at_index` (`product_variant_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Kartu stok';

DROP TABLE IF EXISTS `stock_alerts`;
CREATE TABLE `stock_alerts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `stock_at_alert` int(10) unsigned NOT NULL,
  `status` enum('open','resolved') NOT NULL DEFAULT 'open',
  `sent_at` datetime NOT NULL,
  `resolved_at` datetime NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_alerts_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `stock_alerts_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cost_comparisons`;
CREATE TABLE `cost_comparisons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `period` varchar(7) NOT NULL COMMENT 'YYYY-MM',
  `website_fixed_cost` decimal(12,2) NOT NULL,
  `gateway_fee_total` decimal(12,2) NOT NULL,
  `transaction_count` int(10) unsigned NOT NULL,
  `net_revenue` decimal(14,2) NOT NULL,
  `marketplace_fee_percent` decimal(5,2) NOT NULL,
  `cost_per_transaction` decimal(12,2) NOT NULL,
  `website_cost_percent` decimal(5,2) NOT NULL,
  `note` text NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cost_comparisons_period_unique` (`period`),
  KEY `cost_comparisons_created_by_foreign` (`created_by`),
  CONSTRAINT `cost_comparisons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Perbandingan biaya website vs marketplace per bulan';

SET FOREIGN_KEY_CHECKS = 1;
