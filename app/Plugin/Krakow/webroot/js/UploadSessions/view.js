
$(document).ready(function() {

    var uploader = $('#fine-uploader');
    var id = $('div[data-name="id"]').attr('data-value');
    var config = JSON.parse(
        $('div[data-name="config"]')
            .attr('data-json')
    );

    uploader.fineUploaderS3({
        debug: true,
        request: {
            // REQUIRED: We are using a custom domain
            // for our S3 bucket, in this case.  You can
            // use any valid URL that points to your bucket.
            endpoint: config.endpoint,

            // REQUIRED: The AWS public key for the client-side user
            // we provisioned.
            accessKey: config.key
        },

        // REQUIRED: Path to our local server where requests
        // can be signed.
        signature: {
            endpoint: "/amazon/signRequest"
        },

        // OPTIONAL: An endopint for Fine Uploader to POST to
        // after the file has been successfully uploaded.
        // Server-side, we can declare this upload a failure
        // if something is wrong with the file.
        uploadSuccess: {
            endpoint: "/krakow/upload_sessions/uploadSuccess/" + id
        },

        allComplete: function() {

        },

        submit: function() {
            alert('submit');
        },

        // USUALLY REQUIRED: Blank file on the same domain
        // as this page, for IE9 and older support.
        iframeSupport: {
            localBlankPagePath: "/server/success.html"
        },

        // optional feature
        chunking: {
            enabled: true
        },

        // optional feature
        resume: {
            enabled: true
        },
        retry: {
            enableAuto: true // defaults to false
        },
        /*thumbnails: {
            placeholders: {
                notAvailablePath: "assets/not_available-generic.png",
                waitingPath: "assets/waiting-generic.png"
            }
        },*/
        maxChunkSize: 100000000,
        partSize: 50000000
    })
        // Enable the "view" link in the UI that allows the file to be downloaded/viewed
        .on('complete', function(event, id, name, response) {
            // alert('complete');
        })
        .on('allComplete', function(event, id, name, response) {
            $('#finish-session-submit').attr('disabled', false);

            if( $('#autoclose_checkbox').prop('checked') ) {
                $('#form-upload').submit();
            }

        })
        .on('submit', function(event, id, name, response) {
            $('#finish-session-submit').attr('disabled', 'disabled');
        });

});