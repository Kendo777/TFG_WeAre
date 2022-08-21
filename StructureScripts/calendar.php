<?php
if(isset($_SESSION["user"]) && $session_user["rol"] != "reader")
{
  if(isset($_POST["add_event_title"]))
  {
    $title = mysql_fix_string($mySqli_db, $_POST['add_event_title']);
    $description = str_replace("<script", "", $_POST["add_event_description"]);
    $description = str_replace("</script>", "", $description);
    $description = str_replace("<style", "", $description);
    $description = str_replace("</style>", "", $description);
    $description = str_replace("<?php", "", $description);
    $description = str_replace("?>", "", $description);
    $description = mysql_fix_string($mySqli_db, $description);
    $color = mysql_fix_string($mySqli_db, $_POST['add_event_color']);
    $start = $_POST["add_event_start"];
    $end = $_POST["add_event_end"];

    if($start < $end)
    {    
      $sql= $mySqli_db->prepare("INSERT INTO `calendar_events`(`calendar_id`, `title`, `description`, `color`, `start`, `end`) VALUES (?, ?, ?, ?, ?, ?)");
      $sql->bind_param("isssss", $_GET["calendar"], $title, $description, $color, $start, $end);
      $sql->execute();
    }
    else
    {
      $errorMsg.='<p class="alert alert-danger">Date is not set correctly</p>';
    }
  }
  if(isset($_POST["delete_event_id"]))
  {
    $id = $_POST["delete_event_id"];

    $sql= $mySqli_db->prepare("DELETE FROM `calendar_events` WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
  }
  if(isset($_POST["edit_event_id"]))
  {
    $id = $_POST["edit_event_id"];
    $title = mysql_fix_string($mySqli_db, $_POST['edit_event_title']);
    $description = str_replace("<script", "", $_POST["edit_event_description"]);
    $description = str_replace("</script>", "", $description);
    $description = str_replace("<style", "", $description);
    $description = str_replace("</style>", "", $description);
    $description = str_replace("<?php", "", $description);
    $description = str_replace("?>", "", $description);
    $description = mysql_fix_string($mySqli_db, $description);
    $color = mysql_fix_string($mySqli_db, $_POST['edit_event_color']);
    $start = $_POST["edit_event_start"];
    $end = $_POST["edit_event_end"];

    if($start < $end)
    {  
    $sql= $mySqli_db->prepare("UPDATE `calendar_events` SET `title`=?,`description`=?, `color`=?, `start`=?,`end`=? WHERE id = ?");
    $sql->bind_param("sssssi", $title, $description, $color, $start, $end, $id);
    $sql->execute();
    }
    else
    {
      $errorMsg.='<p class="alert alert-danger">Date is not set correctly</p>';
    }
  }
}
else if(isset($_POST["add_event_title"]) || isset($_POST["edit_event_title"]))
{
  $errorMsg.='<p class="alert alert-danger">You do not have privileges to create or edit components, please create an account or contact the administrator of the page</p>';
}
  echo $errorMsg;
?>


<!------ Include the above in your HEAD tag ---------->
<script type="text/javascript">

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
      <?php
        if($json_data["web_data"]["web_structure"] == "basic")
        {
          $calendar_id = 1;
        }
        else if(isset($_GET["calendar"]))
        {
          $calendar_id = $_GET["calendar"];
        }
        $sql= $mySqli_db->prepare("SELECT * FROM calendar_events WHERE calendar_id = ?");
        $sql->bind_param("i", $calendar_id);
        $sql->execute();
        $result=$sql->get_result();

        for($i=0; $i<$result->num_rows; $i++)
        {
          $row=$result->fetch_assoc();
          echo '{';
          echo 'id: ' . $row["id"] . ", ";
          echo 'title: "' . $row["title"] . '", ';
          echo 'description: "' . $row["description"] . '", ';
          echo 'color: "' . $row["color"] . '", ';
          echo 'start: "' . $row["start"] . '", ';
          echo 'end: "' . $row["end"] . '", ';
          echo 'allDay: false';
          if($i<$result->num_rows-1)
          {
            echo '},'.PHP_EOL;
          }
          else
          {
            echo '}';
          }

        }

      ?>
		],			
	});
	
	
});
</script>

<div class="row mt-4">
    <div data-aos="fade-up" data-aos-delay="200">
    <div class="section-header">
<?php
  $sql= $mySqli_db->prepare("SELECT * FROM calendars WHERE id = ?");
  $sql->bind_param("i", $calendar_id);
  $sql->execute();
  $result=$sql->get_result();
  $calendar=$result->fetch_assoc();
  echo '<h2><i>' . str_replace("\'", "'",str_replace("\\\"", "\"", $calendar["title"])) . '</i></h2>
  <p>' . str_replace("\'", "'",str_replace("\\\"", "\"", $calendar["description"])) . '</p>';
?>
</div>
</div>
</div>
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
      <form action="<?php echo $url; ?>" method="post" role="form">
        <div class="modal-body">
          <input type="text" class="form-control" name="add_event_title" placeholder="Summary" aria-describedby="basic-addon1" required>
          <textarea class="form-control" name="add_event_description" rows="4" placeholder="Description"></textarea>
          <label for="add_event_color" class="mb-2">Event Color</label>
          <select class="form-control mb-2" id="add_event_color" name="add_event_color">
            <option style="color: white; background-color: DeepSkyBlue;" value="DeepSkyBlue">Blue</option>
            <option style="color: white; background-color: Cyan;" value="Cyan">Cyan</option>
            <option style="color: white; background-color: Crimson;" value="Crimson">Red</option>
            <option style="color: white; background-color: Orange;" value="Orange">Orange</option>
            <option style="color: white; background-color: Gold;" value="Gold">Yellow</option>
            <option style="color: white; background-color: HotPink;" value="HotPink">Pink</option>
            <option style="color: white; background-color: BlueViolet;" value="BlueViolet">Purple</option>
            <option style="color: white; background-color: LimeGreen;" value="LimeGreen">Green</option>
            <option style="color: white; background-color: YellowGreen;" value="YellowGreen">Pistachio</option>            
          </select>
          <input id="add_event_start" type="datetime-local" value="" name="add_event_start" required>
          <input id="add_event_end" type="datetime-local" value="" name="add_event_end" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" >Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal AQUI FOR CON TODOS LOS MODALS DE CADA UNO DE LOS EVENTOS -->
<div class="modal fade" id="edit_event_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add an event</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo $url; ?>" method="post" role="form">
        <div class="modal-body">
            <input type="hidden" id="edit_event_id" name="edit_event_id">
            <input type="text" class="form-control" id="edit_event_title"  name="edit_event_title" placeholder="Summary" aria-describedby="basic-addon1">
            <textarea class="form-control" id="edit_event_description" name="edit_event_description" rows="4" placeholder="Description"></textarea>
            <label for="edit_event_color" class="mb-2">Event Color</label>
            <select class="form-control mb-2" id="edit_event_color" name="edit_event_color">
              <option style="color: white; background-color: DeepSkyBlue;" value="DeepSkyBlue">Blue</option>
              <option style="color: white; background-color: Cyan;" value="Cyan">Cyan</option>
              <option style="color: white; background-color: Crimson;" value="Crimson">Red</option>
              <option style="color: white; background-color: Orange;" value="Orange">Orange</option>
              <option style="color: white; background-color: Gold;" value="Gold">Yellow</option>
              <option style="color: white; background-color: HotPink;" value="HotPink">Pink</option>
              <option style="color: white; background-color: BlueViolet;" value="BlueViolet">Purple</option>
              <option style="color: white; background-color: LimeGreen;" value="LimeGreen">Green</option>
              <option style="color: white; background-color: YellowGreen;" value="YellowGreen">Pistachio</option>          
            </select>
            <input id="edit_event_start" type="datetime-local" value="" name="edit_event_start">
            <input id="edit_event_end" type="datetime-local" value="" name="edit_event_end">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      <form action="<?php echo $url; ?>" method="post" role="form">
        <div class="modal-footer">
              <input type="hidden" id="delete_event_id" name="delete_event_id">
              <button type="submit" class="btn btn-danger">Delete event</button>
        </div>
      </form>
    </div>
  </div>
</div>
