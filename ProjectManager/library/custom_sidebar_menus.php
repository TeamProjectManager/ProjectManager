<?php


/** Budget 

add_filter("manage_edit-budget_columns", "edit_budget_columns" );
add_action("manage_posts_custom_column", "custom_budget_columns");

function edit_budget_columns($budget_columns){
        $budget_columns = array(
                "cb" => "<input type ='checkbox' />",
                "title" => "Budget",
                "budget_image" => "Image",
                "budget_content" => "Budget URL",
				"shortcode" => "Shortcode",
        );
        return $budget_columns;
}

function custom_budget_columns($budget_column){
		global $post;
        switch ($budget_column)
        {
			case 'budget_image':
				the_post_thumbnail( 'thumbnail' );
				break;
			case 'budget_project':  
				$custom = get_post_custom();  
				echo $custom['_budget_project'][0];  
				break; 
			case 'budget_content':  
				$custom = get_post_custom();  
				echo $custom['_budget_link'][0];  
				break;  
		}

}

**/


/** ToDos **/

add_filter("manage_edit-todos_columns", "edit_todos_columns" );
add_action("manage_posts_custom_column", "custom_todos_columns");
	

function edit_todos_columns($todos_columns){
        $todos_columns = array(
                "cb" => "<input type ='checkbox' />",
                "title" => "ToDo",
                "todos_image" => "Image",
                "todos_content" => "ToDo URL",
				"shortcode" => "Shortcode",
        );
        return $todos_columns;
}

function custom_todos_columns($todo_column){
		global $post;
        switch ($todo_column)
        {
			case 'todos_project':  
				$custom = get_post_custom();  
				echo $custom['_todos_project'][0];  
				break; 
		}

}



/** Budget 

add_filter("manage_edit-goals_columns", "edit_goals_columns" );
add_action("manage_posts_custom_column", "custom_goals_columns");

function edit_goals_columns($goals_columns){
        $goals_columns = array(
                "cb" => "<input type ='checkbox' />",
                "title" => "Goal",
                "budget_image" => "Image",
                "budget_content" => "Goal URL",
				"shortcode" => "Shortcode",
        );
        return $goals_columns;
}

function custom_goals_columns($goal_column){
		global $post;
        switch ($goal_column)
        {
			case 'goals_image':
				the_post_thumbnail( 'thumbnail' );
				break;
			case 'goals_project':  
				$custom = get_post_custom();  
				echo $custom['_goals_project'][0];  
				break; 
			case 'goals_content':  
				$custom = get_post_custom();  
				echo $custom['_goals_link'][0];  
				break;  
		}

}
**/


/** Projects **/

add_filter("manage_edit-projects_cpt_columns", "edit_projects_cpt_columns" );
add_action("manage_posts_custom_column", "custom_projects_cpt_columns");

function edit_projects_cpt_columns($projects_cpt_columns){
        $projects_cpt_columns = array(
                "cb" => "<input type ='checkbox' />",
                "title" => "Title",
				"projects_cpt_category" => "Category",
                "projects_cpt_image" => "Featured Image"
        );
        return $projects_cpt_columns;
}

function custom_projects_cpt_columns($projects_cpt_column){
        global $post;
        switch ($projects_cpt_column)
        {
				case "projects_cpt_category":
					echo get_the_term_list( get_the_ID(), 'projects_cpt_cats', ' ', ' , ', ' ');
				break;

				case 'projects_cpt_description':
					the_excerpt();  
				break;  
				
                case "projects_cpt_image":
						if(has_post_thumbnail()) {
                        	the_post_thumbnail( 'small-thumb' );
						} else { echo '-'; }
				break;
        }

}



?>