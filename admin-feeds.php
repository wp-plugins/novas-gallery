<?php
$table_name = $wpdb->prefix.'NGFeeds';
	if ($_GET['type']=='feed') {
	if($_GET['action']=='new') {
		$data = array (
				'feed' => '-',
				'type' => '-',
				'page' => '-',
				'exclude' => '-'
				);
				$wpdb->insert($table_name, $data);
				header('Location:admin.php?page=NGAdmin.php');
	}
	if($_GET['action']=='save') {
		$data = array (
				'feed' => $_POST['feed'],
				'type' => $_POST['type'],
				'page' => $_POST['page'],
				'exclude' => $_POST['exclude']
				);
		$where = array (
						'id' => $_GET['id']
						);
		$wpdb->update($table_name, $data, $where);
		header('Location:admin.php?page=NGAdmin.php');
	}
	if ($_GET['action']=='delete') {
		$where = array (
						'id' => $_GET['id']
					);
					$wpdb->delete($table_name, $where);
					header('Location:admin.php?page=NGAdmin.php');
	}
	}
function pageSelector($currentPage) {
	  
  $option = '<select name="page"><option value="-">-</option>';
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
  	$option .= '<option value="' . $page->post_name . '" ';
	if ($currentPage == $page->post_name) {
		$option .='selected';
	}
	$option .='>';
	$option .= $page->post_title;
	$option .= '</option>';
  }
  $option .='</select>';
  return $option;
  }
  function get_types($currentTypes) {
	  $option = '<select name="type">';
	  $types = array('-', 'facebook');
	  foreach($types as $types) {
		  $option .= '<option name="type" value="'.$types.'"';
		  if($currentTypes == $types) {
			  $option .='selected';
		  }
		  $option .= '>'.ucfirst($types).'</option>';
	  }
	  $option .='</select>';
	  return $option;
  }
	echo '<link rel="stylesheet" href="'.plugins_url().'/novas-gallery/admin.css">';
	echo '<script src="'.plugins_url().'/novas-gallery/jquery.js"></script><script src="'.plugins_url().'/novas-gallery/admin.js"></script>';
	echo '<div class="feeds-section"><h3>Feeds</h3><a href="admin.php?page=NGAdmin.php&type=feed&action=new"><input type="button" value="New Feed"></a>';
	echo '<table class="feed"><tr><th>Feed ID</th><th>Type</th><th>Shortcode</th><th>Exclude</th><th>Actions</th></tr>';
	$results = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($results as $results) {
		if($results->type!='local') {
		echo '<tr><form action="admin.php?page=NGAdmin.php&type=feed&action=save&id='.$results->id.'" method="POST" id="NG'.$results->id.'"><td><input name="feed" type="text" value="'.$results->feed.'"></td><td>'.get_types($results->type).'</td><td>[NG id="'.$results->id.'"]</td><td><input type="text" name="exclude" onclick=facebook() value="'.$results->exclude.'"></td><td><input type="submit" value="Save"><a href="admin.php?page=NGAdmin.php&type=feed&action=delete&id='.$results->id.'"><input type="button" class="delete" value="X"></a></td></form></tr>';
		}
	}
	echo'</table></div>';
?>