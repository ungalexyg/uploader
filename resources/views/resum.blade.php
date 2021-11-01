<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Search Users</title>

        {{-- fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        
        
        {{-- styles --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="/css/app.css" rel="stylesheet" type="text/css">
        <link href="/css/custom.css" rel="stylesheet" type="text/css">
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
                              This is a demo app that illustrate how the file uploader works with Kaltura's service. 
                              <br /><br /> 
                              It is based on Laravel which load this frontend and handles the business logic using a dedicted API, 
                              which interacts with Kaltura's SDK.
                              <br /> 
                              located in <code>POST /api/upload</code>
                              <br />
                              The frontend below uses JQuery to interact with the API 
                          </p>    
                        </div>
                      </div>                    
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <div class="bg-light p-5 rounded mt-3 ">
                        <h1>Upload File</h1>
                        <p class="lead">
                            Select file from your computer by clikcing on the the button or dragging files to the space below
                        </p>
                        {{-- <a id="uploadBtn" class="btn btn-lg btn-primary" href="#" role="button">Upload file &raquo;</a> --}}
                        <button id="browseBtn" class="btn btn-lg btn-primary">Brows Files</button>
                    </div>

                    <div class="well shadow p-5 rounded mt-3 ">
                        <p id="statusHint">Pending upload...</p>
                        <div 
                            id="progressBar"
                            class="progress-bar progress-bar-striped progress-bar-animated" 
                            role="progressbar" 
                            aria-valuenow="0" 
                            aria-valuemin="0" 
                            aria-valuemax="100" 
                            style="width: 5%; height: 100%">
                            0%
                        </div>
                    </div>  
                </div>
            </div>                      
        </main>
        {{-- /main ----------------------------------------- --}}        


        {{-- scripts --}}                
        <script src="https://code.jquery.com/jquery-3.6.0.js" type="text/javascript"></script>
        {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" type="text/javascript"></script>                          --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

        <script>
            var token = "{!! csrf_token() !!}"; // CSRF token
            var Uploader = {

                $progress: null,
                $status: null,

                init : function(){
                    this.$progress = $('#progressBar');
                    this.$status = $('#statusHint');
                    this.resumableSetup();
                    this.hideProgress();
                    console.log(token);
                },
                
                showProgress: function () {
                    this.$progress.find('.progress-bar').css('width', '0%');
                    this.$progress.find('.progress-bar').html('0%');
                    this.$progress.find('.progress-bar').removeClass('bg-success');
                    this.$progress.show();
                    this.$status.html("Upload progress...");
                },

                updateProgress: function(value) {
                    this.$progress.find('.progress-bar').css('width', `${value}%`)
                    this.$progress.find('.progress-bar').html(`${value}%`)
                },

                hideProgress: function() {
                    this.$progress.hide();
                }, 


                resumableSetup : function() {
                    let browseFile = $('#browseBtn');
                    let resumable = new Resumable({
                        target: '/api/upload',
                        method:"POST",
                        query:{_token: token} ,
                        fileType: ['mp4', 'mov'],
                        headers: {
                            'Accept' : 'application/json'
                        },
                        testChunks: false,
                        throttleProgressCallbacks: 1,
                    });
                    
                    resumable.assignBrowse(browseFile[0]);

                    resumable.on('fileAdded', function (file) { // trigger when file picked
                        Uploader.showProgress();
                        resumable.upload() // to actually start uploading.
                    });

                    resumable.on('fileProgress', function (file) { // trigger when file progress update
                        Uploader.updateProgress(Math.floor(file.progress() * 100));
                    });

                    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
                        response = JSON.parse(response)
                        $('#videoPreview').attr('src', response.path);
                        $('.card-footer').show();
                    });

                    resumable.on('fileError', function (file, response) { // trigger when there is any error
                        alert('file uploading error.')
                    });
                }                   
            };

         
            $(function(){
                Uploader.init();             
            });        
        </script>
    </body>
</html>

