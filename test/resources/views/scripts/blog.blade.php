<script type="text/javascript">
    $(document).ready(function() {
        $('#add_category_blog').click(function(){
            var categoryInputBlog = $('#categoryInputBlog').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/add-to-category-blog-by-input') }}',
                method: 'POST',
                data: {
                    categoryInputBlog:categoryInputBlog,
                    _token:_token
                },
                success: function(data){
                    notyf.success(data);
                    fetch_category();
                }
            });
        });
    })
    fetch_category();
    function fetch_category(){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '{{ url('/show-list-category-blog') }}',
            method: 'POST',
            data: {
                _token:_token
            },
            success: function(data){
                $('#category_select_blog').html(data);
            }
        });

    }

    $(document).ready(function() {
        $('#add_tag_blog').click(function(){
            var tagInput = $('#tagInput').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/add-to-tag-blog-by-input') }}',
                method: 'POST',
                data: {
                    tagInput:tagInput,
                    _token:_token
                },
                success: function(data){
                    notyf.success(data);
                    fetch_tag();
                }
            });
        });
    });

    fetch_tag();
    function fetch_tag(){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '{{ url('/show-list-tag-blog') }}',
            method: 'POST',
            data: {
                _token:_token
            },
            success: function(data){
                $('#tag_select_blog').html(data);
            }
        });

    }

    $(document).ready(function() {
        $('#add-select-tag').click(function(){
            var id = $('#tag_select_blog').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/add-tag') }}',
                method: 'POST',
                data: {
                _token:_token,
                id
                },
                success: function(data){
                $('#tag-list').append(data);
            }
            });
        });
    });

    $(document).ready(function() {
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '{{ url('/show-tag-blog') }}',
            method: 'POST',
            data: {
                _token:_token
            },
            success: function(data){
                $('#tag-list').html(data);
            }
        });

    });

    $(document).ready(function() {
        $('#list-of-tags').on('click','.delete-tag-input', function(){
            var _token = $('input[name="_token"]').val();
            var id = $(this).data('id_tag_delete');
            $.ajax({
                url: '{{ url('/delete-tag-blog') }}',
                method: 'POST',
                data: {
                    _token:_token,
                    id:id
                },
                success: function(data){

                }
            });
        });
    });

</script>


