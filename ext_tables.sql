#
# Table structure for table 'tx_operations_domain_model_operation'
#
CREATE TABLE tx_operations_domain_model_operation (

	number varchar(255) DEFAULT '' NOT NULL,
	onlyEld tinyint(4) unsigned DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	path_segment varchar(2048),
	location text NOT NULL,
	begin int(11) DEFAULT '0' NOT NULL,
	end int(11) DEFAULT '0' NOT NULL,
	teaser text NOT NULL,
	report text NOT NULL,
	longitude varchar(255) DEFAULT '' NOT NULL,
	latitude varchar(255) DEFAULT '' NOT NULL,
	zoom int(11) DEFAULT '0' NOT NULL,
	media varchar(255) DEFAULT '' NOT NULL,
	type int(11) unsigned DEFAULT '0' NOT NULL,
	assistance int(11) unsigned DEFAULT '0' NOT NULL,
	vehicles int(11) unsigned DEFAULT '0' NOT NULL,
	resources int(11) unsigned DEFAULT '0' NOT NULL,
	category int(11) unsigned DEFAULT '0' NOT NULL,

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
	color varchar(25) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_operations_operation_type_mm'
#
CREATE TABLE tx_operations_operation_type_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_operations_operation_assistance_mm'
#
CREATE TABLE tx_operations_operation_assistance_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_operations_operation_vehicle_mm'
#
CREATE TABLE tx_operations_operation_vehicle_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_operations_operation_resource_mm'
#
CREATE TABLE tx_operations_operation_resource_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_operations_operation_category_mm'
#
CREATE TABLE tx_operations_operation_category_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	field varchar(50) DEFAULT '' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
