drop database if exists `ql_ghichu`;
create database `ql_ghichu`;
use ql_ghichu;
#bảng tài khoản người dùng
create table taikhoan(
`id` int auto_increment primary key,
`name` varchar(255) character set utf8mb4 not null,
`email` varchar(255) not null unique,
`password` varchar(255) not null,
`linkanh` varchar(255),
`trangthai` tinyint,
`makhoiphuc` varchar(6),
`ngaykichhoat` datetime,
`thoihanmakhoiphuc` datetime
)engine=InnoDB default char set utf8;
#bảng lưu lại thông tin đăng nhập cho máy
create table luudangnhap(
`token` varchar(100) primary key,
`user_id` int not null,
`ngayhethan` datetime not null
)engine = InnoDB default char set utf8;

create table ghichu(
`maghichu` int auto_increment primary key,
`user_id` int not null references taikhoan(id),
`tieudeghichu` varchar(255) character set utf8mb4,
`ndghichu` text character set utf8mb4,
`trangthai` tinyint,
`ngaytao` datetime,
`ngaycapnhat` datetime,
`linkanhnen` varchar(255)
)engine = InnoDB default char set utf8;

create table the(
`mathe` int auto_increment primary key,
`tenthe` varchar(50) character set utf8mb4,
`user_id` int not null references taikhoan(id)
)engine = InnoDB;

create table theghichu(
`maghichu` int not null references ghichu(maghichu),
`mathe` int not null references the(mathe),
primary key (maghichu,mathe)
)engine = InnoDB;


