-- Setting up the database

CREATE DATABASE ACMSPro_Main;
USE ACMSPro_Main;

-- DDL
-- no foreign KEY
CREATE TABLE Course(
	course_id varchar(16) NOT NULL PRIMARY KEY,
	course_name varchar(128) NOT NULL	
);
CREATE TABLE Countries(
	country_id char(3) NOT NULL PRIMARY KEY,
	country_name varchar(64)
);
CREATE TABLE AdminUser(
	admin_id int(8) NOT NULL PRIMARY KEY,
	first_name varchar(64) NOT NULL,
	middle_name varchar(64),
	last_name varchar(64) NOT NULL,
	title varchar(64),
	password_hash char(64) NOT NULL,
	salt char(8) NOT NULL
);
-- refrencesed tables
CREATE TABLE StudentUser(
	student_id int(8) NOT NULL PRIMARY KEY,
	first_name varchar(64) NOT NULL,
	middle_name varchar(64),
	last_name varchar(64) NOT NULL,
	course_id varchar(16) NOT NULL,
	intake varchar(16),
	password_hash char(64) NOT NULL,
	salt char(8) NOT NULL,
	blocked bit(1) default 0,
	FOREIGN KEY (course_id) REFERENCES Course(course_id) 
);
CREATE TABLE PendingStudentUser(
	student_id int(8) NOT NULL,
	reg_id int(8),
	first_name varchar(64) NOT NULL,
	middle_name varchar(64),
	last_name varchar(64) NOT NULL,
	course_id varchar(16) NOT NULL,
	intake varchar(16),
	pending tinyint(1) default 1,
	password_hash char(64) NOT NULL,
	salt char(8) NOT NULL,
	PRIMARY KEY(student_id, reg_id),
	FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
CREATE TABLE Bookmarks(
	student_id int(8) NOT NULL,
	bookmark_index int(4) NOT NULL,
	target_id int(8) NOT NULL,
	PRIMARY KEY(student_id, bookmark_index),
	FOREIGN KEY (student_id) REFERENCES StudentUser(student_id),
	FOREIGN KEY (target_id) REFERENCES StudentUser(student_id)
);
CREATE TABLE Emails(
	student_id int(8) NOT NULL,
	email_index int(8) NOT NULL,
	email varchar(64) NOT NULL,
	description text,
	isHidden bit(1) default 0,
	PRIMARY KEY (student_id,email_index),
	FOREIGN KEY (student_id) REFERENCES StudentUser(student_id)
);
CREATE TABLE PhoneNum(
	student_id int(8) NOT NULL,
	phoneNum_index int(8) NOT NULL,
	phoneNum varchar(64) NOT NULL,
	description text,
	isHidden bit(1) default 0,
	PRIMARY KEY (student_id,phoneNum_index),
	FOREIGN KEY (student_id) REFERENCES StudentUser(student_id)
);

CREATE TABLE Address(
	student_id int(8) NOT NULL,
	address_index int(8) NOT NULL,
	address_line1 text NOT NULL,
	address_line2 text,
	city varchar(64),
	state_province  varchar(64),
	country_id char(3) NOT NULL,
	description text,
	isHidden bit(1) default 0,
	PRIMARY KEY (student_id,address_index),
	FOREIGN KEY (student_id) REFERENCES StudentUser(student_id),
	FOREIGN KEY (country_id) REFERENCES Countries(country_id)
);

CREATE TABLE PasswordToken(
	token varchar(64),
	student_id int(8),
	PRIMARY KEY (token),
	FOREIGN KEY (student_id) REFERENCES StudentUser(student_id)
);

CREATE TABLE Messages(
	sender_id int(8) NOT NULL,
	target_id int(8) NOT NULL,
	msg_index int(8) NOT NULL,
	content longtext,
	send_date date NOT NULL,
	is_read bit(0) NOT NULL DEFAULT 0,
	PRIMARY KEY (sender_id, target_id, msg_index)
);

-- DML (Pre-set values)

insert into Countries(country_name,country_id) values
("Afghanistan","AFG"),
("Aland Islands","ALA"),
("Albania","ALB"),
("Algeria","DZA"),
("American Samoa","ASM"),
("Andorra","AND"),
("Angola","AGO"),
("Anguilla","AIA"),
("Antarctica","ATA"),
("Antigua and Barbuda","ATG"),
("Argentina","ARG"),
("Armenia","ARM"),
("Aruba","ABW"),
("Australia","AUS"),
("Austria","AUT"),
("Azerbaijan","AZE"),
("Bahamas","BHS"),
("Bahrain","BHR"),
("Bangladesh","BGD"),
("Barbados","BRB"),
("Belarus","BLR"),
("Belgium","BEL"),
("Belize","BLZ"),
("Benin","BEN"),
("Bermuda","BMU"),
("Bhutan","BTN"),
("Bolivia","BOL"),
("Bosnia and Herzegovina","BIH"),
("Botswana","BWA"),
("Bouvet Island","BVT"),
("Brazil","BRA"),
("British Virgin Islands","VGB"),
("British Indian Ocean Territory","IOT"),
("Brunei Darussalam","BRN"),
("Bulgaria","BGR"),
("Burkina Faso","BFA"),
("Burundi","BDI"),
("Cambodia","KHM"),
("Cameroon","CMR"),
("Canada","CAN"),
("Cape Verde","CPV"),
("Cayman Islands","CYM"),
("Central African Republic","CAF"),
("Chad","TCD"),
("Chile","CHL"),
("China","CHN"),
("Hong Kong, SAR China","HKG"),
("Macao, SAR China","MAC"),
("Christmas Island","CXR"),
("Cocos (Keeling) Islands","CCK"),
("Colombia","COL"),
("Comoros","COM"),
("Congo (Brazzaville)","COG"),
("Congo, (Kinshasa)","COD"),
("Cook Islands","COK"),
("Costa Rica","CRI"),
("Côte d'Ivoire","CIV"),
("Croatia","HRV"),
("Cuba","CUB"),
("Cyprus","CYP"),
("Czech Republic","CZE"),
("Denmark","DNK"),
("Djibouti","DJI"),
("Dominica","DMA"),
("Dominican Republic","DOM"),
("Ecuador","ECU"),
("Egypt","EGY"),
("El Salvador","SLV"),
("Equatorial Guinea","GNQ"),
("Eritrea","ERI"),
("Estonia","EST"),
("Ethiopia","ETH"),
("Falkland Islands (Malvinas)","FLK"),
("Faroe Islands","FRO"),
("Fiji","FJI"),
("Finland","FIN"),
("France","FRA"),
("French Guiana","GUF"),
("French Polynesia","PYF"),
("French Southern Territories","ATF"),
("Gabon","GAB"),
("Gambia","GMB"),
("Georgia","GEO"),
("Germany","DEU"),
("Ghana","GHA"),
("Gibraltar","GIB"),
("Greece","GRC"),
("Greenland","GRL"),
("Grenada","GRD"),
("Guadeloupe","GLP"),
("Guam","GUM"),
("Guatemala","GTM"),
("Guernsey","GGY"),
("Guinea","GIN"),
("Guinea-Bissau","GNB"),
("Guyana","GUY"),
("Haiti","HTI"),
("Heard and Mcdonald Islands","HMD"),
("Holy See (Vatican City State)","VAT"),
("Honduras","HND"),
("Hungary","HUN"),
("Iceland","ISL"),
("India","IND"),
("Indonesia","IDN"),
("Iran, Islamic Republic of","IRN"),
("Iraq","IRQ"),
("Ireland","IRL"),
("Isle of Man","IMN"),
("Israel","ISR"),
("Italy","ITA"),
("Jamaica","JAM"),
("Japan","JPN"),
("Jersey","JEY"),
("Jordan","JOR"),
("Kazakhstan","KAZ"),
("Kenya","KEN"),
("Kiribati","KIR"),
("Korea (North)","PRK"),
("Korea (South)","KOR"),
("Kuwait","KWT"),
("Kyrgyzstan","KGZ"),
("Lao PDR","LAO"),
("Latvia","LVA"),
("Lebanon","LBN"),
("Lesotho","LSO"),
("Liberia","LBR"),
("Libya","LBY"),
("Liechtenstein","LIE"),
("Lithuania","LTU"),
("Luxembourg","LUX"),
("Macedonia, Republic of","MKD"),
("Madagascar","MDG"),
("Malawi","MWI"),
("Malaysia","MYS"),
("Maldives","MDV"),
("Mali","MLI"),
("Malta","MLT"),
("Marshall Islands","MHL"),
("Martinique","MTQ"),
("Mauritania","MRT"),
("Mauritius","MUS"),
("Mayotte","MYT"),
("Mexico","MEX"),
("Micronesia, Federated States of","FSM"),
("Moldova","MDA"),
("Monaco","MCO"),
("Mongolia","MNG"),
("Montenegro","MNE"),
("Montserrat","MSR"),
("Morocco","MAR"),
("Mozambique","MOZ"),
("Myanmar","MMR"),
("Namibia","NAM"),
("Nauru","NRU"),
("Nepal","NPL"),
("Netherlands","NLD"),
("Netherlands Antilles","ANT"),
("New Caledonia","NCL"),
("New Zealand","NZL"),
("Nicaragua","NIC"),
("Niger","NER"),
("Nigeria","NGA"),
("Niue","NIU"),
("Norfolk Island","NFK"),
("Northern Mariana Islands","MNP"),
("Norway","NOR"),
("Oman","OMN"),
("Pakistan","PAK"),
("Palau","PLW"),
("Palestinian Territory","PSE"),
("Panama","PAN"),
("Papua New Guinea","PNG"),
("Paraguay","PRY"),
("Peru","PER"),
("Philippines","PHL"),
("Pitcairn","PCN"),
("Poland","POL"),
("Portugal","PRT"),
("Puerto Rico","PRI"),
("Qatar","QAT"),
("Réunion","REU"),
("Romania","ROU"),
("Russian Federation","RUS"),
("Rwanda","RWA"),
("Saint-Barthélemy","BLM"),
("Saint Helena","SHN"),
("Saint Kitts and Nevis","KNA"),
("Saint Lucia","LCA"),
("Saint-Martin (French part)","MAF"),
("Saint Pierre and Miquelon","SPM"),
("Saint Vincent and Grenadines","VCT"),
("Samoa","WSM"),
("San Marino","SMR"),
("Sao Tome and Principe","STP"),
("Saudi Arabia","SAU"),
("Senegal","SEN"),
("Serbia","SRB"),
("Seychelles","SYC"),
("Sierra Leone","SLE"),
("Singapore","SGP"),
("Slovakia","SVK"),
("Slovenia","SVN"),
("Solomon Islands","SLB"),
("Somalia","SOM"),
("South Africa","ZAF"),
("South Georgia and the South Sandwich Islands","SGS"),
("South Sudan","SSD"),
("Spain","ESP"),
("Sri Lanka","LKA"),
("Sudan","SDN"),
("Suriname","SUR"),
("Svalbard and Jan Mayen Islands","SJM"),
("Swaziland","SWZ"),
("Sweden","SWE"),
("Switzerland","CHE"),
("Syrian Arab Republic (Syria)","SYR"),
("Taiwan (R.O.C)","TWN"),
("Tajikistan","TJK"),
("Tanzania, United Republic of","TZA"),
("Thailand","THA"),
("Timor-Leste","TLS"),
("Togo","TGO"),
("Tokelau","TKL"),
("Tonga","TON"),
("Trinidad and Tobago","TTO"),
("Tunisia","TUN"),
("TurKEY","TUR"),
("Turkmenistan","TKM"),
("Turks and Caicos Islands","TCA"),
("Tuvalu","TUV"),
("Uganda","UGA"),
("Ukraine","UKR"),
("United Arab Emirates","ARE"),
("United Kingdom","GBR"),
("United States of America","USA"),
("US Minor Outlying Islands","UMI"),
("Uruguay","URY"),
("Uzbekistan","UZB"),
("Vanuatu","VUT"),
("Venezuela (Bolivarian Republic)","VEN"),
("Viet Nam","VNM"),
("Virgin Islands, US","VIR"),
("Wallis and Futuna Islands","WLF"),
("Western Sahara","ESH"),
("Yemen","YEM"),
("Zambia","ZMB"),
("Zimbabwe","ZWE");

insert into Course values
("ACCA","ACCA Qualification"),
("AFIA","ACCA Foundation in Accountancy"),
("ALE","Cambridge GCE Advanced Level"),
("ALE(HS)","Cambridge GCE Advanced Level Head Start"),
("AUSMA","Australian Matriculation Programme"),
("AUSMA(HS)","Australian Matriculation Programme Head Start"),
("CAT","Certified Accounting Technician"),
("CBS","Certificate in Business Studies"),
("CFAB","Certificate in Finance, Accounting and Business"),
("CIMP","Canadian International Matriculation Programme (CIMP)"),
("CIMP(HS)","Canadian International Matriculation Programme (CIMP) Head Start"),
("DACC","Diploma in Accounting"),
("DBA","Diploma in Business Administration"),
("DCOM","Diploma in Communication"),
("DCSI","Diploma in Computer Science"),
("DFIN","Diploma in Finance"),
("DIIT","Diploma in Information Technology"),
("DINM","Diploma in Interactive New Media"),
("DPAC","Diploma in Professional Accounting"),
("FCEO(CAT)","Future CEO Certified Accounting Technician"),
("FCEO(CFAB)","Future CEO Certificate in Finance, Accounting and Business"),
("FEP","Foundation English Programme "),
("FIA","Foundation in Arts"),
("FIA(HS)","Foundation in Arts Head Start"),
("FIST","Foundation in Science and Technology"),
("FIST(HS)","Foundation in Science and Technology Head Start"),
("GIFPR","Global Issues for the Finance Professional"),
("GL","German Language Preparatory Programm"),
("ICAEW","Institute of Chartered Accountants in England and Wales (ICAEW)"),
("MUFY","Monash University Foundation Year"),
("MUFY(HS)","Monash University Foundation Year Head Start"),
("SC-ACA","ACA USM"),
("SFMGT","Strategic Financial Management"),
("SFPRO","Strategic Financial Project"),
("SPMGT","Strategic Performance Management"),
("VUBU","Bachelor of Business 3+0 in Collaboration with Victoria University of Melbourne, Australi"),
("VUENG","English for Business' Enrichment Programme"),
("VUMB(ERPS)","Master of Business (Enterprise Resource Planning Systems) in Collaboration with Victoria "),
("VUMBA","Master of Business Administration in Collaboration with Victoria University, Australia"),
("VUSUMMER","Bachelor of Business - Summer School"),
("WHK-ACCA","ACCA WORKSHOP");