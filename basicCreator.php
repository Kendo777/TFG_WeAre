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
                      <label for="style_bck_color" class="mb-2"><b>1. Primary Color picker</b><small>Text color</small></label>
                      <input type="color" class="form-control form-control-color" id="style_primary_color" name="style_primary_color" <?php if(isset($json_data)) { echo 'value="' . $json_data["style"]["primary_color"] . '"'; } else { echo 'value="#000000"'; } ?> title="Choose your color">
                      <label for="style_bck_color" class="mb-2"><b>1. Secundary Color picker</b><small>Borders color,...</small></label>
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
                <div id="users" class="accordion-collapse collapse <?php if(isset($json_data) && !$json_data["user"]["enable"]) { echo 'show'; } ?>"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
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
                                  <input type="text" class="form-control m-input" placeholder="User Attribute" value="' . ucfirst($column["Field"]) . '">
                                      <div class="input-group-append mx-3">
                                        <form action="' . $url . '" method="post" role="form">
                                          <input type="hidden" name="delete_column" value="' . $column["Field"] . '">
                                          <button type="submit" class="btn btn-danger" onclick="return confirm(\'You are going to delete a users attribute\nOnce deleted it cannot be recovered. Are you sure?\')"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                      </div>
                                    </div>';
                                  }
                                }
                              }
                              else
                              {
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
                              }
                              ?>
                        </div>
                        <div id="usernewRow"></div>
                        <button onclick="addUserRow()" type="button" class="btn btn-info">Add Row</button>
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
                <div id="navBar" class="accordion-collapse collapse"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <label for="navBar_type" class="mb-2"><b>1. Navigation bar type</b></label>
                    <select class="form-control mb-2" id="navBar_type" name="navBar_type">
                      <option>Clasic Navigation Bar</option>
                      <option>Side Collapsed Bar</option>
                    </select>
                  </div>
                </div>
              </div><!-- End Component item-->
              
              <!-- Gallery Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#gallery">
                      <input type="checkbox" class="form-check-input" id="gallery_enable" name="gallery_enable" <?php if(isset($json_data) && $json_data["gallery"]["enable"]) { echo 'checked'; } ?> data-bs-toggle="collapse" data-bs-target="#gallery" style="position:absolute !important; left: 2% !important;">
                      <label class="form-check-label" for="gallery_enable">
                        <i class="bi bi-images question-icon"></i>
                          Gallery
                      </label>
                    </button>
                </h3>
                <div id="gallery" class="accordion-collapse collapse <?php if(isset($json_data) && $json_data["gallery"]["enable"]) { echo 'show'; } ?>"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                  <div class="accordion-body" data-aos="fade-up" data-aos-delay="200">
                    <p>Upload your images to your web page</p>
                    <div class="form-group">
                    <div class="row">
                      <section id="portfolio" class="portfolio">
                          <div class="container">
                            <div class="section-header">
                            <h2>Grid Gallery</h2>
                            <p>Non hic nulla eum consequatur maxime ut vero memo vero totam officiis pariatur eos dolorum sed fug dolorem est possimus esse quae repudiandae. Dolorem id enim officiis sunt deserunt esse soluta consequatur quaerat</p>
                          </div>
                        </div>
                        <div class="container-fluid" style="width: 50%;">
                          <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">
                            <div class="row g-0">
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/app-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/product-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/branding-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/books-1.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/app-2.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/product-2.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/branding-2.jpg" class="img-fluid glightbox" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/books-2.jpg" class="img-fluid glightbox" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/app-3.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/product-3.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/branding-3.jpg" class="img-fluid" alt="">
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item" style="pointer-events: none !important;">
                              <img src="assets/img/portfolio/books-3.jpg" class="img-fluid glightbox preview-link" alt="">
                            </div><!-- End Portfolio Item -->
                            
                          </div><!-- End Portfolio Container -->
                        </div>
                      </div>
                      </section><!-- End Portfolio Section -->
                      </div>
                      <div class="row">
                      <section id="portfolio" class="portfolio">
                          <div class="container">
                            <div class="section-header">
                            <h2>Zoom Gallery</h2>
                            <p>Non hic nulla eum consequatur maxime ut vero memo vero totam officiis pariatur eos dolorum sed fug dolorem est possimus esse quae repudiandae. Dolorem id enim officiis sunt deserunt esse soluta consequatur quaerat</p>
                          </div>

                        </div>
                        <div class="container-fluid"  style="width: 50%;">
                          <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">
                            <div class="row g-0">
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/app-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/app-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/product-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/product-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/branding-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/branding-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/books-1.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/books-1.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/app-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/app-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/product-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/product-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/branding-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/branding-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/books-2.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/books-2.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/app-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/app-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/product-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/product-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/branding-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/branding-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item">
                              <img src="assets/img/portfolio/books-3.jpg" class="img-fluid glightbox preview-link" alt="">
                              <div class="portfolio-info" style="top: 0 !important;">
                                <a href="assets/img/portfolio/books-3.jpg" class="glightbox preview-link" style="left: 45% !important;">
                                  <i class="bi bi-zoom-in" style="font-size: 3vw !important;"></i>
                                </a>
                              </div>
                            </div><!-- End Portfolio Item -->
                            
                          </div><!-- End Portfolio Container -->
                        </div>
                      </div>
                      </section><!-- End Portfolio Section -->
                      </div>
                      <small class="form-text text-muted">All gallery types examples.<br><br></small>
                      <label for="gallery_type" class="mb-2"><b>1. Gallery type</b></label>
                      <select class="form-control mb-2" id="gallery_type" name="gallery_type">
                        <?php
                        echo '<option ';
                        if(isset($json_data) && $json_data["gallery"]["type"] == "Grid Gallery View") 
                        {
                          echo 'selected';
                        }
                          echo '>Grid Gallery View</option>
                                <option ';
                        if(isset($json_data) && $json_data["gallery"]["type"] == "Zoom Gallery View") 
                        {
                          echo 'selected';
                        }
                        echo '>Zoom Gallery View</option>';
                        
                        ?>
                        <!-- <option>Basic Carousel View</option>
                        <option>Carousel View</option> -->
                      </select>
                      <small class="form-text text-muted">Choose type of gallery.</small>
                    </div>
                  </div>
                </div>
              </div><!-- End Component item-->

              <!-- Blog Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#blog">
                      <input type="checkbox" class="form-check-input" id="blog_enable" name="blog_enable" <?php if(isset($json_data) && $json_data["blog"]["enable"]) { echo 'checked'; } ?> data-bs-toggle="collapse" data-bs-target="#blog" style="position:absolute !important; left: 2% !important;">
                      <label class="form-check-label" for="blog_enable">
                        <i class="bi bi-newspaper question-icon"></i>
                          Blog
                      </label>
                    </button>
                </h3>
                <div id="blog" class="accordion-collapse collapse <?php if(isset($json_data) && $json_data["blog"]["enable"]) { echo 'show'; } ?>"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                      </div>
              </div><!-- End Component item-->

              <!-- Forum Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#forum">
                      <input type="checkbox" class="form-check-input" id="forum_enable" name="forum_enable" <?php if(isset($json_data) && $json_data["forum"]["enable"]) { echo 'checked'; } ?> data-bs-toggle="collapse" data-bs-target="#forum" style="position:absolute !important; left: 2% !important;">
                      <label class="form-check-label" for="forum_enable">
                        <i class="bi bi-bar-chart-steps question-icon"></i>
                        Forum
                      </label>
                    </button>
                </h3>
                <div id="forum" class="accordion-collapse collapse <?php if(isset($json_data) && $json_data["forum"]["enable"]) { echo 'show'; } ?>"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
                      </div>
              </div><!-- End Component item-->

              <!-- Forum Configuration -->
              <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                <h3 class="accordion-header form-check form-switch">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#calendar">
                      <input type="checkbox" class="form-check-input" id="calendar_enable" name="calendar_enable" <?php if(isset($json_data) && $json_data["calendar"]["enable"]) { echo 'checked'; } ?> data-bs-toggle="collapse" data-bs-target="#calendar" style="position:absolute !important; left: 2% !important;">
                      <label class="form-check-label" for="calendar_enable">
                        <i class="bi bi-calendar-week question-icon"></i>
                        Calendar
                      </label>
                    </button>
                </h3>
                <div id="calendar" class="accordion-collapse collapse <?php if(isset($json_data) && $json_data["calendar"]["enable"]) { echo 'show'; } ?>"> <!-- Add: data-bs-parent="#faqlist" for collaps when click on other-->
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




