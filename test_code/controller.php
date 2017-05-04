<?
public function action_nedvizhimost()
	{
		$alias_object = $this->request->param('alias_object');
		
		if(	$alias_object == NULL 
			|| $alias_object == Kohana::$config->load('site.objects.dir_current') 
			|| $alias_object == Kohana::$config->load('site.objects.dir_ready') 
			|| $alias_object == Kohana::$config->load('site.objects.dir_planned') 
		  )
		{
			$scripts = array(  'category_list_object', 'lightslider/lightslider', 'hovered_blocks', 'jquery.maskedinput.min','jquery.printElement.min'
);
		
			$styles = array(  'category_list_object', 'advantages_right_min', 'map', 'lightslider/lightslider', 'hovered_blocks');
						
			$Model_Objects = new Model_Objectsmod();
			$list_current_objects = $Model_Objects->get_list_current_objects_ch();
			//$list_current_objects = array('');
			$list_ready_objects = $Model_Objects->get_list_ready_objects();
			$list_planned_objects = $Model_Objects->get_list_planned_objects();
						
			$content = View::factory('category_list_objects')
				   ->bind('list_current_objects',$list_current_objects)
				   ->bind('list_ready_objects',$list_ready_objects)
				   ->bind('list_planned_objects',$list_planned_objects)
				   ->bind('ancor', $alias_object);
			
			$this->template->tittle = 'Недвижимость в Нижнем Новгороде и области | ГК "Сокольники"';
		}	
		else
		{
			$Model_Object = new Model_Objectsmod();
			$object = $Model_Object->get_object_info($alias_object);
			$building_steps = $Model_Object->get_object_building_step($object['id']);
			$prices = $Model_Object->get_object_price($object['id']);
			$docs = $Model_Object->get_object_docs($object['id']);
			$ipoteka = $Model_Object->get_object_docs_ipoteka($object['id']);
			$sales = $Model_Object->get_object_sales($object['id']);
			$floors_plans = $Model_Object->get_object_floors_plans($object['id']);

			$array_aport= [ 'Студия'=>'Студии', '1-комнатные'=>1, '2-комнатные'=>2, '3-комнатные'=>3, '4-комнатные'=>4,
			 'Нежилые помещения'=>'Нежилое', 'Офисы'=>'Офис', 'Гипермаркеты'=>'Гипермаркет' ];
			
			foreach ($array_aport as $key => $value) 
			{
				$remainder = $Model_Object->get_aportment_remainder( $object['id'], $value );				
				$count_remainder[$key] = count( $remainder);
			} //print_r($count_remainder); //print_r($object['id']);
					
			$scripts = array(  'object'	,'lightslider/lightslider', 'jquery.maskedinput.min', 'jquery.printElement.min');
		
			$styles = array(  'object'
						, 'advantages_right_min'
						//, 'slider_foto_objects'
						, 'map'
						, 'lightslider/lightslider'
						);
			if($object['stady_id'] == 2)
			{
				$content = View::factory('object')
				   ->bind('object',$object)
				   ->bind('building_steps',$building_steps)
				   ->bind('prices',$prices)
				   ->bind('docs',$docs)
				   ->bind('ipoteka',$ipoteka)
				   ->bind('sales',$sales)
				   ->bind('floors_plans',$floors_plans)
				   ->bind('count_remainder',$count_remainder);
			}else{
				$content = View::factory('object_light')
				   ->bind('object',$object)
				   ->bind('building_steps',$building_steps)
				   ->bind('prices',$prices)
				   ->bind('docs',$docs)
				   ->bind('ipoteka',$ipoteka)
				   ->bind('sales',$sales)
				   ->bind('floors_plans',$floors_plans);
			}
			
			$this->template->tittle = $alias_object.' | Недвижимость в Нижнем Новгороде и области';
			
			if($object['cetegory_id'] == 1)
			{
				$this->template->cat_name_obj = '';
			}
		
			if($object['cetegory_id'] == 2)
			{
				$this->template->cat_name_obj = 'Коммерческая недвижимость ';
			}
			
			$this->template->study_name_obj = $object['stady_id'];
		
			$this->template->name_object = $object['name'];
		}
		
		$this->template->content = $content;
		$this->template->styles = $styles;
		$this->template->scripts = $scripts;		
	}