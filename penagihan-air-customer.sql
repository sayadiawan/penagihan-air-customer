-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Feb 2023 pada 12.59
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penagihan-air-customer`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id_menus` char(36) NOT NULL,
  `upid_menus` char(36) DEFAULT '0',
  `code_menus` char(15) NOT NULL,
  `name_menus` varchar(100) NOT NULL,
  `link_menus` varchar(255) NOT NULL,
  `description_menus` text DEFAULT NULL,
  `icon_menus` varchar(50) NOT NULL,
  `action_menus` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id_menus`, `upid_menus`, `code_menus`, `name_menus`, `link_menus`, `description_menus`, `icon_menus`, `action_menus`, `created_at`, `updated_at`, `deleted_at`) VALUES
('32d2e1a8-ec96-44c7-885c-21f456b085ff', '9a7773d3-d090-4586-86eb-4a8c3804d199', 'MDPA', 'Data Profile Company', 'profile-company', 'Menu ini berisikan data area seperti contoh profile area dengan nama RW atau Rukun Warga bahkan bisa mengacu komplek', 'fas fa-chalkboard-teacher', 'create,read,update,delete,list', '2023-02-09 06:27:00', '2023-02-09 16:32:24', NULL),
('51bebdc8-28df-4159-8fe4-7833c493431e', '0', 'MOD', 'Data  Menu', 'menus', 'Data menus sistem', 'fa fa-list', 'create,read,update,delete,list,export,import', '2022-10-15 15:02:00', NULL, NULL),
('618019ac-8035-40e1-9bac-d747bb406145', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', 'PRIV', 'Role Akses', 'roles', 'Digunakan untuk mengatur hak akses pengguna', 'fa fa-cog', 'create,update,delete,read,detail,list,roles', '2022-10-15 15:02:00', NULL, NULL),
('92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', '0', 'USM', 'User Management', 'user-management', '', 'fa fa-users', 'read,list', '2022-10-15 15:02:00', NULL, NULL),
('9a7773d3-d090-4586-86eb-4a8c3804d199', '0', 'MSD', 'Master Data', 'master-data', '', 'fa fa-cubes', 'list,read', '2022-10-15 15:02:00', NULL, NULL),
('d1426653-826a-47aa-9920-d7fc5dab4c05', '0', 'HOME', 'Dashboard', 'home', '', 'fa fa-home', 'list,read', '2022-10-15 15:02:00', NULL, NULL),
('fca27393-2694-49ee-8bae-d457c9f5eaf9', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', 'USR', 'Data Pengguna', 'user', '', 'fa fa-user', 'create,read,update,delete,import,export,detail,reset', '2022-10-15 15:02:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2017_05_02_140432_create_provinces_tables', 2),
(6, '2017_05_02_140444_create_regencies_tables', 2),
(7, '2017_05_02_142019_create_districts_tables', 2),
(8, '2017_05_02_143454_create_villages_tables', 2),
(9, '2022_12_11_123220_create_province_raja_ongkirs_table', 3),
(10, '2022_12_11_123238_create_city_raja_ongkirs_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_companys`
--

CREATE TABLE `profile_companys` (
  `id_profile_companys` char(36) NOT NULL,
  `name_profile_companys` varchar(100) DEFAULT NULL,
  `penanggungjawab_profile_companys` char(36) DEFAULT NULL,
  `logo_profile_companys` text DEFAULT NULL,
  `type_kop_profile_companys` enum('IMAGE','TEXT') NOT NULL DEFAULT 'TEXT',
  `kop_image_profile_companys` text DEFAULT NULL,
  `kop_text_profile_companys` text DEFAULT NULL,
  `address_profile_companys` text DEFAULT NULL,
  `kelurahan_profile_companys` varchar(100) DEFAULT NULL,
  `kecamataan_profile_companys` varchar(100) DEFAULT NULL,
  `kota_profile_companys` varchar(100) DEFAULT NULL,
  `provinsi_profile_companys` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profile_companys`
--

INSERT INTO `profile_companys` (`id_profile_companys`, `name_profile_companys`, `penanggungjawab_profile_companys`, `logo_profile_companys`, `type_kop_profile_companys`, `kop_image_profile_companys`, `kop_text_profile_companys`, `address_profile_companys`, `kelurahan_profile_companys`, `kecamataan_profile_companys`, `kota_profile_companys`, `provinsi_profile_companys`, `created_at`, `updated_at`, `deleted_at`) VALUES
('7a9355b5-f8aa-4d47-8d75-f58e98dd9d1a', NULL, NULL, NULL, 'TEXT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-09 11:58:05', '2023-02-09 18:58:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_company_banks`
--

CREATE TABLE `profile_company_banks` (
  `id_profile_company_banks` char(36) NOT NULL,
  `profile_companys_id` char(36) NOT NULL,
  `bankname_profile_company_banks` varchar(100) NOT NULL,
  `accountname_profile_company_banks` varchar(100) NOT NULL,
  `accountnumber_profile_company_banks` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profile_company_banks`
--

INSERT INTO `profile_company_banks` (`id_profile_company_banks`, `profile_companys_id`, `bankname_profile_company_banks`, `accountname_profile_company_banks`, `accountnumber_profile_company_banks`, `created_at`, `updated_at`, `deleted_at`) VALUES
('18215764-46fa-41cf-b5fa-23126d55955f', '7a9355b5-f8aa-4d47-8d75-f58e98dd9d1a', 'BCA', 'Budi', '01234567', '2023-02-09 11:58:05', '2023-02-09 18:58:05', NULL),
('6202e225-f4ea-4a57-b414-75f04d55c0ae', '7a9355b5-f8aa-4d47-8d75-f58e98dd9d1a', 'mandiri', 'Duki', '3123333', '2023-02-09 11:58:05', '2023-02-09 18:58:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_company_contact_details`
--

CREATE TABLE `profile_company_contact_details` (
  `id_profile_company_contact_details` char(36) NOT NULL,
  `profile_companys_id` char(36) NOT NULL,
  `name_profile_company_contact_details` varchar(100) NOT NULL,
  `phone_profile_company_contact_details` varchar(16) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id_roles` char(36) NOT NULL,
  `code_roles` char(16) NOT NULL,
  `name_roles` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id_roles`, `code_roles`, `name_roles`, `created_at`, `updated_at`, `deleted_at`) VALUES
('8b61213d-9521-40a4-8b17-fda810228b54', 'SAS', 'Super Admin', '2022-10-15 14:51:44', NULL, NULL),
('aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', 'ADM', 'Admin', '2022-10-15 14:51:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `avatar_originalfile` varchar(255) DEFAULT NULL,
  `avatar_originalmimetype` varchar(50) DEFAULT NULL,
  `avatar_mimetype` varchar(50) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `roles_id` char(36) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `phone`, `email_verified_at`, `password`, `avatar`, `avatar_originalfile`, `avatar_originalmimetype`, `avatar_mimetype`, `remember_token`, `roles_id`, `is_publish`, `created_at`, `updated_at`, `deleted_at`) VALUES
('ce6c6103-7ccc-4e17-b453-8415b3d9908b', 'Super Admin', 'pinginresign@gmail.com', 'superadmin', '081362867034', NULL, '$2y$10$RwDwoFpzc99JpZvho0eBpuqzuBe2dzNHB58DkUP3YljGQkWfRGtXK', 'user-avatar/1pdhQoB4ElBmXsKGkomwgg6CZojUDLixB9685r8l.jpg', '32745128.jfif', 'jfif', 'image/jpeg', 'ewDaIezae0uTFDa4sZgEUAxs08TOzjHYVo1QchzKV7PbVXEf5n20gQ8JdacV', '8b61213d-9521-40a4-8b17-fda810228b54', 1, NULL, '2023-02-06 16:04:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_as_citizen_details`
--

CREATE TABLE `user_as_citizen_details` (
  `id_user_as_citizen_details` char(36) NOT NULL,
  `users_id` char(36) NOT NULL,
  `norumah_user_as_citizen_details` varchar(50) NOT NULL,
  `rt_user_as_citizen_details` int(11) NOT NULL,
  `rw_user_as_citizen_details` int(11) NOT NULL,
  `address_user_as_citizen_details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu_authorizations`
--

CREATE TABLE `user_menu_authorizations` (
  `id_user_menu_authorizations` char(36) NOT NULL,
  `roles_id` char(36) NOT NULL,
  `menus_id` char(36) NOT NULL,
  `action_user_menu_authorizations` mediumtext DEFAULT NULL,
  `publish_user_menu_authorizations` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_menu_authorizations`
--

INSERT INTO `user_menu_authorizations` (`id_user_menu_authorizations`, `roles_id`, `menus_id`, `action_user_menu_authorizations`, `publish_user_menu_authorizations`, `created_at`, `updated_at`) VALUES
('02df9660-764c-44ec-9bfe-c87fa89a8772', 'f87ee4f8-424e-451e-9304-7730baed289a', 'b95fa7a3-dc67-4f64-bafd-1e03356b8017', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('0328df74-77b9-49b9-af84-a7de1cf3fff1', 'f87ee4f8-424e-451e-9304-7730baed289a', '1e8ac366-a23b-4931-a98e-ef8188cbe881', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('08fde791-aa4a-4773-bd66-a2ba0dcecfb2', '8b61213d-9521-40a4-8b17-fda810228b54', '8b088a91-2b25-4416-bbf2-a080a3f83f2b', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('0931a988-2cc3-4d19-8c22-cf88bba9a8f2', 'f87ee4f8-424e-451e-9304-7730baed289a', 'f837425e-3d1a-4bbe-b536-d7ad41a1c7c5', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('09add454-37b0-40cd-8247-1411bba309db', 'f87ee4f8-424e-451e-9304-7730baed289a', '618019ac-8035-40e1-9bac-d747bb406145', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('0c3cfc30-87b4-48d2-85e1-7df0f262c3bb', 'aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', 'd1426653-826a-47aa-9920-d7fc5dab4c05', 'read,list', 1, '2023-01-28 11:13:08', '2023-01-28 18:13:08'),
('0cf01b1c-4fa5-4bd6-ba3a-d666538b7573', 'f87ee4f8-424e-451e-9304-7730baed289a', 'fca27393-2694-49ee-8bae-d457c9f5eaf9', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('0d5078be-3756-4289-8ac4-6ac7bd1ad8f3', '8b61213d-9521-40a4-8b17-fda810228b54', '10cf7185-d3b0-4abb-9224-dd08423576b2', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('0f29c550-5089-11ed-92cc-54e1ad1481c6', '8b61213d-9521-40a4-8b17-fda810228b54', '618019ac-8035-40e1-9bac-d747bb406145', 'create,update,delete,read,detail,list,roles', 1, '2022-10-20 15:08:31', '2022-10-20 17:07:36'),
('12dd1061-3a6e-4b7d-946e-b8831ed79b8e', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '694fa76f-f4c8-45bc-a9c4-709cb3f65109', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('144b0e8a-209a-41b7-ab6d-839a84c85e40', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '1e8ac366-a23b-4931-a98e-ef8188cbe881', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('15653421-940e-4ac5-992f-95ef4047eb8c', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'f537f8c5-5624-424d-ae9b-2abd9f84bc6e', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('1778a948-0693-4f6f-abf2-e1a2cce513a3', 'aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', '51bebdc8-28df-4159-8fe4-7833c493431e', NULL, 0, '2023-01-28 11:13:08', '2023-01-28 18:13:08'),
('18c07b2a-e971-4d98-836f-dbeddf6daefa', '8b61213d-9521-40a4-8b17-fda810228b54', '943a16fa-dd82-4b26-bd35-997dda9f4cc5', 'create,update,delete,list,read', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('1957ba12-8996-4d08-80cf-ee6cf5a02851', '8b61213d-9521-40a4-8b17-fda810228b54', '49c6176a-6919-4cdd-aaa2-aa6d416c815e', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('1a6b2ff7-c79f-4243-b1b6-1e3ac761491d', '8b61213d-9521-40a4-8b17-fda810228b54', 'cec11661-422d-4dd1-8054-4bf870d243c5', 'list,read', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('1a8c18dc-1944-4fb8-bafc-20960590359a', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '4f259f87-40bb-4bf0-b9d7-226413507afa', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('1ca1e992-2c64-4b25-b7e5-1fe8a20c6e5e', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '53a5f551-ce93-4f8c-940c-fe9da855539b', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('1e435919-dbff-4e75-91d5-5b1416e60eba', '8b61213d-9521-40a4-8b17-fda810228b54', '01c0acd5-2e17-460b-be21-d022511249eb', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('20a8a5ec-c99a-4049-97e7-ea6a0738c0bc', 'f87ee4f8-424e-451e-9304-7730baed289a', '28bfa6ea-3aa1-404a-abb7-6272ad2d72e2', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('217f378d-c77a-4005-b576-c782279240aa', '8b61213d-9521-40a4-8b17-fda810228b54', 'c2d7cd25-4fd0-4885-98b2-649e7a10aa09', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('219cbdc1-37a7-4811-bbfc-7ebfc7b14d5e', '8b61213d-9521-40a4-8b17-fda810228b54', 'a903a3ed-0486-4a66-9183-751ba4028f31', 'read,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('24ffc76d-9f35-407c-8c07-7092454d9314', '8b61213d-9521-40a4-8b17-fda810228b54', 'c230f0f2-f8a0-4e37-865e-1b6c676afd65', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('292f17f1-2147-4b83-81ca-5691a50a3d4c', '8b61213d-9521-40a4-8b17-fda810228b54', '694fa76f-f4c8-45bc-a9c4-709cb3f65109', 'create,read,update,delete,list', 0, '2022-11-26 15:57:27', '2023-01-11 21:36:17'),
('2b0a2041-85ca-4968-bf4e-8630ec9cc5c2', '8b61213d-9521-40a4-8b17-fda810228b54', 'da6f749f-b616-4516-b016-3d9fa75c0909', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('2c45d7b8-62e4-4023-a56a-14795b490a03', 'f87ee4f8-424e-451e-9304-7730baed289a', '8b088a91-2b25-4416-bbf2-a080a3f83f2b', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('302a09d0-cf88-485b-b058-dbad5ced9c57', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'fca27393-2694-49ee-8bae-d457c9f5eaf9', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('31bcfc75-7067-459e-b510-9e5a5ee983ef', 'f87ee4f8-424e-451e-9304-7730baed289a', '46580cff-48e7-4ddd-8454-0d37b2e33a8d', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('351133b8-e654-41d1-acb8-5adf894d32ef', 'f87ee4f8-424e-451e-9304-7730baed289a', '53a5f551-ce93-4f8c-940c-fe9da855539b', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('39b538b4-d793-44ff-802f-2accd69064f0', '8b61213d-9521-40a4-8b17-fda810228b54', '9a7773d3-d090-4586-86eb-4a8c3804d199', 'list,read', 1, '2021-12-22 23:03:58', '2021-12-23 06:03:58'),
('3c52c669-bbcc-49db-848d-3323087c15ea', 'f87ee4f8-424e-451e-9304-7730baed289a', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('3f82af51-f0db-47db-ae8c-e12f33ef642f', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'cec11661-422d-4dd1-8054-4bf870d243c5', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('476ef74e-4140-477f-a7de-97c0fac3dd9d', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '49c6176a-6919-4cdd-aaa2-aa6d416c815e', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('4c77fc0f-8a13-4089-ad43-5e12f770c50d', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '51bebdc8-28df-4159-8fe4-7833c493431e', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('4d8367dc-2374-4fb2-86b3-1c2797744f6c', 'f87ee4f8-424e-451e-9304-7730baed289a', '4f259f87-40bb-4bf0-b9d7-226413507afa', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('4dfeec35-0c97-4219-af08-fcad6f9ad3b7', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '46580cff-48e7-4ddd-8454-0d37b2e33a8d', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('51082609-5a51-4378-8e05-8634a0179925', 'f87ee4f8-424e-451e-9304-7730baed289a', '01c0acd5-2e17-460b-be21-d022511249eb', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('567e0191-fbe5-43d0-af18-693409ed771b', '8b61213d-9521-40a4-8b17-fda810228b54', 'b95fa7a3-dc67-4f64-bafd-1e03356b8017', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('5ac51dab-3bc6-4bd1-943c-9ea7acc7827c', 'aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', NULL, 0, '2023-01-28 11:13:08', '2023-01-28 18:13:08'),
('5f2d325a-c5f8-4077-9ddd-b58f1497de78', '8b61213d-9521-40a4-8b17-fda810228b54', 'f563c20b-a3bb-4883-9730-7078402e53b6', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('5f53dae5-0d33-4523-a342-78025314fcdb', 'f87ee4f8-424e-451e-9304-7730baed289a', 'c230f0f2-f8a0-4e37-865e-1b6c676afd65', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('62ed409d-9c41-4063-95b6-2dfabd993a38', 'aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', '9a7773d3-d090-4586-86eb-4a8c3804d199', 'read,list', 1, '2023-01-28 11:13:08', '2023-01-28 18:13:08'),
('664ee26f-eb28-416f-a83d-91ef3951fede', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'e4837062-2ee2-477f-bcba-0a62cb9cb6fb', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('66888d6b-8965-4f1a-8420-84e4bb792901', '8b61213d-9521-40a4-8b17-fda810228b54', '46580cff-48e7-4ddd-8454-0d37b2e33a8d', 'create,read,update,delete,list', 1, '2022-12-11 08:22:23', '2022-12-11 15:22:23'),
('6a1df376-4cd8-4d33-9f24-4a0341ea31f4', '8b61213d-9521-40a4-8b17-fda810228b54', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', 'list,read', 1, '2021-08-12 20:13:51', '2021-08-13 03:13:51'),
('6b09e245-5f3d-4619-816b-90ec768ca93d', 'f87ee4f8-424e-451e-9304-7730baed289a', 'cec11661-422d-4dd1-8054-4bf870d243c5', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('6d14a670-fc34-469d-9547-9130886ea450', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '10cf7185-d3b0-4abb-9224-dd08423576b2', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('6d940635-e0b8-41fa-8052-052b8e65a87a', '8b61213d-9521-40a4-8b17-fda810228b54', '53a5f551-ce93-4f8c-940c-fe9da855539b', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('6e2a2e5b-471a-4a96-8fbd-647237121fb7', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'd1426653-826a-47aa-9920-d7fc5dab4c05', 'read,list', 1, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('6f6c2c5b-f018-4192-ab29-93425c5e7c2f', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '973b4e68-9a0f-4240-81d9-5bdcd70ca415', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('70525d8a-0d43-41ad-afe0-763463d7fb17', 'f87ee4f8-424e-451e-9304-7730baed289a', '9a7773d3-d090-4586-86eb-4a8c3804d199', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('70e2e876-14ad-468c-aa84-d878c3ba8653', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '943a16fa-dd82-4b26-bd35-997dda9f4cc5', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('721af406-711a-4025-b70c-e69a1b983514', 'f87ee4f8-424e-451e-9304-7730baed289a', '10cf7185-d3b0-4abb-9224-dd08423576b2', 'create,read,update,delete,list', 1, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('734d181e-228b-45eb-86ca-fb0f003ea5e1', '8b61213d-9521-40a4-8b17-fda810228b54', '4f259f87-40bb-4bf0-b9d7-226413507afa', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('76365a7a-8af2-441b-9dd1-1217afce1440', 'f87ee4f8-424e-451e-9304-7730baed289a', 'd1426653-826a-47aa-9920-d7fc5dab4c05', 'read,list', 1, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('766e6848-d97a-48f1-92b8-c7ebac37e0c5', '8b61213d-9521-40a4-8b17-fda810228b54', 'd1426653-826a-47aa-9920-d7fc5dab4c05', 'list', 1, '2021-06-26 10:34:47', '2022-10-22 00:03:24'),
('77910712-5ead-4a7b-8091-74c526fbb534', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'c0a55f27-9b79-4c7e-947b-8083a1a5a4c3', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('7940711d-1238-4cfc-a697-2864578a359c', '8b61213d-9521-40a4-8b17-fda810228b54', '21a957e8-384e-489a-8b60-313b077b9e0c', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('80eabf23-a496-475f-a53f-720ffc54c561', 'f87ee4f8-424e-451e-9304-7730baed289a', 'f537f8c5-5624-424d-ae9b-2abd9f84bc6e', 'create,read,update,delete,list', 1, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('8647fcf5-d829-4147-9cd6-0fa4ffb28a60', '8b61213d-9521-40a4-8b17-fda810228b54', 'fca27393-2694-49ee-8bae-d457c9f5eaf9', 'list,read,update,delete,detail,create,reset', 1, '2021-06-30 23:33:47', '2021-12-23 07:42:18'),
('8a81a9f6-015f-4305-af6e-c55915422f07', 'f87ee4f8-424e-451e-9304-7730baed289a', '51bebdc8-28df-4159-8fe4-7833c493431e', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('8cb0cf0f-70c1-4ce3-bbd1-d3d9d98ef382', 'f87ee4f8-424e-451e-9304-7730baed289a', '21a957e8-384e-489a-8b60-313b077b9e0c', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('8e9f5652-aaea-41c5-8c79-fb15fbc48070', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'da6f749f-b616-4516-b016-3d9fa75c0909', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('8ee1b8bc-ee18-4124-8fe2-63e7cea8e534', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '01c0acd5-2e17-460b-be21-d022511249eb', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('97e232b7-b969-445b-abec-a578e2405858', '8b61213d-9521-40a4-8b17-fda810228b54', 'f537f8c5-5624-424d-ae9b-2abd9f84bc6e', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('a0660bd1-0a50-4bcc-971f-e1d4bf288608', 'f87ee4f8-424e-451e-9304-7730baed289a', '943a16fa-dd82-4b26-bd35-997dda9f4cc5', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('ab7f94ad-eeec-49b8-a0e6-ebaaf9b049e1', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '28bfa6ea-3aa1-404a-abb7-6272ad2d72e2', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('af0a1b22-eb63-4ab8-b52d-1f9ed7efdd4c', '8b61213d-9521-40a4-8b17-fda810228b54', '28bfa6ea-3aa1-404a-abb7-6272ad2d72e2', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('b2ccda67-0e90-4dcc-a6bc-c14b19905d05', 'f87ee4f8-424e-451e-9304-7730baed289a', 'c2d7cd25-4fd0-4885-98b2-649e7a10aa09', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('b2da6d06-ce31-4414-a0b0-1276b7061c13', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('b64b4d81-4aef-4b78-87f7-47a2a8fc4174', 'f87ee4f8-424e-451e-9304-7730baed289a', 'a903a3ed-0486-4a66-9183-751ba4028f31', 'read,list', 1, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('b6937646-0491-4166-8c85-be8420e95f4d', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'b95fa7a3-dc67-4f64-bafd-1e03356b8017', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('b7d1e1fa-9f2b-4fe0-aa4a-375941221110', 'f87ee4f8-424e-451e-9304-7730baed289a', '49c6176a-6919-4cdd-aaa2-aa6d416c815e', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('c2af5f4d-9a91-41b8-a1fb-317394c135c9', 'f87ee4f8-424e-451e-9304-7730baed289a', 'c0a55f27-9b79-4c7e-947b-8083a1a5a4c3', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('c4fdc901-e96a-4b62-b6d0-f08e15412461', 'aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', 'fca27393-2694-49ee-8bae-d457c9f5eaf9', NULL, 0, '2023-01-28 11:13:08', '2023-01-28 18:13:08'),
('c51e4ed8-dacf-4549-a3fd-8bad2f637d5a', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '8b088a91-2b25-4416-bbf2-a080a3f83f2b', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('c9a81121-eb32-40d8-837d-671ff1a19f68', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'c2d7cd25-4fd0-4885-98b2-649e7a10aa09', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('cb8a5827-bb62-42dc-aa13-bb2b9e41fa05', 'f87ee4f8-424e-451e-9304-7730baed289a', '694fa76f-f4c8-45bc-a9c4-709cb3f65109', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('ccc5a9a0-0ba0-48be-a95c-7de35c8320c1', '8b61213d-9521-40a4-8b17-fda810228b54', '973b4e68-9a0f-4240-81d9-5bdcd70ca415', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('ccf49f04-abe2-4c84-9d60-1f83bb8a9ea9', 'aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', '618019ac-8035-40e1-9bac-d747bb406145', NULL, 0, '2023-01-28 11:13:08', '2023-01-28 18:13:08'),
('d6c61477-6cc2-44d0-9ac9-1cb89fbadbcd', '8b61213d-9521-40a4-8b17-fda810228b54', 'e4837062-2ee2-477f-bcba-0a62cb9cb6fb', 'read,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('d6d3ff81-0b88-40c0-86d9-6ac802f62de1', '8b61213d-9521-40a4-8b17-fda810228b54', '1e8ac366-a23b-4931-a98e-ef8188cbe881', 'read,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('d70424f9-99f5-4b44-9f74-bc4a14ba2732', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '618019ac-8035-40e1-9bac-d747bb406145', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('d813a41b-c01c-478c-a507-978e5dcb3659', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'a903a3ed-0486-4a66-9183-751ba4028f31', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('db96cd56-76eb-4f63-88bc-2bda14e3a114', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'f837425e-3d1a-4bbe-b536-d7ad41a1c7c5', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('df2e82d8-1506-42b9-86a9-2934d2227761', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '21a957e8-384e-489a-8b60-313b077b9e0c', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('e045b19a-d402-47a8-879c-72aff7f95513', 'f87ee4f8-424e-451e-9304-7730baed289a', '973b4e68-9a0f-4240-81d9-5bdcd70ca415', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('e585d9d2-8285-4bef-8a44-11a6fc701aae', '8b61213d-9521-40a4-8b17-fda810228b54', '32d2e1a8-ec96-44c7-885c-21f456b085ff', 'create,read,update,delete,list', 1, '2023-02-09 06:27:50', '2023-02-09 13:27:50'),
('e5b4699b-9bde-40fa-87a9-1fe8402bb453', 'f87ee4f8-424e-451e-9304-7730baed289a', 'da6f749f-b616-4516-b016-3d9fa75c0909', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('e73c536b-8200-4ccc-a872-977e469ccbd1', '8b61213d-9521-40a4-8b17-fda810228b54', '51bebdc8-28df-4159-8fe4-7833c493431e', 'create,update,delete,read,export,import,list', 1, '2021-06-30 23:33:47', '2021-12-16 03:42:45'),
('eac3a443-9e56-4b20-8675-923649e46fcb', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '9a7773d3-d090-4586-86eb-4a8c3804d199', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('f47dcd59-d64c-4381-b519-8653e005c39c', 'f87ee4f8-424e-451e-9304-7730baed289a', 'f563c20b-a3bb-4883-9730-7078402e53b6', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('f9527466-8e08-470f-841e-573cbcd7ce75', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'c230f0f2-f8a0-4e37-865e-1b6c676afd65', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('f9f36072-9b4a-4dc8-8baf-c47aeacec67c', '8b61213d-9521-40a4-8b17-fda810228b54', 'c0a55f27-9b79-4c7e-947b-8083a1a5a4c3', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('fb77c684-0dad-41f7-ae1c-bb2028860b18', '8b61213d-9521-40a4-8b17-fda810228b54', 'f837425e-3d1a-4bbe-b536-d7ad41a1c7c5', 'create,read,update,delete,list', 0, '2022-11-26 15:57:27', '2023-01-11 21:36:17'),
('fe586209-686c-40f5-b47d-6cb358bec58f', 'f87ee4f8-424e-451e-9304-7730baed289a', 'e4837062-2ee2-477f-bcba-0a62cb9cb6fb', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('fed752ff-48c2-4201-8aac-e7633284a6bc', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'f563c20b-a3bb-4883-9730-7078402e53b6', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menus`),
  ADD KEY `upid_menus` (`upid_menus`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `profile_companys`
--
ALTER TABLE `profile_companys`
  ADD PRIMARY KEY (`id_profile_companys`);

--
-- Indeks untuk tabel `profile_company_banks`
--
ALTER TABLE `profile_company_banks`
  ADD PRIMARY KEY (`id_profile_company_banks`);

--
-- Indeks untuk tabel `profile_company_contact_details`
--
ALTER TABLE `profile_company_contact_details`
  ADD PRIMARY KEY (`id_profile_company_contact_details`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `user_as_citizen_details`
--
ALTER TABLE `user_as_citizen_details`
  ADD PRIMARY KEY (`id_user_as_citizen_details`);

--
-- Indeks untuk tabel `user_menu_authorizations`
--
ALTER TABLE `user_menu_authorizations`
  ADD PRIMARY KEY (`id_user_menu_authorizations`),
  ADD KEY `roles_id` (`roles_id`,`menus_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
