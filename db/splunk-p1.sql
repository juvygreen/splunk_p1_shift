
-- Splunk P1 Schema

-- /Applications/MAMP/Library/bin/mysql -uroot -proot


-- Additional Requirements:
-- Reporting - engineers per month or date range
-- Sorting - way to sort the engineer
-- Content Management - Add/edit/remove shift zones ie AMER Cloud Shift A - AST 10am - 1pm | UK 2pm - 5pm | EST 9am - 12pm | CST 8am - 11am | PST 6am - 9am | HKT 10pm - 1am
-- Content Management - Add/edit/remove shifts ie Shift A, Shift B, etc.
-- Managers can have multiple support group


-- ACCOUNT
create table account(
id bigint(20) auto_increment,
uuid varchar(36),
username varchar(64),
avatar varchar(64),
email varchar(64),
password_hash varchar(255),
full_name varchar(255),
first_name varchar(255),
last_name varchar(255),
date_of_birth date,
last4_ssn varchar(36),
phone varchar(100),
mobile varchar(100),
fax varchar(100),
address1 varchar(255),
address2 varchar(255),
city varchar(180),
state varchar(100),
zip varchar(20),
country_code varchar(10),
bio text,
slack_url varchar(100),
mode int(4),
account_type varchar(50),
company_id int(11),
roles_id int(11),
region_id int(11),
support_group_id int(11),
support_group_str varchar(30),
support_group_shift_id int(11),
timezone int(11),
status smallint(6),
status_p1 smallint(6),
support_message varchar(300),
profile_completed smallint(6),
activated smallint(6),
isadmin int(4),
sort_rotate int(4),
sort int(4),
activated_at int(11),
deactivated_at int(11),
created_at int(11),
primary key(id)
);
create index idx_rid on account(region_id);
create index idx_did on account(roles_id);
create index idx_sgid on account(support_group_id);
create index idx_sgsid on account(support_group_shift_id);

-- Email
-- Name
-- Phone
-- Region ie AMER- dropdown
-- Designation ie Engineer or Manager - dropdown
-- Manager - if Designation selected is Engineer dropdown (optional for now)
-- Support Group ie Cloud - multiple choices esp for Manager - dropdown
-- Support Group Shift - ie Shift 1 - if Manager, replace this with "Time" dropdown - dropdown
-- support_group_str is for managers with multiple groups ie 1:2 (support_group:support_group_shift),2:3
-- status_p1 1, for vailable, 0 for not avable
-- support_message -- this is message of engr in time of unavailabilty
-- slack url DM - https://splunk.slack.com/app_redirect?channel=[memberid]. If not provided use this link slack://open
-- ie https://splunk.slack.com/app_redirect?channel=WMH6EDZLZ

-- Designation
create table roles(
id int(12) auto_increment,
name varchar(64),
short_name varchar(64),
status tinyint(1),
created_at int(11),
primary key(id)
);
insert into roles values(1,'Engineer','Engineer',1,unix_timestamp());
insert into roles values(2,'Manager','Manager',1,unix_timestamp());
insert into roles values(3,'CSI','CSI',1,unix_timestamp());



-- Region
create table region(
id int(12) auto_increment,
name varchar(64),
short_name varchar(64),
status tinyint(1),
sort int(4),
created_at int(11),
primary key(id)
);
insert into region values(1,'AMER','AMER',1,1,unix_timestamp());
insert into region values(2,'EMEA','EMEA',1,2,unix_timestamp());
insert into region values(3,'APAC','APAC',1,3,unix_timestamp());


-- Support Group
create table support_group(
id int(12) auto_increment,
name varchar(64),
short_name varchar(64),
tab_name varchar(30),
region_id int(11),
status tinyint(1),
sort int(4),
created_at int(11),
primary key(id)
);
create index idx_rid on support_group(region_id);

-- region_id = 0 is for header

insert into support_group values(1,'Cloud','Cloud','tab-cloud',0,1,unix_timestamp());
insert into support_group values(2,'On Prem','On Prem','tab-onprem',0,1,unix_timestamp());
insert into support_group values(3,'Phantom','Phantom','tab-phantom',0,1,unix_timestamp());
insert into support_group values(4,'UBA','UBA','tab-uba',0,1,unix_timestamp());
insert into support_group values(5,'Cloud Premium','Cloud Premium','tab-premium-cloud',0,1,unix_timestamp());
insert into support_group values(6,'On Prem Premium','On Prem Premium','tab-premium-onprem',0,1,unix_timestamp());
insert into support_group values(7,'Weekend Cloud On Call','Weekend Cloud On Call','tab-weekend-call-cloud',0,1,unix_timestamp());
insert into support_group values(8,'Weekend Premium On Call','Weekend Premium On Call','tab-weekend-call-onprem',0,1,unix_timestamp());


-- Support Group Shift
create table support_group_shift(
id int(12) auto_increment,
name varchar(64),
region_id int(11),
support_group_id int(11),
status tinyint(1),
sort int(4),
created_at int(11),
primary key(id)
);
create index idx_rid on support_group_shift(region_id);
create index idx_sgid on support_group_shift(support_group_id);

-- status = 0 is deactivate, status = 1 is to engr, status 2 is to mngr


-- ie AMER Cloud Shift A, B, C, D..
-- Region Amer (1), Support Group Cloud (1)
insert into support_group_shift values(1,'Shift A',1,1,1,1,unix_timestamp());
insert into support_group_shift values(2,'Shift B',1,1,1,2,unix_timestamp());
insert into support_group_shift values(3,'Shift C',1,1,1,3,unix_timestamp());
insert into support_group_shift values(4,'Shift D',1,1,1,4,unix_timestamp());
-- Region Amer (1), Support Group On Prem (2)
insert into support_group_shift values(5,'Shift A',1,2,1,1,unix_timestamp());
insert into support_group_shift values(6,'Shift B',1,2,1,2,unix_timestamp());
insert into support_group_shift values(7,'Shift C',1,2,1,3,unix_timestamp());
insert into support_group_shift values(8,'Shift D',1,2,1,4,unix_timestamp());
-- Region Amer (1), Support Group Phantom (3)
insert into support_group_shift values(9,'Shift A',1,3,1,1,unix_timestamp());
-- Region Amer (1), Support Group UBA (4)
insert into support_group_shift values(10,'10:00 AM - 6:00 PM Halifax',1,4,1,1,unix_timestamp());
insert into support_group_shift values(51,'12:00 PM - 8:00 PM Halifax',1,4,1,1,unix_timestamp());
insert into support_group_shift values(52,'2:00 PM - 10:00 PM Halifax',1,4,1,1,unix_timestamp());




-- Region Amer (1), Support Group Cloud Premium (5)
insert into support_group_shift values(11,'Shift A',1,5,1,1,unix_timestamp());
-- Region Amer (1), Support Group On Prem Premium (6)
insert into support_group_shift values(12,'Shift A',1,6,1,1,unix_timestamp());
insert into support_group_shift values(13,'Shift B',1,6,1,2,unix_timestamp());
-- Region Amer (1), Support Group Weekend Cloud On Call (7)
insert into support_group_shift values(14,'AMER EAST',1,7,1,1,unix_timestamp());
insert into support_group_shift values(15,'AMER WEST',1,7,1,2,unix_timestamp());
-- Region Amer (1), Support Group Weekend Premium On Call (8)
insert into support_group_shift values(16,'AMER EAST',1,8,1,1,unix_timestamp());
insert into support_group_shift values(17,'AMER WEST',1,8,1,2,unix_timestamp());

-- EMEA
-- Region EMEA (2), Support Group Cloud (1)
insert into support_group_shift values(18,'Shift A',2,1,1,1,unix_timestamp());
-- Region EMEA (2), Support Group On Prem (2)
insert into support_group_shift values(19,'Shift A',2,2,1,1,unix_timestamp());
insert into support_group_shift values(20,'Shift B',2,2,1,2,unix_timestamp());
insert into support_group_shift values(21,'Shift C',2,2,1,3,unix_timestamp());
-- Region EMEA (2), Support Group Phantom (3)
insert into support_group_shift values(22,'Shift A',2,3,1,1,unix_timestamp());
-- Region EMEA (2), Support Group UBA (4)
insert into support_group_shift values(23,'Shift A',2,4,1,1,unix_timestamp());
-- Region EMEA (2), Support Group Cloud Premium (5)
insert into support_group_shift values(24,'Shift A',2,5,1,1,unix_timestamp());
-- Region EMEA (2), Support Group On Prem Premium (6)
insert into support_group_shift values(25,'Shift A',2,6,1,1,unix_timestamp());
-- Region EMEA (2), Support Group Weekend Cloud On Call (7)
insert into support_group_shift values(26,'Shift A',2,7,1,1,unix_timestamp());
-- Region EMEA (2), Support Group Weekend Premium On Call (8)
insert into support_group_shift values(27,'Shift A',2,8,1,1,unix_timestamp());

-- APAC
-- Region APAC (3), Support Group Cloud (1)
insert into support_group_shift values(28,'Shift A',3,1,1,1,unix_timestamp());
insert into support_group_shift values(29,'Shift B',3,1,1,2,unix_timestamp());
-- Region APAC (3), Support Group On Prem (2)
insert into support_group_shift values(30,'Shift A',3,2,1,1,unix_timestamp());
insert into support_group_shift values(31,'Shift B',3,2,1,2,unix_timestamp());
insert into support_group_shift values(32,'Shift C',3,2,1,3,unix_timestamp());
-- Region APAC (3), Support Group Phantom (3)
insert into support_group_shift values(33,'Shift A',3,3,1,1,unix_timestamp());
-- Region APAC (3), Support Group UBA (4)
insert into support_group_shift values(34,'Shift A',3,4,1,1,unix_timestamp());
-- Region APAC (3), Support Group Cloud Premium (5)
insert into support_group_shift values(35,'Shift A',3,5,1,1,unix_timestamp());
-- Region APAC (3), Support Group On Prem Premium (6)
insert into support_group_shift values(36,'Shift A',3,6,1,1,unix_timestamp());
-- Region APAC (3), Support Group Weekend Cloud On Call (7)
insert into support_group_shift values(37,'Shift A',3,7,1,1,unix_timestamp());
-- Region APAC (3), Support Group Weekend Premium On Call (8)
insert into support_group_shift values(38,'Shift A',3,8,1,1,unix_timestamp());


-- status 2 managers
-- Region Amer (1), Support Group Cloud (1)
insert into support_group_shift values(39,'10AM - 3PM AST',1,1,2,1,unix_timestamp());
insert into support_group_shift values(40,'3PM - 6PM AST',1,1,2,2,unix_timestamp());
insert into support_group_shift values(41,'6PM - 9PM AST',1,1,2,3,unix_timestamp());
-- Region Amer (1), Support Group On Prem (2)
insert into support_group_shift values(42,'10AM - 2PM AST',1,2,2,1,unix_timestamp());
insert into support_group_shift values(43,'2PM - 6PM AST',1,2,2,2,unix_timestamp());
insert into support_group_shift values(44,'6PM - 10PM AST',1,2,2,3,unix_timestamp());
-- Region Amer (1), Support Group Cloud Premium (5)
insert into support_group_shift values(45,'10AM AST - 3PM AST',1,5,2,1,unix_timestamp());
insert into support_group_shift values(46,'3PM AST - 6PM AST',1,5,2,2,unix_timestamp());
insert into support_group_shift values(47,'6PM AST - 9PM AST',1,5,2,3,unix_timestamp());
-- Region Amer (1), Support Group On Prem Premium (6)
insert into support_group_shift values(48,'10AM AST - 3PM AST',1,6,2,1,unix_timestamp());
insert into support_group_shift values(49,'3PM AST - 6PM AST',1,6,2,2,unix_timestamp());
insert into support_group_shift values(50,'6PM AST - 9PM AST',1,6,2,3,unix_timestamp());



-- Support Group Shift Zone
create table support_group_shift_zone(
id int(12) auto_increment,
name varchar(64),
region_id int(11),
support_group_id int(11),
support_group_shift_id int(11),
status tinyint(1),
sort int(4),
created_at int(11),
primary key(id)
);
create index idx_rid on support_group_shift_zone(region_id);
create index idx_did on support_group_shift_zone(support_group_id);
create index idx_sgzid on support_group_shift_zone(support_group_shift_id);
-- ie AST 10am - 1pm
-- status = 0 is deactivate, status = 1 is to engr, status 2 is to mngr

-- Amer Cloud

-- Region Amer (1), Support Group Cloud (1), Shift A (1)
insert into support_group_shift_zone values(1,'AST 10am - 1pm',1,1,1,1,1,unix_timestamp());
insert into support_group_shift_zone values(2,'UK 2pm - 5pm',1,1,1,1,2,unix_timestamp());
insert into support_group_shift_zone values(3,'EST 9am - 12pm',1,1,1,1,3,unix_timestamp());
insert into support_group_shift_zone values(4,'CST 8am - 11am ',1,1,1,1,4,unix_timestamp());
insert into support_group_shift_zone values(5,'PST 6am - 9am',1,1,1,1,5,unix_timestamp());
insert into support_group_shift_zone values(6,'HKT 10pm - 1am',1,1,1,1,6,unix_timestamp());

-- Region Amer (1), Support Group Cloud (1), Shift B (2)
insert into support_group_shift_zone values(7,'AST 1pm - 3pm',1,1,2,1,1,unix_timestamp());
insert into support_group_shift_zone values(8,'UK 5pm - 7pm',1,1,2,1,2,unix_timestamp());
insert into support_group_shift_zone values(9,'EST 12pm - 2pm',1,1,2,1,3,unix_timestamp());
insert into support_group_shift_zone values(10,'CST 11am - 1pm',1,1,2,1,4,unix_timestamp());
insert into support_group_shift_zone values(11,'PST 9am - 11am',1,1,2,1,5,unix_timestamp());
insert into support_group_shift_zone values(12,'HKT 1am - 3am',1,1,2,1,6,unix_timestamp());

-- Region Amer (1), Support Group Cloud (1), Shift C (3)
insert into support_group_shift_zone values(13,'AST 3pm - 6pm',1,1,3,1,1,unix_timestamp());
insert into support_group_shift_zone values(14,'UK 7pm - 10pm',1,1,3,1,2,unix_timestamp());
insert into support_group_shift_zone values(15,'EST 2pm - 5pm',1,1,3,1,3,unix_timestamp());
insert into support_group_shift_zone values(16,'CST 1pm - 4pm',1,1,3,1,4,unix_timestamp());
insert into support_group_shift_zone values(17,'PST 11am - 2pm',1,1,3,1,5,unix_timestamp());
insert into support_group_shift_zone values(18,'HKT 3am - 6am',1,1,3,1,6,unix_timestamp());


-- Region Amer (1), Support Group Cloud (1), Shift D (4)
insert into support_group_shift_zone values(19,'AST 6pm - 9pm',1,1,4,1,1,unix_timestamp());
insert into support_group_shift_zone values(20,'UK 10pm - 1am',1,1,4,1,2,unix_timestamp());
insert into support_group_shift_zone values(21,'EST 5pm - 8pm',1,1,4,1,3,unix_timestamp());
insert into support_group_shift_zone values(22,'CST 4pm - 7pm',1,1,4,1,4,unix_timestamp());
insert into support_group_shift_zone values(23,'PST 2pm - 5pm',1,1,4,1,5,unix_timestamp());
insert into support_group_shift_zone values(24,'HKT 6am - 9am',1,1,4,1,6,unix_timestamp());

---- Amer On Prem

-- Region Amer (1), Support Group On Prem (2), Shift A (5)
insert into support_group_shift_zone values(25,'AST 10am - 1pm',1,2,5,1,1,unix_timestamp());
insert into support_group_shift_zone values(26,'UK 2pm - 5pm',1,2,5,1,2,unix_timestamp());
insert into support_group_shift_zone values(27,'EST 9am - 12pm',1,2,5,1,3,unix_timestamp());
insert into support_group_shift_zone values(28,'CST 8am - 11am ',1,2,5,1,4,unix_timestamp());
insert into support_group_shift_zone values(29,'PST 6am - 9am',1,2,5,1,5,unix_timestamp());
insert into support_group_shift_zone values(30,'HKT 10pm - 1am',1,2,5,1,6,unix_timestamp());

-- Region Amer (1), Support Group On Prem (2), Shift B (6)
insert into support_group_shift_zone values(31,'AST 1pm - 4pm',1,2,6,1,1,unix_timestamp());
insert into support_group_shift_zone values(32,'UK 5pm - 8pm',1,2,6,1,2,unix_timestamp());
insert into support_group_shift_zone values(33,'EST 12pm - 3pm',1,2,6,1,3,unix_timestamp());
insert into support_group_shift_zone values(34,'CST 11am - 2pm',1,2,6,1,4,unix_timestamp());
insert into support_group_shift_zone values(35,'PST 9am - 12pm',1,2,6,1,5,unix_timestamp());
insert into support_group_shift_zone values(36,'HKT 1am - 4am',1,2,6,1,6,unix_timestamp());

-- Region Amer (1), Support Group On Prem (2), Shift C (7)
insert into support_group_shift_zone values(37,'AST 4pm - 7pm',1,2,7,1,1,unix_timestamp());
insert into support_group_shift_zone values(38,'UK 8pm - 11pm',1,2,7,1,2,unix_timestamp());
insert into support_group_shift_zone values(39,'EST 3pm - 6pm',1,2,7,1,3,unix_timestamp());
insert into support_group_shift_zone values(40,'CST 2pm - 5pm',1,2,7,1,4,unix_timestamp());
insert into support_group_shift_zone values(41,'PST 12pm - 3pm',1,2,7,1,5,unix_timestamp());
insert into support_group_shift_zone values(42,'HKT 4am - 7am',1,2,7,1,6,unix_timestamp());


-- Region Amer (1), Support Group On Prem (2), Shift D (8)
insert into support_group_shift_zone values(43,'AST 7pm - 10pm',1,2,8,1,1,unix_timestamp());
insert into support_group_shift_zone values(44,'UK 11pm - 2am',1,2,8,1,2,unix_timestamp());
insert into support_group_shift_zone values(45,'EST 6pm - 9pm',1,2,8,1,3,unix_timestamp());
insert into support_group_shift_zone values(46,'CST 5pm - 8pm',1,2,8,1,4,unix_timestamp());
insert into support_group_shift_zone values(47,'PST 3pm - 6pm',1,2,8,1,5,unix_timestamp());
insert into support_group_shift_zone values(48,'HKT 7am - 10am',1,2,8,1,6,unix_timestamp());


---- Amer Phantom

-- Region Amer (1), Support Group Phantom (3), Shift A (9)
insert into support_group_shift_zone values(49,'10 AM - 10 PM (Halifax)',1,3,9,1,1,unix_timestamp());
insert into support_group_shift_zone values(50,'2 PM - 2 AM (London)',1,3,9,1,2,unix_timestamp());
insert into support_group_shift_zone values(51,'8 AM - 8 PM (Plano)',1,3,9,1,3,unix_timestamp());
insert into support_group_shift_zone values(52,'6 AM - 6 PM (SF)',1,3,9,1,4,unix_timestamp());
insert into support_group_shift_zone values(53,'9 PM - 9 AM (HK)',1,3,9,1,5,unix_timestamp());


---- Amer UBA

-- Region Amer (1), Support Group UBA (4), Shift A (10)
-- nothing



---- Amer Cloud Premium

-- Region Amer (1), Support Group Cloud Premium (5), Shift A (11)
insert into support_group_shift_zone values(54,'12:00 - 03:00 GMT (London)',1,5,11,1,1,unix_timestamp());
insert into support_group_shift_zone values(55,'08:00 - 23:00 AST (Halifax)',1,5,11,1,2,unix_timestamp());
insert into support_group_shift_zone values(56,'07:00 - 22:00 EST (Tysons)',1,5,11,1,3,unix_timestamp());
insert into support_group_shift_zone values(57,'06:00 - 17:00 CST (Plano)',1,5,11,1,4,unix_timestamp());
insert into support_group_shift_zone values(58,'04:00 - 19:00 PST (SF)',1,5,11,1,5,unix_timestamp());
insert into support_group_shift_zone values(59,'23:00 - 14:00 AEST (Sydney)',1,5,11,1,6,unix_timestamp());


---- Amer On-Prem Premium

-- Region Amer (1), Support Group On Prem Premium (6), Early (12)
insert into support_group_shift_zone values(60,'6AM -12PM PST (SF)',1,6,12,1,1,unix_timestamp());
insert into support_group_shift_zone values(61,'9PM - 3AM HKT (HK)',1,6,12,1,2,unix_timestamp());
insert into support_group_shift_zone values(62,'2PM - 8PM GMT (London)',1,6,12,1,3,unix_timestamp());
insert into support_group_shift_zone values(63,'9AM - 3PM EST (Tysons)',1,6,12,1,4,unix_timestamp());
insert into support_group_shift_zone values(64,'10 AM - 4 PM AST (Halifax)',1,6,12,1,5,unix_timestamp());

-- Region Amer (1), Support Group On Prem Premium (6), Late (13)
insert into support_group_shift_zone values(65,'12PM - 6PM PST (SF)',1,6,13,1,1,unix_timestamp());
insert into support_group_shift_zone values(66,'3AM - 9AMHKT (HK)',1,6,13,1,2,unix_timestamp());
insert into support_group_shift_zone values(67,'8PM - 2AM GMT (London)',1,6,13,1,3,unix_timestamp());
insert into support_group_shift_zone values(68,'3PM - 9PM EST (Tysons)',1,6,13,1,4,unix_timestamp());
insert into support_group_shift_zone values(69,'4 PM - 10 PM AST (Halifax)',1,6,13,1,5,unix_timestamp());


---- Amer Weekend Cloud On Call

-- Region Amer (1), Support Group Weekend Cloud On Call (7), EAST (14)
insert into support_group_shift_zone values(70,'13:00 to 21:00 Standard Time (UTC)',1,7,14,1,1,unix_timestamp());
insert into support_group_shift_zone values(71,'12:00 to 20:00 AMER DST (UTC)',1,7,14,1,2,unix_timestamp());

-- Region Amer (1), Support Group Weekend Cloud On Call (7), WEST (15)
insert into support_group_shift_zone values(72,'17:00 to 01:00 Standard Time (UTC)',1,7,15,1,1,unix_timestamp());
insert into support_group_shift_zone values(73,'16:00 to 00:00 AMER DST (UTC)',1,7,15,1,2,unix_timestamp());


---- Amer Weekend On Prem On Call

-- Region Amer (1), Support Group Weekend Cloud On Call (8), EAST (16)
insert into support_group_shift_zone values(74,'13:00 to 23:00 Standard Time (UTC)',1,8,16,1,1,unix_timestamp());
insert into support_group_shift_zone values(75,'12:00 to 22:00 AMER DST (UTC)',1,8,16,1,2,unix_timestamp());

-- Region Amer (1), Support Group Weekend Cloud On Call (8), WEST (17)
insert into support_group_shift_zone values(76,'15:00 to 01:00 Standard Time (UTC)',1,8,17,1,1,unix_timestamp());
insert into support_group_shift_zone values(77,'14:00 to 00:00 AMER DST (UTC)',1,8,17,1,2,unix_timestamp());




--- ========================================== EMEA

-- Cloud
-- Region EMEA (2), Support Group Cloud (1), Shift A (18)
insert into support_group_shift_zone values(78,'AST (Halifax) 4 AM - 10 AM',2,1,18,1,1,unix_timestamp());
insert into support_group_shift_zone values(79,'UK (London) 8 AM - 2 PM',2,1,1,18,2,unix_timestamp());
insert into support_group_shift_zone values(80,'EST (Tyson) 3 AM - 9 AM',2,1,18,1,3,unix_timestamp());
insert into support_group_shift_zone values(81,'CST (Plano) 2 AM - 8 AM',2,1,18,1,4,unix_timestamp());
insert into support_group_shift_zone values(82,'PST (SF) 12 AM - 6 AM',2,1,18,1,5,unix_timestamp());
insert into support_group_shift_zone values(83,'AEDT (Sydney) 7 PM - 1 AM',2,1,18,1,6,unix_timestamp());

--- On Prem
-- Region EMEA (2), Support Group On Prem (2), Shift A (19)
insert into support_group_shift_zone values(84,'AST (Halifax) 4 AM-5 AM',2,2,19,1,1,unix_timestamp());
insert into support_group_shift_zone values(85,'UK (London) 8 AM-9 AM',2,2,19,1,2,unix_timestamp());
insert into support_group_shift_zone values(86,'EST (Tyson) 3 AM-4 AM',2,2,19,1,3,unix_timestamp());
insert into support_group_shift_zone values(87,'CST (Plano) 2AM-3AM',2,2,19,1,4,unix_timestamp());
insert into support_group_shift_zone values(88,'PST (SF) 12 AM-1 AM',2,2,19,1,5,unix_timestamp());
insert into support_group_shift_zone values(89,'AEDT (Sydney) 3 PM - 4 PM',2,2,19,1,6,unix_timestamp());

-- Region EMEA (2), Support Group On Prem (2), Shift B (20)
insert into support_group_shift_zone values(90,'AST (Halifax) 5 AM-7:30 AM',2,2,20,1,1,unix_timestamp());
insert into support_group_shift_zone values(91,'UK (London) 9 AM-11:30 AM',2,2,20,1,2,unix_timestamp());
insert into support_group_shift_zone values(92,'EST (Tyson) 4 AM-6:30 AM',2,2,20,1,3,unix_timestamp());
insert into support_group_shift_zone values(93,'CST (Plano) 3 AM-5:30 AM',2,2,20,1,4,unix_timestamp());
insert into support_group_shift_zone values(94,'PST (SF) 1 AM-3:30 AM',2,2,20,1,5,unix_timestamp());
insert into support_group_shift_zone values(95,'AEDT (Sydney) 4:00 PM - 6:30 PM',2,2,20,1,6,unix_timestamp());

-- Region EMEA (2), Support Group On Prem (2), Shift C (21)
insert into support_group_shift_zone values(96,'AST (Halifax) 7:30 AM-10 AM',2,2,21,1,1,unix_timestamp());
insert into support_group_shift_zone values(97,'UK (London) 11:30 PM-2 PM',2,2,21,1,2,unix_timestamp());
insert into support_group_shift_zone values(98,'EST (Tyson) 6:30 AM-9 AM',2,2,21,1,3,unix_timestamp());
insert into support_group_shift_zone values(99,'CST (Plano) 5:30 AM-8 AM',2,2,21,1,4,unix_timestamp());
insert into support_group_shift_zone values(100,'PST (SF) 3:30 AM-6 AM',2,2,21,1,5,unix_timestamp());
insert into support_group_shift_zone values(101,'AEDT (Sydney) 6:30 PM - 9:00 PM',2,2,21,1,6,unix_timestamp());


-- Phantom (3)
-- Region EMEA (2), Support Group Phanto=m (3), Shift A (22)
insert into support_group_shift_zone values(102,'4 AM - 10 AM (Halifax)',2,3,22,1,1,unix_timestamp());
insert into support_group_shift_zone values(103,'8 AM - 2 PM (London)',2,3,22,1,2,unix_timestamp());
insert into support_group_shift_zone values(104,'2 AM - 8 AM (Plano)',2,3,22,1,3,unix_timestamp());
insert into support_group_shift_zone values(105,'12 AM - 6 AM (SF)',2,3,22,1,4,unix_timestamp());
insert into support_group_shift_zone values(106,'3 PM - 9 PM (HK)',2,3,22,1,5,unix_timestamp());


-- UBA (4)
-- Region EMEA (2), Support Group UBA (4), Shift A (23)
insert into support_group_shift_zone values(107,'4 AM - 10 AM (Halifax)',2,4,23,1,1,unix_timestamp());

-- Premium Cloud (5)
-- Region EMEA (2), Support Premium Cloud (5), Shift A (24)
insert into support_group_shift_zone values(108,'08:00 - 14:00 GMT (London)',2,5,24,1,1,unix_timestamp());
insert into support_group_shift_zone values(109,'04:00 - 10:00 AST (Halifax)',2,5,24,1,2,unix_timestamp());
insert into support_group_shift_zone values(110,'03:00 - 09:00 EST (Tysons)',2,5,24,1,3,unix_timestamp());
insert into support_group_shift_zone values(111,'02:00 - 08:00 CST (Plano)',2,5,24,1,4,unix_timestamp());
insert into support_group_shift_zone values(112,'00:00 - 06:00 PST (SF)',2,5,24,1,5,unix_timestamp());
insert into support_group_shift_zone values(113,'19:00 - 01:00 AEST (Sydney)',1,5,24,1,6,unix_timestamp());


-- Premium On Prem (6)
-- Region EMEA (2), Support Group On Prem Premium (6), Shift A (25)
insert into support_group_shift_zone values(114,'12AM - 6AM PST (SF)',2,6,25,1,1,unix_timestamp());
insert into support_group_shift_zone values(115,'3PM - 9PM HKT (HK)',2,6,25,1,2,unix_timestamp());
insert into support_group_shift_zone values(116,'8AM - 2PM GMT (London)',2,6,25,1,3,unix_timestamp());
insert into support_group_shift_zone values(117,'3AM - 9AM EST (Tysons)',2,6,25,1,4,unix_timestamp());
insert into support_group_shift_zone values(118,'4AM - 10AM AST (Halifax)',2,6,25,1,5,unix_timestamp());


-- Weeken Cloud On Call (7)
-- Region EMEA (2), Support Group Weekend Cloud On Call (7), Shift A (26)
insert into support_group_shift_zone values(119,'07:00 to 15:00 Standard Time (UTC)',2,7,26,1,1,unix_timestamp());
insert into support_group_shift_zone values(120,'06:00 to 14:00 AMER DST (UTC)',2,7,26,1,2,unix_timestamp());

-- Weeken On Prem On Call (8)
-- Region EMEA (2), Support Group Weekend On Prem On Call (8), Shift A (27)
insert into support_group_shift_zone values(121,'07:00 to 15:00 Standard Time (UTC)',2,8,27,1,1,unix_timestamp());
insert into support_group_shift_zone values(122,'06:00 to 14:00 AMER DST (UTC)',2,8,27,1,2,unix_timestamp());




---============================= APAC

-- Cloud
-- Region APAC (3), Support Group Cloud (1), Shift A (28)
insert into support_group_shift_zone values(123,'ADT (Halifax) 10PM - 1AM',3,1,28,1,1,unix_timestamp());
insert into support_group_shift_zone values(124,'BT (London) ?',3,1,1,28,2,unix_timestamp());
insert into support_group_shift_zone values(125,'EST (Tyson) ?',3,1,28,1,3,unix_timestamp());
insert into support_group_shift_zone values(126,'CST (Plano) ?',3,1,28,1,4,unix_timestamp());
insert into support_group_shift_zone values(127,'PST (SF) ?',3,1,28,1,5,unix_timestamp());
insert into support_group_shift_zone values(128,'AEST (Sydney) 11AM - 2PM',3,1,28,1,6,unix_timestamp());

-- Region APAC (3), Support Group Cloud (1), Shift B (29)
insert into support_group_shift_zone values(129,'ADT (Halifax) 1AM- 4AM',3,1,29,1,1,unix_timestamp());
insert into support_group_shift_zone values(130,'BT (London) ?',3,1,1,29,2,unix_timestamp());
insert into support_group_shift_zone values(131,'EST (Tyson) ?',3,1,29,1,3,unix_timestamp());
insert into support_group_shift_zone values(132,'CST (Plano) ?',3,1,29,1,4,unix_timestamp());
insert into support_group_shift_zone values(133,'PST (SF) ?',3,1,29,1,5,unix_timestamp());


--- On Prem
-- Region APAC (3), Support Group On Prem (2), Shift A (30)
insert into support_group_shift_zone values(134,'ADT (Halifax) 1AM- 4AM',3,2,30,1,1,unix_timestamp());
insert into support_group_shift_zone values(135,'UK (London) ?',3,2,30,1,2,unix_timestamp());
insert into support_group_shift_zone values(136,'ET (Tyson) ?',3,2,30,1,3,unix_timestamp());
insert into support_group_shift_zone values(137,'CT (Plano) ?',3,2,30,1,4,unix_timestamp());
insert into support_group_shift_zone values(138,'PT (SF) ?',3,2,30,1,5,unix_timestamp());
insert into support_group_shift_zone values(139,'HKT (HK) ?',3,2,30,1,6,unix_timestamp());
insert into support_group_shift_zone values(140,'IST (Bangalore) ?',3,2,30,1,7,unix_timestamp());



-- Rotation
create table rotation(
id int(12) auto_increment,
case_type int(4),
mode int(4),
support_id int(11),
engaged_at datetime,
simple_date_at date,
month_num int(2),
week_num int(4),
week_char varchar(20),
day_num int(4),
day_char varchar(20),
count int(4),
comment varchar(300),
status tinyint(1),
created_at int(11),
deleted_at int(11),
primary key(id)
);
-- case_type = 1 is to P1 or 2 is to P2, etc
-- mode - 1 is for answered/assigned (count++), 2 is for missed call/unanswered (count++ missed), 3 is reset (clear count that day for answered and missed), 4 engr update (set on), 5 engr update (set off)
-- support_id = is the enginner - this is the id of table account id

-- endpoints
-- p1/update - mode 4|5 this is to set engr on / off availability
-- p1/update - parameters: engr (account.email input - lookup account.id via email input to rotation.support_id), comment (text input), mode: on|off  (update account status_p1, update rotation.status, rotation.mode (4|5)
-- if updating though curl use email if not, use account.id


-- p1/assign - For CSI to assign engr. Mode: Answered | Missed Call | Reset (1|2|3)





-- Setting
create table setting(
id int(11) auto_increment,
`type` varchar(32),
sub_type varchar(64),
`group` varchar(32),
`key` varchar(64),
`value` text,
sort int(4),
image varchar(64),
primary key(id)
);

insert into setting values('','case_type','','','P1','1',1,'');


insert into setting values('','rotation','mode','','Answered','1',1,'');
insert into setting values('','rotation','mode','','Missed Call','2',2,'');


-- Account Status
insert into setting values('','account','status','','1','Available','1','');
insert into setting values('','account','status','','2','NOT Available','2','');



-- Splunk Date
create table splunk_date(
  date date,
  spldate varchar(30),
  yearweek int(11),
  week int(2),
  weekday int(2),
  day int(2),
  dayname varchar(10),
  month int(2),
  monthname varchar(15),
  year int(4),
  primary key(date)
);
insert into splunk_date select curdate(), concat(month(curdate()),'/',day(curdate()),'/',year(curdate())), yearweek(curdate()), week(curdate()), weekday(curdate()), day(curdate()), dayname(curdate()), month(curdate()), monthname(curdate()), year(curdate());
-- tomorrow
insert into splunk_date select date_add(curdate(),interval 1 day), concat(month(date_add(curdate(),interval 1 day)),'/',day(date_add(curdate(),interval 1 day)),'/',year(date_add(curdate(),interval 1 day))), yearweek(date_add(curdate(),interval 1 day)), week(date_add(curdate(),interval 1 day)), weekday(date_add(curdate(),interval 1 day)), day(date_add(curdate(),interval 1 day)), dayname(date_add(curdate(),interval 1 day)), month(date_add(curdate(),interval 1 day)), monthname(date_add(curdate(),interval 1 day)), year(date_add(curdate(),interval 1 day));


-- https://timezonedb.com/download
--timezone
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
    `country_code` CHAR(2) NULL,
    `country_name` VARCHAR(45) NULL,
    INDEX `idx_country_code` (`country_code`)
) COLLATE='utf8_bin' ENGINE=MyISAM;
 
-- LOAD DATA LOCAL INFILE 'country.csv' INTO TABLE `country` FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';
 
 
DROP TABLE IF EXISTS `timezone`;
CREATE TABLE `timezone` (
    `zone_id` INT(10) NOT NULL,
    `abbreviation` VARCHAR(6) NOT NULL,
    `time_start` INT NOT NULL,
    `gmt_offset` INT NOT NULL,
    `dst` CHAR(1) NOT NULL,
    INDEX `idx_zone_id` (`zone_id`),
    INDEX `idx_time_start` (`time_start`)
) COLLATE='utf8_bin' ENGINE=MyISAM;
 
-- LOAD DATA LOCAL INFILE 'timezone.csv' INTO TABLE `timezone` FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';
 
 
DROP TABLE IF EXISTS `zone`;
CREATE TABLE `zone` (
    `zone_id` INT(10) NOT NULL AUTO_INCREMENT,
    `country_code` CHAR(2) NOT NULL,
    `zone_name` VARCHAR(35) NOT NULL,
    PRIMARY KEY (`zone_id`),
    INDEX `idx_zone_name` (`zone_name`)
) COLLATE='utf8_bin' ENGINE=MyISAM;
 
-- LOAD DATA LOCAL INFILE 'zone.csv' INTO TABLE `zone` FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';



======
load data local infile '/home/wdsurhpiw1q0/www/app/db/US.txt' into table postal fields terminated by '\t';


country code      : iso country code, 2 characters
postal code       : varchar(20)
place name        : varchar(180)
admin name1       : 1. order subdivision (state) varchar(100)
admin code1       : 1. order subdivision (state) varchar(20)
admin name2       : 2. order subdivision (county/province) varchar(100)
admin code2       : 2. order subdivision (county/province) varchar(20)
admin name3       : 3. order subdivision (community) varchar(100)
admin code3       : 3. order subdivision (community) varchar(20)
latitude          : estimated latitude (wgs84)
longitude         : estimated longitude (wgs84)
accuracy          : accuracy of lat/lng from 1=estimated to 6=centroid




create table status(
id smallint(6) auto_increment,
name varchar(100),
description tinytext,
status smallint(6),
sort smallint(6),
created_at int(11),
deleted_at int(11),
primary key(id)
);

insert into status values('','Active','',1,1,now(),NULL);
insert into status values('','In Review','',1,2,now(),NULL);
insert into status values('','Approved','',1,3,now(),NULL);
insert into status values('','Suspended','',1,4,now(),NULL);


