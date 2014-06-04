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
				echo '<response>'.$wpdb->insert_id.'</response>';
	}
}
$results = $wpdb->get_results("SELECT * FROM $table_name");
echo '<div id="local-section"><h3>Media Libray Gallery</h3>';
echo '<input type="button" id="upload_image_button" value="Add Images">Shortcode [NG id="local"]';
echo '<div class="local" id="local">';
foreach($results as $results) {
	echo '<div class="album-photo" id="local-'.$results->id.'"><div class="gallery-photo" style="background:url('.$results->url.');"></div><div imageid="'.$results->id.'" class="local-delete">Remove</div></div>';
}
echo '</tr></div></div>';
?>