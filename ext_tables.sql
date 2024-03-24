CREATE TABLE tx_waf_domain_model_log (
	`type` INT(11) DEFAULT '0' NOT NULL,
	`channel` VARCHAR(120) DEFAULT 'default' NOT NULL,
	`log_data` TEXT,
	`message` VARCHAR(255) DEFAULT '' NOT NULL,
);
