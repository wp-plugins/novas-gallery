<?php
$table_name = $wpdb->prefix.'NGFeeds';
	if ($_GET['type']=='feed') {
	if($_GET['action']=='new') {
		$data = array (
				'feed' => '-',
				'type' => '-',
				'exclude' => '-'
				);
				$wpdb->insert($table_name, $data);
				echo '<response>'.$wpdb->insert_id.'</response>';
				echo '<response-types>'.get_types('-').'</response-types>';
	}
	if($_GET['action']=='save') {
		$data = array (
				'feed' => $_GET['feed'],
				'type' => $_GET['source'],
				'exclude' => $_GET['exclude']
				);
		$where = array (
						'id' => $_GET['id']
						);
		$wpdb->update($table_name, $data, $where);
		echo '<response>1</response>';
	}
	if ($_GET['action']=='delete') {
		$where = array (
						'id' => $_GET['id']
					);
					$wpdb->delete($table_name, $where);
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
	echo '<div class="feeds-section"><h3>Feeds</h3><input type="button" value="New Feed" onclick="addfeed()">';
	echo '<table class="feed" id="feeds"><tr><th>Feed ID</th><th>Type</th><th>Shortcode</th><th>Exclude</th><th>Actions</th></tr>';
	$results = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($results as $results) {
		if($results->type!='local') {
		echo '<tr id="feed'.$results->id.'"><form><td><input name="feed" type="text" value="'.$results->feed.'"></td><td>'.get_types($results->type).'</td><td>[NG id="'.$results->id.'"]</td><td><input type="text" name="exclude" onclick=facebook() value="'.$results->exclude.'"></td><td><input type="button" value="Save" feedid="'.$results->id.'"><input type="button" class="delete" value="X" feedid="'.$results->id.'"></td></form></tr>';
		}
	}
	echo'</table></div>';
?>