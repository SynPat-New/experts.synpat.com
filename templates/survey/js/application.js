jQuery(document).ready(function($) {
	zebraRows('.sortingTable tr:odd td', 'odd');
	
	$('.sortingTable tbody tr').hover(function(){
	  $(this).find('td').addClass('hovered');
	}, function(){
	  $(this).find('td').removeClass('hovered');
	});
	
	//default each row to visible
	$('.sortingTable tbody tr').addClass('visible');
	
	//overrides CSS display:none property
	//so only users w/ JS will see the
	//filter box
	/*
	jQuery('#search').show();
	*/
	jQuery('#filter').keyup(function(event) {
		//if esc is pressed or nothing is entered
    if (event.keyCode == 27 || jQuery(this).val() == '') {
			//if esc is pressed we want to clear the value of search box
			$(this).val('');
			
			//we want each row to be visible because if nothing
			//is entered then all rows are matched.
      jQuery('.sortingTable tbody tr').removeClass('visible').show().addClass('visible');
    }

		//if there is text, lets filter
		else {
      filter('.sortingTable tbody tr', jQuery(this).val());
    }

		//reapply zebra rows
		$('.visible td').removeClass('odd');
		zebraRows('.visible:even td', 'odd');
	});
	
	//grab all header rows
	jQuery('.sortingTable thead th').each(function(column) {
		jQuery(this).addClass('sortable')
					.click(function(){
						var findSortKey = function($cell) {
							return $cell.find('.sort-key').text().toUpperCase() + ' ' + $cell.text().toUpperCase();
						};
						
						var sortDirection = jQuery(this).is('.sorted-asc') ? -1 : 1;
						
						//step back up the tree and get the rows with data
						//for sorting
						var $rows		= jQuery(this).parent()
																.parent()
																.parent()
																.find('tbody tr')
																.get();
						
						//loop through all the rows and find 
						jQuery.each($rows, function(index, row) {
							row.sortKey = findSortKey(jQuery(row).children('td').eq(column));
						});
						
						//compare and sort the rows alphabetically
						$rows.sort(function(a, b) {
							if (a.sortKey < b.sortKey) return -sortDirection;
							if (a.sortKey > b.sortKey) return sortDirection;
							return 0;
						});
						
						//add the rows in the correct order to the bottom of the table
						jQuery.each($rows, function(index, row) {
							jQuery('.sortingTable tbody').append(row);
							row.sortKey = null;
						});
						
						//identify the column sort order
						jQuery('.sortingTable th').removeClass('sorted-asc sorted-desc');
						var $sortHead = jQuery('th').filter(':nth-child(' + (column + 1) + ')');
						sortDirection == 1 ? $sortHead.addClass('sorted-asc') : $sortHead.addClass('sorted-desc');
						
						//identify the column to be sorted by
						jQuery('.sortingTable td').removeClass('sorted')
									.filter(':nth-child(' + (column + 1) + ')')
									.addClass('sorted');
						
						jQuery('.visible td').removeClass('odd');
						zebraRows('.visible:even td', 'odd');
					});
	});
});


//used to apply alternating row styles
function zebraRows(selector, className)
{
	jQuery(selector).removeClass(className)
							.addClass(className);
}

//filter results based on query
function filter(selector, query) {
	query	=	jQuery.trim(query); //trim white space
  query = query.replace(/ /gi, '|'); //add OR for regex
  
  jQuery(selector).each(function() {
    (jQuery(this).text().search(new RegExp(query, "i")) < 0) ? jQuery(this).hide().removeClass('visible') : jQuery(this).show().addClass('visible');
  });
}





















jQuery(document).ready(function($) {
	zebraRows1('.sortingTable1 tr:odd td', 'odd');
	
	$('.sortingTable1 tbody tr').hover(function(){
	  $(this).find('td').addClass('hovered');
	}, function(){
	  $(this).find('td').removeClass('hovered');
	});
	
	//default each row to visible
	$('.sortingTable1 tbody tr').addClass('visible');
	
	//overrides CSS display:none property
	//so only users w/ JS will see the
	//filter box
	/*
	jQuery('#search').show();
	*/
	jQuery('#filter').keyup(function(event) {
		//if esc is pressed or nothing is entered
    if (event.keyCode == 27 || jQuery(this).val() == '') {
			//if esc is pressed we want to clear the value of search box
			$(this).val('');
			
			//we want each row to be visible because if nothing
			//is entered then all rows are matched.
      jQuery('.sortingTable1 tbody tr').removeClass('visible').show().addClass('visible');
    }

		//if there is text, lets filter
		else {
      filter('.sortingTable1 tbody tr', jQuery(this).val());
    }

		//reapply zebra rows
		$('.visible td').removeClass('odd');
		zebraRows1('.visible:even td', 'odd');
	});
	
	//grab all header rows
	jQuery('.sortingTable1 thead th').each(function(column) {
		jQuery(this).addClass('sortable')
					.click(function(){
						var findSortKey = function($cell) {
							return $cell.find('.sort-key').text().toUpperCase() + ' ' + $cell.text().toUpperCase();
						};
						
						var sortDirection = jQuery(this).is('.sorted-asc') ? -1 : 1;
						
						//step back up the tree and get the rows with data
						//for sorting
						var $rows		= jQuery(this).parent()
																.parent()
																.parent()
																.find('tbody tr')
																.get();
						
						//loop through all the rows and find 
						jQuery.each($rows, function(index, row) {
							row.sortKey = findSortKey(jQuery(row).children('td').eq(column));
						});
						
						//compare and sort the rows alphabetically
						$rows.sort(function(a, b) {
							if (a.sortKey < b.sortKey) return -sortDirection;
							if (a.sortKey > b.sortKey) return sortDirection;
							return 0;
						});
						
						//add the rows in the correct order to the bottom of the table
						jQuery.each($rows, function(index, row) {
							jQuery('.sortingTable1 tbody').append(row);
							row.sortKey = null;
						});
						
						//identify the column sort order
						jQuery('.sortingTable th').removeClass('sorted-asc sorted-desc');
						var $sortHead = jQuery('th').filter(':nth-child(' + (column + 1) + ')');
						sortDirection == 1 ? $sortHead.addClass('sorted-asc') : $sortHead.addClass('sorted-desc');
						
						//identify the column to be sorted by
						jQuery('.sortingTable1 td').removeClass('sorted')
									.filter(':nth-child(' + (column + 1) + ')')
									.addClass('sorted');
						
						jQuery('.visible td').removeClass('odd');
						zebraRows1('.visible:even td', 'odd');
					});
	});
});


//used to apply alternating row styles
function zebraRows1(selector, className)
{
	jQuery(selector).removeClass(className)
							.addClass(className);
}

//filter results based on query
function filter1(selector, query) {
	query	=	jQuery.trim(query); //trim white space
  query = query.replace(/ /gi, '|'); //add OR for regex
  
  jQuery(selector).each(function() {
    (jQuery(this).text().search(new RegExp(query, "i")) < 0) ? jQuery(this).hide().removeClass('visible') : jQuery(this).show().addClass('visible');
  });
}