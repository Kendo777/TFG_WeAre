        var blog_num = 1;
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
        function addForumCategorieRow()
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

            $('#categorienewRow').append(html);
        };
        function addNavBarRow ()
        {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<div class="col-sm-2">';
            html += '<select class="form-control" id="navBar_tab_type" name="navBar_tab_type">';
            html += '<option>Blog</option>';
            html += '<option>Gallery</option>';
            html += '</select>';
            html += '</div>';
            html += '<div class="col-sm-2">';
            html += '<input type="number" name="navBar_tab_target[]" class="form-control m-input" placeholder="Tab target">';
            html += '</div>';
            html += '<input type="text" name="navBar_tab[]" class="form-control m-input" placeholder="Tab name" autocomplete="off"></input>';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>';
            html += '</div>';
            html += '</div>';

            $('#nabBarnewRow').append(html);
        };

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });