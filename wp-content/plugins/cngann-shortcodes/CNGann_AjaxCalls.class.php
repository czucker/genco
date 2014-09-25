<?php
	class CNGann_AjaxCalls  extends CNGann_Lib {
		public function email_form(){
			global $wpdb;
			$table_name = $wpdb->prefix . "cngann_email_form";
			$wpdb->show_errors();
			$r = $wpdb->insert(
				$table_name,
				array(
					'name' => $_POST['name'] ? $_POST['name'] : "N/A",
					'company' => $_POST['company'] ? $_POST['company'] : "N/A",
					'email' => $_POST['email'] ? $_POST['email'] : "N/A",
					'phone' => $_POST['phone'] ? $_POST['phone'] : "N/A",
					'comments' => $_POST['content'] ? $_POST['content'] : "N/A",
					'subscribe' => ( $_POST['get_emails'] == y ? 1 : 0)
				)
			);
			if($r) return "Success";
			else return "Fail";
		}
	}