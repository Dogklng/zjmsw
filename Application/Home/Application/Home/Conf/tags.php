<?php
/**
 * 用户行为标签
 */
return array(
		"after_reg" => array(
				"Home\\Behaviors\\return_reg_jifenBehavior",
			),
		"after_login" => array(
				"Home\\Behaviors\\return_login_jifenBehavior",
			),
		"change_comment_status" => array(
			"Home\\Behaviors\\change_statusBehavior",
		),

	);