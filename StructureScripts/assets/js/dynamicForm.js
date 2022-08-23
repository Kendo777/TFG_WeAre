        var tab_id = 1;
        // add row
        function addBlogRow ()
        {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<button name="blog_id[]" class="btn btn-info disabled">${blog_num}</button>';
            html += '<input type="text" name="blog_title[]" class="form-control m-input" placeholder="Blog title" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>';
            html += '</div>';
            html += '</div>';

            $('#blognewRow').append(html);
            blog_num++;
        };
        function addUserRow ()
        {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<select class="btn btn-outline-info" id="add_event_color" name="column_type[]">';
            html += '<option value="VARCHAR(60)">Text</option>';
            html += '<option value="INT(4)">Number</option>';
            html += '<option value="DATE">Date</option>';
            html += '<option value="VARCHAR(2000)">Paragraph</option>';
            html += '</select>';
            html += '<input type="text" name="column_name[]" class="form-control m-input" placeholder="User Attribute">';
            html += '<div class="input-group-append mx-3">';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>';
            html += '</div>';
            html += '</div>';

            $('#usernewRow').append(html);
            blog_num++;
        };
        function addForumCategorieRow(id)
        {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<button class="btn btn-info disabled">#</button>';
            html += '<input type="text" name="categorie_title[]" class="form-control m-input" placeholder="Categorie name" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>';
            html += '</div>';
            html += '</div>';

            $('#categorienewRow_' + id).append(html);
        };
        function add_tab_row()
        {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<select class="btn btn-outline-info" name="tab_type[]" onchange="tab_type_form(this, ' + tab_id +')">';
            html += '<option>Blank Page</option>';
            html += '<option>Gallery</option>';
            html += '<option>Blog</option>';
            html += '<option>Forum</option>';
            html += '<option>Calendar</option>';
            html += '<option>Dropdown</option>';
            html += '</select>';
            html += '<input type="text" name="tab_name[]" class="form-control m-input" placeholder="Tab Name">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>';
            html += '</div>';
            html += '</div>';
            html += '<div id="tab_form_' + tab_id + '"></div>';
            html += '<hr></div>';
            tab_id++;
            $('#tab_new_row').append(html);
        }
        function add_tab_dropdown_row(id)
        {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<select class="btn btn-outline-info" name="tab_dropdown_' + id + '_type[]" onchange="tab_type_form(this, ' + tab_id +')">';
            html += '<option>Blank Page</option>';
            html += '<option>Gallery</option>';
            html += '<option>Blog</option>';
            html += '<option>Forum</option>';
            html += '<option>Calendar</option>';
            html += '<option>Dropdown Tab</option>';
            html += '</select>';
            html += '<input type="text" name="tab_dropdown_' + id + '_name[]" class="form-control m-input" placeholder="Tab Name">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>';
            html += '</div>';
            html += '</div>';
            html += '<div id="tab_form_' + tab_id + '"></div>';
            html += '<hr></div>';
            tab_id++;
            $('#tab_new_row_' + id).append(html);
        }

        function tab_type_form(type, id)
        {
            switch (type.value)
            {
                case "Gallery":
                    gallery_form(id);
                    break;
                case "Blog":
                    blog_form(id);
                    break;
                case "Forum":
                    forum_form(id);
                    break;
                case "Calendar":
                    calendar_form(id);
                    break;
                case "Dropdown Tab":
                    dropdown_form(id);
                    break;
                default:
                  document.getElementById("tab_form_" + id).innerHTML = "";
                  break;
            }
        }
        function blog_form(id)
        {
            var html = '';
            html += '<div class="shadow-sm rounded">';
            html += '<h3 class="accordion-header">';
            html += '<button class="accordion-button collapsed float-left" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_tab_' + tab_id + '">';
            html += '<i class="bi bi-newspaper question-icon"></i>';
            html += tab_id + ' Blog';
            html += '</button>';
            html += '</h3>';
            html += '<div id="collapse_tab_' + tab_id + '" class="accordion-collapse collapse show p-3">';
            html += '<div class="form-group my-3">';
            html += '<input type="text" class="form-control" name="blog_title[]" placeholder="Blog title" required>';
            html += '<hr>';
            html += '<textarea class="form-control" name="blog_description[]" rows="5" placeholder="Write the description" required></textarea>';
            html += '</div></div></div>';
            blog_id++;
            document.getElementById("tab_form_" + id).innerHTML = html;
        }
        function gallery_form(id)
        {
            var html = '';
            html += '<div class="shadow-sm rounded">';
            html += '<h3 class="accordion-header">';
            html += '<button class="accordion-button collapsed float-left" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_tab_' + tab_id + '">';
            html += '<i class="bi bi-images question-icon"></i>';
            html += tab_id + ' Gallery';
            html += '</button>';
            html += '</h3>';
            html += '<div id="collapse_tab_' + tab_id + '" class="accordion-collapse collapse show p-3">';
            html += '<div class="form-group my-3">';
            html += '<input type="text" class="form-control" name="gallery_title[]" placeholder="Gallery title" required>';
            html += '<hr>';
            html += '<textarea class="form-control" name="gallery_description[]" rows="5" placeholder="Write the description" required></textarea>';
            html += '</div></div></div>';
            gallery_id++;
            document.getElementById("tab_form_" + id).innerHTML = html;
        }
        function calendar_form(id)
        {
            var html = '';
            html += '<div class="shadow-sm rounded">';
            html += '<h3 class="accordion-header">';
            html += '<button class="accordion-button collapsed float-left" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_tab_' + tab_id + '">';
            html += '<i class="bi bi-calendar-week question-icon"></i>';
            html += tab_id + 'Calendar';
            html += '</button>';
            html += '</h3>';
            html += '<div id="collapse_tab_' + tab_id + '" class="accordion-collapse collapse show p-3">';
            html += '<div class="form-group my-3">';
            html += '<input type="text" class="form-control" name="calendar_title[]" placeholder="Calendar title" required>';
            html += '<hr>';
            html += '<textarea class="form-control" name="calendar_description[]" rows="5" placeholder="Write the description" required></textarea>';
            html += '</div></div></div>';
            calendar_id++;
            document.getElementById("tab_form_" + id).innerHTML = html;
        }
        function forum_form(id)
        {
            var html = '';
            html += '<div class="shadow-sm rounded">';
            html += '<h3 class="accordion-header">';
            html += '<button class="accordion-button collapsed float-left" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_tab_' + tab_id + '">';
            html += '<i class="bi bi-bar-chart-steps question-icon"></i>';
            html += tab_id + 'Forum';
            html += '</button>';
            html += '</h3>';
            html += '<div id="collapse_tab_' + tab_id + '" class="accordion-collapse collapse show p-3">';
            html += '<div class="form-group my-3">';
            html += '<input type="text" class="form-control" name="forum_title[]" placeholder="Forum title" required>';
            html += '<hr>';
            html += '<textarea class="form-control" name="post_content[]" rows="5" placeholder="Write the post" required></textarea>';
            html += '<hr>';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<button class="btn btn-info disabled">#</button>';
            html += '<input type="text" name="categorie_title[]" class="form-control m-input" placeholder="Categorie name" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div id="categorienewRow_' + id + '"></div>';
            html += '<button onclick="addForumCategorieRow(' + id + ')" type="button" class="btn btn-info">Add Row</button>';
            html += '</div></div></div>';
            forum_id++;
            document.getElementById("tab_form_" + id).innerHTML = html;
        }
        function dropdown_form(id)
        {
            var html = '';
            html += '<div class="shadow-sm rounded">';
            html += '<input type="hidden" name="dropdown_id" value="' + id + '">';
            html += '<h3 class="accordion-header">';
            html += '<button class="accordion-button collapsed float-left" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_tab_' + tab_id + '">';
            html += '<i class="bi bi-menu-button-wide-fill"></i>';
            html += tab_id + ' Dropdown';
            html += '</button>';
            html += '</h3>';
            html += '<div id="collapse_tab_' + tab_id + '" class="accordion-collapse collapse show p-3">';
            html += '<div class="form-group my-3">';
            html += '<div id="tab_new_row_' + id + '"></div>';
            html += '<button onclick="add_tab_dropdown_row(' + id + ')" type="button" class="btn btn-info">Add New Dropdown Tab</button>'
            html += '</div></div></div>';
            dropdown_id++;
            document.getElementById("tab_form_" + id).innerHTML = html;
        }

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });
        