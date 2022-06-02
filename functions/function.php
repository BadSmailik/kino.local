<?php
require_once __DIR__ . "/rb.php";
function debug($data)
{
	echo '<pre><li style="font-family: \'RobotoRegular\', sans-serif;color: red;">' . print_r($data, true) . '</li></pre>';
}

function sumStr($string)
{
	$gdgd = substr($string, 0, strrpos(substr($string, 0, 450), ' '));
	$res = trim($gdgd, "\.\,");
	return $res . '...';
}

function connectDB()
{
	R::setup('mysql:host=127.0.0.1;dbname=test2', 'root', '');
	if (!R::testConnection()) {
		echo 'нет подключения';
	}
}

function clearInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function userInfo()
{
	if (isset($_SESSION['user']['email']) !== false) {
		$user = R::findOne('users', 'email = ?', [$_SESSION['user']['email']]);
		$_SESSION['user']['id'] = $user->id;
		$_SESSION['user']['avatar'] = $user->avatar;
		return $_SESSION['user'];
	}
}

function testArray($array)
{
	if (is_array($array)) {
		echo 'это массив';
	} else {
		echo 'это не массив';
	}
}

function is_admin()
{
	if (@$_SESSION['user']['email'] !== null) {
		$user = R::findOne('users', 'email = ?', [$_SESSION['user']['email']]);
		if (@$user->role >= 2) {
			return true;
		} else {
			return false;
		}
	}
}

function countComments($var)
{
	$count = R::count('comments', 'id_content = ?', [$var]);
	return $count;
}

function countLike($id)
{
	$countLike = R::exec("SELECT `like` FROM `grade` WHERE `id_content` = {$id} AND `like` > 0");
	return $countLike;
}

function countDisLike($id)
{
	$countDisLike = R::exec("SELECT `like` FROM `grade` WHERE `id_content` = {$id} AND `dislike` > 0");
	return $countDisLike;
}

function is_like($id)
{
	if (isset($_SESSION['user']['name']) !== false) {
		$ress = R::findAll('grade');
		foreach ($ress as $k);
		if (@$k['id_content'] == $id && @$k['login'] == $_SESSION['user']['name'] && @$k['like']) {
			echo 'disabled';
		} elseif (@$k['id_content'] == $id && @$k['login'] == $_SESSION['user']['name'] && @$k['dislike']) {
			echo 'disabled';
		}
	}
}

function download_file($file)
{
	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/json');
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
	} else {
		echo '<div class="alert alert-danger" role="alert">Файл&nbsp;<b>' . $file . '</b>&nbsp;не существует!</div>';
	}
}

function uploadsFile($file, $folder, $type)
{
	if (is_uploaded_file($file)) {
		$path_file = pathinfo($folder . '/' . time() . $file);
		$ext_type = array($type);
		if (in_array($path_file['extension'], $ext_type)) {
			move_uploaded_file($_FILES['file']['tmp_name'], $path_file['dirname'] . '/' . $path_file['basename']);
		} else {
			echo 'не верный формат файла';
		}
	}
}

function searchContent()
{
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		$str = clearInput($_GET['q']);
		if (empty($str) && $str == '') {
			echo 'Введите запрос!';
		} else {
			$exp = explode(' ', $str);
			if (!empty($exp)) {
				echo '<h5>По запросу<span class=\'text-primary\'>&nbsp;' . $str . '&nbsp;</span>найдено</h5>';
				foreach ($exp as $key) {
					$search = R::find('content', 'text LIKE ?', ["%$key%"]);
					$search = R::find('content', 'hash LIKE ?', ["%$key%"]);
					$search = R::find('content', 'title LIKE ?', ["%$key%"]);
					foreach ($search as $result) {
						$result = $result->export();
						// debug($result);
						echo nl2br('<a href="view?id=' . $result['id'] . '">' . $result['title'] . '</a>' . "\n");
					}
				}
			}
		}
	}
}

function custom_delete($table)
{
	$id = $_POST['id'];
	$content = R::load($table, $id);
	R::trash($content);
	header("Location: {$_SERVER['REQUEST_URI']}");
}

function actionComment($id_content)
{
	$errors = [];
	if (empty($_POST['comment'])) {
		$errors[] = 'Заполните поле комментарий';
	}
	if (@$_SESSION['user'] === NULL) {
		$errors[] = 'Сначала нужно&nbsp;<b><a href="register">зарегестрироваться!</a></b>';
	}
	if (count($errors) > 0) {
		foreach ($errors as $error) {
			debug($error);
		}
		return $errors;
	} else {
		$comments = R::dispense('comments');
		$comments->id_content = $id_content;
		$comments->login = $_SESSION['user']['name'];
		$comments->id_login = $_SESSION['user']['id'];
		$comments->date_post = date('d.m.Y' . ' в ' . 'H:i');
		$comments->comment = clearInput($_POST['comment']);
		R::store($comments);
		if (R::store($comments)) {
			$_SESSION['msg'] = 'Комментарий добавлен';
		}
		R::close($comments);
		header("Location: {$_SERVER['REQUEST_URI']}");
	}
}

function quest()
{
	$agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
	if (@$_SESSION['user'] == null) {
		$_SESSION['quest'] = [
			'ip' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
		];
		$query = R::findOne('quest', 'ip = ?', [$_SESSION['quest']['ip']]);
		$query = $query->export();
		if (!in_array($_SESSION['quest']['ip'], $query)) {
			$quest = R::dispense('quest');
			$quest->ip = $_SERVER['REMOTE_ADDR'];
			$quest->user_agent = $_SERVER['HTTP_USER_AGENT'];
			$quest->parent = $agent['parent'];
			$quest->platform = $agent['platform'];
			$quest->browser = $agent['browser'];
			$quest->ban = 0;
			R::store($quest);
			R::close();
		}
	}
}

function grade($id)
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$i = 1;
		$query = R::inspect(); // какие таблицы естть в базе
		if (in_array('grade', $query) && isset($_POST['like'])) {
			$search_grade = R::getAll('SELECT * FROM `grade` WHERE `id_content` = :id_content AND `login` = :login', [':id_content' => $id, ':login' => $_SESSION['user']['name']]); // смотрим сколько оценок, есть от одного пользователя для одного поста
			if (count($search_grade) >= 1) {
				$_SESSION['msg'] = '<div class="float-end text-danger">больше одного раза голосовать нельзя</div>';
			} else {
				$grade = R::load('grade', $id);
				$grade->id_content = $id;
				$grade->login = $_SESSION['user']['name'];
				$grade->like = $i++;
				R::store($grade);
				R::close();
			}
		}
		if (in_array('grade', $query) && isset($_POST['dislike'])) {
			$grade = R::load('grade', $id);
			$grade->id_content = $id;
			$grade->login = $_SESSION['user']['name'];
			$grade->dislike = $i++;
			R::store($grade);
			R::close();
		}
	}
}
function alert_message()
{
	@$_SESSION['msg'];
	if (!empty($_SESSION['msg'])) {
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
}
