<?php

/**
 * Set title of the page
 */
function setTitle($title){
    echo "<title>Etisalat Blacklist - ".$title."</title>\n";
}

function show_pagination($current=NULL, $total=NULL, $base_url=NULL){

	 $pagination = '<ul class="pagination pagination-lg">';
	  
	  $page = $current;
	  while ( $page < $total+1 ) { 
	  	# code...
	  	$pagination .= '<li><a href="'.$base_url.'/' .$page. '">' . $page . '</a></li>';
	  	$page++;
	  	if ($page==3) break;
	  }

	  if ($total > 3) {
	  	# code...
	  	$pagination .= '<li><a href="#">....</a></li>';
	  	$pagination .= '<li><a href="'.$base_url.'/' .$page. '">' . $total . '</a></li>';
	  }
	  


	$pagination .= '</ul>';

	echo $pagination;
}

function build_nav($json_nav, $title){

	$nav = json_decode($json_nav,true);

	$build = '';

	foreach ($nav as $key => $options) {
		# code...
		$url = $options['controller'] . "/" . implode('/', $options['method']);

		if (!in_array($_SESSION['company']->getPrivilege(), $options['priv'])) continue;

		$class = '';
		if ($title == $options['controller']) {
			# code...
			$class = 'active';
		}

		$build .= "<li class='" . $class . "'>";
		$build .= "<a href=" . ROOT_URL . "/" . $url . ">";
		$build .= "<span>".ucfirst($key)."</span></a></li>";
	}

	return $build;

}

?>