<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Ajax Image Upload With Preview - Tutsmake.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>

<form method="POST" action="" enctype="multipart/form-data" id="schoolform">

    <div class="form-group">
        <label class="col-md-3 control-label">Name:</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="name" placeholder="Enter Your Name" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Image:</label>
        <div class="col-md-6">
            <input type="file" class="form-control" id="image" name="image" placeholder="Enter Your Image" />
        </div>
        <div class="col-md-12 mb-2">
            <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                 alt="preview image" style="max-height: 250px;">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12" style="text-align: center">
            <button type="submit" class="btn btn-sm btn-success">Submit</button>
        </div>
    </div>

</form>

<script>
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#image').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-before-upload').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });
        $('#schoolform').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: "{{ url('upload')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    $('#preview-image-before-upload').reset();
                    alert('Image has been uploaded using jQuery ajax successfully');
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    });
</script>
</body>
</html>


