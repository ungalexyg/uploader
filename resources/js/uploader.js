
var Uploader = {
    init : function(){
        this.bindUploadBtn();
        this.setDropzone();
    },

    bindUploadBtn : function(){
        $("#upload-btn").click(function(){
            $("#my-dropzone").click();    
        });
    },    

    setDropzone : function() {
        Dropzone.options.myDropzone = { // camelized version of the `id`
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else { 
                    done();
                }
            }
        };                    
    }       
};


$(function(){
    Uploader.init();
});