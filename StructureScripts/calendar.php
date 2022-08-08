
<!------ Include the above in your HEAD tag ---------->
<script type="text/javascript">

function datetime_local_format(date)
{
	var standar_date = date.getFullYear() + "-";
	if(date.getMonth()<10)
	{
		standar_date += "0";
	}
	standar_date += (date.getMonth() + 1) + "-";
	if(date.getDate()<10)
	{
		standar_date += "0";
	}
	standar_date += date.getDate() + "T";
	if(date.getHours()<10)
	{
		standar_date += "0";
	}
	standar_date += date.getHours() + ":";
	if(date.getMinutes()<10)
	{
		standar_date += "0";
	}
	standar_date += date.getMinutes();
	return standar_date;

}

$(document).ready(function() {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	/*  className colors
	
	className: default(transparent), important(red), chill(pink), success(green), info(blue)
	
	*/		
	
	  
	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events div.external-event').each(function() {
	
		// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
		// it doesn't need to have a start or end
		var eventObject = {
			title: $.trim($(this).text()) // use the element's text as the event title
		};
		
		// store the Event Object in the DOM element so we can get to it later
		$(this).data('eventObject', eventObject);
		
		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});
		
	});


	/* initialize the calendar
	-----------------------------------------------------------------*/
	
	var calendar =  $('#calendar').fullCalendar({
		header: {
			left: 'title',
			center: 'agendaDay,agendaWeek,month',
			right: 'prev,next today'
		},
		editable: true,
		firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
		selectable: true,
		defaultView: 'month',
		
		axisFormat: 'h:mm',
		columnFormat: {
			month: 'ddd',    // Mon
			week: 'ddd d', // Mon 7
			day: 'dddd M/d',  // Monday 9/7
			agendaDay: 'dddd d'
		},
		titleFormat: {
			month: 'MMMM yyyy', // September 2009
			week: "MMMM yyyy", // September 2009
			day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
		},
		allDaySlot: false,
		selectHelper: true,
		select: function(start, end, allDay) {

      document.getElementById("add_event_start").value = datetime_local_format(start);
      document.getElementById("add_event_end").value = datetime_local_format(end);

      $('#add_event_modal').modal('show');
			/*var title = prompt('Event Title:');
			if (title) {
				calendar.fullCalendar('renderEvent',
					{
						title: title,
						start: start,
						end: end,
						allDay: allDay
					},
					true // make the event "stick"
				);
			}*/
			calendar.fullCalendar('unselect');
		},
		droppable: true, // this allows things to be dropped onto the calendar !!!
		drop: function(date, allDay) { // this function is called when something is dropped
		
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
			
		},
		//FOR CON TODOS LOS EVENTOS PHP
		events: [
			{
				title: 'All Day Event',
				start: new Date(y, m, 1)
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: new Date(y, m, d-3, 16, 0),
				allDay: false,
				className: 'info'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: new Date(y, m, d+4, 16, 0),
				allDay: false,
				className: 'info'
			},
			{
				title: 'Meeting',
				start: new Date(y, m, d, 10, 30),
				allDay: false,
				className: 'important'
			},
			{
				title: 'Lunch',
				start: new Date(y, m, d, 12, 0),
				end: new Date(y, m, d, 14, 0),
				allDay: false,
				className: 'important'
			},
			{
				title: 'Birthday Party',
				start: new Date(y, m, d+1, 19, 0),
				end: new Date(y, m, d+1, 22, 30),
				allDay: false,
			},
			{
				title: 'Click for Google',
				start: new Date(y, m, 28),
				end: new Date(y, m, 29),
				url: 'https://ccp.cloudaccess.net/aff.php?aff=5188',
				className: 'success'
			},
			{
				id: 1,
				title: 'Test',
				start: new Date(y, m, d, 19, 0),
				end: new Date(y, m, d, 22, 30),
				className: 'success'
			}
		],			
	});
	
	
});
</script>

<div id='wrap'>
	<div id='calendar'></div>
	<div style='clear:both'></div>
</div>

<!-- Modal FORM PARA MANDAR PETICION SQL-->
<div class="modal fade" id="add_event_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add an event</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="Summary" aria-label="Username" aria-describedby="basic-addon1" name="user">
        <textarea class="form-control" name="" rows="2" placeholder="Description"></textarea>
        <input id="add_event_start" type="datetime-local" value="" name="">
        <input id="add_event_end" type="datetime-local" value="" name="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal AQUI FOR CON TODOS LOS MODALS DE CADA UNO DE LOS EVENTOS -->
<div class="modal fade" id="event_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add an event</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="Summary" aria-label="Username" aria-describedby="basic-addon1" name="user">
        <textarea class="form-control" name="" rows="2" placeholder="Description"></textarea>
        <input id="add_event_start" type="datetime-local" value="" name="">
        <input id="add_event_end" type="datetime-local" value="" name="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<p id="demo">HEHEHEHE</p>
