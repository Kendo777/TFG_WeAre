<header>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="StructureScripts\assets\js\dynamicForm.js"></script>

</header>

<section class="d-flex align-items-center">
  <div class="container" data-aos="fade-up">

    <div class="section-header mt-5">
      <h2 data-aos="fade-up" data-aos-delay="400">Create your own web page</h2>
      <?php if(isset($errorMsg)) echo '<div data-aos="fade-up" data-aos-delay="400">'.$errorMsg.'</div>'; ?>
    </div>

    <div class="row justify-content-center">
        <form action="<?php echo $url; ?>" method="post" role="form">
        <!-- ======= Configuration components ======= -->
        <section id="faq" class="faq">
          <div class="accordion accordion-flush px-xl-5" id="faqlist">

          <!-- General Configuration -->
          <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#general">
                      <i class="bi bi-globe2 question-icon"></i>
                        General
                    </button>
                </h3>
                <div id="general" class="accordion-collapse collapse show"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <label><b>1. Web Name</b></label><br>
                    <input type="text" class="form-control" name="web_name" <?php if(isset($json_data)) { echo 'value="' . $json_data["web_data"]["web_current_name"] . '"'; } ?> required>
                    <br>
                    <label for="web_privacity" class="mb-2"><b>2. Privacity</b></label>
                      <select class="form-control mb-2" id="web_privacity" name="web_privacity">
                      <?php
                        echo '<option ';
                        if(isset($json_data) && $json_data["web_data"]["web_privacity"] == "Public") 
                        {
                          echo 'selected';
                        }
                          echo '>Public</option>
                          <option ';
                        if(isset($json_data) && $json_data["web_data"]["web_privacity"] == "Private") 
                        {
                          echo 'selected';
                        }
                        echo '>Private</option>
                        <option';
                        if(isset($json_data) && $json_data["web_data"]["web_privacity"] == "Invitation") 
                        {
                          echo 'selected';
                        }
                        echo '>Invitation</option>';
                        
                        ?>
                      </select>
                  </div>
                </div>
              </div><!-- End Component item-->

            <!-- Style Configuration -->
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#style">
                      <i class="bi bi-brush question-icon"></i>
                        Style
                    </button>
                </h3>
                <div id="style" class="accordion-collapse collapse show"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <p>Web page style: colors,...</p>
                    <div class="form-group">
                      <label for="style_bck_color" class="mb-2"><b>1. Background Color picker</b></label>
                      <input type="color" class="form-control form-control-color" id="style_bck_color" name="style_bck_color" <?php if(isset($json_data)) { echo 'value="' . $json_data["style"]["bck_color"] . '"'; } else { echo 'value="#FFFFFF"'; } ?> title="Choose your color">
                      <label for="style_bck_color" class="mb-2"><b>2. Primary Color picker</b><small>Text color</small></label>
                      <input type="color" class="form-control form-control-color" id="style_primary_color" name="style_primary_color" <?php if(isset($json_data)) { echo 'value="' . $json_data["style"]["primary_color"] . '"'; } else { echo 'value="#000000"'; } ?> title="Choose your color">
                      <label for="style_bck_color" class="mb-2"><b>3. Secundary Color picker</b><small>Borders color,...</small></label>
                      <input type="color" class="form-control form-control-color" id="style_secundary_color" name="style_secundary_color" <?php if(isset($json_data)) { echo 'value="' . $json_data["style"]["secundary_color"] . '"'; } else { echo 'value="#000000"'; } ?> title="Choose your color">
                    </div>
                  </div>
                </div>
              </div><!-- End Component item-->
              <!-- Blog Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#users">
                      <input type="checkbox" class="form-check-input" id="users_enable" name="users_enable" <?php if(isset($json_data) && $json_data["user"]["enable"]) { echo 'checked'; } ?> data-bs-toggle="collapse" data-bs-target="#users" style="position:absolute !important; left: 2% !important;">
                      <label class="form-check-label" for="users_enable">
                        <i class="bi bi-images question-icon"></i>
                          User
                      </label>
                    </button>
                </h3>
                <div id="users" class="accordion-collapse collapse <?php if(isset($json_data) && $json_data["user"]["enable"]) { echo 'show'; } ?>"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <div class="row">
                      <div class="col-lg-12">
                        <div id="inputFormRow">
                              <?php
                              if(isset($_GET["edit"]))
                              {
                                $sql= $mySqlidb->prepare("SHOW COLUMNS FROM " . mysql_fix_string($mySqlidb, $json_data["web_data"]["web_database"]) . ".users");
                                $sql->execute();
                                $result_columns=$sql->get_result();
                                for($i=0; $i<$result_columns->num_rows; $i++)
                                {
                                  $column=$result_columns->fetch_assoc();
                                  if($column["Field"] != "user" && $column["Field"] != "email" && $column["Field"] != "user_name" && $column["Field"] != "password" && $column["Field"] != "valid" && $column["Field"] != "rol")
                                  {
                                    $type = "";
                                    switch($column["Type"])
                                    {
                                      case "varchar(60)":
                                        $type = "Text";
                                        break;
                                      case "varchar(2000)":
                                        $type = "Paragraph";
                                        break;
                                      case "int(6)":
                                        $type = "Number";
                                        break;
                                      case "date":
                                        $type = "Date";
                                        break;  
                                    }
                                    echo '<div class="input-group mb-3">
                                        <button class="btn btn-info disabled">' . $type . '</button> 
                                        <form></form>                               
                                        <form action="' . $url . '" method="post" role="form" style="flex: 1 1 auto;">
                                        <div class="input-group">
                                            <input type="text" name="column_name" class="form-control m-input" placeholder="User Attribute" value="' . ucfirst($column["Field"]) . '">
                                            <input type="hidden" name="rename_column" value="' . $column["Field"] . '">
                                            <input type="hidden" name="column_type" value="' . $column["Type"] . '">
                                            <button type="submit" class="btn btn-warning mx-2"><i class="bi bi-pencil-fill"></i></button>
                                          </div>
                                        </form>
                                        <div class="input-group-append d-flex">
                                        <form action="' . $url . '" method="post" role="form">
                                          <input type="hidden" name="delete_column" value="' . $column["Field"] . '">
                                          <button type="submit" class="btn btn-danger" onclick="return confirm(\'You are going to delete a users attribute\nOnce deleted it cannot be recovered. Are you sure?\')"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                      </div>
                                    </div>';
                                  }
                                }
                              }
                                echo '<div id="inputFormRow">
                                <div class="input-group mb-3">
                                  <select class="btn btn-outline-info" id="add_event_color" name="column_type[]">
                                    <option value="VARCHAR(60)">Text</option>
                                    <option value="INT(4)">Number</option>
                                    <option value="DATE">Date</option>
                                    <option value="VARCHAR(2000)">Paragraph</option>
                                  </select>
                                <input type="text" name="column_name[]" class="form-control m-input" placeholder="User Attribute">
                                <div class="input-group-append mx-3">
                                  <button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </div>
                                </div>
                                </div>';
                              
                              ?>
                        </div>
                        <div id="usernewRow"></div>
                        <button onclick="addUserRow()" type="button" class="btn btn-info">Add Attribute</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- End Component item-->
              <!-- Navbar Configuration -->
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navBar">
                      <i class="bi bi-segmented-nav question-icon"></i>
                        Navigation Bar
                    </button>
                </h3>
                <div id="navBar" class="accordion-collapse collapse show"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <label for="navBar_type" class="mb-2"><b>1. Navigation bar type</b></label>
                    <select class="form-control mb-2" id="navBar_type" name="navBar_type">
                      <option>Clasic Navigation Bar</option>
                      <option>Side Collapser Bar</option>
                    </select>
                    <label for="style_bck_color" class="mb-2"><b>2. Make your own custom web page</b></label>
                    <div id="inputFormRow">
                      <div class="input-group mb-3">
                        <select class="btn btn-outline-info" id="add_event_color" disabled>
                          <option>Home</option>
                        </select>
                        <input type="text" name="home_name" class="form-control m-input" placeholder="Home Tab">
                      </div>
                    </div>
                      <div id="tab_new_row"></div>
                      <button onclick="add_tab_row()" type="button" class="btn btn-info">Add New Tab</button>
                  </div>
                </div>
              </div><!-- End Component item-->
              
              <div class="form-group row mt-5">
                <div class="col-sm-10">
                  <?php
                    if(isset($_GET["edit"]))
                    {
                      echo '<input type="hidden" name="save">';
                    }
                    echo '<button type="submit" class="btn btn-primary">';
                    if(isset($_GET["edit"]))
                    {
                      echo 'Save Changes';
                    }
                    else
                    {
                      echo 'Create';
                    }
                    echo '</button>';
                  ?>
                </div>
              </div>
        </section><!-- End Configuration components -->
      </form>
    </div>
  </div>
</section>




