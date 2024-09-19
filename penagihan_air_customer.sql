-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 07:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `city_raja_ongkirs`
--

CREATE TABLE `city_raja_ongkirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id_customers` char(36) NOT NULL,
  `users_id` char(36) NOT NULL,
  `norumah_customers` varchar(50) NOT NULL,
  `rt_customers` int(11) NOT NULL,
  `rw_customers` int(11) NOT NULL,
  `address_customers` text NOT NULL,
  `tarif` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id_customers`, `users_id`, `norumah_customers`, `rt_customers`, `rw_customers`, `address_customers`, `tarif`, `created_at`, `updated_at`, `deleted_at`) VALUES
('14b4cb87-d0ab-47b6-b230-086e620ddd04', 'a3f9d1e6-940e-495c-94af-f58a662bba30', '12', 1, 1, '-', '12000', '2024-08-17 10:01:55', '2024-08-17 17:01:55', NULL),
('36aeae35-499a-45ef-881c-7d6bf1d79a78', '70ea518d-f818-40f6-a099-d5e71956a82a', '55', 2, 2, 'Wonosobo', '3000', '2023-01-05 02:52:51', '2024-01-28 09:52:51', NULL),
('56ac447a-a535-48d3-b917-e68c4e582cd5', '7c20d65d-b92b-454f-8e71-b6d46940801a', '70', 4, 2, 'Ngaliyan, Semarang', '2000', '2023-05-10 17:00:00', '2024-01-28 10:03:09', NULL),
('60900d5b-808b-484b-b39c-86b6a47f1745', '1ec7a2f7-4635-47a5-86d3-9d6ad8b8166a', '10', 2, 5, 'Dermolo, Rt.02/05 Kembang - Jepara', '2000', '2024-01-26 10:01:03', '2024-01-26 17:01:03', NULL),
('7a4099e6-5e8e-4652-8336-12889301805f', 'df07cbe2-2ce3-4245-b9a6-bc9b24448edb', '30', 5, 20, 'Weleri, Kendal', '2000', '2024-02-02 16:21:11', '2024-02-02 23:21:11', NULL),
('99551344-2aaf-4bc7-b689-37db9d05adc5', 'c2a86466-3818-4ac5-80b5-50411c1c2f9c', '16', 1, 2, 'Pandak Rt, 2/3, Colo, Dawe, Kudus, Jawa Tengah', '1200', '2024-08-24 16:52:56', '2024-08-24 23:52:56', NULL),
('a5fd9b72-5107-45a0-afd9-1e117ecc0088', '2c67ebd8-722d-44cf-b644-4bf4c5493e56', '30', 3, 2, 'Grobogan', '4000', '2024-01-26 09:14:40', '2024-01-26 16:14:40', NULL),
('a80a7799-fa87-4ee4-89ef-13f08b4125b4', '623945d3-db4e-4026-b745-4379a8ece86d', '20', 3, 4, 'Demak', '2000', '2024-01-28 07:35:28', '2024-01-28 14:35:28', NULL),
('b96de30b-07e5-41b8-8816-315f5cdc4097', '15e1e792-0d16-4838-a9ae-631a5d10b346', '10', 4, 2, 'Pati', '2000', '2024-02-02 16:05:28', '2024-02-02 23:05:28', NULL),
('c01d6aa2-56b3-4d37-86db-7f944bf4a5c9', '3b14b0bc-dc9b-473f-a320-52612566d871', '10', 4, 4, 'Demak', '2000', '2024-01-28 07:42:57', '2024-01-28 14:42:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_awals`
--

CREATE TABLE `data_awals` (
  `id_data_awal` char(36) NOT NULL,
  `customer_id` char(36) NOT NULL,
  `tunggakan` varchar(20) DEFAULT NULL,
  `denda` varchar(20) DEFAULT NULL,
  `lain_lain` varchar(20) DEFAULT NULL,
  `awal` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_awals`
--

INSERT INTO `data_awals` (`id_data_awal`, `customer_id`, `tunggakan`, `denda`, `lain_lain`, `awal`, `created_at`, `updated_at`, `deleted_at`) VALUES
('3b309386-3915-47eb-891b-dece1e437626', '14b4cb87-d0ab-47b6-b230-086e620ddd04', '12000', '2000', '0', '1000', '2024-08-17 10:02:39', '2024-08-17 10:02:39', NULL),
('5fc6815a-02e4-4f05-a74b-e5053da77b0e', '7a4099e6-5e8e-4652-8336-12889301805f', '1000', '0', '2000', '70', '2024-02-02 16:21:47', '2024-02-02 16:21:47', NULL),
('afa32b4b-cb76-4a8c-bb4a-2e16e800a42c', '56ac447a-a535-48d3-b917-e68c4e582cd5', '10000', '15000', '0', '100', '2024-01-28 03:40:05', '2024-01-28 03:40:05', NULL),
('b4434cc9-2ea2-464e-ad27-c2a6442f9c86', '99551344-2aaf-4bc7-b689-37db9d05adc5', '2000', '10000', '0', '200', '2024-08-24 16:53:48', '2024-08-24 16:53:48', NULL),
('b6ef6b20-c002-473f-9cdd-c89b0de30a8e', 'b96de30b-07e5-41b8-8816-315f5cdc4097', '0', '0', '0', '90', '2024-02-02 16:06:26', '2024-02-02 16:06:26', NULL),
('b9fc427c-b6be-4ccb-b6ff-bd9a885067c3', '60900d5b-808b-484b-b39c-86b6a47f1745', '50000', '1000', '0', '100', '2024-01-26 10:01:37', '2024-01-26 10:01:37', NULL),
('c281ea12-3052-451c-a0db-b13d722254a6', 'a5fd9b72-5107-45a0-afd9-1e117ecc0088', '5000', '0', '0', '120', '2024-01-26 09:42:44', '2024-01-26 09:42:44', NULL),
('d6c4437f-e219-4250-96b8-cb9bc9896154', '36aeae35-499a-45ef-881c-7d6bf1d79a78', '1000', '2000', '3000', '200', '2024-01-28 02:53:28', '2024-01-28 02:53:28', NULL),
('f2b417df-22f2-4bec-86da-5f6415f3c76a', 'c01d6aa2-56b3-4d37-86db-7f944bf4a5c9', '0', '0', '2000', '105', '2024-01-28 07:48:17', '2024-01-28 07:48:17', NULL);

--
-- Triggers `data_awals`
--
DELIMITER $$
CREATE TRIGGER `after_data_awals_update` AFTER UPDATE ON `data_awals` FOR EACH ROW BEGIN
    UPDATE tagihans 
    SET 
        tunggakan = NEW.tunggakan,
        denda = NEW.denda,
        lain_lain = NEW.lain_lain
    WHERE data_awal_id = NEW.id_data_awal;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_tagihan` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode_invoice` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id_menus`, `upid_menus`, `code_menus`, `name_menus`, `link_menus`, `description_menus`, `icon_menus`, `action_menus`, `created_at`, `updated_at`, `deleted_at`) VALUES
('322bccd2-e2df-4aab-903c-ec7205a9ce1c', '9a7773d3-d090-4586-86eb-4a8c3804d199', 'MDPS', 'Setting Harga', 'price-settings', NULL, 'fas fa-sliders-h', 'create,read,update,delete,list', '2023-02-11 11:35:02', '2023-02-11 18:36:29', NULL),
('32d2e1a8-ec96-44c7-885c-21f456b085ff', '9a7773d3-d090-4586-86eb-4a8c3804d199', 'MDPA', 'Data Profile Company', 'profile-company', 'Menu ini berisikan data area seperti contoh profile area dengan nama RW atau Rukun Warga bahkan bisa mengacu komplek', 'fas fa-chalkboard-teacher', 'create,read,update,delete,list', '2023-02-09 06:27:00', '2023-02-09 16:32:24', NULL),
('51bebdc8-28df-4159-8fe4-7833c493431e', '0', 'MOD', 'Data  Menu', 'menus', 'Data menus sistem', 'fa fa-list', 'create,read,update,delete,list,export,import', '2022-10-15 15:02:00', NULL, NULL),
('618019ac-8035-40e1-9bac-d747bb406145', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', 'PRIV', 'Role Akses', 'roles', 'Digunakan untuk mengatur hak akses pengguna', 'fa fa-cog', 'create,update,delete,read,detail,list,roles', '2022-10-15 15:02:00', NULL, NULL),
('6b726921-5854-4805-9493-da3e4e93118f', '0', 'DTA', 'Data Awal Pelanggan', 'data-awal-pelanggan', NULL, 'fas fa-table', 'data-awal-pelanggan', '2024-01-17 03:01:48', '2024-01-18 13:17:14', NULL),
('7e32dfaa-8113-4829-9f5f-5a0ab29c8468', '9a7773d3-d090-4586-86eb-4a8c3804d199', 'MDDP', 'Data Pelanggan', 'data-customer', 'Berisikan data pelanggan', 'fas fa-users', 'create,read,update,delete,list,reset', '2023-02-09 12:35:33', '2023-02-09 23:06:23', NULL),
('90bc0faf-2acd-455a-b816-1add813b289b', '0', 'DT1', 'Data Tagihan', 'data-tagihan', NULL, 'fas fa-money-bill-wave-alt', 'create,read,update,delete,data-tagihan', '2024-01-23 03:52:28', '2024-01-23 11:46:38', NULL),
('92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', '0', 'USM', 'User Management', 'user-management', '', 'fa fa-users', 'read,list', '2022-10-15 15:02:00', NULL, NULL),
('9a7773d3-d090-4586-86eb-4a8c3804d199', '0', 'MSD', 'Master Data', 'master-data', '', 'fa fa-cubes', 'list,read', '2022-10-15 15:02:00', NULL, NULL),
('a4b58142-a3d4-45e7-b211-dcc20d007875', '0', 'DTP', 'Data Tagihan Pelanggan', 'customer-bill', NULL, 'fas fa-hand-holding-usd', 'create,read,update,delete,list', '2023-02-11 10:43:21', '2023-05-04 10:52:52', NULL),
('d1426653-826a-47aa-9920-d7fc5dab4c05', '0', 'HOME', 'Dashboard', 'home', '', 'fa fa-home', 'list,read', '2022-10-15 15:02:00', NULL, NULL),
('fca27393-2694-49ee-8bae-d457c9f5eaf9', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', 'USR', 'Data Pengguna', 'user', '', 'fa fa-user', 'create,read,update,delete,import,export,detail,reset', '2022-10-15 15:02:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
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
(16, '2022_12_11_123220_create_province_raja_ongkirs_table', 3),
(17, '2022_12_11_123238_create_city_raja_ongkirs_table', 3),
(18, '2024_08_29_060137_create_pembayarans_table', 4),
(19, '2024_09_10_141408_create_invoices_table', 5),
(20, '2024_09_10_135528_add_kode_invoice_to_invoices_table', 6),
(21, '2024_09_10_144109_add_kode_invoice_to_tagihans_table', 7),
(22, '2024_09_10_171104_create_payments_table', 8),
(23, '2024_09_10_175131_create_payments_table', 9),
(24, '2024_09_12_142645_create_payments_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `model_id` bigint(20) NOT NULL,
  `roles_id` bigint(20) NOT NULL,
  `model_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` char(36) NOT NULL,
  `tagihan_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `jenis_pembayaran` varchar(255) DEFAULT NULL,
  `total_pembayaran` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `tagihan_id`, `user_id`, `jenis_pembayaran`, `total_pembayaran`, `created_at`, `updated_at`) VALUES
('1384c238-ad9f-4960-bd60-7a0f2630a135', '55ba908e-655d-49a7-8716-0ab2aec635ce', 'c2a86466-3818-4ac5-80b5-50411c1c2f9c', 'transfer', 84000.00, '2024-09-12 16:31:22', '2024-09-12 16:31:22'),
('5e5fc04a-6039-47c3-9a15-6e99eb706c6d', '55ba908e-655d-49a7-8716-0ab2aec635ce', 'c2a86466-3818-4ac5-80b5-50411c1c2f9c', 'cash', 84000.00, '2024-09-12 17:04:26', '2024-09-12 17:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_settings`
--

CREATE TABLE `price_settings` (
  `id_price_settings` char(36) NOT NULL,
  `minimum_value_per_cubic_price_settings` varchar(16) DEFAULT NULL,
  `increase_in_price_per_cubic_price_settings` varchar(16) DEFAULT NULL,
  `type_ref_doc_price_settings` enum('TEXT','LINK') NOT NULL DEFAULT 'TEXT',
  `ref_doc_price_settings` longtext DEFAULT NULL,
  `is_active_price_settings` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `price_settings`
--

INSERT INTO `price_settings` (`id_price_settings`, `minimum_value_per_cubic_price_settings`, `increase_in_price_per_cubic_price_settings`, `type_ref_doc_price_settings`, `ref_doc_price_settings`, `is_active_price_settings`, `created_at`, `updated_at`, `deleted_at`) VALUES
('c653fa52-6a05-4609-bc09-c1ca5dcea021', '25000', '1050', 'LINK', 'https://kastara.id/05/09/2021/tarif-air-pam-di-dki-turun-dari-rp-25-000-menjadi-rp-1-050/#:~:text=Hal%20itu%20tertuang%20dalam%20Peraturan,jadi%20Rp%201.050%20per%20m3.', 1, '2024-01-17 04:18:56', '2023-02-12 21:58:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile_companys`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_companys`
--

INSERT INTO `profile_companys` (`id_profile_companys`, `name_profile_companys`, `penanggungjawab_profile_companys`, `logo_profile_companys`, `type_kop_profile_companys`, `kop_image_profile_companys`, `kop_text_profile_companys`, `address_profile_companys`, `kelurahan_profile_companys`, `kecamataan_profile_companys`, `kota_profile_companys`, `provinsi_profile_companys`, `created_at`, `updated_at`, `deleted_at`) VALUES
('7a9355b5-f8aa-4d47-8d75-f58e98dd9d1a', NULL, NULL, NULL, 'TEXT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-17 04:18:56', '2023-02-09 18:58:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile_company_banks`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_company_banks`
--

INSERT INTO `profile_company_banks` (`id_profile_company_banks`, `profile_companys_id`, `bankname_profile_company_banks`, `accountname_profile_company_banks`, `accountnumber_profile_company_banks`, `created_at`, `updated_at`, `deleted_at`) VALUES
('18215764-46fa-41cf-b5fa-23126d55955f', '7a9355b5-f8aa-4d47-8d75-f58e98dd9d1a', 'BCA', 'Budi', '01234567', '2024-01-17 04:18:56', '2023-02-09 18:58:05', NULL),
('6202e225-f4ea-4a57-b414-75f04d55c0ae', '7a9355b5-f8aa-4d47-8d75-f58e98dd9d1a', 'mandiri', 'Duki', '3123333', '2024-01-17 04:18:56', '2023-02-09 18:58:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile_company_contact_details`
--

CREATE TABLE `profile_company_contact_details` (
  `id_profile_company_contact_details` char(36) NOT NULL,
  `profile_companys_id` char(36) NOT NULL,
  `name_profile_company_contact_details` varchar(100) NOT NULL,
  `phone_profile_company_contact_details` varchar(16) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `province_raja_ongkirs`
--

CREATE TABLE `province_raja_ongkirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_roles` char(36) NOT NULL,
  `code_roles` char(16) NOT NULL,
  `name_roles` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_roles`, `code_roles`, `name_roles`, `created_at`, `updated_at`, `deleted_at`) VALUES
('587c9ce1-0ac5-457a-8524-2f69fe161fea', 'CST', 'Customer', '2023-02-09 12:46:25', '2023-02-09 19:46:25', NULL),
('8b61213d-9521-40a4-8b17-fda810228b54', 'SAS', 'Super Admin', '2022-10-15 14:51:44', NULL, NULL),
('aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', 'ADM', 'Admin', '2022-10-15 14:51:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tagihans`
--

CREATE TABLE `tagihans` (
  `id_tagihan` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `data_awal_id` char(36) NOT NULL,
  `akhir` varchar(20) DEFAULT NULL,
  `pakai` varchar(20) DEFAULT NULL,
  `tarif` varchar(20) DEFAULT NULL,
  `tagihan` varchar(20) DEFAULT NULL,
  `total_tagihan` varchar(20) DEFAULT NULL,
  `bayar` varchar(30) DEFAULT NULL,
  `bulan` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `tunggakan` varchar(20) DEFAULT NULL,
  `denda` varchar(20) DEFAULT NULL,
  `lain_lain` varchar(20) DEFAULT NULL,
  `kode_invoice` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tagihans`
--

INSERT INTO `tagihans` (`id_tagihan`, `user_id`, `data_awal_id`, `akhir`, `pakai`, `tarif`, `tagihan`, `total_tagihan`, `bayar`, `bulan`, `tahun`, `created_at`, `updated_at`, `deleted_at`, `tunggakan`, `denda`, `lain_lain`, `kode_invoice`) VALUES
('39403b24-8775-4379-a8b8-5e890970cb56', '70ea518d-f818-40f6-a099-d5e71956a82a', 'd6c4437f-e219-4250-96b8-cb9bc9896154', '12000', '11800', '3000', '35400000', '35406000', NULL, 8, 2024, '2024-09-01 12:06:05', '2024-08-17 09:47:20', NULL, NULL, NULL, NULL, NULL),
('3ee7b8ed-7145-4448-a54d-4ab7f5aafa08', '1ec7a2f7-4635-47a5-86d3-9d6ad8b8166a', 'b9fc427c-b6be-4ccb-b6ff-bd9a885067c3', '200', '100', '2000', '200000', '251000', NULL, 8, 2024, '2024-09-01 13:14:04', '2024-08-25 10:13:49', NULL, NULL, NULL, NULL, NULL),
('4d379f54-97ac-46f1-86a6-8baacd8765f1', 'df07cbe2-2ce3-4245-b9a6-bc9b24448edb', '5fc6815a-02e4-4f05-a74b-e5053da77b0e', '200', '130', '2000', '260000', '263000', NULL, 9, 2024, '2024-09-10 07:49:40', '2024-09-10 07:49:40', NULL, '1000', '0', '2000', 'INV202409100002'),
('55ba908e-655d-49a7-8716-0ab2aec635ce', 'c2a86466-3818-4ac5-80b5-50411c1c2f9c', 'b4434cc9-2ea2-464e-ad27-c2a6442f9c86', '250', '50', '1200', '60000', '72000', NULL, 9, 2024, '2024-09-10 07:42:52', '2024-09-10 07:42:52', NULL, '2000', '10000', '0', 'INV202409100001'),
('5b78a9cc-2165-4a2a-bbb3-de2a7792fea8', '70ea518d-f818-40f6-a099-d5e71956a82a', 'd6c4437f-e219-4250-96b8-cb9bc9896154', '210', '10', '3000', '30000', '36000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 15:30:38', NULL, NULL, NULL, NULL, NULL),
('89d2cb6e-475d-42a4-96cc-24219ccf37d7', 'a3f9d1e6-940e-495c-94af-f58a662bba30', '3b309386-3915-47eb-891b-dece1e437626', '1040', '40', '12000', '480000', '494000', NULL, 9, 2024, '2024-09-10 07:46:03', '2024-09-10 07:46:03', NULL, NULL, NULL, NULL, 'INV202409100001'),
('a458309b-e05b-48cf-98c5-874717270ce8', '3b14b0bc-dc9b-473f-a320-52612566d871', 'f2b417df-22f2-4bec-86da-5f6415f3c76a', '150', '45', '2000', '90000', '92000', NULL, 9, 2024, '2024-09-10 07:50:24', '2024-09-10 07:50:24', NULL, '0', '0', '2000', NULL),
('a9f30d41-c4a5-4d44-80e3-65038dd1398f', '3b14b0bc-dc9b-473f-a320-52612566d871', 'f2b417df-22f2-4bec-86da-5f6415f3c76a', '110', '5', '2000', '10000', '12000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 15:21:42', NULL, NULL, NULL, NULL, NULL),
('b54af0db-3ae8-4d0d-97c6-55cfd83942da', 'c2a86466-3818-4ac5-80b5-50411c1c2f9c', 'b4434cc9-2ea2-464e-ad27-c2a6442f9c86', '201', '1', '1200', '1200', '13200', NULL, 8, 2024, '2024-09-01 12:06:05', '2024-08-25 00:17:10', NULL, NULL, NULL, NULL, NULL),
('ba808eed-2b5a-4768-bbcd-532d0379eff4', 'c2a86466-3818-4ac5-80b5-50411c1c2f9c', 'b4434cc9-2ea2-464e-ad27-c2a6442f9c86', '201', '1', '1200', '1200', '13200', NULL, 8, 2024, '2024-09-01 12:06:05', '2024-08-25 00:17:09', NULL, NULL, NULL, NULL, NULL),
('c2726cc4-c2a9-4111-bad4-6c62961782e9', '7c20d65d-b92b-454f-8e71-b6d46940801a', 'afa32b4b-cb76-4a8c-bb4a-2e16e800a42c', '120', '20', '2000', '40000', '65000', NULL, 8, 2024, '2024-09-01 12:06:05', '2024-08-23 21:15:23', NULL, NULL, NULL, NULL, NULL),
('cf004a69-5191-4806-ba73-2b11cd4be7b6', '15e1e792-0d16-4838-a9ae-631a5d10b346', 'b6ef6b20-c002-473f-9cdd-c89b0de30a8e', '91', '1', '2000', '2000', '2000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 16:12:34', NULL, NULL, NULL, NULL, NULL),
('d5d0d86a-08b9-42bc-b912-d3d02acf55a3', 'c2a86466-3818-4ac5-80b5-50411c1c2f9c', 'b4434cc9-2ea2-464e-ad27-c2a6442f9c86', '300', '100', '1200', '120000', '132000', NULL, 8, 2024, '2024-09-01 12:06:05', '2024-08-24 16:55:05', NULL, NULL, NULL, NULL, NULL),
('d861311d-52fe-434c-96a0-20d987a544b8', '1ec7a2f7-4635-47a5-86d3-9d6ad8b8166a', 'b9fc427c-b6be-4ccb-b6ff-bd9a885067c3', '200', '100', '2000', '200000', '251000', NULL, 8, 2024, '2024-09-01 12:06:05', '2024-08-25 10:13:51', NULL, NULL, NULL, NULL, NULL),
('dd4eabe5-94e7-4dc4-bcde-dbee3ef64717', 'a3f9d1e6-940e-495c-94af-f58a662bba30', '3b309386-3915-47eb-891b-dece1e437626', '10002', '9002', '12000', '108024000', '108038000', NULL, 8, 2024, '2024-09-01 12:06:05', '2024-08-24 15:14:46', NULL, NULL, NULL, NULL, NULL),
('ded13ddb-e7d3-4740-8872-9855ab2fdc9b', '1ec7a2f7-4635-47a5-86d3-9d6ad8b8166a', 'b9fc427c-b6be-4ccb-b6ff-bd9a885067c3', '120', '20', '2000', '40000', '91000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 14:13:00', NULL, NULL, NULL, NULL, NULL),
('e21d063b-4246-4cfe-b339-0ff927935eb8', '7c20d65d-b92b-454f-8e71-b6d46940801a', 'afa32b4b-cb76-4a8c-bb4a-2e16e800a42c', '130', '30', '2000', '60000', '85000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 15:00:07', NULL, NULL, NULL, NULL, NULL),
('e24ec79b-e218-4f90-b785-c1333ba33192', '2c67ebd8-722d-44cf-b644-4bf4c5493e56', 'c281ea12-3052-451c-a0db-b13d722254a6', '130', '10', '4000', '40000', '45000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 15:44:43', NULL, NULL, NULL, NULL, NULL),
('e2eac3b1-b89c-43b1-be62-b056b09568a8', 'df07cbe2-2ce3-4245-b9a6-bc9b24448edb', '5fc6815a-02e4-4f05-a74b-e5053da77b0e', '80', '10', '2000', '20000', '23000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 16:59:49', NULL, NULL, NULL, NULL, NULL),
('fceeab04-cedf-4ecf-8614-7072e73406a3', '7c20d65d-b92b-454f-8e71-b6d46940801a', 'afa32b4b-cb76-4a8c-bb4a-2e16e800a42c', '150', '50', '2000', '100000', '125000', NULL, 2, 2024, '2024-09-01 12:06:05', '2024-02-02 15:19:07', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `second_phone_customers` varchar(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `phone`, `second_phone_customers`, `email_verified_at`, `password`, `avatar`, `avatar_originalfile`, `avatar_originalmimetype`, `avatar_mimetype`, `remember_token`, `roles_id`, `is_publish`, `created_at`, `updated_at`, `deleted_at`) VALUES
('15e1e792-0d16-4838-a9ae-631a5d10b346', 'Rizza Fakhrul Umam', 'rizza@gmail.com', 'rizzaaa', '081224345675', NULL, NULL, '$2y$10$7cnd3rsvl6XONhOJ3x6KxeJxjhdVULMXC8YdZodbX9p976Ayp6buW', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-02-02 16:05:28', '2024-02-02 16:05:28', NULL),
('1ec7a2f7-4635-47a5-86d3-9d6ad8b8166a', 'Dimas Wahyu Ardhana', 'dimasardhana29@gmail.com', 'dims', '082322345597', NULL, NULL, '$2y$10$ZVwPmpgAsHZwJOkCBGSWCuT0EBkH90U/.W9MBiTZC9u6j66uHPHf6', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-01-26 10:01:03', '2024-01-26 10:01:03', NULL),
('2c67ebd8-722d-44cf-b644-4bf4c5493e56', 'Dinda', 'dinda@gmail.com', 'dindaaa', '089678567456', NULL, NULL, '$2y$10$b4oIDaJVqbfFF6t5VgQhkucHum3BwsI0npyiHIh317znATcP1mSMS', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-01-26 09:06:59', '2024-01-26 09:06:59', NULL),
('3b14b0bc-dc9b-473f-a320-52612566d871', 'Rizal Yuli Kustanto', 'rizal@gmail.com', 'Rizalll', '087987678567', NULL, NULL, '$2y$10$jwXT8TZmubr/eq9MOy9waeBqhzO7RDQS/2BMAgZV1IPxOM9TvmjXO', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-01-28 07:42:57', '2024-01-28 07:42:57', NULL),
('4c47696f-4508-4025-88c9-b97e03856ada', 'Yanto Kopling T', 'rahmadianto018@gmail.com', 'yantokopling', '081362867034', NULL, NULL, '$2y$10$j.Uky9UyJkyuF5jWTAdeEuh.oIPUzs9uifDm6dDe.CNNQPvTeNGBq', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2023-02-09 16:01:42', '2023-02-09 16:07:12', NULL),
('70ea518d-f818-40f6-a099-d5e71956a82a', 'Fuat', 'fuat@gmail.com', 'fuattt', '087987678567', NULL, NULL, '$2y$10$.XeKYCwpafkFruzbbit4nev5SpekICCTSqo8QBJM/Y2yiolBj0EwK', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-01-28 02:50:58', '2024-01-28 02:50:58', NULL),
('7c20d65d-b92b-454f-8e71-b6d46940801a', 'Eka Vita Raranti', 'vita@gmail.com', 'vitaaa', '081224345675', NULL, NULL, '$2y$10$KB/d2t8xVbRtz7NT4Vy82.sZSEJv1XW4zoScQgKxZpS2wgUoTTHfW', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-01-28 03:03:09', '2024-01-28 03:03:09', NULL),
('a3f9d1e6-940e-495c-94af-f58a662bba30', 'ELIT', 'elit@gmail.com', 'elit', '089898989898', NULL, NULL, '$2y$10$8B5hcqHtuUYFaREvehpbfOg/YQHsaFx6C5ke1jpkCSJprLYZLhzEG', NULL, NULL, NULL, NULL, 'oYJPbs1PxHS0FC8sCgjyLUUe3E4imQAfRGaF8QyOG3yQqx5mDQ9Er7qbqA0E', '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-08-17 10:01:55', '2024-08-23 20:51:13', NULL),
('c2a86466-3818-4ac5-80b5-50411c1c2f9c', 'Divan Lavianto Pamungkas', 'idsatria@gmail.com', 'divann', '081226594919', NULL, NULL, '$2y$10$rOoR6nb2Q2IFE0HNEVzI1.ACB5NFU1zTWg9wY8j.ApXA.FMHjg6Vu', NULL, NULL, NULL, NULL, 'QNbcTdyK8ae2hTRQuACvl1fLiYncBy5mI6S9EpO4bHqEb1nsDob2uBdb7j8e', '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-08-24 16:52:56', '2024-08-24 16:54:29', NULL),
('ce6c6103-7ccc-4e17-b453-8415b3d9908b', 'Super Admin', 'pinginresign@gmail.com', 'superadmin', '081362867034', NULL, NULL, '$2y$10$RwDwoFpzc99JpZvho0eBpuqzuBe2dzNHB58DkUP3YljGQkWfRGtXK', 'user-avatar/1pdhQoB4ElBmXsKGkomwgg6CZojUDLixB9685r8l.jpg', '32745128.jfif', 'jfif', 'image/jpeg', 'uFdlUw6vE4Up8gI78Im4h3WMXbAex2jbRpF8jt2WP7ENBsumjlX0xflcAfLp', '8b61213d-9521-40a4-8b17-fda810228b54', 1, NULL, '2023-02-06 16:04:28', NULL),
('df07cbe2-2ce3-4245-b9a6-bc9b24448edb', 'Fardannu Bimantara', 'dannu@gmail.com', 'dannu', '087987678567', NULL, NULL, '$2y$10$.sCdph6TdpgbjVskU3Dfb.XVC30oIvMFjN/xlTs6ZdUZodS80Tufi', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-02-02 16:21:11', '2024-02-02 16:21:11', NULL),
('e8b1a294-af9f-4dbe-8ce9-a9b2a6988edb', 'Divan Lavianto Pamungkas', 'idsatria12@gmail.com', 'divan', '081226594919', NULL, NULL, '$2y$10$nnasI0Y4XydTnMtUMOuIb.6FyZPo2aGzi5M.hLDlYhGwHF7.uEzBC', NULL, NULL, NULL, NULL, NULL, '587c9ce1-0ac5-457a-8524-2f69fe161fea', 1, '2024-08-24 16:49:18', '2024-08-24 16:49:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu_authorizations`
--

CREATE TABLE `user_menu_authorizations` (
  `id_user_menu_authorizations` char(36) NOT NULL,
  `roles_id` char(36) NOT NULL,
  `menus_id` char(36) NOT NULL,
  `action_user_menu_authorizations` mediumtext DEFAULT NULL,
  `publish_user_menu_authorizations` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_menu_authorizations`
--

INSERT INTO `user_menu_authorizations` (`id_user_menu_authorizations`, `roles_id`, `menus_id`, `action_user_menu_authorizations`, `publish_user_menu_authorizations`, `created_at`, `updated_at`) VALUES
('02df9660-764c-44ec-9bfe-c87fa89a8772', 'f87ee4f8-424e-451e-9304-7730baed289a', 'b95fa7a3-dc67-4f64-bafd-1e03356b8017', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('0328df74-77b9-49b9-af84-a7de1cf3fff1', 'f87ee4f8-424e-451e-9304-7730baed289a', '1e8ac366-a23b-4931-a98e-ef8188cbe881', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('06c8ddd8-dda0-4836-98e3-0d9baaf86dfc', '587c9ce1-0ac5-457a-8524-2f69fe161fea', 'fca27393-2694-49ee-8bae-d457c9f5eaf9', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('08fde791-aa4a-4773-bd66-a2ba0dcecfb2', '8b61213d-9521-40a4-8b17-fda810228b54', '8b088a91-2b25-4416-bbf2-a080a3f83f2b', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('0931a988-2cc3-4d19-8c22-cf88bba9a8f2', 'f87ee4f8-424e-451e-9304-7730baed289a', 'f837425e-3d1a-4bbe-b536-d7ad41a1c7c5', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('09add454-37b0-40cd-8247-1411bba309db', 'f87ee4f8-424e-451e-9304-7730baed289a', '618019ac-8035-40e1-9bac-d747bb406145', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('0c3cfc30-87b4-48d2-85e1-7df0f262c3bb', 'aa9b727c-c4d6-4825-9294-9b1fb6c2eb8d', 'd1426653-826a-47aa-9920-d7fc5dab4c05', 'read,list', 1, '2023-01-28 11:13:08', '2023-01-28 18:13:08'),
('0cf01b1c-4fa5-4bd6-ba3a-d666538b7573', 'f87ee4f8-424e-451e-9304-7730baed289a', 'fca27393-2694-49ee-8bae-d457c9f5eaf9', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('0d5078be-3756-4289-8ac4-6ac7bd1ad8f3', '8b61213d-9521-40a4-8b17-fda810228b54', '10cf7185-d3b0-4abb-9224-dd08423576b2', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('0f29c550-5089-11ed-92cc-54e1ad1481c6', '8b61213d-9521-40a4-8b17-fda810228b54', '618019ac-8035-40e1-9bac-d747bb406145', 'create,update,delete,read,detail,list,roles', 1, '2022-10-20 15:08:31', '2022-10-20 17:07:36'),
('1182860b-4241-4bc5-97d8-320cef9f100b', '587c9ce1-0ac5-457a-8524-2f69fe161fea', 'd1426653-826a-47aa-9920-d7fc5dab4c05', 'list,read', 1, '2024-08-23 16:21:12', '2024-08-23 23:23:55'),
('12dd1061-3a6e-4b7d-946e-b8831ed79b8e', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '694fa76f-f4c8-45bc-a9c4-709cb3f65109', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('144b0e8a-209a-41b7-ab6d-839a84c85e40', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '1e8ac366-a23b-4931-a98e-ef8188cbe881', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('15653421-940e-4ac5-992f-95ef4047eb8c', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'f537f8c5-5624-424d-ae9b-2abd9f84bc6e', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('17435bec-d33e-47b6-9803-cf88cba6a9b9', '8b61213d-9521-40a4-8b17-fda810228b54', '90bc0faf-2acd-455a-b816-1add813b289b', 'list,read,update,delete,reset,create', 1, '2024-01-23 04:10:19', '2024-01-23 13:27:47'),
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
('2b81f2a6-d2ed-4c79-8517-33d463f30eff', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '7e32dfaa-8113-4829-9f5f-5a0ab29c8468', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
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
('521ea8c6-33dc-44ff-87eb-c7d3d49b0a2d', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '322bccd2-e2df-4aab-903c-ec7205a9ce1c', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
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
('766e6848-d97a-48f1-92b8-c7ebac37e0c5', '8b61213d-9521-40a4-8b17-fda810228b54', 'd1426653-826a-47aa-9920-d7fc5dab4c05', 'list,read', 1, '2021-06-26 10:34:47', '2023-02-11 17:45:24'),
('77910712-5ead-4a7b-8091-74c526fbb534', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'c0a55f27-9b79-4c7e-947b-8083a1a5a4c3', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('7940711d-1238-4cfc-a697-2864578a359c', '8b61213d-9521-40a4-8b17-fda810228b54', '21a957e8-384e-489a-8b60-313b077b9e0c', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('7e9bda0a-ad60-4159-9e28-b356b37a1572', '587c9ce1-0ac5-457a-8524-2f69fe161fea', 'a4b58142-a3d4-45e7-b211-dcc20d007875', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('7ee6edbf-eae0-4063-a5da-2fb5cd015df1', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '6b726921-5854-4805-9493-da3e4e93118f', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('80eabf23-a496-475f-a53f-720ffc54c561', 'f87ee4f8-424e-451e-9304-7730baed289a', 'f537f8c5-5624-424d-ae9b-2abd9f84bc6e', 'create,read,update,delete,list', 1, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('8647fcf5-d829-4147-9cd6-0fa4ffb28a60', '8b61213d-9521-40a4-8b17-fda810228b54', 'fca27393-2694-49ee-8bae-d457c9f5eaf9', 'list,read,update,delete,detail,create,reset', 1, '2021-06-30 23:33:47', '2021-12-23 07:42:18'),
('8a81a9f6-015f-4305-af6e-c55915422f07', 'f87ee4f8-424e-451e-9304-7730baed289a', '51bebdc8-28df-4159-8fe4-7833c493431e', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('8be8391b-8904-44ff-b5df-5468190555a6', '8b61213d-9521-40a4-8b17-fda810228b54', '322bccd2-e2df-4aab-903c-ec7205a9ce1c', 'create,read,update,delete,list', 1, '2023-02-11 11:35:35', '2023-02-11 18:35:35'),
('8cb0cf0f-70c1-4ce3-bbd1-d3d9d98ef382', 'f87ee4f8-424e-451e-9304-7730baed289a', '21a957e8-384e-489a-8b60-313b077b9e0c', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('8e9f5652-aaea-41c5-8c79-fb15fbc48070', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'da6f749f-b616-4516-b016-3d9fa75c0909', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('8ee1b8bc-ee18-4124-8fe2-63e7cea8e534', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '01c0acd5-2e17-460b-be21-d022511249eb', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('9029c49f-9175-4378-8b2a-5af4ae082d58', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '51bebdc8-28df-4159-8fe4-7833c493431e', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('97e232b7-b969-445b-abec-a578e2405858', '8b61213d-9521-40a4-8b17-fda810228b54', 'f537f8c5-5624-424d-ae9b-2abd9f84bc6e', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('9b58a55f-62ae-439d-b859-85bfe81c76df', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '9a7773d3-d090-4586-86eb-4a8c3804d199', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('9bbeb77e-8b21-4133-a3c8-497adc6f2f7c', '8b61213d-9521-40a4-8b17-fda810228b54', '7e32dfaa-8113-4829-9f5f-5a0ab29c8468', 'create,read,update,delete,list,reset', 1, '2023-02-09 12:37:00', '2023-02-09 23:06:57'),
('a0660bd1-0a50-4bcc-971f-e1d4bf288608', 'f87ee4f8-424e-451e-9304-7730baed289a', '943a16fa-dd82-4b26-bd35-997dda9f4cc5', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('a5b9e064-4c17-4a42-8f26-5169c29303fe', '8b61213d-9521-40a4-8b17-fda810228b54', 'a4b58142-a3d4-45e7-b211-dcc20d007875', 'create,read,update,delete,list', 1, '2023-02-11 10:45:24', '2023-02-11 17:45:24'),
('ab7f94ad-eeec-49b8-a0e6-ebaaf9b049e1', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '28bfa6ea-3aa1-404a-abb7-6272ad2d72e2', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('af0a1b22-eb63-4ab8-b52d-1f9ed7efdd4c', '8b61213d-9521-40a4-8b17-fda810228b54', '28bfa6ea-3aa1-404a-abb7-6272ad2d72e2', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('b2ccda67-0e90-4dcc-a6bc-c14b19905d05', 'f87ee4f8-424e-451e-9304-7730baed289a', 'c2d7cd25-4fd0-4885-98b2-649e7a10aa09', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('b2da6d06-ce31-4414-a0b0-1276b7061c13', '62cd5d85-4765-4481-b3db-8dc85f2f9061', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('b35d870a-8ee6-428e-b74b-8fff39cfb4c0', '8b61213d-9521-40a4-8b17-fda810228b54', '6b726921-5854-4805-9493-da3e4e93118f', 'create,list,read,update,delete,reset', 1, '2024-01-17 03:02:43', '2024-01-17 10:02:43'),
('b64b4d81-4aef-4b78-87f7-47a2a8fc4174', 'f87ee4f8-424e-451e-9304-7730baed289a', 'a903a3ed-0486-4a66-9183-751ba4028f31', 'read,list', 1, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('b6937646-0491-4166-8c85-be8420e95f4d', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'b95fa7a3-dc67-4f64-bafd-1e03356b8017', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('b7d1e1fa-9f2b-4fe0-aa4a-375941221110', 'f87ee4f8-424e-451e-9304-7730baed289a', '49c6176a-6919-4cdd-aaa2-aa6d416c815e', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('c104385f-b2c0-404f-b229-89014f857608', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '618019ac-8035-40e1-9bac-d747bb406145', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
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
('ec596ab3-6ec8-4403-99fd-630133e1ca00', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '32d2e1a8-ec96-44c7-885c-21f456b085ff', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('f47dcd59-d64c-4381-b519-8653e005c39c', 'f87ee4f8-424e-451e-9304-7730baed289a', 'f563c20b-a3bb-4883-9730-7078402e53b6', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('f59a0b9f-2803-417a-813c-12f44fd5b083', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '90bc0faf-2acd-455a-b816-1add813b289b', 'list,read,action', 1, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('f84043e1-6bc6-4735-b2b9-88bce83147fc', '587c9ce1-0ac5-457a-8524-2f69fe161fea', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05', NULL, 0, '2024-08-23 16:21:12', '2024-08-23 23:21:12'),
('f9527466-8e08-470f-841e-573cbcd7ce75', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'c230f0f2-f8a0-4e37-865e-1b6c676afd65', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13'),
('f9f36072-9b4a-4dc8-8baf-c47aeacec67c', '8b61213d-9521-40a4-8b17-fda810228b54', 'c0a55f27-9b79-4c7e-947b-8083a1a5a4c3', 'create,read,update,delete,list', 0, '2022-12-11 08:22:23', '2022-12-17 17:35:48'),
('fb77c684-0dad-41f7-ae1c-bb2028860b18', '8b61213d-9521-40a4-8b17-fda810228b54', 'f837425e-3d1a-4bbe-b536-d7ad41a1c7c5', 'create,read,update,delete,list', 0, '2022-11-26 15:57:27', '2023-01-11 21:36:17'),
('fe586209-686c-40f5-b47d-6cb358bec58f', 'f87ee4f8-424e-451e-9304-7730baed289a', 'e4837062-2ee2-477f-bcba-0a62cb9cb6fb', NULL, 0, '2022-12-19 12:56:38', '2022-12-19 19:56:38'),
('fed752ff-48c2-4201-8aac-e7633284a6bc', '62cd5d85-4765-4481-b3db-8dc85f2f9061', 'f563c20b-a3bb-4883-9730-7078402e53b6', NULL, 0, '2023-01-28 10:13:13', '2023-01-28 17:13:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city_raja_ongkirs`
--
ALTER TABLE `city_raja_ongkirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_customers`);

--
-- Indexes for table `data_awals`
--
ALTER TABLE `data_awals`
  ADD PRIMARY KEY (`id_data_awal`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menus`),
  ADD KEY `upid_menus` (`upid_menus`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tagihan` (`tagihan_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `price_settings`
--
ALTER TABLE `price_settings`
  ADD PRIMARY KEY (`id_price_settings`);

--
-- Indexes for table `profile_companys`
--
ALTER TABLE `profile_companys`
  ADD PRIMARY KEY (`id_profile_companys`);

--
-- Indexes for table `profile_company_banks`
--
ALTER TABLE `profile_company_banks`
  ADD PRIMARY KEY (`id_profile_company_banks`);

--
-- Indexes for table `profile_company_contact_details`
--
ALTER TABLE `profile_company_contact_details`
  ADD PRIMARY KEY (`id_profile_company_contact_details`);

--
-- Indexes for table `province_raja_ongkirs`
--
ALTER TABLE `province_raja_ongkirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indexes for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `data_awal_id` (`data_awal_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_menu_authorizations`
--
ALTER TABLE `user_menu_authorizations`
  ADD PRIMARY KEY (`id_user_menu_authorizations`),
  ADD KEY `roles_id` (`roles_id`,`menus_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city_raja_ongkirs`
--
ALTER TABLE `city_raja_ongkirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `province_raja_ongkirs`
--
ALTER TABLE `province_raja_ongkirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_tagihan` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihans` (`id_tagihan`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD CONSTRAINT `tagihans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tagihans_ibfk_2` FOREIGN KEY (`data_awal_id`) REFERENCES `data_awals` (`id_data_awal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
