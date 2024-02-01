-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2023 at 01:14 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dcs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` int(10) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `is_active_bank` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bank_account_details`
--

CREATE TABLE `bank_account_details` (
  `account_id` int(10) NOT NULL,
  `account_no` int(10) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `bank_id` int(10) NOT NULL,
  `bank_branch_id` int(10) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `is_active_bank_acc` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bank_branch`
--

CREATE TABLE `bank_branch` (
  `branch_id` int(10) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_address` varchar(200) NOT NULL,
  `branch_contact` varchar(20) NOT NULL,
  `bank_branch_code` varchar(255) NOT NULL,
  `bank_swift_code` varchar(255) NOT NULL,
  `is_active_bank_branch` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bank_deposit`
--

CREATE TABLE `bank_deposit` (
  `bank_deposit_id` int(10) NOT NULL,
  `account_id` int(10) NOT NULL,
  `created_emp_id` int(10) NOT NULL,
  `deposit_total_amount` decimal(10,2) NOT NULL,
  `create_date` varchar(10) NOT NULL,
  `created_time` varchar(10) NOT NULL,
  `deposit_narration_no` varchar(200) NOT NULL,
  `deposit_transaction_no` varchar(200) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `bank_deposit_type` varchar(100) NOT NULL COMMENT 'online, bank slip',
  `verified_emp_id` int(10) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `is_active_bank_deposit` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_contact` varchar(255) NOT NULL,
  `company_about_us` varchar(255) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `company_country` int(10) NOT NULL,
  `is_active_company` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_address`, `company_contact`, `company_about_us`, `company_logo`, `company_country`, `is_active_company`) VALUES
(1, 'DCS', 'Dalupitiya, Wattala', '2121212121', 'test', 'http://localhost/API/assets/img/dcs.jpg', 1, 1),
(2, 'sas 1', 'sasasa', 'sas', 'asasa', 'http://localhost/API/assets/img/dcs.jpg', 2, 0),
(15, 'xxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxx', 'xxxxxxxxx', 'xxxxxxxxxxxxxxx', 'http://localhost/API/assets/img/dcs.jpg', 5, 1),
(16, 'xxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxx', 'xxxxxxxxx', 'xxxxxxxxxxxxxxx', 'http://localhost/API/assets/img/dcs.jpg', 5, 1),
(17, 'xxxxxxxxxxxxx111111', 'xxxxxxxxxxxxxxxx111111111111111', 'xxxxxxxxx1111111111111', 'xxxxxxxxxxxxxxx11111', 'http://localhost/API/assets/img/preview.jpg', 4, 0),
(18, 'hhhhhhhh2222', 'hhhhhhhhh222', 'hhhhhhhhhhhh2222', 'hhhhhhhhhhh222', 'http://localhost/API/assets/img/digg.png', 4, 1),
(19, 'hhhhhhhh2222', 'hhhhhhhhh222', 'hhhhhhhhhhhh2222', 'hhhhhhhhhhh222', 'http://localhost/API/assets/img/digg.png', 4, 1),
(20, 'hhhhhhhh2222', 'hhhhhhhhh222', 'hhhhhhhhhhhh2222', 'hhhhhhhhhhh222', 'http://localhost/API/assets/img/digg.png', 4, 1),
(21, 'hhhhhhhh2222', 'hhhhhhhhh222', 'hhhhhhhhhhhh2222', 'hhhhhhhhhhh222', 'http://localhost/API/assets/img/digg.png', 4, 1),
(22, 'hhhhhhhhxxxx', 'hhhhhhhhhxxx', 'hhhhhhhhhhhhxxxx', 'hhhhhhhhhhhxxx', 'http://localhost/API/assets/img/modern.jpg', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `company_branch`
--

CREATE TABLE `company_branch` (
  `company_branch_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `company_branch_name` varchar(255) NOT NULL,
  `branch_location` int(10) NOT NULL,
  `branch_contact` int(10) NOT NULL,
  `branch_manager` int(10) NOT NULL,
  `branch_address` varchar(255) NOT NULL,
  `is_active_branch` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_branch`
--

INSERT INTO `company_branch` (`company_branch_id`, `company_id`, `company_branch_name`, `branch_location`, `branch_contact`, `branch_manager`, `branch_address`, `is_active_branch`) VALUES
(1, 15, 'Wattala2', 1, 2147483611, 1, '120/36A, Nahena, Hunupitiya, Wattala2', 0),
(2, 1, 'Kadawata', 1, 712917184, 1, '21, Polhena, Madapatha', 1),
(3, 1, 'Nittambuwa', 4, 712917184, 2, 'Kandy Rd, Nittambuwa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(10) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_desc` varchar(255) NOT NULL,
  `is_active_country` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`, `country_desc`, `is_active_country`) VALUES
(1, 'Sri Lanka', '1234', 1),
(2, 'Japan', '123', 1),
(3, 'India', 'India', 0),
(4, 'China', 'China', 1),
(5, 'Russia', 'Russia', 1),
(6, 'Dubai', 'Dubai', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `working_address` varchar(200) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `nic_address` varchar(200) NOT NULL,
  `old_nic_no` varchar(20) NOT NULL,
  `new_nic_no` varchar(20) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `is_web` tinyint(1) NOT NULL,
  `is_active_customer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `working_address`, `shipping_address`, `nic_address`, `old_nic_no`, `new_nic_no`, `contact_no`, `created_date`, `is_web`, `is_active_customer`) VALUES
(1, 'Sachith', 'Mahara, Kadawatha', 'Hunupitiya, Wattala', 'Hunupitiya, Wattala', '99999999999', '', '1213134564', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `emp_allowance`
--

CREATE TABLE `emp_allowance` (
  `allowance_id` int(10) NOT NULL,
  `allowance_name` varchar(20) NOT NULL,
  `allowance_desc` varchar(200) NOT NULL,
  `is_active_emp_allow` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_designation`
--

CREATE TABLE `emp_designation` (
  `emp_desig_id` int(10) NOT NULL,
  `emp_desig_name` varchar(20) NOT NULL,
  `emp_desig_desc` varchar(200) NOT NULL,
  `is_active_emp_desig` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_details`
--

CREATE TABLE `emp_details` (
  `emp_id` int(10) NOT NULL,
  `emp_epf` int(10) NOT NULL,
  `emp_company_id` int(10) NOT NULL,
  `emp_first_name` varchar(200) NOT NULL,
  `emp_middle_name` varchar(200) NOT NULL,
  `emp_last_name` varchar(200) NOT NULL,
  `emp_nic_new` varchar(20) NOT NULL,
  `emp_nic_old` varchar(10) NOT NULL,
  `emp_dob` varchar(10) NOT NULL,
  `emp_perm_address` varchar(300) NOT NULL,
  `emp_temp_address` varchar(300) NOT NULL,
  `emp_contact_no` varchar(20) NOT NULL,
  `emp_emg_contact_no` varchar(20) NOT NULL,
  `emp_drive_license_id` int(10) NOT NULL,
  `is_active_emp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_details`
--

INSERT INTO `emp_details` (`emp_id`, `emp_epf`, `emp_company_id`, `emp_first_name`, `emp_middle_name`, `emp_last_name`, `emp_nic_new`, `emp_nic_old`, `emp_dob`, `emp_perm_address`, `emp_temp_address`, `emp_contact_no`, `emp_emg_contact_no`, `emp_drive_license_id`, `is_active_emp`) VALUES
(1, 17534, 1, 'Charith', 'Denuwan', 'Porage', '', '911330768V', '12.05.1991', '21, Polhena, Madapatha', 'Welisara, Wattala', '0712917184', '0757848081', 1, 1),
(2, 17533, 1, 'Sachith', 'Sasindu', 'Sasindu', '', '96331768V', '26.01.1996', '120/36A, Nahena, Hunupitiya, Wattala', '120/36A, Nahena, Hunupitiya, Wattala', '0712917184', '0712917184', 12345678, 1);

-- --------------------------------------------------------

--
-- Table structure for table `emp_driving_license`
--

CREATE TABLE `emp_driving_license` (
  `driving_license_id` int(10) NOT NULL,
  `license_number` varchar(100) NOT NULL,
  `valid_from_date` varchar(10) NOT NULL,
  `valid_to_date` varchar(10) NOT NULL,
  `license_type` varchar(10) NOT NULL,
  `is_active_driving_lice` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_driving_license`
--

INSERT INTO `emp_driving_license` (`driving_license_id`, `license_number`, `valid_from_date`, `valid_to_date`, `license_type`, `is_active_driving_lice`) VALUES
(1, 'B1447703', '01.01.2020', '01.01.2027', 'Light', 1);

-- --------------------------------------------------------

--
-- Table structure for table `emp_final_salary`
--

CREATE TABLE `emp_final_salary` (
  `final_sal_id` int(10) NOT NULL,
  `sal_scale_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `month` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `additions_amount` decimal(10,2) NOT NULL,
  `deductions_amount` decimal(10,2) NOT NULL,
  `created_by_emp_id` int(10) NOT NULL,
  `approved_by_emp_id` int(10) NOT NULL,
  `is_active_final_sal` tinyint(1) NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `is_hold` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_finger_print_details`
--

CREATE TABLE `emp_finger_print_details` (
  `fp_line_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `date` varchar(10) NOT NULL,
  `in_time` varchar(5) NOT NULL,
  `out_time` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_grade`
--

CREATE TABLE `emp_grade` (
  `emp_grade_id` int(10) NOT NULL,
  `emp_grade_name` varchar(100) NOT NULL,
  `emp_grade_desc` varchar(100) NOT NULL,
  `is_active_smp_grade` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_group`
--

CREATE TABLE `emp_group` (
  `emp_group_id` int(10) NOT NULL,
  `emp_group_name` varchar(20) NOT NULL,
  `emp_group_desc` varchar(100) NOT NULL,
  `emp_grade_id` int(10) NOT NULL,
  `emp_designation_id` int(10) NOT NULL,
  `is_active_emp_group` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_holiday_calender`
--

CREATE TABLE `emp_holiday_calender` (
  `calendar_id` int(10) NOT NULL,
  `holiday_date` varchar(10) NOT NULL,
  `holoday_name` varchar(100) NOT NULL,
  `calendar_year` int(10) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `created_by_emp_id` int(10) NOT NULL,
  `is_active_calendar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave_details`
--

CREATE TABLE `emp_leave_details` (
  `leave_detail_id` int(10) NOT NULL,
  `leave_date` varchar(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `leave_type` int(10) NOT NULL,
  `leave_amount` varchar(5) NOT NULL,
  `leave_start_time` varchar(10) NOT NULL,
  `leave_end_time` varchar(10) NOT NULL,
  `created_by_emp_id` int(10) NOT NULL,
  `approved_by_emp_id` int(10) NOT NULL,
  `is_active_leave_details` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave_quota`
--

CREATE TABLE `emp_leave_quota` (
  `leave_quota_id` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `leave_type_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `is_active_leave_quota` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave_type`
--

CREATE TABLE `emp_leave_type` (
  `leave_type_id` int(10) NOT NULL,
  `leave_type_name` varchar(100) NOT NULL,
  `is_active_leave_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_medical_checkup_location`
--

CREATE TABLE `emp_medical_checkup_location` (
  `emp_med_loc_id` int(10) NOT NULL,
  `emp_med_loc_name` varchar(100) NOT NULL,
  `emp_med_loc_contact` varchar(20) NOT NULL,
  `is_active_medical_checkup` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_medical_records`
--

CREATE TABLE `emp_medical_records` (
  `med_record_id` int(10) NOT NULL,
  `med_checkup_date` varchar(10) NOT NULL,
  `special_note` varchar(200) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `med_loc_id` int(10) NOT NULL,
  `is_active_medical_records` tinyint(1) NOT NULL,
  `emp_med_status` varchar(10) NOT NULL COMMENT 'normal, moderate, critical'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_over_time`
--

CREATE TABLE `emp_over_time` (
  `over_time_id` int(10) NOT NULL,
  `over_time_date` varchar(10) NOT NULL,
  `created_emp_id` int(10) NOT NULL,
  `approved_emp_id` int(10) NOT NULL,
  `special_task_id` int(10) NOT NULL,
  `is_active_emp_ot` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_over_time_allocation`
--

CREATE TABLE `emp_over_time_allocation` (
  `ot_alloc_id` int(10) NOT NULL,
  `over_time_id` int(10) NOT NULL,
  `over_time_start_time` varchar(10) NOT NULL,
  `over_time_end_time` varchar(10) NOT NULL,
  `emp_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_over_time_hour_rate`
--

CREATE TABLE `emp_over_time_hour_rate` (
  `ot_rate_id` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(200) NOT NULL,
  `is_active_ot_rate` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_advance`
--

CREATE TABLE `emp_salary_advance` (
  `advance_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `month` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `create_date` varchar(10) NOT NULL,
  `created_emp_id` int(10) NOT NULL,
  `approved_emp_id` int(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `is_active_sal_advance` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_allowance`
--

CREATE TABLE `emp_salary_allowance` (
  `addition_id` int(10) NOT NULL,
  `allowance_id` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `percentage` decimal(10,2) NOT NULL COMMENT 'percentage from basic salary\r\n',
  `emp_id` int(10) NOT NULL,
  `month` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `created_emp_id` int(10) NOT NULL,
  `approved_emp_id` int(10) NOT NULL,
  `is_active_sal_allow` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_bonus`
--

CREATE TABLE `emp_salary_bonus` (
  `emp_bonus_id` int(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `percentage` decimal(10,2) NOT NULL,
  `created_by_emp_id` int(11) NOT NULL,
  `approved_by_emp_id` int(11) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `month` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `is_active_sal_bonus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_increment`
--

CREATE TABLE `emp_salary_increment` (
  `increment_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `month` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `create_date` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `created_by_emp_id` int(10) NOT NULL,
  `approved_by_emp_id` int(10) NOT NULL,
  `is_active_sal_increment` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_scale`
--

CREATE TABLE `emp_salary_scale` (
  `sal_scale_id` int(10) NOT NULL,
  `sal_scale_name` varchar(100) NOT NULL,
  `emp_group_id` int(10) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `is_active_sal_scale` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_special_task_assign_emp`
--

CREATE TABLE `emp_special_task_assign_emp` (
  `assign_emp_line_id` int(10) NOT NULL,
  `special_task_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `is_active_sp_task_assign` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_special_task_detail`
--

CREATE TABLE `emp_special_task_detail` (
  `task_detail_id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `is_active_sp_task_detail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_special_task_header`
--

CREATE TABLE `emp_special_task_header` (
  `special_task_id` int(10) NOT NULL,
  `task_name` varchar(200) NOT NULL,
  `task_type` int(10) NOT NULL,
  `task_date` varchar(10) NOT NULL,
  `task_start_time` varchar(10) NOT NULL,
  `task_end_time` varchar(10) NOT NULL,
  `is_active_sp_task_header` tinyint(1) NOT NULL,
  `is_complete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_work_contract`
--

CREATE TABLE `emp_work_contract` (
  `work_contract_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `emp_grade_id` int(10) NOT NULL,
  `emp_branch_id` int(10) NOT NULL,
  `emp_company_id` int(10) NOT NULL,
  `emp_desig_id` int(10) NOT NULL,
  `emp_ws_id` int(10) NOT NULL,
  `valid_from_date` varchar(10) NOT NULL,
  `valid_to_date` varchar(10) NOT NULL,
  `is_active_emp_work_cont` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_work_schedule`
--

CREATE TABLE `emp_work_schedule` (
  `ws_id` int(10) NOT NULL,
  `ws_name` int(11) NOT NULL,
  `working_hours_per_day` int(10) NOT NULL,
  `in_time` varchar(10) NOT NULL,
  `out_time` varchar(10) NOT NULL,
  `is_flexible` tinyint(1) NOT NULL,
  `is_active_work_schedule` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` int(10) NOT NULL,
  `holiday_type_id` int(10) NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `holiday_desc` varchar(255) NOT NULL,
  `is_active_holiday` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `holiday_type_id`, `holiday_name`, `holiday_desc`, `is_active_holiday`) VALUES
(1, 1, 'Full Moon Poya Day', 'General Full Moon Poya Day', 1),
(2, 1, 'May Day', 'May Day ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `holiday_calendar`
--

CREATE TABLE `holiday_calendar` (
  `h_calendar_id` int(10) NOT NULL,
  `h_holiday_id` int(10) NOT NULL,
  `h_holiday_date_from` varchar(10) NOT NULL,
  `h_holiday_date_to` varchar(10) NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `h_calendar_desc` varchar(255) NOT NULL,
  `is_active_h_calendar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_type`
--

CREATE TABLE `holiday_type` (
  `holiday_type_id` int(10) NOT NULL,
  `holiday_type_name` varchar(255) NOT NULL,
  `holiday_type_desc` varchar(255) NOT NULL,
  `is_active_holiday_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday_type`
--

INSERT INTO `holiday_type` (`holiday_type_id`, `holiday_type_name`, `holiday_type_desc`, `is_active_holiday_type`) VALUES
(1, 'Mercantile', 'Mercantile holiday type', 1),
(2, 'Public', 'Public', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_invoice_hdr`
--

CREATE TABLE `inventory_invoice_hdr` (
  `rental_invoice_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `created_emp_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `total_discount` decimal(10,2) NOT NULL,
  `create_date` varchar(10) NOT NULL,
  `created_time` varchar(10) NOT NULL,
  `is_active_inv_hdr` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_item`
--

CREATE TABLE `inventory_item` (
  `item_id` int(10) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_type` int(10) NOT NULL,
  `item_category` int(10) NOT NULL,
  `is_active_inv_item` tinyint(1) NOT NULL,
  `is_feature` tinyint(1) NOT NULL,
  `is_web_pattern` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_item_category`
--

CREATE TABLE `inventory_item_category` (
  `item_category_id` int(10) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `is_active_inv_item_cat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_item_type`
--

CREATE TABLE `inventory_item_type` (
  `item_type_id` int(10) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `is_active_inv_item_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_rental_invoice_detail`
--

CREATE TABLE `inventory_rental_invoice_detail` (
  `rental_detail_id` int(10) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `no_of_items` int(10) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_discount` decimal(10,2) NOT NULL,
  `is_active_inv_rent_invoice_detail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_rental_invoice_header`
--

CREATE TABLE `inventory_rental_invoice_header` (
  `invoice_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `create_time` varchar(10) NOT NULL,
  `total_discount` decimal(10,2) NOT NULL,
  `is_active_inv_rent_invoice_hdr` tinyint(1) NOT NULL,
  `is_complete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_rent_charge_period`
--

CREATE TABLE `inventory_rent_charge_period` (
  `period_id` int(10) NOT NULL,
  `period_name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `is_active_inv_rent_charge` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_retail_invoice_detail`
--

CREATE TABLE `inventory_retail_invoice_detail` (
  `rental_detail_id` int(10) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `no_of_items` int(10) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_discount` decimal(10,2) NOT NULL,
  `is_active_inv_retail_invoice_detail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_retail_invoice_header`
--

CREATE TABLE `inventory_retail_invoice_header` (
  `invoice_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `create_time` varchar(10) NOT NULL,
  `total_discount` decimal(10,2) NOT NULL,
  `is_active_inv_retail_invoice_hdr` tinyint(1) NOT NULL,
  `is_complete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock_rental`
--

CREATE TABLE `inventory_stock_rental` (
  `rental_stock_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `max_rent_price` decimal(10,2) NOT NULL,
  `min_rent_price` decimal(10,2) NOT NULL,
  `full_stock_count` int(10) NOT NULL,
  `out_stock_count` int(10) NOT NULL,
  `in_stock_count` int(10) NOT NULL,
  `damage_stock_count` int(10) NOT NULL,
  `repair_stock_count` int(10) NOT NULL,
  `rent_charge_period` int(10) NOT NULL,
  `stock_re_order_level` int(10) NOT NULL,
  `is_active_inv_stock_rental` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock_retail`
--

CREATE TABLE `inventory_stock_retail` (
  `stock_retail` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `max_sale_price` decimal(10,2) NOT NULL,
  `min_sale_price` decimal(10,2) NOT NULL,
  `full_stock_count` int(10) NOT NULL,
  `stock_re_order_level` int(10) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `is_active_inv_stock_retail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock_transfer`
--

CREATE TABLE `inventory_stock_transfer` (
  `transfer_id` int(10) NOT NULL,
  `branch_id_from` int(10) NOT NULL,
  `branch_id_to` int(10) NOT NULL,
  `create_date` varchar(10) NOT NULL,
  `create_time` varchar(10) NOT NULL,
  `sender_emp_id` int(10) NOT NULL,
  `receiver_emp_id` int(10) NOT NULL,
  `stock_id` int(10) NOT NULL,
  `stock_amount` decimal(10,2) NOT NULL,
  `transfer_type` varchar(50) NOT NULL COMMENT 'rental_stock, retail_stock',
  `approved_emp_id` int(10) NOT NULL,
  `is_complete` tinyint(1) NOT NULL,
  `is_active_inv_stock_trans` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_sub_item`
--

CREATE TABLE `inventory_sub_item` (
  `line_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `sub_item_id` int(10) NOT NULL,
  `is_active_inv_sub_item` tinyint(1) NOT NULL,
  `no_of_sub_items` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(10) NOT NULL,
  `country_id` int(10) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `location_desc` varchar(255) NOT NULL,
  `is_active_location` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `country_id`, `location_name`, `location_desc`, `is_active_location`) VALUES
(1, 2, 'Kadawata', 'Kadawata', 1),
(2, 2, 'Wattala', 'Wattala Description', 1),
(3, 5, 'Ibaraki Prefetcher', 'Ibaraki Prefetcher Japan', 0),
(4, 1, 'Nittambuwa', 'Nittambuwa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `online_buying_pattern_detail`
--

CREATE TABLE `online_buying_pattern_detail` (
  `pattern_detail_id` int(10) NOT NULL,
  `pattern_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_buying_pattern_header`
--

CREATE TABLE `online_buying_pattern_header` (
  `pattern_id` int(10) NOT NULL,
  `pattern_name` varchar(200) NOT NULL,
  `is_active_buy_pttrn_hdr` tinyint(1) NOT NULL,
  `create_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_feedback`
--

CREATE TABLE `online_feedback` (
  `feedback_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `no_of_stars` int(10) NOT NULL,
  `create_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_order`
--

CREATE TABLE `online_order` (
  `order_id` int(10) NOT NULL,
  `kart_id` int(10) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `promo_code_id` int(10) NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `is_complete` tinyint(1) NOT NULL,
  `is_active_online_order` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_promo_code`
--

CREATE TABLE `online_promo_code` (
  `promo_code_id` int(10) NOT NULL,
  `promo_code_name` varchar(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `valid_from_date` varchar(10) NOT NULL,
  `valid_to_date` varchar(10) NOT NULL,
  `is_active_online_promo_code` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_shopping_kart_detail`
--

CREATE TABLE `online_shopping_kart_detail` (
  `kart_detail_id` int(10) NOT NULL,
  `kart_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `no_of_items` int(10) NOT NULL,
  `is_active_shpng_kart_detail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_shopping_kart_header`
--

CREATE TABLE `online_shopping_kart_header` (
  `kart_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `create_date` varchar(10) NOT NULL,
  `create_time` varchar(10) NOT NULL,
  `is_active_shpng_kart_hdr` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_special_offers`
--

CREATE TABLE `online_special_offers` (
  `offer_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(10,2) NOT NULL,
  `valid_from_date` varchar(10) NOT NULL,
  `valid_to_date` varchar(10) NOT NULL,
  `is_active_online_special_offers` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sys_notification`
--

CREATE TABLE `sys_notification` (
  `sys_notify_id` int(10) NOT NULL,
  `sys_notify_nam` varchar(20) NOT NULL,
  `sys_notify_type` int(10) NOT NULL,
  `create_date` varchar(10) NOT NULL,
  `create_time` varchar(10) NOT NULL,
  `is_repeat` tinyint(1) NOT NULL,
  `repeat_times` int(10) NOT NULL,
  `repeat_every` varchar(20) NOT NULL COMMENT 'daily, monthly, yearly',
  `valid_to_date` varchar(10) NOT NULL,
  `notify_date` varchar(10) NOT NULL,
  `for_user_group_id` int(10) NOT NULL,
  `is_active_sys_notify` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sys_notify_type`
--

CREATE TABLE `sys_notify_type` (
  `sys_notify_id` int(10) NOT NULL,
  `notify_name` varchar(100) NOT NULL,
  `is_active_sys_notify_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sys_user`
--

CREATE TABLE `sys_user` (
  `user_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_active_sys_user` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sys_user`
--

INSERT INTO `sys_user` (`user_id`, `emp_id`, `customer_id`, `username`, `password`, `token`, `is_active_sys_user`) VALUES
(1, 1, 0, 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', '8b5263ac7162e0272ccc', 1),
(2, 0, 1, 'cust', '80d26609c5226268981e4a6d4ceddbc339d991841ae580e3180b56c8ade7651d', '0c990d19a20dc60a6ea7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `user_group_id` int(10) NOT NULL,
  `user_group_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_active_user_grp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_pages`
--

CREATE TABLE `user_pages` (
  `page_id` int(10) NOT NULL,
  `page_category_id` int(10) NOT NULL,
  `page_name` varchar(200) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `description` varchar(200) NOT NULL,
  `is_active_user_pages` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_page_category`
--

CREATE TABLE `user_page_category` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_desc` varchar(255) NOT NULL,
  `is_active_user_page_cat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `user_permission_id` int(10) NOT NULL,
  `user_group_id` int(10) NOT NULL,
  `page_category_id` int(10) NOT NULL,
  `user_page_id` int(10) NOT NULL,
  `is_active_user_perm` tinyint(1) NOT NULL,
  `is_view` tinyint(1) NOT NULL,
  `is_edit` tinyint(1) NOT NULL,
  `is_create` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_category`
--

CREATE TABLE `vehicle_category` (
  `vehicle_category_id` int(10) NOT NULL,
  `vehicle_category_name` varchar(255) NOT NULL,
  `vehicle_category_desc` varchar(255) NOT NULL,
  `is_active_vhcl_cat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE `vehicle_details` (
  `vehicle_id` int(10) NOT NULL,
  `license_plate_no` varchar(20) NOT NULL,
  `vehicle_yom` int(10) NOT NULL,
  `vehicle_type` int(10) NOT NULL,
  `vehicle_category` int(10) NOT NULL,
  `chasis_no` varchar(20) NOT NULL,
  `engine_no` varchar(20) NOT NULL,
  `number_of_passengers` int(10) NOT NULL,
  `max_load` decimal(10,2) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `is_active_vhcl_details` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_eco_test`
--

CREATE TABLE `vehicle_eco_test` (
  `eco_test_id` int(10) NOT NULL,
  `eco_test_number` varchar(200) NOT NULL,
  `vehicle_id` int(10) NOT NULL,
  `valid_from_date` varchar(10) NOT NULL,
  `valid_to_date` varchar(10) NOT NULL,
  `is_active_vhcl_eco_test` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_insuarance_claim_details`
--

CREATE TABLE `vehicle_insuarance_claim_details` (
  `claim_id` int(10) NOT NULL,
  `claim_number` varchar(100) NOT NULL,
  `repair_id` int(10) NOT NULL,
  `claim_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_insuarance_company`
--

CREATE TABLE `vehicle_insuarance_company` (
  `insuar_comp_id` int(10) NOT NULL,
  `insuar_comp_name` varchar(100) NOT NULL,
  `is_active_ins_comp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_insuarance_details`
--

CREATE TABLE `vehicle_insuarance_details` (
  `insuar_detail_id` int(10) NOT NULL,
  `insuar_comp_id` int(10) NOT NULL,
  `insuarance_number` varchar(200) NOT NULL,
  `insuar_type` varchar(20) NOT NULL COMMENT 'full,3rdparty',
  `valid_from_date` varchar(10) NOT NULL,
  `valid_to_date` varchar(10) NOT NULL,
  `premimum_amount` decimal(10,2) NOT NULL,
  `vehicle_id` int(10) NOT NULL,
  `is_active_vhcl_ins_details` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_part_replacement`
--

CREATE TABLE `vehicle_part_replacement` (
  `replacement_id` int(10) NOT NULL,
  `invoice_number` int(10) NOT NULL,
  `shop_name` varchar(200) NOT NULL,
  `shop_address` varchar(200) NOT NULL,
  `shop_contact` varchar(20) NOT NULL,
  `description` varchar(500) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `is_active_vhcl_prt_replace` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_repair`
--

CREATE TABLE `vehicle_repair` (
  `repair_id` int(10) NOT NULL,
  `repair_invoice_number` varchar(200) NOT NULL,
  `vehicle_id` int(10) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `end_date` varchar(10) NOT NULL,
  `repair_type` int(10) NOT NULL COMMENT 'accident, maintenance',
  `repair_location` int(10) NOT NULL,
  `repair_cost` decimal(10,2) NOT NULL,
  `is_active_vhcl_repair` tinyint(1) NOT NULL,
  `is_complete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_repair_location`
--

CREATE TABLE `vehicle_repair_location` (
  `repair_loc_id` int(10) NOT NULL,
  `repair_loc_name` varchar(100) NOT NULL,
  `repair_loc_address` varchar(200) NOT NULL,
  `repair_loc_contact` varchar(20) NOT NULL,
  `is_active_vhcl_repair_loc` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_revenue_license`
--

CREATE TABLE `vehicle_revenue_license` (
  `rev_license_id` int(10) NOT NULL,
  `vehicle_id` int(10) NOT NULL,
  `valid_from_date` varchar(10) NOT NULL,
  `valid_to_date` varchar(10) NOT NULL,
  `is_active_vhcl_rev_lice` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_service_center`
--

CREATE TABLE `vehicle_service_center` (
  `service_center_id` int(10) NOT NULL,
  `service_center_name` varchar(100) NOT NULL,
  `service_center_contact` varchar(20) NOT NULL,
  `service_center_address` varchar(200) NOT NULL,
  `is_active_vhcl_srv_cntr` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_service_details`
--

CREATE TABLE `vehicle_service_details` (
  `service_detail_id` int(10) NOT NULL,
  `service_center_id` int(10) NOT NULL,
  `vehicle_id` int(10) NOT NULL,
  `next_service_in_kms` int(10) NOT NULL,
  `next_service_in_months` int(10) NOT NULL,
  `service_date` varchar(10) NOT NULL,
  `service_invoice_number` varchar(100) NOT NULL,
  `service_cost` decimal(10,2) NOT NULL,
  `description` varchar(500) NOT NULL,
  `is_complete` tinyint(1) NOT NULL,
  `is_active_vhcl_srv_detail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type`
--

CREATE TABLE `vehicle_type` (
  `vehicle_type_id` int(10) NOT NULL,
  `vehicle_type_name` varchar(255) NOT NULL,
  `vehicle_type_decs` varchar(255) NOT NULL,
  `is_active_vhcl_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `bank_account_details`
--
ALTER TABLE `bank_account_details`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `bank_branch`
--
ALTER TABLE `bank_branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `bank_deposit`
--
ALTER TABLE `bank_deposit`
  ADD PRIMARY KEY (`bank_deposit_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `company_branch`
--
ALTER TABLE `company_branch`
  ADD PRIMARY KEY (`company_branch_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `emp_allowance`
--
ALTER TABLE `emp_allowance`
  ADD PRIMARY KEY (`allowance_id`);

--
-- Indexes for table `emp_designation`
--
ALTER TABLE `emp_designation`
  ADD PRIMARY KEY (`emp_desig_id`);

--
-- Indexes for table `emp_details`
--
ALTER TABLE `emp_details`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `emp_driving_license`
--
ALTER TABLE `emp_driving_license`
  ADD PRIMARY KEY (`driving_license_id`);

--
-- Indexes for table `emp_final_salary`
--
ALTER TABLE `emp_final_salary`
  ADD PRIMARY KEY (`final_sal_id`);

--
-- Indexes for table `emp_finger_print_details`
--
ALTER TABLE `emp_finger_print_details`
  ADD PRIMARY KEY (`fp_line_id`);

--
-- Indexes for table `emp_grade`
--
ALTER TABLE `emp_grade`
  ADD PRIMARY KEY (`emp_grade_id`);

--
-- Indexes for table `emp_group`
--
ALTER TABLE `emp_group`
  ADD PRIMARY KEY (`emp_group_id`);

--
-- Indexes for table `emp_holiday_calender`
--
ALTER TABLE `emp_holiday_calender`
  ADD PRIMARY KEY (`calendar_id`);

--
-- Indexes for table `emp_leave_details`
--
ALTER TABLE `emp_leave_details`
  ADD PRIMARY KEY (`leave_detail_id`);

--
-- Indexes for table `emp_leave_quota`
--
ALTER TABLE `emp_leave_quota`
  ADD PRIMARY KEY (`leave_quota_id`);

--
-- Indexes for table `emp_leave_type`
--
ALTER TABLE `emp_leave_type`
  ADD PRIMARY KEY (`leave_type_id`);

--
-- Indexes for table `emp_medical_checkup_location`
--
ALTER TABLE `emp_medical_checkup_location`
  ADD PRIMARY KEY (`emp_med_loc_id`);

--
-- Indexes for table `emp_medical_records`
--
ALTER TABLE `emp_medical_records`
  ADD PRIMARY KEY (`med_record_id`);

--
-- Indexes for table `emp_over_time`
--
ALTER TABLE `emp_over_time`
  ADD PRIMARY KEY (`over_time_id`);

--
-- Indexes for table `emp_over_time_allocation`
--
ALTER TABLE `emp_over_time_allocation`
  ADD PRIMARY KEY (`ot_alloc_id`);

--
-- Indexes for table `emp_over_time_hour_rate`
--
ALTER TABLE `emp_over_time_hour_rate`
  ADD PRIMARY KEY (`ot_rate_id`);

--
-- Indexes for table `emp_salary_advance`
--
ALTER TABLE `emp_salary_advance`
  ADD PRIMARY KEY (`advance_id`);

--
-- Indexes for table `emp_salary_allowance`
--
ALTER TABLE `emp_salary_allowance`
  ADD PRIMARY KEY (`addition_id`);

--
-- Indexes for table `emp_salary_bonus`
--
ALTER TABLE `emp_salary_bonus`
  ADD PRIMARY KEY (`emp_bonus_id`);

--
-- Indexes for table `emp_salary_increment`
--
ALTER TABLE `emp_salary_increment`
  ADD PRIMARY KEY (`increment_id`);

--
-- Indexes for table `emp_salary_scale`
--
ALTER TABLE `emp_salary_scale`
  ADD PRIMARY KEY (`sal_scale_id`);

--
-- Indexes for table `emp_special_task_assign_emp`
--
ALTER TABLE `emp_special_task_assign_emp`
  ADD PRIMARY KEY (`assign_emp_line_id`);

--
-- Indexes for table `emp_special_task_detail`
--
ALTER TABLE `emp_special_task_detail`
  ADD PRIMARY KEY (`task_detail_id`);

--
-- Indexes for table `emp_special_task_header`
--
ALTER TABLE `emp_special_task_header`
  ADD PRIMARY KEY (`special_task_id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `holiday_calendar`
--
ALTER TABLE `holiday_calendar`
  ADD PRIMARY KEY (`h_calendar_id`);

--
-- Indexes for table `holiday_type`
--
ALTER TABLE `holiday_type`
  ADD PRIMARY KEY (`holiday_type_id`);

--
-- Indexes for table `inventory_invoice_hdr`
--
ALTER TABLE `inventory_invoice_hdr`
  ADD PRIMARY KEY (`rental_invoice_id`);

--
-- Indexes for table `inventory_item`
--
ALTER TABLE `inventory_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `inventory_item_type`
--
ALTER TABLE `inventory_item_type`
  ADD PRIMARY KEY (`item_type_id`);

--
-- Indexes for table `inventory_rental_invoice_detail`
--
ALTER TABLE `inventory_rental_invoice_detail`
  ADD PRIMARY KEY (`rental_detail_id`);

--
-- Indexes for table `inventory_rental_invoice_header`
--
ALTER TABLE `inventory_rental_invoice_header`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `inventory_rent_charge_period`
--
ALTER TABLE `inventory_rent_charge_period`
  ADD PRIMARY KEY (`period_id`);

--
-- Indexes for table `inventory_retail_invoice_detail`
--
ALTER TABLE `inventory_retail_invoice_detail`
  ADD PRIMARY KEY (`rental_detail_id`);

--
-- Indexes for table `inventory_retail_invoice_header`
--
ALTER TABLE `inventory_retail_invoice_header`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `inventory_stock_rental`
--
ALTER TABLE `inventory_stock_rental`
  ADD PRIMARY KEY (`rental_stock_id`);

--
-- Indexes for table `inventory_stock_retail`
--
ALTER TABLE `inventory_stock_retail`
  ADD PRIMARY KEY (`stock_retail`);

--
-- Indexes for table `inventory_stock_transfer`
--
ALTER TABLE `inventory_stock_transfer`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `inventory_sub_item`
--
ALTER TABLE `inventory_sub_item`
  ADD PRIMARY KEY (`line_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `online_buying_pattern_detail`
--
ALTER TABLE `online_buying_pattern_detail`
  ADD PRIMARY KEY (`pattern_detail_id`);

--
-- Indexes for table `online_buying_pattern_header`
--
ALTER TABLE `online_buying_pattern_header`
  ADD PRIMARY KEY (`pattern_id`);

--
-- Indexes for table `online_feedback`
--
ALTER TABLE `online_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `online_order`
--
ALTER TABLE `online_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `online_shopping_kart_detail`
--
ALTER TABLE `online_shopping_kart_detail`
  ADD PRIMARY KEY (`kart_detail_id`);

--
-- Indexes for table `online_shopping_kart_header`
--
ALTER TABLE `online_shopping_kart_header`
  ADD PRIMARY KEY (`kart_id`);

--
-- Indexes for table `online_special_offers`
--
ALTER TABLE `online_special_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `sys_notification`
--
ALTER TABLE `sys_notification`
  ADD PRIMARY KEY (`sys_notify_id`);

--
-- Indexes for table `sys_notify_type`
--
ALTER TABLE `sys_notify_type`
  ADD PRIMARY KEY (`sys_notify_id`);

--
-- Indexes for table `sys_user`
--
ALTER TABLE `sys_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `user_pages`
--
ALTER TABLE `user_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `user_page_category`
--
ALTER TABLE `user_page_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`user_permission_id`);

--
-- Indexes for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
  ADD PRIMARY KEY (`vehicle_category_id`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `vehicle_eco_test`
--
ALTER TABLE `vehicle_eco_test`
  ADD PRIMARY KEY (`eco_test_id`);

--
-- Indexes for table `vehicle_insuarance_claim_details`
--
ALTER TABLE `vehicle_insuarance_claim_details`
  ADD PRIMARY KEY (`claim_id`);

--
-- Indexes for table `vehicle_insuarance_company`
--
ALTER TABLE `vehicle_insuarance_company`
  ADD PRIMARY KEY (`insuar_comp_id`);

--
-- Indexes for table `vehicle_insuarance_details`
--
ALTER TABLE `vehicle_insuarance_details`
  ADD PRIMARY KEY (`insuar_detail_id`);

--
-- Indexes for table `vehicle_part_replacement`
--
ALTER TABLE `vehicle_part_replacement`
  ADD PRIMARY KEY (`replacement_id`);

--
-- Indexes for table `vehicle_repair`
--
ALTER TABLE `vehicle_repair`
  ADD PRIMARY KEY (`repair_id`);

--
-- Indexes for table `vehicle_repair_location`
--
ALTER TABLE `vehicle_repair_location`
  ADD PRIMARY KEY (`repair_loc_id`);

--
-- Indexes for table `vehicle_revenue_license`
--
ALTER TABLE `vehicle_revenue_license`
  ADD PRIMARY KEY (`rev_license_id`);

--
-- Indexes for table `vehicle_service_details`
--
ALTER TABLE `vehicle_service_details`
  ADD PRIMARY KEY (`service_detail_id`);

--
-- Indexes for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  ADD PRIMARY KEY (`vehicle_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_account_details`
--
ALTER TABLE `bank_account_details`
  MODIFY `account_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_branch`
--
ALTER TABLE `bank_branch`
  MODIFY `branch_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_deposit`
--
ALTER TABLE `bank_deposit`
  MODIFY `bank_deposit_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `company_branch`
--
ALTER TABLE `company_branch`
  MODIFY `company_branch_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `emp_allowance`
--
ALTER TABLE `emp_allowance`
  MODIFY `allowance_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_designation`
--
ALTER TABLE `emp_designation`
  MODIFY `emp_desig_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_details`
--
ALTER TABLE `emp_details`
  MODIFY `emp_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_driving_license`
--
ALTER TABLE `emp_driving_license`
  MODIFY `driving_license_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `emp_final_salary`
--
ALTER TABLE `emp_final_salary`
  MODIFY `final_sal_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_finger_print_details`
--
ALTER TABLE `emp_finger_print_details`
  MODIFY `fp_line_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_grade`
--
ALTER TABLE `emp_grade`
  MODIFY `emp_grade_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_group`
--
ALTER TABLE `emp_group`
  MODIFY `emp_group_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_holiday_calender`
--
ALTER TABLE `emp_holiday_calender`
  MODIFY `calendar_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_leave_details`
--
ALTER TABLE `emp_leave_details`
  MODIFY `leave_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_leave_quota`
--
ALTER TABLE `emp_leave_quota`
  MODIFY `leave_quota_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_leave_type`
--
ALTER TABLE `emp_leave_type`
  MODIFY `leave_type_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_medical_checkup_location`
--
ALTER TABLE `emp_medical_checkup_location`
  MODIFY `emp_med_loc_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_medical_records`
--
ALTER TABLE `emp_medical_records`
  MODIFY `med_record_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_over_time`
--
ALTER TABLE `emp_over_time`
  MODIFY `over_time_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_over_time_allocation`
--
ALTER TABLE `emp_over_time_allocation`
  MODIFY `ot_alloc_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_over_time_hour_rate`
--
ALTER TABLE `emp_over_time_hour_rate`
  MODIFY `ot_rate_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salary_advance`
--
ALTER TABLE `emp_salary_advance`
  MODIFY `advance_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salary_allowance`
--
ALTER TABLE `emp_salary_allowance`
  MODIFY `addition_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salary_bonus`
--
ALTER TABLE `emp_salary_bonus`
  MODIFY `emp_bonus_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salary_increment`
--
ALTER TABLE `emp_salary_increment`
  MODIFY `increment_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salary_scale`
--
ALTER TABLE `emp_salary_scale`
  MODIFY `sal_scale_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_special_task_assign_emp`
--
ALTER TABLE `emp_special_task_assign_emp`
  MODIFY `assign_emp_line_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_special_task_detail`
--
ALTER TABLE `emp_special_task_detail`
  MODIFY `task_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_special_task_header`
--
ALTER TABLE `emp_special_task_header`
  MODIFY `special_task_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `holiday_calendar`
--
ALTER TABLE `holiday_calendar`
  MODIFY `h_calendar_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_type`
--
ALTER TABLE `holiday_type`
  MODIFY `holiday_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_invoice_hdr`
--
ALTER TABLE `inventory_invoice_hdr`
  MODIFY `rental_invoice_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_item`
--
ALTER TABLE `inventory_item`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_item_type`
--
ALTER TABLE `inventory_item_type`
  MODIFY `item_type_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_rental_invoice_detail`
--
ALTER TABLE `inventory_rental_invoice_detail`
  MODIFY `rental_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_rental_invoice_header`
--
ALTER TABLE `inventory_rental_invoice_header`
  MODIFY `invoice_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_rent_charge_period`
--
ALTER TABLE `inventory_rent_charge_period`
  MODIFY `period_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_retail_invoice_detail`
--
ALTER TABLE `inventory_retail_invoice_detail`
  MODIFY `rental_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_retail_invoice_header`
--
ALTER TABLE `inventory_retail_invoice_header`
  MODIFY `invoice_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_stock_rental`
--
ALTER TABLE `inventory_stock_rental`
  MODIFY `rental_stock_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_stock_retail`
--
ALTER TABLE `inventory_stock_retail`
  MODIFY `stock_retail` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_stock_transfer`
--
ALTER TABLE `inventory_stock_transfer`
  MODIFY `transfer_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_sub_item`
--
ALTER TABLE `inventory_sub_item`
  MODIFY `line_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `online_buying_pattern_detail`
--
ALTER TABLE `online_buying_pattern_detail`
  MODIFY `pattern_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_buying_pattern_header`
--
ALTER TABLE `online_buying_pattern_header`
  MODIFY `pattern_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_feedback`
--
ALTER TABLE `online_feedback`
  MODIFY `feedback_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_order`
--
ALTER TABLE `online_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_shopping_kart_detail`
--
ALTER TABLE `online_shopping_kart_detail`
  MODIFY `kart_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_shopping_kart_header`
--
ALTER TABLE `online_shopping_kart_header`
  MODIFY `kart_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_special_offers`
--
ALTER TABLE `online_special_offers`
  MODIFY `offer_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_notification`
--
ALTER TABLE `sys_notification`
  MODIFY `sys_notify_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_notify_type`
--
ALTER TABLE `sys_notify_type`
  MODIFY `sys_notify_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_user`
--
ALTER TABLE `sys_user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `user_group_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pages`
--
ALTER TABLE `user_pages`
  MODIFY `page_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_page_category`
--
ALTER TABLE `user_page_category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `user_permission_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
  MODIFY `vehicle_category_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  MODIFY `vehicle_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_eco_test`
--
ALTER TABLE `vehicle_eco_test`
  MODIFY `eco_test_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_insuarance_claim_details`
--
ALTER TABLE `vehicle_insuarance_claim_details`
  MODIFY `claim_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_insuarance_company`
--
ALTER TABLE `vehicle_insuarance_company`
  MODIFY `insuar_comp_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_insuarance_details`
--
ALTER TABLE `vehicle_insuarance_details`
  MODIFY `insuar_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_part_replacement`
--
ALTER TABLE `vehicle_part_replacement`
  MODIFY `replacement_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_repair`
--
ALTER TABLE `vehicle_repair`
  MODIFY `repair_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_repair_location`
--
ALTER TABLE `vehicle_repair_location`
  MODIFY `repair_loc_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_revenue_license`
--
ALTER TABLE `vehicle_revenue_license`
  MODIFY `rev_license_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_service_details`
--
ALTER TABLE `vehicle_service_details`
  MODIFY `service_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  MODIFY `vehicle_type_id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
