#
# Table structure for table 'tx_operations_domain_model_operation'
#
CREATE TABLE tx_operations_domain_model_operation (

	number varchar(255) DEFAULT '' NOT NULL,
	onlyEld tinyint(4) unsigned DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	path_segment varchar(2048),
	location text DEFAULT '' NOT NULL,
	begin int(11) DEFAULT '0' NOT NULL,
	end int(11) DEFAULT '0' NOT NULL,
	teaser text DEFAULT '' NOT NULL,
	report text DEFAULT '' NOT NULL,
	longitude varchar(255) DEFAULT '' NOT NULL,
	latitude varchar(255) DEFAULT '' NOT NULL,
	zoom int(11) DEFAULT '0' NOT NULL,
	media varchar(255) DEFAULT '' NOT NULL,
	type int(11) unsigned DEFAULT '0' NOT NULL,
	assistance int(11) unsigned DEFAULT '0' NOT NULL,
	vehicles int(11) unsigned DEFAULT '0' NOT NULL,
	resources int(11) unsigned DEFAULT '0' NOT NULL,
	category int(11) unsigned DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_operations_domain_model_assistance'
#
CREATE TABLE tx_operations_domain_model_assistance (

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL

);

#
# Table structure for table 'tx_operations_domain_model_vehicle'
#
CREATE TABLE tx_operations_domain_model_vehicle (

	title varchar(255) DEFAULT '' NOT NULL,
	path_segment varchar(2048),
	short varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	media varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL

);

#
# Table structure for table 'tx_operations_domain_model_resource'
#
CREATE TABLE tx_operations_domain_model_resource (

	title varchar(255) DEFAULT '' NOT NULL,
	path_segment varchar(2048),
	short varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	media varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL

);

#
# Table structure for table 'tx_operations_domain_model_type'
#
CREATE TABLE tx_operations_domain_model_type (

	title varchar(255) DEFAULT '' NOT NULL,
	image varchar(255) DEFAULT '' NOT NULL,
	color varchar(25) DEFAULT '' NOT NULL

);
