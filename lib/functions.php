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

?>