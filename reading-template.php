<?php

function import_template2_func( $content ) {
    if( is_single() && ! empty( $GLOBALS['post'] ) ) {
        if ( $GLOBALS['post']->ID == get_the_ID() ) {
          if( get_post_type() =='event' ) {
            $content = template_event2_func($content);
            return $content;
          }
          if( get_post_type() == 'internship' ) {
            if( !is_bot() ){
              setDayViews(get_the_ID());
              setWeekViews(get_the_ID());
              setPostViews(get_the_ID());
            }
            $content = template_internship2_func($content);
            return $content;
          }
          if( get_post_type() == 'job' ) {
            $content = template_job2_func($content);
            return $content;
          }
          if( get_post_type() == 'company' ) {
            $content=template_company_info2_func($content);
            return $content;
          }
          if( get_post_type() == 'summer_internship' ) {
            $content=template_summer_internship2_func($content);
            return $content;
          }
          if( get_post_type() == 'autumn_internship' ) {
            $content=template_autumn_internship2_func($content);
            return $content;
          }
          if( get_post_type() == 'column' ) {
            $content=template_column2_func($content);
            return $content;
          }
        }
    }
    return $content;
}
add_filter('the_content', 'import_template2_func');

function view_terms_func($pid, $tax_slugs,$before='',$sep='',$after=''){
  $html='';
  foreach($tax_slugs as $tax_slug){
	 if ($tax_slug === reset($tax_slugs)) {
	   $html.=$before;
	 }
   $term_list=get_the_term_list($pid, $tax_slug, '<span class="card-category">', '</span><span class="card-category">','</span>');
	   $term_list=str_replace('/?', '/customsearch?sw=&itype='.get_post_type($pid).'&',$term_list);
$html.=$term_list;
		 if ($tax_slug === end($tax_slugs)) {
		   $html.=$after;
		 }else{
		   $html.=$sep;
		 }
  }
return $html;
}

?>