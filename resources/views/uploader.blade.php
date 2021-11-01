<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Search Users</title>

        {{-- fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        {{-- styles --}}
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="/css/custom.css">
    </head>
    <body>

        {{-- navbar ----------------------------------------- --}}
        <nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img id="img-logo" src="https://avatars.githubusercontent.com/u/319096?s=200&v=4">
                Uploader
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Upload</a>
                </li>           
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Terms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Privacy</a>
                </li>              
                </ul>
            </div>
            </div>
        </nav>
        {{-- /navbar ----------------------------------------- --}}
        
        {{-- main ----------------------------------------- --}}
        <main class="container main-container">

            <div class="row">
                <div class="col">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                          <h1 class="display-4">File Uploader</h1>
                          <p class="lead">
                              This is a demo app that illustrate file upload process with integration to Kaltura. 
                              <br />
                              It is based on Laravel which load this frontend and handles the business logic in the backend using a dedicated API.  
                              <br />                               
                          </p>    
                        <p>Process details: </p>    
                          <ul>
                            <li>
                              The API accssible via <code>POST /api/upload</code>
                            </li>
                            <li>
                              The API handles business logic in <code>app/Http/Controllers/API/UploadController.php</code>
                            </li>
                            <li>
                              The actual integration to Kaltura happens using custom service provider in <code>app/Services/Kaltura/Kaltura.php</code>
                            </li>
                            <li>
                              The service provider wrap the Kaltura's client, based PHP SDK (namespaced)
                            </li>                                  
                            <li>
                              The frontend uses JQuery & <a target="_blank" href="https://www.dropzone.dev/">Dropzone</a> 
                              to create the upload inputs & interact with the backend API. 
                            </li>                                  
                        </ul>                          
                        </div>
                      </div>                    
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <div class="bg-light p-5 rounded mt-3 ">
                        <h1>Upload File</h1>
                        <p class="lead">
                            Select file from your computer by clicking on the browse button or by simply dragging files to the space below.
                        </p>
                        <p>
                            Supported files: .mov, .mp4, .flv
                        </p>
                        <a id="browse-btn" class="btn btn-lg btn-outline-secondary " href="#" role="button">Broswe Files</a>
                        &nbsp;
                        <a id="submit-btn" class="btn btn-lg btn-primary" href="#" role="button">Submit Upload &raquo;</a>
                    </div>

                    <br />
                    <div id="status-alert" class="hide alert alert-success" role="alert">
                        <p class="lead">The file uploaded successfully</p>
                        <p>Check the response in the console</p>
                    </div>

                    <div class="well shadow p-5 rounded mt-3 ">
                        <p>Status preview...</p>
                        <form action="/api/upload" method="POST" id="dropzone-form" class="dropzone">
                            <div class="previews"></div>
                        </form>
                    </div>  
                </div>
            </div>                      
        </main>
        {{-- /main ----------------------------------------- --}}        


        {{-- scripts --}}                
        <script src="https://code.jquery.com/jquery-3.6.0.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" type="text/javascript"></script>                         
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js" type="text/javascript"></script>
        <script>
            
            // get csrf token
            var token = "{!! csrf_token() !!}";
            
            // prep Dropzone instance
            Dropzone.options.dropzoneForm = { 
                // config 
                autoProcessQueue: false,
                uploadMultiple: false,
                acceptedFiles: ".mov, .mp4, .flv",
                headers: {
                    'Accept' : 'application/json',
                    'X-CSRF-TOKEN' : token
                },                

                // events
                init: function() {
                    var myDropzone = this;
                    $("#submit-btn").click(function(){
                        myDropzone.processQueue();
                    });
                    this.on("addedfile", function(files, response) {
                        console.log("-- addedfile");
                        console.log("file: ");console.log(files);
                        console.log("response: ");console.log(response);
                    });
                    this.on("success", function(files, response) {
                        console.log("-- success");
                        console.log("file: ");console.log(files);
                        console.log("response: ");console.log(response);
                        $("#status-alert").show();
                    });
                    this.on("complete", function(files, response) {
                        console.log("-- complete");
                        console.log("file: ");console.log(files);
                        console.log("response: ");console.log(response);
                    });                    
                    this.on("error", function(files, response) {
                        console.log("-- error");
                        console.log("file: ");console.log(files);
                        console.log("response: ");console.log(response);
                        if(response.api_message == "API_VALIDATION_FAILED") {
                            alert(response.exception.info.file[0]);
                        }
                    });
                }
            }  

            var Uploader = {
                init : function(){
                    this.bindUploadBtn();
                    $("#status-alert").hide();
                    console.log(token);
                },
                bindUploadBtn : function(){
                    $("#browse-btn").click(function(){
                        $("#dropzone-form").click();    
                    });
                }    
            };
            $(function(){
                Uploader.init();                  
            });        
        </script>
    </body>
</html>

