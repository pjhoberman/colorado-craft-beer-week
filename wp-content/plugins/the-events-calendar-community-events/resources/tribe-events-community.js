/**
 * This script is borrowed from Filament Group
 * http://filamentgroup.com/lab/responsive_design_approach_for_complex_multicolumn_data_tables
 * Edited by Paul Hughes
*/
jQuery(document).ready(function() {
	jQuery('.my-events').addClass('enhanced');
	var container = jQuery('.table-menu'); 
	jQuery('#my-events-display-headers th').each(function(i){
		var th = jQuery(this),
      	id = th.attr('id'), 
      	classes = th.attr('class');  // essential, optional (or other content identifiers)
   		// assign an ID to each header, if none is in the markup
   		if (!id) {
      		id = ( "col-" ) + i;
      		th.attr("id", id);
   		};      
   		// loop through each row to assign a "headers" attribute and any
   		// classes (essential, optional) to the matching cell
   		// the "headers" attribute value = the header's ID
   		jQuery('#tribe-community-events tbody tr').each(function(){
      		var cell = jQuery(this).find('th, td').eq(i);                        
      		cell.attr('headers', id);
      		if (classes) { cell.addClass(classes); };
  	 	});
     	// create the menu hide/show toggles
   		if ( !th.is('.persist') ) {
      		// note that each input's value matches the header's ID; 
      		// later we'll use this value to control the visibility
      		// of that header and it's associated cells
      		var toggle = jQuery('<li><input type="checkbox" name="toggle-cols" id="toggle-col-'+i+'" value="'+id+'" /> <label for="toggle-col-'+i+'">'+th.text()+'</label></li>');
      
      		// append each toggle to the container
      		container.find('ul').append(toggle); 
	
			toggle.find('input').change(function(){
            	var input = jQuery(this), 
            	val = input.val(),  // this equals the header's ID, i.e. "company"
            	cols = jQuery("#" + val + ", [headers="+ val +"]"); // so we can easily find the matching header (id="company") and cells (headers="company")
         
            	if (input.is(':checked')) { cols.show(); }
            	else { cols.hide(); };		
         	})
         	// custom event that sets the checked state for each toggle based
         	// on column visibility, which is controlled by @media rules in the CSS
         	// called whenever the window is resized or reoriented (mobile)
         	.bind('updateCheck', function(){
            	if ( th.css('display') ==  'table-cell') {
               		jQuery(this).attr('checked', true);
            	}
            	else {
               		jQuery(this).attr('checked', false);
            	};
         	})
         
         	// call the custom event on load
         	.trigger('updateCheck');
   	 	};
	});
	// update the inputs' checked status
	jQuery(window).bind('orientationchange resize', function(){
   		container.find('input').trigger('updateCheck');
	});
	
	var menuWrapper = jQuery('<div class="table-menu-wrapper" />'),
   	menuBtn = jQuery('.table-menu-btn');
      
	menuBtn.click(function(){
   		container.toggleClass('table-menu-hidden');            
   		return false;
	});
	// assign click-away-to-close event
	jQuery(document).click(function(e){								
   		if ( !jQuery(e.target).is( container ) ) {
   			if ( !jQuery(e.target).is( container.find('*') ) ) {			
      			container.addClass('table-menu-hidden');
      		}
   		}				
	});
	
	// our events list js
	jQuery('#show_hidden_categories').click(function() {
		//jQuery('#event-categories').css('overflow-y', 'scroll');
		jQuery('.hidden_category').show('medium');
		jQuery('#show_hidden_categories').hide();
		return false;
	});	
});