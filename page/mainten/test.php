1	id Primary	int(11)			
	2	asset_tag Index	varchar(50)		
	3	maintenance_type	varchar(50)		
	4	description	text		
	5	date	date	
    
    

	6	status	enum('Pending', 'In-Progress', 'Completed')		
	7	performed_by	int(11)				
	8	cost	decimal(10,2)				
	9	next_schedule	date			
	10	spare_parts_used	
	11	notes	text		
	12	created_at		
	13	updated_at