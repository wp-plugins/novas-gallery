<?php
$table_name = $wpdb->prefix."NGLocal";
if ($_GET['type']=='local') {
if ($_GET['action']=='delete') {
		$where = array (
						'id' => $_GET['id']
					);
					$wpdb->delete($table_name, $where);
					header('Location:admin.php?page=NGAdmin.php');
	}
	if($_GET['action']=='add') {
		$data = array (
				'url' => $_GET['id'],
				);
				$wpdb->insert($table_name, $data);
				header('Location:admin.php?page=NGAdmin.php');
	}
}
$results = $wpdb->get_results("SELECT * FROM $table_name");
echo '<div id="local-section"><h3>Media Libray Gallery</h3>';
echo '<input type="button" id="upload_image_button" value="Add Image">Shortcode [NG id="local"]';
echo '<table class="local">';
foreach($results as $results) {
	echo '<tr><td class="album-photo"><div class="gallery-photo" style="background:url('.$results->url.');"></div><a href="admin.php?page=NGAdmin.php&type=local&action=delete&id='.$results->id.'" class="local-delete">Remove</a></td></tr>';
}
echo '</table></div>';
?>