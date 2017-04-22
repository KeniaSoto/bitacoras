// JavaScript Document
$(document).ready(function() {
	  $('#btnDel').attr('disabled','disabled');
	  $('#btnAdd').click(function() {
		var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
		var newNum = new Number(num + 1); // the numeric ID of the new input field being added
	
		// create the new element via clone(), and manipulate it's ID using newNum value
		var newElem = $('#input' + num).clone().attr('id', 'Add' + newNum);
	
		// manipulate the name/id values of the input inside the new element
		newElem.children(':last').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
	
		// insert the new element after the last "duplicatable" input field
		$('#input' + num).after(newElem);
	
		// enable the "remove" button
		$('#btnDel').attr('disabled',false);
	
		// business rule: you can only add 10 names
		if (newNum == 6)
		  $('#btnAdd').attr('disabled','disabled');
	  });

	  $('#btnDel').click(function() {
		var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
		$('#input' + num).remove(); // remove the last element
	
		// enable the "add" button
		$('#btnAdd').attr('disabled',false);
	
		// if only one element remains, disable the "remove" button
		if (num-1 == 1)
		  $('#btnDel').attr('disabled','disabled');
	  });
	
	});