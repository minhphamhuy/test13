<?php
if (isset($_POST['update-user']) || isset($_POST['update-admin'])) {
	$errors = array(); // array to hold validation errors
	$data = array(); // array to pass back data
	$sucessMsg = array();
	$last_name = $first_name = $email = $phone_number = $password = "";

	$username = $_SESSION['Admin'];
	$sql = "SELECT `last_name`, `first_name`, `email`, `phone_number`, `password` FROM `admin` WHERE username=?";
	$db->query($sql, $username);
	// query returned at least 1 row
	if ($db->numRows() > 0) {
		$result = $db->fetchAll();
		foreach ($result as $row) {
			$last_name = $row['last_name'];
			$first_name = $row['first_name'];
			$email = $row['email'];
			$phone_number = $row['phone_number'];
			$password = $row['password'];
		}
	}

	// validate first name and last name for admins too since admins can change those
	if (isset($_POST['update-admin'])) {
		// Validate first name
		if (!empty($_POST["first_name"]) && isset($_POST["first_name"])) {
			$first_name_new = test_input($_POST["first_name"]);
			if ($first_name_new != $first_name) {
				// not matching regex, format error message
				if (!preg_match("/^[A-Za-z]+$/", $first_name_new)) {
					$errors['name'] = 'Please enter an appropriate name!';
				} else {
					$sucessMsg['first_name'] = 'First name updated.';
				}
			}
		}

		// Validate last name
		if (!empty($_POST["last_name"]) && isset($_POST["last_name"])) {
			$last_name_new = test_input($_POST["last_name"]);
			if ($last_name_new != $last_name) {
				// not matching regex, format error message
				if (!preg_match("/^[A-Za-z]+$/", $last_name_new)) {
					$errors['name'] = 'Please enter an appropriate name!';
				} else {
					$sucessMsg['last_name'] = 'Last name updated.';
				}
			}
		}
	}

	// Validate email
	if (!empty($_POST["email"]) && isset($_POST["email"])) {
		$email_new = test_input($_POST["email"]);
		if ($email_new != $email) {
			// check if e-mail address is well-formed
			if (!is_valid_email($email_new)) {
				$errors['email'] = 'Invalid email format!';
			} else {
				// attempt to get email query result from user to check if email is registered
				$sql = "SELECT customer.id, admin.id FROM `customer`, `admin` WHERE customer.email=? OR admin.email=?;";
				// execute query
				$db->query($sql, $email_new, $email_new);
				// query returned at least 1 row
				if ($db->numRows() > 0) {
					$errors['email'] = 'This email is already registered!';
				} else {
					$sucessMsg['email'] = 'Email updated.';
				}
			}
		}
	}

	// Validate phone number
	if (!empty($_POST["phone"]) && isset($_POST["phone"])) {
		$phone_number_new = test_input($_POST["phone"]);
		if ($phone_number_new != $phone_number) {
			// not matching regex, format error message
			if (!preg_match("/^\+?\d{0,13}/", $phone_number_new)) {
				$errors['phone'] = 'Invalid phone number!';
			} else {
				$sucessMsg['phone'] = 'Phone number updated.';
			}
		}
	}

	// Validate password
	// if 'current password' field has value
	if (!empty($_POST["oldpassword"]) && isset($_POST["oldpassword"])) {
		$currentpassword = test_input($_POST["oldpassword"]);
		if (!password_verify($currentpassword, $password)) {
			$errors['password'] = 'Current password is incorrect!';
		} else {
			$currentpassword_valid = true;
			// 'new password' field has value
			if (!empty($_POST["newpassword"]) && isset($_POST["newpassword"])) {
				$newpassword = test_input($_POST["newpassword"]);
				$newpassword_valid = true;
				// field not empty, check if data is not null
				if (!empty($_POST["renewpassword"]) && isset($_POST["renewpassword"])) {
					$renewpassword = test_input($_POST["renewpassword"]);

					// 're-type new password' field and 'new password' field are the same
					if ($renewpassword === $newpassword) {
						// new password same as old password
						if ($renewpassword === $currentpassword) {
							$errors['password'] = 'New password is the same as old password!';
						}
						// update password
						else {
							$sucessMsg['password'] = 'Password updated.';
						}
					}
					// 'new password' and 're-type new password' fields don't match, store error message
					else {
						$errors['password'] = "New password in fields don't match!";
					}
				}
				// no value in 're-type new password' field, store error message
				else {
					$errors['password'] = "Please re-type your new password!";
				}
			}
			// no value in 'new password' field, store error message
			else {
				$errors['password'] = "New password is required!";
			}
		}
	}
	// only 'new password' field is filled
	else if (!empty($_POST["newpassword"]) && isset($_POST["newpassword"])) {
		$errors['password'] = "Please enter your current password!";
	}
	// only 're-type new password' field is filled
	else if (!empty($_POST["renewpassword"]) && isset($_POST["renewpassword"])) {
		$errors['password'] = "Please enter your current and new password!";
	}
	if (isset($_POST['update-admin'])) {
		if ($first_name_valid) {
			$sql = "UPDATE `admin` SET `first_name`=? WHERE username=?;";
			$db->query($sql, $first_name_new, $username);
		}
		if ($last_name_valid) {
			$sql = "UPDATE `admin` SET `last_name`=? WHERE username=?;";
			$db->query($sql, $last_name_new, $username);
		}
	}
	if ($email_valid) {
		if (isset($_POST['update-user']))
			$sql = "UPDATE `customer` SET `email`=? WHERE username=?;";
		else if (isset($_POST['update-admin']))
			$sql = "UPDATE `admin` SET `email`=? WHERE username=?;";

		$db->query($sql, $email_new, $username);
	}
	if ($phone_valid) {
		if (isset($_POST['update-user']))
			$sql = "UPDATE `customer` SET `phone_number`=? WHERE username=?";
		else if (isset($_POST['update-admin']))
			$sql = "UPDATE `admin` SET `phone_number`=? WHERE username=?";

		$db->query($sql, $phone_number_new, $username);
	}
	if ($currentpassword_valid && $newpassword_valid && $renewpassword_valid) {
		if (isset($_POST['update-user']))
			$sql = "UPDATE `customer` SET `password`=? WHERE username=?;";
		else if (isset($_POST['update-admin']))
			$sql = "UPDATE `admin` SET `password`=? WHERE username=?;";

		$db->query($sql, password_hash($renewpassword, PASSWORD_DEFAULT), $username);
	}


	// if there are any errors in our errors array, return a success boolean of false
	if (isset($errors)) {
		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {
		// if there are no errors process our form, then return a message

		// DO ALL YOUR FORM PROCESSING HERE
		// THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['sucessMsg'] = $sucessMsg;
	}

	// return all our data to an AJAX call
	echo json_encode($data);
}
