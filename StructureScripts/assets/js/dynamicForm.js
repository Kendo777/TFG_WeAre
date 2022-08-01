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
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';

            $('#blognewRow').append(html);
            blog_num++;
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
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';

            $('#nabBarnewRow').append(html);
        };

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });