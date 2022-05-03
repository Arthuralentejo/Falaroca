<?php


//START create save metabox
add_action( 'save_post', 'nd_cc_meta_box_cost_save' );
function nd_cc_meta_box_cost_save( $post_id )
{


    //get limit datas
    $nd_cc_max_sections = get_post_meta( get_the_ID(), 'nd_cc_meta_box_cc_section_number', true );
    if ( $nd_cc_max_sections == '' ) { $nd_cc_max_sections = 2; }

    $nd_cc_max_sub_sections = get_post_meta( get_the_ID(), 'nd_cc_meta_box_cc_subsection_number', true );
    if ( $nd_cc_max_sub_sections == '' ) { $nd_cc_max_sub_sections = 3; }

    $nd_cc_max_repeater_options = get_post_meta( get_the_ID(), 'nd_cc_meta_box_cc_repeater_number', true );
    if ( $nd_cc_max_repeater_options == '' ) { $nd_cc_max_repeater_options = 4; }

    $nd_cc_sub_section_options = 4;



    //START CICLE SECTION
    $nd_cc_section_i = 1; 
    while ( $nd_cc_section_i <= $nd_cc_max_sections ) {
      
      $nd_cc_section_var_name = "nd_cc_section_name_".$nd_cc_section_i;
      $nd_cc_section_name = sanitize_meta($nd_cc_section_var_name,$_POST[$nd_cc_section_var_name],'post');
      
      if ( isset( $nd_cc_section_name ) ) { 

        if ( $nd_cc_section_name != '' ) {
          update_post_meta( $post_id, $nd_cc_section_var_name , $nd_cc_section_name );
        }else{
          delete_post_meta( $post_id,$nd_cc_section_var_name );
        }
         
      }


    
      $nd_cc_section_var_descr = "nd_cc_section_descr_".$nd_cc_section_i;
      $nd_cc_section_descr = sanitize_meta($nd_cc_section_var_descr,$_POST[$nd_cc_section_var_descr],'post');
      
      if ( isset( $nd_cc_section_descr ) ) { 

        if ( $nd_cc_section_descr != '' ) {
          update_post_meta( $post_id, $nd_cc_section_var_descr , $nd_cc_section_descr ); 
        }else{
          delete_post_meta( $post_id,$nd_cc_section_var_descr );
        }
        
      }

      $nd_cc_section_var_width = "nd_cc_section_width_".$nd_cc_section_i;
      $nd_cc_section_width = sanitize_meta($nd_cc_section_var_width,$_POST[$nd_cc_section_var_width],'post');
      
      if ( isset( $nd_cc_section_width ) ) { 

        if ( $nd_cc_section_width != '' ) {
          update_post_meta( $post_id, $nd_cc_section_var_width , $nd_cc_section_width ); 
        }else{
          delete_post_meta( $post_id,$nd_cc_section_var_width );
        }
        
      }


      //START CICLE SUB SECTION
      $nd_cc_sub_section_i = 1; 
      while ( $nd_cc_sub_section_i <= $nd_cc_max_sub_sections ) {
        
        $nd_cc_sub_section_var_name = "nd_cc_sub_section_name_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_name = sanitize_meta($nd_cc_sub_section_var_name,$_POST[$nd_cc_sub_section_var_name],'post');
        
        if ( isset( $nd_cc_sub_section_name ) ) {

          if ( $nd_cc_sub_section_name != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_name , $nd_cc_sub_section_name );
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_name );
          }
           
        }

        $nd_cc_sub_section_var_width = "nd_cc_sub_section_width_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_width = sanitize_meta($nd_cc_sub_section_var_width,$_POST[$nd_cc_sub_section_var_width],'post');
        
        if ( isset( $nd_cc_sub_section_width ) ) { 

          if ( $nd_cc_sub_section_width != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_width , $nd_cc_sub_section_width ); 
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_width );
          }
          
        }

        $nd_cc_sub_section_var_active = "nd_cc_sub_section_active_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_active = sanitize_meta($nd_cc_sub_section_var_active,$_POST[$nd_cc_sub_section_var_active],'post');
        
        if ( isset( $nd_cc_sub_section_active ) ) { 

          if ( $nd_cc_sub_section_active != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_active , $nd_cc_sub_section_active ); 
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_active );
          }
 
        }


        //slider options
        $nd_cc_sub_section_var_slide_min = "nd_cc_sub_section_slide_min_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_slide_min = sanitize_meta($nd_cc_sub_section_var_slide_min,$_POST[$nd_cc_sub_section_var_slide_min],'post');
        
        if ( isset( $nd_cc_sub_section_slide_min ) ) { 

          if ( $nd_cc_sub_section_slide_min != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_slide_min , $nd_cc_sub_section_slide_min );
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_slide_min );
          }
           
        }

        $nd_cc_sub_section_var_slide_max = "nd_cc_sub_section_slide_max_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_slide_max = sanitize_meta($nd_cc_sub_section_var_slide_max,$_POST[$nd_cc_sub_section_var_slide_max],'post');
        
        if ( isset( $nd_cc_sub_section_slide_max ) ) { 

          if ( $nd_cc_sub_section_slide_max != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_slide_max , $nd_cc_sub_section_slide_max ); 
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_slide_max );
          }
          
        }

        $nd_cc_sub_section_var_slide_default = "nd_cc_sub_section_slide_default_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_slide_default = sanitize_meta($nd_cc_sub_section_var_slide_default,$_POST[$nd_cc_sub_section_var_slide_default],'post');
        
        if ( isset( $nd_cc_sub_section_slide_default ) ) { 

          if ( $nd_cc_sub_section_slide_default != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_slide_default , $nd_cc_sub_section_slide_default ); 
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_slide_default );
          }
          
        }

        //switch options
        $nd_cc_sub_section_var_switch_on = "nd_cc_sub_section_switch_on_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_switch_on = sanitize_meta($nd_cc_sub_section_var_switch_on,$_POST[$nd_cc_sub_section_var_switch_on],'post');
        
        if ( isset( $nd_cc_sub_section_switch_on ) ) { 

          if ( $nd_cc_sub_section_switch_on != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_switch_on , $nd_cc_sub_section_switch_on ); 
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_switch_on );
          }
          
        }

        $nd_cc_sub_section_var_switch_off = "nd_cc_sub_section_switch_off_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_switch_off = sanitize_meta($nd_cc_sub_section_var_switch_off,$_POST[$nd_cc_sub_section_var_switch_off],'post');
        
        if ( isset( $nd_cc_sub_section_switch_off ) ) { 

          if ( $nd_cc_sub_section_switch_off != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_switch_off , $nd_cc_sub_section_switch_off ); 
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_switch_off );
          }
          
        }

        //tag options
        $nd_cc_sub_section_var_tag_type = "nd_cc_sub_section_tag_type_".$nd_cc_section_i."_".$nd_cc_sub_section_i;
        $nd_cc_sub_section_tag_type = sanitize_meta($nd_cc_sub_section_var_tag_type,$_POST[$nd_cc_sub_section_var_tag_type],'post');
        
        if ( isset( $nd_cc_sub_section_tag_type ) ) { 

          if ( $nd_cc_sub_section_tag_type != '' ) {
            update_post_meta( $post_id, $nd_cc_sub_section_var_tag_type , $nd_cc_sub_section_tag_type );
          }else{
            delete_post_meta( $post_id,$nd_cc_sub_section_var_tag_type );
          }
           
        }

        //set price option
        $nd_cc_tab_option_i = 0;
        while ( $nd_cc_tab_option_i <= $nd_cc_sub_section_options-1 ) {

          $nd_cc_sub_section_var_price = "nd_cc_sub_section_price_".$nd_cc_section_i."_".$nd_cc_sub_section_i."_".$nd_cc_tab_option_i;
          $nd_cc_sub_section_price = sanitize_meta($nd_cc_sub_section_var_price,$_POST[$nd_cc_sub_section_var_price],'post');
          
          if ( isset( $nd_cc_sub_section_price ) ) { 

            if ( $nd_cc_sub_section_price != '' ) {
              update_post_meta( $post_id, $nd_cc_sub_section_var_price , $nd_cc_sub_section_price ); 
            }else{
              delete_post_meta( $post_id,$nd_cc_sub_section_var_price );
            }
            
          }

          $nd_cc_tab_option_i++;
        }

        //set price option for repeater fields
        $nd_cc_tag_option_i = 2;
        while ( $nd_cc_tag_option_i <= $nd_cc_max_repeater_options ) {

          $nd_cc_sub_section_var_price_tag = "nd_cc_sub_section_price_".$nd_cc_section_i."_".$nd_cc_sub_section_i."_2_".$nd_cc_tag_option_i;
          $nd_cc_sub_section_price_tag = sanitize_meta($nd_cc_sub_section_var_price_tag,$_POST[$nd_cc_sub_section_var_price_tag],'post');
          
          if ( isset( $nd_cc_sub_section_price_tag ) ) { 

            if ( $nd_cc_sub_section_price_tag != '' ) {
              update_post_meta( $post_id, $nd_cc_sub_section_var_price_tag , $nd_cc_sub_section_price_tag ); 
            }else{
              delete_post_meta( $post_id,$nd_cc_sub_section_var_price_tag );
            }
            
          }

          $nd_cc_sub_section_var_price_select = "nd_cc_sub_section_price_".$nd_cc_section_i."_".$nd_cc_sub_section_i."_3_".$nd_cc_tag_option_i;
          $nd_cc_sub_section_price_select = sanitize_meta($nd_cc_sub_section_var_price_select,$_POST[$nd_cc_sub_section_var_price_select],'post');
          
          if ( isset( $nd_cc_sub_section_price_select ) ) { 

            if ( $nd_cc_sub_section_price_select != '' ) {
              update_post_meta( $post_id, $nd_cc_sub_section_var_price_select , $nd_cc_sub_section_price_select ); 
            }else{
              delete_post_meta( $post_id,$nd_cc_sub_section_var_price_select );
            }
 
          }

          $nd_cc_tag_option_i++;
        }

        $nd_cc_tag_name_option_i = 1;
        while ( $nd_cc_tag_name_option_i <= $nd_cc_max_repeater_options ) {

          $nd_cc_sub_section_var_name_tag = "nd_cc_sub_section_name_tag_".$nd_cc_section_i."_".$nd_cc_sub_section_i."_2_".$nd_cc_tag_name_option_i;
          $nd_cc_sub_section_name_tag = sanitize_meta($nd_cc_sub_section_var_name_tag,$_POST[$nd_cc_sub_section_var_name_tag],'post');
          
          if ( isset( $nd_cc_sub_section_name_tag ) ) { 

            if ( $nd_cc_sub_section_name_tag != '' ) {
              update_post_meta( $post_id, $nd_cc_sub_section_var_name_tag , $nd_cc_sub_section_name_tag ); 
            }else{
              delete_post_meta( $post_id,$nd_cc_sub_section_var_name_tag );
            }
            
          }

          $nd_cc_sub_section_var_name_select = "nd_cc_sub_section_name_select_".$nd_cc_section_i."_".$nd_cc_sub_section_i."_3_".$nd_cc_tag_name_option_i;
          $nd_cc_sub_section_name_select = sanitize_meta($nd_cc_sub_section_var_name_select,$_POST[$nd_cc_sub_section_var_name_select],'post');
          
          if ( isset( $nd_cc_sub_section_name_select ) ) { 

            if ( $nd_cc_sub_section_name_select != '' ) {
              update_post_meta( $post_id, $nd_cc_sub_section_var_name_select , $nd_cc_sub_section_name_select );
            }else{
              delete_post_meta( $post_id,$nd_cc_sub_section_var_name_select );
            }
   
          }

          $nd_cc_sub_section_var_descr_select = "nd_cc_sub_section_descr_select_".$nd_cc_section_i."_".$nd_cc_sub_section_i."_3_".$nd_cc_tag_name_option_i;
          $nd_cc_sub_section_descr_select = sanitize_meta($nd_cc_sub_section_var_descr_select,$_POST[$nd_cc_sub_section_var_descr_select],'post');
          
          if ( isset( $nd_cc_sub_section_descr_select ) ) { 

            if ( $nd_cc_sub_section_descr_select != '' ) {
              update_post_meta( $post_id, $nd_cc_sub_section_var_descr_select , $nd_cc_sub_section_descr_select ); 
            }else{
              delete_post_meta( $post_id,$nd_cc_sub_section_var_descr_select );
            }
            
          }

          $nd_cc_sub_section_var_icon_select = "nd_cc_sub_section_icon_select_".$nd_cc_section_i."_".$nd_cc_sub_section_i."_3_".$nd_cc_tag_name_option_i;
          $nd_cc_sub_section_icon_select = sanitize_meta($nd_cc_sub_section_var_icon_select,$_POST[$nd_cc_sub_section_var_icon_select],'post');
          
          if ( isset( $nd_cc_sub_section_icon_select ) ) { 

            if ( $nd_cc_sub_section_icon_select != '' ) {
              update_post_meta( $post_id, $nd_cc_sub_section_var_icon_select , $nd_cc_sub_section_icon_select ); 
            }else{
              delete_post_meta( $post_id,$nd_cc_sub_section_var_icon_select );
            }
            
          }

          $nd_cc_tag_name_option_i++;
        }


        $nd_cc_sub_section_i++;
      }
      //END CICLE SUB SECTION


      $nd_cc_section_i++;
    }
    //END CICLE SECTION



    //general settings
    $nd_cc_meta_box_cc_color = sanitize_hex_color( $_POST['nd_cc_meta_box_cc_color'] );
    
    if ( isset( $nd_cc_meta_box_cc_color ) ) { 

      if ( $nd_cc_meta_box_cc_color != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_color' , $nd_cc_meta_box_cc_color ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_color' );
      }
      
    }

    $nd_cc_meta_box_cc_layout = sanitize_option( 'nd_cc_meta_box_cc_layout', $_POST['nd_cc_meta_box_cc_layout'] );
    
    if ( isset( $nd_cc_meta_box_cc_layout ) ) { 

      if ( $nd_cc_meta_box_cc_layout != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_layout' , $nd_cc_meta_box_cc_layout ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_layout' );
      }
      
    }

    $nd_cc_meta_box_cc_section_number = sanitize_meta('nd_cc_meta_box_cc_section_number',$_POST['nd_cc_meta_box_cc_section_number'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_section_number ) ) { 

      if ( $nd_cc_meta_box_cc_section_number != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_section_number' , $nd_cc_meta_box_cc_section_number ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_section_number' );
      }

    }

    $nd_cc_meta_box_cc_subsection_number = sanitize_meta('nd_cc_meta_box_cc_subsection_number',$_POST['nd_cc_meta_box_cc_subsection_number'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_subsection_number ) ) { 

      if ( $nd_cc_meta_box_cc_subsection_number != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_subsection_number' , $nd_cc_meta_box_cc_subsection_number ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_subsection_number' );
      }
     
    }

    $nd_cc_meta_box_cc_repeater_number = sanitize_meta('nd_cc_meta_box_cc_repeater_number',$_POST['nd_cc_meta_box_cc_repeater_number'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_repeater_number ) ) { 

      if ( $nd_cc_meta_box_cc_repeater_number  != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_repeater_number' , $nd_cc_meta_box_cc_repeater_number );
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_repeater_number' );
      }
  
    }

    //price fields
    $nd_cc_meta_box_cc_price_title = sanitize_meta('nd_cc_meta_box_cc_price_title',$_POST['nd_cc_meta_box_cc_price_title'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_price_title ) ) { 

      if ( $nd_cc_meta_box_cc_price_title != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_price_title' , $nd_cc_meta_box_cc_price_title ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_price_title' );
      }

    }

    $nd_cc_meta_box_cc_price_descr = sanitize_meta('nd_cc_meta_box_cc_price_descr',$_POST['nd_cc_meta_box_cc_price_descr'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_price_descr ) ) { 

      if ( $nd_cc_meta_box_cc_price_descr != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_price_descr' , $nd_cc_meta_box_cc_price_descr ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_price_descr' );
      }

    }

    $nd_cc_meta_box_cc_price_price = sanitize_meta('nd_cc_meta_box_cc_price_price',$_POST['nd_cc_meta_box_cc_price_price'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_price_price ) ) { 

      if ( $nd_cc_meta_box_cc_price_price != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_price_price' , $nd_cc_meta_box_cc_price_price ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_price_price' );
      }

    }

    $nd_cc_meta_box_cc_price_icon = sanitize_meta('nd_cc_meta_box_cc_price_icon',$_POST['nd_cc_meta_box_cc_price_icon'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_price_icon ) ) { 

      if ( $nd_cc_meta_box_cc_price_icon  != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_price_icon' , $nd_cc_meta_box_cc_price_icon ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_price_icon' );
      }

      
    }

    $nd_cc_meta_box_cc_price_currency = sanitize_meta('nd_cc_meta_box_cc_price_currency',$_POST['nd_cc_meta_box_cc_price_currency'],'post');
    
    if ( isset( $nd_cc_meta_box_cc_price_currency ) ) { 

      if ( $nd_cc_meta_box_cc_price_currency != '' ) {
        update_post_meta( $post_id, 'nd_cc_meta_box_cc_price_currency' , $nd_cc_meta_box_cc_price_currency ); 
      }else{
        delete_post_meta( $post_id,'nd_cc_meta_box_cc_price_currency' );
      }

      
    }

  

}